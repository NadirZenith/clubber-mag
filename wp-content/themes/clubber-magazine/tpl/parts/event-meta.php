<div class="event-meta" >

    <?php
    $begin_timestamp = get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true);
    $end_timestamp = get_post_meta(get_the_ID(), 'wpcf-event_end_date', true);

    if ($begin_timestamp) {
        $begin_date = new DateTime();
        $begin_date->setTimestamp($begin_timestamp);
        ?>
        <time class="hover top right h2 reset" datetime="<?php echo $begin_date->format(DATE_W3C); ?>">
            <a href="<?php echo add_query_arg(array('date' => urlencode($begin_date->format('d-m-Y'))), get_post_type_archive_link('agenda')) ?>">
                <?php
                echo __($begin_date->format('l'), 'cm');
                echo $begin_date->format(' d/m/y');
                ?>
            </a>
            <?php echo ' - ' . $begin_date->format('H:i'); ?>

            <?php
            if ($end_timestamp) {
                echo ' / ';
                $end_date = new DateTime();
                $end_date->setTimestamp($end_timestamp);

                $duration = $begin_date->diff($end_date);

                if ($duration->days < 1) {
                    echo $end_date->format('H:i');
                } else {
                    ?>
                    <a href="<?php echo add_query_arg(array('date' => urlencode($end_date->format('d-m-Y'))), get_post_type_archive_link('agenda')) ?>">

                        <?php
                        echo __($end_date->format('l'), 'cm');
                        echo $end_date->format(' d/m/y');
                        ?>
                    </a>

                    <?php
                    echo ' - ' . $end_date->format('H:i');
                }
            }
            ?>
        </time>
        <?php
    }
    ?>
    <hr class="pb5">
    <?php
    $event_place_id = get_post_meta(get_the_ID(), 'relation-to-coolplace', true);

    if ($event_place_id) {
        $place = get_post($event_place_id);
        $event_place_name = '<a href="' . get_permalink($place) . '">' . $place->post_title . '</a>';

        $mapaddress = get_post_meta($place->ID, CM_META_MAPA, true);
        $mapaddress = json_decode($mapaddress, true);
        /* d( $mapaddress ); */
        if (isset($mapaddress, $mapaddress['components'], $mapaddress['components']['formatted_address'])) {
            /* d( 'new address' ); */
            $event_address = $mapaddress['components']['formatted_address'];
        }
        /*
         */
    } else {

        $event_place_name = get_post_meta(get_the_ID(), 'wpcf-event_place_name', true);
        $event_address = get_post_meta(get_the_ID(), 'wpcf-event_place_address', true);
    }
    ?>
    <style>
        .event-meta .pure-u-1,
        .event-meta .pure-u-1-2
        {
            padding: 3px 0;
        }
    </style>
    <div class="pure-g">
        <div class="pure-u-1-2 pt3">
            <?php _e('City', 'cm') ?>:
            <b>
                <?php
                echo nz_get_post_city_link(get_the_ID());
                ?>
            </b>
        </div>
        <div class="pure-u-1-2 pt3">
            <?php _e('Promoter', 'cm') ?>:
            <b>
                <?php $event_promoter = get_post_meta(get_the_ID(), 'wpcf-event_promoter', true); ?>
                <?php echo ($event_promoter) ? $event_promoter : '-'; ?>
            </b>
        </div>

        <div class="pure-u-1-2 pt3">
            <?php _e('Place', 'cm') ?>:
            <b>
                <?php if (!is_null($event_place_name)) { ?>
                    <?php echo $event_place_name ?>
                <?php } ?>
            </b>
        </div>
        <div class="pure-u-1-2 pt3">
            <?php _e('Price', 'cm') ?>:
            <b>
                <?php $event_price = get_post_meta(get_the_ID(), 'wpcf-event_price', true) ?>
                <?php if (!is_null($event_price)) { ?>
                    <?php echo $event_price ?>
                <?php } ?>
            </b>
        </div>
        <?php $event_price_conditions = get_post_meta(get_the_ID(), 'wpcf-event_price_conditions', true); ?>
        <?php if ($event_price_conditions) { ?>
            <div class="pure-u-1 pt3">
                <?php _e('Price Conditions', 'cm') ?>
                <b>
                    <?php echo $event_price_conditions; ?>
                </b>
            </div>
        <?php } ?>

        <div class="pure-u-1 pt3">
            <?php _e('Address', 'cm') ?>:
            <b>
                <?php if (!is_null($event_address)) { ?>
                    <?php echo $event_address ?>
                <?php } ?>
            </b>
            <?php cm_render_google_map(get_post_meta(get_the_ID(), 'relation-to-coolplace', true))?>
            <?php //get_template_part('tpl/parts/mapa'); ?>
        </div>
    </div>

</div>
<?php
$eid = get_post_meta(get_the_ID(), 'nzwpcm_ticketscript_event_id', true);
if ($eid && class_exists('NzWpCmTicketscript')) {
    ?>
    <div id="cm-tickets" style="z-index: 100000; position: relative;">
        <?php
        if (wp_is_mobile()) {
            NzWpCmTicketscript::mobile_iframe($eid);
        } else {
            ?>
            <button id="open-tickets" class="buy-tickets pure-button col-1 meddium">
                <?php
                _e('Get your tickets!', 'cm');
                ?>
            </button>

            <div class="col-1 ts-iframe-wrapper" style="z-index: 10000000; margin-left: -40px;display: none" >
                <?php
                if (wp_is_mobile()) {
                    NzWpCmTicketscript::get_mobile_iframe('LSSX45SZ', $eid);
                } else {
                    NzWpCmTicketscript::get_web_iframe('LSSX45SZ', $eid);
                }
                ?>
            </div>
            <script>

                (function ($) {

                    var $wrapper = $('.ts-iframe-wrapper');
                    $('#open-tickets').on('click', function () {

                        if (($wrapper).is(':visible')) {
                            $wrapper.slideUp();

                        } else {

                            $wrapper.slideDown();
                        }

                    });

                    if (window.location.hash === '#open-tickets') {

                        $wrapper.slideDown();
                    }

                })(jQuery);
            </script>
            <?php
        }
        ?>
    </div>
    <?php
}
?>