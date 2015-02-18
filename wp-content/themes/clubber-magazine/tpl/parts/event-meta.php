<?php
$begin_timestamp = get_post_meta( get_the_ID(), 'wpcf-event_begin_date', true );


$end_timestamp = get_post_meta( get_the_ID(), 'wpcf-event_end_date', true );



if ( $begin_timestamp ) {
      $begin_date = new DateTime();
      $begin_date->setTimestamp( $begin_timestamp );
      ?>
      <time class="p-detail" datetime="<?php echo $begin_date->format( 'l d/m/y H:i' ); ?>">
            <a href="<?php echo add_query_arg( array( 'date' => urlencode( $begin_date->format( 'd-m-Y' ) ) ), get_post_type_archive_link( 'agenda' ) ) ?>">
                  <?php
                  echo __( $begin_date->format( 'l' ), 'cm' );
                  echo $begin_date->format( ' d/m/y' );
                  ?>
            </a>
            <?php echo ' - ' . $begin_date->format( 'H:i' ); ?>

            <?php
            if ( $end_timestamp ) {
                  echo ' / ';
                  $end_date = new DateTime();
                  $end_date->setTimestamp( $end_timestamp );

                  $duration = $begin_date->diff( $end_date );

                  if ( $duration->days < 1 ) {
                        echo $end_date->format( 'H:i' );
                  } else {
                        ?>
                        <a href="<?php echo add_query_arg( array( 'date' => urlencode( $end_date->format( 'd-m-Y' ) ) ), get_post_type_archive_link( 'agenda' ) ) ?>">

                              <?php
                              echo __( $end_date->format( 'l' ), 'cm' );
                              echo $end_date->format( ' d/m/y' );
                              ?>
                        </a>

                        <?php
                        echo ' - ' . $end_date->format( 'H:i' );
                  }
            }
            ?>
      </time>
      <?php
}
?>
<hr class="mt5">
<?php
$event_place_id = get_post_meta( get_the_ID(), 'relation-to-coolplace', true );

if ( $event_place_id ) {
      $place = get_post( $event_place_id );
      $event_place_name = '<a href="' . get_permalink( $place ) . '">' . $place->post_title . '</a>';

      $mapaddress = get_post_meta( $place->ID, CM_META_MAPA, true );
      $mapaddress = json_decode( $mapaddress, true );
      /*d( $mapaddress );*/
      if ( isset( $mapaddress, $mapaddress[ 'components' ], $mapaddress[ 'components' ][ 'formatted_address' ] ) ) {
            /*d( 'new address' );*/
            $event_address = $mapaddress[ 'components' ][ 'formatted_address' ];
      }
      /*
       */
} else {

      $event_place_name = get_post_meta( get_the_ID(), 'wpcf-event_place_name', true );
      $event_address = get_post_meta( get_the_ID(), 'wpcf-event_place_address', true );
}
?>


<div class="event-meta" >
      <div class="group mt3 mb3">
            <div class="fl col-1-2">
                  <?php _e( 'City', 'cm' ) ?>:
                  <b>
                        <?php
                        $taxonomy = 'city';
                        $term = wp_get_post_terms( get_the_ID(), $taxonomy );
                        if ( !is_wp_error( $term ) && ($term = $term[ 0 ]) ) {
                              $link = get_term_link( $term );
                              $city_name = $term->name;
                        }
                        ?>
                        <?php if ( $city_name ) { ?>
                              <?php echo "<a href='{$link}' title='Eventos en {$city_name}'>{$city_name}</a>"; ?> 
                        <?php } ?>
                  </b>
            </div>
            <div class="fl col-1-2">
                  <?php _e( 'Promoter', 'cm' ) ?>:
                  <b>
                        <?php $event_promoter = get_post_meta( get_the_ID(), 'wpcf-event_promoter', true ); ?>
                        <?php echo ($event_promoter) ? $event_promoter : '-'; ?>
                  </b>
            </div>

      </div>

      <div class="group mt3 mb3">

            <div class="fl col-1-2">
                  <?php _e( 'Place', 'cm' ) ?>:
                  <b>
                        <?php if ( !is_null( $event_place_name ) ) { ?>
                              <?php echo $event_place_name ?>
                        <?php } ?>
                  </b>
            </div>
            <div class="fl col-1-2">
                  <?php _e( 'Price', 'cm' ) ?>:
                  <b>
                        <?php $event_price = get_post_meta( get_the_ID(), 'wpcf-event_price', true ) ?>
                        <?php if ( !is_null( $event_price ) ) { ?>
                              <?php echo $event_price ?>
                        <?php } ?>
                  </b>
            </div>
      </div>
      <?php $event_price_conditions = get_post_meta( get_the_ID(), 'wpcf-event_price_conditions', true ); ?>
      <?php if ( $event_price_conditions ) { ?>
            <div class="col-1 mt3 mb3">
                  <?php _e( 'Price Conditions', 'cm' ) ?>
                  <b>
                        <?php echo $event_price_conditions; ?>
                  </b>
            </div>
      <?php } ?>

      <div class="col-1 mt3 group">
            <?php _e( 'Address', 'cm' ) ?>:
            <b>
                  <?php if ( !is_null( $event_address ) ) { ?>
                        <?php echo $event_address ?>
                  <?php } ?>
            </b>
            <?php get_template_part( 'tpl/parts/mapa' ); ?>
            <?php //get_template_part( 'tpl/parts/mapa', 'image' );   ?>
      </div>

</div>
<hr>