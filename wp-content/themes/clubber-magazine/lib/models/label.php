<?php

$labels = new CPT( array(
      'post_type_name' => 'label',
      'singular' => __( 'Label', 'cm' ),
      'plural' => __( 'Labels', 'cm' ),
      'slug' => 'label'
          ), array(
      'supports' => array( 'title', 'editor', 'thumbnail' ),
      'has_archive' => 'labels'
          )
);


add_action( 'p2p_init', 'cm_labels_connections' );

function cm_labels_connections() {
      p2p_register_connection_type( array(
            'name' => 'open-frequency-to-label',
            'from' => 'open-frequency',
            'to' => 'label'
      ) );
}
