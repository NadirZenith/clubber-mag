

<div id="primary">
      <style>
            .event-date:hover .sc-eee{
                  color: #333;
            }
            .fancybox-skin{
                  background-color: #999;
            }
      </style>
      <script type="text/javascript">
            jQuery(document).ready(function($) {
                  $('a.event-image').fancybox();

            });
      </script>
      <?php
      global $post;
      if ( have_posts() ) {
            while ( have_posts() ) {
                  the_post();
                  $event_end_date = get_post_meta( get_the_ID(), 'wpcf-event_end_date', true );
                  $post_timestamp = get_post_meta( get_the_ID(), 'wpcf-event_begin_date', true );

                  $taxonomy = 'city';
                  $term = wp_get_post_terms( get_the_ID(), $taxonomy );
                  if ( !is_wp_error( $term ) && ($term = $term[ 0 ]) ) {
                        $link = get_term_link( $term );
                        $city_name = $term->name;
                  }
                  ?>

                  <section class="bg-50 block-5 group" style="overflow:visible">
                        <article style="">
                              <div class="col-2-4 fl nm">
                                    <?php if ( has_post_thumbnail( $post->ID ) ): ?>
                                          <?php
                                          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) );
                                          ?>
                                          <a href="<?php echo $image[ 0 ] ?>" class="event-image featured-image">
                                                <?php
                                                the_post_thumbnail();
                                                ?>
                                          </a>
                                    <?php endif; ?>

                              </div>
                              <div class="mt15  col-2-4 fl">
                                    <div class="ml5"> 
                                          <header  class="mt30">
                                                <h1 style="line-height: normal;" class=" mr15">
                                                      <?php
                                                      the_title();
                                                      ?>
                                                </h1>
                                          </header>
                                          <hr>
                                          <div class="event-date" style="position: absolute; right: 0; top: 0px;font-size: 20px;padding: 2px;">
                                                <?php ?>
                                                <a  class="sc-eee" href="<?php echo add_query_arg( array( 'date' => urlencode( date( 'd-m-Y', $post_timestamp ) ) ), get_post_type_archive_link( 'agenda' ) ) ?>">
                                                      <?php echo date( 'l d/m/y', $post_timestamp ); ?>
                                                </a>
                                                <?php echo ' - ' . date( 'H:i', $post_timestamp ); ?>

                                                <?php
                                                if ( $event_end_date = get_post_meta( get_the_ID(), 'wpcf-event_end_date', true ) ) {
                                                      echo ' / ' . date( 'H:i', $event_end_date );
                                                }
                                                ?>
                                          </div>
                                          <div class="post-meta meddium" >
                                                <div class="fl col-2-4">
                                                      <ul>
                                                            <?php if ( $city_name ) { ?>
                                                                  <li class="event-city">
                                                                        <span class="bold">Ciudad: </span>
                                                                        <?php echo "<a href='{$link}' title='Eventos en {$city_name}'>{$city_name}</a>"; ?> 
                                                                  </li>
                                                            <?php } ?>
                                                            <li class="event-place-name">
                                                                  <span class="bold">Lugar: </span>
                                                                  <?php echo get_post_meta( get_the_ID(), 'wpcf-event_place_name', true ); ?>
                                                            </li>
                                                            <li class="event-place-address">
                                                                  <span class="bold"> Dirección: </span>  
                                                                  <?php echo get_post_meta( get_the_ID(), 'wpcf-event_place_address', true ); ?>
                                                            </li>

                                                      </ul>
                                                </div>
                                                <div class="fl col-2-4">
                                                      <ul>
                                                            <?php if ( $event_promoter = get_post_meta( get_the_ID(), 'wpcf-event_promoter', true ) ) { ?>
                                                                  <li class="event-promoter">
                                                                        <span class="bold"> Promotor: </span>
                                                                        <?php echo $event_promoter ?>
                                                                  </li>
                                                            <?php } ?>
                                                            <li class="event-price">
                                                                  <span class="bold">Precio: </span>
                                                                  <?php echo get_post_meta( get_the_ID(), 'wpcf-event_price', true ); ?>
                                                            </li>
                                                            <?php if ( $event_price_conditions = get_post_meta( get_the_ID(), 'wpcf-event_price_conditions', true ) ) { ?>
                                                                  <li class="event-price-conditions">
                                                                        <span class="bold">Condiciones del evento: </span>
                                                                        <?php echo $event_price_conditions; ?>
                                                                  </li>
                                                            <?php } ?>
                                                      </ul>

                                                </div>
                                          </div>
                                          <div class="cb">

                                          </div>
                                          <div class="mt30 cb meddium" style="text-align: justify;">
                                                <?php
                                                the_content();
                                                ?> 

                                          </div>
                                    </div>
                              </div>
                              <div class="featured-image ml15 mt15" style="width:400px;">
                                    <?php
                                    $attachment_id = get_post_meta( get_the_ID(), 'wpcf-event_flyer', true );
                                    if ( $attachment_id ) {
                                          $attachment = wp_get_attachment_image( $attachment_id, 'single-thumb' );
                                          ?>
                                          <?php echo $attachment ?>
                                                                                                                                                                                                                          <!--<img src="<?php echo $flyer ?>" alt="<?php echo get_the_title() ?>" />-->
                                          <?php
                                    }
                                    ?>
                              </div>
                              
                        </article>
                  </section>
                  <?php
            }
      }
      ?>
      <div class="bg-50  block-5" >

            <h1 class="ml5">Comentarios</h1>
            <?php
            include_once 'facebook/comments.php';
            ?>

      </div>

      <?php
      $tags = wp_get_post_tags( get_the_ID(), $args );
      if ( !empty( $tags ) ) {
            if ( !is_wp_error( $tags ) ) {
                  ?>
                  <div class="cb bg-50  block-5 mb15">
                        <div class="tag-list">
                              <span class="tags-icon"></span>
                              <ul>
                                    <?php
                                    foreach ( $tags as $tag ) {
                                          echo '<li><span>' . $tag->name . '</span></li>';
                                          /*echo '<li><a href="' . get_term_link( $tag ) . '">' . $tag->name . '</a></li>';*/
                                    }
                                    ?>
                              </ul>
                        </div>
                  </div>
                  <?php
            }
      }
      ?>

      <div class="cb bg-50  block-5">
            <h1 class="ml5">También te puede interesar</h1>
            <hr class="pb5">
            <?php
            $args = array(
                  'post_type' => get_post_type(),
                  'posts_per_page' => 4,
                  'order' => 'ASC',
                  'orderby' => 'meta_value_num',
                  'meta_key' => 'wpcf-event_begin_date',
                  'meta_query' => array(
                        /* 'relation' => 'AND', */
                        /* array(
                          'key' => 'wpcf-event_displayed',
                          'value' => 1,
                          'compare' => '=',
                          ),
                         */
                        array(
                              'key' => 'wpcf-event_begin_date',
                              'value' => time(),
                              'type' => 'NUMERIC',
                              'compare' => '>='
                        )
                  )
            );
            $query = new WP_Query( $args );
            $tpl_loop = array(
                  'query' => $query,
                  'container' => array(
                        'tag' => 'ul',
                        'id' => '',
                        'class' => ''
                  ),
                  'item_container' => array(
                        'tag' => 'li',
                        'id' => '',
                        'class' => ''
                  ),
                  'item_template' => array(
                        'template_part' => 'tpl/archive/related-list-item'
                  )
            );


            $loop = new NzTplLoop( $tpl_loop );
            ?>

            <?php echo $loop->render(); ?>
      </div>

</div>

<div id="secondary" >
      <?php
      get_sidebar( 'single-agenda' );
      ?>
</div>
