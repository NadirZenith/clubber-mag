<?php
/*
 * podcast archive single item
 */
?>
<article class="">
      <?php
      if ( is_post_type_archive( 'podcast' ) ) {
            ?>
            <header class="m5">
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

            <hr class="pb5">
            <?php
      }
      ?>
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
/*                  
                  $post_id = cm_lang_get_post( get_the_ID() );
                  d( $post_id );
                  if ( !$post_id ) {
                        global $polylang;
                        echo $polylang->get_post_language( get_the_ID() )->slug;
                        $test = get_posts( array(
                              'lang' => 'es',
                              'post_type' => 'podcast',
                              'p' => get_the_ID()
                                  ) );
                        setup_postdata( $test );
                        d( 'false cargar' );
                        d( $test );
                        $related = p2p_type( 'artists_to_podcasts' )->get_connected( $test[ 0 ] );
                        d( $related->post->post_title );
                  }



 */
                  $tpost = get_post();
                  /* d( $tpost ); */
                  /* d( get_post_meta( get_the_ID() ) ); */
                   /*wp_set_object_terms( get_the_ID(), array( 'es', 'en' ), 'language' ); */
                   /*wp_set_object_terms( get_the_ID(), array( 'es' ), 'language' ); */
                  $terms = get_the_terms( get_post(), 'language' );
                  /* d( $terms ); */
                  /* die(); */


                  /*
                   */
                  $args = array(
                        'post_type' => 'artist',
                        'lang' => 'es',
                        /* 'lang' => implode( ', ', pll_languages_list() ), */
                        /* 'posts_per_page' => 1, */
                        'connected_items' => get_post(),
                        'nopaging' => true,
                        'connected_type' => 'artists_to_podcasts',
                            /*
                              'tax_query' => array(
                              array(
                              'taxonomy' => 'language',
                              'field' => 'slug',
                              'terms' => implode( ', ', pll_languages_list() )
                              )
                              )
                             */
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
