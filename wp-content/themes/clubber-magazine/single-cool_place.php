
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
                                    <div class="fr mt5 mr5 cb">
                                          <span class=""style="color: #666;">
                                                <?php echo get_the_date(); ?>
                                          </span>
                                    </div>
                                    <div class="mt5 ml5 meddium cb">
                                          <?php
                                          the_content();
                                          ?>
                                    </div>

                                    <?php
                                    $map = get_field('map');
                                    /* d($map); */
                                    if ($map) {
                                          ?>  
                                          <style>
                                                #map-canvas {
                                                      height: 300px;
                                                      width: 80%;
                                                      margin: 10px auto;
                                                }
                                          </style>
                                          <script>

                                                function initialize() {
                                                      var myLatlng = new google.maps.LatLng(<?php echo $map['lat'] ?>, <?php echo $map['lng'] ?>);
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

                                                var map;
                                                function initialize2() {
                                                      var mapOptions = {
                                                            zoom: 15,
                                                            center: new google.maps.LatLng(<?php echo $map['lat'] ?>, <?php echo $map['lng'] ?>)
                                                      };
                                                      map = new google.maps.Map(document.getElementById('map-canvas'),
                                                              mapOptions);
                                                }

                                                google.maps.event.addDomListener(window, 'load', initialize);

                                          </script>
                                          <div id="map-canvas"></div>
                                          <?php
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