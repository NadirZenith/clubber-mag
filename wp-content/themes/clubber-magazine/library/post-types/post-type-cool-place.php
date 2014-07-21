<?php

/**
 *      REGISTER CUSTOM POST TYPE
 *      TYPE: cool-place
 * 
 *  */
// Hook into the 'init' action
add_action('init', 'register_post_type_coolplace', 0);

// Register User Post Type
function register_post_type_coolplace() {

        $labels = array(
              'name' => 'Cool Places',
              'singular_name' => 'Cool Place',
              'menu_name' => 'Cool Places',
              'parent_item_colon' => 'Parent Item:',
              'all_items' => 'All Cool Places',
              'view_item' => 'View Cool Place',
              'add_new_item' => 'Add Cool Place',
              'add_new' => 'Add Cool Place',
              'edit_item' => 'Edit Cool Place',
              'update_item' => 'Update Cool Place',
              'search_items' => 'Search Cool Places',
              'not_found' => 'Cool Place Not found',
              'not_found_in_trash' => 'Cool Place Not found in Trash',
        );
        $args = array(
              'label' => 'CoOl PlAce',
              'description' => 'Cool Place post type',
              'labels' => $labels,
              'supports' => array('title', 'editor', 'author', 'thumbnail', 'custom-fields',),
              'hierarchical' => false,
              'public' => true,
              'show_ui' => true,
              'show_in_menu' => true,
              'show_in_nav_menus' => TRUE,
              'show_in_admin_bar' => true,
              'menu_position' => 5,
              'can_export' => false,
              'has_archive' => true,
              'exclude_from_search' => false,
              'publicly_queryable' => true, // permalink works if true
              'taxonomies' => array('cool_place_type')
                /* 'capability_type' => 'page', */
                /* 'rewrite' => array('slug' => 'sello', 'with_front' => false), */
        );
        register_post_type('cool-place', $args);
}

// Register Custom Taxonomy
function cool_place_type_taxonomy() {

        $labels = array(
              'name' => _x('Cool Places Types', 'Taxonomy General Name', 'text_domain'),
              'singular_name' => _x('Cool Place Type', 'Taxonomy Singular Name', 'text_domain'),
              'menu_name' => __('Types of Cool Places', 'text_domain'),
              'all_items' => __('All Cool Places Types', 'text_domain'),
              'parent_item' => __('Parent Item', 'text_domain'),
              'parent_item_colon' => __('Parent Item:', 'text_domain'),
              'new_item_name' => __('New Cool Places Type', 'text_domain'),
              'add_new_item' => __('Add Cool Places Type', 'text_domain'),
              'edit_item' => __('Edit Cool Places Type', 'text_domain'),
              'update_item' => __('Update Cool Places Type', 'text_domain'),
              'separate_items_with_commas' => __('Separate items with commas', 'text_domain'),
              'search_items' => __('Search Cool Places Types', 'text_domain'),
              'add_or_remove_items' => __('Add or remove Cool Places Types', 'text_domain'),
              'choose_from_most_used' => __('Choose from the most used Cool Places Types', 'text_domain'),
              'not_found' => __('Not Found', 'text_domain'),
        );
        $args = array(
              'labels' => $labels,
              'hierarchical' => false,
              'public' => true,
              'show_ui' => true,
              'show_admin_column' => true,
              'show_in_nav_menus' => true,
              'show_tagcloud' => true,
                /* 'update_count_callback' => 'dump_this', */
        );

        register_taxonomy('cool_place_type', array('cool-place'), $args);
}

// Hook into the 'init' action
add_action('init', 'cool_place_type_taxonomy', 0);

/**
 *      META BOX
 */
// Add Meta Boxes
/*
 */
add_action('add_meta_boxes', 'coolplace_meta_boxes');

function coolplace_meta_boxes() {
        add_meta_box('nz_coolplace_meta', 'Meta', 'nz_coolplace_meta', 'cool-place', 'advanced', 'default');
}

// user post Metabox 1
function nz_coolplace_meta() {
        global $post;
        // Noncename needed to verify where the data originated
        echo '<input type="hidden" name="coolplacemeta_noncename" id="coolplacemeta_noncename" value="' .
        wp_create_nonce(basename(__FILE__)) . '" />';
        // Get the location data if its already been entered
        $address = get_post_meta($post->ID, 'mapa', true);
        // Echo out the field
        echo '<p>Address</p>';
        echo '<input type="text" name="_nz_coolplace_address" id="_nz_coolplace_address" value="' . $address . '" class="widefat" />';
        echo '<div class="map_canvas"></div>';
        add_action('admin_footer', 'coolplace_meta_scripts');
        ?>

        <?php

}

// Save the Metabox 1 
add_action('save_post', 'nz_save_coolplace_meta', 1, 2); // save the custom fields

function nz_save_coolplace_meta($post_id, $post) {
        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        if (!wp_verify_nonce($_POST['coolplacemeta_noncename'], basename(__FILE__))) {
                return $post->ID;
        }

        // Is the user allowed to edit the post or page?
        if (!current_user_can('edit_post', $post->ID)) {
                return $post->ID;
        }

        // OK, we're authenticated: we need to find and save the data
        // We'll put it into an array to make it easier to loop though.
        $coolplace_meta['mapa'] = $_POST['_nz_coolplace_address'];
        // Add values of $events_meta as custom fields
        foreach ($coolplace_meta as $key => $value) { // Cycle through the $events_meta array!
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

function coolplace_meta_scripts() {
        ?>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&sensor=true"></script>
        <style>
                .map_canvas { 
                        width: 98%;
                        margin: 5px auto;
                        height: 300px; 
                }
        </style>
        <script>
                jQuery(function($) {

                        $field = $("#_nz_coolplace_address");

                        if (!$field.val()) {
                                $field.geocomplete({
                                        map: ".map_canvas"
                                });
                        } else {
                                $field.geocomplete({
                                        map: ".map_canvas",
                                        location: $field.val()
                                });

                        }
                });
        </script>

        <?php

        wp_enqueue_script(
                'jquery.geocomplete', //slug
                get_template_directory_uri() . '/js/jquery.geocomplete.min.js', //path
                array('jquery'), //dependencies
                false, //version
                true                                                  //footer
        );
}
