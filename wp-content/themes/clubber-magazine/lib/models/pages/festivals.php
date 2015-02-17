<?php

/**
 *      filter for pre get page_festivals
 */
 add_action( 'pre_get_posts', 'nz_pre_get_page_festivals' ); 

function nz_pre_get_page_festivals( $query ) {
      if ( !$query->is_main_query() || !is_page_template( 'page-template-festivals.php' ) )
            return;

      Roots_Wrapping::$raw = TRUE;
      return;
}
