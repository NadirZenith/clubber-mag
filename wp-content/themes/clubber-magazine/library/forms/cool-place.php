<?php

global $nz;


$nz['form.coolplace'] = array(
      'id' => 9,
      'ajax' => 1
);

$nz['coolplace_form'] = function($nz) {

        $shortcode = sprintf($nz['shortcode.gform'], $nz['form.coolplace']['id'], $nz['form.coolplace']['ajax']);

        return do_shortcode($shortcode);
};
add_action("gform_after_submission_" . $nz['form.coolplace']['id'], "relate_user_to_coolplace", 10, 2);

function relate_user_to_coolplace($entry, $form) {

        $user = wp_get_current_user();
        $coolplace_id = $entry['post_id'];

        $NZRelation = New NZRelation('coolplaces_to_users', 'coolplace_id', 'user_id');
        $NZRelation->install_table();

        $NZRelation->setRelationFrom($coolplace_id, $user->ID);

        update_user_meta($user->ID, 'has_coolplace', 'true');

        //set cool place type!
        $term = array((int) $entry['5']);
        wp_set_object_terms($coolplace_id, $term, 'cool_place_type');


        global $NZS;
        $NZS->getFlashBag()->add('success', $form['confirmation']['message']);
        wp_redirect(get_author_posts_url(get_current_user_id()));
        exit();
}

add_filter('nz_image_preview_placeholder_' . $nz['form.coolplace']['id'] . '_3', 'set_coolplace_preview_image');

function set_coolplace_preview_image($img) {
        $post_id = $_GET['gform_post_id'];
        $thumb = get_the_post_thumbnail($post_id);
        if ($thumb) {
                $img = wp_get_attachment_url(get_post_thumbnail_id($post_id));
        }
        return $img;
}

add_filter('nz_image_preview_input_value_' . $nz['form.coolplace']['id'] . '_3', 'set_coolplace_preview_value');

function set_coolplace_preview_value($value) {
        $post_id = $_GET['gform_post_id'];

        $post = get_post($post_id, $output, $filter);
        if ($post && $post->post_type == 'cool-place') {

                $thumb = get_the_post_thumbnail($post->ID);

                if ($thumb) {
                        $value = array();
                        $img = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                        $value[1]['src'] = $img;
                        $value[1]['attach_id'] = get_post_thumbnail_id($post->ID);
                        $return = json_encode($value);
                        return $return;
                }
        }
        return $value;
}

add_filter("gform_field_content", "remove_coolplace_title_edit", 10, 5);

function remove_coolplace_title_edit($content, $field, $value, $lead_id, $form_id) {
        global $nz;
        if (
                $nz['form.coolplace']['id'] == $form_id &&
                $field['id'] == 1 &&
                $value != ''
        ) {
                $content = str_replace("type='text'", "type='hidden'", $content);
                $content .= sprintf('<h2 class="ml5 bold">%s</h2>', $value);
        }

        return $content;
}

add_filter("nz_gform_google_maps_value_" . $nz['form.coolplace']['id'] . '_4', "pre_value_map_coolplace", 10, 5);

function pre_value_map_coolplace($value) {
        $post_id = (int) $_GET['gform_post_id'];
        $direction = get_post_meta($post_id, 'mapa', true);

        if ($direction) {
                return $direction;
        }
}

add_filter("nz_gform_google_maps_after_submission_" . $nz['form.coolplace']['id'] . '_4', "process_coolplace_map", 10, 5);

function process_coolplace_map($arg) {
        $post_id = $arg['entry']['post_id'];
        update_post_meta($post_id, 'mapa', $arg['entry']['4']);
}

/*
 */