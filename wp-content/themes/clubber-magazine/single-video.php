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
                                ?>
                                <section class="bg-50 block-5" style="overflow:visible">
                                        <article >
                                                <header style="top:0px; height: 50px;z-index: 1000" class="hover">
                                                        <h1 class="ml5 sc-eee">
                                                                <?php
                                                                the_title();
                                                                ?>
                                                        </h1>
                                                </header>
                                                <div class="video-container">
                                                        <?php
                                                        /*$url = get_post_meta(get_the_ID(), 'wpcf-youtube-video-url', true);*/
                                                        /*parse_str(parse_url($url, PHP_URL_QUERY), $vars);*/
                                                        /* <iframe width="390" height="490" src="//www.youtube.com/embed/<?php echo $vars['v']; ?>" frameborder="0" allowfullscreen></iframe> */

                                                        $video = types_render_field("video-url", array("output" => "html"));
                                                        echo $video;
                                                        ?>
                                                </div>
                                                <div class="fr mt5 mr5 cb">
                                                        <span class=""style="color: #333;">
                                                                <?php
                                                                echo get_the_date();
                                                                ?>
                                                        </span>
                                                </div>
                                                <div class="mt5 ml5 meddium cb">
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

                <div class="bg-50  block-5">
                        <h1 class="ml5">Comentarios</h1>
                        <?php
                        include_once 'facebook/comments.php';
                        ?>
                </div>

                <?php
                /* include_once 'banners/footer-728-90.php'; */
                ?>


        </div>

        <div id="secondary" class="no-margin-left">
                <?php get_sidebar('right'); ?>
        </div><!-- #secondary -->


</div><!--container-->
<?php
?>

<?php
get_footer();
?>