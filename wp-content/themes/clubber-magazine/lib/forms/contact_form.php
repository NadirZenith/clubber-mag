<?php

$form_name = 'contact_form';
$post_type = 'post';

$ContactForm = new NZ_WP_Form( $form_name, $post_type );
$ContactForm->auto_process = false;
$ContactForm->addConfirmation( 'thank you for your contact' );

/**
 * Name
 */
$slug = 'contact_name';
$label = __( 'Name', 'cm' );
$atts = array();
if ( is_user_logged_in() ) {
      $atts[ 'value' ] = get_the_author_meta( 'display_name', get_current_user_id() );
}
$rule = array(
      'required' => array( 'error',  __( 'Name is required', 'cm' ) )
);
$ContactForm->addField( 'text', $slug, $label, $atts, $rule );
/**
 * Email
 */
$slug = 'contact_email';
$label = __( 'Email', 'cm' );
$atts = array();
if ( is_user_logged_in() ) {
      $atts[ 'value' ] = get_the_author_meta( 'user_email', get_current_user_id() );
}
$rule = array(
      'required' => array( 'error',  __( 'Email is required', 'cm' ) ),
      'email' => array( 'error',  __( 'Email is not valid', 'cm' ) )
);
$ContactForm->addField( 'text', $slug, $label, $atts, $rule );

/**
 * Message
 */
$slug = 'contact_message';
$label = __( 'Content', 'cm' );
$atts = array(
);
$rules = array(
      'required' => array( 'error', __( 'Info is required', 'cm' ) )
);

$ContactForm->addField( 'textarea', $slug, $label, $atts, $rules );

/**
 * PODCAST submit button
 */
$ContactForm->addSubmit( 'btn_submit', __( 'Submit', 'cm' ) );

$ContactForm->addCallback( 'valid', 'nz_wp_contact_form_valid' );

function nz_wp_contact_form_valid( $nzforms ) {
      //send email
      add_filter( 'wp_mail_content_type', function($content_type) {
            return 'text/html';
      } );
      
      //send admin email
      $to = get_option( 'admin_email', '2cb.md2@gmail.com' );
      $subject = 'CM Contact From ' . $nzforms->wpform->form->controls[ 'contact_name' ]->submitted_value;
      $content = $nzforms->wpform->form->controls[ 'contact_message' ]->submitted_value;
      $r = wp_mail( $to, $subject, $content );
      /* $r = wp_mail( 'albertino05@gmail.com', 'Contacto clubber magazine', '$content' ); */

      if ( !is_user_logged_in() )
            return;

      global $NZS;
      //redirect
      $uid = get_current_user_id();
      $NZS->getFlashBag()->add( 'success', $nzforms->renderConfirmations() );
      $url = get_author_posts_url( $uid );

      wp_redirect( $url );
      exit();
}

return $ContactForm;
