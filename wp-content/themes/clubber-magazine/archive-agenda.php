
<?php
$tax = 'city';
if ( is_tax( $tax ) ) {
      global $wp_query;
      $term = $wp_query->get_queried_object();
      $city = ucfirst( $term->name );
}
?>

<main role="main">
      <div class="mb30 mt15">
            <?php
            get_template_part( 'tpl/parts/featured-events' );
            ?>
      </div>

      <div class="has-sidebar">
            <div class="ml5">
                  <h1 class="h2">
                        <?php
                        _e( 'Party and Events of the week', 'cm' );
                        echo ($city) ? ' ' . __( 'in', 'cm' ) . ' ' . $city : '';
                        ?> 
                  </h1>
            </div>

            <?php
            $query = &$wp_query;
            nz_pagination_by_date();

            $main_posts_id = array();
            include('tpl/archive/agenda.php');
            nz_pagination_by_date();
            ?>

            <?php
            /*   LESS THAN 5 EVENTS        */
            if ( $query->found_posts < 5 ) {

                  $date = get_query_var( 'date' );

                  $DateTime = DateTime::createFromFormat( 'd-m-Y', $date );
                  if ( $DateTime ) {
                        $DateTime->setTime( 0, 0, 0 ); //to avoid date problems
                        $start_date = $DateTime->getTimestamp();
                  } else {
                        $start_date = strtotime( "now" );
                  }

                  $args = array(
                        'post_type' => 'agenda',
                        'post__not_in' => $main_posts_id,
                        'posts_per_page' => 10,
                        'order' => 'ASC',
                        'orderby' => 'meta_value_num',
                        'meta_key' => 'wpcf-event_begin_date',
                        'meta_query' => array(
                              array(
                                    'key' => 'wpcf-event_begin_date',
                                    'value' => $start_date,
                                    'compare' => '>='
                              )
                        )
                  );

                  $query = new WP_Query( $args );
                  if ( $query->found_posts > 0 ) {
                        ?>
                        <div class="ml5 mb15">
                              <h1 class="h2">
                                    <?php _e( 'Next parties and events', 'cm' ) ?> <?php echo ($city) ? "en {$city}" : ''; ?>               
                              </h1>
                        </div>


                        <?php include('tpl/archive/agenda.php'); ?>

                        <?php
                  }
            }
            /*  --------- //END LESS THAN 5 EVENTS        */
            ?>
      </div>

</main>
<aside role="complementary">
      <?php get_sidebar(); ?>
      <?php
      if ( is_active_sidebar( 'banners_sidebar' ) ) {
            dynamic_sidebar( 'banners_sidebar' );
      }
      ?>
</aside>