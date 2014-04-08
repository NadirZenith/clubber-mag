
<?php get_header(); ?>


<div id="container">
      <ul class="archive-list">
            <?php
            $args = array(
                'label_name' => 'Artistas',
                'link' => get_post_type_archive_link('artists'),
                'post_type' => 'artists',
                'post_status' => 'publish',
                'posts_per_page' => 1,
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) {

                  while ($query->have_posts()) {
                        $query->the_post();
                        ?>
                        <li class="bg-50 block-5 mt15">
                              <section class="">
                                    <div class="fr col-3-4 col-min">
                                          <h1>
                                                <a class="ml5" href="<?php echo $args['link'] ?>">
                                                      <?php echo $args['label_name'] ?>
                                                </a>
                                          </h1>


                                          <div class="meddium bold">
                                                <p>
                                                      <?php
                                                      echo wp_trim_words(get_the_content(), 30);
                                                      ?>
                                                </p>
                                          </div>
                                          <a class="readmore mr5" href="<?php echo $args['link']; ?>" title=""> <?php echo __('Read more', 'attitude') ?></a>
                                    </div>
                                    <div class="fl col-1-4 nm">
                                          <a class="featured-image" href="<?php
                                          echo $args['link'];
                                          ;
                                          ?>">
                                                   <?php
                                                   the_post_thumbnail('340-155-thumb');
                                                   ?>
                                          </a>
                                    </div>

                              </section>
                        </li>
                        <?php
                  }
            }

            wp_reset_postdata();

            $post_type = 'music';
            $taxonomy = 'music_type';

            $music_terms = get_terms($taxonomy, array(
                'orderby' => 'count',
                'hide_empty' => 0
            ));

            foreach ($music_terms as $term) {
                  $term_link = get_term_link($term);
                  $args = array(
                      'posts_per_page' => 1,
                      'post_type' => $post_type,
                      'tax_query' => array(
                          array(
                              'taxonomy' => 'music_type',
                              'field' => 'slug',
                              'terms' => $term->slug
                          )
                      )
                  );

                  $query = new WP_Query($args);
                  if ($query->have_posts()) {
                        $query->the_post();
                        ?>
                        <li class="bg-50 block-5 mt15">
                              <section class="">
                                    <div class="fr col-3-4 col-min">
                                          <h1>
                                                <a class="ml5" href="<?php echo $term_link; ?>">
                                                      <?php echo $term->name ?>
                                                </a>
                                          </h1>

                                          <div class="meddium bold">
                                                <p>
                                                      <?php
                                                      echo wp_trim_words(get_the_content(), 30);
                                                      ?>
                                                </p>
                                          </div>
                                          <a class="readmore mr5" href="<?php echo $term_link; ?>" title=""> <?php echo __('Read more', 'attitude') ?></a>
                                    </div>
                                    <div class="fl col-1-4 nm">
                                          <a class="featured-image" href="<?php echo $term_link; ?>">
                                                <?php
                                                the_post_thumbnail('340-155-thumb');
                                                ?>
                                          </a>
                                    </div>
                              </section>
                        </li>
                        <?php
                  }// have posts
            }//for each
            wp_reset_postdata();
            ?>
      </ul>

</div><!-- #container -->

<?php get_footer(); ?>
