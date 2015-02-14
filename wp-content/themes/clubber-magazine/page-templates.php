<!--
 <main class="has-sidebar" role="main">

        </main>
-->
<?php
/* pure full

  <!--

  <link
  type="text/css"
  rel="stylesheet"
  href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css"
  >
  -->
 */

/* pure grid
  <!--[if lte IE 8]>
  <link rel="stylesheet" href="http://yui.yahooapis.com/combo?pure/0.5.0/base-min.css&pure/0.5.0/grids-min.css&pure/0.5.0/grids-responsive-old-ie-min.css">
  <![endif]-->
  <!--[if gt IE 8]><!-->
  <link rel="stylesheet" href="http://yui.yahooapis.com/combo?pure/0.5.0/base-min.css&pure/0.5.0/grids-min.css&pure/0.5.0/grids-responsive-min.css">
  <!--<![endif]-->
 */

function nz_header( $content, $class, $wrapper = '%s' ) {
      
}

/* Kint::enabled( false ); */
?>
<?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
            <section <?php post_class( 'ibox-5 box-5' ); ?>>
                  <article id="post-<?php the_ID(); ?>">

                        <header class="mt5 mb10">
                              <h1> <?php the_title(); ?> </h1>
                        </header>
                        <div>
                              <?php
                              the_content();
                              ?>
                        </div>
                  </article>
            </section>
      <?php endwhile; ?>
<?php else: ?>
      <div class="h1"><?php _e( 'No Posts Found.', 'cm' ); ?></div>
<?php endif; ?>

<div style="clear: both;"></div>


<div style="clear: both;"></div>
<?php
/* d( __DIR__ ); */
/* d( __FILE__ ); */
?>


<!--
FEATURED EVENTS 4 COLUMNS
-->

<?php
d( 'featured content' );
?>

<main role="main">
      <section class="featured-events bg-50 block-5 m5">
            <header class="m5">
                  <style>

                  </style>
                  <ul class="afl fr pr15">
                        <li>

                              (
                              <a href="http://lab.dev/clubber-mag-dev/cool-places/bares/">
                                    <i>link</i>
                              </a>,
                        </li>
                        <li>
                              <a href="http://lab.dev/clubber-mag-dev/cool-places/clubs/">
                                    <i>link</i>
                              </a>,
                        </li>
                        <li>
                              <a href="http://lab.dev/clubber-mag-dev/cool-places/restaurantes/">
                                    <i>link</i>
                              </a>
                              )
                        </li>
                  </ul>
                  <h2>
                        <a href="http://lab.dev/clubber-mag-dev/agenda/" >
                              Fiestas y Eventos Recomendados
                        </a>
                  </h2>
            </header>

            <div class="cb" id="flexslider-featured-events" >
                  <ul class="slides">
                        <?php
                        $query = new WP_Query( array(
                              'post_type' => 'agenda',
                              'posts_per_page' => 8,
                              'orderby' => 'rand' )
                        );
                        if ( $query->have_posts() ) {
                              $count = 0;
                              ?> 
                              <li>
                                    <ul>
                                          <?php
                                          while ( $query->have_posts() ) {
                                                $query->the_post();
                                                if ( $count == 4 ) {
                                                      ?>
                                                </ul>
                                          </li>
                                          <li>
                                                <ul>
                                                      <?php
                                                }
                                                ?>
                                                <li class="col-1-4 fl">
                                                      <div class="box-3">
                                                            <?php
                                                            get_template_part( 'tpl/home/list-2' );
                                                            ?>
                                                      </div>
                                                </li>
                                                <?php
                                                $count +=1;
                                          } //END while
                                          ?>
                                    </ul>
                              </li>
                              <?php
                        } //end if have posts
                        ?>
                  </ul>

            </div>

            <script type="text/javascript">
                  jQuery(document).ready(function($) {

                        $('#flexslider-featured-events').flexslider({
                              animation: "slide",
                              slideshowSpeed: 5000,
                              controlNav: false,
                              directionNav: false,
                              pauseOnHover: false,
                              direction: "horizontal",
                              reverse: false,
                              animationSpeed: 500,
                              prevText: "&lt;",
                              nextText: "&gt;",
                              easing: "linear",
                              slideshow: true,
                              useCSS: false
                        });
                  });
            </script>
      </section>
