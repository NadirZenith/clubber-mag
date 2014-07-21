<?php

global $nz;

$nz['form.userpost'] = array(
      'id' => 11,
      'ajax' => 1
);

$nz['userpost_form'] = function($nz) {
        $form = $nz['form.userpost'];

        $shortcode = sprintf($nz['shortcode.gform'], $form['id'], $form['ajax']);

        return do_shortcode($shortcode);
};

add_action("gform_after_submission_" . $nz['form.userpost']['id'], "relate_user_and_resource_to_post", 10, 2);

function relate_user_and_resource_to_post($entry, $form) {
        $user = wp_get_current_user();
        $user_post_id = $entry['post_id'];

        $type = get_query_var('type'); // artista || sellos-discograficos

        switch ($type) {
                case 'artista':
                        $parent_id = get_user_meta($user->ID, 'artist_page', true);


                        break;
                case 'sello':
                        $parent_id = get_user_meta($user->ID, 'label_page', true);


                        break;

                default:
                        die('403');
                        break;
        }

        if ($parent_id) {
                update_post_meta($user_post_id, 'parent', $parent_id);
        }

        global $NZS;
        $NZS->getFlashBag()->add('success', $form['confirmation']['message']);
        wp_redirect(get_author_posts_url($user->ID));
        exit();
}

/*
add_filter('nz_image_preview_placeholder_' . $nz['form.userpost']['id'] . '_2', 'set_label_preview_image');

function set_label_preview_image($img) {
        $post_id = $_GET['gform_post_id'];
        $thumb = get_the_post_thumbnail($post_id);
        if ($thumb) {
                $img = wp_get_attachment_url(get_post_thumbnail_id($post_id));
        }
        return $img;
}

add_filter('nz_image_preview_input_value_' . $nz['form.userpost']['id'] . '_2', 'set_label_preview_value');

function set_label_preview_value($value) {

        $post_id = $_GET['gform_post_id'];

        $post = get_post($post_id, $output, $filter);
        if ($post && $post->post_type == 'label') {

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
 */
