<section class="m5-">
      <div class="mb5-">
            <?php
            cm_home_list_title( get_permalink( get_page_by_title( 'noticias' ) ), __( 'Latest News', 'cm' ), true );
            ?>
      </div>
      <ul>
            <?php
            $query = new WP_Query( array(
                  'post_type' => 'post',
                  'posts_per_page' => 5,
                      )
            );
            while ( $query->have_posts() ) {
                  $query->the_post();
                  ?>
                  <li class="mb5-">
                        <?php get_template_part( 'tpl/home/list-1' ); ?>
                  </li>
                  <?php
            }
            wp_reset_postdata();
            ?>
      </ul>

      <?php cm_home_list_more( get_permalink( get_page_by_title( 'noticias' ) ), __( 'see more ...', 'cm' ), true ) ?>

</section>