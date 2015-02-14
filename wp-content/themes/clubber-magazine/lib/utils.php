<?php

/**
 * Utility functions
 */
function is_element_empty( $element ) {
      $element = trim( $element );
      return !empty( $element );
}

// Tell WordPress to use searchform.php from the templates/ directory
function roots_get_search_form( $form ) {
      $form = '';
      locate_template( '/templates/searchform.php', true, false );
      return $form;
}

add_filter( 'get_search_form', 'roots_get_search_form' );

function is_portrait( $image_url ) {
//$tn_id = get_post_thumbnail_id( get_the_ID() );
//$img = wp_get_attachment_image_src( $tn_id, 'full' );

      $isize = (getimagesize( $image_url ));
      /* d($isize); */
//array 0 is height, 1 is width
      if ( $isize[ 0 ] >= $isize[ 1 ] ) {
            return true;
      } else {
            return false;
      }
}

/**
 * 
 */
function nz_copy_post_terms( $from_id, $to_id, $tax = 'tags' ) {
      $terms = get_the_terms( $from_id, $tax );
      $t_ids = array();
      foreach ( $terms as $term ) {
            $t_ids[] = $term->term_id;
      }
      wp_set_object_terms( $to_id, $t_ids, $tax );
}

/**
 * Home listings title
 */
function cm_home_list_title( $post_type, $title, $raw = false ) {
      ?>
      <header class="h2">
            <a class="cm-title" href="<?php echo ($raw) ? $post_type : get_post_type_archive_link( $post_type ); ?>">
                  <?php echo $title; ?>
            </a>
      </header>
      <?php
}

/**
 * Home listings title
 */
function cm_home_list_more( $post_type, $title, $raw = false ) {
      ?>
      <a class="fr mr5 sc-2 bold" href="<?php echo ($raw) ? $post_type : get_post_type_archive_link( $post_type ); ?>">
            <?php echo $title; ?>
      </a>

      <?php
}

/**
 * Video iframe from meta
 */
function nz_get_youtube_iframe( $url, $args = array() ) {

      $query_string = array();
      parse_str( parse_url( $url, PHP_URL_QUERY ), $query_string );
      if ( !isset( $query_string[ "v" ] ) )
            return false;

      $id = $query_string[ "v" ];

      $defaults = array(
            'width' => '100%', //640
            'height' => '166', //390
            'color' => '0583F2',
            'frameborder' => '0',
      );

      $args = wp_parse_args( $args, $defaults );


      $content = '<div class="nz-sciframe">'
                . '<iframe '
                . 'width="' . $args[ 'width' ] . '" '
                . 'height="' . $args[ 'height' ] . '" '
                . 'frameborder="' . $args[ 'frameborder' ] . '" '
                . 'src="http://www.youtube.com/embed/' . $id . '"'
                . '></iframe></div>';


      return $content;
}

function cm_lang_get_post( $id ) {

      return get_post( $id );
      /* return pll_get_post( $id ); */
}