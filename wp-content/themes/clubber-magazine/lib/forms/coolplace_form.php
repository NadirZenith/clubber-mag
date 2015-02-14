<?php

$form_name = 'coolplace_form';
$post_type = 'cool-place';

$CoolplaceForm = new NZ_WP_Form( $form_name, $post_type );
$CoolplaceForm->post_status = 'publish';
$CoolplaceForm->addNotification( 'gracias por subir su cool place' );

/**
 * TITLE(text) --------------------------------------------
 */
$slug = 'coolplace_name';
$label = __( 'Coolplace name', 'cm' );
$atts = array();
$rule = array(
      'required' => array( 'error', __( 'Name is required', 'cm' ) )
);
$CoolplaceForm->addTitle( 'text', $slug, $label, $atts, $rule );

/**
 * FEATURED(text) --------------------------------------------
 */
$slug = 'coolplace_featured';
$label = __( 'Coolplace image', 'cm' );
$atts = array( 'style' => 'display:none' );
$rules = array(
      'required' => array( 'error', __( 'Image is required', 'cm' ) )
);

$CoolplaceForm->addFeatured( $slug, $label, $atts, $rules );

/**
 * CONTENT(textarea) --------------------------------------------
 */
$slug = 'coolplace_content';
$label = __( 'Coolplace info', 'cm' );
$atts = array();
$rules = array();

$CoolplaceForm->addContent( 'textarea', $slug, $label, $atts, $rules );

/**
 * map (meta) --------------------------------------------
 */
$slug = CM_META_MAPA;
$label = __( 'Address', 'cm' );
$atts = array(
      'class' => 'nzGMField',
      'style' => 'display:none'
);
$rules = array(
      'required' => array( 'error', __( 'Address is required', 'cm' ) ),
);

$CoolplaceForm->addMetaJson( 'text', $slug, $label, $atts, $rules );

/**
 * PODCAST term --------------------------------------------
 */
$type = 'checkboxes';
$slug = 'cool_place_type';
$label = __( 'Coolplace type', 'cm' );
$atts = array();
$rules = array(
      'required' => array( 'error', __( 'Type is required', 'cm' ) ),
);

$CoolplaceForm->addTerm( $slug, $type, $label, $atts, $rules );


/* CONTACT FIELDS -------------------------------------------- */
$rules = array(
      'email' => array( 'error', __( 'Email is not valid', 'cm' ) ),
);
$CoolplaceForm->addMeta( 'text', 'email', __( 'Email', 'cm' ), array(), $rules );

$socials = array(
      'home' => __( 'Link Pagina Oficial', 'cm' ),
      'facebook' => __( 'Link Facebook', 'cm' ),
      'instagram' => __( 'Link Instagram', 'cm' ),
      'google-plus' => __( 'Link Google +', 'cm' ),
      'twitter' => __( 'Link Twitter', 'cm' ),
);

foreach ( $socials as $network => $description ) {
      $slug = $network;
      $label = ucfirst( $network ) . ' url:';
      $atts = array(
      );
      $rules = array(
            'url' => array( true, 'error', __( 'Url is not valid', 'cm' ) ),
      );

      $CoolplaceForm->addMeta( 'text', $slug, $label, $atts, $rules );
}

/* END CONTACT FIELDS */

/**
 * submit button --------------------------------------------
 */
$CoolplaceForm->addSubmit( 'btn_submit', __( 'Submit', 'cm' ) );

$CoolplaceForm->addCallback( 'submit', 'nz_wp_coolplace_form_submit' );
$CoolplaceForm->addCallback( 'valid', 'nz_wp_coolplace_form_valid' );

function nz_wp_coolplace_form_submit( $nzform ) {
      //set auhor the cuurent user
      $nzform->post_author = get_current_user_id();
}

function nz_wp_coolplace_form_valid( $nzforms ) {
      $post_ID = $nzforms->wpform->postId;
      $uid = get_current_user_id();

      //check for user main resource
      update_user_meta( $uid, CM_USER_META_RESOURCE_ID, $post_ID );

      $field_value = $nzforms->wpform->form->controls[ CM_META_MAPA ]->submitted_value;

      /* $map_info = json_decode( stripslashes( $field_value ), true ); */
      /* d( $map_info ); */
      $map_info = json_decode( stripslashes( htmlspecialchars_decode( $field_value ) ), true );

      if ( !empty( $map_info ) )
            set_map_terms( $map_info, $post_ID );

      //redirect
      global $NZS;
      $NZS->getFlashBag()->add( 'success', 'Coolplace guardado' );

      wp_redirect( get_author_posts_url( $uid ) );
      exit();
}

return $CoolplaceForm;
