<?php
/**
 * Plugin Name: Gravity Forms Google Maps
 * 
 * Description: Field with google maps support
 * Version: 0.1 beta
 * Author: Nadir Zenith
 * Author URI: http://www.SOON.net/
 * License:  
  DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
  Version 2, December 2004

  Copyright (C) 2004 Sam Hocevar <sam@hocevar.net>

  Everyone is permitted to copy and distribute verbatim or modified
  copies of this license document, and changing it is allowed as long
  as the name is changed.

  DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
  TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

  0. You just DO WHAT THE FUCK YOU WANT TO.
 */
// Add a custom field button to the advanced to the field editor
add_filter('gform_add_field_buttons', 'nz_add_google_maps_field');

function nz_add_google_maps_field($field_groups) {
        foreach ($field_groups as &$group) {
                if ($group["name"] == "advanced_fields") { // to add to the Advanced Fields
                        //if( $group["name"] == "standard_fields" ){ // to add to the Standard Fields
                        //if( $group["name"] == "post_fields" ){ // to add to the Standard Fields
                        $group["fields"][] = array(
                              "class" => "button",
                              "value" => __("Google Maps", "gravityforms"),
                              "onclick" => "StartAddField('google_maps');"
                        );
                        break;
                }
        }
        return $field_groups;
}

// Adds title to GF custom field
add_filter('gform_field_type_title', 'nz_google_maps_title');

function nz_google_maps_title($type) {
        if ($type == 'image_preview')
                return __('Google Maps', 'gravityforms');
}

// Now we execute some javascript technicalitites for the field to load correctly
add_action("gform_editor_js", "nz_gform_google_maps_js");

function nz_gform_google_maps_js() {
        ?>

        <script type='text/javascript'>

                jQuery(document).ready(function($) {
                        fieldSettings["google_maps"] = ".label_setting, .description_setting, .rules_setting, .error_message_setting, .css_class_setting";

                        //binding to the load field settings event to initialize the checkbox
                        /*                        
                         $(document).bind("gform_load_field_settings", function(event, field, form) {
                         jQuery("#field_nz_set_featured").attr("checked", field["nz_set_featured"] == true);
                         jQuery("#field_nz_image_sizes").attr("value", field["nz_image_sizes"]);
                         });
                         * */

                });

        </script>
        <?php
}

// SETTINGS Add a custom setting to the tos advanced field
/* add_action("gform_field_advanced_settings", "nz_gform_google_maps_settings", 10, 2); */

function nz_gform_google_maps_settings($position, $form_id) {
        /* d($position); */
        // Create settings on position 50 (right after Field Label)
        if ($position == 50) {
                ?>

                <li class="nz_set_featured_setting field_setting">

                        <input type="checkbox" id="field_nz_set_featured" onclick="SetFieldProperty('nz_set_featured', this.checked);" />
                        <label for="field_nz_set_featured" class="inline">
                                <?php _e("Set as featured image", "gravityforms"); ?>
                                <?php gform_tooltip("field_nz_set_featured"); ?>
                        </label>

                </li>
                <!--       fieldSettings["image_preview"]    nz_image_sizes_setting     -->
                <li class="nz_image_sizes_setting field_setting">

                        <label for="field_nz_image_sizes" class="inline">
                                <?php _e("image sizes", "gravityforms"); ?>
                        </label>
                        <input type="text" id="field_nz_image_sizes" onkeyup="SetFieldProperty('nz_image_sizes', this.value);" />

                </li>
                <?php
        }
}

//Filter to add a new tooltip
/* add_filter('gform_tooltips', 'nz_gform_google_maps_tooltip'); */

function nz_gform_google_maps_tooltip($tooltips) {
        /*     @todo: ...  */
        return $tooltips;
}

// Adds the input area to the external side
add_action("gform_field_input", "nz_gform_google_maps_field_input", 10, 5);

function nz_gform_google_maps_field_input($input, $field, $value, $lead_id, $form_id) {

        if ($field["type"] == "google_maps") {
                $value = apply_filters('nz_gform_google_maps_value_' . $form_id . '_' . $field['id'], $value);
                $id = 'input_' . $form_id . '_' . $field['id'];
                $input_field = '<input id="' . $id . '" name="input_' . $field['id'] . '" value="' . $value . '" type="text" placeholder="Type in an address" class="medium" size="30" />';

                $map_canvas = '<div class="map_canvas"></div>';
                $input = '<div class="ginput_container">' . $input_field . $map_canvas . '</div>';
        }

        return $input;
}

// Add a custom class to the field li
add_action("gform_field_css_class", "nz_gform_google_maps_custom_class", 10, 3);

function nz_gform_google_maps_custom_class($classes, $field, $form) {
        if ($field["type"] == "google_maps") {
                $classes .= " nz_gform_google_maps ";
        }

        return $classes;
}

// Add a script to the display of the particular form only if image preview field is being used
add_action('gform_enqueue_scripts', 'nz_gform_google_maps_enqueue_scripts', 10, 2);

function nz_gform_google_maps_enqueue_scripts($form, $ajax) {
        // cycle through fields to see if image_preview is being used
        foreach ($form['fields'] as $field) {
                if ($field['type'] == 'google_maps') {
                        add_action('wp_footer', 'nz_gform_google_maps_script', 10, 2);

                        // Register the script first.
                        wp_register_script('nz_gform_google_maps_geocomplete', plugins_url('jquery.geocomplete.min.js', __FILE__), array("jquery"));

                        // The script can be enqueued now or later.
                        /*wp_enqueue_script('nz_gform_google_maps_api');*/
                        wp_enqueue_script('nz_gform_google_maps_geocomplete');

                        break;
                }
        }
}

function nz_gform_google_maps_script() {
        ?>
        <style>
                .map_canvas { 
                        width: 98%;
                        margin: 5px auto;
                        height: 300px; 
                }
        </style>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&sensor=true"></script>
        <?php
        /*
         * 
          <script type="text/javascript"
          src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places">
          </script>
         */
        ?>
        <script>
                                jQuery(function($) {
                                        $field = $("#input_10_4");
                                        console.log($field);
                                        console.log($field.val());

                                        if (!$field.val()) {
                                                $field.geocomplete({
                                                        map: ".map_canvas"
                                                });
                                        } else {
                                                $field.geocomplete({
                                                        map: ".map_canvas",
                                                        location: $field.val()
                                                });

                                        }
                                });
        </script>
        <?php
}

add_action("gform_after_submission", "nz_gform_google_maps_after_submission", 10, 2);

function nz_gform_google_maps_after_submission($entry, $form) {
        foreach ($form['fields'] as $field) {
                if ('google_maps' == $field['type']) {
                        $action_name = 'nz_gform_google_maps_after_submission_' . $form['id'] . '_' . $field['id'];
                        do_action($action_name
                                , array('field' => $field, 'entry' => $entry)
                        );
                }
        }
}
