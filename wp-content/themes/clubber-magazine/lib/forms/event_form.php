<?php

$form_name = 'event_form';
$post_type = 'agenda';
$prefix = 'wpcf-';

$EventForm = new NZ_WP_Form( $form_name, $post_type );
if ( is_super_admin() ) {
      $EventForm->post_status = 'publish';
}

/**
 * relation(text)meta
 */
$post_type = 'cool-place';
$slug = 'relation-to-coolplace';
$label = __( 'Name of the club or place where the event is', 'cm' );
$atts = array(
      'data-placeholder' => __( 'Select a place', 'cm' ),
      'new-resource' => array(
            'url' => get_permalink( cm_lang_get_post( CM_RESOURCE_COOLPLACE_FAST_PAGE_ID ) ),
            'text' => 'New',
            'class' => 'fancybox'
      ),
          /* 'new-resource-url' => get_permalink( cm_lang_get_post( CM_RESOURCE_COOLPLACE_FAST_PAGE_ID ) ) */
);
$rules = array(
      'required' => array( 'error', __( 'Place is required!', 'cm' ) )
);

$EventForm->addRelation( $post_type, $slug, $label, $atts, $rules );


/**
 * TITLE(text) --------------------------------------------
 */
$slug = 'event_name';
$label = __( 'Event name', 'cm' );
$atts = array();
$rules = array(
      'required' => array( 'error', __( 'Name is required!', 'cm' ) )
);
$EventForm->addTitle( 'text', $slug, $label, $atts, $rules );


/**
 * note(unrelated to post) --------------------------------------------
 */
$atts = array(
      'caption' => __( 'Write the name of your event', 'cm' ),
      'attach_to' => 'event_name'
);

$EventForm->addNote( 'note_title', $atts );



/**
 * Fecha Inicio Meta(text) --------------------------------------------
 */
$type = 'text';
$slug = $prefix . 'event_begin_date';
$label = __( 'Begin date', 'cm' );
$atts = array();
$rules = array(
      'required' => array( 'error', __( 'Date is required!', 'cm' ) ),
);

add_filter( 'nzwp_forms_fill_form_metadata_' . $form_name, 'cm_event_form_fill_date_metadata' );
add_filter( 'nzwp_forms_process_form_metadata_' . $form_name, 'cm_event_form_process_date_metadata' );

function cm_event_form_fill_date_metadata( $meta ) {
      /* d( $meta ); */

      if ( isset( $meta[ 'wpcf-event_begin_date' ], $meta[ 'wpcf-event_begin_date' ][ 0 ] ) ) {
            if ( !empty( $meta[ 'wpcf-event_begin_date' ][ 0 ] ) )
                  $meta[ 'wpcf-event_begin_date' ][ 0 ] = date( 'd/m/Y H:i', intval( $meta[ 'wpcf-event_begin_date' ][ 0 ] ) );
      }
      if ( isset( $meta[ 'wpcf-event_end_date' ], $meta[ 'wpcf-event_end_date' ][ 0 ] ) ) {
            if ( !empty( $meta[ 'wpcf-event_end_date' ][ 0 ] ) )
                  $meta[ 'wpcf-event_end_date' ][ 0 ] = date( 'd/m/Y H:i', intval( $meta[ 'wpcf-event_end_date' ][ 0 ] ) );
      }

      return $meta;
}

function cm_event_form_process_date_metadata( $meta ) {
      if ( isset( $meta[ 'wpcf-event_begin_date' ] ) ) {
            $user_input_DATETIME = date_create_from_format( 'd/m/Y H:i', $meta[ 'wpcf-event_begin_date' ] );
            if ( $user_input_DATETIME ) {
                  $meta[ 'wpcf-event_begin_date' ] = $user_input_DATETIME->getTimestamp();
            }
      }
      if ( isset( $meta[ 'wpcf-event_end_date' ] ) ) {
            $user_input_DATETIME = date_create_from_format( 'd/m/Y H:i', $meta[ 'wpcf-event_end_date' ] );
            if ( $user_input_DATETIME ) {
                  $meta[ 'wpcf-event_end_date' ] = $user_input_DATETIME->getTimestamp();
            }
      }
      return $meta;
}

$EventForm->addMeta( $type, $slug, $label, $atts, $rules );


/**
 * note(unrelated to post) --------------------------------------------
 */
$atts = array(
      'caption' => 'Escribe la fecha de inicio',
      'attach_to' => $slug
);

/* $EventForm->addNote( 'note_begin_date', $atts ); */

/**
 * Fecha final Meta(text)--------------------------------------------
 */
