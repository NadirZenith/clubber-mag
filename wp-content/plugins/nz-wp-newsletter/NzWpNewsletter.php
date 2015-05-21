<?php
/**
 * Description of nzwpnewsletter
 *
 * @author tino
 */
class NzWpNewsletter
{
    const VERSION = 0.5;

    private $options;

    function __construct()
    {
        $this->options = wp_parse_args([], [
            'template_path' => __DIR__ . '/tpl/nz-wp-newsletter-form.php'
        ]);

        add_shortcode('nzwpnewsletter', array($this, 'shortcode'));
        add_action('wp_ajax_nopriv_nzwpnewsletter', array($this, 'ajax_action'));
        add_action('wp_ajax_nzwpnewsletter', array($this, 'ajax_action'));

        wp_register_script('nzwpnewsletter', plugin_dir_url(__FILE__) . 'public/js/main.js', array('jquery'), self::VERSION, true);
        wp_enqueue_script('nzwpnewsletter');

        add_action('admin_menu', array($this, 'add_menu'));
    }

    public function add_menu()
    {
        add_options_page('Nz Wp Newsletter', 'Nz Wp Newsletter', 'manage_options', 'nz-wp-newsletter', array($this, 'options_page'));
    }

    public function options_page()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'nzwpnewsletter';
        $newsletter_emails = $wpdb->get_results(
            "
	SELECT *
	FROM $table_name
	"
        );
        ?>
        <table>
            <thead>
                <tr>
                    <td>email</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($newsletter_emails as $newsletter_email) {
                    ?>
                    <tr>
                        <td>
                            <?php
                            echo $newsletter_email->email;
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    }

    function setFormTemplate($path)
    {
        $this->options['template_path'] = $path;
    }

    function ajax_action()
    {

        check_ajax_referer('nzwpnewsletter', 'security');

        $email = $_REQUEST['email'];
        $user_id = get_current_user_id();

        global $wpdb;
        $wpdb->suppress_errors = TRUE;

        $table_name = $wpdb->prefix . 'nzwpnewsletter';

        $success = $wpdb->insert($table_name, array(
            'time' => current_time('mysql'),
            'user_id' => $user_id,
            'email' => $email,
            )
        );

        $msg = $success ? __('Thank you for submitting your email', 'nz-wp-newsletter') :
            __('Your email is already in our newsletter', 'nz-wp-newsletter');

        echo wp_json_encode(['msg' => $msg]);
        wp_die();
    }

    public function init_script()
    {
        /* invalid_email_msg: '<?php echo $this->options['invalid_email_msg'] ?>', */
        ?>
        <script>
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            jQuery(document).ready(function ($) {
                jQuery('.nzwpnewsletter').NzWpNewsletter({
                    invalid_email_msg: '<?php echo __('Email is not valid', 'nz-wp-newsletter') ?>',
                    security: '<?php echo wp_create_nonce('nzwpnewsletter') ?>'
                });
            });
        </script>
        <?php
    }

    function shortcode()
    {

        include $this->options['template_path'];

        add_action('wp_footer', array($this, 'init_script'));
    }
}

$nzwpnewsletter = new nzwpnewsletter();
