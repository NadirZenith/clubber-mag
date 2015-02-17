<?php

/**
 * This is file is responsible for custom logic needed by all templates. NO
 * admin code should be placed in this file.
 */
Class NZ_Login {

      public $form_name = null;
      public $ajax = false;

      public function __construct( $form_name ) {

            $this->form_name = $form_name;

            add_action( 'init', array( &$this, 'init' ) );
      }

      public function init() {
            // add_action( 'wp_ajax_login_submit', array( &$this, 'login_submit' ) );
            // add_action( 'wp_ajax_nopriv_login_submit', array( &$this, 'login_submit' ) );
            add_filter( 'nzwp_forms_init_form_' . $this->form_name, array( &$this, 'setCallbacks' ) );
            add_shortcode( 'nzwp_forms_login', array( &$this, 'login_shortcode' ) );

            /* add_action( 'wp_ajax_facebook_login', array( &$this, 'facebook_login' ) ); */
            /* add_action( 'wp_ajax_nopriv_facebook_login', array( &$this, 'facebook_login' ) ); */
      }

      public function setCallbacks( $nzform ) {

            $nzform->form->csrf( false );
            $nzform->auto_process = false;

            $nzform->form->add( 'hidden', 'nz_login', wp_create_nonce( 'nz-login' ) );
            $nzform->addCallback( 'valid', array( &$this, 'login_submit' ) );

            return $nzform;
      }

      public function login_submit( $formHandler ) {
            $error = false;

            $LoginForm = $formHandler->wpform;

            $form = $LoginForm->form;

            $nonce = $form->controls[ 'nz_login' ]->submitted_value;
            if ( !wp_verify_nonce( $nonce, 'nz-login' ) ) {
                  die( 'Security check' );
            }

            f( $form );
            $login_creds = array(
                  'user_email' => $form->controls[ 'login-email' ]->submitted_value,
                  'user_password' => $form->controls[ 'login-password' ]->submitted_value,
                  'remember' => $form->controls[ 'remember_1' ]->submitted_value
            );
            $real_user = get_user_by( 'email', $login_creds[ 'user_email' ] );

            if ( isset( $real_user, $real_user->user_login, $real_user->user_status ) && 0 === ( int ) $real_user->user_status ) {
                  $login_creds[ 'user_login' ] = $real_user->user_login;

                  $user = wp_signon( $login_creds, true );
                  if ( !is_wp_error( $user ) ) {
                        wp_set_current_user( $user->ID );
                        wp_set_auth_cookie( $user->ID, $login_creds[ 'remember' ] ); //if is admin??

                        $success = array(
                              'description' => __( 'Login complete', 'ajax_login_register' ),
                              'redirect' => true,
                              'url' => get_author_posts_url( get_current_user_id() ),
                        );
                  } else {
                        /*
                         * wp error return recover pass url link
                         * cant apply lostpassword_url filter
                          foreach ( $user->errors as $errors ) {
                          d( $errors );
                          foreach ( $errors as $err ) {
                          $error = $err;
                          }
                          }
                         */

                        $error = __( 'Invalid credentials.', 'ajax_login_register' );
                  }
            } else {
                  $error = __( 'User does not exist or is inactive', 'ajax_login_register' );
            }
            /*
              if ( !empty( $real_user ) ) {
              } else {
              $error = __( 'Invalid credentials', 'ajax_login_register' );
              }
             */



            if ( nz_is_ajax() ) {//json
                  if ( FALSE === $error ) {//SUCCESS
                        new NzAjaxResponse( $success[ 'description' ], null, $success[ 'url' ] );

                        /* wp_send_json_success( $success ); */
                  } else {
                        new NzAjaxResponse( $error, null, null, 400 );
                  }
            } else {//html
                  if ( FALSE === $error ) {//SUCCESS
                        wp_redirect( $success[ 'url' ] );
                        exit();
                  } else {
                        $form->add_error( 'error', $error );
                  }
            }
      }

      public function facebook_login() {

            check_ajax_referer( 'facebook-nonce', 'security' );

            // Map our FB response fields to the correct user fields as found in wp_update_user
            $fb_creds = array(
                  'username' => sanitize_text_field( $_POST[ 'fb_response' ][ 'id' ] ),
                  'user_login' => sanitize_text_field( $_POST[ 'fb_response' ][ 'id' ] ),
                  'first_name' => sanitize_text_field( $_POST[ 'fb_response' ][ 'first_name' ] ),
                  'last_name' => sanitize_text_field( $_POST[ 'fb_response' ][ 'last_name' ] ),
                  'user_email' => sanitize_email( $_POST[ 'fb_response' ][ 'email' ] ),
                  'user_url' => sanitize_text_field( $_POST[ 'fb_response' ][ 'link' ] ),
            );

            f( $fb_creds );
            //wp_send_json( $fb_creds );

            if ( !empty( $fb_creds[ 'username' ] ) ) {
                  $real_user = get_user_by( 'email', $fb_creds[ 'user_email' ] );
                  f( 'has username' );

                  if ( FALSE == $real_user ) {//create user
                        f( 'create user' );
                        $new_user[ 'user_pass' ] = wp_generate_password();
                        $new_user[ 'user_registered' ] = date( 'Y-m-d H:i:s' );
                        $new_user[ 'role' ] = "subscriber";

                        $user_id = wp_insert_user( $new_user );

                        if ( !is_wp_error( $user_id ) ) {
                              $real_user = get_user_by( 'id', $user_id );
                        } else {
                              wp_send_json( $this->status( 'user_creation_error' ) );
                        }
                  }
                  if ( $real_user ) {
                        f( 'login' );
                        wp_clear_auth_cookie();
                        wp_set_current_user( $real_user->ID );
                        wp_set_auth_cookie( $real_user->ID );

                        $status = $this->status( 'success_login' );
                  } else {
                        f( 'login fail' );
                  }
            } else {
                  $status = $this->status( 'invalid_credentials', 4, 'empty username' );
            }

            wp_send_json( $status );
      }

      public function login_shortcode() {
            $html_form = do_shortcode( "[nz-wp-form name={$this->form_name}]" );
            /*
              if ( $this->ajax ) {
              $html_form .= $this->ajax_login_script();
              }
             */
            return $html_form;
      }

      public function lostpasswordUrl() {
            d( 'passei' );
            return the_permalink();
      }

      public function ajax_login_script() {

            ob_start();
            ?>
            <script>
                  jQuery(document).ready(function($) {

                        ;
                        (function($, window, document, undefined) {

                              var pluginName = "nzwpajaxlogin",
                                      dataKey = "plugin_" + pluginName;

                              var Plugin = function(element, options) {

                                    this.$el = $(element);
                                    var self = this;
                                    this.options = {
                                          submitting: false,
                                          onError: function($form, message) {
                                                self.onError($form, message);
                                          },
                                          onSubmit: function($form) {
                                                self.onSubmit($form);

                                          },
                                          onSuccess: function($form, json) {
                                                self.onSuccess($form, json);

                                          },
                                          onFinish: function($form, json) {
                                                self.onFinish($form, json);

                                          },
                                    };

                                    this.init(options);
                              };

                              Plugin.prototype = {
                                    init: function(options) {
                                          $.extend(this.options, options);

                                          var self = this;
                                          var $loading = $('<div></div>').attr({class: 'loading', style: 'height:5px'});
                                          this.$el.append($loading);

                                          this.$el.submit(function(e) {
                                                e.preventDefault();
                                                if (self.$el.find('.error').length) {
                                                      return false;
                                                }
                                                self.options.onSubmit.call(self, self.$el);


                                                /*self.$el.data('Zebra_Form').attach_tip(self.$el.find('#password'), 'message');*/
                                                self.submit();
                                                /*alert(this);*/
                                          });
                                    },
                                    submit: function() {
                                          var self = this;
                                          $.ajax({
                                                data: this.$el.serialize(),
                                                /*data: "action=login_submit&" + this.$el.serialize(),*/
                                                type: "POST",
                                                url: window.ajaxurl,
                                                success: function(json) {
                                                      console.log(json);
                                                      self.options.onFinish.call(self, self.$el, json);

                                                      if (json['success'] == true) {
                                                            self.options.onSuccess.call(self, self.$el, json);

                                                      } else {
                                                            self.options.onError.call(self, self.$el, json['message']);
                                                      }

                                                }
                                          });
                                    },
                                    onSubmit: function($form) {
                                          console.log('submit', $form);
                                          var $loading = $form.find('.loading');
                                          this.options.submitting = setInterval(function() {
                                                $loading.toggleClass("x");
                                          }, 100);
                                    },
                                    onSuccess: function($form, json) {
                                          console.log('success', this);
                                          if (json['redirect']) {
                                                window.location.replace(json['url']);
                                          } else {
                                                alert(json['message']);
                                          }
                                    },
                                    onError: function($form, message) {
                                          console.log('error', this);
                                          var $ZF = $form.data('Zebra_Form');
                                          $ZF.attach_tip($form.find('#password'), message);

                                    },
                                    onFinish: function($form, json) {
                                          console.log('finish', $form);
                                          var $loading = $form.find('.loading');
                                          window.clearInterval(this.options.submitting);
                                          $loading.addClass("x").delay(1000).animate({opacity: 0}, 1000, function() {
                                                $loading.removeClass("x").css("opacity", "");
                                          });
                                    },
                              };


                              /*
                               * Plugin wrapper, preventing against multiple instantiations and
                               * return plugin instance.
                               */
                              $.fn[pluginName] = function(options) {

                                    var plugin = this.data(dataKey);

                                    // has plugin instantiated ?
                                    if (plugin instanceof Plugin) {
                                          // if have options arguments, call plugin.init() again
                                          if (typeof options !== 'undefined') {
                                                plugin.init(options);
                                          }
                                    } else {
                                          plugin = new Plugin(this, options);
                                          this.data(dataKey, plugin);
                                    }

                                    return plugin;
                              };


                        }(jQuery, window, document));
                        $("#<?php echo $this->form_name ?>").nzwpajaxlogin();


                        //fb login
                        $(document).on('click', '.fb-login', function(event) {
                              event.preventDefault();
                              var $form_obj = $(this).parents('form');


                              FB.login(function(response) {
                                    if (response.authResponse.grantedScopes === "public_profile,email,contact_email") {
                                          FB.api('/me', function(response) {
                                                /*console.log(response);*/

                                                /*var fb_response = response;*/
                                                $.ajax({
                                                      data: {
                                                            action: "facebook_login",
                                                            fb_response: response,
                                                            security: $('#facebook_security').val()
                                                      },
                                                      global: false,
                                                      type: "POST",
                                                      url: ajaxurl,
                                                      success: function(data) {
                                                            nz_ajax_login_msg($form_obj, data);
                                                      }
                                                });
                                          });

                                    } else {
                                          console.log('User canceled login or did not fully authorize.');
                                    }
                              },
                                      {
                                            scope: 'email',
                                            return_scopes: true
                                      });


                        });


                  });//onload

            </script>
            <?php
            $scripts = ob_get_clean();

            return $scripts;
      }

}

new NZ_Login( 'login_form' );


if ( !function_exists( 'nz_is_ajax' ) ) {

      function nz_is_ajax() {
            $headers = apache_request_headers();
            return (isset( $headers[ 'X-Requested-With' ] ) && $headers[ 'X-Requested-With' ] == 'XMLHttpRequest');
      }

}
