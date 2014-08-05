
<?php get_header(); ?>

<div id="container">
        <div id="primary">
                <?php
                /* d('single cool place'); */
                global $post;

                if (have_posts()) {
                        while (have_posts()) {
                                the_post();
                                ?>

                                <section class="bg-50 block-5" style="overflow:visible">
                                        <article>
                                                <header style="top:0px; height: 50px;" class="hover">
                                                        <h1 class="ml5 sc-eee">
                                                                <?php the_title(); ?>
                                                        </h1>
                                                </header>
                                                <div class="featured-image" style="width:100%;">
                                                        <?php
                                                        /* the_post_thumbnail('single-thumb'); */
                                                        the_post_thumbnail();
                                                        ?>
                                                </div>

                                                <div class="mt5 ml5 meddium cb">
                                                        <?php
                                                        the_content();
                                                        ?>
                                                </div>

                                                <?php
                                                $mapa = get_post_meta(get_the_ID(), 'mapa', true);
                                                if ($mapa) {

                                                        $json_mapa = json_decode($mapa);
                                                        if (is_object($json_mapa)) {

                                                                /* d($json_mapa); */
                                                                ?>  
                                                                <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&sensor=true"></script>

                                                                <style>
                                                                        #map-canvas {
                                                                                height: 300px;
                                                                                width: 90%;
                                                                                margin: 10px auto;
                                                                        }
                                                                </style>
                                                                <script>

                                                                        function initialize() {
                                                                                var myLatlng = new google.maps.LatLng(<?php echo $json_mapa->lat ?>, <?php echo $json_mapa->long ?>);
                                                                                var mapOptions = {
                                                                                        zoom: 16,
                                                                                        center: myLatlng
                                                                                }
                                                                                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

                                                                                var marker = new google.maps.Marker({
                                                                                        position: myLatlng,
                                                                                        map: map,
                                                                                        title: '<?php the_title() ?>'
                                                                                });
                                                                        }

                                                                        google.maps.event.addDomListener(window, 'load', initialize);

                                                                </script>
                                                                <div id="map-canvas"></div>
                                                                <div style="text-align:center">
                                                                        <?php echo $json_mapa->address ?>
                                                                </div>
                                                                <?php
                                                        } else {
                                                                ?>
                                                                <div style="text-align:center">
                                                                        <?php echo $mapa ?>
                                                                </div>
                                                                <?php
                                                        }
                                                }
                                                ?>
                                                <?php
                                                include_once 'facebook/like-single.php';
                                                ?>


                                        </article>
                                </section>
                                <?php
                        }
                } else {
                        ?>
                        <h1 class="entry-title"><?php _e('No Posts Found.', 'attitude'); ?></h1>
                        <?php
                }
                ?>

                <div class="bg-50  block-5">

                        <h1 class="ml5">Comentarios</h1>
                        <?php
                        include_once 'facebook/comments.php';
                        ?>
                </div>

        </div>

        <div id="secondary">
                <?php get_sidebar('right'); ?>
        </div><!-- #secondary -->



</div><!--container-->

<?php
get_footer();
?>