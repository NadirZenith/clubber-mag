<?php

/**
 * FIELD USER PROFILE PICTURE 4_5
 */
//      PRE
add_filter('nz_image_preview_placeholder_6_5', 'set_field_value_user_profile_image');

function set_field_value_user_profile_image($img) {
        $img = nz_get_user_image(false, 'profile');
        return $img;
}

//      POST
add_action('nz_image_upload_custom_sizes_6_5', 'nz_process_user_profile_picture');

function nz_process_user_profile_picture($arr) {
        $field = $arr['field'];
        $entry = $arr['entry'];
        //$form = $arr['form'];

        $field_value = json_decode($entry[$field['id']], TRUE);

        if ($field_value) {
                $uid = get_current_user_id();
                $img_name = basename($field_value['1']['src']);
                $file_source = RGFormsModel::get_upload_root() . "image_preview/" . $img_name;
                $size = explode(',', $field['nz_image_sizes']);

                nz_set_user_image($uid, $file_source, 'profile', $size);
        }
}

/**
 * FIELD USER BACKGROUND PICTURE 5_6
 */
//      PRE
add_filter('nz_image_preview_placeholder_6_6', 'set_field_value_user_background_image');

function set_field_value_user_background_image($img) {
        $img = nz_get_user_image(false, 'background');
        return $img;
}

//      POST
add_action('nz_image_upload_custom_sizes_6_6', 'nz_process_user_background_picture');

function nz_process_user_background_picture($arr) {
        $field = $arr['field'];
        $entry = $arr['entry'];
        //$form = $arr['form'];

        $field_value = json_decode($entry[$field['id']], TRUE);

        if ($field_value) {

                $uid = get_current_user_id();

                $img_name = basename($field_value['1']['src']);
                $file_source = RGFormsModel::get_upload_root() . "image_preview/" . $img_name;
                $size = explode(',', $field['nz_image_sizes']);

                nz_set_user_image($uid, $file_source, 'background', $size);
        }
}

/**
 *      set default user profile image
 * 
 *  */
add_filter('nz_get_user_image_profile', 'nz_set_default_user_profile');

function nz_set_default_user_profile($imgUrl) {
        if (FALSE == $imgUrl) {
                $imgUrl = get_template_directory_uri() . '/images/user-profile-ph.png';
        }
        return $imgUrl;
}

add_filter('nz_get_user_image_background', 'nz_set_default_user_background');

function nz_set_default_user_background($imgUrl) {
        if (FALSE == $imgUrl) {
                $imgUrl = get_template_directory_uri() . '/images/user-background-ph.png';
        }

        return $imgUrl;
}