</main>


<!--

  <main class="has-sidebar" role="main">

        </main>

        <aside class="" role="complementary">

        </aside>
-->

<div style="clear: both;"></div>

<?php d( 'home page' ); ?>
<!--
HOME ARCHIVE NEWS
-->
<main role="main">

      <div class="home-list">
            <div class="col-1 fl">
                  <?php get_template_part( 'tpl/parts/home-last-news' ); ?>
            </div>
            <!--
            HOME PHOTO AND VIDEO ARCHIVE 
            -->
            <div class="col-2 fr">
                  <section class="music bg-50 block-5 m5">
                        <header class="m5 h2">
                              <a href="http://lab.dev/clubber-mag-dev/musica/">
                                    Música
                              </a>
                        </header>

                        <ul>
                              <?php
                              $query = new WP_Query( array(
                                    'post_type' => 'musica',
                                    'posts_per_page' => 4,
                                    'orderby' => 'rand' )
                              );
                              while ( $query->have_posts() ) {
                                    $query->the_post();
                                    ?>
                                    <li class="mb5">
                                          <?php
                                          get_template_part( 'tpl/home/list-1' );
                                          ?>

                                    </li>
                                    <?php
                              }
                              ?>

                        </ul>


                        <a href="http://lab.dev/clubber-mag-dev/musica/" class="fr">ver más...</a>
                  </section>
            </div>

            <div class="col-3 fl">
                  <section class="photo bg-50 block-5 m5">
                        <header class="m5 h2">
                              <a href="http://lab.dev/clubber-mag-dev/photo/">
                                    Galería de Fotos
                              </a>
                        </header>
                        <div class="gallery-slideshow">
                              <ul class="slides">
                                    <?php
                                    $query = new WP_Query( array(
                                          'post_type' => 'photo',
                                          'posts_per_page' => 3,
                                          'orderby' => 'rand' )
                                    );
                                    while ( $query->have_posts() ) {
                                          $query->the_post();
                                          //$permalink = get_permalink();
                                          ?>
                                          <li>
                                                <?php
                                                get_template_part( 'tpl/home/photo-list-0' );
                                                ?>

                                          </li>
                                          <?php
                                    }
                                    ?>
                              </ul>
                        </div>


                        <script type="text/javascript">

                              jQuery(document).ready(function($) {

                                    $('.gallery-slideshow').flexslider({
                                          animation: "fade",
                                          slideshowSpeed: 5000,
                                          controlNav: false,
                                          directionNav: false,
                                          pauseOnHover: false,
                                          direction: "horizontal",
                                          reverse: false,
                                          animationSpeed: 1000,
                                          prevText: "&lt;",
                                          nextText: "&gt;",
                                          easing: "linear",
                                          slideshow: true,
                                          useCSS: false});
                              });
                        </script>        
                  </section>

                  <section class="video bg-50 block-5 m5 pb15">
                        <header class="m5 h2">
                              <a href="http://lab.dev/clubber-mag-dev/video/">
                                    Video review
                              </a>
                        </header>

                        <ul>

                              <?php
                              $query = new WP_Query( array(
                                    'post_type' => 'video',
                                    'posts_per_page' => 1,
                                    'orderby' => 'rand' )
                              );
                              while ( $query->have_posts() ) {
                                    $query->the_post();
                                    $permalink = get_permalink();
                                    ?>
                                    <li>
                                          <?php
                                          get_template_part( 'tpl/home/video-list-0' );
                                          ?>
                                    </li>
                                    <?php
                              }
                              ?>
                        </ul>
                        <script type="text/javascript">

                              jQuery(document).ready(function($) {

                                    $('.video-slideshow').flexslider({
                                          animation: "fade",
                                          slideshowSpeed: 5000,
                                          controlNav: false,
                                          directionNav: false,
                                          pauseOnHover: false,
                                          direction: "horizontal",
                                          reverse: false,
                                          animationSpeed: 1000,
                                          prevText: "&lt;",
                                          nextText: "&gt;",
                                          easing: "linear",
                                          slideshow: true,
                                          useCSS: false});
                              });
                        </script>  
                  </section>
            </div>
            <!---->
            <div class="fl" >
                  <section class="bg-50 block-5 m5">
                        <header class="m5">
                              <div class="fr mr15">
                                    (
                                    <a href="http://lab.dev/clubber-mag-dev/cool-places/bares/">
                                          <i>link</i>
                                    </a>,
                                    <a href="http://lab.dev/clubber-mag-dev/cool-places/clubs/">
                                          <i>link</i>
                                    </a>,
                                    <a href="http://lab.dev/clubber-mag-dev/cool-places/restaurantes/">
                                          <i>link</i>
                                    </a>
                                    )
                              </div>
                              <a class="h2" href="http://lab.dev/clubber-mag-dev/agenda/" >
                                    Podcasts
                              </a>
                        </header>

                        <div class="cb"></div>
                        <ul>
                              <?php
                              $query = new WP_Query( array(
                                    'post_type' => 'agenda',
                                    'posts_per_page' => 4,
                                    'orderby' => 'rand' )
                              );

                              while ( $query->have_posts() ) {
                                    $query->the_post();
                                    ?>
                                    <li class="col-1-4 fl">
                                          <div class="box-3">
                                                <article>
                                                      <div class="hover-2">
                                                            <h2 class="ml5 sf-2">
                                                                  <a href="<?php the_permalink(); ?>">
                                                                        <?php the_title() ?>
                                                                  </a>
                                                            </h2>
                                                      </div>
                                                      <?php
                                                      echo do_shortcode( '[soundcloud url="https://api.soundcloud.com/tracks/177325223" params="color=ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false" width="100%" height="166" iframe="true" /]' );
                                                      ?>
                                                </article>
                                          </div>
                                    </li>
                                    <?php
                              } //END while
                              ?>

                        </ul>
                  </section>  
            </div>


      </div>
