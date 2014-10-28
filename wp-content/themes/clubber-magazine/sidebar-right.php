<?php
if ( is_single() ) {
      ?>
      <div class="bg-50 block-5 pb5 mt15 ">
            <div class="mt5" style="color:#333; text-align: center; font-size: 18px;font-family: 'Russo One', sans-serif;">
                  Compártelo
            </div>
            <hr class="ml5 mr5">

            <div class="ml15 mt15" style="">
                  <?php
                  nz_fb_like();
                  ?>
                  <div class="mt15"></div>
                        <?php
                  nz_tt_tweet();
                  ?>
                
            </div>
      </div>
      <?php
}
?>

<div class="bg-50 mt30 block-5 pb5">
      <?php
      nz_fb_like_box( 'https://www.facebook.com/Clubber.Mag' );
      ?>
</div>
<?php
/*    banners       */
include_once 'banners/single-event-1.php';
?>