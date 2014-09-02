<?php

/**
 *    PRE GET POSTS AUTHOR ARCHIVE
 * @todo nz possibility do deactivate user author page individualy
 */
function nz_pre_get_archive_author( $query ) {

      if (
                !$query->is_main_query() ||
                !$query->is_archive() ||
                !$query->is_author()
      ) {
            return;
      }

      $action = get_query_var( 'action' ); // '' , 'editar', 'agenda', 'eventos'

      switch ( $action ) {
            case 'editar':
                  global $nz_form;
                  $nz_form = 'useredit_form';
                  add_filter( 'roots/wrap_base', 'nz_form_roots_main_template' );

                  break;

            case 'agenda':
                  add_filter( 'roots/wrap_base', 'nz_roots_main_template_user_agenda' );

                  break;

            case 'eventos':
                  add_filter( 'roots/wrap_base', 'nz_roots_main_template_user_promoter' );

                  break;
      }
}

add_action( 'pre_get_posts', 'nz_pre_get_archive_author' );

function nz_roots_main_template_user_agenda( $wrap ) {
      Roots_Wrapping::$main_template = locate_template( 'templates/user/user-agenda-list.php' );
      return $wrap;
}

function nz_roots_main_template_user_promoter( $wrap ) {
      Roots_Wrapping::$main_template = locate_template( 'templates/user/user-promoter-list.php' );
      return $wrap;
}
