<?php

/**
 * Enable theme features
 */
add_theme_support( 'soil-clean-up' );         // Enable clean up from Soil
add_theme_support( 'soil-nice-search' );      // Enable /?s= to /search/ redirect from Soil
add_theme_support( 'soil-disable-trackbacks' );      // disables X-Pingback header 
add_theme_support( 'jquery-cdn' );            // Enable to load jQuery from the Google CDN 
add_theme_support( 'post-thumbnails' );
/* add_theme_support('soil-relative-urls');    // Enable relative URLs from Soil. See :https://yoast.com/relative-urls-issues/ */
//add_theme_support( 'automatic-feed-links' );
/* add_theme_support('bootstrap-gallery');     // Enable Bootstrap's thumbnails component on [gallery] */
/* add_theme_support('html5', array('gallery'));     // Enable NZ Bootstrap Gallery */
//add_theme_support( 'nz-bootstrap-gallery' );     // Enable NZ Bootstrap Gallery

add_action( 'after_setup_theme', 'my_theme_setup' );

function my_theme_setup() {

      load_theme_textdomain( 'cm', get_template_directory() . '/lib/languages' );
}

/**
 * option-tree theme enable.
 */
/*add_filter( 'ot_theme_mode', '__return_true' );*/
//option-tree include
//require( trailingslashit( get_template_directory() ) . 'vendor/option-tree/ot-loader.php' );

/**
 * Configuration values
 */
define( 'GOOGLE_ANALYTICS_ID', 'UA-49721787-1' ); // UA-XXXXX-Y (Note: Universal Analytics only, not Classic Analytics)


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
      $vars[] = "country"; //
      $vars[] = "city"; //

      //$vars[] = "child"; //
      return $vars;
}

// Add default posts and comments RSS feed links to head

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
      add_image_size( '650-300-thumb', 650, 300, true ); //podcast photo
      add_image_size( '1000-450-thumb', 1000, 450, true ); // single
}

/**
 * Register our sidebars and widgetized areas.
 *
 */
add_action( 'widgets_init', 'cm_widgets_init' );

function cm_widgets_init() {

      register_sidebar( array(
            'id' => 'singular_sidebar',
            'name' => 'Singular sidebar',
            'before_widget' => '<div class="mb15 col-1 col-sm-1-2 col-md-1-3 col-lg-1 fl"><div class="ibox-5">',
            'after_widget' => '</div></div>',
            'before_title' => '<h3 class="mb3">',
            'after_title' => '</h3>',
      ) );
      register_sidebar( array(
            'id' => 'banners_sidebar',
            'name' => 'Banners sidebar',
            'before_widget' => '<div class="mb15 col-1 col-sm-1-2 col-md-1-3 col-lg-1 fl"><div class="ibox-5">',
            'after_widget' => '</div></div>',
            'before_title' => '<h3 class="mb3">',
            'after_title' => '</h3>',
      ) );

      register_sidebar( array(
            'id' => 'archive_event_sidebar',
            'name' => 'Agenda sidebar',
            'before_widget' => '<div class="ibox-5 mb15">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="mb3">',
            'after_title' => '</h3>',
      ) );

      register_sidebar( array(
            'id' => 'single_event_sidebar',
            'name' => 'Event sidebar',
            'before_widget' => '<div class="ibox-5 mb15 single_event_sidebar_item">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="mb3">',
            'after_title' => '</h3>',
      ) );
}

