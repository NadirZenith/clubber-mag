<section class="m5">
      <div class="mb5">
            <?php
            cm_home_list_title( 'music', __( 'Music', 'cm' ) );
            ?>
      </div>

      <ul>
            <?php
            $query = new WP_Query( array(
                  'post_type' => 'music',
                  'posts_per_page' => 5,
                      )
            );
            while ( $query->have_posts() ) {
                  $query->the_post();
                  ?>
                  <li class="mb5">
                        <?php get_template_part( 'tpl/home/list-1' ); ?>
                  </li>
                  <?php
            }
            wp_reset_postdata();
            ?>
      </ul>
      <?php cm_home_list_more( 'music', __( 'see more ...', 'cm' ) ) ?>
</section>