</main>

<div style="clear: both;"></div>

<!--
artist list
-->
<?php
d( 'artist letter list-0' );
?>
<main role="main">
      <section>
            <header>
                  <h1>
                        Artistas
                  </h1>
            </header>
            <ul>
                  <?php
                  $query = new WP_Query( array( 'post_type' => ' artista', 'posts_per_page' => 4 ) );
                  while ( $query->have_posts() ) {
                        $query->the_post();
                        ?>
                        <li class="col-1-4 fl">
                              <?php
                              get_template_part( 'tpl/home/list-0' );
                              ?>
                        </li>
                        <?php
                  }
                  ?>
            </ul>
      </section>
</main>

<div style="clear: both;"></div>

<?php d( 'event single' ); ?>
<!-- event single -->
<main class="has-sidebar" role="main">
      <?php
      $query = new WP_Query( array( 'p' => 3634, 'post_type' => 'agenda' ) );
      while ( $query->have_posts() ) {
            $query->the_post();
            ?>
            <?php
            get_template_part( 'tpl/home/single-1' );
            ?>
            <?php
      }
      ?>


      <div class="featured-image banner-bottom"> 
            <div data-sam="0" class="sam-container sam-place" id="c8881_21_5">
                  <a target="_blank" href="https://www.facebook.com/events/651384781641473/" class="sam_ad" id="a41_21">
                        <img alt="" src="http://www.clubber-mag.com/clubber-mag/wp-content/uploads/sam-images/thewarehouse.gif">
                  </a>
            </div>     
      </div>
</main>

