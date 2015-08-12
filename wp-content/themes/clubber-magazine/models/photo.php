<?php

add_action('init', 'cm_register_photo_post_type');

function cm_register_photo_post_type() {
    $labels = array(
        'name' => _x('Photos', 'post type general name', 'cm'),
        'singular_name' => _x('Photo', 'post type singular name', 'cm'),
        'menu_name' => _x('Photos', 'admin menu', 'cm'),
        'name_admin_bar' => _x('Photo', 'add new on admin bar', 'cm'),
        'add_new' => _x('Add New', 'photo', 'cm'),
        'add_new_item' => __('Add New Photo', 'cm'),
        'new_item' => __('New Photo', 'cm'),
        'edit_item' => __('Edit Photo', 'cm'),
        'view_item' => __('View Photo', 'cm'),
        'all_items' => __('All Photos', 'cm'),
        'search_items' => __('Search Photos', 'cm'),
        'parent_item_colon' => __('Parent Photos:', 'cm'),
        'not_found' => __('No photos found.', 'cm'),
        'not_found_in_trash' => __('No photos found in Trash.', 'cm')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'photo'),
        'capability_type' => 'post',
        'has_archive' => 'photos',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','author', 'editor', 'thumbnail', 'custom-fields')
    );

    register_post_type('photo', $args);

}

