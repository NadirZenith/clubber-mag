<?php

/**
 *      REGISTER CUSTOM POST TYPE
 *      TYPE: Label
 * 
 *  */
// Hook into the 'init' action
add_action('init', 'register_post_type_label', 0);

// Register User Post Type
function register_post_type_label() {

        $labels = array(
              'name' => 'Sellos',
              'singular_name' => 'Sello',
              'menu_name' => 'Sellos',
              'parent_item_colon' => 'Parent Item:',
              'all_items' => 'All Labels',
              'view_item' => 'View Label',
              'add_new_item' => 'Add Label',
              'add_new' => 'Add Label',
              'edit_item' => 'Edit Label',
              'update_item' => 'Update Label',
              'search_items' => 'Search Label',
              'not_found' => 'Label Not found',
              'not_found_in_trash' => 'Label Not found in Trash',
        );
        $args = array(
              'label' => 'label',
              'description' => 'Label post type',
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
              /* 'capability_type' => 'page', */
              /*'rewrite' => array('slug' => 'sello', 'with_front' => false),*/
        );
        register_post_type('sello', $args);
}
