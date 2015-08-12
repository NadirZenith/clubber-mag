<?php

$form_name = 'label_form';
$post_type = 'label';
$prefix = '';

$LabelForm = new NZ_WP_Form( $form_name, $post_type );

/**
 * TITLE(text) --------------------------------------------
 */
$slug = 'label_name';
$label = __( 'Label Name', 'cm' );
$atts = array();
$rule = array(
      'required' => array( 'error', __( 'Name is required', 'cm' ) )
);
$LabelForm->addTitle( 'text', $slug, $label, $atts, $rule );

/**
 * FEATURED(text) --------------------------------------------
 */
$slug = 'label_featured';
$label = __( 'Label image', 'cm' );
$atts = array(
      // 'value' => 'http://lab.dev/clubber-mag-dev/wp-content/uploads/cache/preview/1419004629-17.jpg',
      'style' => 'display:none',
          /* 'data-preview' => 'http://lab.dev/clubber-mag-dev/wp-content/uploads/cache/preview/1419004629-17.jpg' */
);
$rules = array( 'required' => array( 'error', __( 'Image is required', 'cm' ) ) );

$LabelForm->addFeatured( $slug, $label, $atts, $rules );

/**
 * CONTENT(textarea) --------------------------------------------
 */
$slug = 'label_content';
$label = __( 'Label info', 'cm' );
$atts = array();
$rules = array();

$LabelForm->addContent( 'textarea', $slug, $label, $atts, $rules );

/* CONTACT FIELDS -------------------------------------------- */
$rules = array(
      'email' => array( 'error', __( 'Email is not valid', 'cm' ) ),
);
$LabelForm->addMeta( 'text', 'email', __( 'Email', 'cm' ), $atts, $rules );

$socials = array(
      'home' => __( 'Link Pagina Oficial', 'cm' ),
      'facebook' => __( 'Link Facebook', 'cm' ),
      'soundcloud' => __( 'Link Soundcloud', 'cm' ),
      'instagram' => __( 'Link Instagram', 'cm' ),
      'google-plus' => __( 'Link Google +', 'cm' ),
      'youtube' => __( 'Link Youtube', 'cm' ),
      'twitter' => __( 'Link Twitter', 'cm' ),
      'beatport' => __( 'Link Beatport', 'cm' ),
      'bandpage' => __( 'Link Bandpage', 'cm' )
);

foreach ( $socials as $network => $description ) {
      $slug = $network;
      $label = ucfirst( $network ) . ' url:';
      $atts = array();
      $rules = array(
            'url' => array( true, 'error', __( 'Url is not valid, ex: http://www.example.com, don\'t forget the protocol http://', 'cm' ) ),
      );

      $LabelForm->addMeta( 'text', $slug, $label, $atts, $rules );
}

/* END CONTACT FIELDS */

/**
 * submit button --------------------------------------------
 */
$LabelForm->addSubmit( 'btn_submit', __( 'Submit', 'cm' ) );
/*

 */
$LabelForm->addCallback( 'submit', 'nz_wp_label_form_submit' );
$LabelForm->addCallback( 'valid', 'nz_wp_label_form_valid' );
$LabelForm->addNotification( 'gracias por subir su label' );

function nz_wp_label_form_submit( $nzform ) {
      $nzform->post_author = get_current_user_id();
}

function nz_wp_label_form_valid( $nzforms ) {
      $post_id = $nzforms->wpform->postId;
      $uid = get_current_user_id();

      //set main resource
      update_user_meta( $uid, CM_USER_META_RESOURCE_ID, $post_id );

//      update_user_meta( $uid, 'main_resource', 'label' );
      //     update_user_meta( $uid, 'label_page', $post_id );
      //redirect
      global $NZS;
      $NZS->getFlashBag()->add( 'success', 'Label guardado' );
      $url = get_author_posts_url( $uid );

      wp_redirect( $url );
      exit();
}

//return form
return $LabelForm;
