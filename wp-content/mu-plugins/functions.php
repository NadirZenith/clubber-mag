<?php



/*                ----------------------------              */
/** hide notifications !! cant update */
/*define('DISALLOW_FILE_MODS', true);*/


/*add_action('set_current_user', 'csstricks_hide_admin_bar');*/

function csstricks_hide_admin_bar() {
        if (!current_user_can('edit_posts')) {
                show_admin_bar(false);
        }
}

/*add_filter('show_admin_bar', '__return_false');*/