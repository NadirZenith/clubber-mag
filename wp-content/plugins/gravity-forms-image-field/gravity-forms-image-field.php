<?php
/**
 * Plugin Name: Gravity Forms image Field
 * Upload image with preview
 * Description: Upload image with preview
 * Version: 0.1 beta
 * Author: Nadir Zenith
 * Author URI: http://www.SOON.net/
 * License: GPLv2
 * 
 * 
 *     This program is free software; you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License, version 2, as 
 *     published by the Free Software Foundation.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program; if not, write to the Free Software
 * 
 *     Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * 
 */
include_once 'gform-gallery-field.php';

// Add a custom field button to the advanced to the field editor
add_filter('gform_add_field_buttons', 'nz_add_image_preview_field');

function nz_add_image_preview_field($field_groups) {
        foreach ($field_groups as &$group) {
                if ($group["name"] == "advanced_fields") { // to add to the Advanced Fields
                        //if( $group["name"] == "standard_fields" ){ // to add to the Standard Fields
                        //if( $group["name"] == "post_fields" ){ // to add to the Standard Fields
                        $group["fields"][] = array(
                              "class" => "button",
                              "value" => __("Image Preview", "gravityforms"),
                              "onclick" => "StartAddField('image_preview');"
                        );
                        break;
                }
        }
        return $field_groups;
}

// Adds title to GF custom field
add_filter('gform_field_type_title', 'nz_image_preview_title');

function nz_image_preview_title($type) {
        if ($type == 'image_preview')
                return __('Image preview', 'gravityforms');
}

// Now we execute some javascript technicalitites for the field to load correctly
add_action("gform_editor_js", "nz_gform_editor_js");

function nz_gform_editor_js() {
        ?>

        <script type='text/javascript'>

                jQuery(document).ready(function($) {
                        fieldSettings["image_preview"] = ".label_setting, .description_setting, .rules_setting, .error_message_setting, .css_class_setting, .nz_set_featured_setting, .nz_image_sizes_setting";

                        //binding to the load field settings event to initialize the checkbox
                        $(document).bind("gform_load_field_settings", function(event, field, form) {
                                jQuery("#field_nz_set_featured").attr("checked", field["nz_set_featured"] == true);
                                jQuery("#field_nz_image_sizes").attr("value", field["nz_image_sizes"]);
                        });

                });

        </script>
        <?php
}

// SETTINGS Add a custom setting to the tos advanced field
add_action("gform_field_advanced_settings", "nz_image_preview_settings", 10, 2);

