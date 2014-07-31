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
        /* define('ATTITUDE_SHORTCODES_DIR', ATTITUDE_LIBRARY_DIR . '/shortcodes'); */
        define('ATTITUDE_STRUCTURE_DIR', ATTITUDE_LIBRARY_DIR . '/structure');
        if (!defined('ATTITUDE_LANGUAGES_DIR')) /** So we can define with a child theme */
                define('ATTITUDE_LANGUAGES_DIR', ATTITUDE_LIBRARY_DIR . '/languages');
        define('ATTITUDE_WIDGETS_DIR', ATTITUDE_LIBRARY_DIR . '/widgets');

        /*  CLUBBER CONSTANTS    */
        define('CLUBBER_DEV', TRUE);
        define('CLUBBER_PLUGIN_DIR', ATTITUDE_PARENT_DIR . '/plugins');
        define('CLUBBER_ADDONS_DIR', ATTITUDE_PARENT_DIR . '/add-ons');
        define('CLUBBER_PLUGIN_URL', get_site_url() . '/wp-content/themes/clubber-magazine/plugins');

        define('CLUBBER_CUSTOM_FIELDS_DIR', ATTITUDE_LIBRARY_DIR . '/custom-fields');
        /* define('CLUBBER_POST_TYPES_DIR', ATTITUDE_LIBRARY_DIR . '/post-types'); */
        /* define('CLUBBER_TAXONOMY_DIR', ATTITUDE_LIBRARY_DIR . '/taxonomy'); */
        define('CLUBBER_FORMS_DIR', ATTITUDE_LIBRARY_DIR . '/forms');

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


        /** Load functions */
        require_once( ATTITUDE_FUNCTIONS_DIR . '/i18n.php' );
        require_once( ATTITUDE_FUNCTIONS_DIR . '/custom-header.php' );
        require_once( ATTITUDE_FUNCTIONS_DIR . '/functions.php' );

        /** ADMIN      */
        require_once( ATTITUDE_ADMIN_DIR . '/attitude-themeoptions-defaults.php' );
        require_once( ATTITUDE_ADMIN_DIR . '/theme-options.php' );
        /* require_once( ATTITUDE_ADMIN_DIR . '/attitude-metaboxes.php' ); */
        require_once( ATTITUDE_ADMIN_DIR . '/attitude-show-post-id.php' );

        /*    CLUBBER PLUGINS  */
        (CLUBBER_DEV) ? NULL : define('ACF_LITE', true);

        /* require_once( CLUBBER_PLUGIN_DIR . '/ozh-admin-drop-down-menu/wp_ozh_adminmenu.php'); */
        /* require_once( CLUBBER_PLUGIN_DIR . '/acf-field-date-time-picker/acf-date_time_picker.php' ); */
        require_once( CLUBBER_PLUGIN_DIR . '/advanced-custom-fields/acf.php' );
        require_once( CLUBBER_PLUGIN_DIR . '/acf-gallery/gallery.php' );
        require_once( CLUBBER_PLUGIN_DIR . '/raw-radio-taxonomies/raw-radio-taxonomies.php' );
        require_once( CLUBBER_PLUGIN_DIR . '/ml-slider/ml-slider.php' );
        require_once( CLUBBER_PLUGIN_DIR . '/post-type-archive-links/post-type-archive-links.php');
        require_once( CLUBBER_PLUGIN_DIR . '/nz-database-functions.php');

        /** Load Shortcodes */
        /* require_once( ATTITUDE_SHORTCODES_DIR . '/attitude-shortcodes.php' ); */

        /** Load Structure */
        require_once( ATTITUDE_STRUCTURE_DIR . '/header-extensions.php' );
        /* require_once( ATTITUDE_STRUCTURE_DIR . '/searchform-extensions.php' ); */
        require_once( ATTITUDE_STRUCTURE_DIR . '/sidebar-extensions.php' );
        require_once( ATTITUDE_STRUCTURE_DIR . '/footer-extensions.php' );
        /* require_once( ATTITUDE_STRUCTURE_DIR . '/content-extensions.php' ); */
        require_once( ATTITUDE_STRUCTURE_DIR . '/relation-events-users.php' );

        /** CLUBBER POST TYPES      */
        /* require_once( ATTITUDE_LIBRARY_DIR . '/post-types/post-type-evento.php' ); */
        require_once( ATTITUDE_LIBRARY_DIR . '/post-types/post-type-cool-place.php' );
        require_once( ATTITUDE_LIBRARY_DIR . '/post-types/post-type-artista.php' );
        require_once( ATTITUDE_LIBRARY_DIR . '/post-types/post-type-sello.php' );
        require_once( ATTITUDE_LIBRARY_DIR . '/post-types/post-type-userpost.php' );


        /** CLUBBER add-ons      */
        require_once( CLUBBER_ADDONS_DIR . '/todo-pending-posts.php' );

        /** CLUBBER FORMS      */
        require_once( CLUBBER_FORMS_DIR . '/common.php' );
        require_once( CLUBBER_FORMS_DIR . '/user-profile-edit.php' );
        require_once( CLUBBER_FORMS_DIR . '/event.php' );

        require_once( CLUBBER_FORMS_DIR . '/artist.php' );
        require_once( CLUBBER_FORMS_DIR . '/sello.php' );
        require_once( CLUBBER_FORMS_DIR . '/cool-place.php' );
        require_once( CLUBBER_FORMS_DIR . '/user-post.php' );

        /*   images   */
        require_once( ATTITUDE_STRUCTURE_DIR . '/images-extensions.php' );

        /** Load Widgets and Widgetized Area */
        /* require_once( ATTITUDE_WIDGETS_DIR . '/attitude_widgets.php' ); */
}

