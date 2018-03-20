<?php

//change default post name to news
add_action( 'admin_menu', 'nz_change_post_label' );

function nz_change_post_label() {
      global $menu;
      global $submenu;
      $menu[ 5 ][ 0 ] = __( 'News', 'cm' );
      $submenu[ 'edit.php' ][ 5 ][ 0 ] = __( 'News', 'cm' );
      $submenu[ 'edit.php' ][ 10 ][ 0 ] = __( 'Add News item', 'cm' ); //admin sidebar
      $submenu[ 'edit.php' ][ 16 ][ 0 ] = __( 'News tags', 'cm' );
      /*echo '';*/
}

add_action( 'init', 'nz_change_post_object' );

function nz_change_post_object() {
      global $wp_post_types;
      $labels = &$wp_post_types[ 'post' ]->labels;
      $labels->name =  __( 'News', 'cm' ); //admin list news title
      $labels->singular_name = 'News item22';
      $labels->add_new = 'Add News item'; //admin edit post new shortcut
      $labels->add_new_item = 'Add News item'; //admin edit new post title
      $labels->edit_item = 'Edit News item'; //admin edit post title
      $labels->new_item = 'News6';
      $labels->view_item = 'View News item';   //View button from admin 
      $labels->search_items = 'Search News'; //admin list news search input
      $labels->not_found = 'No News found9';
      $labels->not_found_in_trash = 'No News found in Trash';
      $labels->all_items = 'All News10';
      $labels->menu_name = 'News11';
      $labels->name_admin_bar = 'News item'; //admin top bar
}
