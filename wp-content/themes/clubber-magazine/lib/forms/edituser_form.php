<?php

$form_name = 'edituser_form';
$post_type = 'user';

$UserForm = new NZ_WP_Form( $form_name, $post_type );

/**
 * PROFILE IMAGE meta(text)
 */
$slug = 'userprofile_image';
$label = __( 'Background image', 'cm' );
$default = get_template_directory_uri() . '/assets/images/user/user-profile-ph.jpg';

$url = nz_get_user_image( $curauth->ID, 'profile', $default );
$atts = array(
      'value' => $url,
      'style' => 'display:none',
);
add_filter( 'nz_wp_form_' . $form_name . '_' . $slug, 'cm_set_user_profile_image' );

function cm_set_user_profile_image( $file ) {

      $size = array( 160, 160 );
      $size_name = 'profile';
      $user_id = get_current_user_id();

      nz_set_user_image( $user_id, $file, $size_name, $size );

      return false;
}

$UserForm->addImage( $slug, $label, $atts );

/**
 * BACKGROUND IMAGE meta(text)
 */
$slug = 'userbackground_image';
$label = __( 'Background image', 'cm' );
$default = get_template_directory_uri() . '/assets/images/user/user-background-ph.jpg';

$url = nz_get_user_image( $curauth->ID, 'background', $default );
$atts = array(
      'value' => $url,
      'style' => 'display:none',
);

add_filter( 'nz_wp_form_' . $form_name . '_' . $slug, 'cm_set_user_background_image' );

function cm_set_user_background_image( $file ) {

      $size = array( 582, 200 );
      $size_name = 'background';
      $user_id = get_current_user_id();

      nz_set_user_image( $user_id, $file, $size_name, $size );

      return false;
}

$UserForm->addImage( $slug, $label, $atts );

/**
 * Description field
 */
$slug = 'edit_description';
$label = __( 'Info', 'cm' );
$atts = array();
$rules = array(
      'length' => array( 50, 500, 'error', __( 'Between 50 to 500 chars allowed', 'cm' ), true )
);
$UserForm->addUserDescription( $slug, $label, $atts, $rules );
/**
 * email field
 */
$slug = 'edit_email';
$label = __( 'Email', 'cm' );
$atts = array();
$rules = array(
      'required' => array( 'error', __( 'Email is required', 'cm' ) ),
      'email' => array( 'error', __( 'Email is not valid', 'cm' ) ),
);

$UserForm->addUserEmail( $slug, $label, $atts, $rules );
/**
 * Display field
 */
$slug = 'edit_display_name';
$label = __( 'Display Name', 'cm' );
$atts = array(
);
$rules = array(
      'required' => array( 'error', __( 'Display name is required', 'cm' ) ),
);

$UserForm->addUserDisplayName( $slug, $label, $atts, $rules );

/* CONTACT FIELDS */
$socials = array(
      'home' => __( 'Link Pagina Oficial', 'cm' ),
      'facebook' => __( 'Link Facebook', 'cm' ),
      'soundcloud' => __( 'Link Soundcloud', 'cm' ),
      'instagram' => __( 'Link Instagram', 'cm' ),
      'google-plus' => __( 'Link Google +', 'cm' ),
      'youtube' => __( 'Link Youtube', 'cm' ),
      'twitter' => __( 'Link Twitter', 'cm' ),
);

foreach ( $socials as $network => $description ) {
      $slug = $network;
      $label = ucfirst( $network ) . ' url:';
      $atts = array(
      );
      $rules = array(
            'url' => array( false, 'error', __( 'Url is not valid', 'cm' ) ),
      );

      $UserForm->addMeta( 'text', $slug, $label, $atts, $rules );
}

/* END CONTACT FIELDS */


/* * _nz_user_profile_images
 * pass field(unrelated to post)
 */
$slug = 'register_password';
$label = __( 'Password', 'cm' );
$atts = array(
      'confirm' => true,
      /* 'confirm_label' => 'Confirm password', */
      'confirm_error' => 'Not correct verified'
);
$rules = array(
      'required' => array( 'error', __( 'Password is required', 'cm' ) ),
      'length' => array( 3, 15, 'error', 'The password must have between 6 and 10 characters' ),
);

/* $UserForm->addUserPass( $slug, $label, $atts, $rules ); */


/* ---------------- */
/* $UserForm->addClear(); */

/**
 * PODCAST submit button
 */
$UserForm->addSubmit( 'btn_register', __( 'Submit', 'cm' ) );

//$type, $slug, $title, $atts = array(), $rules = array()
//$UserForm->addField( 'nztext', 'test_text', 'test text',array( 'value' => 'hello' ), array( 'required' => array( 'error', 'field is required' ) ) );


/*

  $EventForm->addCallback( 'submit', 'nz_wp_event_form_submit' );

 */
$UserForm->addCallback( 'valid', 'nz_wp_edituser_form_valid' );

function nz_wp_edituser_form_valid( $nzform ) {
      global $NZS;
      $NZS->getFlashBag()->add( 'success', 'Info guardada' );
      $url = get_author_posts_url( get_current_user_id() );

      wp_redirect( $url );
      exit();
}

return $UserForm;
