<?php
/*
 * home photo list
 */
?>
<article>
      <div class="pr">
            <header class="hover-2">
                  <h2 class="sf-2 m5">
                        <a href="<?php the_permalink() ?>">
                              <?php the_title() ?>
                        </a>
                  </h2>
            </header>
            <a class="featured-image" href="<?php the_permalink() ?>">
                  <?php the_post_thumbnail( '430-190-thumb' ); ?>
            </a>
      </div>
      <?php
      $gallery = get_post_gallery( get_the_ID(), FALSE );
      if ( $gallery ):
            $imgs_ids = explode( ',', $gallery[ 'ids' ] );
      else:
            $imgs_ids = get_post_meta( get_the_ID(), 'photo-gallery', true );
      endif;
      if ( !empty( $imgs_ids ) ):
            $imgs_ids = array_slice( $imgs_ids, 0, 4 );
            ?>
            <div class="cb mt10 mb10">
                  <?php
                  include(locate_template( 'tpl/parts/acf-gallery-list-preview.php' ));
                  ?>
            </div>
            <?php
      endif;
      ?>
</article>