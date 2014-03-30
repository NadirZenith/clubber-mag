

<?php get_header(); ?>

<div id="container">
      <?php
      d('page');
      global $post;
      if (have_posts()) {
            while (have_posts()) {
                  the_post();

                  do_action('attitude_before_post');
                  ?>
                  <section class="bg-50 block-5" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <article class="">
                              <header class="ml5 mt5">
                                    <h1 class="bigger">
                                          <?php the_title(); ?>
                                    </h1>
                              </header>
                              <div class="mt5 ml5 meddium bold">
                                    <?php
                                    the_content()
                                    ?>
                              </div>

                        </article>
                  </section>
                  <?php
            }
      } else {
            ?>
            <h1 class="entry-title"><?php _e('No Posts Found.', 'attitude'); ?></h1>
            <?php
      }
      ?>

  
</div><!-- #container -->


<?php
get_footer();
?>