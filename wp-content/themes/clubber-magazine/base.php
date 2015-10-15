<?php ob_start() ?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
    <head>
        <?php get_template_part('tpl/base/head'); ?>
    </head>
    <body <?php body_class(); ?> >
        <?php do_action('base_after_body') ?>
        <div id="site">
            <header id="header" role="banner">
                <?php get_template_part('tpl/base/header'); //the header of page, logo banner menu etc...  ?>
            </header>
            <?php
            if (is_front_page()) {
                ?>
                <section class="featured-posts">
                    <?php echo do_shortcode('[metaslider id=661]'); ?>
                </section>
                <?php
            } else if (is_singular('artist')) {
                echo get_template_part('tpl/parts/artist-home');
            }
            ?>
            <?php
            ob_flush();
            ob_start();
            ?>
            <div id="content">
                <?php nzs_display_messages(); ?>
                <?php get_template_part('tpl/base/content'); ?>
            </div>
            <?php
            ob_flush();
            ob_start();
            ?>
            <footer id="footer" role="contentinfo">
                <?php get_template_part('tpl/base/footer'); ?>
            </footer>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>
<?php ob_flush(); ?>