<?php

/**
 * Clubber Mag constants, adding files and WordPress core functionality.
 *
 * Defining some constants, loading all the required files and Adding some core functionality.
 *
 * package ClubberMag
 * since ClubberMag 1.0
 */
/* --------------------------- */


define( 'CM_DIR', get_stylesheet_directory_uri() );
define( 'CM_LIB_DIR', '/lib' );
define( 'CM_ADDONS_DIR', '/lib/nz/add-ons' );
define( 'CM_MODELS_DIR', CM_LIB_DIR . '/models' );


//pages
define( 'CM_RESOURCE_EVENT_PAGE_ID', 406 );
define( 'CM_CONNECT_PAGE_ID', 675 );
define( 'CM_RESOURCE_MAIN_PAGE_ID', 2610 );
define( 'CM_RESOURCE_ARTIST_PAGE_ID', 4912 );
define( 'CM_RESOURCE_LABEL_PAGE_ID', 4913 );
define( 'CM_RESOURCE_COOLPLACE_PAGE_ID', 4914 );
define( 'CM_RESOURCE_COOLPLACE_FAST_PAGE_ID', 4915 );
define( 'CM_RESOURCE_PODCAST_PAGE_ID', 4916 );
//\pages
//metafields
define( 'CM_META_MAPA', 'coolplace_mapaddress' );
define( 'CM_META_SOUNDCLOUD', 'soundcloud_url' );

//user meta
define( 'CM_USER_META_RESOURCE_ID', 'main_resource_id' );
//\metafields
/**
 * Roots includes
 *
 * The $roots_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/roots/pull/1042
 */
$roots_includes = array(
      'vendor/autoload.php',
      'lib/soil/soil.php',
      'lib/config.php',
      'lib/utils.php',
      'lib/api.php',
      'lib/nav.php',
      'lib/wrapper.php',
      'lib/scripts.php',
      'lib/sidebar.php',
      //
      'lib/nz/template.php',
      'lib/nz/security.php',
      'lib/nz/NzAjaxResponse.php',
      //widgets
      /* 'lib/nz/widgets/widget-audio.php', */
      /* 'lib/nz/widgets/widget-test.php', */
      'lib/nz/widgets/widget-soundcloud.php',
      'lib/nz/widgets/widget-calendar.php',
      'lib/nz/widgets/widget-relate.php',
      'lib/nz/widgets/widget-share.php',
      'lib/nz/widgets/widget-newsletter.php',
      //shortcode
      'lib/nz/shortcodes/shortcode-soundcloud.php',
      //social
      'lib/nz/social/social-icons-list.php',
      'lib/nz/social/facebook-config.php',
      'lib/nz/social/soundcloud-config.php',
      'lib/nz/social/twitter-config.php',
      //

      /** CLUBBER POST TYPES      */
      'lib/nz/CPT.php', //library to create custom post and terms
      /*
       */
      CM_MODELS_DIR . '/user.php',
      CM_MODELS_DIR . '/menu.php',
      CM_MODELS_DIR . '/artist.php',
      CM_MODELS_DIR . '/label.php',
      CM_MODELS_DIR . '/cool-place.php',
      CM_MODELS_DIR . '/event.php',
      CM_MODELS_DIR . '/music.php',
      CM_MODELS_DIR . '/video.php',
      CM_MODELS_DIR . '/photo.php',
      CM_MODELS_DIR . '/page.php',
      CM_MODELS_DIR . '/news.php',
      CM_MODELS_DIR . '/podcast.php',
      CM_MODELS_DIR . '/pages/recursos.php', // Page recursos specific queries
      CM_MODELS_DIR . '/pages/festivals.php', // Page festivals queries
      'lib/nz/lib/nzsession.php',
      //forms /login /register
      'lib/nz/lib/nz-wp-form/nz-wp-forms.php',
      //
      /* 'lib/nz/lib/debug/nz-url-functions.php', */
      /* 'lib/nz/lib/debug/nz-debug-functions.php', */
      /* 'lib/nz//lib/debug/css-media-queries.php', */
      //
      /* CM_PLUGIN_DIR . '/raw-radio-taxonomies/raw-radio-taxonomies.php', */
      /* CM_PLUGIN_DIR . '/post-type-archive-links/post-type-archive-links.php', */
      /** CLUBBER add-ons      */
      CM_ADDONS_DIR . '/nz-start-msgs/NzStartMsgs.php',
      CM_ADDONS_DIR . '/location-taxonomy/contry-list.php',
      CM_ADDONS_DIR . '/todo-pending-posts.php',
      CM_ADDONS_DIR . '/query-functions.php',
      CM_ADDONS_DIR . '/search-query.php',
      CM_ADDONS_DIR . '/language-selector.php',
      'tpl/shortcodes/layout-shortcodes.php'
);

foreach ( $roots_includes as $file ) {
      if ( !$filepath = locate_template( $file ) ) {
            trigger_error( sprintf( __( 'Error locating %s for inclusion', 'roots' ), $file ), E_USER_ERROR );
      }

      require_once $filepath;
}
unset( $file, $filepath );


/*
 *  
 *      DEV 
 * 
 * * 
if ( NZ_USE_LIVE_DB || (isset( $_GET[ 'action' ] ) && $_GET[ 'action' ] == 'live') ) {

      add_filter( 'wp_get_attachment_image_attributes', 'correct_localhost_live_path' );

      function correct_localhost_live_path( $attr ) {

            $attr[ 'src' ] = str_replace( 'http://lab.dev/clubber-mag-dev', 'http://www.clubber-mag.com/clubber-mag', $attr[ 'src' ] );

            return $attr;
      }

}
 */

/*
 *  
 *      TESTES 
 * 
 * * 

// always paste as plain text
foreach ( array( 'tiny_mce_before_init', 'teeny_mce_before_init' ) as $filter ) {
      add_filter( $filter, function( $mceInit ) {
            $mceInit[ 'paste_text_sticky' ] = true;
            $mceInit[ 'paste_text_sticky_default' ] = true;
            return $mceInit;
      } );
}
// load 'paste' plugin in minimal/pressthis editor
add_filter( 'teeny_mce_plugins', function( $plugins ) {
      $plugins[] = 'paste';
      return $plugins;
} );
// remove "Paste as Plain Text" button from editor
add_filter( 'mce_buttons_2', function( $buttons ) {
      if ( ( $key = array_search( 'pastetext', $buttons ) ) !== false ) {
            unset( $buttons[ $key ] );
      }
      return $buttons;
} );



 */
