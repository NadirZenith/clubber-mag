<?php
/**
 *      REGISTER CUSTOM POST TYPE
 *      TYPE: User Post
 * 
 *  */
// Hook into the 'init' action
add_action('init', 'register_post_type_userpost', 0);

// Register User Post Type
function register_post_type_userpost() {

        $labels = array(
              'name' => 'User Posts',
              'singular_name' => 'User Post',
              'menu_name' => 'User Posts',
              'parent_item_colon' => 'Parent Item:',
              'all_items' => 'All User Posts',
              'view_item' => 'View User Post',
              'add_new_item' => 'Add User Post',
              'add_new' => 'Add User Post',
              'edit_item' => 'Edit User Post',
              'update_item' => 'Update User Post',
              'search_items' => 'Search User Post',
              'not_found' => 'User Post Not found',
              'not_found_in_trash' => 'User Post Not found in Trash',
        );
        $args = array(
              'label' => 'userpost',
              'description' => 'User Posts post type',
              'labels' => $labels,
              'supports' => array('title', 'editor', 'author', 'thumbnail', 'custom-fields',),
              'hierarchical' => TRUE,
              'public' => true,
              'show_ui' => true,
              'show_in_menu' => true,
              'show_in_nav_menus' => FALSE,
              'show_in_admin_bar' => FALSE,
              'menu_position' => 5,
              'can_export' => false,
              'has_archive' => false,
              'exclude_from_search' => false,
              'publicly_queryable' => FALSE, // permalink works if true
                /* 'capability_type' => 'page', */
        );
        register_post_type('userpost', $args);
}

if (false) {

        /**
         *      META BOX
         */
// Add Meta Boxes
        /*
         */
        add_action('add_meta_boxes', 'userpost_meta_boxes');

        function userpost_meta_boxes() {
                add_meta_box('nz_userpost_meta', 'Meta', 'nz_userpost_meta', 'userpost', 'side', 'default');
        }

// user post Metabox 1
        function nz_userpost_meta() {
                global $post;
                // Noncename needed to verify where the data originated
                echo '<input type="hidden" name="userpostmeta_noncename" id="userpostmeta_noncename" value="' .
                wp_create_nonce(plugin_basename(__FILE__)) . '" />';
                // Get the location data if its already been entered
                $parent_post = get_post_meta($post->ID, '_nz_parent_post', true);
                // Echo out the field
                echo '<p>Parent Post Id</p>';
                echo '<input type="text" name="_nz_parent_post" id="_nz_parent_post" value="' . $parent_post . '" class="widefat" />';
                ?>
                <script>
                        jQuery.validator.setDefaults({
                                /*debug: true,*/
                                success: function() {
                                        console.log('success');
                                }
                        });

                        jQuery('#post').validate({
                                rules: {
                                        _nz_parent_post: {
                                                required: true,
                                                digits: true
                                        }
                                }
                        });
                </script>
                <?php
        }

// Save the Metabox 1 
        add_action('save_post', 'nz_save_userpost_meta', 1, 2); // save the custom fields

        function nz_save_userpost_meta($post_id, $post) {
                // verify this came from the our screen and with proper authorization,
                // because save_post can be triggered at other times
                if (!wp_verify_nonce($_POST['userpostmeta_noncename'], plugin_basename(__FILE__))) {
                        return $post->ID;
                }

                // Is the user allowed to edit the post or page?
                if (!current_user_can('edit_post', $post->ID)) {
                        return $post->ID;
                }

                // OK, we're authenticated: we need to find and save the data
                // We'll put it into an array to make it easier to loop though.
                $userpost_meta['_nz_parent_post'] = $_POST['_nz_parent_post'];
                // Add values of $events_meta as custom fields
                foreach ($userpost_meta as $key => $value) { // Cycle through the $events_meta array!
                        if ($post->post_type == 'revision')
                                return; // Don't store custom data twice
                        $value = implode(',', (array) $value); // If $value is an array, make it a CSV (unlikely)
                        if (get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
                                update_post_meta($post->ID, $key, $value);
                        } else { // If the custom field doesn't have a value
                                add_post_meta($post->ID, $key, $value);
                        }
                        if (!$value)
                                delete_post_meta($post->ID, $key); // Delete if blank
                }
        }

        /**
         *      COLUMNS
         */
        add_filter('manage_userpost_posts_columns', 'nz_userpost_columns');

        function nz_userpost_columns($columns) {
                $columns = array(
                      'cb' => '<input type="checkbox" />',
                      'title' => __('Title'),
                      'author' => __('Parent Post'),
                      'parent' => __('Parent Post'),
                      'date' => __('Date')
                );

                return $columns;
        }

        add_action('manage_userpost_posts_custom_column', 'nz_userpost_columns_manage', 10, 2);

        function nz_userpost_columns_manage($column, $post_id) {

                global $post;

                switch ($column) {

                        /* If displaying the 'parent' column. */
                        case 'parent' :

                                /* Get the post meta. */
                                $parent_post = get_post(get_post_meta($post_id, '_nz_parent_post', true));

                                /* If no parent is found, output a default message. */
                                if (empty($parent_post)) {
                                        echo __('Unknown');
                                } else {
                                        ?>
                                        <a href="<?php echo get_permalink($parent_post); ?>"><?php echo $parent_post->post_title ?></a>
                                        <?php
                                }

                                break;

                        /* Just break out of the switch statement for everything else. */
                        default :
                                break;
                }
        }

        /* Only run our customization on the 'edit.php' page in the admin. */
        add_action('load-edit.php', 'nz_edit_userpost_load');

        function nz_edit_userpost_load() {
                add_filter('request', 'nz_sort_userpost');
        }

        /* Sorts the movies. */

        function nz_sort_userpost($vars) {

                /* Check if we're viewing the 'movie' post type. */
                if (isset($vars['post_type']) && 'userpost' == $vars['post_type']) {

                        /* Check if 'orderby' is set to 'duration'. */
                        if (isset($vars['orderby']) && 'parent' == $vars['orderby']) {

                                /* Merge the query vars with our custom variables. */
                                $vars = array_merge(
                                        $vars, array(
                                      'meta_key' => '_nz_parent_post',
                                      'orderby' => 'meta_value_num'
                                        )
                                );
                        }
                }

                return $vars;
        }

}
