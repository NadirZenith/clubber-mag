<?php

/* add_filter("gform_field_content", "image_upload_preview", 10, 5); */
add_filter("gform_field_input", "image_upload_preview", 10, 5);

function image_upload_preview($input, $field, $value, $lead_id, $form_id) {
        //hidden input field to convert = 4
        if (6 === $form_id &&
                4 === (int) $field['id']) {

                if ($value && is_numeric($value)) {
                        $attach = wp_get_attachment_image_src($value, array('290', '160'));
                        if ($attach) {
                                $image_url = $attach[0];
                        }
                } else {
                        $image_url = get_template_directory_uri() . '/images/preview-290-160.png';
                }
                /* '<label class="gfield_label" for="input_6_4">Photo<span class="gfield_required">*</span></label>' */
                $input = '<div class="ginput_container">'
                        //image preview placeholder
                        . '<img id="imagePreview" src="' . $image_url . '" alt="preview image" style="width:290px; height:160px; background-color:yellowgreen;"/>'
                        //progress bar
                        . '<div class="progress" style="width:290px; height:15px;margin-bottom: 10px;border-bottom:1px solid #111;">'
                        . '<div class="bar" style="width:2%; height:15px;background-color:#333"></div>'
                        . '</div>'
                        //hidden field stores images ids
                        /* . '<input name="input_4" id="input_6_4" type="number" step="any" value="" class="medium" tabindex="3"   />' */
                        . '<input name="input_4" id="input_6_4" type="hidden" value="' . $value . '"  />'
                        //image upload trigger button
                        . '<input type="button" id="upload-image-button" value="Subir Photo" />'
                        . '</div>';
                /* return $input; */
        }

        return $input;
}

add_action("gform_after_submission", "set_post_content", 10, 2);

function set_post_content($entry, $form) {
        $post_id= $entry['post_id'];
        $attach_id = $entry[4];
        add_post_meta($post_id, '_thumbnail_id', $attach_id, true);
        /*d($entry);*/
        /*d($form);*/
}
