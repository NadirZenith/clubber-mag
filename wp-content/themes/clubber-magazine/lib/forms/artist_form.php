<?php

$form_name = 'artist_form';
$post_type = 'artist';
$prefix = '';

$ArtistForm = new NZ_WP_Form( $form_name, $post_type );

/**
 * TITLE(text) --------------------------------------------
 */
$slug = 'artist_name';
$label = __( 'Artist name', 'cm' );
$atts = array();
$rule = array(
      'required' => array( 'error', __( 'Name is required!', 'cm' ) )
);
/*
  if ( NZ_WP_Forms::$isEdit ) {
  if ( NZ_WP_Forms::$isEdit && !NZ_WP_Forms::$isSubmit ) {
  $atts[ 'disabled' ] = 'true';
  unset($rule['required']);
  }
 */
$ArtistForm->addTitle( 'text', $slug, $label, $atts, $rule );

/**
 * FEATURED(text) --------------------------------------------
 */
$slug = 'artist_featured';
$label = __( 'Artist image', 'cm' );
$atts = array(
      // 'value' => 'http://lab.dev/clubber-mag-dev/wp-content/uploads/cache/preview/1419004629-17.jpg',
      'style' => 'display:none',
          /* 'data-preview' => 'http://lab.dev/clubber-mag-dev/wp-content/uploads/cache/preview/1419004629-17.jpg' */
);
$rules = array(
      'required' => array( 'error', __( 'Image is required', 'cm' ) )
);
$ArtistForm->addFeatured( $slug, $label, $atts, $rules );

/**
 * CONTENT(textarea) --------------------------------------------
 */
$slug = 'artist_content';
$label = __( 'Artist info', 'cm' );
$atts = array();
$rules = array();

$ArtistForm->addContent( 'textarea', $slug, $label, $atts, $rules );



/* CONTACT FIELDS -------------------------------------------- */
$rules = array(
      'email' => array( 'error', __( 'Email is not valid', 'cm' ) ),
);
$ArtistForm->addMeta( 'text', 'email', __( 'Email', 'cm' ), array(), $rules );

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
      $atts = array(
      );
      $rules = array(
            'url' => array( true, 'error', __( 'Url is not valid', 'cm' ) ),
      );

      $ArtistForm->addMeta( 'text', $slug, $label, $atts, $rules );
}

/* END CONTACT FIELDS */

/**
 * submit button --------------------------------------------
 */
$ArtistForm->addSubmit( 'btn_submit', __( 'Submit', 'cm' ) );


$ArtistForm->addCallback( 'submit', 'nz_wp_artist_form_submit' );
$ArtistForm->addCallback( 'valid', 'nz_wp_artist_form_valid' );
$ArtistForm->addNotification( 'gracias por subir su artista' );

function nz_wp_artist_form_submit( $nzform ) {
      $nzform->post_author = get_current_user_id();
}

function nz_wp_artist_form_valid( $nzforms ) {
      /* df( $nzforms ); */
      $post_id = $nzforms->wpform->postId;
      $uid = get_current_user_id();

      //set main resource
      update_user_meta( $uid, CM_USER_META_RESOURCE_ID, $post_id );


      //redirect
      global $NZS;
      $NZS->getFlashBag()->add( 'success', 'Artista guardado' );

      wp_redirect( get_author_posts_url( $uid ) );
      exit();
}

//return form
return $ArtistForm;
