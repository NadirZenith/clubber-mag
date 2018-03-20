<?php
/**
 * The Class.
 */
class NzWpCmTicketscriptMetaBox
{
    private $post_types;
    private $meta_slug;
    private $box_slug;
    private $channel_id;

    /**
     * Hook into the appropriate actions when the class is constructed.
     */
    public function __construct($post_types)
    {
        $this->meta_slug = 'nzwpcm_ticketscript_event_id';
        $this->box_slug = 'nzwpcm_ticketscript';
        $this->channel_id = 'LSSX45SZ';


        $this->post_types = is_array($post_types) ? $post_types : [$post_types];
        add_action('add_meta_boxes', array($this, 'add_meta_box'));
        add_action('save_post', array($this, 'save'));
    }

    /**
     * Adds the meta box container.
     */
    public function add_meta_box($post_type)
    {
        if (in_array($post_type, $this->post_types)) {
            add_meta_box(
                'nzwpcm_ticketscript_meta_box'
                , __('Some Meta Box Headline', 'myplugin_textdomain')
                , array($this, 'render_meta_box_content')
                , $post_type
                , 'advanced'
                , 'high'
            );
        }
    }

    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save($post_id)
    {

        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if (!isset($_POST[$this->box_slug . '_nonce']))
            return $post_id;

        $nonce = $_POST[$this->box_slug . '_nonce'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, $this->box_slug))
            return $post_id;

        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {

            if (!current_user_can('edit_page', $post_id))
                return $post_id;
        } else {

            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }

        /* OK, its safe for us to save the data now. */

        // Sanitize the user input.
        $mydata = sanitize_text_field($_POST[$this->box_slug]);

        // Update the meta field.
        update_post_meta($post_id, $this->meta_slug, $mydata);
    }

    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content($post)
    {
        // Add an nonce field so we can check for it later.
        wp_nonce_field($this->box_slug, $this->box_slug . '_nonce');

        // Use get_post_meta to retrieve an existing value from the database.
        $value = get_post_meta($post->ID, $this->meta_slug, true);
        ?>
        <label for="<?php echo $this->box_slug . '_listen' ?>">
            <?php
            _e('Insert ticket script event id', 'nzwpcm_ticketscript');
            ?>
            <input 
                type="text" 
                id="<?php echo $this->box_slug . '_listen' ?>" 
                name="<?php echo $this->box_slug . '_listen' ?>" 
                size="85" />
        </label>
        <input 
            type="hidden" 
            id="<?php echo $this->box_slug ?>" 
            name="<?php echo $this->box_slug ?>" 
            value="<?php echo esc_attr($value) ?>" 
            size="25" />
        <a target="_blank" href="https://shop.ticketscript.com/channel/web2/start-order/rid/<?php echo $this->channel_id ?>/language/es">shop</a>

        <div id="ts-iframe-wrapper">

        </div>
        <script type="text/javascript">

            (function ($) {
                var $box_slug_listen = $('#<?php echo $this->box_slug . '_listen' ?>');
                var $box_slug = $('#<?php echo $this->box_slug ?>');

                if ($box_slug.val()) {
                    ShowTicketScript($box_slug.val());
                }

                $box_slug_listen.on('change', function () {
                    console.log();
                    var string = $(this).val();
                    //https://shop.ticketscript.com/channel/web2/get-dates/rid/LSSX45SZ/eid/254478/language/es
                    //https://shop.ticketscript.com/channel/web2/get-dates/rid/LSSX45SZ/eid/252983/language/es
                    console.log(string);
                    var m = string.match(/eid\/(\d+)/g);
                    console.log(m);

                    if (!m[0]) {
                        return;

                    }
                    var eid = m[0].replace('eid/', '');
                    console.log(eid);

                    $box_slug.val(eid);
                    $box_slug.change();

                });
                /*                
                 */
                $box_slug.change(function () {
                    var eid = $(this).val();
                    ShowTicketScript(eid);

                });

                function ShowTicketScript(eid) {

                    $('#ts-iframe-wrapper').html('<div id="ts-shop"></div>');

                    window.Ticketscript = {};
                    Ticketscript.Application = {
                        containerId: "ts-shop",
                        channel: "LSSX45SZ",
                        eventId: eid,
                        type: "iframe",
                        language: "es",
                        width: "500",
                        height: "650"
                    };

                    var script = document.createElement("script");
                    script.type = "text/javascript";
                    script.src = "https://shop.ticketscript.com/assets/js/ga-embed.js";
                    $("head").append(script);
                }

            })(jQuery);



        </script>
        <?php
    }
}
