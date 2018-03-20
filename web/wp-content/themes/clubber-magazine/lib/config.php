<?php

/**
 * Enable theme features
 */
add_theme_support('soil-clean-up');         // Enable clean up from Soil
add_theme_support('soil-nice-search');      // Enable /?s= to /search/ redirect from Soil
add_theme_support('soil-disable-trackbacks');      // disables X-Pingback header 
add_theme_support('jquery-cdn');            // Enable to load jQuery from the Google CDN 
add_theme_support('post-thumbnails');
/* add_theme_support('soil-relative-urls');    // Enable relative URLs from Soil. See :https://yoast.com/relative-urls-issues/ */
//add_theme_support( 'automatic-feed-links' );
/* add_theme_support('bootstrap-gallery');     // Enable Bootstrap's thumbnails component on [gallery] */
/* add_theme_support('html5', array('gallery'));     // Enable NZ Bootstrap Gallery */
//add_theme_support( 'nz-bootstrap-gallery' );     // Enable NZ Bootstrap Gallery
add_theme_support('yoast-seo-breadcrumbs');
/**
 * Configuration values
 */
define('GOOGLE_ANALYTICS_ID', 'UA-49721787-1'); // UA-XXXXX-Y (Note: Universal Analytics only, not Classic Analytics)

add_action('after_setup_theme', 'cm_after_setup_theme');

function cm_after_setup_theme()
{

    load_theme_textdomain('cm', get_template_directory() . '/languages');

    add_image_size('290-160-thumb', 290, 160, true); //EVENT 25%

    add_image_size('340-155-thumb', 340, 155, true); //NEWS / MUSIC ??PX
    //old home-gallery-thumb
    add_image_size('430-190-thumb', 430, 190, true); //archive & taxonomy archive photo

    add_image_size('630-250-thumb', 630, 250, true); //podcast photo
    //add_image_size( 'single-thumb', 700, 300, false ); // single
    add_image_size('650-300-thumb', 650, 300, true); //podcast photo
    add_image_size('1000-450-thumb', 1000, 450, true); // single
}
/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 *
 * Example: If the content area is 640px wide, set $content_width = 620; so images and videos will not overflow.
 * Default: 1140px is the default Bootstrap container width.
 */
if (!isset($content_width)) {
    $content_width = 1140;
}

add_filter('query_vars', 'add_used_vars');

function add_used_vars($vars)
{
    $vars[] = "action"; //
    $vars[] = "date"; //
    $vars[] = "type"; //

    return $vars;
}
// This theme uses wp_nav_menu() in header menu location.
register_nav_menu('primary', __('Primary Menu', 'cm'));
register_nav_menu('footer', __('Footer Menu', 'cm'));


/*
 * remove default sizes
 */
add_filter('intermediate_image_sizes_advanced', 'filter_image_sizes');

function filter_image_sizes($sizes)
{

    unset($sizes['thumbnail']);
    unset($sizes['medium']);
    unset($sizes['large']);

    /*
      $post_type = get_post_type($_POST['post_id']);
      switch ($post_type) {
      case 'artistas' :
      unset($sizes['290-160-thumb']);
      unset($sizes['340-155-thumb']);
      unset($sizes['430-190-thumb']);
      unset($sizes['single-thumb']);

      break;
      default :
      break;
      }
     */

    return $sizes;
}
