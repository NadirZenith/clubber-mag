<?php
/* artist item */
?>
<article class="ibox-5">
      <header>
            <h2 class="mb5">
                  <a class="cm-title" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php
                        /* echo get_the_title() */
                        echo mb_strimwidth( get_the_title(), 0, 32, ' ...' );
                        ?>
                  </a>
            </h2>
      </header>
      <?php if ( WP_DEBUG ) { ?>
            <div style="position: absolute; right: 5px;top: 0;">
                  [<a href="<?php echo get_edit_post_link( get_the_ID() ); ?>">
                        editar
                  </a>]
            </div>
      <?php } ?>
      <div class="col-1" style="min-height: 160px">
            <?php
            if ( has_post_thumbnail() ) {
                  ?>
                  <a class="featured-image" href="<?php the_permalink() ?>">
                        <?php the_post_thumbnail( '290-160-thumb' ); ?>
                  </a>
                  <?php
            }
            ?>     
      </div>
      <div class="m3 tj" style="min-height: 80px">
            <?php
            echo wp_trim_words( get_the_content(), 16, $more = null );
            ?>
      </div>
      <!--      
      <a class="readmore" href="<?php the_permalink() ?>" title="<?php the_title() ?>">
            <?php echo __( 'Read more', 'cm' ) ?>
      </a>
      -->
</article>