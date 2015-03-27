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
 * youtube iframe from url
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

function nz_pagination_by_date( $interval = 'week' ) {

      $date = get_query_var( 'date' );

      $DateTime = DateTime::createFromFormat( 'd-m-Y', $date );
      if ( $DateTime ) {
            $DateTime->setTime( 0, 0, 0 ); //to avoid date problems
            $start_date = $DateTime->getTimestamp();
      } else {
            $start_date = strtotime( "now" );
      }

      $end_date = strtotime( '+ 1 ' . $interval, $start_date );
      $prev_date = strtotime( '- 1 ' . $interval, $start_date );

      if ( $end_date && $prev_date ) {
            ?>
            <div class="group p15 pager-date">
                  <ul>
                        <li class="fl">
                              <a href="<?php echo add_query_arg( array( 'date' => date( 'd-m-Y', $prev_date ) ) ); ?>" rel="nofollow">
                                    <span class="meddium sc-2">&#8678; </span>
                                    <?php _e( 'previous ' . $interval, 'cm' ) ?>
                              </a>
                        </li>
                        <li class="fr">
                              <a href="<?php echo add_query_arg( array( 'date' => date( 'd-m-Y', $end_date ) ) ); ?>" rel="nofollow">
                                    <?php _e( 'next ' . $interval, 'cm' ) ?>
                                    <span class="meddium sc-2"> &#8680;</span>
                              </a>
                        </li>
                  </ul>
            </div>
            <?php
      }
}

/**
 * inser image to editor with class fancybox
 */
add_filter( 'image_send_to_editor', 'html5_insert_image', 10, 9 );

function html5_insert_image( $html, $id, $caption, $title, $align, $url ) {

      $html5 = "<a href='$url' id='media-$id' class='align-$align fancybox'>";
      $html5 .= "<img src='$url' alt='$title' />";
      $html5 .= "</a>";
      return $html5;
}

function nz_get_post_city_link( $post_id ) {
      $city_term = NzWpLocationTerms::get_post_city_term( $post_id );
      $link = '';

      if ( $city_term ) {
            $archive_link = get_post_type_archive_link( get_post_type() );
            $query_arg = add_query_arg( array( 'city' => $city_term->slug ), $archive_link );
            $link = "<a href='" . $query_arg . "'>{$city_term->name}</a>";
      }
      return $link;
}

/**
 *  resources helpers 
 */
function cm_is_promoter() {
      if ( !is_user_logged_in() )
            return false;
      return true == get_user_meta( get_current_user_id(), 'is_promoter', true );
}

function cm_has_resource_coolplace() {
      return cm_has_resource( 'cool-place' );
}

function cm_has_resource_label() {
      return cm_has_resource( 'label' );
}

function cm_has_resource_artist() {

      return cm_has_resource( 'artist' );
}

function cm_has_resource( $resource_type ) {
      if ( !is_user_logged_in() )
            return false;

      $resource_id = get_user_meta( get_current_user_id(), CM_USER_META_RESOURCE_ID, true );
      if ( $resource_id ) {
            $resource = get_post( $resource_id );
            return $resource_type == $resource->post_type;
      }
      return FALSE;
}
