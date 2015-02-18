<?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
            <section <?php post_class( 'ibox-5 box-5' ); ?>>
                  <article id="post-<?php the_ID(); ?>">
                        <?php echo get_template_part( 'tpl/parts/page-header' ) ?>
                        <?php the_content(); ?>
                  </article>
            </section>
      <?php endwhile; ?>
<?php else: ?>
      <?php get_template_part( 'tpl/parts/not-found' ); ?>
<?php endif; ?>
