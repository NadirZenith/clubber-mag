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
        define("D4P_EOL", "rn");

        echo '<div style="background-color:red">';
        echo '<h2> request: ';
        echo empty($wp->request) ? "None" : esc_html($wp->request);
        echo '</h2>';
        echo '<h2> Matched Rewrite Rule: ';
        echo empty($wp->matched_rule) ? "None" : esc_html($wp->matched_rule);
        echo '</h2>';
        echo '<h2> Matched Rewrite Query: ';
        echo empty($wp->matched_query) ? "None" : esc_html($wp->matched_query);
        echo '</h2>';
        echo '<h2> template: ';
        echo basename($template);
        echo '</h2>';
        echo '</div>' . D4P_EOL;
}
