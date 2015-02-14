
<?php
if (
          $mapa = get_post_meta( get_the_ID(), CM_META_MAPA, true )
 ) {
      $json_mapa = json_decode( $mapa, true );
      /* d( $json_mapa ); */
      if ( isset( $json_mapa, $json_mapa[ 'type' ] ) ) {

            if ( $json_mapa[ 'type' ] == 'map' ) {
                  ?>  
                  <style>
                        #map-canvas {
                              height: 300px;
                              width: 90%;
                              margin: 10px auto;
                        }
                  </style>

                  <div class="cb">
                        <script>
                              jQuery(document).ready(function($) {
                                    function nz_map(id, lat, lng, options) {
                                          var myLatlng = new google.maps.LatLng(lat, lng);
                                          console.log(myLatlng);
                                          var mapOptions = {
                                                zoom: 13,
                                                center: myLatlng
                                          };

                                          $.extend(mapOptions, options);

                                          var map = new google.maps.Map(document.getElementById(id), mapOptions);

                                          var marker = new google.maps.Marker({
                                                position: myLatlng,
                                                map: map,
                                                title: '<?php the_title() ?>'
                                          });

                                    }
                  <?php
                  if ( isset( $json_mapa[ 'components' ][ 'lat' ], $json_mapa[ 'components' ][ 'lng' ] ) ) {
                        ?>

                                          google.maps.event.addDomListener(window, 'load', function() {
                                                nz_map('map-canvas',
                        <?php echo $json_mapa[ 'components' ][ 'lat' ] ?>,
                        <?php echo $json_mapa[ 'components' ][ 'lng' ] ?>,
                                                        {
                                                              zoom: 15
                                                        }
                                                );
                                          });
                        <?php
                  }
                  ?>
                              });

                        </script>

                        <div id="map-canvas" class="map-canvas mt10"></div>
                        <div class="tc">
                              <span class="smalling">
                                    <?php echo $json_mapa->address ?>
                              </span>
                        </div>

                  </div>
                  <?php
            } elseif ( $json_mapa[ 'type' ] == 'raw' ) {
                  /* d( 'raw' ); */
            }
      }
}
?>