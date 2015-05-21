<?php
$begin_timestamp = get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true);


$end_timestamp = get_post_meta(get_the_ID(), 'wpcf-event_end_date', true);



if ($begin_timestamp) {
    $begin_date = new DateTime();
    $begin_date->setTimestamp($begin_timestamp);
    ?>
    <time class="p-detail" datetime="<?php echo $begin_date->format('l d/m/y H:i'); ?>">
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
<hr class="mt5">
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


<div class="event-meta" >
    <div class="group mt3 mb3">
        <div class="col-1-2 fl">
            <?php _e('City', 'cm') ?>:
            <b>
                <?php
                echo nz_get_post_city_link(get_the_ID());
                ?>
            </b>
        </div>
        <div class="col-1-2 fl">
            <?php _e('Promoter', 'cm') ?>:
            <b>
                <?php $event_promoter = get_post_meta(get_the_ID(), 'wpcf-event_promoter', true); ?>
                <?php echo ($event_promoter) ? $event_promoter : '-'; ?>
            </b>
        </div>

    </div>

    <div class="group mt3 mb3">

        <div class="col-1-2 fl">
            <?php _e('Place', 'cm') ?>:
            <b>
                <?php if (!is_null($event_place_name)) { ?>
                    <?php echo $event_place_name ?>
                <?php } ?>
            </b>
        </div>
        <div class="col-1-2 fl">
            <?php _e('Price', 'cm') ?>:
            <b>
                <?php $event_price = get_post_meta(get_the_ID(), 'wpcf-event_price', true) ?>
                <?php if (!is_null($event_price)) { ?>
                    <?php echo $event_price ?>
                <?php } ?>
            </b>
        </div>
    </div>
    <?php $event_price_conditions = get_post_meta(get_the_ID(), 'wpcf-event_price_conditions', true); ?>
    <?php if ($event_price_conditions) { ?>
        <div class="col-1 mt3 mb3">
            <?php _e('Price Conditions', 'cm') ?>
            <b>
                <?php echo $event_price_conditions; ?>
            </b>
        </div>
    <?php } ?>

    <div class="col-1 mt3 group">
        <?php _e('Address', 'cm') ?>:
        <b>
            <?php if (!is_null($event_address)) { ?>
                <?php echo $event_address ?>
            <?php } ?>
        </b>
        <?php get_template_part('tpl/parts/mapa'); ?>
        <?php //get_template_part( 'tpl/parts/mapa', 'image' );   ?>
    </div>

</div>
<?php
$eid = get_post_meta(get_the_ID(), 'nzwpcm_ticketscript_event_id', true);
if ($eid) {
    ?>
<div id="cm-tickets" style="z-index: 100000; position: relative;">
        <?php
        if (wp_is_mobile()) {
            NzWpCmTicketscript::mobile_iframe($eid);
        } else {
            ?>
            <button id="open-tickets" class="pure-button col-1 meddium  ">
                <?php
                _e('Tickets', 'cm');
                ?>
            </button>

            <div class="col-1 oh2 ts-iframe-wrapper " style="z-index: 10000000;display: none; margin-left: -30px; padding-right: 30px" >
                <?php
                NzWpCmTicketscript::get_ticket_script($eid);
                ?>
            </div>
            <script>

                $('#open-tickets').on('click', function () {
                    var $wrapper = $('.ts-iframe-wrapper');

                    if (($wrapper).is(':visible')) {
                        $wrapper.slideUp();

                    } else {

                        $wrapper.slideDown();
                    }

                });
            </script>
            <?php
        }
        ?>
    </div>
    <?php
}
?>
<hr>