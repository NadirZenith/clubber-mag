<?php

$form_name = 'coolplace_fast_form';
$post_type = 'cool-place';

$CoolplaceForm = new NZ_WP_Form( $form_name, $post_type );
$CoolplaceForm->post_status = 'draft';
$CoolplaceForm->clientside_validation = false;
$CoolplaceForm->ajax = true;

/**
 * TITLE(text)
 */
$slug = 'coolplace_name';
$label = __( 'Club or place name', 'cm' );
$atts = array();
$rule = array(
      'required' => array( 'error', 'Name is required!' )
);
$CoolplaceForm->addTitle( 'text', $slug, $label, $atts, $rule );

/**
 * map (meta)
 */
$slug = CM_META_MAPA;
$label = __( 'Address', 'cm' );
$atts = array(
      'style' => 'display:none',
      'class' => 'nzGMField',
);
$rules = array(
      'required' => array( 'error', __( 'Address is required', 'cm' ) )
);

$CoolplaceForm->addMetaJson( 'text', $slug, $label, $atts, $rules );



/**
 * PODCAST term
 */
$type = 'checkboxes';
$slug = 'cool_place_type';
$label = __( 'Coolplace type', 'cm' );

$atts = array();
$rules = array(
      'required' => array( 'error', __( 'Type is required', 'cm' ) ),
);

/* $CoolplaceForm->addTerm( $slug, $type, $label, $atts, $rules ); */


/**
 * PODCAST submit button
 */
$CoolplaceForm->addSubmit( 'btn_submit', __( 'Submit', 'cm' ) );
/*


  $CoolplaceForm->addCallback( 'success', 'nz_wp_coolplace_form_success' );

 */

/* $CoolplaceForm->addCallback( 'render', 'nz_wp_coolplace_form_render' ); */

function nz_wp_coolplace_form_render( $html_form ) {
      return $html_form;
}

$CoolplaceForm->addCallback( 'submit', 'nz_wp_coolplace_fast_form_submit' );

function nz_wp_coolplace_fast_form_submit( $nzforms ) {

      $nzforms->wpform->post_author = 1;

      return $nzforms;
}

$CoolplaceForm->addCallback( 'valid', 'nz_wp_coolplace_fast_form_valid' );

function nz_wp_coolplace_fast_form_valid( $nzforms ) {

      $place_id = $nzforms->wpform->postId;

      $field_value = $nzforms->wpform->form->controls[ CM_META_MAPA ]->submitted_value;

      /* $map_info = json_decode( stripslashes( $field_value ), true ); */
      $map_info = json_decode( stripslashes( htmlspecialchars_decode( $field_value ) ), true );

      if ( !empty( $map_info ) )
            set_map_terms( $map_info, $place_id );

      //redirect
      $event_form_url = get_permalink( cm_lang_get_post( CM_RESOURCE_EVENT_PAGE_ID ) );
      $event_form_url = add_query_arg( array( 'relation-to-coolplace' => $place_id ), $event_form_url );
      $nzforms->wpform->redirectTo = $event_form_url;
      /* wp_redirect( $event_form_url ); */
      /* exit(); */
}

return $CoolplaceForm;
