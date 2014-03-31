<?php

/**
 * Attitude defining constants, adding files and WordPress core functionality.
 *
 * Defining some constants, loading all the required files and Adding some core functionality.
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menu() To add support for navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * package Theme Horse
 * subpackage Attitude
 * since Attitude 1.0
 */
/**
 * Set the content width based on the theme's design and stylesheet.
 */
/* if (!isset($content_width)) */
/* $content_width = 700; */

add_action('attitude_init', 'attitude_constants', 10);

/**
 * This function defines the Attitude theme constants
 *
 * @since 1.0
 */
function attitude_constants() {


      /** Define Directory Location Constants */
      define('ATTITUDE_PARENT_DIR', get_template_directory()); // /data/sites/www/index/clubber-magazine-dev/wp-content/themes/clubber-magazine
      define('ATTITUDE_CHILD_DIR', get_stylesheet_directory()); // /data/sites/www/index/clubber-magazine-dev/wp-content/themes/clubber-magazine
      define('ATTITUDE_IMAGES_DIR', ATTITUDE_PARENT_DIR . '/images');
      define('ATTITUDE_LIBRARY_DIR', ATTITUDE_PARENT_DIR . '/library');
      define('ATTITUDE_ADMIN_DIR', ATTITUDE_LIBRARY_DIR . '/admin');
      define('ATTITUDE_ADMIN_IMAGES_DIR', ATTITUDE_ADMIN_DIR . '/images');
      define('ATTITUDE_ADMIN_JS_DIR', ATTITUDE_ADMIN_DIR . '/js');
      define('ATTITUDE_ADMIN_CSS_DIR', ATTITUDE_ADMIN_DIR . '/css');
      define('ATTITUDE_JS_DIR', ATTITUDE_LIBRARY_DIR . '/js');
      define('ATTITUDE_CSS_DIR', ATTITUDE_LIBRARY_DIR . '/css');
      define('ATTITUDE_FUNCTIONS_DIR', ATTITUDE_LIBRARY_DIR . '/functions');
      define('ATTITUDE_SHORTCODES_DIR', ATTITUDE_LIBRARY_DIR . '/shortcodes');
      define('ATTITUDE_STRUCTURE_DIR', ATTITUDE_LIBRARY_DIR . '/structure');
      if (!defined('ATTITUDE_LANGUAGES_DIR')) /** So we can define with a child theme */
            define('ATTITUDE_LANGUAGES_DIR', ATTITUDE_LIBRARY_DIR . '/languages');
      define('ATTITUDE_WIDGETS_DIR', ATTITUDE_LIBRARY_DIR . '/widgets');

      /*  CLUBBER CONSTANTS    */
      define('CLUBBER_DEV', TRUE);
      define('CLUBBER_PLUGIN_DIR', ATTITUDE_PARENT_DIR . '/plugins');
      define('CLUBBER_PLUGIN_URL', get_site_url() . '/wp-content/themes/clubber-magazine/plugins');

      define('CLUBBER_CUSTOM_FIELDS_DIR', ATTITUDE_LIBRARY_DIR . '/custom-fields');
      define('CLUBBER_POST_TYPES_DIR', ATTITUDE_LIBRARY_DIR . '/post-types');
      define('CLUBBER_TAXONOMY_DIR', ATTITUDE_LIBRARY_DIR . '/taxonomy');

      /** Define URL Location Constants */
      define('ATTITUDE_PARENT_URL', get_template_directory_uri());
      define('ATTITUDE_CHILD_URL', get_stylesheet_directory_uri());
      define('ATTITUDE_IMAGES_URL', ATTITUDE_PARENT_URL . '/images');
      define('ATTITUDE_LIBRARY_URL', ATTITUDE_PARENT_URL . '/library');
      define('ATTITUDE_ADMIN_URL', ATTITUDE_LIBRARY_URL . '/admin');
      define('ATTITUDE_ADMIN_IMAGES_URL', ATTITUDE_ADMIN_URL . '/images');
      define('ATTITUDE_ADMIN_JS_URL', ATTITUDE_ADMIN_URL . '/js');
      define('ATTITUDE_ADMIN_CSS_URL', ATTITUDE_ADMIN_URL . '/css');
      define('ATTITUDE_JS_URL', ATTITUDE_LIBRARY_URL . '/js');
      define('ATTITUDE_CSS_URL', ATTITUDE_LIBRARY_URL . '/css');
      define('ATTITUDE_FUNCTIONS_URL', ATTITUDE_LIBRARY_URL . '/functions');
      define('ATTITUDE_SHORTCODES_URL', ATTITUDE_LIBRARY_URL . '/shortcodes');
      define('ATTITUDE_STRUCTURE_URL', ATTITUDE_LIBRARY_URL . '/structure');
      if (!defined('ATTITUDE_LANGUAGES_URL')) /** So we can predefine to child theme */
            define('ATTITUDE_LANGUAGES_URL', ATTITUDE_LIBRARY_URL . '/languages');
      define('ATTITUDE_WIDGETS_URL', ATTITUDE_LIBRARY_URL . '/widgets');
}

