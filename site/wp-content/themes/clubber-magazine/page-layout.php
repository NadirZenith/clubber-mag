<?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
            <section <?php post_class( 'ibox-5 box-5' ); ?>>
                  <article id="post-<?php the_ID(); ?>">
                        <header class="mt5 mb10">
                              <h1> <?php the_title(); ?> </h1>
                        </header>
                        <div>
                              <?php the_content(); ?>
                        </div>
                  </article>
            </section>
      <?php endwhile; ?>
<?php else: ?>
      <div class="h1"><?php _e( 'No Posts Found.', 'cm' ); ?></div>
<?php endif; ?>
