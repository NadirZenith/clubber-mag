<?php
$query = new WP_Query( 'cm_get_featured_events' );
if ( $query->have_posts() ) {
      $posts_per_row = 5;
      $count = 0;
      ?> 
      <div class="cb " id="featured-events-slider">
            <ul class="slides">
                  <li>
                        <ul>
                              <?php
                              while ( $query->have_posts() ) {
                                    $query->the_post();
                                    if ( $count == $posts_per_row ) {
                                          ?>
                                    </ul>
                              </li>
                              <li>
                                    <ul>
                                          <?php
                                    }
                                    ?>
                                    <li class="col-1 col-sm-1-2 col-lg-1-5 fl">
                                          <div class="box-3">
                                                <?php
                                                get_template_part( 'tpl/home/list-2' );
                                                ?>
                                          </div>
                                    </li>
                                    <?php
                                    $count +=1;
                              } //END while
                              ?>
                        </ul>
                  </li>
            </ul>
      </div>
      <?php
} //end if have posts
wp_reset_postdata();
?>

<script type="text/javascript">

      $(function() {
            $('#featured-events-slider').flexslider({
                  animation: "slide",
                  slideshowSpeed: 5000,
                  controlNav: false,
                  directionNav: false,
                  pauseOnHover: false,
                  direction: "horizontal",
                  reverse: false,
                  animationSpeed: 500,
                  prevText: "&lt;",
                  nextText: "&gt;",
                  easing: "linear",
                  slideshow: true,
                  useCSS: false
            });
      });

</script>