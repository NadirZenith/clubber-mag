<?php
if (
          $mapa = get_post_meta( get_the_ID(), 'mapa', true )
 ) {
      $json_mapa = json_decode( $mapa );
      if ( is_object( $json_mapa ) ) {
            ?>  
            <div class="cb">

                  <?php
                  //https://maps.googleapis.com/maps/api/staticmap?center=Brooklyn+Bridge,New+York,NY&zoom=13&size=600x300&maptype=roadmap&markers=color:blue|label:S|40.702147,-74.015794&markers=color:red%7Clabel:C%7C40.718217,-73.998284

                  $base = 'https://maps.googleapis.com/maps/api/staticmap?';
                  $center = 'Brooklyn+Bridge,New+York,NY&';
                  $zoom = 16;
                  $size = '450x200';
                  $type = 'roadmap';
                  $markers = array();
                  $key = 'AIzaSyBUIuQPZCCtI62ayOKoekvgEO0XhF8Hh-k';

                  //markers
                  $markers[] = sprintf( 'markers=color:%s|%s,%s', 'red', $json_mapa->lat, $json_mapa->long );
                  //$markers[] = sprintf( 'markers=color:%s|%s,%s', 'red', $json_mapa->lat, $json_mapa->long );
                  //$base.= sprintf( 'center=%s&', $center);
                  $base.= sprintf( 'zoom=%d&', $zoom );
                  $base.= sprintf( 'size=%s&', $size );
                  $base.= sprintf( 'maptype=%s&', $type );

                  $str = implode( '&', $markers );
                  $base.= $str . '&' . $key;
                  ?>
                  <div class="map-canvas featured-image mt10">
                        <img src="<?php echo $base ?>"/>
                  </div>
                  <div class="tc">
                        <span class="smalling">
                              <?php echo $json_mapa->address ?>
                        </span>
                  </div>
            </div>
            <?php
      }
}
?>