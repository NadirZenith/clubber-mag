<?php

$form_name = 'login_form';
$post_type = 'user';

$LoginForm = new NZ_WP_Form( $form_name, $post_type );

if ( isset( $_GET[ 'recover' ] ) ) {

      if ( empty( $_GET[ 'recover' ] ) ) {

            $type = 'text';
            $slug = 'recover-email';
            $label = __( 'Email', 'cm' );
            $atts = array();
            $rules = array(
                  'required' => array( 'error', __( 'Email is required', 'cm' ) ),
                  'email' => array( 'error', __( 'Email is not valid', 'cm' ) ),
            );

            $LoginForm->addField( $type, $slug, $label, $atts, $rules );

            $LoginForm->addConfirmation( 'verify your email' );
            $LoginForm->addSubmit( 'btn_recover', __( 'Recover password', 'cm' ) );
      } else {
            /**
             * pass field(unrelated to post)
             */
            $slug = 'recover-pass';
            $label = __( 'Password', 'cm' );
            $atts = array(
                  /* 'value' => '', */
                  'confirm' => true,
                  'confirm_error' => __( 'Password does not match', 'cm' ),
            );
            $rules = array(
                  'required' => array( 'error', __( 'Password is required', 'cm' ) ),
                  'length' => array( 6, 16, 'error', __( 'The password must have between 6 and 16 characters', 'cm' ) ),
            );

            $LoginForm->addUserPass( $slug, $label, $atts, $rules );
            $LoginForm->redirectTo( get_permalink( CM_CONNECT_PAGE_ID ) );
            $LoginForm->addSubmit( 'btn_set_password', __( 'Set password', 'cm' ) );
      }
} else {

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

      $LoginForm->addSubmit( 'btn_register', __( 'Login', 'cm' ) );
}
return $LoginForm;
