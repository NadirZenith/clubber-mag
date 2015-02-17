<?php

$form_name = 'login_form';
$post_type = 'user';

$LoginForm = new NZ_WP_Form( $form_name, $post_type );

/**
 * name field(unrelated to post)
 */
$type = 'text';
$slug = 'login-email';
$label = __( 'Email', 'cm' );
$atts = array();
$rules = array(
      'required' => array( 'error', __( 'Email is required', 'cm' ) ),
      'email' => array( 'error', __( 'Email is not valid', 'cm' ) ),
);

$LoginForm->addField( $type, $slug, $label, $atts, $rules );

/**
 * pass field(unrelated to post)
 */
$type = 'password';
$slug = 'login-password';
$label = __( 'Password', 'cm' );
$atts = array();
$rules = array(
      'required' => array( 'error', 'Password is required!' ),
      'length' => array( 6, 15, 'error', 'The password must have between 6 and 10 characters' ),
);

$LoginForm->addField( $type, $slug, $label, $atts, $rules );

/**
 * remember field(unrelated to post)
 */
$type = 'checkboxes';
$slug = 'remember';
$label = '';

$atts = array(
      'options' => array( '1' => __( 'Remember me', 'cm' ), )
);
$LoginForm->addField( $type, $slug, $label, $atts );

/**
 * PODCAST submit button
 */
$LoginForm->addSubmit( 'btn_register', __( 'Login', 'cm' ) );


return $LoginForm;
