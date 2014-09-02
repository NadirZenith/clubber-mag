<?php

global $nz;


$nz['form.artist'] = array(
      'id' => 8,
      'ajax' => 1,
      'post_type' => 'artista'
);

$nz['artist_form'] = function($nz) {

        $shortcode = sprintf($nz['shortcode.gform'], $nz['form.artist']['id'], $nz['form.artist']['ajax']);

        return do_shortcode($shortcode);
};

add_action("gform_after_submission_" . $nz['form.artist']['id'], "relate_user_to_artist", 10, 2);

function relate_user_to_artist($entry, $form) {

        $user = wp_get_current_user();
        $post_id = $entry['post_id'];

        //check for user main resource
        $main_resource = get_user_meta($user->ID, 'main_resource', true);

        if (!$main_resource) {
                update_user_meta($user->ID, 'main_resource', 'artist');
        }

        update_user_meta($user->ID, 'artist_page', $post_id);

        global $NZS;
        $NZS->getFlashBag()->add('success', $form['confirmation']['message']);
        wp_redirect(get_author_posts_url(get_current_user_id()));
        exit();
}

add_filter('nz_image_preview_placeholder_' . $nz['form.artist']['id'] . '_3', 'set_artist_preview_image');

function set_artist_preview_image($img) {
        $post_id = $_GET['gform_post_id'];
        $thumb = get_the_post_thumbnail($post_id);
        if ($thumb) {
                $img = wp_get_attachment_url(get_post_thumbnail_id($post_id));
        }
        return $img;
}

add_filter('nz_image_preview_input_value_' . $nz['form.artist']['id'] . '_3', 'set_artist_preview_value');

function set_artist_preview_value($value) {
        $post_id = $_GET['gform_post_id'];

        $post = get_post($post_id, $output, $filter);
        
      global $nz;
        if ($post && $post->post_type == $nz['form.artist']['post_type']) {

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

add_filter("gform_field_content", "remove_artist_title_edit", 10, 5);

function remove_artist_title_edit($content, $field, $value, $lead_id, $form_id) {
        global $nz;
        if (
                $nz['form.artist']['id'] == $form_id &&
                $field['id'] == 1 &&
                $value != ''
        ) {
                $content = str_replace("type='text'", "type='hidden'", $content);
                $content .= sprintf('<h2 class="ml5 bold">%s</h2>', $value);
        }

        return $content;
}
