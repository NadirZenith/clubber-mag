<?php
/**
 * Displays the header section of the theme.
 *
 * @package Theme Horse
 * @subpackage Attitude
 * @since Attitude 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
      <head>

            <?php
            do_action('attitude_title');


            do_action('attitude_meta');
            ?>
            <link rel="stylesheet" href="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/css/common.css" type="text/css">
            <link rel="stylesheet" href="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/css/clubber_style.css" type="text/css">
            <?php
            do_action('attitude_links');

            /**
             * This hook is important for wordpress plugins and other many things
             */
            wp_head();
            ?>
            <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

            <link href='http://fonts.googleapis.com/css?family=Russo+One' rel='stylesheet' type='text/css'>


            <link rel="stylesheet" href="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/js/fullcalendar/fullcalendar.css" type="text/css">
            <script type="text/javascript" src="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/js/fullcalendar/fullcalendar.min.js"></script>

            <link rel="stylesheet" href="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/js/fancybox/source/jquery.fancybox.css" type="text/css">
            <script type="text/javascript" src="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/js/fancybox/source/jquery.fancybox.pack.js"></script>

      <?php
            /* <body <?php body_class(); ?>> */
            ?>
      </head>
      <body>

            <div id="fb-root"></div>
            <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id))
                              return;
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&status=0";
                        fjs.parentNode.insertBefore(js, fjs);
                  }(document, 'script', 'facebook-jssdk'));</script>



            <?php
            /**
             * attitude_before hook
             */
            /* do_action('attitude_before'); */
            ?>

            <div class="wrapper">
                  <?php
                  /**
                   * attitude_before_header hook
                   */
                  do_action('attitude_before_header');
                  ?>
                  <header id="branding">

                        <?php
                        /**
                         * attitude_header hook
                         *
                         * HOOKED_FUNCTION_NAME PRIORITY
                         *
                         * attitude_headerdetails 10
                         */
                        do_action('attitude_header');
                        ?>
                  </header>
                  <?php
                  /**
                   * attitude_after_header hook
                   */
                  do_action('attitude_after_header');
                  ?>

                  <?php
                  /**
                   * attitude_before_main hook
                   */
                  do_action('attitude_before_main');
                  ?>
                  <div id="main" class="container clearfix">
                        <!--<div id="main" class="container">-->