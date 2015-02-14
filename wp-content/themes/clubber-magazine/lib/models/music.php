<?php

$music_items = new CPT( array(
      'post_type_name' => 'music',
      'singular' => 'Music', 'cm',
      'plural' => 'Music archive', 'cm',
      'slug' => 'musica'
          ), array(
      'supports' => array( 'title', 'editor', 'thumbnail', 'author', 'custom-fields' ),
      'has_archive' => TRUE
          )
);

$music_items->register_taxonomy( array(
      'taxonomy_name' => 'music_type',
      'singular' => __( 'Music Category', 'cm' ),
      'plural' => __( 'Music Categories', 'cm' ),
      'slug' => 'categoria-musica' )
);
