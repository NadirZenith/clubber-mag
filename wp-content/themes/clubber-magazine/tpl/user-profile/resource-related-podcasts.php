<?php
if ( $resource->post_type == 'artist' )
      $connected_type = 'open-frequency-to-artist';
elseif ( $resource->post_type == 'label' )
      $connected_type = 'open-frequency-to-label';

$connections = p2p_get_connections( $connected_type, array(
      'direction' => 'from',
      'from' => 'any',
      'to' => $resource,
      'fields' => 'p2p_from',
          ) );

if ( empty( $connections ) )
      return;

$args = array(
      'post_type' => array( 'open-frequency' ),
      'posts_per_page' => 5,
      'post__in' => $connections,
      'post_author' => $curauth->ID,
);
$query2 = new WP_Query( $args );
if ( $query2->have_posts() ) {
      ?>
      <div class="homeCustomScroll mt15 oh" style="min-height: 180px;max-height: 328px;">
            <?php
            while ( $query2->have_posts() ) {
                  $query2->the_post();
                  ?>
                  <div class="col-1 fl">
                        <div class="box-3">
                              <article>
                                    <?php
                                    if ( $curauth->ID == get_current_user_id() ) {
                                          $form_page_link = get_permalink( CM_RESOURCE_PODCAST_PAGE_ID );
                                          /* $form_page_link = get_permalink( cm_lang_get_post( CM_RESOURCE_PODCAST_PAGE_ID ) ); */
                                          $resource_edit_url = NZ_WP_Forms::link( $form_page_link, get_the_ID() );
                                          ?>
                                          <div class="p-detail">
                                                <?php if ( get_post_status() != 'publish' ) : ?>
                                                      <span style="color:red" title="<?php _e( 'pending review', 'cm' ) ?>"> <i class="fa fa-eye-slash"></i></span>
                                                <?php endif; ?>
                                                <a class="fancybox" data-fancybox-type="ajax" href="<?php echo $resource_edit_url ?>" title="<?php _e( 'edit', 'cm' ) ?>"><i class="fa fa-pencil-square-o"></i></a> 
                                          </div>
                                    <?php } ?>

                                    <div class="hover">
                                          <h2 class="ml5 sf-2">
                                                <a href="<?php the_permalink(); ?>">
                                                      <?php if ( get_the_title() ): ?>
                                                            <?php the_title() ?>
                                                      <?php else: ?>
                                                            Ver podcast
                                                      <?php endif; ?>
                                                </a>
                                          </h2>

                                    </div>
                                    <?php
                                    if ( $sc_info_str = get_post_meta( get_the_ID(), CM_META_SOUNDCLOUD, true ) ) {
                                          $sc_info = json_decode( $sc_info_str );
                                          /* d( $sc_info_str, $sc_info ); */
                                          if ( $sc_info ) {
                                                echo nz_get_soundcloud_iframe( $sc_info->uri );
                                          }
                                    }
                                    ?>
                              </article>
                        </div>
                  </div>
                  <?php
            } //END while
            // Prevent weirdness
            wp_reset_postdata();
            ?>
      </div>

      <script>
            (function($) {
                  $(window).load(function() {

                        $(".homeCustomScroll").mCustomScrollbar();

                  });
            })(jQuery);
      </script>
      <?php
}
?>
