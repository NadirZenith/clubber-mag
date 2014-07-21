<?php

add_filter('intermediate_image_sizes_advanced', 'filter_image_sizes');

function filter_image_sizes($sizes) {

        unset($sizes['thumbnail']);
        unset($sizes['medium']);
        unset($sizes['large']);

        /*
          $post_type = get_post_type($_POST['post_id']);
          switch ($post_type) {
          case 'artistas' :
          unset($sizes['290-160-thumb']);
          unset($sizes['340-155-thumb']);
          unset($sizes['430-190-thumb']);
          unset($sizes['single-thumb']);

          break;
          default :
          break;
          }
         */

        return $sizes;
}

function clubber_register_image_sizes() {

        add_image_size('290-160-thumb', 290, 160, true); //EVENT 25%

        add_image_size('340-155-thumb', 340, 155, true); //NEWS / MUSIC ??PX
        //old home-gallery-thumb
        add_image_size('430-190-thumb', 430, 190, true); //archive & taxonomy archive photo

        add_image_size('single-thumb', 700, 300, false); // single
}
