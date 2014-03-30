
<?php get_header(); ?>

<div id="container">

      <ul class="archive-list">

            <?php
            $args = array(
                'post_type' => 'photo',
                'post_status' => 'publish',
                /* 'name' => $wp_query->query_vars['name'], */
                'posts_per_page' => 2
            );
            $query = new WP_Query($args);
            $thumb = array();
            if ($query->have_posts()) {
                  $query->the_post();
                  $thumb[] = get_the_post_thumbnail(get_the_ID(), '340-155-thumb');
                  $query->the_post();
                  $thumb[] = get_the_post_thumbnail(get_the_ID(), '340-155-thumb');
            }
            ?>
            <li class="bg-50 block-5 mt15">

                  <section class="">
                        <div class="fr col-3-4 col-min">
                              <h1>
                                    <a class="ml5" href="<?php echo get_post_type_archive_link('photo'); ?>">
                                          Photo review
                                    </a>
                              </h1>

                              <div class="meddium bold">
                                    <p>
                                         description
                                    </p>
                              </div>
                              <a class="readmore mr5" href="<?php echo get_post_type_archive_link('photo'); ?>" title=""> <?php echo __('Read more', 'attitude') ?></a>
                        </div>
                        <div class="fl featured-image col-1-4 nm" >
                              <?php
                              echo $thumb[0];
                             
                              ?>
                        </div>

                  </section>  
            </li>

            <li class="bg-50 block-5 mt15">

                  <section class="">
                        <div class="fr col-3-4 col-min">
                              <h1>
                                    <a class="ml5" href="<?php echo get_post_type_archive_link('video'); ?>">
                                          Video review
                                    </a>
                              </h1>

                              <div class="meddium bold">
                                    <p>
                                         description
                                    </p>
                              </div>
                              <a class="readmore mr5" href="<?php echo get_post_type_archive_link('video'); ?>" title=""> <?php echo __('Read more', 'attitude') ?></a>
                        </div>
                        <div class="fl featured-image col-1-4 nm" >

                              <?php
                              echo $thumb[1];
                              /* the_post_thumbnail('340-155-thumb'); */
                              ?>
                        </div>

                  </section>  
            </li>
      </ul>


</div><!-- #container -->

<?php get_footer(); ?>
