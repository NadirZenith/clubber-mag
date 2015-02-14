<?php

/**
 * Enable theme features
 */
add_theme_support( 'soil-clean-up' );         // Enable clean up from Soil
add_theme_support( 'soil-nice-search' );      // Enable /?s= to /search/ redirect from Soil
add_theme_support( 'soil-disable-trackbacks' );      // disables X-Pingback header 
add_theme_support( 'jquery-cdn' );            // Enable to load jQuery from the Google CDN 
/* add_theme_support('soil-relative-urls');    // Enable relative URLs from Soil. See :https://yoast.com/relative-urls-issues/ */
/* add_theme_support('bootstrap-gallery');     // Enable Bootstrap's thumbnails component on [gallery] */
/* add_theme_support('html5', array('gallery'));     // Enable NZ Bootstrap Gallery */
//add_theme_support( 'nz-bootstrap-gallery' );     // Enable NZ Bootstrap Gallery

add_action( 'after_setup_theme', 'my_theme_setup' );

function my_theme_setup() {

      load_theme_textdomain( 'cm', get_template_directory() . '/lib/languages' );
}

/**
 * Configuration values
 */
define( 'GOOGLE_ANALYTICS_ID', '' ); // UA-XXXXX-Y (Note: Universal Analytics only, not Classic Analytics)

/**
 * .main classes
 */
function roots_main_class() {
      if ( roots_display_sidebar() ) {
            // Classes on pages with the sidebar
            $class = 'has-sidebar';
      } else {
            // Classes on full width pages
            $class = 'no-sidebar';
      }

      return apply_filters( 'roots/main_class', $class );
}

/**
 * .sidebar classes
 */
function roots_sidebar_class() {
      return apply_filters( 'roots/sidebar_class', '' );
}

/**
 * Define which pages shouldn't have the sidebar
 *
 * See lib/sidebar.php for more details
 */
function roots_display_sidebar() {
      /**
       * Conditional tag checks (http://codex.wordpress.org/Conditional_Tags)
       * Any of these conditional tags that return true won't show the sidebar
       *
       * To use a function that accepts arguments, use the following format:
       *
       * array('function_name', array('arg1', 'arg2'))
       *
       * The second element must be an array even if there's only 1 argument.
       */
      $sidebar_config = new Roots_Sidebar(
                array(
            'is_404',
            'is_front_page',
            /* 'is_archive', */
            /* 'is_category', */
            'is_page',
            'is_author',
            array( 'is_post_type_archive',
                  array( 'cool-place', 'artist', 'music' )
            ),
            array( 'is_tax',
                  array( 'cool_place_type' )
            )
                )
      );

      return apply_filters( 'roots/display_sidebar', $sidebar_config->display );
}

/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 *
 * Example: If the content area is 640px wide, set $content_width = 620; so images and videos will not overflow.
 * Default: 1140px is the default Bootstrap container width.
 */
if ( !isset( $content_width ) ) {
      $content_width = 1140;
}

$nz = new Pimple();


add_filter( 'query_vars', 'add_used_vars' );

function add_used_vars( $vars ) {
      $vars[] = "action"; //
      $vars[] = "date"; //
      $vars[] = "type"; //
      //$vars[] = "child"; //
      return $vars;
}

// Add default posts and comments RSS feed links to head
//add_theme_support( 'automatic-feed-links' );
// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page.
add_theme_support( 'post-thumbnails' );


// Remove WordPress version from header for security concern
remove_action( 'wp_head', 'wp_generator' );

// This theme uses wp_nav_menu() in header menu location.
register_nav_menu( 'primary', __( 'Primary Menu', 'cm' ) );
register_nav_menu( 'footer', __( 'Footer Menu', 'cm' ) );



add_filter( 'intermediate_image_sizes_advanced', 'filter_image_sizes' );

function filter_image_sizes( $sizes ) {

      unset( $sizes[ 'thumbnail' ] );
      unset( $sizes[ 'medium' ] );
      unset( $sizes[ 'large' ] );

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

/* clubber_register_image_sizes(); */
add_action( 'after_setup_theme', 'clubber_register_image_sizes' );

function clubber_register_image_sizes() {

      add_image_size( '290-160-thumb', 290, 160, true ); //EVENT 25%

      add_image_size( '340-155-thumb', 340, 155, true ); //NEWS / MUSIC ??PX
      //old home-gallery-thumb
      add_image_size( '430-190-thumb', 430, 190, true ); //archive & taxonomy archive photo

      add_image_size( '630-250-thumb', 630, 250, true ); //podcast photo
      //add_image_size( 'single-thumb', 700, 300, false ); // single
      add_image_size( '750-350-thumb', 700, 350, true ); // single
}