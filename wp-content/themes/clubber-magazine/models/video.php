<?php

add_action('init', 'cm_register_video_post_type');

function cm_register_video_post_type()
{
    $labels = array(
        'name' => _x('Videos', 'post type general name', 'cm'),
        'singular_name' => _x('Video', 'post type singular name', 'cm'),
        'menu_name' => _x('Videos', 'admin menu', 'cm'),
        'name_admin_bar' => _x('Video', 'add new on admin bar', 'cm'),
        'add_new' => _x('Add New', 'video', 'cm'),
        'add_new_item' => __('Add New Video', 'cm'),
        'new_item' => __('New Video', 'cm'),
        'edit_item' => __('Edit Video', 'cm'),
        'view_item' => __('View Video', 'cm'),
        'all_items' => __('All Videos', 'cm'),
        'search_items' => __('Search Videos', 'cm'),
        'parent_item_colon' => __('Parent Videos:', 'cm'),
        'not_found' => __('No videos found.', 'cm'),
        'not_found_in_trash' => __('No videos found in Trash.', 'cm')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'video'),
        'capability_type' => 'post',
        'has_archive' => 'videos',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'author', 'editor', 'thumbnail', 'custom-fields')
    );

    register_post_type('video', $args);
}
/**
 * register custom metadata groups and fields
 * this is the example code that you should use
 * make sure to use the 'admin_init' hook as below
 *
 * @return void
 */
add_action('custom_metadata_manager_init_metadata', 'cm_video_custom_fields');

function cm_video_custom_fields()
{

    x_add_metadata_group('youtube_video_metabox', 'video', array(
        'label' => 'video group field'
    ));

    x_add_metadata_field('wpcf-video-url', 'video', array(
        'group' => 'youtube_video_metabox', // the group name
        'label' => 'Video URL', // field label
        'description' => 'Youtube video url', // description for the field
        'display_column' => false // show this field in the column listings
    ));
}
