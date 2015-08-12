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

define('CM_LIB_DIR', '/lib');
define('CM_ADDONS_DIR', '/lib/nz/add-ons');
define('CM_MODELS_DIR', '/models');

//pages
define('CM_RESOURCE_EVENT_PAGE_ID', 406);
define('CM_CONNECT_PAGE_ID', 675);
define('CM_RESOURCE_MAIN_PAGE_ID', 2610);
define('CM_RESOURCE_ARTIST_PAGE_ID', 4912);
define('CM_RESOURCE_LABEL_PAGE_ID', 4913);
define('CM_RESOURCE_COOLPLACE_PAGE_ID', 4914);
define('CM_RESOURCE_COOLPLACE_FAST_PAGE_ID', 4915);
define('CM_RESOURCE_PODCAST_PAGE_ID', 4916);
define('CM_TICKETSCRIPT_PAGE_ID', 7521);
//\pages
//metafields
define('CM_META_MAPA', 'coolplace_mapaddress');
define('CM_META_SOUNDCLOUD', 'soundcloud_url');

//user meta
define('CM_USER_META_RESOURCE_ID', 'main_resource_id');
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
    'lib/queries.php',
    'lib/nz/widgets/widget-soundcloud.php',
    'lib/nz/widgets/widget-calendar.php',
    'lib/nz/widgets/widget-relate.php',
    'lib/nz/widgets/widget-share.php',
    'lib/nz/widgets/widget-fb-like-box.php',
    /*'lib/nz/widgets/widget-newsletter.php',*/
    'lib/nz/shortcodes/shortcode-soundcloud.php',
    'lib/nz/social/social-icons-list.php',
    'lib/nz/social/facebook-config.php',
    'lib/nz/social/soundcloud-config.php',
    'lib/nz/social/twitter-config.php',
    /** CLUBBER POST TYPES      */
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
    'lib/nz/lib/nz-wp-form/nz-wp-forms.php',//forms to be replaced
    //
    /** CLUBBER add-ons      */
    CM_ADDONS_DIR . '/nz-start-msgs/NzStartMsgs.php',
    CM_ADDONS_DIR . '/location-taxonomy/contry-list.php',//tax tools cm specific
    CM_ADDONS_DIR . '/col-shortcodes/col-shortcodes.php',//shortcodes cm specific()
    CM_ADDONS_DIR . '/todo-pending-posts.php',
    CM_ADDONS_DIR . '/query-functions.php',//artist archive filter
    CM_ADDONS_DIR . '/language-selector.php',//to be removed by plugin localization
    /*'tpl/shortcodes/layout-shortcodes.php'*/
);

foreach ($roots_includes as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'roots'), $file), E_USER_ERROR);
    }

    require_once $filepath;
}
unset($file, $filepath);


global $nzwpnewsletter;

if (isset($nzwpnewsletter)) {
    $nzwpnewsletter->setFormTemplate(__DIR__ . '/tpl/home/newsletter.php');
    /* d($nzwpnewsletter); */
}



