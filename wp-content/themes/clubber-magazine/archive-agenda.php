
<?php get_header(); ?>

<?php
do_action('attitude_before_main_container');
$tax = 'city';
if (is_tax($tax)) {
      global $wp_query;
      $term = $wp_query->get_queried_object();
      $city = ucfirst($term->name);
}
?>

<div id="container">
      <section class="event bg-50 block-5">
            <?php
            require_once 'library/structure/front/event.php';
            ?>
      </section>

      <div id="primary">
            <h1 class="ml5">
                  Eventos esta semana
                  <?php
                  if ($city) {
                        echo " en {$city}";
                  }
                  ?>
            </h1>

            <?php
            if (isset($_GET['date'])) {
                  $DateTime = date_create_from_format('d/m/Y', $_GET['date']);

                  if ($DateTime) {
                        $DateTime->setTime(0, 0, 0); //to avoid date problems
                        $start_date = $DateTime->getTimestamp();
                  }
            } else {
                  $start_date = strtotime("now");
            }
            $end_date = strtotime('+ 1 week', $start_date);
            $prev_date = strtotime('- 1 week', $start_date);

            $args = array(
                'post_type' => 'agenda',
                'posts_per_page' => -1,
                'order' => 'ASC',
                'orderby' => 'meta_value_num',
                'meta_key' => 'wpcf-event_begin_date',
                'meta_query' => array(
                    array(
                        'key' => 'wpcf-event_begin_date',
                        'value' => array($start_date, $end_date),
                        'type' => 'NUMERIC',
                        'compare' => 'BETWEEN'
                    )
                )
            );
            if ($city) {
                  $args[$tax] = $city;
            }

            $wp_query = new WP_Query($args);
            ?>

            <div class="clearfix ml15 mt15 mb15 mr15 bold meddium">
                  <ul>
                        <li class="fl">
                              <a href="<?php echo add_query_arg(array('date' => urlencode(date('d/m/Y', $prev_date)))) ?>"> <span class="meddium sc-3">&#8678; </span>Semana anterior</a>
                        </li>
                        <li class="fr" >
                              <a href="<?php echo add_query_arg(array('date' => date('d/m/Y', $end_date))) ?>">Próxima semana<span class="meddium sc-3"> &#8680;</span></a>
                        </li>
                  </ul>
            </div>
            <ul class="cb archive-list ">
                  <?php
                  /*    MAIN AGENDA QUERY              */
                  if (have_posts()) {
                        $main_posts_id = array();
                        while (have_posts()) {
                              the_post();
                              $main_posts_id[] = get_the_ID();
                              $post_timestamp = get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true); //1394924400
                              $post_date = date('l d/m/y', $post_timestamp); //"15/03/14"

                              if ($last_date != $post_date) {
                                    ?> 
                                    <li class="ml5 mr5">
                                          <h2 class=" bold sc-3" style="font-size: 200%;"><?php echo $post_date ?> </h2> 
                                          <hr class="cb pb5">
                                    </li>
                                    <?php
                              }
                              $last_date = $post_date;
                              ?>
                              <li class="pr">

                                    <section class="bg-50 block-5 mb15" >
                                          <article>
                                                <header>
                                                      <h1 class="mt5" style="">
                                                            <a class="ml5" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                                                  <?php
                                                                  $mytitle = get_the_title();
                                                                  if (strlen($mytitle) > 65) {
                                                                        $mytitle = substr($mytitle, 0, 65) . '...';
                                                                  }
                                                                  echo $mytitle;
                                                                  ?>
                                                            </a>
                                                      </h1>
                                                </header>
                                                <hr class="pb5">
                                                <div class="fl ml5 col-2-4 ">
                                                      <div class="meddium bold" style="text-align: justify">
                                                            <p><?php echo wp_trim_words(get_the_content(), 20); ?></p>
                                                      </div>
                                                      <div class="event-date" style="position: absolute; right: 0; bottom: 0;">
                                                            <?php
                                                            echo date('d/m/y - H:i', get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true));

                                                            if ($term = wp_get_post_terms(get_the_ID(), $tax)[0]->name) {
                                                                  $link = get_term_link($term, $tax);
                                                                  echo " <a href='{$link}'>en {$term}</a>";
                                                            }
                                                            ?>
                                                      </div>
                                                </div>
                                                <div class="fr col-2-4 nm" >
                                                      <?php
                                                      if (has_post_thumbnail()) {
                                                            ?>
                                                            <a class="featured-image" href="<?php the_permalink() ?>"  style="">
                                                                  <?php
                                                                  the_post_thumbnail('430-190-thumb');
                                                                  ?>
                                                            </a>
                                                            <?php
                                                      }
                                                      ?>
                                                </div>
                                          </article>
                                          <div style="position: absolute; bottom: 10px;left: 20px;">
                                                <a class="readmore" href="<?php the_permalink() ?>" title="<?php the_title() ?>"> <?php echo __('Read more', 'attitude') ?></a>
                                          </div>
                                    </section>
                              </li>
                              <?php
                        }
                  } else {
                        ?>
                        <li>
                              <h2><?php _e('No Posts Found.', 'attitude'); ?></h2>

                        </li>
                        <?php
                  }
                  /* ---------- //END MAIN AGENDA QUERY              */
                  ?>
            </ul>
            <div class="clearfix ml15 mt30 mb15 mr15 bold meddium" >
                  <ul>
                         <li class="fl">
                              <a href="<?php echo add_query_arg(array('date' => urlencode(date('d/m/Y', $prev_date)))) ?>"> <span class="meddium sc-3">&#8678; </span>Semana anterior</a>
                        </li>
                        <li class="fr">
                              <a href="<?php echo add_query_arg(array('date' => date('d/m/Y', $end_date))) ?>">Próxima semana<span class="meddium sc-3"> &#8680;</span></a>
                        </li>
                  </ul>
            </div>

            <?php
            /*   LESS THAN 3 EVENTS        */
            if ($wp_query->found_posts < 5) {
                  /* wp_reset_postdata(); */
                  /* d('less than 5 results -> query nexts'); */

                  $args = array(
                      'post_type' => 'agenda',
                      'post__not_in' => $main_posts_id,
                      'posts_per_page' => 5,
                      'order' => 'ASC',
                      'orderby' => 'meta_value_num',
                      'meta_key' => 'wpcf-event_begin_date',
                  );

                  if ($city) {
                        $args[$tax] = $city;
                  }

                  $wp_query = new WP_Query($args);
                  if (have_posts()) {
                        ?>
                        <h1 class="ml5">
                              Próximos eventos
                              <?php
                              if ($city) {
                                    echo " en {$city}";
                              }
                              ?>
                        </h1>
                        <ul>

                              <?php
                              while (have_posts()) {
                                    the_post();
                                    ?>
                                    <li class="pr">

                                          <section class="bg-50 block-5 mb15" >
                                                <article>
                                                      <header>
                                                            <h1 class="mt5" style="">
                                                                  <a class="ml5" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                                                        <?php
                                                                        $mytitle = get_the_title();
                                                                        if (strlen($mytitle) > 65) {
                                                                              $mytitle = substr($mytitle, 0, 65) . '...';
                                                                        }
                                                                        echo $mytitle;
                                                                        ?>
                                                                  </a>
                                                            </h1>
                                                      </header>
                                                      <hr class="pb5">
                                                      <div class="fl ml5 col-2-4 ">
                                                            <div class="meddium bold" style="text-align: justify">
                                                                  <p><?php echo wp_trim_words(get_the_content(), 20); ?></p>
                                                            </div>

                                                            <div class="event-date" style="position: absolute; right: 0; bottom: 0;">
                                                                  <?php
                                                                  echo date('d/m/y - H:i', get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true));

                                                                  if ($term = wp_get_post_terms(get_the_ID(), $tax)[0]->name) {
                                                                        $link = get_term_link($term, $tax);
                                                                        echo " <a href='{$link}'>en {$term}</a>";
                                                                  }
                                                                  ?>
                                                            </div>


                                                      </div>
                                                      <div class="fr col-2-4 nm" >
                                                            <?php
                                                            if (has_post_thumbnail()) {
                                                                  ?>
                                                                  <a class="featured-image" href="<?php the_permalink() ?>"  style="">
                                                                        <?php
                                                                        the_post_thumbnail('430-190-thumb');
                                                                        ?>
                                                                  </a>
                                                                  <?php
                                                            }
                                                            ?>
                                                      </div>
                                                </article>
                                                <div style="position: absolute; bottom: 10px;left: 20px;">
                                                      <a class="readmore" href="<?php the_permalink() ?>" title="<?php the_title() ?>"> <?php echo __('Read more', 'attitude') ?></a>
                                                </div>
                                          </section>
                                    </li>
                                    <?php
                              }
                              ?>
                        </ul>
                        <?php
                  }
            }

            /*  --------- //END LESS THAN 3 EVENTS        */
            ?>


      </div>
      <?php
      wp_reset_postdata();
      ?>
      <div id="secondary">
            <?php get_sidebar('agenda'); ?>
      </div>

</div><!-- #container -->

<?php get_footer(); ?>
