<?php
/**
 * Displays the single section of the theme.
 *
 * @package Theme Horse
 * @subpackage Attitude
 * @since Attitude 1.0
 */
?>

<?php get_header(); ?>

<?php
/**
 * attitude_before_main_container hook
 */
/* do_action('attitude_before_main_container'); */
?>
<div id="container">
      <div id="primary">
            <?php
            global $post;
            if (have_posts()) {
                  while (have_posts()) {
                        the_post();
                        $post_timestamp = get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true);
                        $taxonomy = 'city';
                        $term = wp_get_post_terms(get_the_ID(), $taxonomy)[0]->name;
                        $link = get_term_link($term, $taxonomy);
                        ?>

                        <section class="bg-50 block-5" style="overflow:visible">
                              <article style="">
                                    <div class="featured-image col-2-4 fl nm" style="">
                                          <?php
                                          the_post_thumbnail();
                                          ?>
                                    </div>
                                    <div class="mt15  col-2-4 fl">
                                          <div class="ml5"> 
                                                <header  class="mt30">
                                                      <h1 style="line-height: normal;" class=" mr15">
                                                            <?php
                                                            the_title();
                                                            ?>
                                                      </h1>
                                                </header>
                                                <hr>
                                                <div class="event-date" style="position: absolute; right: 0; top: 0px;font-size: 20px;padding: 2px;">
                                                      <?php echo date('l d/m/y - H:i', $post_timestamp); ?>
                                                </div>
                                                <div class="post-meta meddium" >
                                                      <div class="fl col-2-4">
                                                            <ul >
                                                                  <!--<ul style="border-right:1px solid #333;">-->

                                                                  <li class="event-city">
                                                                        <span class="bold">Ciudad: </span>
                                                                        <?php echo "<a href='{$link}' title='Eventos en {$term}'>{$term}</a>"; ?> 
                                                                  </li>
                                                                  <li class="event-place-name">
                                                                        <span class="bold">Lugar: </span>                                                               </span>
                                                                        <?php echo get_post_meta(get_the_ID(), 'wpcf-event_place_name', true); ?>
                                                                  </li>
                                                                  <li class="event-place-address">
                                                                        <span class="bold"> Dirección: </span>  
                                                                        <?php echo get_post_meta(get_the_ID(), 'wpcf-event_place_address', true); ?>
                                                                  </li>

                                                            </ul>
                                                      </div>
                                                      <div class="fl col-2-4">
                                                            <ul>
                                                                  <li class="event-promoter">
                                                                        <span class="bold"> Promotor: </span>
                                                                        <?php echo get_post_meta(get_the_ID(), 'wpcf-event_promoter', true); ?>
                                                                  </li>
                                                                  <li class="event-price">
                                                                        <span class="bold">Precio: </span>
                                                                        <?php echo get_post_meta(get_the_ID(), 'wpcf-event_price', true) . '€'; ?>
                                                                  </li>
                                                                  <li class="event-price-conditions">
                                                                        <span class="bold">Condiciones del evento: </span>
                                                                        <?php echo get_post_meta(get_the_ID(), 'wpcf-event_price_conditions', true); ?>
                                                                  </li>
                                                            </ul>

                                                      </div>
                                                </div>
                                                <div class="cb">

                                                </div>
                                                <div style="font-size:19px; text-align: justify;" class="mt30 cb">
                                                      <?php
                                                      the_content();
                                                      ?> 

                                                </div>
                                          </div>
                                    </div>
                                    <div class="featured-image ml15 mt15" style="width:400px;">
                                          <?php
                                          $attachment_id = get_post_meta(get_the_ID(), 'wpcf-event_flyer', true);
                                          if ($attachment_id) {
                                                $attachment = wp_get_attachment_image($attachment_id, 'single-thumb');
                                                ?>
                                                <?php echo $attachment ?>
                                                                                                                                                                                                                          <!--<img src="<?php echo $flyer ?>" alt="<?php echo get_the_title() ?>" />-->
                                                <?php
                                          }
                                          ?>
                                    </div>


                                    <?php
                                    include_once 'facebook/like-single.php';
                                    ?>

                              </article>
                        </section>
                        <?php
                  }
            } else {
                  ?>
                  <h1 class="entry-title"><?php _e('No Posts Found.', 'attitude'); ?></h1>
                  <?php
            }
            /* the_meta(); */
            ?>

            <div class="bg-50  block-5" >

                  <h1 class="ml5">Comentarios</h1>
                  <?php
                  include_once 'facebook/comments.php';
                  ?>

            </div>

      </div>

      <div id="secondary" >
            <?php
            /* get_sidebar('right'); */
            include_once 'facebook/like-box.php';
            include_once 'banners/right-2-300-300.php';
            ?>
      </div>

</div><!--container-->

<?php
get_footer();
?>