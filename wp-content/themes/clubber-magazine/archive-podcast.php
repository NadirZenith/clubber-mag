<main role="main">
      <div class="has-sidebar">
            <section>
                  <?php
                  if ( have_posts() ) {
                        ?>
                        <header class="mt15 mb10">
                              <h1>
                                    <span class="cm-title">
                                          <?php _e( 'Into the Beat Radio', 'cm' ) ?>
                                    </span>
                              </h1>
                        </header>
                        <ul class="group">
                              <?php
                              while ( have_posts() ) {
                                    the_post();
                                    /* $ids[] = get_the_ID(); */
                                    ?>
                                    <li class="col-1 col-md-1-2 fl">
                                          <div class="box-3">
                                                <?php
                                                get_template_part( 'tpl/parts/list-5' );
                                                ?>
                                          </div>
                                    </li>
                                    <?php
                              }
                              ?>
                        </ul>

                        <?php include (locate_template( 'tpl/parts/pagination.php' )); ?>

                        <?php
                  }
                  ?>

            </section>
            <div class="cb mb15"></div>
            <section>
                  <header class="mt15 mb10">
                        <h1 class="h2">
                              <span class="cm-title">
                                    <?php _e( 'Open Frequency', 'cm' ) ?>
                              </span>
                        </h1>
                  </header>

                  <?php
                  $args = array(
                        'post_type' => 'podcast',
                        'posts_per_page' => 3,
                        'meta_key' => 'soundcloud_special_guest',
                        'meta_compare' => 'NOT EXISTS',
                        /*'lang' => implode( ' ,', pll_languages_list() ),*/
                  );
                  $query2 = new WP_Query( $args );
                  if ( $query2->have_posts() ) {
                        ?>
                        <ul>
                              <?php
                              while ( $query2->have_posts() ) {
                                    $query2->the_post();
                                    ?>
                                    <li class="col-1">
                                          <?php
                                          get_template_part( 'tpl/parts/list-5' );
                                          ?>
                                    </li>
                                    <?php
                              }
                              ?>
                        </ul>
                        <?php
                  }
                  ?>
                  <?php wp_reset_postdata(); ?>

                  <?php
                  ?>
            </section>

      </div>

</main>
<aside role="complementary">
      <?php get_sidebar(); ?>
</aside>