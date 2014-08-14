<?php

global $nz;

$nz['form.label'] = array(
      'id' => 9,
      'ajax' => 1
);

$nz['label_form'] = function($nz) {
        $form = $nz['form.label'];

        $shortcode = sprintf($nz['shortcode.gform'], $form['id'], $form['ajax']);

        return do_shortcode($shortcode);
};

add_action("gform_after_submission_" . $nz['form.label']['id'], "relate_user_to_label", 10, 2);

function relate_user_to_label($entry, $form) {
        $user = wp_get_current_user();
        $label_id = $entry['post_id'];

        //check for user main resource
        $main_resource = get_user_meta($user->ID, 'main_resource', true);

        if (!$main_resource) {
                update_user_meta($user->ID, 'main_resource', 'sello');
        }

        update_user_meta($user->ID, 'label_page', $label_id);

        global $NZS;
        $NZS->getFlashBag()->add('success', $form['confirmation']['message']);
        wp_redirect(get_author_posts_url(get_current_user_id()));
        exit();
}

add_filter('nz_image_preview_placeholder_' . $nz['form.label']['id'] . '_2', 'set_label_preview_image');

function set_label_preview_image($img) {
        $post_id = $_GET['gform_post_id'];
        $thumb = get_the_post_thumbnail($post_id);
        if ($thumb) {
                $img = wp_get_attachment_url(get_post_thumbnail_id($post_id));
        }
        return $img;
}

add_filter('nz_image_preview_input_value_' . $nz['form.label']['id'] . '_2', 'set_label_preview_value');

function set_label_preview_value($value) {

        $post_id = $_GET['gform_post_id'];

        $post = get_post($post_id, $output, $filter);
        if ($post && $post->post_type == 'sello') {

                $thumb = get_the_post_thumbnail($post->ID);

                if ($thumb) {
                        $attach_id = get_post_thumbnail_id($post->ID);
                        $img = wp_get_attachment_url($attach_id);
                        $data[1]['src'] = $img;
                        $data[1]['attach_id'] = get_post_thumbnail_id($post->ID);
                        $value = json_encode($data);
                }
        }
        return $value;
}

add_filter("gform_field_content", "remove_label_title_edit", 10, 5);

function remove_label_title_edit($content, $field, $value, $lead_id, $form_id) {
        global $nz;
        if (
                $nz['form.label']['id'] == $form_id &&
                $field['id'] == 1 &&
                $value != ''
        ) {
                $content = str_replace("type='text'", "type='hidden'", $content);
                $content .= sprintf('<h2 class="ml5 bold">%s</h2>', $value);
        }
        return $content;
}