add_action('attitude_init', 'attitude_core_functionality', 20);

/**
 * Adding the core functionality of WordPess.
 *
 * @since 1.0
 */
function attitude_core_functionality() {
        global $nz;
        $nz['shortcode.gform'] = function($nz) {
                return '[gravityform id="%d" title="false" description="false" ajax=%d]';
        };

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

/*                ---------------------------- ---------------------------- ----------------------------              */

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
        global $submenu;
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
        $labels->name = 'Noticias'; //admin list news title
        $labels->singular_name = 'News item22';
        $labels->add_new = 'Add News item'; //admin edit post new shortcut
        $labels->add_new_item = 'Add News item'; //admin edit new post title
        $labels->edit_item = 'Edit News item'; //admin edit post title
        $labels->new_item = 'News6';
        $labels->view_item = 'View News item';   //View button from admin 
        $labels->search_items = 'Search News'; //admin list news search input
        $labels->not_found = 'No News found9';
        $labels->not_found_in_trash = 'No News found in Trash';
        $labels->all_items = 'All News10';
        $labels->menu_name = 'News11';
        $labels->name_admin_bar = 'News item'; //admin top bar
}

/*    CHANGE HOME/author/name to HOME/perfil/name */
add_action('init', 'change_author_base');

function change_author_base() {
        global $wp_rewrite;
        $query_var_name = 'action';
        $author_slug = 'perfil';
        $author_edit_slug = 'editar';

        $wp_rewrite->author_base = $author_slug;

//editar perfil
        $regex = sprintf('^%s/([^/]+)/(%s)/?$', $author_slug, $author_edit_slug);
        $redirect = sprintf('index.php?author_name=$matches[1]&%s=$matches[2]', $query_var_name);

        $wp_rewrite->add_rule($regex, $redirect);

//agenda list
        $regex = sprintf('^%s/([^/]+)/(%s)/?$', $author_slug, 'agenda');
        $redirect = sprintf('index.php?author_name=$matches[1]&%s=$matches[2]', $query_var_name);

        $wp_rewrite->add_rule($regex, $redirect);

//promoter list
        $regex = sprintf('^%s/([^/]+)/(%s)/?$', $author_slug, 'eventos');
        $redirect = sprintf('index.php?author_name=$matches[1]&%s=$matches[2]', $query_var_name);

        $wp_rewrite->add_rule($regex, $redirect);

        /* d($wp_rewrite); */
}

/** PROFILE BUILDER PRO */
/*
  add_filter('wppb_register_content_name1', '__return_empty_string');
  add_filter('wppb_register_content_info1', '__return_empty_string');
  add_filter('wppb_register_content_about_yourself1', '__return_empty_string');
  add_filter('wppb_register_confirmation_email_form', '__return_empty_string');
 */

add_filter('wppb_pre_login_url_filter', 'recover_password_url');

