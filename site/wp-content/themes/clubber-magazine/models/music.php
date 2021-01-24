<?php

add_action('init', 'cm_register_music_post_type');

function cm_register_music_post_type()
{
    $labels = array(
        'name' => _x('Music Content', 'post type general name', 'cm'),
        'singular_name' => _x('Music', 'post type singular name', 'cm'),
        'menu_name' => _x('Music Content', 'admin menu', 'cm'),
        'name_admin_bar' => _x('Music', 'add new on admin bar', 'cm'),
        'add_new' => _x('Add New', 'music', 'cm'),
        'add_new_item' => __('Add New Music', 'cm'),
        'new_item' => __('New Music', 'cm'),
        'edit_item' => __('Edit Music', 'cm'),
        'view_item' => __('View Music', 'cm'),
        'all_items' => __('All Music Content', 'cm'),
        'search_items' => __('Search Music Content', 'cm'),
        'parent_item_colon' => __('Parent Music Content:', 'cm'),
        'not_found' => __('No music content found.', 'cm'),
        'not_found_in_trash' => __('No music content found in Trash.', 'cm')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'musica'),
        'capability_type' => 'post',
        'has_archive' => 'musica',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'author', 'editor', 'thumbnail', 'custom-fields')
    );

    register_post_type('music', $args);

    $labels = array(
        'name' => _x('Music Categories', 'taxonomy general name', 'cm'),
        'singular_name' => _x('Music Category', 'taxonomy singular name', 'cm'),
        'search_items' => __('Search Music Categories', 'cm'),
        'popular_items' => __('Popular Music Categories', 'cm'),
        'all_items' => __('All Music Categories', 'cm'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __('Edit Music Category', 'cm'),
        'update_item' => __('Update Music Category', 'cm'),
        'add_new_item' => __('Add New Music Category', 'cm'),
        'new_item_name' => __('New Music Category Name', 'cm'),
        'separate_items_with_commas' => __('Separate music categories with commas', 'cm'),
        'add_or_remove_items' => __('Add or remove music categories', 'cm'),
        'choose_from_most_used' => __('Choose from the most used music categories', 'cm'),
        'not_found' => __('No music categories found.', 'cm'),
        'menu_name' => __('Music Categories', 'cm'),
    );

    $args = array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        /* 'update_count_callback' => '_update_post_term_count', */
        'query_var' => true,
        'rewrite' => array('slug' => 'categoria-musica'),
    );

    register_taxonomy('music_type', 'music', $args);
}
