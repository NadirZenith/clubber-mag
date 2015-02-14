<?php
/*
 * Featured list item
 */
?>
<article>
      <div class="hover-2">
            <h2 class="ml5 sf-2">
                  <a href="<?php the_permalink(); ?>">
                        <?php
                        echo get_the_title()
                        ?>
                  </a>
            </h2>
      </div>
      <?php if ( $date = get_post_meta( get_the_ID(), 'wpcf-event_begin_date', true ) ): ?>
            <div class="p-detail">
                  <?php
                  if ( is_numeric( $date ) && ( int ) $date == $date ) {
                        echo date( 'd/m/y', $date );
                  }
                  $tax = 'city';
                  if ( $term = wp_get_post_terms( get_the_ID(), $tax )[ 0 ]->name ) {
                        $link = get_term_link( $term, $tax );
                        echo " <a href='{$link}'>{$term}</a>";
                  }
                  ?>
            </div>
      <?php endif; ?>
      <?php
      /* d(get_post_meta( get_the_ID(), CM_META_SOUNDCLOUD, true )); */
      if ( $url = get_post_meta( get_the_ID(), CM_META_SOUNDCLOUD, true ) AND strlen( trim( $url ) ) > 10 ) {
            /* d($url); */
            //echo do_shortcode( '[soundcloud url="' . $url . '" params="color=ff5500&auto_play=false&hide_related=true&show_comments=true&show_user=true&show_reposts=false" width="100%" height="166" iframe="true" /]' );
            /* echo do_shortcode( '[soundcloud url="http://api.soundcloud.com/playlists/1595551" ' */
            echo do_shortcode( '[soundcloud url="http://api.soundcloud.com/tracks/98703651" '
                      . 'visual="true" '
                      /* . 'width="100%" ' */
                      . 'iframe="true" '
                      . 'show_artwork ="true" '
                      . '/]' );
      } else {
            ?>
            <a class="featured-image" href="<?php echo get_permalink( $event->ID ); ?>">
                  <?php the_post_thumbnail( '290-160-thumb' ); ?>

            </a>
            <?php
      }
      ?>
</article>
