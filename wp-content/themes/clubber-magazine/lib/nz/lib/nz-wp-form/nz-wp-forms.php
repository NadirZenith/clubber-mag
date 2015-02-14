<?php

/* define( 'NZ_WP_FORMS_PATH', 'forms' ); */
define( 'NZ_WP_FORMS_PATH', 'lib/forms' );
require_once 'nzwpform-functions.php';
require_once 'Zebra_Form/Zebra_Form.php';
require_once 'nz-wp-form.php';
require_once 'login-register/plugin.php';

abstract class NZ_WP_Forms {

      static $isSubmit = false;
      static $isEdit = false;
      static $edit_query_var = "edit-id";

      function __construct() {
            
      }

      /**
       * return edit link
       */
      public static function link( $form_url = null, $post_id = null ) {

            if ( !$form_url || !$post_id )
                  return;

            return add_query_arg( array( self::$edit_query_var => $post_id ), $form_url );
      }

}

class NZ_WP_Forms_Handler extends NZ_WP_Forms {

      public $forms = array();
      public $wpform = null;
      public $isValid = null;
      public $isAjax = null;
      public $isSuccess = false;
      public $editId = 0;

      /**
       * init 
       * add action /filters /shortcode
       */
      public function __construct() {
            $this->isAjax = nz_is_ajax();
            /* add_action( 'init', array( $this, 'maybeProcessForm' ) ); */
            add_action( 'parse_request', array( $this, 'maybeProcessForm' ) );
            add_filter( 'query_vars', array( $this, '_add_used_vars' ) );
            add_shortcode( 'nz-wp-form', array( $this, 'shortcode' ) );
      }

      /**
       * catch form submission and process it apply filters(security)
       */
      public function maybeProcessForm( $query ) {
            /* $match = 'zebra_csrf_token_'; */
            $match = 'zebra_honeypot_';

            foreach ( array_keys( $_REQUEST ) as $key ) {
                  if ( $key === self::$edit_query_var ) {
                        self::$isEdit = TRUE;
                        $this->editId = ( int ) $_REQUEST[ self::$edit_query_var ];
                  } else if ( strpos( $key, $match ) !== FALSE ) {//submit (NEW|EDIT)
                        self::$isSubmit = TRUE;
                        $form_name = str_replace( $match, '', $key );
                  }
            }

            if ( self::$isSubmit ) {
                  $this->initForm( $form_name );

                  // submit callback
                  $this->doCallback( 'submit' );

                  if ( $this->validateForm() ) {
                        $this->isValid = true;

                        $this->wpform->processForm( $this->editId );

                        $tes = $this->doCallback( 'valid' );

                        //redirect
                        if ( $this->wpform->redirectTo ) {
                              if ( $this->isAjax ) {//&& $this->wpform->ajax
                                    wp_send_json_success( array( 'redirectTo' => $this->wpform->redirectTo ) );
                              } else {
                                    wp_safe_redirect( $this->wpform->redirectTo );
                              }
                        } elseif ( !empty( $this->wpform->confirmations ) ) {

                              if ( $this->isAjax ) {//&& $this->wpform->ajax
                                    wp_send_json_success( array( 'confirmations' => $this->wpform->confirmations ) );
                              } else {
                                    $this->wpform->addCallback( 'render', array( &$this, 'renderConfirmations' ) );
                              }
                        }
                  } else {//form is not valid
                        /* dd( $this ); */
                        if ( $this->isAjax ) {//&& $this->wpform->ajax
                              $html_form = $this->getHtmlForm();
                              wp_send_json_error( array( 'error_form' => $html_form ) );
                        }
                  }
            }
      }

      /**
       * Shortcode  
       */
      public function shortcode( $atts, $content ) {
            $this->initForm( $atts[ 'name' ] );

            $this->wpform->form->clientside_validation( $this->wpform->clientside_validation );

            return $this->getHtmlForm();
      }

