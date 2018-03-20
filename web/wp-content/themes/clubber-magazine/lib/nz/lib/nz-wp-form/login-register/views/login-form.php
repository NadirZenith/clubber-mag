<?php
/**
 * This is the template for our login form. It should contain as less logic as possible
 */
?>
<div class="login-container">
      <form action="" class="login_form">
            <div class="gform_fields">
                  <?php
                  wp_nonce_field( 'facebook-nonce', 'facebook_security' );
                  wp_nonce_field( 'login_submit', 'security' );
                  ?>

                  <div class="gfield">
                        <div class="ginput_container">
                              <label class="gfield_label"><?php _e( 'User Email', 'ajax_login_register' ); ?></label><br>
                              <input class="medium" type="text" name="user_email"  required />
                        </div>
                  </div>
                  <div class="gfield">
                        <div class="ginput_container">
                              <label class="gfield_label"><?php _e( 'Password', 'ajax_login_register' ); ?></label><br>
                              <input class="medium" type="password" name="password" required />
                        </div>
                  </div>

                  <div class="gfield">
                        <input type="checkbox" name="rememberme" />
                        <span class="meta"><?php _e( 'Keep me logged in', 'ajax_login_register' ); ?> </span>
                  </div>

                  <div class="button-container">
                        <input class="login_button" type="submit" value="<?php _e( 'Login', 'ajax_login_register' ); ?>" accesskey="p" name="submit" />
                        <div class="loading" style="height:5px;"></div>
                  </div>
                  <div class="ajax-login-register-status-container fr">
                        <div class="ajax-login-status-target">

                        </div>
                  </div>
            </div>
            <div id="social-login">
                  <ul>
                        <li>
                              <a href="#" class="fb-login">login with facebook</a>
                        </li>
                        <li id="status">
                        </li>
                  </ul>

            </div>
      </form>
      <script>
            jQuery(document).ready(function($) {
                  //ajax login
                  $(".login_form").submit(function(e) {
                        e.preventDefault();
                        var $form = $(this);
                        $loading = $form.find('.loading');
                        var loading = setInterval(function() {
                              $loading.toggleClass("x");
                        }, 100);
                        $.ajax({
                              data: "action=login_submit&" + $form.serialize(),
                              type: "POST",
                              url: ajaxurl,
                              success: function(msg) {
                                    console.log(arguments);
                                    window.clearInterval(loading);
                                    $loading.addClass("x").delay(1000).animate({opacity: 0}, 1000, function() {
                                          $loading.removeClass("x").css("opacity", "");
                                    });
                                    nz_ajax_login_msg($form, msg);
                              }
                        });
                  });

                  //fb login
                  $(document).on('click', '.fb-login', function(event) {
                        event.preventDefault();
                        var $form_obj = $(this).parents('form');


                        FB.login(function(response) {
                              if (response.authResponse.grantedScopes === "public_profile,email,contact_email") {
                                    FB.api('/me', function(response) {
                                          console.log(response);

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


            window.nz_ajax_login_msg = function(form_obj, data) {
                  /*console.log(data);*/
                  /*return;*/
                  if (typeof data !== undefined) {
                        if (data.status == 'success_login' || data.status == 'success_registration') {
                              window.location.replace(data.redirect);
                        } else {
                              $msg_display = jQuery('.ajax-login-status-target');
                              $msg_display.html(data.description).fadeIn('fast').delay(2000).fadeOut('slow');

                              return;
                        }
                  } else {
                        alert('empty data');
                  }
            };
      </script>
</div>
