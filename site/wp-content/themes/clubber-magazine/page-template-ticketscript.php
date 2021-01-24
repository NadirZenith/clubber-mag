<?php
/**
 * Template Name: TicketScript Template
 *
 * Displays the index TicketScript template.
 *
 */
?>

<div style="display: block; width: 600px;margin-left: auto;margin-right: auto;margin-top: 15px;margin-bottom: 15px;">
    <?php
    if (class_exists('NzWpCmTicketscript')) {
        if (wp_is_mobile()) {
            NzWpCmTicketscript::get_mobile_iframe('LSSX45SZ');
        } else {
            NzWpCmTicketscript::get_web_iframe('LSSX45SZ');
        }
    } else {
        if (current_user_can('manage_options')) {
            echo '<h1>- activate ticketscript plugin -</h1>';
        }
    }
    ?>
</div>