      private function getHtmlForm( $scripts = true ) {
            $html_form = $this->wpform->form->render( '', true );

            $full = '<div id="nzwp-form-' . $this->wpform->form_name . '" class="nzwp-form-wraper">';
            // render callback
            $html_form = $this->doCallback( 'render', $html_form );

            if ( $scripts ) {

                  $js = '<script type="text/javascript"> $(function() {';

                  if ( $this->wpform->ajax ) {
                        $ajax_form = file_get_contents( __DIR__ . '/ajax_form.js' );

                        $js .= str_replace( '@form_name', $this->wpform->form_name, $ajax_form );
                  }

                  //initialize custom fields
                  $js .= '$(".nzwpform_imageupload").nzwpform_imageupload();';
                  $js .= '$(".nzwpform_relationTo").nzwpform_relationTo();';
                  $js .= '$(".nzSCField").nzSCField();';
                  $js .= '$(".nzGMField").nzGMField();';


                  $js .= '}); </script>';

                  $html_form .= $js;
            }

            return $full . $html_form . '</div>';
      }

      public function renderConfirmations( $html_form ) {

            $confirmations = '';
            foreach ( $this->wpform->confirmations as $confirmation ) {

                  $confirmations .= $confirmation;
            }


            return $confirmations;
      }

      /**
       * get form file
       */
      public function initForm( $form_name ) {

            if ( isset( $this->forms[ $form_name ] ) ) {
                  $this->wpform = $this->forms[ $form_name ];
                  return;
            }

            if ( !$filepath = locate_template( trailingslashit( NZ_WP_FORMS_PATH ) . $form_name . '.php' ) ) {
                  trigger_error( sprintf( __( 'Error locating form ' . $form_name, 'roots' ), $file ), E_USER_ERROR );
            }

            $wpform = require $filepath;

            $this->wpform = apply_filters( 'nzwp_forms_init_form_' . $form_name, $wpform );

            $this->wpform->isSubmit = self::$isSubmit;
            $this->wpform->isEdit = self::$isEdit;
            $this->wpform->postId = $this->editId;

            $this->maybeFillForm();

            $this->forms[ $form_name ] = $this->wpform;
      }

      /**
       * add used query var
       */
      public function _add_used_vars( $vars ) {
            $vars[] = self::$edit_query_var;

            return $vars;
      }

      /**
       * fill form if is edit
       */
      private function maybeFillForm() {
            if ( self::$isSubmit ) {
                  return;
            }
            if ( self::$isEdit ) {

                  $model_type = $this->wpform->get_object_type();
                  if ( $model_type == 'post' ) {
                        $model = get_post( $this->editId );

                        $owner = get_user_by( 'id', $model->post_author );
                        /* d( $owner->get( 'user_nicename' ) ); */

                        if ( $model && $model->post_type != $this->wpform->post_type ) {
                              $model = null;
                        }
                  } elseif ( $model_type == 'user' ) {
                        $model = get_user_by( 'id', $this->editId );
                  }

                  if ( $model ) {
                        $meta = get_metadata( $model_type, $this->editId );
                        $meta = apply_filters( 'nzwp_forms_fill_form_metadata_' . $this->wpform->form_name, $meta );

                        $this->wpform->fillForm( $model, $meta );
                        return;
                  } else {
                        global $wp_query;
                        $wp_query->set_404();
                        status_header( 404 );
                        nocache_headers();
                        include( get_query_template( '404' ) );
                        die();
                  }
            }
      }

      /**
       * Run a form callback      
       */
      private function doCallback( $type, $arg = NULL ) {
            if ( isset( $this->wpform->callbacks[ $type ] ) ) {
                  $callback = $this->wpform->callbacks[ $type ];

                  if ( is_array( $callback ) ) {
                        $callback = array( $callback[ 0 ], $callback[ 1 ] );
                  }
                  $arg = isset( $arg ) ? $arg : $this;

                  return (is_callable( $callback )) ?
                            call_user_func( $callback, $arg ) :
                            $arg;
            } else {
                  return $arg;
            }
      }

      /**
       * validate Form     
       */
      private function validateForm() {

            $valid = $this->wpform->form->validate();

            return $valid;
      }

      /**
       * return form from name
       */
      public static function getForm( $form_name, $path = null ) {
            /* d($form_name); */


            if ( !$filepath = locate_template( trailingslashit( NZ_WP_FORMS_PATH ) . $form_name . '.php' ) ) {
                  trigger_error( sprintf( __( 'Error locating form ' . $form_name, 'roots' ), $file ), E_USER_ERROR );
            }

            return require $filepath;
      }

}

new NZ_WP_Forms_Handler();

