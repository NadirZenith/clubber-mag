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
            /* d('single photo'); */
            global $post;

            if (have_posts()) {
                  while (have_posts()) {
                        the_post();
                        ?>
                        <section class="cb bg-50 block-5" style="overflow:visible">
                              <article class="" >
                                    <header style="top:0px; height: 50px;" class="hover">
                                          <h1 class="ml5 sc-eee" style="height: 50px;">
                                                <?php the_title(); ?>
                                          </h1>
                                    </header>
                                    <div class="featured-image" style="width:100%;">
                                          <?php
                                          the_post_thumbnail();
                                          ?>
                                    </div>
                                    <div class="fr mt5 mr5 cb">
                                          <span class=""style="color: #666;">
                                                <?php echo get_the_date(); ?>
                                          </span>
                                    </div>
                                    <div class="mt5 ml5 meddium cb">
                                          <?php
                                          the_content();
                                          ?>
                                    </div>
                                    <?php
                                    $images = get_field('photo-gallery');
                                    if ($images) {
                                          ?>

                                          <div class="cb">
                                                <ul>
                                                      <?php foreach ($images as $image) { ?>
                                                            <li class="fl mt5 col-1-4" style="">
                                                                  <a class="fancybox featured-image" href="<?php echo $image['url'] ?>">
                                                                        <img src="<?php echo $image['sizes']['290-160-thumb']; ?>" alt="<?php echo $image['alt'] ?>">
                                                                  </a>
                                                            </li>
                                                      <?php } ?>
                                                </ul>
                                          </div>
                                          <?php
                                    }
                                    ?>
                                    <?php
                                    include_once 'facebook/like-single.php';
                                    ?>


                              </article>
                        </section>
                        <script type="text/javascript">
                              (function($) {
                                    $('.fancybox').fancybox();
                              })(jQuery);
                        </script>
                        <?php
                  }
            } else {
                  ?>
                  <h1 class=""><?php _e('No Posts Found.', 'attitude'); ?></h1>
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
      <!--
            <div id="secondary" class="no-margin-left">
      <?php
      /* get_sidebar('right'); */
      ?>
            </div>
      -->



</div><!--container-->
<?php
/**
 * attitude_after_main_container hook
 */
do_action('attitude_after_main_container');
?>

<?php
get_footer();
?>