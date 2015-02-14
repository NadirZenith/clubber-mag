<?php

/**
 * This is file is responsible for custom logic needed by all templates. NO
 * admin code should be placed in this file.
 */
Class NZ_Register Extends NzAjaxAuth {

      public $form_name = null;
      public $ajax = true;

      /**
       * Run the following methods when this class is loaded
       */
      public function __construct( $form_name, $ajax = false ) {
            $this->form_name = $form_name;
            add_action( 'init', array( &$this, 'initRegister' ) );

            $this->ajax = $ajax;
      }

      /**
       * During WordPress' init load various methods.
       */
      public function initRegister() {
            if ( $this->ajax ) {

                  add_action( 'wp_ajax_nopriv_register_submit', array( &$this, 'register_submit' ) );
                  add_action( 'wp_ajax_register_submit', array( &$this, 'register_submit' ) );
            }

            add_shortcode( 'nzwp_forms_register', array( &$this, 'register_shortcode' ) );
            add_filter( 'nzwp_forms_init_form_' . $this->form_name, array( &$this, 'setCallbacks' ) );
      }

      /**
       * if is register form set user validation callback
       */
      public function setCallbacks( $nzform ) {

            $nzform->form->csrf( false );
            $nzform->auto_process = false;
            $nzform->form->add( 'hidden', 'nz_register', wp_create_nonce( 'nz-register' ) );
            $nzform->addCallback( 'valid', array( &$this, 'register_submit' ) );

            return $nzform;
      }

      /**
       * Load the register shortcode
       */
      public function register_shortcode() {
            /* d($this->form_name); */
            $html_form = do_shortcode( "[nz-wp-form name={$this->form_name}]" );

            return $html_form; // . $this->ajax_register_script();
      }

      public function register_submit( $formHandler ) {
            $errors = array();
            $RegisterForm = $formHandler->wpform;

            $form = $RegisterForm->form;

            $nonce = $form->controls[ 'nz_register' ]->submitted_value;
            if ( !wp_verify_nonce( $nonce, 'nz-register' ) ) {
                  die( 'Security check' );
            }

            $register_user = array(
                  'login' => $form->controls[ 'register_username' ]->submitted_value,
                  'email' => $form->controls[ 'register_email' ]->submitted_value,
                  'password' => $form->controls[ 'register_password' ]->submitted_value,
            );


            $user_id = wp_create_user( $register_user[ 'login' ], $register_user[ 'password' ], $register_user[ 'email' ] );

            /* d( '$user_id', $user_id ); */
            if ( !is_wp_error( $user_id ) ) {

                  update_user_meta( $user_id, 'show_admin_bar_front', 'false' );
                  /* update_user_meta( $user_id, 'fb_id', $user[ 'fb_id' ] ); */


                  wp_update_user( array( 'ID' => $user_id, 'role' => 'subscriber' ) );
                  $user = wp_signon( array( 'user_login' => $register_user[ 'login' ], 'user_password' => $register_user[ 'password' ], 'remember' => true ), false );
                  if ( !is_wp_error( $user ) ) {
                        wp_set_current_user( $user->ID );
                        wp_set_auth_cookie( $user->ID, false ); //if is admin??

                        $success = array(
                              'description' => __( 'Success Registration', 'ajax_login_register' ),
                              'redirect_url' => get_author_posts_url( get_current_user_id() ),
                        );
                  }
            } else {
                  foreach ( $user_id->errors as $error ) {
                        foreach ( $error as $err ) {
                              $errors[] = $err;
                        }
                  }
                  /* $errors[] = __( 'Invalid Username', 'ajax_login_register' ); */
            }
            /*
              if ( !email_exists( $register_user[ 'email' ] ) ) {
              } else {
              $errors[] = __( 'Invalid Email', 'ajax_login_register' );
              }
             */


            if ( nz_is_ajax() ) {//json
                  if ( empty( $errors ) ) {//SUCCESS
                        new NzAjaxResponse( $success[ 'description' ], null, $success[ 'redirect_url' ] );
                  } else {
                        new NzAjaxResponse( $error, null, null, 200 );
                  }
            } else {//html
                  if ( empty( $errors ) ) {//SUCCESS
                        wp_redirect( $success[ 'redirect_url' ] );
                        exit();
                  } else {
                        foreach ( $errors as $error ) {
                              $form->add_error( 'error', $error );
                        }
                  }
            }
      }

      // Create Facebook User
      //
    public function create_facebook_user( $user = array() ) {

            $user[ 'user_pass' ] = wp_generate_password();
            $user[ 'user_registered' ] = date( 'Y-m-d H:i:s' );
            $user[ 'role' ] = "subscriber";

            $user_id = wp_insert_user( $user );

            if ( is_wp_error( $user_id ) ) {
                  return $user_id;
            } else {
                  // Store random password as user meta
                  $meta_id = add_user_meta( $user_id, '_random', $user[ 'user_pass' ] );

                  // Setup this user if this is Multisite/Networking
                  if ( is_multisite() ) {
                        $this->multisite_setup( $user_id );
                  }
            }

            return get_user_by( 'id', $user_id );
      }

}

new NZ_Register( 'register_form' );