<aside role="complementary">
      <div class="bg-50 block-5 ibox-5 box-5">
            <div style="color:#333; text-align: center; font-size: 18px;font-family: 'Russo One', sans-serif;">
                  Participa y Compártelo
            </div>
            <hr class="pb5">

            <div class="nz-relate big" id="nz-relate-user-to-event">
                  <a href="#participar" class="nz-relate-btn " id="relate_user_to_event">
                        <span class="nzr-icon"></span>
                        <span class="nzr-text">Me apunto!</span>
                  </a>

                  <a style="visibility:hidden" href="#participantes" class="fancybox.ajax nz-get-relation" id="get-event-users">
                        (<span class="nzr-total">0</span>)
                  </a>

            </div>

            <div class="box-5">
                  <div class="nz-fblike">
                        <div data-share="true" data-show-faces="true" data-action="like" data-layout="standard" data-href="http://lab.dev/clubber-mag-dev/cool-place/razzmatazz/" class="fb-like"></div>
                  </div>
                  <div class="mt15"></div>
                  <div class="nz-tweet">
                        <a data-via="ClubberMag" data-url="http://lab.dev/clubber-mag-dev/cool-place/razzmatazz/" data-text="twitter text" class="twitter-share-button" href="https://twitter.com/share">
                              Tweet
                        </a>
                        <script>
                              !function(d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                    if (!d.getElementById(id)) {
                                          js = d.createElement(s);
                                          js.id = id;
                                          js.src = p + '://platform.twitter.com/widgets.js';
                                          fjs.parentNode.insertBefore(js, fjs);
                                    }
                              }(document, 'script', 'twitter-wjs');
                        </script>
                  </div>
            </div>
      </div>

      <div class="bg-50 block-5 ibox-5 box-5 mt15">
            <div style="color:#333; text-align: center; font-size: 18px;font-family: 'Russo One', sans-serif;">
                  Compártelo
            </div>
            <hr class="pb5">

            <div class="box-5">
                  <div class="nz-fblike">
                        <div data-share="true" data-show-faces="true" data-action="like" data-layout="standard" data-href="http://lab.dev/clubber-mag-dev/cool-place/razzmatazz/" class="fb-like"></div>
                  </div>
                  <div class="mt15"></div>
                  <div class="nz-tweet">
                        <a data-via="ClubberMag" data-url="http://lab.dev/clubber-mag-dev/cool-place/razzmatazz/" data-text="twitter text" class="twitter-share-button" href="https://twitter.com/share">
                              Tweet
                        </a>
                        <script>
                              !function(d, s, id) {
                                    var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                    if (!d.getElementById(id)) {
                                          js = d.createElement(s);
                                          js.id = id;
                                          js.src = p + '://platform.twitter.com/widgets.js';
                                          fjs.parentNode.insertBefore(js, fjs);
                                    }
                              }(document, 'script', 'twitter-wjs');
                        </script>
                  </div>
            </div>
      </div>


      <div class="bg-50 block-5 mt15 box-5 ibox-5">
            <div class="featured-image">
                  <div data-sam="0" class="sam-container sam-place" id="c1715_22_6">
                        <a target="_blank" href="http://www.salarazzmatazz.com" class="sam_ad" id="a88_22">
                              <img alt="http://www.salarazzmatazz.com" src="http://www.clubber-mag.com/clubber-mag/wp-content/uploads/sam-images/300x250_generico_razzmatazz.gif">
                        </a>
                  </div>     
            </div>
      </div>
</aside>


<div style="clear: both;"></div>
<?php d( 'single post' ); ?>
<!-- single post  -->


<main class="has-sidebar" role="main">
      <?php
      $query = new WP_Query( array( 'posts_per_page' => 1, 'post_type' => 'photo' ) );
      while ( $query->have_posts() ) {
            $query->the_post();
            ?>
            <?php
            get_template_part( 'tpl/home/single-0' );
            ?>
            <?php
      }
      ?>
</main>


<aside role="complementary">
      <div class="bg-50 block-5 ibox-5 mt15">
            <div class="nz-fblikebox">
                  <div data-show-border="FALSE" data-stream="FALSE" data-header="false" data-show-faces="true" data-colorscheme="light" data-href="https://www.facebook.com/Clubber.Mag" class="fb-like-box"></div>
            </div>
      </div>
</aside>




<div style="clear: both;"></div>
<?php d( 'archive event agenda' ); ?>
<!--
ARCHIVE EVENT
-->

