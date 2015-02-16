<?php

// create a book custom post type
$events = new CPT( array(
      'post_type_name' => 'agenda',
      'singular' => __( 'Event', 'cm' ),
      'plural' => __( 'Events', 'cm' ),
      'slug' => 'agenda'
          ), array(
      'supports' => array( 'title', 'editor', 'thumbnail', 'author', 'custom-fields' ),
      'has_archive' => TRUE
          )
);

$events->register_taxonomy( array(
      'taxonomy_name' => 'city',
      'singular' => __( 'City', 'cm' ),
      'plural' => __( 'Cities', 'cm' ),
      'slug' => 'ciudad'
          )
);

$events->register_taxonomy( array(
      'taxonomy_name' => 'country',
      'singular' => __( 'Country', 'cm' ),
      'plural' => __( 'Countries', 'cm' ),
      'slug' => 'country'
          )
);

/* relation to users */
add_action( 'p2p_init', 'cm_events_connections' );

function cm_events_connections() {
      p2p_register_connection_type( array(
            'name' => 'events_to_users',
            'from' => 'agenda',
            'to' => 'user'
      ) );
}

add_action( 'custom_metadata_manager_init_metadata', 'cm_agenda_custom_fields' );

function cm_agenda_custom_fields() {
      $group = 'event_metabox';
      $post_type = 'agenda';
      $prefix = 'wpcf-';

      x_add_metadata_group( $group, $post_type, array(
            'label' => 'Agenda field group'
      ) );

      x_add_metadata_field( $prefix . 'event_begin_date', $post_type, array(
            'group' => $group, // the group name
            'label' => 'Fecha inicio', // field label
            /* 'description' => 'Fecha inicio evento', // description for the field */
            'display_column' => true, // show this field in the column listings
            'field_type' => 'datetimepicker',
                /* 'readonly' => FALSE, */
      ) );
      x_add_metadata_field( $prefix . 'event_end_date', $post_type, array(
            'group' => $group,
            'label' => 'Fecha Final',
            'field_type' => 'datetimepicker',
      ) );

      x_add_metadata_field( $prefix . 'event_price', $post_type, array(
            'group' => $group,
            'label' => 'Precio',
      ) );
      x_add_metadata_field( $prefix . 'event_price_conditions', $post_type, array(
            'group' => $group,
            'label' => 'Condiciones del Precio',
      ) );
      x_add_metadata_field( $prefix . 'event_place_name', $post_type, array(
            'group' => $group,
            'label' => 'Nombre del lugar',
      ) );
      x_add_metadata_field( $prefix . 'event_place_address', $post_type, array(
            'group' => $group,
            'label' => 'Dirección del lugar',
      ) );
      x_add_metadata_field( $prefix . 'event_flyer_back', $post_type, array(
            'group' => $group,
            'label' => 'Back flyer',
            'field_type' => 'upload'
      ) );
      /*
       */
      x_add_metadata_field( $prefix . 'event_type', $post_type, array(
            'group' => $group,
            'field_type' => 'radio',
            'label' => 'Tipo de evento',
            'values' => array(
                  'party' => 'party',
                  'festival' => 'festival'
            )
      ) );
      x_add_metadata_field( $prefix . 'event_promoter', $post_type, array(
            'group' => $group,
            'label' => 'Promotor del evento',
      ) );

      x_add_metadata_field( $prefix . 'event_featured', $post_type, array(
            'group' => $group,
            'label' => 'Destacado',
            'field_type' => 'checkbox',
      ) );
}

add_action( 'pre_get_posts', 'cm_pre_get_archive_agenda' );

function cm_pre_get_archive_agenda( $query ) {

      if (
                !$query->is_main_query() || $query->is_admin
      )
            return;

      if (
                $query->is_post_type_archive( 'agenda' ) ||
                $query->is_tax( 'city' )
      ) {

            Roots_Wrapping::$raw = TRUE;
            $query->set( 'posts_per_page', -1 );
            $query->set( 'post_type', "agenda" );

            $query->set( 'orderby', "meta_value_num" );
            $query->set( 'meta_key', "wpcf-event_begin_date" );
            $query->set( 'order', "ASC" );

            $start_date = strtotime( "now" );

            $date = get_query_var( 'date' );
            $DateTime = DateTime::createFromFormat( 'd-m-Y', $date );
            if ( $DateTime ) {
                  $DateTime->setTime( 0, 0, 0 ); //to avoid date problems
                  $start_date = $DateTime->getTimestamp();
            }

            $end_date = strtotime( '+ 1 week', $start_date );
            $prev_date = strtotime( '- 1 week', $start_date );

            $meta_query = array(
                  array(
                        'key' => 'wpcf-event_begin_date',
                        'value' => array( $start_date, $end_date ),
                        'type' => 'NUMERIC',
                        'compare' => 'BETWEEN'
                  )
            );

            $query->set( 'meta_query', $meta_query );
      }
}