function recover_password_url($url) {

        $login_url = get_permalink(get_page_by_path('registrate')) . '?action=lostpassword';
        return $login_url;
}

//recover password form
add_filter('wppb_recover_password_message1', '__return_empty_string');


add_filter('wp_nav_menu_items', 'add_loginout_link', 10, 2);

function add_loginout_link($items, $args) {

        if (is_user_logged_in() && $args->theme_location == 'primary') {
                $class = is_author() ? ' current-menu-item ' : '';
                $avatar = get_avatar(get_current_user_id(), 55);
                $items .= '<li class="menu-profile-picture ' . $class . '">'
                        . '<a style="" href="' . get_author_posts_url(get_current_user_id()) . '">'
                        . '<span style="padding: 16px 0 0;">Perfil</span>'
                        . $avatar
                        . '</a>';
                if (is_super_admin()) {
                        $items .= '<ul class="sub-menu">';
                        $items .= '<li><a href="' . admin_url() . '">ADMIN</a></li>';
                        $items .= '</ul>';
                }

                $items .= '</li>';
        } elseif (!is_user_logged_in() && $args->theme_location == 'primary') {
                $class = is_page('registrate') ? ' current-menu-item ' : '';
                $login_url = get_permalink(get_page_by_path('registrate'));
                $items .= '<li class="' . $class . '"><a href="' . $login_url . '">Regístrate / Entra</a></li>';
        }
        return $items;
}

add_filter('query_vars', 'add_used_vars');

//to use get_query_var( 'action' ) && TYPE;
function add_used_vars($vars) {
        $vars[] = "action"; //
        $vars[] = "type"; //
        $vars[] = "child"; //
        return $vars;
}

//PAGE RECURSOS REWRITE 
add_filter('page_rewrite_rules', 'rewrite_page_recursos');

function rewrite_page_recursos($rules) {
        $query_var_name = 'type';
        $page_slug = 'recursos';

        /* d($rules); */
        /* $rules['^recursos/([^/]+)?'] = 'index.php?pagename=recursos&type=$matches[1]'; */
        $rules['^recursos/([^/]+)?/?([^/]+)?'] = 'index.php?pagename=recursos&type=$matches[1]&action=$matches[2]';
        return $rules;
}

/** add inline meta userprofile */
function nz_add_contactmethods($contactmethods) {
        // Remove Yahoo IM
        if (isset($contactmethods['yim']))
                unset($contactmethods['yim']);

        // Add Youtube
        if (!isset($contactmethods['youtube']))
                $contactmethods['youtube'] = 'youtube';
        // Add Country
        if (!isset($contactmethods['country']))
                $contactmethods['country'] = 'country';
        // Add city
        if (!isset($contactmethods['city']))
                $contactmethods['city'] = 'city';
        // Add gender
        if (!isset($contactmethods['gender']))
                $contactmethods['gender'] = 'gender';
        // Add birthday
        if (!isset($contactmethods['birthday']))
                $contactmethods['birthday'] = 'birthday';


        return $contactmethods;
}

add_filter('user_contactmethods', 'nz_add_contactmethods', 10, 1);

add_action('show_user_profile', 'clubber_mag_extra_profile_fields');
add_action('edit_user_profile', 'clubber_mag_extra_profile_fields');

