
<?php get_header(); ?>


<div id="container">
      <?php
      /**
       *    ARTISTS
       *    REVIEWS
       *    PODCASTS
       *    ENTREVISTAS
       *          
       */
      ?>
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
                                    <div class="fl featured-image col-1-4 nm">
                                          <?php
                                          the_post_thumbnail('340-155-thumb');
                                          ?>
                                    </div>

                              </section>
                        </li>
                        <?php
                  }
            }


            wp_reset_postdata();
            ?>


            <?php
            $post_type = 'music';
            $taxonomy = 'music_type';

            $terms = array(
                /* 'artist' => 'Artistas', */
                'review' => 'Reviews',
                'podcast' => 'Podcasts',
                'interview' => 'Entrevistas'
            );
            foreach ($terms as $term => $name) {
                  $Term = get_term_by('slug', $term, $taxonomy);
                  $term_link = get_term_link($Term);
                  $args = array(
                      'post_type' => $post_type,
                      'posts_per_page' => 1,
                      'post_status' => 'publish',
                      'tax_query' => array(
                          array(
                              'taxonomy' => $taxonomy,
                              'field' => 'slug',
                              'terms' => $term
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
                                                      <?php echo $name ?>
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
                                    <div class="fl featured-image col-1-4 nm">
                                          <?php
                                          the_post_thumbnail('340-155-thumb');
                                          ?>
                                    </div>
                              </section>
                        </li>
                        <?php
                  } else {
                        ?>
                        <li> NO POSTS!! </li>
                        <?php
                  }
            }
            wp_reset_postdata();
            ?>

      </ul>

</div><!-- #container -->

<?php get_footer(); ?>