function nz_image_preview_settings($position, $form_id) {
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
/* add_filter('gform_tooltips', 'nz_field_images_sizes_tooltip'); */

function nz_field_images_sizes_tooltip($tooltips) {
        $tooltips["field_nz_set_featured"] = "<h6>Set as featured image</h6>Check the box if you would like to attribute image to post.";
        /* $tooltips["form_field_default_value"] = "<h6>Default Value</h6>Enter the Terms of Service here."; */
        return $tooltips;
}

// Adds the input area to the external side
add_action("gform_field_input", "nz_image_preview_field_input", 10, 5);

function nz_image_preview_field_input($input, $field, $value, $lead_id, $form_id) {

        if ($field["type"] == "image_preview") {
                $image_size = explode(',', $field['nz_image_sizes']);
                /* d($image_size); */

                $image_info = json_decode($value, true);

                $image_url = (isset($image_info[1]['src'])) ? $image_info[1]['src'] : plugins_url('images/image_ph.png', __FILE__);
                $image_url = apply_filters('nz_image_preview_placeholder_' . $form_id . '_' . $field['id'], $image_url);

                $tabindex = GFCommon::get_tabindex();

                $css = isset($field['cssClass']) ? $field['cssClass'] : '';

                $id = 'input_' . $form_id . '_' . $field['id'];


                $preview_container = sprintf(
                        '<div id="preview-%1$s">'
                        . '<img id="nz-gform-image-preview-%1$s" class="gform_image_preview" src="%2$s" alt="preview image" style="width:' . $image_size[0] . 'px; height:' . $image_size[1] . 'px;"/>'
                        . '<div class="result_pannel" style="display:none">'
                        
                        . '<div class="progress" style="width:' . $image_size[0] . 'px; height:5px;margin-bottom: 10px;border-bottom:1px solid #111;">'
                        
                        . '<div class="bar" style="width:1%%; height:5px;background-color:#333"></div>'
                        . '<div class="prc" style="float:right"></div>'
                        . '</div>'
                        
                        . '</div>'
                        . '</div>'
                        . '<input type="button" id="%1$s-button" class="nz-gform-image-preview-upload-button nz-upload-button" value="Subir Photo" data-type="single" />', $id, $image_url);

                $value = apply_filters('nz_image_preview_input_value_' . $form_id . '_' . $field['id'], $value);
                $input = sprintf(
                        '<input name="input_%s" id="%s" class="%s" ' . $tabindex . ' type="hidden" value="%s"  />', //input
                        $field["id"], //name
                        $id, //id
                        $field["type"] . ' ' . esc_attr($css), //class
                        esc_html($value)//value
                );


                $input = '<div class="ginput_container">' . $preview_container . $input . '</div>';
        }

        return $input;
}

// Add a custom class to the field li
add_action("gform_field_css_class", "nz_gform_image_preview_custom_class", 10, 3);

function nz_gform_image_preview_custom_class($classes, $field, $form) {
        if ($field["type"] == "image_preview") {
                $classes .= " gform_image_preview";
        }

        return $classes;
}

// Add a script to the display of the particular form only if image preview field is being used
add_action('gform_enqueue_scripts', 'nz_gform_enqueue_scripts', 10, 2);

function nz_gform_enqueue_scripts($form, $ajax) {
        // cycle through fields to see if image_preview is being used
        foreach ($form['fields'] as $field) {
                if (( $field['type'] == 'image_preview' || $field['type'] == 'gallery')) {
                        /* d('aqui'); */
                        add_action('wp_footer', 'nz_ajaxurl');

                        $url = plugins_url('gform_image_preview.js', __FILE__);

                        // Register the script first.
                        wp_register_script('nz_gform_image_preview', $url, array("jquery", "jquery-form"));

                        // Now we can localize the script with our data.
                        /* wp_localize_script('nz_gform_image_preview', 'nz_image_preview', $js_field_info); */

                        // The script can be enqueued now or later.
                        wp_enqueue_script('nz_gform_image_preview');

                        break;
                }
        }
}

if (!function_exists('nz_ajaxurl')) {

        function nz_ajaxurl() {
                ?>
                <script type="text/javascript">
                        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                </script>
                <?php
        }

}


/**
 * add ajax actions
 *  wp_ajax_nz_gform_image_upload
 *  wp_ajax_ + action
 */
// ajax for logged in users
add_action('wp_ajax_nz_gform_image_upload', 'ajax_nz_gform_image_upload');

//// ajax for not logged in users 
add_action('wp_ajax_nopriv_nz_gform_image_upload', 'ajax_nz_gform_image_upload');

//ajax receive action
function ajax_nz_gform_image_upload() {
        //Creating temp folder if it does not exist
        $target_path = RGFormsModel::get_upload_root() . "image_preview/";
        $target_url = RGFormsModel::get_upload_url_root() . "image_preview/";
        wp_mkdir_p($target_path);
        $mime = array("image/jpg", "image/jpeg", "image/png");
        $remove_these = array(' ', '`', '"', '\'', '\\', '/');
        $upload_files_url = array();
        $i = 0;
        /*    test if is array. for non required field!    */
        foreach ($_FILES['files']['name'] as $key => $value_data) {

                $errors_founds = '';

                if ($_FILES['files']['error'][$key] != UPLOAD_ERR_OK) {

                        $errors_founds .= 'Error uploading the file!<br />';
                }

                if (!in_array(trim($_FILES['files']['type'][$key]), $mime)) {

                        $errors_founds .= 'Invalid file type!<br />';
                }

                if ($_FILES['files']['size'][$key] == 0) {

                        $errors_founds .= 'Image file it\'s empty!<br />';
                }

                if ($_FILES['files']['size'][$key] > getMaximumFileUploadSize()) {

                        $errors_founds .= 'Image file to large, maximus size is 500Kb!<br />';
                }

                if (!is_uploaded_file($_FILES['files']['tmp_name'][$key])) {

                        $errors_founds .= 'Error uploading the file on the server!<br />';
                }

                if ($errors_founds == '') {

                        //Sanitize the filename (See note below)
                        $newname = str_replace($remove_these, '', $_FILES['files']['name'][$key]);

                        //Make the filename unique
                        $newname = time() . '-' . $newname;

                        //Save the uploaded the file to another location
                        $upload_path = $target_path . "$newname";
                        move_uploaded_file($_FILES['files']['tmp_name'][$key], $upload_path);

                        $upload_files_url[$target_path] = $target_url . "$newname";

                        //return image information hover ajax
                        $i++;
                        $attachs[$i]['src'] = $upload_files_url[$target_path];
                }
        }

        if ($errors_founds != '') {
                echo $errors_founds;
                die();
        }
        echo json_encode($attachs);
        die(); // stop executing script
}

add_action("gform_after_submission", "nz_associate_image_to_post", 10, 2);

function nz_associate_image_to_post($entry, $form) {

        $source_path = RGFormsModel::get_upload_root() . "image_preview/";

        foreach ($form['fields'] as $field) {

                if ('image_preview' == $field['type']) {

                        $field_value = json_decode($entry[$field['id']], TRUE);
                        $img_name = basename($field_value['1']['src']);
                        $filename_path = $source_path . $img_name;
                        $wp_filetype = wp_check_filetype($img_name, null);

                        //call an action formId_FieldId and pass arguments
                        if (!empty($field['nz_image_sizes'])) {
                                $sizes = explode(',', $field['nz_image_sizes']);
                                $action_name = 'nz_image_upload_custom_sizes_' . $form['id'] . '_' . $field['id'];
                                do_action($action_name
                                        , array('field' => $field, 'entry' => $entry)
                                );
                        }

                        //set featured image
                        if ($field['nz_set_featured'] && !isset($field_value['1']['attach_id'])) {

                                $uploads = wp_upload_dir();
                                $destination_path = $uploads['path'] . "/$img_name";

                                $attachment = array(
                                      'post_mime_type' => $wp_filetype['type'],
                                      'post_title' => preg_replace('/\.[^.]+$/', '', $img_name),
                                      'post_content' => '',
                                      'post_status' => 'inherit'
                                );

                                //mv file to uploads and instert into library
                                rename($filename_path, $destination_path);
                                $attach_id = wp_insert_attachment($attachment, $destination_path);

                                // for the function wp_generate_attachment_metadata() to work
                                require_once(ABSPATH . 'wp-admin/includes/image.php');
                                $attach_data = wp_generate_attachment_metadata($attach_id, $destination_path);
                                wp_update_attachment_metadata($attach_id, $attach_data);

                                /* add_post_meta($entry['post_id'], '_thumbnail_id', $attach_id, true); */
                                update_post_meta($entry['post_id'], '_thumbnail_id', $attach_id);
                        }
                }
        }
}

function convertPHPSizeToBytes($sSize) {
        //This function transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case)  
        $sSuffix = substr($sSize, -1);
        $iValue = substr($sSize, 0, -1);
        switch (strtoupper($sSuffix)) {
                case 'P':
                        $iValue *= 1024;
                case 'T':
                        $iValue *= 1024;
                case 'G':
                        $iValue *= 1024;
                case 'M':
                        $iValue *= 1024;
                case 'K':
                        $iValue *= 1024;
                        break;
        }
        return $iValue;
}

function getMaximumFileUploadSize() {
        return min(convertPHPSizeToBytes(ini_get('post_max_size')), convertPHPSizeToBytes(ini_get('upload_max_filesize')));
}
