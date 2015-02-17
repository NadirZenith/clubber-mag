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
      if ( $sc_info_str = get_post_meta( get_the_ID(), CM_META_SOUNDCLOUD, true ) ) {
            $sc_info = json_decode( $sc_info_str );
            if ( $sc_info ) {
                  echo nz_get_soundcloud_iframe( $sc_info->uri );
            }
      } else {
            ?>
            <a class="featured-image" href="<?php echo get_permalink( $event->ID ); ?>">
                  <?php the_post_thumbnail( '290-160-thumb' ); ?>

            </a>
            <?php
      }
      ?>
</article>
