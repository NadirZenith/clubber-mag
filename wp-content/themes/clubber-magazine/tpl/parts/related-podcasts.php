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
      <ul>
            <?php
            while ( $query2->have_posts() ) {
                  $query2->the_post();
                  ?>
                  <li class="col-1 col-sm-1-2 col-lg-1-5 fl">
                        <div class="box-3">
                              <?php
                              get_template_part( 'tpl/home/list-2' );
                              ?>
                        </div>
                  </li>
                  <?php
            } //END while
            // Prevent weirdness
            wp_reset_postdata();
            ?>
      </ul>
      <?php
}
?>
