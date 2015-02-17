<?php
$args = array(
      'post_type' => 'podcast',
      'posts_per_page' => 5,
      'connected_items' => get_queried_object(),
);

if ( get_post_type() == 'artist' )
      $args[ 'connected_type' ] = 'artists_to_podcasts';
elseif ( get_post_type() == 'label' )
      $args[ 'connected_type' ] = 'labels_to_podcasts';

$query2 = new WP_Query( $args );
if ( $query2->have_posts() ) {
      ?>
      <div class="homeCustomScroll oh" style="height: 428px;">
            <?php
            while ( $query2->have_posts() ) {
                  $query2->the_post();
                  ?>
                  <div class="col-1 fl">
                        <article>
                              <div class="hover-2">
                                    <h2 class="ml5 sf-2">
                                          <a href="<?php the_permalink(); ?>">
                                                <?php the_title() ?>
                                          </a>
                                    </h2>
                              </div>
                              <div class="col-1">
                                    <?php
                                    if ( $sc_info_str = get_post_meta( get_the_ID(), CM_META_SOUNDCLOUD, true ) ) {
                                          $sc_info = json_decode( $sc_info_str );
                                          if ( $sc_info ) {
                                                echo nz_get_soundcloud_iframe( $sc_info->uri, array( 'visual' => TRUE ) );
                                          }
                                    }
                                    ?>
                              </div>
                        </article>
                  </div>
                  <?php
            } //END while
            // Prevent weirdness
            wp_reset_postdata();
            ?>
      </div>
      <?php
}
?>

<script>
      (function($) {
            $(window).load(function() {
                  $(".homeCustomScroll").mCustomScrollbar({});
            });
      })(jQuery);
</script>