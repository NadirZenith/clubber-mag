<?php
/*
 * podcast archive single item
 */
?>
<article>
      <?php
      $special = get_post_meta( get_the_ID(), 'soundcloud_special_guest', true );
      if ( $special ) {
            ?>
            <div class="pr col-1">
                  <?php
                  if ( has_post_thumbnail() ) {
                        ?>
                        <a class="featured-image" href="<?php the_permalink() ?>" >
                              <?php
                              the_post_thumbnail( '650-300-thumb' );
                              ?>
                        </a>
                        <?php
                  }
                  ?>
                  <i class="clubbermag-podcast-wm"></i>
                  <?php
                  $args = array(
                        'post_type' => 'artist',
                        'lang' => 'es',
                        'posts_per_page' => 1,
                        'connected_items' => get_post(),
                        'nopaging' => true,
                        'connected_type' => 'artists_to_podcasts',
                  );


                  $query2 = new WP_Query( $args );
                  if ( $query2->have_posts() ) {
                        ?>
                        <div class="hover-3">
                              <div class="pod-title">
                                    <a href="<?php the_permalink(); ?>">
                                          <span class="sc-1">
                                                Special Guest
                                          </span>
                                          <?php echo $query2->post->post_title ?>
                                          <span class="sf-2" style="font-size: 60%">
                                                <?php the_date(); ?>
                                          </span>
                                    </a>
                              </div>
                        </div>
                        <?php
                  }
                  ?>


            </div>
            <?php
      }
      ?>
      <div class="fr col-1">

            <?php
            if ( $sc_info_str = get_post_meta( get_the_ID(), CM_META_SOUNDCLOUD, true ) ) {
                  $sc_info = json_decode( $sc_info_str );
                  /* d( $sc_info_str, $sc_info ); */
                  if ( $sc_info ) {
                        echo nz_get_soundcloud_iframe( $sc_info->uri, array( 'visual' => true ) );
                  }
            }
            ?>
      </div>

</article>
