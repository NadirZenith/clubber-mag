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
                        echo date( 'd/m/y ', $date );
                  }
                  echo nz_get_post_city_link( get_the_ID());
                  ?>
            </div>
      <?php endif; ?>
      <?php
      if ( $sc_info_str = get_post_meta( get_the_ID(), CM_META_SOUNDCLOUD, true ) ) {
            $sc_info = json_decode( $sc_info_str );
            if ( $sc_info ) {
                  echo nz_get_soundcloud_iframe( $sc_info->uri );
            }
      } elseif ( has_post_thumbnail() ) {
            ?>
            <a class="featured-image" href="<?php echo get_permalink( $event->ID ); ?>">
                  <?php the_post_thumbnail( '290-160-thumb' ); ?>

            </a>
            <?php
      } elseif ( $meta_video_url = get_metadata( 'post', get_the_ID(), 'wpcf-video-url', true ) ) {
            ?>
            <div class="iframe-container">
                  <?php
                  $shortcode = ' [embed width="640" height="390"]' . $meta_video_url . '[/embed]';

                  global $wp_embed;

                  echo $wp_embed->run_shortcode( $shortcode );
                  ?>
            </div>
            <?php
      }
      ?>
</article>