function clubber_mag_extra_profile_fields($user) {
        ?>

        <h3>CLUBBER MAG USER INFORMATION</h3>
        <?php d($user); ?>
        <table class="form-table">


                <!--  Images               -->

                <tr>
                        <th><label>User images</label></th>
                        <td>
                                <div style="position:relative">

                                        <div style="float:left">
                                                <?php
                                                $url = nz_get_user_image($user->ID, 'background');
                                                ?>
                                                <img src="<?php echo $url ?>" alt="clubber-mag-background-picture" width="589" height="200">
                                        </div>
                                        <div style="position: absolute;top: 20px;">
                                                <?php
                                                $url = nz_get_user_image($user->ID, 'profile');
                                                ?>
                                                <img style="background-color: #fff" src="<?php echo $url ?>" alt="clubber-mag-profile-picture" width="160" height="160">
                                        </div>
                                </div>


                        </td>
                </tr>
                <!--  info -->
                <tr>
                        <th><label>User info</label></th>
                        <td>
                                <?php echo get_user_meta($user->ID, 'description', TRUE); ?>
                        </td>
                </tr>
                <tr>
                        <th><label>User meta</label></th>
                        <td>
                                <ul class="m">
                                        <?php
                                        $website = get_user_meta($user->ID, 'website', true);
                                        if ($website) {
                                                ?>
                                                <li class="">
                                                        <span class="bold">Web: </span>
                                                        <a href="<?php echo $website ?>" target="_blank" rel="nofollow">
                                                                <?php echo $website ?>
                                                        </a>
                                                </li>  
                                                <?php
                                        }
                                        ?>
                                        <?php
                                        $facebook = get_user_meta($user->ID, 'facebook', true);
                                        if ($facebook) {
                                                ?>
                                                <li class="">
                                                        <span class="bold">Facebook: </span>
                                                        <a href="<?php echo $facebook ?>" target="_blank" rel="nofollow">
                                                                <?php echo $facebook ?>
                                                        </a>
                                                </li>  
                                                <?php
                                        }
                                        ?>
                                        <?php
                                        $twitter = get_user_meta($user->ID, 'twitter', true);
                                        if ($twitter) {
                                                ?>
                                                <li class="">
                                                        <span class="bold">Twitter: </span>
                                                        <a href="<?php echo $twitter ?>" target="_blank" rel="nofollow">
                                                                <?php echo $twitter ?>
                                                        </a>
                                                </li>  
                                                <?php
                                        }
                                        ?>
                                        <?php
                                        $youtube = get_user_meta($user->ID, 'youtube', true);
                                        if ($youtube) {
                                                ?>
                                                <li class="">
                                                        <span class="bold">Youtube: </span>
                                                        <a href="<?php echo $youtube ?>" target="_blank" rel="nofollow">
                                                                <?php echo $youtube ?>
                                                        </a>
                                                </li>  
                                                <?php
                                        }
                                        ?>

                                </ul>
                        </td>
                </tr>
                <!--  COOL PLACES               -->
                <tr>
                        <th><label>CoolPlaces</label></th>
                        <td>
                                <?php
                                if (get_user_meta($user->ID, 'has_coolplace', true)) {
                                        $NZRelation = New NZRelation('coolplaces_to_users', 'coolplace_id', 'user_id');
                                        $coolplaces = $NZRelation->getRelationTo($user->ID, true);
                                        $args = array(
                                              'post_type' => 'cool-place',
                                              'post_status' => 'any',
                                              'posts_per_page' => -1,
                                              'post__in' => $coolplaces,
                                              'order' => 'ASC',
                                        );

                                        $wp_query = new WP_Query($args);
                                        if ($wp_query->have_posts()) {
                                                ?>
                                                <ul>
                                                        <?php
                                                        while ($wp_query->have_posts()) {
                                                                $wp_query->the_post();
                                                                ?>
                                                                <li>
                                                                        <?php echo the_post_thumbnail(array(50, 50)) ?>

                                                                        <a href="<?php echo get_edit_post_link(get_the_ID()) ?>"><?php the_title(); ?></a>
                                                                        (<?php echo get_post()->post_status ?>)
                                                                </li>
                                                                <?php
                                                        }
                                                        ?>
                                                </ul>
                                                <?php
                                        } else {
                                                echo 'delete relation!';
                                        }
                                } else {
                                        echo 'no coool places';
                                }
                                ?>
                                <?php
                                wp_reset_postdata();
                                ?>
                        </td>
                </tr>
                <!--  ARTIST PAGE       -->
                <tr>
                        <th><label>Artist Page</label></th>
                        <td>
                                <?php
                                if ($artist_page_id = get_user_meta($user->ID, 'artist_page', true)) {
                                        $artist_page = get_post($artist_page_id);
                                        /* var_dump($artist_page); */
                                        ?>
                                        <?php echo get_the_post_thumbnail($artist_page->ID, array(50, 50)) ?>
                                        <a href="<?php echo get_edit_post_link($artist_page->ID) ?>"><?php echo $artist_page->post_title; ?></a>
                                        (<?php echo get_post()->post_status ?>)
                                        <?php
                                } else {
                                        echo 'no artist page';
                                }
                                ?>
                        </td>
                </tr>
                <!--  LABEL PAGE       -->
                <tr>
                        <th><label>Label page</label></th>
                        <td>
                                <?php
                                if ($label_page_id = get_user_meta($user->ID, 'label_page', true)) {
                                        $label_page = get_post($label_page_id);
                                        ?>
                                        <?php echo get_the_post_thumbnail($label_page->ID, array(50, 50)) ?>

                                        <a href="<?php echo get_edit_post_link($label_page->ID) ?>"><?php echo $label_page->post_title; ?></a>
                                        (<?php echo get_post()->post_status ?>)
                                        <?php
                                } else {
                                        echo 'no label page';
                                }
                                ?>
                        </td>
                </tr>

                <!--       USER AGENDA         -->
                <tr>
                        <th><label>User Agenda</label></th>
                        <td>
                                <?php
                                $NZRelation = New NZRelation('events_to_users', 'event_id', 'user_id');
                                $user_events = $NZRelation->getRelationTo($user->ID, TRUE);
                                $start_date = strtotime("now");
                                $args = array(
                                      'post_type' => 'agenda',
                                      'posts_per_page' => 3,
                                      'post__in' => $user_events,
                                      'order' => 'ASC',
                                      'orderby' => 'meta_value_num',
                                      'meta_key' => 'wpcf-event_begin_date',
                                      'meta_query' => array(
                                            array(
                                                  'key' => 'wpcf-event_begin_date',
                                                  'value' => $start_date,
                                                  'type' => 'NUMERIC',
                                                  'compare' => '>='
                                            )
                                      )
                                );

                                $wp_query = new WP_Query($args);
                                if ($wp_query->have_posts()) {
                                        ?>
                                        <ul style="">

                                                <?php
                                                while ($wp_query->have_posts()) {
                                                        $wp_query->the_post();
                                                        ?>
                                                        <li>
                                                                <?php echo get_the_post_thumbnail(get_the_ID(), array(50, 50)) ?>
                                                                <a href="<?php echo get_edit_post_link(get_the_ID()) ?>"><?php the_title(); ?></a>
                                                                (<?php echo get_post()->post_status ?>)
                                                        </li>
                                                        <?php
                                                }
                                                ?>
                                        </ul>
                                        <?php
                                }
                                ?>
                        </td>
                </tr>

        </table>
        <?php
}

