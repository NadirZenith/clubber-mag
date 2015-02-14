<script>
      var CMP = function(options) {
            var
                    $body = $("body"),
                    settings = {
                          /*afterLocate: null,*/
                          callback: function(now, total) {
                                console.log('now ' + now);
                                console.log('total ' + total);
                                console.log('options ', options);

                          },
                          total: options.offsetStart - options.offsetEnd
                    };

            $.extend(settings, options);

            $(window).scroll(onScroll);

            function onScroll(e) {
                  var body_height = $body.outerHeight(true); //2409
                  /*console.log('body_height', body_height);*/

                  var scrollTop = $(window).scrollTop();// 0 -> ...
                  /*console.log('scrollTop', scrollTop);*/

                  var window_height = $(window).height();
                  /*console.log('window_height', window_height);*/


                  var current_position = window_height + scrollTop - 30; // +-600 ++ max 2409
                  /*console.log('current_position', current_position);*/

                  var px_left = body_height - current_position;// px left to touch bottom

                  if (undefined !== settings.offsetStart
                          && undefined !== settings.offsetEnd) {


                        if (px_left < settings.offsetStart && px_left > settings.offsetEnd) {
                              var now = settings.offsetStart - px_left;
                        } else if (px_left < settings.offsetStart) {
                              var now = settings.total;
                        } else if (px_left > settings.offsetEnd) {
                              var now = 0;
                        }

                        if (typeof settings.callback === 'function') {
                              settings.callback(now, settings.total);
                        }
                  } else {
                        console.log('start end');
                  }

            }


            return {
                  /*                        
                   load: load,
                   * */
            };
      };
      $(function() {
            /* 
             * bottom position
             * */
            new CMP({
                  offsetStart: 300,
                  offsetEnd: 170,
                  callback: function(now, total) {
                        var
                                $obj = $('#footer-parallax'),
                                start = 320,
                                end = 10,
                                gap = start - end,
                                pos = gap * now / total,
                                move = start - pos;
                        $obj.css('bottom', move);
                  }
            });
            /* 
             * decrease with
             * */
            new CMP({
                  offsetStart: 300,
                  offsetEnd: 30,
                  callback: function(now, total) {
                        var
                                $img = $('#footer-parallax img'),
                                start = 80,
                                end = 12,
                                gap = start - end,
                                pos = gap * now / total,
                                move = start - pos;

                        $img.css('width', move + '%');
                  }
            });

            /* 
             * decrease margin right
             * */
            new CMP({
                  offsetStart: 200,
                  offsetEnd: 30,
                  callback: function(now, total) {
                        var
                                $obj = $('#footer-parallax img'),
                                start = 20,
                                end = 3,
                                gap = start - end,
                                pos = gap * now / total,
                                move = start - pos;
                        $obj.css('margin-right', move + '%');
                  }
            });
            /*
             cm_logo_resize2 = new CMP({
             start: 300,
             end: 30,
             callback3: function(now, total) {
             var
             $img = $('#footer-parallax img'),
             start = 50,
             //end = 15,
             end = 12,
             gap = start - end,
             pos = gap * now / total,
             move = start - pos;
             
             $img.css('width', move + '%');
             },
             callback2: function(now, total) {
             var
             $img = $('#footer-parallax img'),
             start = 50,
             //end = 15,
             end = 12,
             gap = start - end,
             pos = gap * now / total,
             move = start - pos;
             
             $img.css('width', move + '%');
             }
             });
             */

            /*
             */
      });
</script>

<?php
if (
          class_exists( 'WPSEO_Breadcrumbs' ) && !is_home() && !is_front_page()
 ) {
      WPSEO_Breadcrumbs::breadcrumb( '<div id="breadcrumbs" class="group ml30">', '</div>', true );
}
?>
<div  class="nzparallax parallax" id="footer-parallax" >
      <img class="" src="http://lab.dev/clubber-mag-dev/wp-content/themes/clubber-magazine/assets/css/img/logo-footer2.png" />
</div>
<nav id="footer-menu" class="group pb15 pr" style="z-index:20;">
      <?php
      $footer_menu = get_transient( 'footer_menu_html' );
      if ( !$footer_menu ) {
            $footer_menu = wp_nav_menu( array(
                  'theme_location' => 'footer',
                  'echo' => FALSE
                      ) );
            set_transient( 'footer_menu_html', $footer_menu, 60 * 15 );
      }
      //echo $footer_menu;

      wp_nav_menu( array(
            'theme_location' => 'footer'
      ) );
      ?>
</nav>
<div class="back-to-top">
      <a href="#header"><?php echo __( 'Back to Top', 'cm' ); ?></a>
</div>