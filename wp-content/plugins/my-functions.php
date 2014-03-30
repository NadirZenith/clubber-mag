<?php

/**
 * Plugin Name: my functions
 * Plugin URI: http://www.slice.com.es/wp-plugins/custom
 * Description: multiple debug functions.
 * Version: 0.1b
 * Author: NadirZenith
 * Author URI: http://www.slice.com.es
 * License: GPL2
 */
add_filter("the_content", "custom_content_after_post");

function custom_content_after_post($content) {

      if (is_single()) {
            d(the_meta());
      }

      return $content;
}

add_filter('intermediate_image_sizes_advanced', 'filter_image_sizes');

function filter_image_sizes($sizes) {
      unset($sizes['thumbnail']);
      unset($sizes['medium']);
      unset($sizes['large']);

      return $sizes;
}

?>