/* @todo: allow admin to remove associations */
/*
  add_action('personal_options_update', 'clubber_mag_save_extra_profile_fields');
  add_action('edit_user_profile_update', 'clubber_mag_save_extra_profile_fields');
 */

function clubber_mag_save_extra_profile_fields($user_id) {

        if (!current_user_can('edit_user', $user_id))
                return false;

        /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
        update_usermeta($user_id, 'twitter', $_POST['twitter']);
}

/*
 *  
 *      DEV 
 * 
 * * */

add_filter('rewrite_rules_array', 'nz_child_route');

// Adding a new rule
function nz_child_route($rules) {
        $newrules = array();
        $newrules['artista/([^/]+)/([^/]+)/?$'] = 'index.php?artista=$matches[1]&child=$matches[2]';
        $newrules['sello/([^/]+)/([^/]+)/?$'] = 'index.php?sello=$matches[1]&child=$matches[2]';
        return $newrules + $rules;
}

/* -- */

add_action('pre_get_posts', 'nz_child_query');

function nz_child_query($query) {

        //only front end && main query
        if (is_admin() || !$query->is_main_query())
                return;


        if (in_array($query->get('post_type'), array('artista', 'sello'))) {

                if ($query->get($query->get('post_type'))) {

                        if ($query->get('child')) {
                                $query->set('post_type', 'userpost');
                                $query->set('userpost', $query->get('child'));

                                add_filter('single_template', function($single) {
                                        return TEMPLATEPATH . '/single-child.php';
                                });
                        }
                }
        }
}

/*
 *  
 *      TESTES 
 * 
 * * */

/* add_filter('init', 'nz_flush_rewrite_rules'); */
// Removing front end admin bar because it's ugly
/* add_filter('show_admin_bar', '__return_false'); */

if (NZ_USE_LIVE_DB || (isset($_GET['action']) && $_GET['action'] == 'live')) {

        add_filter('wp_get_attachment_image_attributes', 'correct_localhost_live_path');

        function correct_localhost_live_path($attr) {

                $attr['src'] = str_replace('http://lab.dev/clubber-mag-dev', 'http://www.clubber-mag.com/clubber-mag', $attr['src']);

                return $attr;
        }

}
?>