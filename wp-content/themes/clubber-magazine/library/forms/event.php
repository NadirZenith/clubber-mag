<?php

/** change gform event date to unix timestamp */
add_filter("gform_post_data", "event_change_date_format", 10, 3);

function event_change_date_format($post_data, $form, $entry) {
        /* d($post_data); */
        if ($form["id"] != 1) {
                return $post_data;
        }
        $user_input_date = $post_data['post_custom_fields']['wpcf-event_begin_date'];
        $user_input_DATETIME = date_create_from_format('d/m/Y H:i', $user_input_date);
        if ($user_input_DATETIME) {
                $post_data['post_custom_fields']['wpcf-event_begin_date'] = $user_input_DATETIME->getTimestamp();
        }

        if (!empty($post_data['post_custom_fields']['wpcf-event_end_date'])) {
                $user_input_end_date = $post_data['post_custom_fields']['wpcf-event_end_date'];
                $user_input_end_DATETIME = date_create_from_format('d/m/Y H:i', $user_input_end_date);
                if ($user_input_end_DATETIME) {
                        $post_data['post_custom_fields']['wpcf-event_end_date'] = $user_input_end_DATETIME->getTimestamp();
                }
        }
        /* d($post_data); */

        return $post_data;
}
