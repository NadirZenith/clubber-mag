<?php

// ajax for logged in users
add_action( 'wp_ajax_nzwpform_image_upload', 'nzwpform_ajax_image_upload' );

//// ajax for not logged in users 
add_action( 'wp_ajax_nopriv_nzwpform_image_upload', 'nzwpform_ajax_image_upload' );

//ajax receive action
function nzwpform_ajax_image_upload() {

      $upload = wp_upload_dir();

      $mime_types = array( "image/jpg", "image/jpeg", "image/png" );
      $target_path = $upload[ 'basedir' ] . '/cache/preview/';
      $target_url = $upload[ 'baseurl' ] . '/cache/preview/';
      wp_mkdir_p( $target_path );
      $remove_these = array( ' ', '`', '"', '\'', '\\', '/' );
      $attachs = array();
      $upload_files_url = array();
      $i = 0;

      foreach ( $_FILES[ 'files' ][ 'name' ] as $key => $filename ) {
            $errors_founds = '';

            if ( $_FILES[ 'files' ][ 'error' ][ $key ] != UPLOAD_ERR_OK ) {

                  $errors_founds .= 'Error uploading the file! ' . $key . ' -> ' . $filename . '<br />';
            }

            if ( !in_array( trim( $_FILES[ 'files' ][ 'type' ][ $key ] ), $mime_types ) ) {

                  $errors_founds .= 'Invalid file type! ' . $key . ' -> ' . $filename . '<br />';
            }

            if ( $_FILES[ 'files' ][ 'size' ][ $key ] == 0 ) {

                  $errors_founds .= 'Image file it\'s empty! ' . $key . ' -> ' . $filename . '<br />';
            }
            /*
              if ( $_FILES[ 'files' ][ 'size' ][ $key ] > getMaximumFileUploadSize() ) {
              $errors_founds .= 'Image file to large, maximus size is 500Kb!<br />';
              }
             */
            if ( !is_uploaded_file( $_FILES[ 'files' ][ 'tmp_name' ][ $key ] ) ) {

                  $errors_founds .= 'Error uploading the file on the server! ' . $key . ' -> ' . $filename . '<br />';
            }

            if ( $errors_founds == '' ) {

                  //Sanitize the filename (See note below)
                  $newname = str_replace( $remove_these, '', $_FILES[ 'files' ][ 'name' ][ $key ] );

                  //Make the filename unique
                  $newname = time() . '-' . "$newname";

                  //Save the uploaded the file to another location
                  $upload_path = $target_path . $newname;
                  move_uploaded_file( $_FILES[ 'files' ][ 'tmp_name' ][ $key ], $upload_path );

                  $upload_files_url[ $target_path ] = $target_url . $newname;

                  //return image information hover ajax
                  $i++;
                  /* $attachs[ $i ][ 'src' ] = $target_url . "$newname"; */
                  /* $attachs[ $i ][ 'src' ] = $upload_files_url[ $target_path ]; */
                  $response = $upload_files_url[ $target_path ];
            }
      }
      if ( $errors_founds != '' ) {
            echo $errors_founds;
            wp_die();
      }

      wp_send_json( $response );
      die();
}

function getMaximumFileUploadSize2() {
      return min( convertPHPSizeToBytes( ini_get( 'post_max_size' ) ), convertPHPSizeToBytes( ini_get( 'upload_max_filesize' ) ) );
}

/**
 * custom rules
 */
function nz_is_json_object( $value ) {
      $value = trim( stripslashes( html_entity_decode( $value ) ) );

      return !is_null( json_decode( $value ) );
}

function nz_is_valid_soundcloud_uri( $value ) {
      /* return false; */
      return strpos( $value, 'soundcloud.com' ) !== false;
}


/**
 * Field functions
 */
function nz_getJsonKey($json){
      
}