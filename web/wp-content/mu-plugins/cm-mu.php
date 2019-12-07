<?php
if ( defined( 'ERRORLOGFILE' ) ) {
    ini_set( 'error_log',ERRORLOGFILE );
}
include_once 'firephp/fb.php';

// ob_start(); 

/**
 * Set user image
 * move file to nz-user-images
 * create thumb using $size
 * create image metadata
 * return
 * 
 */
function nz_set_user_image( $id, $file, $size_name, $size ) {

      $user = ($id) ? get_user_by( 'id', $id ) : wp_get_current_user();

      $upload_dir = wp_upload_dir();

      wp_mkdir_p( $upload_dir[ 'basedir' ] . '/nz-user-images' );

      $destination = $upload_dir[ 'basedir' ] . '/nz-user-images/' . basename( $file );
      rename( $file, $destination );

      $resized = image_make_intermediate_size( $destination, $size[ 0 ], $size[ 1 ], true );
      /*d($resized);*/
      $resized[ 'src' ] = $destination;

      $user_images = unserialize( $user->get( '_nz_user_profile_images' ) );
      if ( isset( $user_images[ 'sizes' ][ $size_name ] ) ) {
            //delete sizes first
            unlink( $user_images[ 'sizes' ][ $size_name ][ 'src' ] );
            unlink( $upload_dir[ 'basedir' ] . '/nz-user-images/' . $user_images[ 'sizes' ][ $size_name ][ 'file' ] );
      }

      $user_images[ 'sizes' ][ $size_name ] = $resized;

      update_user_meta( $user->ID, '_nz_user_profile_images', serialize( $user_images ) );
}

/**
 * Get user image array
 */
function nz_get_user_images( $id = false ) {
      $user = ($id) ? get_user_by( 'id', $id ) : wp_get_current_user();
      if ( !$user ) {
            return false;
      }
      return unserialize( $user->get( '_nz_user_profile_images' ) );
}

/**
 * Get user image url
 */
function nz_get_user_image( $id = false, $size_name = 'profile', $default = '' ) {

      $user = ($id) ? get_user_by( 'id', $id ) : wp_get_current_user();

      if ( $user ) {

            $user_profile_images = unserialize( $user->get( '_nz_user_profile_images' ) );

            $dir = wp_upload_dir();
            $url = FALSE;

            if ( isset( $user_profile_images[ 'sizes' ][ $size_name ] ) ) {
                  $url = $dir[ 'baseurl' ] . '/nz-user-images/' . $user_profile_images[ 'sizes' ][ $size_name ][ 'file' ];
            }
            /* $url = apply_filters( 'nz_get_user_image_' . $size_name, $url ); */
            if ( empty( $url ) )
                  $url = $default;

            return $url;
      }
      return false;
}

/**
 *  GET USER AVATAR BY ID
 */
function get_avatar( $id, $size = 100, $default = false, $alt = 'clubber-mag-avatar' ) {
      $default = get_template_directory_uri() . '/assets/images/user/user-profile-ph.jpg';

      $url = nz_get_user_image( $id, 'profile', $default );

      /* d('AVATAR' , $url); */
      $my_avatar = "<img alt='" . $alt . "' src='" . $url . "' class='avatar avatar-" . $size . " photo' height='" . $size . "' width='" . $size . "' />";


      return $my_avatar;
}
