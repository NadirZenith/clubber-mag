<?php
/*
 * single - event | label 
 */
?>
<section class=" group ibox-5">
      <article>
            <div class="col-1 col-md-1-2 fl">
                  <?php if ( has_post_thumbnail( $post->ID ) ): ?>
                        <?php
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) );
                        ?>
                        <a href="<?php echo $image[ 0 ] ?>" class="featured-image fancybox" title="<?php the_title() ?>">
                              <?php
                              the_post_thumbnail();
                              $back_flyer_url = get_post_meta( get_the_ID(), 'wpcf-event_flyer_back', true );
                              ?>
                        </a>
                  <?php endif; ?>
                  <?php
                  if ( get_post_type() == 'agenda' && $back_flyer_url ) {
                        ?>
                        <div class="mt15">
                              <a href="<?php echo $back_flyer_url ?>" class="featured-image fancybox" title="<?php the_title() ?>">
                                    <img src="<?php echo $back_flyer_url ?>" alt="<?php _e( 'backflyer', 'cm' ) ?>" />
                              </a>
                        </div>
                        <?php
                  }
                  ?>

            </div>
            <div class="col-1 col-md-1-2 fl">
                  <div class="ibox-5"> 
                        <header class="mt30 pr15">
                              <h1>
                                    <span class="cm-title">
                                          <?php the_title(); ?>
                                    </span>
                              </h1>
                        </header>
                        <?php if ( get_post_type() == 'agenda' ) { ?>
                              <?php get_template_part( 'tpl/parts/event-meta' ) ?>
                        <?php } ?>
                        <?php if ( get_post_type() == 'label' ) { ?>
                              <?php get_template_part( 'tpl/parts/social-meta' ) ?>
                        <?php } ?>
                        <div class="mt15 tj">
                              <?php the_content(); ?> 
                        </div>
                  </div>
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
                  'post_type' => get_post_type(),
                  'lang' => 'es, en',
                  'posts_per_page' => 4,
                  'orderby' => 'rand'
            );
            if ( get_post_type() == 'agenda' ) {

                  $args[ 'meta_query' ] = array(
                        array(
                              'key' => 'wpcf-event_begin_date',
                              'value' => time(),
                              'type' => 'NUMERIC',
                              'compare' => '>='
                        )
                  );
            } else {

                  $args[ 'post__not_in' ] = array_push( $ids, get_queried_object_id() );
            }
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
            wp_reset_postdata();
            ?>
      </ul> 
</section>