<main class="has-sidebar" role="main">
      <header class="m5">
            <h1>
                  Fiestas y Eventos esta semana                
            </h1>
      </header>

      <?php
      get_template_part( 'tpl/pager-by-date' );
      ?>
      <!-- Week events -->
      <!--        one day          -->
      <section> 
            <header class="ml5 mr5 h1 bold sc-2">
                  Sunday 16/11/14 
                  <hr class="cb pb5">
            </header>
            <ul>                                                
                  <?php
                  $query = new WP_Query( array(
                        'post_type' => 'agenda',
                        'posts_per_page' => 2,
                        'orderby' => 'rand' )
                  );
                  while ( $query->have_posts() ) {
                        $query->the_post();
                        ?>
                        <li class=" ibox-5">
                              <?php
                              get_template_part( 'tpl/home/list-3' );
                              ?>
                        </li>
                        <?php
                  }
                  ?>
            </ul>
      </section>                        
      <!--        another day          -->
      <section> 
            <header class="ml5 mr5 h1 bold sc-2">
                  Sunday 17/11/14 
                  <hr class="cb pb5">
            </header>
            <ul>                                                
                  <?php
                  $query = new WP_Query( array(
                        'post_type' => 'agenda',
                        'posts_per_page' => 1,
                        'orderby' => 'rand' )
                  );
                  while ( $query->have_posts() ) {
                        $query->the_post();
                        ?>
                        <li class=" ibox-5">
                              <?php
                              get_template_part( 'tpl/home/list-3' );
                              ?>
                        </li>
                        <?php
                  }
                  ?>
            </ul>
      </section>                        
      <!-- Week event list close -->

      <?php
      get_template_part( 'tpl/pager-by-date' );
      ?>

      <section>
            <header class="m5">
                  <h1>
                        Próximas Fiestas y Eventos           
                  </h1>
            </header>
            <ul>
                  <?php
                  $query = new WP_Query( array(
                        'post_type' => 'agenda',
                        'posts_per_page' => 1,
                        'orderby' => 'rand' )
                  );
                  while ( $query->have_posts() ) {
                        $query->the_post();
                        ?>
                        <li class="ibox-5">
                              <?php
                              get_template_part( 'tpl/home/list-3' );
                              ?>
                        </li>
                        <?php
                  }
                  ?>
            </ul>
      </section>

