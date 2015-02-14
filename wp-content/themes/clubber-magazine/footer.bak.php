
</div><!-- #main -->
<?php
/*
  // BREADCRUMBS
  <style>
  #breadcrumbs{
  margin-bottom: 0px;
  margin-left: 20px;
  }
  #breadcrumbs a{
  color: #666;
  }
  #breadcrumbs span{
  color: #333;
  }
  </style>
  <?php
  if (function_exists('yoast_breadcrumb') && !is_home() && !is_front_page()) {
  yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
  }
  ?>
 */
?>
<footer id="site-footer" class="pr clearfix pb15">
        <nav id="footer-menu" class="hide-767">
                <?php
                $footer_menu = get_transient('footer_menu_html');
                if (!$footer_menu) {
                        $footer_menu = wp_nav_menu(array(
                              'theme_location' => 'footer',
                              'echo' => FALSE
                        ));
                        set_transient('footer_menu_html', $footer_menu, 60 * 15);
                }
                echo $footer_menu;
                ?>
        </nav>
        <a class="" href="https://www.facebook.com/Clubber.Mag"  target="_blank">
                <span class="follow-us"></span>
        </a>
        <div class="back-to-top">
                <a href="#branding"><?php echo __('Back to Top', 'cm'); ?></a>
        </div>
</footer>
</div><!-- .wrapper -->

<?php wp_footer(); ?>

</body>
</html>
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

<?php
/*
  if (1 == get_current_user_id()) {
  ?>
  <link rel="stylesheet" href="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/css/debug.css" type="text/css">
  <div id="nz-debug" class="nz-debug active" style="">

  <!--<?php echo uniqid(); ?>-->
  </div>
  <script>
  jQuery(document).ready(function($) {
  $('#nz-debug').on('click', function(e) {
  $(this).toggleClass("active");
  });
  });
  </script>
  <?php
  }
 */
?>
