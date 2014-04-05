
<?php get_header(); ?>

<div id="container">
      <div id="primary">
            <?php
            /* d('single'); */
            global $post;
            if (have_posts()) {
                  while (have_posts()) {
                        the_post();
                        ?>

                        <section class="bg-50 block-5" style="overflow:visible">
                              <article >
                                    <header class="hover" style="top:0px; height: 50px;">
                                          <h1 class="ml5 sc-eee">
                                                <?php the_title(); ?>
                                          </h1>
                                    </header>
                                    <div class="featured-image" style="width:100%;">
                                          <?php
                                          /* the_post_thumbnail('single-thumb'); */
                                          the_post_thumbnail();
                                          ?>
                                    </div>
                                    <div class="fr mt5 mr5 cb">
                                          <span class=""style="color: #666;">
                                                <?php echo get_the_date(); ?>
                                          </span>
                                    </div>
                                    <div class="mt5 ml5 mr5 meddium cb">
                                          <?php
                                          the_content();
                                          ?>
                                    </div>
                                    <?php
                                    include_once 'facebook/like-single.php';
                                    ?>

                              </article>
                        </section>
                        <?php
                        /* do_action('attitude_after_post'); */
                  }
            } else {
                  ?>
                  <h1 class="entry-title"><?php _e('No Posts Found.', 'attitude'); ?></h1>
                  <?php
            }
            ?>

            <div class="cb bg-50  block-5">

                  <h1 class="ml5">Comentarios</h1>
                  <?php
                  include_once 'facebook/comments.php';
                  ?>
            </div>

      </div>

      <div id="secondary" class="no-margin-left">
            <?php get_sidebar('right'); ?>
      </div><!-- #secondary -->



</div><!--container-->


<?php
get_footer();
?>