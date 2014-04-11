<?php
/**
* Template Name: Archive noticias
*
* Displays archive for noticias (posts)
*
*/
get_header(); ?>

<?php
$args = array(
    'posts_per_page' => -1,
    'post_type' => 'post',
    'label_name' => 'Últimas noticias'
);
$the_query = new WP_Query($args);
?>
<div id="container">
      <div id="primary">
            <h1>
               NOTICIAS
            </h1>
         
            <ul class="archive-list">

                  <?php
                  global $post;

                  if ($the_query->have_posts()) {
                        while ($the_query->have_posts()) {
                              $the_query->the_post();
                              ?>
                              <li>

                                    <section class="bg-50 block-5 mb15">
                                          <article>
                                                <header>
                                                      <h1 class="mt5">
                                                            <a class="ml5" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                                      </h1>

                                                </header>
                                                <hr class="pb5">
                                                <div class="fl ml5 col-2-4 " style="">
                                                      <div class="meddium bold" style="text-align:justify">
                                                            <p><?php echo wp_trim_words(get_the_content(), 20); ?></p>
                                                      </div>
                                                      <p class="">
                                                            <a class="readmore" href="<?php the_permalink() ?>" title="<?php the_title() ?>"> <?php echo __('Read more', 'attitude') ?></a>
                                                      </p>

                                                      <div  style="color: #666;">
                                                            <?php echo get_the_date() ?>

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
                                    </section>
                              </li>

                              <?php
                        }
                  } else {
                        ?>
                        <h1 class=""><?php _e('No Posts Found.', 'attitude'); ?></h1>
                        <?php
                  }
                  ?>
            </ul>
      </div>

      <div id="secondary">
            <?php get_sidebar('right'); ?>
      </div><!-- #secondary -->
     
</div><!-- #container -->

<?php get_footer(); ?>
