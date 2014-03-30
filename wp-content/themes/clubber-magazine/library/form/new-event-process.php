<?php

/* 'POST' == $_SERVER['REQUEST_METHOD'] */
//response generation function
$error_response = array();

//function to generate response
function add_event_form_error($message) {
      global $error_response;
      $error_response[] = "<li class='error col-1-4 fl '>{$message}</li>";
}

if ('POST' == $_SERVER['REQUEST_METHOD']) {
      /* if ($_POST['submitted']) { */
      global $error_response;
//RESPONSE MESSAGES
      $rm = array();
      $rm['event_title'] = 'Title must be set.';
      $rm['event_description'] = 'Description must be set.';
      $rm['event_begin_date'] = 'Event begin date must be set.';
      $rm['event_price'] = 'Event price date must be set. (only numbers)';
      $rm['event_club_name'] = 'Club name must be set.';
      $rm['event_club_address'] = 'Club address must be set.';
      $rm['event_flyer'] = 'Event flyer must be uploaded.';
      /* $rm['event_flyer_full'] = 'Event flyer full must be uploaded.'; */ // not needed
      $rm['event_city'] = 'Event city must be set.';
      $rm['event_type'] = 'Event type must be set.';
      $rm['human_verification'] = 'Human verification incorrect.';

      d($_FILES);
//FORM VARS
      $fv = array();
      $fv['event_title'] = $_POST['event_title'];
      $fv['event_description'] = $_POST['event_description'];
      $fv['event_begin_date'] = $_POST['event_begin_date'];
      $fv['event_price'] = $_POST['event_price'];
      $fv['event_club_name'] = $_POST['event_club_name'];
      $fv['event_club_address'] = $_POST['event_club_address'];
      $fv['event_flyer'] = $_FILES['event_flyer'];
      /* $fv['event_flyer'] = $_POST['event_flyer']; */
      $fv['event_flyer_full'] = $_FILES['event_flyer_full'];
      /* $fv['event_flyer_full'] = $_POST['event_flyer_full']; */
      $fv['event_city'] = $_POST['event_city'];
      $fv['event_type'] = $_POST['event_type'];
      $fv['human_verification'] = $_POST['human_verification'];
      d($fv);

//php mailer variables
      $to = get_option('admin_email');
      $subject = "Someone submited a new event from " . get_bloginfo('name');
      $headers = 'From: ' . $email . "\r\n" .
              'Reply-To: ' . $email . "\r\n";


//FORM VALIDATION AND STANDARD FORMATS
      //event_title
      if (empty($fv['event_title'])) {
            add_event_form_error($rm['event_title']);
      }
      //event_description
      if (empty($fv['event_description'])) {
            add_event_form_error($rm['event_description']);
      }
      //event_begin_date
      if (empty($fv['event_begin_date'])) {
            add_event_form_error($rm['event_begin_date']);
      } else {
            $DateTime = date_create_from_format('d/m/Y H:i', $fv['event_begin_date']);
            if ($DateTime) {
                  $fv['event_begin_date'] = $DateTime->getTimestamp();
            } else {
                  add_event_form_error($rm['event_begin_date']);
            }
      }
      //event_price
      if (!is_numeric($_POST['event_price'])) {
            add_event_form_error($rm['event_price']);
      } else {
            $fv['event_price'] = (int) $fv['event_price'];
      }
      
      //event_club_name
      if (empty($fv['event_club_name'])) {
            add_event_form_error($rm['event_club_name']);
      }
      //event_club_address
      if (empty($fv['event_club_address'])) {
            add_event_form_error($rm['event_club_address']);
      }
      
      //event_flyer
      if (empty($fv['event_flyer']['size'])) {
            add_event_form_error($rm['event_flyer']);
      }
      //event_city
      if (!is_numeric($fv['event_city'])) {
            /* if (empty($fv['event_city'])) { */
            add_event_form_error($rm['event_city']);
      } else {
            $fv['event_city'] = (int) $fv['event_city'];
      }
      //event_type
      if (empty($fv['event_type'])) {
            add_event_form_error($rm['event_type']);
      }

      if ($fv['human_verification'] != 2) {
            add_event_form_error($rm['human_verification']);
      }
      d($fv);

      if (empty($error_response)) {
            //no form error
            $post = array(
                'post_title' => $fv['event_title'],
                'post_content' => $fv['event_description'],
                'post_type' => 'event',
                'post_status' => 'pending',
            );

            $event = wp_insert_post($post);

            if ($event) {
                  //event_images
                  $attach_id = insert_attachment('event_flyer', $event, '_thumbnail_id');
                  $attach_id = insert_attachment('event_flyer_full', $event, 'flyer_completo');

                  // event_begin_date
                  add_post_meta($event, 'begin_date', $fv['event_begin_date']);

                  add_post_meta($event, 'event_price', $fv['event_price']);
                  
                  add_post_meta($event, 'club_name', $fv['event_club_name']);
                  
                  add_post_meta($event, 'club_address', $fv['event_club_address']);

                  $term = wp_set_object_terms($event, $fv['event_city'], 'es_city_type');

                  add_post_meta($event, 'event_type', $fv['event_type']);
                  
                  //send email & redirect
                  $sent = wp_mail($to, $subject, strip_tags($message), $headers);
            } else {
                  //set form unknown error
            }
      }
}

function insert_attachment($file_handler, $post_id, $meta = 'false') {
      //for thumb $meta = _thumbnail_id
      // check to make sure its a successful upload
      if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK)
            __return_false();

      if (!function_exists('wp_generate_attachment_metadata')) {
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            require_once(ABSPATH . "wp-admin" . '/includes/file.php');
            require_once(ABSPATH . "wp-admin" . '/includes/media.php');
      }

      $attach_id = media_handle_upload($file_handler, $post_id);

      if ($meta)
            update_post_meta($post_id, $meta, $attach_id);
      return $attach_id;
}

?>