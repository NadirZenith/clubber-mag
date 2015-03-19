<section class="m5">
      <div class="mb5">
            <?php
            cm_home_list_title( 'into-the-beat', __( 'Into the Beat Radio', 'cm' ) );
            ?>
      </div>
      <div class="group">
            <div class="home-clubbermag-podcasts oh" >

                  <ul class="slides">
                        <?php
                        $args = array(
                              'post_type' => 'into-the-beat',
                              'posts_per_page' => 3,
                              'meta_query' => array(
                                    array(
                                          'key' => '_thumbnail_id',
                                          'compare' => 'EXISTS',
                                    )
                              )
                        );
                        $query = new WP_Query( $args );

                        while ( $query->have_posts() ) {
                              $query->the_post();
                              ?>
                              <li class="col-1 fl">
                                    <?php get_template_part( 'tpl/parts/list-5' ); ?>
                              </li>
                              <?php
                        } //END while
                        ?>
                        <?php wp_reset_postdata(); ?>

                  </ul>
            </div>

      </div>
      <script type="text/javascript">

            jQuery(document).ready(function($) {

                  $('.home-clubbermag-podcasts').flexslider({
                        animation: "fade",
                        slideshowSpeed: 5000,
                        controlNav: false,
                        directionNav: false,
                        pauseOnHover: false,
                        direction: "horizontal",
                        reverse: false,
                        animationSpeed: 1000,
                        easing: "linear",
                        slideshow: true,
                        useCSS: false
                  });
            });
      </script>    
      <?php cm_home_list_more( 'into-the-beat', __( 'see more...', 'cm' ) ) ?>

</section>
