<?php
/**
 * Template Name: Form Page Template
 *
 * Displays the contact page template.
 *
 */
?>

<?php
global $post;
if ( have_posts() ) {
      while ( have_posts() ) {
            the_post();

            do_action( 'attitude_before_post' );
            ?>
            <section class="bg-50 block-5 pb15" id="post-<?php the_ID(); ?>">
                  <div class="col-3-4" style="margin:auto">
                        <header>
                              <h1 class="ml5 mt5 bigger">
                                    <?php the_title(); ?>
                              </h1>
                        </header>
                        <?php
                        the_content()
                        ?>
                  </div>
            </section>
            <?php
      }
} else {
      ?>
      <h1 class="entry-title"><?php _e( 'No Posts Found.', 'attitude' ); ?></h1>
      <?php
}
?>
