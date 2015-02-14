<?php
/**
 * Template Name: Archive noticias
 *
 * Displays archive for noticias (posts)
 *
 */
?>
<section class="m5">
      <header class="mt5 mb10 ml5">
            <h1 class="sc-2">
                  <?php _e( 'News Archive', 'cm' ) ?> 
            </h1>
      </header>
      <?php
      if ( have_posts() ) {
            ?>
            <ul>
                  <?php
                  while ( have_posts() ) {
                        the_post();
                        ?>
                        <li class="ibox-5">
                              <?php get_template_part( 'tpl/parts/list-3' ); ?>

                        </li>
                        <?php
                  }
                  ?>
            </ul>
            <?php
      } else {
            get_template_part( 'tpl/parts/not-found' );
      }
      ?>
      <?php get_template_part( 'tpl/parts/pagination' ); ?>
</section>