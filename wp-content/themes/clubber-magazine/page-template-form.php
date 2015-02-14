<?php
/**
 * Template Name: Form Page Template
 *
 * Displays the contact page template.
 *
 */
?>


<?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
            <section class="ibox-5 box-5">
                  <article>
                        <?php
                        the_content();
                        ?>
                  </article>
            </section>
      <?php endwhile; ?>
<?php else: ?>
      <div class="h1"><?php _e( 'No Posts Found.', 'cm' ); ?></div>
<?php endif; ?>
