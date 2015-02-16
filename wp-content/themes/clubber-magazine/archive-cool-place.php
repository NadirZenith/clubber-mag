<?php
if ( is_tax() ) :
      ?>
      <header class="mt15 mb10">
            <h1>
                  <span class="cm-title">
                        <?php
                        single_tag_title();
                        ?>
                  </span>
            </h1>
      </header>
      <?php
elseif ( false ) :
      ?>
      <header class="mt15 mb10">
            <h1 class="h3">
                  Clubber Mag te invita a visitar los lugares más frescos y mejor valorados en tu ciudad donde podrás disfrutar de la calidad de sus servicios además del confort de sus ambientes.
            </h1>
      </header>

      <?php
endif;
?>

<?php
if ( !is_tax() )
      get_template_part( 'tpl/parts/featured-coolplaces' );
?>

<div class="m5 p5 menu-az">

      <?php
      $letter = (isset( $_GET[ 'first-letter' ] )) ? $_GET[ 'first-letter' ] : null;
//call MENU
      $after = '';
      $terms = get_terms( 'cool_place_type' );
      foreach ( $terms as $term ) {
            $after .= '[ <a href="' . get_term_link( $term ) . '">' . $term->name . '</a> ]';
      }


      $coolplace_form_url = get_permalink( cm_lang_get_post( CM_RESOURCE_COOLPLACE_PAGE_ID ) );
      $after .= '&nbsp;&nbsp;<a class="readmore" href="' . $coolplace_form_url . '">' . __( 'Add new place', 'cm' ) . '</a>';

      menu_a_z( $letter, '', $after );
      ?>        
</div>
<div class="cb"></div>

<?php
//QUERY BY FIRST LETTER
$term_name = get_query_var( 'cool_place_type', '' );

$term = get_term_by( 'name', $term_name, 'cool_place_type' );
query_by_first_letter( 'cool-place', $letter, $term );
?>

<div class="cb"></div>
<div class="m5 p5 menu-all-first-letter">
      <?php
//sort_all_by_first_letter
      sort_all_by_first_letter( 'cool-place', $term );
      ?>
</div>

<div class="cb"></div>

<?php
$args = array(
      'post_type' => 'cool-place',
      'orderby' => 'title',
      'order' => 'ASC',
      'posts_per_page' => 10
);

$query = new WP_Query( $args );
if ( $query->have_posts() ) {
      $places = array();
      while ( $query->have_posts() ) {
            $query->the_post();
            /* d( get_post_meta( get_the_ID() ) ); */
            //$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '290-160-thumb' );
            $url = $thumb[ '0' ];
            $mapa = get_post_meta( get_the_ID(), 'mapa', true );
            $map_json = json_decode( $mapa );
            if ( $map_json && isset( $map_json->lat ) && isset( $map_json->long ) ) {
                  $places[] = array(
                        'lat' => $map_json->lat,
                        'lng' => $map_json->long,
                        'title' => get_the_title(),
                        'img' => get_the_post_thumbnail( get_the_ID(), '290-160-thumb' ),
                        'url' => $url,
                  );
            }
            /* d( $mapa ); */
      }
}
?>


<script>


      var places = <?php echo json_encode( $places ) ?>;
      var markers = [];
      var infowindows = [];
      var preloads = [];

      function initialize() {
            var myLatlng = new google.maps.LatLng(41.381300, 2.167136);
            var mapOptions = {
                  zoom: 13,
                  center: myLatlng
            }
            var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

            for (i = 0; i < places.length; ++i) {
                  markers[i] = new google.maps.Marker({
                        position: new google.maps.LatLng(places[i]['lat'], places[i]['lng']),
                        map: map,
                        title: places[i]['title']
                  });
                  //store images to preload
                  if (places[i]['url']) {
                        preloads[i] = places[i]['url'];
                  } else {
                        preloads[i] = 'http://lab.dev/clubber-mag-dev/wp-content/themes/clubber-magazine/assets/css/img/placeholder.jpg';
                  }

                  //infowindow content
                  var contentString = '<h1>' + places[i]['title'] + '</h1><div style="height:110px;">'
                          + '<img style="display:block;margin:0 auto;" width="190" ' + 'src="' + places[i]['url'] + '"></img></div>';
                  /*width="290" height="160"*/

                  //infowindow
                  infowindows[i] = new google.maps.InfoWindow({
                        content: contentString
                  });

                  //marker mouseover
                  google.maps.event.addListener(markers[i], 'mouseover', function() {
                        var y = markers.indexOf(this);
                        infowindows[y].open(map, markers[y]);
                  });

                  //marker mouseout
                  google.maps.event.addListener(markers[i], 'mouseout', function() {
                        var y = markers.indexOf(this);
                        window.setTimeout(function() {
                              infowindows[y].close();
                        }, 1500);
                  });

            }//end for
            preload(preloads);

      }

      /*var images = new Array();*/
      var images = [];
      function preload() {
            console.log(preload.arguments);
            console.log(preload.arguments.length);
            for (i = 0; i < preload.arguments.length; i++) {
                  images[i] = new Image()
                  images[i].src = preload.arguments[i]
            }
      }

      //initialize map
      google.maps.event.addDomListener(window, 'load', initialize);

      //Array.indexOf fallback
      if (!Array.prototype.indexOf) {
            Array.prototype.indexOf = function(searchElement /*, fromIndex */) {
                  "use strict";
                  if (this == null) {
                        throw new TypeError();
                  }
                  var t = Object(this);
                  var len = t.length >>> 0;
                  if (len === 0) {
                        return -1;
                  }
                  var n = 0;
                  if (arguments.length > 1) {
                        n = Number(arguments[1]);
                        if (n != n) { // para verificar si es NaN
                              n = 0;
                        } else if (n != 0 && n != Infinity && n != -Infinity) {
                              n = (n > 0 || -1) * Math.floor(Math.abs(n));
                        }
                  }
                  if (n >= len) {
                        return -1;
                  }
                  var k = n >= 0 ? n : Math.max(len - Math.abs(n), 0);
                  for (; k < len; k++) {
                        if (k in t && t[k] === searchElement) {
                              return k;
                        }
                  }
                  return -1;
            }
      }
</script>

<style>
      #map-canvas {
            width: 80%;
            height: 450px;
      }
</style>
<div id="map-canvas" class="m15"></div>

