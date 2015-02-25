<?php
/*
 * podcast archive single item
 */
?>
<article>
      <?php
      if ( is_post_type_archive( 'open-frequency' ) ) {
            $args = array(
                  'post_type' => 'artist',
                  'post_status' => 'any',
                  'posts_per_page' => 1,
                  'connected_items' => get_post(),
                  'connected_type' => 'open-frequency-to-artist',
            );

            $query2 = new WP_Query( $args );
            ?>
            <header class="m5">
                  <?php if ( $query2->have_posts() ): ?>
                        <div class="fr">
                              <?php _e( 'by', 'cm' ) ?>
                              <a class="bold" href="<?php echo get_permalink( $query2->post->ID ); ?>">
                                    <?php echo $query2->post->post_title ?>
                              </a>
                        </div>
                  <?php endif; ?>
                  <h2>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                              <?php
                              $mytitle = get_the_title();
                              if ( strlen( $mytitle ) > 65 ) {
                                    $mytitle = substr( $mytitle, 0, 65 ) . '...';
                              }
                              echo $mytitle;
                              ?>
                        </a>
                  </h2>
            </header>

            <hr class="pb5 cb">
            <?php
      }
      ?>
      <?php
      if ( get_post_type() == 'into-the-beat' ) {
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
                        'posts_per_page' => 1,
                        'connected_items' => get_post(),
                        'nopaging' => true,
                        'connected_type' => 'into-the-beat-to-artist',
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
