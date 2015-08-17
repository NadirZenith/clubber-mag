<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class(); ?>>
            <?php echo get_template_part('tpl/parts/page-header') ?>
            <?php the_content(); ?>
        </article>
    <?php endwhile; ?>
<?php else: ?>
    <?php get_template_part('tpl/parts/not-found'); ?>
<?php endif; ?>
