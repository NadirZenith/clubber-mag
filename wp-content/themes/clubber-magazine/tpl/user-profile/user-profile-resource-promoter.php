<?php
/**
 *     Preview List next events promoted by user
 */
$start_date = strtotime( "now" );

$args = array(
      'post_type' => 'agenda',
      //'lang' => implode( ', ', pll_languages_list() ),
      'post_status' => 'any',
      'author' => $curauth->ID, //by this author
      'posts_per_page' => 3,
      'order' => 'ASC',
      /*
       */
      'orderby' => 'meta_value_num',
      'meta_key' => 'wpcf-event_begin_date',
      'meta_query' => array(
            array(
                  'key' => 'wpcf-event_begin_date',
                  'value' => $start_date,
                  'type' => 'NUMERIC',
                  'compare' => '>='
            )
      )
);

$query = new WP_Query( $args );
if ( $query->have_posts() ) {
      ?>
      <section class="m5">
            <header class="m5 cb group">
                  <?php
                  $title = 'Eventos';

                  if ( $curauth->ID == get_current_user_id() ) :
                        $title = 'Mis Eventos';
                        ?>

                  <?php endif; ?>
                  <?php
                  $user_promoter_list_url = get_author_posts_url( $curauth->ID ) . 'eventos';
                  ?>
                  <h2>
                        <a href="<?php echo $user_promoter_list_url ?>" title="<?php _e( 'See all events', '' ) ?>">
                              <?php echo $title ?>
                        </a>
                  </h2>
            </header>

            <div class="bg-50 block-5">
                  <ul class="group">
                        <?php
                        while ( $query->have_posts() ) {
                              $query->the_post();
                              ?>
                              <li class="col-1-3 fl">
                                    <div class="ibox-3 mt0">
                                          <article>
                                                <div class="hover-2">
                                                      <h2 class="ml5 sf-2">
                                                            <a href="<?php the_permalink() ?>">
                                                                  <?php echo get_the_title(); ?>
                                                            </a>
                                                      </h2>
                                                </div>
                                                <div class="p-detail">
                                                      <?php if ( $date = get_post_meta( get_the_ID(), 'wpcf-event_begin_date', true ) ): ?>
                                                            <?php
                                                            echo date( 'd/m/y', $date );
                                                            $tax = 'city';
                                                            if ( $term = wp_get_post_terms( get_the_ID(), $tax )[ 0 ]->name ) {
                                                                  $link = get_term_link( $term, $tax );
                                                                  echo " <a href='{$link}'>{$term}</a>";
                                                            }
                                                            ?>
                                                      <?php endif; ?>
                                                      <?php if ( $curauth->ID == get_current_user_id() ): ?>
                                                            <?php if ( get_post_status() != 'publish' ) : ?>
                                                                  <span style="color:red" title="pendiente de revision"> <i class="fa fa-eye-slash"></i> </span>
                                                            <?php endif; ?>
                                                            <?php
                                                            $event_form_url = get_permalink( cm_lang_get_post( CM_RESOURCE_EVENT_PAGE_ID ) );

                                                            $edit_resource_link = NZ_WP_Forms::link( $event_form_url, get_the_ID() );
                                                            ?>
                                                            <a href="<?php echo $edit_resource_link ?>" title="<?php _e( 'edit', 'cm' ) ?>"><i class="fa fa-pencil-square-o"></i></a> 
                                                      <?php endif; ?>

                                                </div>
                                                <a class="featured-image" href="<?php the_permalink() ?>">
                                                      <?php echo get_the_post_thumbnail( get_the_ID(), '290-160-thumb' ); ?>
                                                      <?php //the_post_thumbnail( '340-155-thumb' );  ?>

                                                </a>
                                          </article>
                                    </div>
                              </li>
                              <?php
                        }
                        ?>
                  </ul>
                  <?php
                  if ( $curauth->ID == get_current_user_id() && $resource->post_type != 'cool-place' ) :
                        $event_form_url = get_permalink( cm_lang_get_post( CM_RESOURCE_EVENT_PAGE_ID ) );
                        ?>
                        <div class="pt10 pb5">
                              <a class="readmore responsive " href="<?php echo $event_form_url ?>"> 
                                    <?php _e( 'Compartir Evento', 'cm' ) ?>&nbsp;&nbsp;<i class="fa fa-users" style="color: #0583f2" ></i>
                              </a>
                        </div>

                        <?php
                  endif;
                  ?>
            </div>
      </section>
      <?php
}
wp_reset_postdata();
?>