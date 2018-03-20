<?php

/* ------------------------------------------------ */
add_action('init', 'cm_register_artist_post_type');

function cm_register_artist_post_type()
{
    $labels = array(
        'name' => _x('Artist', 'post type general name', 'cm'),
        'singular_name' => _x('Artist', 'post type singular name', 'cm'),
        'menu_name' => _x('Artists', 'admin menu', 'cm'),
        'name_admin_bar' => _x('Artist', 'add new on admin bar', 'cm'),
        'add_new' => _x('Add New', 'artist', 'cm'),
        'add_new_item' => __('Add New Artist', 'cm'),
        'new_item' => __('New Artist', 'cm'),
        'edit_item' => __('Edit Artist', 'cm'),
        'view_item' => __('View Artist', 'cm'),
        'all_items' => __('All Artists', 'cm'),
        'search_items' => __('Search Artists', 'cm'),
        'parent_item_colon' => __('Parent Artists:', 'cm'),
        'not_found' => __('No artists found.', 'cm'),
        'not_found_in_trash' => __('No artists found in Trash.', 'cm')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'artista'),
        'capability_type' => 'post',
        'has_archive' => 'artistas',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields')
    );

    register_post_type('artist', $args);
}
/* ------------------------------------------------ */
add_action('p2p_init', 'cm_artists_connections');

function cm_artists_connections()
{
    p2p_register_connection_type(array(
        'name' => 'artists_to_labels',
        'from' => 'artist',
        'to' => 'label'
    ));
}
add_action('custom_metadata_manager_init_metadata', 'cm_artist_contact_custom_fields');
/*
 * OLD FIELDS
 * wpcf-link-youtube
 * wpcf-link-twitter
 * wpcf-link-soundcloud
 * wpcf-link-pagina-oficial
 * wpcf-link-facebook
 * wpcf-link-contact -> EMAIL
 * 
 * NEW
 * home
 * email
 * facebook
 * soundcloud
 * instagram
 * google-plus
 * youtube
 * twitter
 * beatport
 * bandpage
 * 
 */

function cm_artist_contact_custom_fields()
{

    $post_types = array('artista');
    $prefix = '';
    $metagroup = 'contact_metabox';
    x_add_metadata_group($metagroup, $post_types, array(
        'label' => 'Contact'
    ));

    /* CONTACT FIELDS */
    $socials = array(
        'home' => 'Link Pagina Oficial',
        'email' => 'Email Oficial',
        'facebook' => 'Link Facebook',
        'soundcloud' => 'Link Soundcoud',
        'instagram' => 'Link Instagram',
        'google-plus' => 'Link Google +',
        'youtube' => 'Link Youtube',
        'twitter' => 'Link Twitter',
        'beatport' => 'Link Beatport',
        'bandpage' => 'Link Bandpage'
    );

    foreach ($socials as $network => $description) {

        x_add_metadata_field($prefix . $network, $post_types, array(
            'group' => $metagroup,
            'label' => $description,
        ));
    }

    /* END CONTACT FIELDS */
}
/**
 * PRE GET ARCHIVE ARTIST
 */
add_action('pre_get_posts', 'cm_pre_get_archive_artist');

function cm_pre_get_archive_artist($query)
{

    if (
        !$query->is_main_query() || $query->is_admin || !$query->is_post_type_archive('artist')
    )
        return;

    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
}
add_action('pre_get_posts', 'cm_pre_get_single_artist');

function cm_pre_get_single_artist($query)
{

    if (
        'artist' != $query->get('post_type') || !$query->is_main_query() || $query->is_admin || !$query->is_single()
    )
        return;
    /*Roots_Wrapping::$raw = TRUE;*/
}
