<?php
/*
 * single post item (artist)
 */
/* d( 'single-2' ); */
?>
<section class="group m5" >
      <article>
            <div class="ibox-5">
                  <?php if ( get_post_type() == 'artist' ) { ?>
                        <?php get_template_part( 'tpl/parts/social-meta' ) ?>
                  <?php } ?>

                  <div class="mt15 tj">
                        <?php the_content(); ?> 
                  </div>
                  <div class="mt15 col-1">
                        <div class="iframe-container ">
                              <?php
                              /* d(get_post_meta( get_the_ID(), CM_META_SOUNDCLOUD, true )); */
                              if ( $url = get_post_meta( get_the_ID(), 'wpcf-link-soundcloud', true ) AND strlen( trim( $url ) ) > 10 ) {

                                    $shortcode = '[embed height="300"]' . $url . '[/embed]';
                                    global $wp_embed;
                                    echo $wp_embed->run_shortcode( $shortcode );
                              }
                              ?>
                        </div>
                  </div>

            </div>
      </article>

      <div class="cb pt15" >
            <h2 class="m3">
                  <span class="cm-title" >
                        Ultimos podcasts
                  </span>
            </h2>
            <ul>
                  <?php
                  $args = array(
                        'posts_per_page' => 3,
                        'orderby' => 'rand',
                        'post_type' => 'podcast',
                  );
                  $query = new WP_Query( $args );
                  /* d( $query ); */
                  $ids = array();
                  while ( $query->have_posts() ) {
                        $query->the_post();
                        $ids[] = get_the_ID();
                        ?>
                        <li class="col-1-3 fl">
                              <div class="ibox-3">
                                    <?php
                                    get_template_part( 'tpl/home/list-2' );
                                    ?>
                              </div>
                        </li>
                        <?php
                  }
                  ?>
                  <?php wp_reset_postdata(); ?>
            </ul>     
      </div>


      <div class="cb pt15">
            <h2 class="m3">
                  <span class="cm-title">
                        También te puede interesar
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
                  ?>
            </ul>     
            <?php wp_reset_postdata(); ?>
      </div>
      <?php get_template_part( 'tpl/parts/comments' ); ?>
</section>
<section class="group m5" >
      <h2 class="m3">
            <span class="cm-title2">
                  Contenidos relacionados
            </span>
      </h2>
      <ul>
            <?php
            $args = array(
                  'posts_per_page' => 4,
                  'orderby' => 'rand',
                  'post_type' => get_post_type(),
                  'post__not_in' => array_push( $ids, get_queried_object_id() )
            );
            $query = new WP_Query( $args );
            while ( $query->have_posts() ) {
                  $query->the_post();
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
            ?>
      </ul> 
</section>