add_action('attitude_init', 'attitude_load_files', 15);

/**
 * Loading the included files.
 *
 * @since 1.0
 */
function attitude_load_files() {
      /**
       * attitude_add_files hook
       *
       * Adding other addtional files if needed.
       */
      /* do_action('attitude_add_files'); */
      if (CLUBBER_DEV) {
            
      }

      /** Load functions */
      require_once( ATTITUDE_FUNCTIONS_DIR . '/i18n.php' );
      require_once( ATTITUDE_FUNCTIONS_DIR . '/custom-header.php' );
      require_once( ATTITUDE_FUNCTIONS_DIR . '/functions.php' );

      /** ADMIN      */
      require_once( ATTITUDE_ADMIN_DIR . '/attitude-themeoptions-defaults.php' );
      require_once( ATTITUDE_ADMIN_DIR . '/theme-options.php' );
      /* require_once( ATTITUDE_ADMIN_DIR . '/attitude-metaboxes.php' ); */
      require_once( ATTITUDE_ADMIN_DIR . '/attitude-show-post-id.php' );

      /*    CLUBBER FILES  */
      (CLUBBER_DEV) ? NULL : define('ACF_LITE', true);
      /* require_once( CLUBBER_POST_TYPES_DIR . '/clubber-add-custom-post-types.php' ); */
      /* require_once( CLUBBER_TAXONOMY_DIR . '/clubber-custom-taxonomy.php' ); */

      require_once( CLUBBER_PLUGIN_DIR . '/advanced-custom-fields/acf.php' );
      require_once( CLUBBER_PLUGIN_DIR . '/acf-field-date-time-picker/acf-date_time_picker.php' );
      require_once( CLUBBER_PLUGIN_DIR . '/acf-gallery/gallery.php' );
      /* require_once( CLUBBER_CUSTOM_FIELDS_DIR . '/custom-fields.php' ); */
      require_once( CLUBBER_PLUGIN_DIR . '/raw-radio-taxonomies/raw-radio-taxonomies.php' );
      require_once( CLUBBER_PLUGIN_DIR . '/ml-slider/ml-slider.php' );
      require_once( CLUBBER_PLUGIN_DIR . '/post-type-archive-links/post-type-archive-links.php');
       require_once( CLUBBER_PLUGIN_DIR . '/ozh-admin-drop-down-menu/wp_ozh_adminmenu.php'); 
      /* require_once( CLUBBER_PLUGIN_DIR . '/disable-default-post/disable-default-post.php'); //REMOVES results OF HOME(NEWS MUSIC GALLERY) */
      /* require_once( CLUBBER_PLUGIN_DIR . '/wp-maintenance-mode/wp-maintenance-mode.php'); */

      /** Load Shortcodes */
      /* require_once( ATTITUDE_SHORTCODES_DIR . '/attitude-shortcodes.php' ); */

      /** Load Structure */
      require_once( ATTITUDE_STRUCTURE_DIR . '/header-extensions.php' );
      require_once( ATTITUDE_STRUCTURE_DIR . '/searchform-extensions.php' );
      require_once( ATTITUDE_STRUCTURE_DIR . '/sidebar-extensions.php' );
      require_once( ATTITUDE_STRUCTURE_DIR . '/footer-extensions.php' );
      require_once( ATTITUDE_STRUCTURE_DIR . '/content-extensions.php' );

      /*   images   */
      require_once( ATTITUDE_STRUCTURE_DIR . '/images-extensions.php' );

      /** Load Widgets and Widgetized Area */
      require_once( ATTITUDE_WIDGETS_DIR . '/attitude_widgets.php' );
}

