<ul class="thumbs">
      <?php foreach ( $imgs_ids as $img_id ) { ?>
            <?php
            $thumb = wp_get_attachment_image_src( $img_id, '340-155-thumb' );
            $img = wp_get_attachment_image_src( $img_id );
            if ( !isset( $thumb[ 0 ], $img[ 0 ] ) )
                  next;
            if(!is_single())
                  $img[0] = get_permalink();
            ?>
            <li>
                  <a class="fancybox featured-image" href="<?php echo $img[ 0 ] ?>" rel="gallery">
                        <img src="<?php echo $thumb[ 0 ] ?>">
                  </a>
            </li>
            <?php
      }
      ?>
</ul>