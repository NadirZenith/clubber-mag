<?php

class Share_Widget extends WP_Widget {
      /* -------------------------------------------------- */
      /* CONSTRUCT THE WIDGET
        /*-------------------------------------------------- */

      function Share_Widget() {
            /* Widget name and description */
            $widget_opts = array(
                  'classname' => 'test_widget',
                  'description' => __( 'Test your Widget.', 'clubber' )
            );
            $this->WP_Widget( 'share-widget', __( 'share - widget', 'clubber' ), $widget_opts );
      }

      /* -------------------------------------------------- */
      /* DISPLAY THE WIDGET
        /*-------------------------------------------------- */
      /* outputs the content of the widget
       * @args --> The array of form elements */

      function widget( $args, $instance ) {
            extract( $args, EXTR_SKIP );
            $title = apply_filters( 'widget_title', $instance[ 'title' ] );
            echo $before_widget;
            if ( $title )
                  echo $before_title . $title . $after_title;
            /* display the widget */
            ?>

            <div class="h3 tc ibox-5 mt30" >
                  <span class="cm-title3">
                        <?php _e( 'Share this', 'cm' ) ?>
                  </span>
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
add_action( 'widgets_init', create_function( '', 'register_widget("Share_Widget");' ) );
?>