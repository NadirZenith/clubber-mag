<?php
/**
 * Template Name: xCeed Template
 *
 * Displays the index xCeed template.
 *
 */
?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class('pure-type'); ?>>
            <img style="height: 100px; display: block; margin: 5px auto;" src="http://www.clubber-mag.com/web/wp-content/uploads/2015/06/Tickets-script-gray.jpg">
            <?php the_content(); ?>
        </article>
    <?php endwhile; ?>
<?php else: ?>
    <?php get_template_part('tpl/parts/not-found'); ?>
<?php endif; ?>
