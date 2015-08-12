<section class="video ibox-5- mt30-">
      <div class="mb5- ">
            <?php
            cm_home_list_title( 'video', __( 'Video review', 'cm' ) );
            ?>
      </div>
      <div class="home-slider">
            <ul class="slides">
                  <?php
                  $query = new WP_Query( array(
                        'post_type' => 'video',
                        'posts_per_page' => 2,
                            )
                  );
                  while ( $query->have_posts() ) {
                        $query->the_post();
                        ?>
                        <li>
                              <article>
                                    <div class="iframe-container">
                                          <?php
                                          $url = get_metadata( 'post', get_the_ID(), 'wpcf-video-url', true );
                                          $shortcode = '[embed width="123" height="456"]' . $url . '[/embed]';
                                          global $wp_embed;
                                          echo $wp_embed->run_shortcode( $shortcode );
                                          ?>
                                    </div>
                              </article>
                        </li>
                        <?php
                  }
                  ?>
                  <?php wp_reset_postdata(); ?>
            </ul>
            <?php cm_home_list_more( 'video', __( 'see more ...', 'cm' ) ) ?>
      </div>
</section>