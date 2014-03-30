<?php

// Register Custom Taxonomy
function clubber_register_taxonomy() {
      $taxonomies = array();
      $labels = array();

      /*  TAXONOMY MUSIC TYPE    */
      $labels['music_type'] = array(
          'name' => _x('Music Type', 'Taxonomy General Name', 'text_domain'),
          'singular_name' => _x('Music type', 'Taxonomy Singular Name', 'text_domain'),
          'menu_name' => __('Music type', 'text_domain'),
          'all_items' => __('All Items', 'text_domain'),
          'parent_item' => __('Parent Item', 'text_domain'),
          'parent_item_colon' => __('Parent Item:', 'text_domain'),
          'new_item_name' => __('New Item Name', 'text_domain'),
          'add_new_item' => __('Add New Item', 'text_domain'),
          'edit_item' => __('Edit Item', 'text_domain'),
          'update_item' => __('Update Item', 'text_domain'),
          'separate_items_with_commas' => __('Separate items with commas', 'text_domain'),
          'search_items' => __('Search Items', 'text_domain'),
          'add_or_remove_items' => __('Add or remove items', 'text_domain'),
          'choose_from_most_used' => __('Choose from the most used items', 'text_domain'),
          'not_found' => __('Not Found', 'text_domain'),
      );
      /*   MUSIC TYPE    */
      $taxonomies['music_type'] = array(
          'name' => 'music_type',
          'object_type' => 'music',
          'labels' => $labels['music_type'],
          'hierarchical' => false,
          'public' => true,
          'show_ui' => true,
          'show_admin_column' => true,
          'show_in_nav_menus' => true,
          'show_tagcloud' => true,
          'rewrite' => array(
              'slug' => 'art'
          )
      );

      /*  TAXONOMY COOL PLACE TYPE    */
      $labels['cool_place_type'] = array(
          'name' => _x('Cool Place Type', 'Taxonomy General Name', 'text_domain'),
          'singular_name' => _x('Cool Place Type', 'Taxonomy Singular Name', 'text_domain'),
          'menu_name' => __('Cool Place Type', 'text_domain'),
          'all_items' => __('All Items', 'text_domain'),
          'parent_item' => __('Parent Item', 'text_domain'),
          'parent_item_colon' => __('Parent Item:', 'text_domain'),
          'new_item_name' => __('New Item Name', 'text_domain'),
          'add_new_item' => __('Add New Item', 'text_domain'),
          'edit_item' => __('Edit Item', 'text_domain'),
          'update_item' => __('Update Item', 'text_domain'),
          'separate_items_with_commas' => __('Separate items with commas', 'text_domain'),
          'search_items' => __('Search Items', 'text_domain'),
          'add_or_remove_items' => __('Add or remove items', 'text_domain'),
          'choose_from_most_used' => __('Choose from the most used items', 'text_domain'),
          'not_found' => __('Not Found', 'text_domain'),
      );
      /*    COOL PLACE TYPE   */
      $taxonomies['cool_place_type'] = array(
          'name' => 'cool_place_type',
          'object_type' => 'cool_place',
          'labels' => $labels['cool_place_type'],
          'hierarchical' => false,
          'public' => true,
          'show_ui' => true,
          'show_admin_column' => true,
          'show_in_nav_menus' => true,
          'show_tagcloud' => true,
          'rewrite' => array(
              'slug' => 'place'
          )
      );
      /*  TAXONOMY CITY TYPE    */
      $labels['es_city_type'] = array(
          'name' => _x('Ciudades España', 'Taxonomy General Name', 'clubber'),
          'singular_name' => _x('Ciudad españa', 'Taxonomy Singular Name', 'clubber'),
          'menu_name' => __('Ciudades españa', 'clubber'),
          'all_items' => __('All Items', 'clubber'),
          'parent_item' => __('Parent Item', 'clubber'),
          'parent_item_colon' => __('Parent Item:', 'clubber'),
          'new_item_name' => __('New Item Name', 'clubber'),
          'add_new_item' => __('Add New Item', 'clubber'),
          'edit_item' => __('Edit Item', 'clubber'),
          'update_item' => __('Update Item', 'clubber'),
          'separate_items_with_commas' => __('Separate items with commas', 'clubber'),
          'search_items' => __('Search Items', 'clubber'),
          'add_or_remove_items' => __('Add or remove items', 'clubber'),
          'choose_from_most_used' => __('Choose from the most used items', 'clubber'),
          'not_found' => __('Not Found', 'clubber'),
      );
      /*    CITY TYPE   */
      $taxonomies['es_city_type'] = array(
          'name' => 'es_city_type',
          'object_type' => 'event',
          'labels' => $labels['es_city_type'],
          'hierarchical' => false,
          'public' => true,
          'show_ui' => true,
          /*'show_ui' => false,*/
          'show_admin_column' => TRUE,
          'show_in_nav_menus' => TRUE,
          'show_tagcloud' => true,
          'rewrite' => array(
              'slug' => 'events/es'
          )
      );


      foreach ($taxonomies as $taxonomy) {
            register_taxonomy($taxonomy['name'], $taxonomy['object_type'], $taxonomy);
      }
}
