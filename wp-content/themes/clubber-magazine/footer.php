
</div><!-- #main -->

<footer id="site-footer" class="pr clearfix pb15">


        <nav id="footer-menu" class="hide-767">

                <?php wp_nav_menu(array('theme_location' => 'footer')); ?>
        </nav>
        <!--
        -->
        <a class="" href="https://www.facebook.com/Clubber.Mag"  target="_blank">
                <span class="follow-us"></span>
        </a>

        <div class="back-to-top">
                <a href="#branding"><?php echo __('Back to Top', 'attitude'); ?></a>
        </div>
</footer>
</div><!-- .wrapper -->

<?php
wp_footer();
?>

<?php
/*
  if (1 == get_current_user_id()) {

  d(wp_get_current_user());
  nz_debug_page_request();
  global $nz;
  d($nz);
  global $wp_query, $wp_rewrite;
  d($wp_query);
  d($wp_rewrite);



  $nz_get_image_sizes = nz_get_image_sizes();
  d(
  $nz_get_image_sizes
  );
  unset($nz_get_image_sizes['thumbnail']);
  unset($nz_get_image_sizes['medium']);
  unset($nz_get_image_sizes['large']);
  if (is_single()) {
  foreach ($nz_get_image_sizes as $key => $value) {
  //d($key);

  echo get_the_post_thumbnail(get_the_ID(), $key);

  //d($value);
  }
  }

  $user_coolplaces = get_user_meta(get_current_user_id(), 'coolplaces_ids');

  d($user_coolplaces);

  }
 */
?>
<?php if (1 == get_current_user_id()) { ?>
        <link rel="stylesheet" href="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/css/debug.css" type="text/css">
        <div id="nz-debug" class="nz-debug active" style="">
                
                <?php echo uniqid();?>
        </div>
        <script>
                jQuery(document).ready(function($) {
                        $('#nz-debug').on('click', function(e){
                                $( this ).toggleClass( "active" );
                        });
                });
        </script>
<?php } ?>

</body>
</html>