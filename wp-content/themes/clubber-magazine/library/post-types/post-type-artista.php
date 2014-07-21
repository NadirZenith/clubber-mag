<?php

/**
 *      REGISTER CUSTOM POST TYPE
 *      TYPE: artista
 * 
 *  */
// Hook into the 'init' action
add_action('init', 'register_post_type_artista', 0);

// Register User Post Type
function register_post_type_artista() {

        $labels = array(
              'name' => 'Artistas',
              'singular_name' => 'Artista',
              'menu_name' => 'Artistas',
              'parent_item_colon' => 'Parent Item:',
              'all_items' => 'All Artistas',
              'view_item' => 'View Artista',
              'add_new_item' => 'Add Artista',
              'add_new' => 'Add Artista',
              'edit_item' => 'Edit Artista',
              'update_item' => 'Update Artista',
              'search_items' => 'Search Artistas',
              'not_found' => 'Artista Not found',
              'not_found_in_trash' => 'Artista Not found in Trash',
        );
        $args = array(
              'label' => 'Artista',
              'description' => 'Artista post type',
              'labels' => $labels,
              'supports' => array('title', 'editor', 'author', 'thumbnail'),
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
              'taxonomies' => array()
                /* 'capability_type' => 'page', */
                /* 'rewrite' => array('slug' => 'sello', 'with_front' => false), */
        );
        register_post_type('artista', $args);
}