</main>
<aside role="complementary">
      <div id="calendar" class="bg-50 block-5 box-5 ibox-5"></div>

      <script type="text/javascript">
            jQuery(document).ready(function($) {
                  $('#calendar').fullCalendar({
                        header: {
                              left: '',
                              center: 'title',
                              right: 'prev,next'},
                        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'], monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                  });
            });


      </script>

      <div class="bg-50 block-5 mt30 box-5 ibox-5">
            <div class="featured-image">
                  <div data-sam="0" class="sam-container sam-place" id="c1715_22_6">
                        <a target="_blank" href="http://www.salarazzmatazz.com" class="sam_ad" id="a88_22">
                              <img alt="http://www.salarazzmatazz.com" src="http://www.clubber-mag.com/clubber-mag/wp-content/uploads/sam-images/300x250_generico_razzmatazz.gif">
                        </a>
                  </div>     
            </div>
      </div>

      <div class="bg-50 block-5 mt30 box-5 ibox-5">
            <div class="featured-image">
                  <div data-sam="0" class="sam-container sam-place" id="c8376_9_4">
                        <a target="_blank" href="http://www.clubber-mag.com/registrate/" class="sam_ad" id="a18_9"><img alt="" src="http://www.clubber-mag.com/clubber-mag/wp-content/uploads/sam-images/banner-clubber-mag-list.gif">
                        </a>
                  </div>
            </div>
      </div>
      <div class="bg-50 block-5 mt30 box-5 ibox-5">
            <?php
            echo do_shortcode(
                      '[soundcloud url="https://api.soundcloud.com/tracks/177325223" params="color=ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false" width="100%" height="166" iframe="true" /]'
            );
            /*
              '[soundcloud url="https://api.soundcloud.com/tracks/177325223" params="auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&visual=true" width="100%" height="450" iframe="true" /]'
             */
            ?>
      </div>

      <hr>

      <?php if ( is_active_sidebar( 'archive_event_sidebar' ) ) : ?>
            <?php dynamic_sidebar( 'archive_event_sidebar' ); ?>
      <?php endif; ?>

      <hr>
</aside>


<div class="cb"></div>

<?php d( 'archive music' ); ?>
<!--
musica archive
-->


<main role="main">
      <ul>
            <?php
            $query = new WP_Query( array(
                  'post_type' => 'agenda',
                  'posts_per_page' => 3,
                  'orderby' => 'rand' )
            );
            while ( $query->have_posts() ) {
                  $query->the_post();
                  ?>
                  <li class="bg-50 block-5 mt15">
                        <?php
                        get_template_part( 'tpl/home/list-4' );
                        ?>
                  </li>
                  <?php
            }
            ?>
      </ul>
</main>


<div style="clear: both;"></div>
<?php
menu_a_z();
?>
<div style="clear: both;"></div>
<!--
artist list
-->
<?php
d( 'all list' );
?>
<section style="width:150px;margin:5px" class="fl">  
      <header>
            <h2 class="ml5 bold sc-2">
                  <a href="/clubber-mag-dev/artista/?first-letter=F">F</a> 
            </h2> 
            <hr class="pb5">
      </header>
      <ul>                        <li style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden" class="ml5">
                  <a title="Felipe Valenzuela" rel="bookmark" style="color: #eee" href="http://lab.dev/clubber-mag-dev/artista/felipe-valenzuela/">Felipe Valenzuela</a>
            </li>
            <li style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden" class="ml5">
                  <a title="Felipe Venegas" rel="bookmark" style="color: #eee" href="http://lab.dev/clubber-mag-dev/artista/felipe-venegas/">Felipe Venegas</a>
            </li>
            <li style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden" class="ml5">
                  <a title="Franco Cinelli" rel="bookmark" style="color: #eee" href="http://lab.dev/clubber-mag-dev/artista/franco-cinelli/">Franco Cinelli</a>
            </li>
      </ul>
</section>
<div style="clear: both;"></div>
<?php d( 'photo list 1' ); ?>
<!--
Photo archive
-->


<main role="main">
      <ul>
            <?php
            $query = new WP_Query( array(
                  'post_type' => 'photo',
                  'posts_per_page' => 2,
                  'orderby' => 'rand' )
            );
            while ( $query->have_posts() ) {
                  $query->the_post();
                  ?>
                  <li class="ibox-5">
                        <?php
                        get_template_part( 'tpl/home/photo-list-1' );
                        ?>
                  </li>
                  <?php
            }
            ?>
      </ul>
</main>


<div style="clear: both;"></div>


<?php
 d( 'PROFILE' ); 
?>
<!-- PROFILE INFO-->

<main role="main">
      <div class="fl col-1-2">

            <section class="bg-50 block-5 m5">
                  <header class="m5 group">
                        <div class="fr">
                              <span >[ <a href="http://lab.dev/clubber-mag-dev/perfil/clubber-mag/editar">Editar</a> ]</span>
                              <span >[ <a href="http://lab.dev/clubber-mag-dev/arbol/?action=logout&amp;redirect_to=http%3A%2F%2Flab.dev%2Fclubber-mag-dev&amp;_wpnonce=118187423a">Salir</a> ]</span>
                        </div>
                        <h2>
                              clubber-mag
                        </h2>
                  </header>
                  <div id="user-profile-main">
                        <div style="border-bottom:1px solid #aaa" id="user-profile-images">
                              <div class="pr">
                                    <div class="featured-image" id="user-profile-background">
                                          <img width="589" height="200" alt="clubber-mag-background-picture" src="http://lab.dev/clubber-mag-dev/wp-content/themes/clubber-magazine/images/user-background-ph.png">
                                    </div>
                                    <div id="user-profile-picture">
                                          <img width="160" height="160" alt="clubber-mag-profile-picture" src="http://lab.dev/clubber-mag-dev/wp-content/uploads/nz-user-images/1409673094-cm-new-logo-160x160.png">
                                    </div>
                              </div>

                        </div>
                        <div class="cb m5">
                              Clubber Magazine es una revista online especializada en contenidos y eventos referentes a la música electrónica donde podrás encontrar información sobre artistas, eventos, festivales, vida nocturna, entretenimiento y ocio.                
                        </div>
                        <hr style="border-color: #aaa" class="pb5">

                        <ul class="cb m5">
                              <li class="">
                                    <span class="bold">Web: </span>
                                    <a rel="nofollow" target="_blank" href="http://www.clubber-mag.com">
                                          http://www.clubber-mag.com                                        </a>
                              </li>  
                              <li class="">
                                    <span class="bold">Facebook: </span>
                                    <a rel="nofollow" target="_blank" href="https://www.facebook.com/Clubber.Mag">
                                          https://www.facebook.com/Clubber.Mag                                        </a>
                              </li>  
                              <li class="">
                                    <span class="bold">Twitter: </span>
                                    <a rel="nofollow" target="_blank" href="https://twitter.com/ClubberMag">
                                          https://twitter.com/ClubberMag                                        </a>
                              </li>  

                        </ul>

                        <div class="cb m15 p15">
                              <div data-share="true" data-show-faces="true" data-action="like" data-layout="standard" data-href="http://lab.dev/clubber-mag-dev/perfil/clubber-mag/" class="fb-like"></div>
                        </div>

                  </div>


            </section>

      </div>
      <div class="fl col-1-2">
            <section class="bg-50 block-5 m5 pb15">
                  <header class="m5 cb group">
                        <span class="fr">
                              [ <a href="http://lab.dev/clubber-mag-dev/subir-evento/">
                                    Subir evento
                              </a> ]
                        </span>
                        <h2>
                              <a title="Ver todos los eventos" href="http://lab.dev/clubber-mag-dev/perfil/clubber-mag/eventos">
                                    Mis Eventos
                              </a>
                        </h2>
                  </header>

                  <ul>
                        <?php
                        $query = new WP_Query( array(
                              'post_type' => 'agenda',
                              'posts_per_page' => 3,
                              'orderby' => 'rand' )
                        );
                        while ( $query->have_posts() ) {
                              $query->the_post();
                              ?>
                              <li class="col-1-3 fl">
                                    <div class="ibox-3 mt0">
                                          <?php
                                          get_template_part( 'tpl/home/list-2' );
                                          ?>
                                    </div>
                              </li>
                              <?php
                        }
                        ?>
                  </ul>
            </section>


            <section class="bg-50 block-5 m5 pb15">
                  <header class="m5 cb group">
                        <div class="fr">
                              <span>[ <a href="http://lab.dev/clubber-mag-dev/agenda/">Apúntate a eventos</a> ]</span>
                        </div>
                        <h2>
                              <a title="Ver agenda de usuário" href="http://lab.dev/clubber-mag-dev/perfil/clubber-mag/agenda">
                                    Agenda
                              </a>
                        </h2>
                  </header>

                  <div class="m5">
                        Apúntate a eventos en nuestra agenda!
                  </div>
            </section>

      </div>

      <!-- OTHER -->
      <div class="cb m5">
            <h1>Mis otros recursos</h1>
            <hr class="p5">
      </div>

      <!-- resourte template-->
      <div class="fl col-1-2">

            <section class="bg-50 block-5 m5 pb15">
                  <header class="m5 cb group">
                        <div class="fr">
                              <span>
                                    [ <a href="http://lab.dev/clubber-mag-dev/recurso/cool-place/">Nuevo local</a> ]
                              </span>
                        </div>
                        <h2>
                              <a href="http://lab.dev/clubber-mag-dev/cool-place/">
                                    Cool Places
                              </a>
                        </h2>
                  </header>
                  <ul>
                        <li>
                              <article class="mb5 cb group">
                                    <div class="col-1-2 fl pr">
                                          <a class="featured-image" href="http://lab.dev/clubber-mag-dev/cool-place/sala-apolo/">
                                                <img width="340" height="155" alt="1406911405-big_SalaApolo_BCN_480" class="attachment-340-155-thumb wp-post-image" src="http://lab.dev/clubber-mag-dev/wp-content/uploads/2014/08/1406911405-big_SalaApolo_BCN_480-340x155.jpg">   
                                          </a>
                                    </div>
                                    <div class="col-1-2 fl">
                                          <div class="p5">
                                                <header class="cb">
                                                      <div class="fr">
                                                            [ <a href="http://lab.dev/clubber-mag-dev/recurso/cool-place/?gform_post_id=2880&amp;nonce=29e96dae83">
                                                                  editar
                                                            </a> ]
                                                      </div>
                                                      <h3>
                                                            <a href="http://lab.dev/clubber-mag-dev/cool-place/sala-apolo/">
                                                                  Sala Apolo
                                                            </a>
                                                      </h3>
                                                </header>
                                                <div class="cb">
                                                      <div class="tj mt5 mb5">
                                                            Si vols rebre més informació de la Sala Apolo i…                              
                                                      </div>
                                                      <i>
                                                            Carrer Nou de la Rambla, 111, 08004 Barcelona, Barcelona, España                              
                                                      </i> 
                                                </div>
                                          </div>
                                    </div>
                              </article>
                        </li>
                        <li>
                              <article class="mb5 cb group">
                                    <div class="col-1-2 fl pr">
                                          <a class="featured-image" href="http://lab.dev/clubber-mag-dev/cool-place/sala-apolo/">
                                                <img width="340" height="155" alt="1406911405-big_SalaApolo_BCN_480" class="attachment-340-155-thumb wp-post-image" src="http://lab.dev/clubber-mag-dev/wp-content/uploads/2014/08/1406911405-big_SalaApolo_BCN_480-340x155.jpg">   
                                          </a>
                                    </div>
                                    <div class="col-1-2 fl">
                                          <div class="p5">
                                                <header class="cb">
                                                      <div class="fr">
                                                            [ <a href="http://lab.dev/clubber-mag-dev/recurso/cool-place/?gform_post_id=2880&amp;nonce=29e96dae83">
                                                                  editar
                                                            </a> ]
                                                      </div>
                                                      <h3>
                                                            <a href="http://lab.dev/clubber-mag-dev/cool-place/sala-apolo/">
                                                                  Sala Apolo
                                                            </a>
                                                      </h3>
                                                </header>
                                                <div class="cb">
                                                      <div class="tj mt5 mb5">
                                                            Si vols rebre més informació de la Sala Apolo i…                              
                                                      </div>
                                                      <i>
                                                            Carrer Nou de la Rambla, 111, 08004 Barcelona, Barcelona, España                              
                                                      </i> 
                                                </div>
                                          </div>
                                    </div>
                              </article>
                        </li>
                  </ul>
            </section>
      </div>
</main>

<div class="cb"></div>
<?php d( 'user agenda list page -- with side bar' ); ?>
<!--
user agenda list
-->
<main class="has-sidebar" role="main">
      <section class="bg-50 block-5 pb15 m5">
            <header class="m5 cb group">
                  <div class="fr">
                        [ <a href="http://lab.dev/clubber-mag-dev/subir-evento/">
                              Subir evento
                        </a> ]
                  </div>
                  <h2>
                        <span title="Eventos de usuário">
                              Mis eventos
                        </span>
                  </h2>
            </header>

            <ul class="cb">
                  <?php
                  $query = new WP_Query( array(
                        'post_type' => 'agenda',
                        'posts_per_page' => 10,
                        'orderby' => 'rand' )
                  );
                  while ( $query->have_posts() ) {
                        $query->the_post();
                        ?>
                        <li class="col-1-4 fl">
                              <div class="box-3 pt0">
                                    <?php
                                    get_template_part( 'tpl/home/list-2' );
                                    ?>
                              </div>
                        </li>
                        <?php
                  }
                  ?>
            </ul>
      </section>

</main>
<aside>
      side
</aside>
<div style="clear: both;"></div>


<script>
      jQuery(document).ready(function($) {
            jQuery("h2.sf-2").fitText(1.5, {minFontSize: '10px', maxFontSize: '16px'});
      });

</script>