
<?php get_header(); ?>

<?php
do_action('attitude_before_main_container');
$tax = 'city';
if (is_tax($tax, 'barcelona')) {
      $city = 'Barcelona';
}
if (is_tax($tax, 'madrid')) {
      $city = 'Madrid';
}
?>

<div id="container">
      <section class="event bg-50 block-5">
            <?php
            //@todo remove link **
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
                        $start_date = $DateTime->getTimestamp();
                  }
            } else {
                  $start_date = strtotime("now");
            }
            $end_date = strtotime('+ 1 week', $start_date);
            $prev_date = strtotime('- 1 week', $start_date);

            $args = array(
                'post_type' => 'event',
                'posts_per_page' => -1,
                'order' => 'ASC',
                /* 'orderby' => 'meta_value', */
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
                        <li class="fl   " style="">
                              <a href="<?php echo add_query_arg(array('date' => urlencode(date('d/m/Y', $prev_date)))) ?>"> <span class="meddium sc-3">&#8678;</span> Previous week</a>
                        </li>
                        <li class="fr " style="font-weight: bold">
                              <a href="<?php echo add_query_arg(array('date' => date('d/m/Y', $end_date))) ?>">Next week <span class="meddium sc-3">&#8680;</span></a>
                        </li>
                  </ul>
            </div>
            <ul class="cb archive-list ">
                  <?php
                  if (have_posts()) {
                        while (have_posts()) {
                              the_post();
                              $post_timestamp = get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true); //1394924400
                              $post_date = date('l d/m/y', $post_timestamp); //"15/03/14"

                              if ($last_date != $post_date) {
                                    ?> 
                                    <li class="ml5 mr5">
                                          <h2 class="" style="font-size: 28px;font-weight: bold; color: #333;"><?php echo $post_date ?> </h2> 
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
                                                      <div class="meddium" style="">
                                                            <?php the_excerpt() ?>
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
                                                                  /* the_post_thumbnail('home-gallery-thumb'); */
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
                              <h1><?php _e('No Posts Found.', 'attitude'); ?></h1>

                        </li>
                        <?php
                  }
                  ?>
            </ul>
            <div class="clearfix ml15 mt30 mb15 mr15 bold meddium" >
                  <ul>
                        <li class="fl">
                              <a href="<?php echo add_query_arg(array('date' => urlencode(date('d/m/Y', $prev_date)))) ?>"> <span class="meddium sc-3">&#8678;</span> Previous week</a>
                        </li>
                        <li class="fr ">
                              <a href="<?php echo add_query_arg(array('date' => date('d/m/Y', $end_date))) ?>">Next week <span class="meddium sc-3">&#8680;</span></a>
                        </li>
                  </ul>
            </div>
      </div>
      <?php
      wp_reset_postdata();
      ?>
      <div id="secondary">
            <?php get_sidebar('event'); ?>
      </div>

</div><!-- #container -->

<?php get_footer(); ?>
