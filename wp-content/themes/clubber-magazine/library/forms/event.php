<?php

global $nz;

$nz['form.event'] = array(
      'id' => 7,
      'ajax' => 'true'
);

$nz['event_form'] = function($nz) {
        $form = $nz['form.event'];

        $shortcode = sprintf($nz['shortcode.gform'], $form['id'], $form['ajax']);
        /* return $shortcode; */
        return do_shortcode($shortcode);
};


/** change gform event date to unix timestamp */
add_filter("gform_post_data", "event_change_date_format", 10, 3);

function event_change_date_format($post_data, $form, $entry) {
        global $nz;

        if ($form["id"] != $nz['form.event']['id']) {
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

        return $post_data;
}

add_filter("gform_pre_render_" . $nz['form.event']['id'], "remove_protected_fields");

function remove_protected_fields($form) {

        $publish_checkbox_id = 21;
        $featured_checkbox_id = 23;


        $current_user = wp_get_current_user();
        if (!($current_user instanceof WP_User))
                return;

        $roles = $current_user->roles;  //$roles is an array
        if (
                in_array('administrator', $roles) ||
                in_array('author', $roles)
        ) {
                return $form;
        } else {
                foreach ($form['fields'] as &$field) {
                        if (
                                $field['id'] == $publish_checkbox_id ||
                                $field['id'] == $featured_checkbox_id
                        ) {
                                continue;
                        }
                        $fields[] = $field;
                }
                $form['fields'] = $fields;
        }
        return $form;
}

add_action("gform_after_submission_" . $nz['form.event']['id'], "after_event_submission", 10, 2);

function after_event_submission($entry, $form) {
        $user = wp_get_current_user();

        //handle admin checkboxes
        if (($user instanceof WP_User && $user->ID != 0)) {

                update_user_meta($user->ID, 'is_promoter', 'true');

                $roles = $user->roles;  //$roles is an array

                if (
                        (in_array('administrator', $roles))
                /* || (!in_array('author', $roles)) */
                ) {

                        $publish_checkbox_id = '21.1';
                        $featured_checkbox_id = '23.1';
                        $post = array();

                        if ($entry[$publish_checkbox_id] != '') {
                                $post['ID'] = $entry['post_id'];
                                $post['post_status'] = 'publish';
                                wp_update_post($post);
                        }

                        if ($entry[$featured_checkbox_id] != '') {
                                update_post_meta($post['ID'], 'wpcf-event_displayed', 1);
                        }
                }

                global $NZS;
                $NZS->getFlashBag()->add('success', $form['confirmation']['message']);
                wp_redirect(get_author_posts_url($user->ID));
                exit();
        }
        global $NZS;
        $form_message = $form['confirmation']['message'];
        $form_message .= '<br>' . 'Registrate para guardares tus eventos!';

        $NZS->getFlashBag()->add('success', $form_message);
        $register_link = add_query_arg(array('action' => 'event_' . $entry['post_id']), get_permalink(get_page_by_path('registrate')));
        wp_redirect($register_link);
        exit();
}
