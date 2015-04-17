<?php
$args = array(
    'post_type' => 'cool-place',
    'orderby' => 'title',
    'order' => 'ASC',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key' => CM_META_MAPA,
            'value' => 'map',
            'compare' => 'LIKE'
        )
    )
);

$query = new WP_Query($args);
if ($query->have_posts()) {
    $places = array();
    while ($query->have_posts()) {
        $query->the_post();
        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '290-160-thumb');
        $url = $thumb['0'];
        $mapa = get_post_meta(get_the_ID(), CM_META_MAPA, true);

        $json_mapa = json_decode($mapa, true);
        if (isset($json_mapa, $json_mapa['type'])) {
            if ($json_mapa['type'] == 'map' && isset($json_mapa['components']['lat'], $json_mapa['components']['lng'])) {
                $places[] = array(
                    'lat' => $json_mapa['components']['lat'],
                    'lng' => $json_mapa['components']['lng'],
                    'title' => get_the_title(),
                    'img' => get_the_post_thumbnail(get_the_ID(), '290-160-thumb'),
                    'url' => $url,
                );
            }
        }
    }
}
?>


<script>


    var places = <?php echo json_encode($places) ?>;
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
                preloads[i] = 'http://www.clubber-mag.com/clubber-mag/wp-content/themes/clubber-magazine/assets/css/img/placeholder.jpg';
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
            google.maps.event.addListener(markers[i], 'mouseover', function () {
                var y = markers.indexOf(this);
                infowindows[y].open(map, markers[y]);
            });

            //marker mouseout
            google.maps.event.addListener(markers[i], 'mouseout', function () {
                var y = markers.indexOf(this);
                window.setTimeout(function () {
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
        Array.prototype.indexOf = function (searchElement /*, fromIndex */) {
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