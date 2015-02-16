<?php

class Relate_Widget extends WP_Widget {
      /* -------------------------------------------------- */
      /* CONSTRUCT THE WIDGET
        /*-------------------------------------------------- */

      function Relate_Widget() {
            /* Widget name and description */
            $widget_opts = array(
                  'classname' => 'test_widget',
                  'description' => __( 'Test your Widget.', 'clubber' )
            );
            $this->WP_Widget( 'relate-widget', __( 'relate - widget', 'clubber' ), $widget_opts );
      }

      /* -------------------------------------------------- */
      /* DISPLAY THE WIDGET
        /*-------------------------------------------------- */
      /* outputs the content of the widget
       * @args --> The array of form elements */

      function widget( $args, $instance ) {
            extract( $args, EXTR_SKIP );
            $title = apply_filters( 'widget_title', $instance[ 'title' ] );
            /* before widget */
            echo $before_widget;
            /* display title */
            if ( $title )
                  echo $before_title . $title . $after_title;
            /* display the widget */
            ?>


            <?php
            $from = get_queried_object_id();
            $to = (is_user_logged_in()) ? get_current_user_id() : false;
            $relation_type = 'events_to_users';
            $relation = p2p_type( $relation_type );
            $p2p_id = $relation->get_p2p_id( $from, $to );
            if ( $p2p_id ) {
                  // connection exists
                  $class = 'relation-active';
                  $name = __( 'Asistiré', 'cm' );
            } else {
                  // connection doesn't exist
                  $class = '';
                  $name = __( 'Me apunto!', 'cm' );
            }

            $users = get_users( array(
                  'connected_type' => $relation_type,
                  'connected_items' => $from
                      ) );
            if ( empty( $users ) ) {
                  $total = 0;
                  $total_style = 'style="visibility:hidden"';
            } else {

                  $total = count( $users );
                  $total_style = '';
            }
            ?>
            <div class="h3 tc ibox-5" >
                  <span class="cm-title3">
                        <?php _e( 'Participa y Compártelo', 'cm' ); ?>
                  </span>
            </div>

            <div class="cm-relation" id="cm-relation-<?php echo $relation_type ?>">

                  <a class="relate-btn sc-2 <?php echo $class ?>" title="<?php _e( 'participar', 'cm' ) ?>" >
                        <span class="r-icon"></span>
                        <span class="r-text"><?php echo $name ?></span>
                  </a>

                  <a class="view-relation-btn" title="<?php _e( 'Participantes', 'cm' ) ?>" href="#<?php echo 'participantes' ?>" <?php echo $total_style ?>>
                        <span class="r-count"><?php echo $total ?></span>
                  </a>
                  <div class="loading" style="height:3px;"></div>
            </div>
            <div class="group mt10 pb10" >
                  <div class="col-1-2 fl oh">
                        <div class="pl30">
                              <?php echo nz_fb_like(); ?>
                        </div>
                  </div>
                  <div class="col-1-2 fl">
                        <div class="mt3 pl30">
                              <?php echo nz_fb_sharer(); ?>
                        </div>
                  </div>
            </div>
            <div class="group mt10 pb10" >
                  <div class="col-1-2 fl oh">
                        <div class="pl30">
                              <!-- Posicione esta tag no cabeçalho ou imediatamente antes da tag de fechamento do corpo. -->
                              <script src="https://apis.google.com/js/platform.js" async defer>
                                    {
                                          lang: 'es-ES'
                                    }
                              </script>

                              <div class="g-plusone" data-annotation="inline" data-width="300"></div>
                        </div>
                  </div>
                  <div class="col-1-2 fl">
                        <div class="mt3 pl30">
                              <?php nz_tt_tweet(); ?>
                        </div>
                  </div>
            </div>

            <script type="text/javascript">
                  (function($) {

                        jQuery(document).ready(function($) {

                              var NZRelation = function(relation_type, from, to) {

                                    var $nzr = $('#cm-relation-' + relation_type);

                                    var $btnRelate = $nzr.find('.relate-btn');
                                    var text = $btnRelate.find('.r-text');

                                    var $btnRelation = $nzr.find('.view-relation-btn');
                                    var $count = $btnRelation.find('.r-count');
                                    var value = function() {
                                          return parseInt($count.text());
                                    };
                                    var $loading = $nzr.find('.loading'),
                                            loading = false;

                                    var settings = {
                                          type: relation_type,
                                          from: from,
                                          to: to,
                                          textRelated: '<?php _e( 'Assistiré!', 'cm' ) ?>',
                                          textUnRelated: '<?php _e( 'Me apunto!', 'cm' ); ?>',
                                          textFail: '<?php _e( 'Intente más tarde!', 'cm' ); ?>',
                                          nonce: '<?php echo wp_create_nonce( $relation_type . $to ) ?>'
                                    };

                                    $btnRelate.on('click', nzr_relate);
                                    $btnRelation.on('click', nzr_get_relation);

                                    function nzr_relate(e) {
                                          e.preventDefault();
                                          if (loading)
                                                return;

                                          setLoading();

                                          var state = $btnRelate.hasClass('relation-active') ? 1 : 0;

                                          var data = {
                                                action: 'cm_relate',
                                                from: settings.from,
                                                state: state,
                                                type: settings.type,
                                                _wpnonce: settings.nonce
                                          };
                                          $.get(ajaxurl, data)
                                                  .done(function(data) {
                                                        var newvalue = value();
                                                        if (data.state) {
                                                              text.html(settings.textUnRelated);
                                                              $btnRelate.removeClass('relation-active');
                                                              newvalue = newvalue - 1;

                                                        } else {
                                                              text.html(settings.textRelated);
                                                              $btnRelate.addClass('relation-active');
                                                              newvalue = newvalue + 1;
                                                        }
                                                        if (newvalue < 1) {
                                                              $btnRelation.css('visibility', 'hidden');
                                                        } else {
                                                              $btnRelation.css('visibility', 'visible');
                                                        }
                                                        $count.html(newvalue);
                                                  })
                                                  .fail(ajaxFail)
                                                  .always(ajaxAlways);

                                    }
                                    ;

                                    function nzr_get_relation(e) {
                                          e.preventDefault();
                                          if (loading)
                                                return;
                                          setLoading();

                                          var data = {
                                                action: 'cm_get_relation',
                                                type: settings.type,
                                                from: settings.from,
                                                _wpnonce: settings.nonce

                                          };
                                          $.get(ajaxurl, data)
                                                  .done(function(response) {
                                                        if (response.result === 1) {

                                                              $.fancybox.open({
                                                                    autoSize: false,
                                                                    height: 'auto',
                                                                    content: response.content,
                                                              });
                                                        }
                                                  })
                                                  .fail(ajaxFail)
                                                  .always(ajaxAlways);

                                    }
                                    function setLoading() {
                                          loading = setInterval(function() {
                                                $loading.toggleClass("x");
                                          }, 100);
                                    }
                                    function ajaxFail(xhr) {
                                          var data = settings.textFail;
                                          if (xhr.status === 403) {
                                                data = xhr.responseText;
                                          }
                                          $.fancybox.open([
                                                {
                                                      content: data,
                                                }
                                          ]);
                                    }
                                    function ajaxAlways() {
                                          //loading stop
                                          window.clearInterval(loading);
                                          $loading.addClass("x").delay(1000).animate({opacity: 0}, 1000, function() {
                                                $loading.removeClass("x").css("opacity", "");
                                                loading = false;
                                          });
                                    }
                              }

                              new NZRelation('<?php echo $relation_type ?>', '<?php echo $from ?>', '<?php echo $to ?>');

                        })
                  })(jQuery);

            </script>

            <?php
            /* after widget */
            echo $after_widget;
      }

      /* -------------------------------------------------- */
      /* UPDATE THE WIDGET
        /*-------------------------------------------------- */

      function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
            $instance[ 'soundcloud_api' ] = strip_tags( $new_instance[ 'soundcloud_api' ] );
            /*
             */
            return $instance;
      }

      /* -------------------------------------------------- */
      /* WIDGET ADMIN FORM
        /*-------------------------------------------------- */
      /* @instance	The array of keys and values for the widget. */

      function form( $instance ) {
            $instance = wp_parse_args( ( array ) $instance, array(
                  'title' => 'test',
                  'soundcloud_api' => null
                      ) );
            // Display the admin form
            ?>
            <p>
                  <label for="<?php
                  echo $this->get_field_id( 'title' );
                  ?>"><?php
                               _e( 'Title:', 'clubber' );
                               ?></label>
                  <input type="text" class="widefat" id="<?php
                         echo $this->get_field_id( 'title' );
                         ?>" name="<?php
                         echo $this->get_field_name( 'title' );
                         ?>" value="<?php
                         echo $instance[ 'title' ];
                         ?>" />
            </p>


            <?php
      }

// end form
}

// end class
add_action( 'widgets_init', create_function( '', 'register_widget("Relate_Widget");' ) );
?>