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

            <?php
            get_template_part( 'tpl/parts/comments' );
            ?>
      </article>
      <?php
      $tags = wp_get_post_tags( get_the_ID() );
      if ( !empty( $tags ) ) {
            if ( !is_wp_error( $tags ) ) {
                  ?>
                  <div class="cb pb15">
                        <div class="tag-list">
                              <span class="tags-icon"></span>
                              <ul>
                                    <?php
                                    foreach ( $tags as $tag ) {
                                          echo '<li><span>' . $tag->name . '</span></li>';
                                          /* echo '<li><a href="' . get_term_link( $tag ) . '">' . $tag->name . '</a></li>'; */
                                    }
                                    ?>
                              </ul>
                        </div>
                  </div>
                  <?php
            }
      }
      ?>

</section>
<section class="group m5" >
      <h2 class="m3">
            <span class="cm-title2">
                  <?php _e( 'Related Content', 'cm' ) ?>
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
            ?>
      </ul> 
</section>

