<?php
/**
 * Template Name: TicketScript Template
 *
 * Displays the index TicketScript template.
 *
 */
?>

<div class="col-1d col-sm-1-2" style="display: block; width: 600px;margin-left: auto;margin-right: auto">
    <div class="ibox-5">
        <div class="box-5">
            <?php
            if (wp_is_mobile()) {
                NzWpCmTicketscript::get_mobile_iframe('LSSX45SZ');
            } else {
                NzWpCmTicketscript::get_web_iframe('LSSX45SZ');
            }
            ?>

        </div>
    </div>
</div>