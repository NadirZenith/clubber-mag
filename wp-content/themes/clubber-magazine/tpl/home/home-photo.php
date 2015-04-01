
<section class="m5">
      <div class="mb5">
            <?php
            cm_home_list_title( 'photo', __( 'Photo Gallery', 'cm' ) );
            ?>
      </div>
      <div class="home-slider">
            <ul class="slides">
                  <?php
                  $query = new WP_Query( array(
                        'post_type' => 'photo',
                        'posts_per_page' => 3,
                            )
                  );
                  while ( $query->have_posts() ) {
                        $query->the_post();
                        ?>
                        <li>
                              <?php get_template_part( 'tpl/home/photo-list-0' ); ?>
                        </li>
                        <?php
                  }
                  ?>
                  <?php wp_reset_postdata(); ?>
            </ul>
            <?php cm_home_list_more( 'photo', __( 'see more ...', 'cm' ) ) ?>
      </div>

</section>