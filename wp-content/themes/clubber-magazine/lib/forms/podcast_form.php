<?php

$form_name = 'podcast_form';
$post_type = 'podcast';

$PodcastForm = new NZ_WP_Form( $form_name, $post_type );
/* $PodcastForm->addConfirmation( 'Sucesso' ); */


/* $PodcastForm->redirectTo( get_author_posts_url( get_current_user_id() ) ); */
/* $PodcastForm->addConfirmation( 'podcast confirmation message' ); */

/* $PodcastForm->form->clientside_validation( false ); */
/* $PodcastForm->ajax = true; */
$PodcastForm->post_status = 'publish';


/**
 * TITLE(hidden)
 */
$slug = 'podcast_content';

$PodcastForm->addContent( 'hidden', $slug,'' );

/**
 * Meta(text)
 */
/* $type = 'nzsoundcloud'; */
$type = 'text';
$slug = CM_META_SOUNDCLOUD;
$label = __( 'Soundcloud Url', 'cm' );


$atts = array(
      'class' => 'nzSCField_newpodcast',
      'style' => 'display:none'
);
$rules = array(
      'required' => array( 'error', __( 'Soundcloud Url is required', 'cm' ) )
);

$PodcastForm->addMetaJson( $type, $slug, $label, $atts, $rules );

/**
 * TITLE(hidden)
 */
$slug = 'podcast_title';

$PodcastForm->addTitle( 'text', $slug, __( 'Title', 'cm' ), array( 'required' => array( 'error', __( 'Title is required', 'cm' ) ) ) );


/**
 * PODCAST submit button
 */
$PodcastForm->addSubmit( 'btn_submit', __( 'Share', 'cm' ) );
/*
 */

/**
 *    render Callback
 */
/* add_filter( 'nzwp_forms_shortcode_' . $form_name, 'nz_wp_podcast_form_render',10,2 ); */
$PodcastForm->addCallback( 'render', 'nz_wp_podcast_form_render' );

function nz_wp_podcast_form_render( $formhtml ) {
      $js = '<script type="text/javascript"> ';
      $js .= '
            $(function() {
                  $(".nzSCField_newpodcast").nzSCField({
                         onComplete: function(track) {
                               var plugin = this;
                               var $form = plugin.$element.offsetParent();
                               console.log("this", this);
                               console.log($form, $form);
                               $form.find("#podcast_title").val(track.title);
                               $form.find("#podcast_content").val(track.description);
                         }
                   });
            });
';

      $js .= ' </script>';


      /* d( $formhtml ); */
      /* return '$formhtml'; */
      return $formhtml . $js;
}

/**
 *    Submit Callback
 */
/* $PodcastForm->addCallback( 'submit', 'nz_wp_podcast_form_submit' ); */

function nz_wp_podcast_form_submit( $nzforms ) {
      if ( !is_user_logged_in() ) {
            global $wp_query;
            $wp_query->set_404();
            return;
      }
      $podcast_id = $nzforms->wpform->editId;
      $uid = get_current_user_id();

      $main_resource_id = get_user_meta( $uid, CM_USER_META_RESOURCE_ID, true );
      $resource = get_post( $main_resource_id );
      if ( !$resource || !in_array( $resource->post_type, array( 'artist', 'label' ) ) || !check_ajax_referer( 'new-podcast-from-' . $resource->ID ) ) {
            global $wp_query;
            $wp_query->set_404();
            return;
      }
}

/**
 *    valid Callback
 */
$PodcastForm->addCallback( 'valid', 'nz_wp_podcast_form_valid' );

function nz_wp_podcast_form_valid( $nzforms ) {
      $podcast_id = $nzforms->wpform->postId;

      $uid = get_current_user_id();
      $main_resource_id = ( int ) get_user_meta( $uid, CM_USER_META_RESOURCE_ID, true );

      $result = p2p_type( 'artists_to_podcasts' )->connect( $main_resource_id, $podcast_id, array(
            'date' => current_time( 'mysql' )
                ) );

      /*
        //redirect
       */
      global $NZS;
      $NZS->getFlashBag()->add( 'success', __( 'Podcast subido' ) );

      wp_redirect( get_author_posts_url( $uid ) );
      exit();
}

return $PodcastForm;
