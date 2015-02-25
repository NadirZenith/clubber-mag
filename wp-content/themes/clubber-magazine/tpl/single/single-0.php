<?php
/*
 * single post item (post coolplace news music video photo podcast etc)
 */
?>
<section class="block-5 group ibox-5" >
      <article class="pr">
            <?php if ( get_post_type() != 'artist' ) : ?>
                  <header class="hover" style="z-index: 1000;top:0px; height: 35px;width: 100%; ">
                        <h1 class="p5">
                              <?php the_title(); ?> 
                        </h1>
                  </header>
                  <div class="pr">
                        <?php if ( has_post_thumbnail() ) : ?>
                              <div class="featured-image col-1 cb">
                                    <?php
                                    the_post_thumbnail();
                                    ?>
                              </div>
                        <?php endif; ?>
                        <?php
                        if ( in_array( get_post_type(), array( 'into-the-beat', 'open-frequency' ) ) ) {

                              $args = array(
                                    'connected_items' => get_queried_object(),
                                    'nopaging' => true,
                                    'posts_per_page' => 1,
                                    'suppress_filters' => false
                              );

                              if ( get_post_type() == 'into-the-beat' ) {
                                    $args[ 'connected_type' ] = 'into-the-beat-to-artist';
                              } elseif ( get_post_type() == 'open-frequency' ) {
                                    $args[ 'connected_type' ] = 'open-frequency-to-artist';
                              }

                              $artist = get_posts( $args );

                              if ( !empty( $artist ) ) {
                                    $artist = $artist[ 0 ];
                                    if ( get_post_type() == 'open-frequency' ) {
                                          ?>
                                          <div class="featured-image col-1 cb">
                                                <?php
                                                echo get_the_post_thumbnail( $artist->ID, 'single' );
                                                ?>
                                          </div>
                                          <?php
                                    }
                                    ?>
                                    <i class="clubbermag-podcast-wm"></i>
                                    <div class="hover-3">
                                          <div class="pod-title">
                                                <a href="<?php echo get_permalink( $artist ) ?>">
                                                      <span class="sc-1">
                                                            <?php if ( get_post_type() == 'into-the-beat' ) : ?>
                                                                  Special Guest
                                                            <?php else: ?>
                                                                  Open Signal
                                                            <?php endif ?>
                                                      </span>
                                                      <?php echo $artist->post_title ?>
                                                      <span class="sf-2" style="font-size: 60%">
                                                            <?php the_date(); ?>                                                               
                                                      </span>
                                                </a>
                                          </div>
                                    </div>

                              <?php } ?>
                        <?php } ?>
                        <?php
                        if ( get_post_type() == 'video' ) {
                              $meta_video_url = get_metadata( 'post', get_the_ID(), 'wpcf-video-url', true );
                              if ( $meta_video_url ) {
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
                        }
                        ?>
                  </div>

            <?php endif; //not artist    ?>

            <?php if ( in_array( get_post_type(), array( 'artist', 'label' ) ) ): ?>
                  <?php get_template_part( 'tpl/parts/social-meta' ) ?>
            <?php endif; ?>


            <?php
            $sc_info_str = get_post_meta( get_the_ID(), CM_META_SOUNDCLOUD, true );
            if ( $sc_info_str ) {
                  ?>
                  <div class="pt30" >
                        <?php
                        $sc_info = json_decode( $sc_info_str );
                        if ( $sc_info ) {
                              echo nz_get_soundcloud_iframe( $sc_info->uri, array( 'visual' => false ) );
                        }
                        ?>
                  </div>
                  <?php
            }
            ?>
            <div class="m5">
                  <?php
                  if ( in_array( get_post_type(), array( 'post', 'music', 'photo', 'into-the-beat', 'open-frequency' ) ) ) {
                        //post author info
                        get_template_part( 'tpl/parts/post-author-info' );
                  }
                  ?>

                  <div class="mt15 tj the-content">
                        <?php the_content(); ?> 
                  </div>

                  <?php
                  $imgs_ids = get_post_meta( get_the_ID(), 'photo-gallery', true );
                  if ( !empty( $imgs_ids ) ):
                        ?>
                        <div class="cb mt10 mb10">
                              <?php
                              include(locate_template( 'tpl/parts/gallery-list-preview.php' ));
                              ?>
                        </div>
                        <?php
                  endif;
                  ?>
                  <?php
                  if ( get_post_type() == 'artist' ) {
                        get_template_part( 'tpl/parts/related-into-the-beat' );
                  }

                  if ( in_array( get_post_type(), array( 'artist', 'label' ) ) ) {
                        get_template_part( 'tpl/parts/related-open-frequency' );
                  }
                  ?>

                  <?php get_template_part( 'tpl/parts/mapa' ); ?>
            </div>

            <?php get_template_part( 'tpl/parts/comments' ); ?>

            <?php get_template_part( 'tpl/parts/post-tags' ); ?>
      </article>

</section>
