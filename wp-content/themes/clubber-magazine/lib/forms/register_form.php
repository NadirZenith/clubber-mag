<?php

$form_name = 'register_form';
$post_type = 'user';

$RegisterForm = new NZ_WP_Form( $form_name, $post_type );

/**
 * username field
 */
$slug = 'register_username';
$label = __( 'Username', 'cm' );
$atts = array();
$rules = array(
      'required' => array( 'error', __( 'Username is required', 'cm' ) ),
      'regexp' => array(
            '^[a-z0-9_-]{3,16}$',
            'error',
            __( 'Allowed characteres ', 'cm' ) . '[a-z0-9_-]{3,16}'
      )
);

$RegisterForm->addUserLogin( $slug, $label, $atts, $rules );
/**
 * email field
 */
$slug = 'register_email';
$label = __( 'Email', 'cm' );
$atts = array();
$rules = array(
      'required' => array( 'error', __( 'Email is required', 'cm' ) ),
      'email' => array( 'error', __( 'Email is not valid', 'cm' ) ),
);

$RegisterForm->addUserEmail( $slug, $label, $atts, $rules );

/**
 * pass field(unrelated to post)
 */
$slug = 'register_password';
$label = __( 'Password', 'cm' );
$atts = array(
      'confirm' => true,
      'confirm_error' => __( 'Password does not match', 'cm' ),
);
$rules = array(
      'required' => array( 'error', __( 'Password is required', 'cm' ) ),
      'length' => array( 6, 16, 'error', __( 'The password must have between 6 and 16 characters', 'cm' ) ),
);

$RegisterForm->addUserPass( $slug, $label, $atts, $rules );

/**
 * PODCAST submit button
 */
$RegisterForm->addSubmit( 'btn_register', __( 'Submit', 'cm' ) );



return $RegisterForm;
