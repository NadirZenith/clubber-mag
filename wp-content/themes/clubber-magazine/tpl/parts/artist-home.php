<?php
$tn_id = get_post_thumbnail_id( get_the_ID() );
$img = wp_get_attachment_image_src( $tn_id, '1000-450-thumb' );
?>
<div class="home-featured-image" style="background-image:url('<?php echo $img[ 0 ] ?>'); " >
<!--      <div class="hover-3">
            <div class="pod-title">
                  <span class="sc-1">
                        <?php _e( 'Artist', 'cm' ) ?>
                  </span>
                  <span class="sc-eee">
                        <?php the_title() ?> 
                  </span>
            </div>
      </div>
-->
</div>