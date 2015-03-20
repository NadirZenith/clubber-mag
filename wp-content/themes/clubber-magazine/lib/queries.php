<?php

function nz_search_query($query) {
        if (!$query->is_search || $query->is_admin) {
                return $query;
        }

        $query->set('post_type', array(
              'agenda',
              /*'page',*/
              'photo',
              'video',
              'music',
              'cool-place',
              'artist',
              'label'
        ));
        return $query;
}

//hook filters to search
add_filter('pre_get_posts', 'nz_search_query');


/*
 * Get Future Featured Events* With Thumbnail Ordered by Date
 */
add_action( 'pre_get_posts', 'cm_get_featured_events' );

function cm_get_featured_events( $query ) {

      if (
                !isset( $query->query[ 'cm_get_featured_events' ] )
      )
            return;

      //Future
      $future = array(
            'key' => 'wpcf-event_begin_date',
            'value' => time(),
            'type' => 'NUMERIC',
            'compare' => '>='
      );
      //Featured
      $featured = array(
            'key' => 'wpcf-event_featured',
            'compare' => 'EXISTS',
      );
      //Events
      $query->set( 'post_type', 'agenda' );

      //With Thumbnail
      $with_tumbnail = array(
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS',
      );

      $query->set( 'posts_per_page', 10 );
      //Ordered by Meta Date
      $query->set( 'order', 'ASC' );
      $query->set( 'orderby', 'meta_value_num' );
      $query->set( 'meta_key', 'wpcf-event_begin_date' );

      $meta_query = array(
            'relation' => 'AND',
            $future, $featured, $with_tumbnail
      );
      $query->set( 'meta_query', $meta_query );
}

/* * * 2
 * Get Future Featured Events* With Thumbnail Ordered by Date Asc
 */
/* add_action( 'pre_get_posts', 'cm_get_featured_events2' ); */

function cm_get_featured_events2( $query ) {

      if (
                !isset( $query->query[ 'cm_get_featured_events2' ] )
      )
            return;

      global $nz_wp_query;

      //Future
      $nz_wp_query->meta_future( 'wpcf-event_begin_date' );

      //Featured
      $nz_wp_query->meta_exist( 'wpcf-event_featured' );
      
      //Events
      $nz_wp_query->post_type( 'agenda' );

      //With Thumbnail
      $nz_wp_query->with_thumbnail(); //shortcut exist
      $with_tumbnail = array(
            'key' => '_thumbnail_id',
            'value' => 'bue',
            'compare' => 'NOT LIKE',
      );

      //Ordered by Meta Date 
      $nz_wp_query->order_by_meta_date_asc( 'wpcf-event_begin_date' );
      $query->set( 'order', 'ASC' );
      $query->set( 'orderby', 'meta_value_num' );
      $query->set( 'meta_key', 'wpcf-event_begin_date' );


      //apply meta
      $meta_query = array(
            'relation' => 'AND',
            $future, $featured, $with_tumbnail
      );
      $query->set( 'meta_query', $meta_query );

      $query->set( 'posts_per_page', 10 );
}

class NzWpLoop {

      public $query;
      public $meta = array();

      public function set_query( $query ) {
            $this->query = $query;
      }

      public function meta_future( $meta ) {
            $this->meta[] = array(
                  'key' => $meta,
                  'value' => time(),
                  'type' => 'NUMERIC',
                  'compare' => '>='
            );
      }

      public function meta_exist( $meta ) {
            $this->meta[] = array(
                  'key' => $meta,
                  'compare' => 'EXISTS',
            );
      }

      public function post_type( $post_type ) {
            $this->query->set( 'post_tye', $post_type );
      }

}

$NzWpLoop = new NzWpLoop();