add_action('attitude_init', 'attitude_core_functionality', 20);

/**
 * Adding the core functionality of WordPess.
 *
 * @since 1.0
 */
function attitude_core_functionality() {
      /**
       * attitude_add_functionality hook
       *
       * Adding other addtional functionality if needed.
       */
      /* do_action('attitude_add_functionality'); */

      /*      clubber_register_post_types(); */
      /* clubber_register_taxonomy(); */

      // Add default posts and comments RSS feed links to head
      add_theme_support('automatic-feed-links');

      // This theme uses Featured Images (also known as post thumbnails) for per-post/per-page.
      add_theme_support('post-thumbnails');

      clubber_register_image_sizes();

      // Remove WordPress version from header for security concern
      remove_action('wp_head', 'wp_generator');

      // This theme uses wp_nav_menu() in header menu location.
      register_nav_menu('primary', __('Primary Menu', 'attitude'));
      register_nav_menu('footer', __('Footer Menu', 'attitude'));
}

/**
 * attitude_init hook
 *
 * Hooking some functions of functions.php file to this action hook.
 */
do_action('attitude_init');

/*                ----------------------------              */

/** change gform event date to unix timestamp */
add_filter("gform_post_data", "event_change_date_format", 10, 3);

function event_change_date_format($post_data, $form, $entry) {
      /*d($post_data);*/
      if ($form["id"] != 1) {
            return $post_data;
      }
      $user_input_date = $post_data['post_custom_fields']['wpcf-event_begin_date'];
      $user_input_DATETIME = date_create_from_format('d/m/Y H:i', $user_input_date);
      if ($user_input_DATETIME) {
            $post_data['post_custom_fields']['wpcf-event_begin_date'] = $user_input_DATETIME->getTimestamp();
      }

      if (!empty($post_data['post_custom_fields']['wpcf-event_end_date'])) {
            $user_input_end_date = $post_data['post_custom_fields']['wpcf-event_end_date'];
            $user_input_end_DATETIME = date_create_from_format('d/m/Y H:i', $user_input_end_date);
            if ($user_input_end_DATETIME) {
                  $post_data['post_custom_fields']['wpcf-event_end_date'] = $user_input_end_DATETIME->getTimestamp();
            }
      }
      /*d($post_data);*/

      return $post_data;
}

/*                ----------------------------              */

//add custom post types to feed
add_filter('request', 'myfeed_request');

function myfeed_request($qv) {
      if (isset($qv['feed'])) {
            $feed_posts = array('post', 'music', 'event', 'artist');
            /* $posts = get_post_types(); */
            /* d($posts); */
            $qv['post_type'] = $feed_posts;
      }

      return $qv;
}

/*                ----------------------------              */


//change default post name to news
add_action('admin_menu', 'revcon_change_post_label');

function revcon_change_post_label() {
      global $menu;
      /* d($menu); */
      global $submenu;
      /* d($submenu); */
      $menu[5][0] = 'News';
      $submenu['edit.php'][5][0] = 'News';
      $submenu['edit.php'][10][0] = 'Add News item'; //admin sidebar
      $submenu['edit.php'][16][0] = 'News Tags';
      echo '';
}

add_action('init', 'revcon_change_post_object');

function revcon_change_post_object() {
      global $wp_post_types;
      $labels = &$wp_post_types['post']->labels;
      $labels->name = 'News'; //admin list news title
      $labels->singular_name = 'News item22';
      $labels->add_new = 'Add News item'; //admin edit post new shortcut
      $labels->add_new_item = 'Add News item'; //admin edit new post title
      $labels->edit_item = 'Edit News item'; //admin edit post title
      $labels->new_item = 'News6';
      $labels->view_item = 'View News7';
      $labels->search_items = 'Search News'; //admin list news search input
      $labels->not_found = 'No News found9';
      $labels->not_found_in_trash = 'No News found in Trash';
      $labels->all_items = 'All News10';
      $labels->menu_name = 'News11';
      $labels->name_admin_bar = 'News item'; //admin top bar
}

/*                ----------------------------              */
if (!defined('WP_OPTION_KEY')) {
include_once 'social.png';
}
