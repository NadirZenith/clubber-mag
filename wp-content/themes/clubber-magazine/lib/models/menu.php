<?php

add_filter('wp_nav_menu_items', 'cm_add_loginout_link', 10, 2);

function cm_add_loginout_link($items, $args)
{
    $wrapper = '<li class="menu-connect %s" id="menu-connect">%s</li>';
    /* d(sprintf($wrapper, 'hahaha')); */

    $item = '';
    if ($args->theme_location == 'primary') {
        if (is_user_logged_in()) {
            $class = is_author() ? ' current-menu-item ' : '';
            $avatar = get_avatar(get_current_user_id(), 40);
            $curusr = wp_get_current_user();
            $user_url = get_author_posts_url($curusr->ID);
            $link_content = __('Profile', 'cm') . "<br><span>" . $curusr->get('display_name') . "</span>";
            $user_link = "<a class=\"user-menu\" href=\"$user_url\">" . $link_content . $avatar . "</a>";

            $sub = '';
            if (is_super_admin()) {
                $sub .= '<ul class="sub-menu">';
                $sub .= '<li><a href="' . admin_url() . '">ADMIN</a></li>';
                $sub .= '</ul>';
            }
            $item = sprintf($wrapper, $class, $user_link . $sub);
        } else {
            $class = is_page('registrate') ? ' current-menu-item ' : '';
            $login_url = get_permalink(CM_CONNECT_PAGE_ID);
            $login_link = '<a href="' . $login_url . '">' . __('Login / SignUp', 'cm') . '</a>';
            $item = sprintf($wrapper, $class, $login_link);
            /* d($item); */
            /* $items .= '<li id="menu-login" class="' . $class . '"></li>'; */
        }
    }
    return $items . $item;
}
add_filter('wp_nav_menu_items', 'cm_add_language_switcher', 15, 2);

function cm_add_language_switcher($items, $args)
{

    if ($args->theme_location == 'primary') {


        $items .= '<li class="menu-lang-choice">';
        $selector = nz_wp_language_selector();
        $items.= $selector;


        $items .= '</li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'cm_add_ticketscript_menu', 15, 2);

function cm_add_ticketscript_menu($items, $args)
{
    if ($args->theme_location == 'primary') {
        $items .= '<li class="menu-ticketscript">';
        $items.= '<a style="color: #0583F2;" href="' . get_permalink(CM_TICKETSCRIPT_PAGE_ID) . '">' . get_the_title(CM_TICKETSCRIPT_PAGE_ID) . '</a>';
        $items .= '</li>';
    }
    return $items;
}
?>
<?php

/* add_filter( 'wp_nav_menu_items', 'cm_add_menu_logo', 10, 2 ); */

function cm_add_menu_logo($items, $args)
{

    $item = '';
    if ($args->theme_location == 'primary') {
        $item .= '
            <a style="position:relative;" rel="home" title="Clubber-Mag" href="http://lab.dev/clubber-mag-dev/">
                  <img width="150" style="position:absolute; top:-30px;" alt="Clubber-Mag" src="http://lab.dev/clubber-mag-dev/wp-content/themes/clubber-magazine/images/clubber-mag-logo-v2.png">
            </a>';
    }
    return $item . $items;
}
/*
  pll_the_languages($args);
  $args is an optional array parameter. Options are:

  ‘dropdown’ => displays a list if set to 0, a dropdown list if set to 1 (default: 0)
  ‘show_names’ => displays language names if set to 1 (default: 1)
  ‘display_names_as’ => either ‘name’ or ‘slug’ (default: ‘name’)
  ‘show_flags’ => displays flags if set to 1 (default: 0)
  ‘hide_if_empty’ => hides languages with no posts (or pages) if set to 1 (default: 1)
  ‘force_home’ => forces link to homepage if set to 1 (default: 0)
  ‘echo’ => echoes if set to 1, returns a string if set to 0 (default: 1)
  ‘hide_if_no_translation’ => hides the language if no translation exists if set to 1 (default: 0)
  ‘hide_current’=> hides the current language if set to 1 (default: 0)
  ‘post_id’ => if set, displays links to translations of the post (or page) defined by post_id (default: null)
  ‘raw’ => use this to create your own custom language switcher (default:0)
 *  */


