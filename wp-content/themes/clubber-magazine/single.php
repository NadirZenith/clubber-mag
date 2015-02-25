<?php
while ( have_posts() ) {
      the_post();
      switch ( get_post_type() ) {
            case 'label':
            case 'agenda':
                  get_template_part( 'tpl/single/single-1' );

                  break;

            default:
                  get_template_part( 'tpl/single/single-0' );

                  break;
      }
}
?>


<?php
$args = array(
      'post_type' => get_post_type(),
      'posts_per_page' => 4,
      'orderby' => 'rand',
      'post__not_in' => array( get_queried_object_id() )
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
}
$query = new WP_Query( $args );
if ( $query->have_posts() ) {
      ?>
      <section class="group m5" >
            <h2 class="m3">
                  <span class="cm-title2">
                        <?php _e( 'Related Contents', 'cm' ) ?>
                  </span>
            </h2>
            <ul>
                  <?php
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
      <?php
}
?>

<div class="featured-image banner-bottom cb"> 
      <?php
      echo do_shortcode( '[sam id=5]' );
      ?>
</div>
