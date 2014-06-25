<?php

function nz_flush_rewrite_rules() {
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
}

function nz_debug_rewrite_rules() {
        global $wp_rewrite;
        echo '<div style="background-color:#333">';
        if (!empty($wp_rewrite->rules)) {
                echo '<h3>Rewrite Rules</h3>';
                echo '<table><thead><tr>';
                echo '<td>Rule</td><td>Rewrite</td>';
                echo '</tr></thead><tbody>';
                foreach ($wp_rewrite->rules as $name => $value) {
                        echo '<tr><td>' . $name . '</td><td>' . $value . '</td></tr>';
                }
                echo '</tbody></table>';
        } else {
                echo 'No rules defined.';
        }
        echo '</div>';
}

function nz_debug_page_request() {
        global $wp, $template;
        ?>
        <div style="clear: both; background-color: #aaa;">
                <h2> <span style="color: #333"> Request: </span><?php echo empty($wp->request) ? "None" : esc_html($wp->request); ?> </h2>
                <h2> <span style="color: #333"> Matched Rewrite Rule: </span><?php echo empty($wp->matched_rule) ? "None" : esc_html($wp->matched_rule); ?> </h2>
                <h2> <span style="color: #333"> Matched Rewrite Query: </span><?php echo empty($wp->matched_query) ? "None" : esc_html($wp->matched_query); ?> </h2>
                <h2> <span style="color: #333"> Template: </span><?php echo basename($template); ?> </h2>
        </div>
        <?php
       
}
