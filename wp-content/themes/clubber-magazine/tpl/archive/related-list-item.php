<article class="fl col-1-4">
      <div class="hover-2" style="">
            <h2 class="ml5" style="line-height: normal">
                  <a style="" href="<?php the_permalink(); ?>">
                        <?php
                        echo get_the_title()
                        ?>
                  </a>
            </h2>
      </div>
      <div class="event-date" style="position: absolute; right: 0; top: 0px;">
            <?php
            $date = get_post_meta( get_the_ID(), 'wpcf-event_begin_date', true );
            echo date( 'd/m/y', $date );
            $tax = 'city';
            if ( $term = wp_get_post_terms( get_the_ID(), $tax )[ 0 ]->name ) {
                  $link = get_term_link( $term, $tax );
                  echo " <a href='{$link}'>{$term}</a>";
            }
            ?>
      </div>

      <a class="featured-image" href="<?php echo get_permalink( $event->ID ); ?>"  style="">
            <?php echo get_the_post_thumbnail( get_the_ID(), '290-160-thumb' ); ?>
      </a>
</article>