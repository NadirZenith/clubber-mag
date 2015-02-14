<?php

$video = new CPT( array(
      'post_type_name' => 'video',
      'singular' => __('Video','cm'),
      'plural' => __('Videos','cm'),
      'slug' => 'video'
          ), array(
      'supports' => array( 'title', 'editor', 'thumbnail', 'author', 'custom-fields' ),
      'has_archive' => 'videos'
          )
);


/**
 * register custom metadata groups and fields
 * this is the example code that you should use
 * make sure to use the 'admin_init' hook as below
 *
 * @return void
 */
add_action( 'custom_metadata_manager_init_metadata', 'cm_video_custom_fields' );

function cm_video_custom_fields() {

      x_add_metadata_group( 'youtube_video_metabox', 'video', array(
            'label' => 'video group field'
      ) );

      x_add_metadata_field( 'wpcf-video-url', 'video', array(
            'group' => 'youtube_video_metabox', // the group name
            'label' => 'Video URL', // field label
            'description' => 'Youtube video url', // description for the field
            'display_column' => false // show this field in the column listings
      ) );
}
