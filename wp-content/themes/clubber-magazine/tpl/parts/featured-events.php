<?php
$now_timestamp = time();
$date = date( 'd/m/Y', $now_timestamp );
$posts_per_row = 5;
$args = array(
      'post_type' => 'agenda',
      'lang' => 'es, en',
      'posts_per_page' => $posts_per_row * 2,
      'order' => 'ASC',
      'orderby' => 'meta_value_num',
      'meta_key' => 'wpcf-event_begin_date',
      'meta_query' => array(
            'relation' => 'AND',
            array(
                  'key' => 'wpcf-event_featured',
                  'value' => 'on',
                  'compare' => '=',
            ),
            array(
                  'key' => 'wpcf-event_begin_date',
                  'value' => time(),
                  'type' => 'NUMERIC',
                  'compare' => '>='
            )
      )
);
$query = new WP_Query( $args );
?>
<section class="m5">

      <div class="mb5">
            <?php
            cm_home_list_title( 'agenda', __( 'Recommended parties and events', 'cm' ) );
            ?>
      </div>

      <div class="cb " id="featured-events-slider">
            <ul class="slides">
                  <?php
                  if ( $query->have_posts() ) {
                        $count = 0;
                        ?> 
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
                        <?php
                  } //end if have posts
                  ?>
                  <?php wp_reset_postdata(); ?>

            </ul>

      </div>

      <script type="text/javascript">
            jQuery(document).ready(function($) {

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
</section>