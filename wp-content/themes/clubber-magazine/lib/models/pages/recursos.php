<?php

//PAGE RECURSOS REWRITE 
/* add_filter( 'page_rewrite_rules', 'rewrite_page_recursos' ); */
//using pages instead!
function rewrite_page_recursos( $rules ) {
      $query_var_name = 'type';
      $page_slug = 'recursos';

      /* d($rules); */
      /* $rules['^recursos/([^/]+)?'] = 'index.php?pagename=recursos&type=$matches[1]'; */
      $rules[ '^recursos/([^/]+)?/?([^/]+)?' ] = 'index.php?pagename=recursos&type=$matches[1]&action=$matches[2]';
      return $rules;
}

/**
 *      filter for pre get page_recursos
 */
add_action( 'pre_get_posts', 'nz_pre_get_page_recursos' );

function nz_pre_get_page_recursos( $query ) {
      if (
                !$query->is_main_query() || !is_page_template( 'page-template-resources.php' )
      ) {
            return;
      }
      $current_page = $query->get_queried_object();
      /* $resource_page_id = cm_lang_get_post( $query->get_queried_object_id(), 'es' ); */
      $resource_page_id = $query->get_queried_object_id();

      if ( $resource_page_id == CM_RESOURCE_MAIN_PAGE_ID ) {

            return;
      } else {
            if ( !is_user_logged_in() ) {
                  global $NZS;

                  $NZS->getFlashBag()->add( 'success', __( 'Please login to manage resources', 'cm' ) );
                  $login_url = get_permalink( CM_CONNECT_PAGE_ID );

                  wp_redirect( $login_url );
                  exit();
            }

            /* $current_user = wp_get_current_user(); */
      }
      $main_resource_id = get_user_meta( get_current_user_id(), CM_USER_META_RESOURCE_ID, true );

      $main_resource = get_post( $main_resource_id );
      $edit_id = ( int ) $query->get( NZ_WP_Forms::$edit_query_var );

      if ( $resource_page_id == CM_RESOURCE_ARTIST_PAGE_ID ) {//IS RESOURCE ARTIST
            //check for main resource
            if ( !empty( $main_resource ) & $main_resource->post_type != 'artist' ) {
                  global $NZS;

                  $NZS->getFlashBag()->add( 'success', __( 'You can only manage one resource per user' ) );

                  $url = get_author_posts_url( get_current_user_id() );
                  wp_redirect( $url );
                  exit();
            }

            //if there is artist page and is not editing redirect to it
            if ( $main_resource && !$edit_id ) {
                  global $NZS;
                  $NZS->getFlashBag()->add( 'success', sprintf( __( 'You can only manage one %s page per user, edit it here' ), __( 'artist' ) ) );


                  $path = NZ_WP_Forms::link( $query->get( 'pagename' ), $main_resource_id );
                  $link = home_url( $path );
                  wp_redirect( $link );
                  exit();
            } elseif ( $edit_id != $main_resource_id ) {
                  //if the artist page is not the user artist page set 404      
                  status_header( 403 );
                  $query->set_404();
                  die( 'artist - 403' );
            }
      } elseif ( $resource_page_id == CM_RESOURCE_LABEL_PAGE_ID ) {//IS RESOURCE LABEL
            //check for main resource
            if ( !empty( $main_resource ) & $main_resource->post_type != 'label' ) {
                  global $NZS;
                  $NZS->getFlashBag()->add( 'success', __( 'You can only manage one resource per user' ) );

                  $url = get_author_posts_url( get_current_user_id() );
                  wp_redirect( $url );
                  exit();
            }

            //if there is label page and is not editing redirect to it
            if ( $main_resource && !$edit_id ) {
                  global $NZS;
                  $NZS->getFlashBag()->add( 'success', sprintf( __( 'You can only manage one %s page per user, edit it here' ), __( 'label' ) ) );

                  $path = NZ_WP_Forms::link( $query->get( 'pagename' ), $main_resource_id );
                  $link = home_url( $path );
                  wp_redirect( $link );
                  exit();
            } elseif ( $edit_id != $main_resource_id ) {
                  //if the artist page is not the user artist page set 404      
                  status_header( 403 );
                  $query->set_404();
                  die( 'label - 403' );
            }
      } elseif ( $resource_page_id == CM_RESOURCE_COOLPLACE_PAGE_ID ) {//IS RESOURCE COOLPLACE
            // //check for main resource
            if ( !empty( $main_resource ) & $main_resource->post_type != 'cool-place' ) {
                  global $NZS;
                  $NZS->getFlashBag()->add( 'success', __( 'You can only manage one resource per user' ) );

                  $url = get_author_posts_url( get_current_user_id() );
                  wp_redirect( $url );
                  exit();
            }

            //if there is artist page and is not editing redirect to it
            if ( $main_resource && !$edit_id ) {
                  global $NZS;
                  $NZS->getFlashBag()->add( 'success', 'Solo puedes tener una página de local, edita la aqui' );

                  $path = NZ_WP_Forms::link( $query->get( 'pagename' ), $main_resource_id );
                  $link = home_url( $path );
                  wp_redirect( $link );
                  exit();
            } elseif ( $edit_id != $main_resource_id ) {
                  //if the artist page is not the user artist page set 404      
                  status_header( 403 );
                  $query->set_404();
                  die( 'coolplace - 403' );
            }
      }
}

/**
 *      filter for pre get page_recursos
 */
/* add_action( 'pre_get_posts', 'nz_pre_get_page_newpodcast' ); */

function nz_pre_get_page_newpodcast( $query ) {
      if (
                !$query->is_main_query() || !is_page( CM_RESOURCE_PODCAST_PAGE_ID )
      ) {
            return;
      }

      if ( !is_user_logged_in() ) {
            $query->set_404();
            return;
      }

      $uid = get_current_user_id();
      $main_resource_id = get_user_meta( $uid, CM_USER_META_RESOURCE_ID, true );
      $resource = get_post( $main_resource_id );

      if ( !$resource ||
                !in_array( $resource->post_type, array( 'artist', 'label' ) ) ||
                !check_ajax_referer( 'podcast-from-' . $resource->ID )
      ) {
            $query->set_404();
            return;
      }

      /* d( $query ); */
}

/*
  function nz_form_roots_main_template( $wrap ) {
  Roots_Wrapping::$main_template = locate_template( 'templates/nz_form.php' );
  return $wrap;
  }

 */
/* add_action( 'pre_get_posts', 'cm_pre_get_posts_lang' ); */

function cm_pre_get_posts_lang( $query ) {

      if (
                !$query->is_main_query()
      ) {
            return;
      }
      /* d( $query ); */
      $query->set( 'lang', implode( ' ,', pll_languages_list() ) );
      return;

      if ( !is_user_logged_in() ) {
            $query->set_404();
            return;
      }

      $uid = get_current_user_id();


      /* d( $query ); */
}
