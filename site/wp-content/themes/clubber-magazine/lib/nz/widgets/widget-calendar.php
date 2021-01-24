<?php

class Calendar_Widget extends WP_Widget {
      /* -------------------------------------------------- */
      /* CONSTRUCT THE WIDGET
        /*-------------------------------------------------- */

      function Calendar_Widget() {
            /* Widget name and description */
            $widget_opts = array(
                  'classname' => 'calendar_widget',
                  'description' => __( 'Calendar widget.', 'clubber' )
            );
            $this->WP_Widget( 'calendar-widget', __( 'Calendar - widget', 'clubber' ), $widget_opts );
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
            echo $before_widget
            ;
            /* display title */
            if ( $title )
                  echo $before_title . $title . $after_title;
            /* display the widget */
            ?>

            <div id="calendar"></div>

            <?php
            /* d('agenda'); */
            $start_date = strtotime( "now" );

            $date = urldecode( get_query_var( 'date' ) );
            $DateTime = DateTime::createFromFormat( 'd-m-Y', $date );
            if ( $DateTime ) {
                  $DateTime->setTime( 0, 0, 0 ); //to avoid date problems
                  $start_date = $DateTime->getTimestamp();
            }
            ?>
            <script type="text/javascript">
                  function updateQueryStringParameter(uri, key, value) {
                        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
                        if (uri.match(re)) {
                              return uri.replace(re, '$1' + key + "=" + value + '$2');
                        }
                        else {
                              return uri + separator + key + "=" + value;
                        }
                  }
                  (function($) {
                        jQuery(document).ready(function($) {
                              var start_date = new Date('<?php echo date( 'r', $start_date ) ?>');
                              $('#calendar').fullCalendar({
                                    header: {
                                          left: '',
                                          center: 'title',
                                          right: 'prev,next'
                                    },
                                    firstDay: 1,
                                    dayClick: function(date, allDay, jsEvent, view) {
                                          var date_str = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
                                          var location = updateQueryStringParameter('<?php echo add_query_arg( NULL, NULL ); ?>', 'date', encodeURIComponent(date_str));
                                          window.location = location;
                                    },
                                    dayRender: function(date, cell) {
                                          if (date.getDate() === start_date.getDate()
                                                  && date.getMonth() === start_date.getMonth()) {
                                                cell.css("background-color", "#666");
                                          }
                                    },
                                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                                    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                              });
                              $('#calendar').fullCalendar('gotoDate', start_date);
                              $('.fc-button-prev span').click(function() {
                                    var date = $('#calendar').fullCalendar('prev').fullCalendar('getDate');
                                    var date_str = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
                                    var location = updateQueryStringParameter('<?php echo add_query_arg( NULL, NULL ); ?>', 'date', encodeURIComponent(date_str));
                                    window.location = location;
                                    /*alert('prev ' + date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear());*/
                                    return false;
                              });
                              $('.fc-button-next span').click(function() {
                                    var date = $('#calendar').fullCalendar('next').fullCalendar('getDate');
                                    var date_str = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
                                    var location = updateQueryStringParameter('<?php echo add_query_arg( NULL, NULL ); ?>', 'date', encodeURIComponent(date_str));
                                    window.location = location;
                                    /*                  alert('next ' + date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear());*/
                                    return false;
                              });


                        });
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
add_action( 'widgets_init', create_function( '', 'register_widget("Calendar_Widget");' ) );
?>