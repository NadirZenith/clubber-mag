<?php
// Add a custom field button to the advanced to the field editor
add_filter('gform_add_field_buttons', 'nz_add_gform_gallery_field');

function nz_add_gform_gallery_field($field_groups) {
        foreach ($field_groups as &$group) {
                if ($group["name"] == "advanced_fields") { // to add to the Advanced Fields
                        //if( $group["name"] == "standard_fields" ){ // to add to the Standard Fields
                        //if( $group["name"] == "post_fields" ){ // to add to the Standard Fields
                        $group["fields"][] = array(
                              "class" => "button",
                              "value" => __("Gallery", "gravityforms"),
                              "onclick" => "StartAddField('gallery');"
                        );
                        break;
                }
        }
        return $field_groups;
}

// Adds title to GF custom field
/* add_filter('gform_field_type_title', 'nz_gform_gallery_title'); */

function nz_gform_gallery_title($type) {
        if ($type == 'image_preview') {
                return __('Gallery field', 'gravityforms');
        }
}

// Add a custom setting to the field
add_action("gform_field_advanced_settings", "nz_gform_gallery_settings", 10, 2);

function nz_gform_gallery_settings($position, $form_id) {
        /* d($position); */
        // Create settings on position 50 (right after Field Label)
        if ($position == 50) {
                //see form_detail.php
                ?>

                <li class="gallery_settings field_setting">

                        <label for="gallery_target" class="inline">
                                <?php _e("Target id of uploaded photos", "gravityforms"); ?>
                                <!--<?php gform_tooltip("image_upload_featured_setting"); ?>-->
                        </label>
                        <input type="text" id="gallery_target" onkeyup="SetFieldProperty('gallery_target', this.value);" />

                </li>
                <?php
        }
}

// Now we execute some javascript technicalitites for the field to load correctly
add_action("gform_editor_js", "nz_gform_gallery_js");

function nz_gform_gallery_js() {
        ?>

        <script type='text/javascript'>

                jQuery(document).ready(function($) {
                        fieldSettings["gallery"] = ".label_setting, .description_setting, .rules_setting, .error_message_setting, .css_class_setting, .gallery_settings";

                        //binding to the load field settings event to initialize the field
                        $(document).bind("gform_load_field_settings", function(event, field, form) {
                                $("#gallery_target").val(field["gallery_target"]);
                        });

                });

        </script>
        <?php
}

// Adds the input area to the external side
add_action("gform_field_input", "nz_gallery_field_input", 10, 5);

function nz_gallery_field_input($input, $field, $value, $lead_id, $form_id) {

        if ($field["type"] == "gallery") {

                $images = json_decode($value, true);

                if (is_array($images) && isset($images[1]['src'])) {
                        $content = '';
                        foreach ($images as $key => $image) {
                                $content .= sprintf('<img src="%s""">', $image['src']);
                        }
                }
                $tabindex = GFCommon::get_tabindex(); //"tabindex='2'"
                $css = isset($field['cssClass']) ? $field['cssClass'] : '';
                $id = 'input_' . $form_id . '_' . $field['id']; //"input_3_2"

                $upload_button = sprintf(
                        '<div id="gallery-upload-%1$s">'
                        . '<input type="button" id="%1$s-button" class="nz-gform-gallery-upload-button nz-upload-button" value="Subir Photos" data-type="multiple"/>' //
                        . '<div class="progress" style="width:290px; height:5px;margin-bottom: 10px;border-bottom:1px solid #111;">'
                        . '<div class="bar" style="width:2%%; height:5px;background-color:#333"></div>'
                        . '</div>'
                        . '</div>', //
                        $id
                );

                $preview_container = '<div id="preview-' . $id . '" >';
                if ($content) {
                        //loop throught images
                        $preview_container .= $content;
                } else {
                        $preview_container .= '';
                }
                $preview_container .= '</div>';


                $input = sprintf(
                        '<input name="input_%s" id="%s" class="%s" ' . $tabindex . ' type="hidden" value="%s"  />', //input
                        $field["id"], //name
                        $id, //id
                        $field["type"] . ' ' . esc_attr($css), //class
                        esc_html($value)//value
                );
                $style = "<style>"
                        . "#preview-{$id}{width:500px; background-color:#aaa;}"
                        . "#preview-{$id} img{ width:32%; margin:0.5%;}"
                        . " </style>";

                $input = $style . '<div class="ginput_container">' . $upload_button . $preview_container . $input . '</div>';
        }

        return $input;
}
