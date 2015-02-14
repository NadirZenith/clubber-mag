<?php
while ( have_posts() ) {
      the_post();
      switch ( get_post_type() ) {
            case 'label':
            case 'agenda':
                  get_template_part( 'tpl/single/single-1' );

                  break;

            case 'artist2':
                  get_template_part( 'tpl/single/single-2' );

                  break;
            

            default:
                  get_template_part( 'tpl/single/single-0' );

                  break;
      }
}
?>

<div class="featured-image banner-bottom cb"> 
      <?php
      echo do_shortcode( '[sam id=5]' );
      ?>
</div>