$type = 'text';
$slug = $prefix . 'event_end_date';
$label = __( 'End date', 'cm' );
$atts = array();
$rules = array(
      'date' => array( 'error', __( 'Invalid date!', 'cm' ) )
);

$EventForm->addMeta( $type, $slug, $label, $atts, $rules );


/**
 * FEATURED(text) --------------------------------------------
 */
$slug = 'event_featured';
$label = __( 'Event flyer', 'cm' );
$atts = array( 'style' => 'display:none' );
$rules = array( 'required' => array( 'error', __( 'Flyer is required', 'cm' ) ) );
$EventForm->addFeatured( $slug, $label, $atts, $rules );

/**
 * IMAGE meta(text) --------------------------------------------
 */
$slug = 'event_image';
$label = __( 'Event back flyer', 'cm' );
$atts = array(
      /* 'value' => 'http://lab.dev/clubber-mag-dev/wp-content/uploads/gravity_forms/image_preview/1418878391-2.jpg', */
      'style' => 'display:none',
          /* 'style' => 'border:5px solid green;width:100%;', */
);
$EventForm->addImage( $slug, $label, $atts );

/**
 * CONTENT(textarea) --------------------------------------------
 */
$slug = 'event_content';
$label = __( 'Event info', 'cm' );
$atts = array(
);
$rules = array(
      'required' => array( 'error', __( 'Content is required', 'cm' ) ),
);

$EventForm->addContent( 'textarea', $slug, $label, $atts, $rules );


/**
 * Event Type Meta(radios) --------------------------------------------
 */
$type = 'radios';
$slug = $prefix . 'event_type';
$label = __( 'Event type', 'cm' );
$options = array(
      'party' => __( 'Party', 'cm' ),
      'festival' => __( 'Festival', 'cm' ),
);
$atts = array(
      'options' => $options
);
$rules = array(
      'required' => array( 'error', __( 'Type is required', 'cm' ) ),
);

$EventForm->addMeta( $type, $slug, $label, $atts, $rules );

/**
 * Event Promoter(text) --------------------------------------------
 */
$type = 'text';
$slug = $prefix . 'event_promoter';
$label = __( 'Promoter', 'cm' );
$atts = array();
$rules = array();

$EventForm->addMeta( $type, $slug, $label, $atts, $rules );

/**
 * Event price(text) --------------------------------------------
 */
$type = 'text';
$slug = $prefix . 'event_price';
$label = __( 'Price', 'cm' );
$atts = array( 'value' => 0 );
$rules = array(
      'required' => array( 'error', __( 'Price is required', 'cm' ) ),
);

$EventForm->addMeta( $type, $slug, $label, $atts, $rules );

/**
 * Event price conditions(text) --------------------------------------------
 */
$type = 'text';
$slug = $prefix . 'event_price_conditions';
$label = __( 'Price conditions', 'cm' );
$atts = array();
$rules = array();

$EventForm->addMeta( $type, $slug, $label, $atts, $rules );

if ( is_super_admin() ) {
      /**
       * Meta(featured)
       */
      $type = 'checkboxes';
      $slug = $prefix . 'event_featured';
      $label = 'Event featured:';
      $options = array( 'on' => 'featured' );
      $atts = array( 'options' => $options );
      $rules = array();

      $EventForm->addMeta( $type, $slug, $label, $atts, $rules );
}

/**
 * PODCAST submit button --------------------------------------------
 */
$EventForm->addSubmit( 'btn_submit', __( 'Submit', 'cm' ) );

$EventForm->addCallback( 'submit', 'nz_wp_event_form_submit' );
$EventForm->addCallback( 'valid', 'nz_wp_event_form_valid' );

function nz_wp_event_form_submit( $nzform ) {
      if ( is_user_logged_in() ) {
            $nzform->post_author = get_current_user_id();
      }
}

function nz_wp_event_form_valid( $nzform ) {
      //set user promoter
      if ( is_user_logged_in() ) {
            update_user_meta( get_current_user_id(), 'is_promoter', 'true' );
      }

      //copy place term (city)
      $event_id = $nzform->wpform->postId;

      $place_id = get_post_meta( $event_id, 'relation-to-coolplace', true );
      $taxonomy = 'city';
      nz_copy_post_terms( $place_id, $event_id, $taxonomy );
      //end copy term
      //set flash message
      global $NZS;
      $NZS->getFlashBag()->add( 'success', __( 'Thanks for submitting your event', 'cm' ) );

      $url = get_author_posts_url( get_current_user_id() );

      //redirect
      wp_redirect( $url );
      exit();
}

return $EventForm;
