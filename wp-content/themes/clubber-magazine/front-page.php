
<ul class="home-list">

      <!--  FEATURED POSTS -->
      <li class="col-0">
            <section class="featured-posts">
                  <?php
                  echo do_shortcode( '[metaslider id=661]' );
                  ?>
            </section>
      </li>

      <!--  FEATURED EVENTS -->
      <li class="col-0 ">
            <section class="featured-events bg-50 block-5">
                  <?php
                  require_once 'library/structure/front/event.php';
                  ?>
            </section>
      </li>

      <!--  NEWS   -->
      <li class="col-1 fl">
            <section class="news bg-50 block-5" >
                  <?php require_once 'library/structure/front/news.php'; ?>
            </section>
            <?php
            /*
              <div class="banner-side featured-image" >
              <?php echo do_shortcode('[sam id=2]'); ?>
              </div>
             */
            ?>
      </li>
      <!--  MUSIC   -->
      <li class="col-2 fr" style="">
            <section class="music bg-50 block-5">
                  <?php require_once 'library/structure/front/music.php'; ?>
            </section>
      </li>
      <!--  PHOTO & VIDEO  -->
      <li class="col-3 fl">

            <section class="photo bg-50 block-5 pb15">
                  <?php
                  require_once 'library/structure/front/photo.php';
                  ?>
            </section>

            <section class="video bg-50 block-5">
                  <?php
                  require_once 'library/structure/front/video.php';
                  ?>
            </section>
      </li>

</ul>
<div class="cb"></div>
<div class="featured-image banner-bottom"> 
      <?php
      echo do_shortcode( '[sam id=5]' );
      ?>
</div>
<?php
$user = wp_get_current_user();

if ( $user->id == 1 ) {
      ?>
      <?php
}
?>

<?php 
/*
?>
<style>
      .banner-bottom{
            width: 100%;
            margin: 12px;
      }
      .banner-bottom img{
            margin-left: 120px;
      }
</style>
<div class="cb"></div>
<div class="banner-bottom cb">
      <?php
      echo do_shortcode( '[sam id=5]' );
      ?>
</div>
 */