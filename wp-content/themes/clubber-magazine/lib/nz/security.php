<?php

/*
 * NZ SECURITY FUNCTIONS
 */

/**
 * Show admin bar only for admin
 */
function nz_filter_show_admin_bar() {
      if ( current_user_can( 'administrator' ) ) {
            /* if (current_user_can('manage_options')) { */
            return true;
      }

      return false;
}

add_filter( 'show_admin_bar', 'nz_filter_show_admin_bar' );

// Removing front end admin bar because it's ugly
/* add_filter('show_admin_bar', '__return_false'); */

/**
 * block front end from not logged in users
 */
function nz_block_front_end() {

      // Current Page
      global $pagenow;
      // Check to see if user in not logged in and not on the login page
      if ( !is_user_logged_in() && $pagenow != 'wp-login.php' ) {
            // If user is, Redirect to Login form.
            auth_redirect();
      }
}

/* add_action('wp', 'nz_block_front_end'); */

/**
 * block back end from non admins
 */
function nz_block_backend() {

      if ( is_admin() && !current_user_can( 'administrator' ) &&
                !( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {

            wp_redirect( home_url() );

            exit;
      }
}

add_action( 'init', 'nz_block_backend' );
