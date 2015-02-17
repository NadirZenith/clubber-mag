<?php
/*
 * single post item (post coolplace news music podcast etc)
 */
?>
<section class="block-5 group ibox-5" >
      <article class="pr">
            <?php if ( get_post_type() != 'artist' ) : ?>
                  <header class="hover" style="z-index: 1000;top:0px; height: 50px;width: 100%; ">
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
                        if ( get_post_type() == 'podcast' ) {

                              $artist = get_posts( array(
                                    'connected_type' => 'artists_to_podcasts',
                                    'connected_items' => get_queried_object(),
                                    'nopaging' => true,
                                    'posts_per_page' => 1,
                                    'suppress_filters' => false
                                        ) );
                              if ( !empty( $artist ) ) {
                                    $artist = $artist[ 0 ];
                                    if ( !get_post_meta( get_the_ID(), 'soundcloud_special_guest', true ) ) {
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
                                                            <?php if ( get_post_meta( get_the_ID(), 'soundcloud_special_guest', true ) ) : ?>
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
                  </div>
                  <?php
                  ?>
            <?php endif; //not artist ?>
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
                              echo nz_get_soundcloud_iframe( $sc_info->uri, array( 'visual' => true, 'height' => 250 ) );
                        }
                        ?>
                  </div>
                  <?php
            }
            ?>
            <div class="m5">
                  <?php
                  if ( in_array( get_post_type(), array( 'post', 'music', 'photo', 'podcast' ) ) ) {
                        //post author info
                        ?>
                        <div class="fr cb" style="min-width: 200px;">
                              <?php
                              $default = get_template_directory_uri() . '/assets/images/user/user-profile-ph.jpg';
                              $url = nz_get_user_image( get_the_author_meta( 'ID' ), 'profile', $default );
                              ?>
                              <img class="fr ml5" src="<?php echo $url ?>" alt="clubber-mag-profile-picture" width="45" height="45">
                              <div class="fr" style="text-align: right;line-height: 1;">
                                    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
                                          <?php the_author_meta( 'display_name' ); ?> 
                                    </a>
                                    <br>
                                    <span class="sc-2 " style="font-size: 80%;">
                                          on <?php echo get_the_date(); ?>
                                    </span>
                              </div>
                        </div>
                        <?php
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
                  if ( in_array( get_post_type(), array( 'artist', 'label' ) ) ) {
                        get_template_part( 'tpl/parts/related-podcasts' );
                  }
                  ?>

                  <?php get_template_part( 'tpl/parts/mapa' ); ?>
            </div>

            <?php get_template_part( 'tpl/parts/comments' ); ?>

            <?php get_template_part( 'tpl/parts/post-tags' ); ?>
      </article>

</section>
<section class="group m5" >
      <h2 class="m3">
            <span class="cm-title2">
                  <?php _e( 'Related Contents', 'cm' ) ?>
            </span>
      </h2>
      <ul>
            <?php
            $args = array(
                  'posts_per_page' => 4,
                  'orderby' => 'rand',
                  'post_type' => get_post_type(),
                  'post__not_in' => array( get_queried_object_id() )
            );
            $query = new WP_Query( $args );
            /* d( $query ); */
            $ids = array();
            while ( $query->have_posts() ) {
                  $query->the_post();
                  $ids[] = get_the_ID();
                  ?>
                  <li class="col-1-4 fl">
                        <div class="ibox-3">
                              <?php
                              get_template_part( 'tpl/home/list-2' );
                              ?>
                        </div>
                  </li>
                  <?php
            }
            wp_reset_postdata();
            ?>
      </ul>     
</section>