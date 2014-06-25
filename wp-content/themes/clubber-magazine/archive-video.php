<?php
/**
 * Displays the index section of the theme.
 *
 * @package Theme Horse
 * @subpackage Attitude
 * @since Attitude 1.0
 */
$args = array(
      'posts_per_page' => -1,
      'post_type' => 'video',
        /* 'label_name' => 'Últimas noticias' */
);
/* $the_query = new WP_Query($args); */
?>

<?php get_header(); ?>

<div id="container">
        <div id="primary">
                <h1>
                        <?php
                        echo ucfirst(post_type_archive_title($prefix, $display));
                        ?>
                </h1>
                <ul class="archive-list">

                        <?php
                        global $post;

                        if (have_posts()) {
                                while (have_posts()) {
                                        the_post();
                                        ?>
                                        <li>
                                                <section class="bg-50 block-5 mb15" >
                                                        <article>
                                                                <header>
                                                                        <h1 class="mt5" style="">
                                                                                <a class="ml5" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                                                        </h1>
                                                                </header>
                                                                <hr class="pb5">
                                                                <div class="fl ml5 col-2-4" style="">
                                                                        <p style="font-size: 20px;text-indent: 20px;">
                                                                                <?php echo get_the_excerpt() ?>
                                                                        </p>
                                                                        <span style="color: #333;">
                                                                                <?php echo get_the_date() ?>

                                                                        </span>
                                                                        <p class="">
                                                                                <a class="readmore" href="<?php the_permalink() ?>" title="<?php the_title() ?>"> <?php echo __('Read more', 'attitude') ?></a>
                                                                        </p>
                                                                </div>

                                                                <div class="fr mt5 col-2-4 nm" >
                                                                        <div class="video-container">
                                                                                <?php
                                                                                $video = types_render_field("video-url", array("output" => "html"));
                                                                                echo $video;
                                                                                ?>
                                                                        </div>
                                                                </div>
                                                        </article>
                                                </section>
                                        </li>


                                        <?php
                                }
                                ?>

                                <?php
                        } else {
                                ?>
                                <li class=""><?php _e('No Posts Found.', 'attitude'); ?></li>
                                <?php
                        }
                        ?>
                </ul>
                <?php
                include (locate_template('templates/pagination.php'));
                ?>

        </div>

        <div id="secondary">
                <?php get_sidebar('right'); ?>
        </div><!-- #secondary -->

</div><!-- #container -->

<?php get_footer(); ?>
