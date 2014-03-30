<?php

if (function_exists("register_field_group")) {
      register_field_group(array(
          'id' => 'acf_photo-type',
          'title' => 'Photo gallery',
          'fields' => array(
              array(
                  'key' => 'photo_gallery',
                  'label' => 'Gallery',
                  'name' => 'photo_gallery',
                  'type' => 'gallery',
                  'preview_size' => '290-160-thumb',
              ),
          ),
          'location' => array(
              array(
                  array(
                      'param' => 'post_type',
                      'operator' => '==',
                      'value' => 'photo',
                      'order_no' => 0,
                      'group_no' => 0,
                  ),
              ),
          ),
          'options' => array(
              'position' => 'normal',
              'layout' => 'default',
              'hide_on_screen' => array(
              ),
          ),
          'menu_order' => 0,
      ));
}
