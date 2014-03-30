<?php

function clubber_register_post_types() {

      $post_types = array();

      /*   NOTICIAS   */
      $post_types['news'] = array(
          'post_type' => 'news', // my own
          'label' => 'News',
          'description' => 'News about club world',
          'public' => true,
          'exclude_from_search' => false, //oposite of public
          'publicly_queryable' => true, //same as public
          'show_ui' => true, //same as public
          'show_in_nav_menus' => true, // same as public,
          'show_in_menu' => true, // same as show_ui,
          'show_in_admin_bar' => true, // same as show_in_menu,
          'menu_position' => null, // 
          'menu_icon' => null,
          'capability_type' => 'post',
          'map_meta_cap' => true,
          'hierarchical' => false,
          'supports' => array('title', 'editor', 'author', 'thumbnail', 'comments'),
          'taxonomies' => array(),
          'has_archive' => true,
          'rewrite' => array(
              /*'slug' => 'noticias'*/
          ),
          'query_var' => FALSE
      );

      /*   MUSICA   */
      $post_types['music'] = array(
          'post_type' => 'music', //my own
          'label' => __('Music', 'text_domain'),
          'description' => __('Music post type', 'text_domain'),
          /* 'labels' => $labels, */
          'supports' => array('title', 'editor', 'author', 'thumbnail', 'comments'),
          'taxonomies' => array('music_type'),
          'hierarchical' => false,
          'public' => true,
          'show_ui' => true,
          'show_in_menu' => true,
          'show_in_nav_menus' => true,
          'show_in_admin_bar' => true,
          'menu_position' => 2,
          'menu_icon' => '',
          'can_export' => true,
          'has_archive' => true,
          'exclude_from_search' => false,
          'publicly_queryable' => true,
          'capability_type' => 'post',
      );

      /*   VIDEO   */
      $post_types['video'] = array(
          'post_type' => 'video', //my own
          'label' => __('Video', 'text_domain'),
          'description' => __('Video post type', 'text_domain'),
          /* 'labels' => $labels, */
          'supports' => array('title', 'editor', 'author', 'comments', 'custom-field'),
          /*'supports' => array('title', 'editor', 'author', 'thumbnail', 'comments', 'custom-field'),*/
          'taxonomies' => array(),
          'hierarchical' => false,
          'public' => true,
          'show_ui' => true,
          'show_in_menu' => true,
          'show_in_nav_menus' => true,
          'show_in_admin_bar' => true,
          'menu_position' => 3,
          'menu_icon' => '',
          'can_export' => true,
          'has_archive' => true,
          'exclude_from_search' => false,
          'publicly_queryable' => true,
          'capability_type' => 'post',
      );
      /*   photo   */
      $post_types['photo'] = array(
          'post_type' => 'photo', //my own
          'label' => __('Photo', 'text_domain'),
          'description' => __('Photo post type', 'text_domain'),
          /* 'labels' => $labels, */
          'supports' => array('title', 'editor', 'author', 'thumbnail', 'comments', 'custom-field'),
          'taxonomies' => array(),
          'hierarchical' => false,
          'public' => true,
          'show_ui' => true,
          'show_in_menu' => true,
          'show_in_nav_menus' => true,
          'show_in_admin_bar' => true,
          'menu_position' => 4,
          'menu_icon' => '',
          'can_export' => true,
          'has_archive' => true,
          'exclude_from_search' => false,
          'publicly_queryable' => true,
          'capability_type' => 'post',
      );

      /*   EVENT   */
      $post_types['event'] = array(
          'post_type' => 'event', //my own
          'label' => __('Event', 'text_domain'),
          'description' => __('Event post type', 'text_domain'),
          /* 'labels' => $labels, */
          'supports' => array('title', 'editor', 'author', 'thumbnail', 'comments', 'custom-field'),
          'taxonomies' => array(),
          'hierarchical' => false,
          'public' => true,
          'show_ui' => true,
          'show_in_menu' => true,
          'show_in_nav_menus' => true,
          'show_in_admin_bar' => true,
          'menu_position' => 5,
          'menu_icon' => '',
          'can_export' => true,
          'has_archive' => true,
          'exclude_from_search' => false,
          'publicly_queryable' => true,
          'capability_type' => 'post',
      );

      /*   COOL PLACE   */
      $post_types['cool_place'] = array(
          'post_type' => 'cool_place', //my own
          'label' => __('Cool Place', 'text_domain'),
          'description' => __('Cool place post type', 'text_domain'),
          /* 'labels' => $labels, */
          'supports' => array('title', 'editor', 'thumbnail', 'comments', 'custom-field'),
          'taxonomies' => array(),
          'hierarchical' => false,
          'public' => true,
          'show_ui' => true,
          'show_in_menu' => true,
          'show_in_nav_menus' => true,
          'show_in_admin_bar' => true,
          'menu_position' => 7,
          'menu_icon' => '',
          'can_export' => true,
          'has_archive' => true,
          'exclude_from_search' => false,
          'publicly_queryable' => true,
          'capability_type' => 'post',
          'rewrite' => array(
              'slug' => 'places'
          ),
      );

      foreach ($post_types as $post_type) {
            register_post_type($post_type['post_type'], $post_type);
      }
}
