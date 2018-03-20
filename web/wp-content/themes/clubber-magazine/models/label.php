<?php

add_action('init', 'cm_register_label_post_type');

function cm_register_label_post_type()
{
    $labels = array(
        'name' => _x('Label', 'post type general name', 'cm'),
        'singular_name' => _x('Label', 'post type singular name', 'cm'),
        'menu_name' => _x('Labels', 'admin menu', 'cm'),
        'name_admin_bar' => _x('Label', 'add new on admin bar', 'cm'),
        'add_new' => _x('Add New', 'label', 'cm'),
        'add_new_item' => __('Add New Label', 'cm'),
        'new_item' => __('New Label', 'cm'),
        'edit_item' => __('Edit Label', 'cm'),
        'view_item' => __('View Label', 'cm'),
        'all_items' => __('All Labels', 'cm'),
        'search_items' => __('Search Labels', 'cm'),
        'parent_item_colon' => __('Parent Labels:', 'cm'),
        'not_found' => __('No labels found.', 'cm'),
        'not_found_in_trash' => __('No labels found in Trash.', 'cm')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'label'),
        'capability_type' => 'post',
        'has_archive' => 'labels',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields')
    );

    register_post_type('label', $args);
}


add_action( 'p2p_init', 'cm_labels_connections' );

function cm_labels_connections() {
      p2p_register_connection_type( array(
            'name' => 'open-frequency-to-label',
            'from' => 'open-frequency',
            'to' => 'label'
      ) );
}
