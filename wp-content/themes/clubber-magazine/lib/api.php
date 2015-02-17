<?php
add_action( 'wp_ajax_get_posts', 'cm_get_posts' );
add_action( 'wp_ajax_nopriv_get_posts', 'cm_get_posts' );

/**
 * ajax_get_posts
 */
function cm_get_posts() {

      /*
       */
      $post_type = ( string ) $_GET[ 'post_type' ];
      $id = ($_GET[ 'id' ]) ? ( int ) $_GET[ 'id' ] : null;
      $state = ( int ) $_GET[ 'state' ];
      $user = get_current_user_id();
      $q = sanitize_text_field( $_GET[ 'q' ] );


      $regex = '^' . $q; // Prefix with caret to match beginning of string.
      global $wpdb;
      $sql = $wpdb->prepare( "
      SELECT      ID
      FROM        $wpdb->posts
      WHERE       $wpdb->posts.post_title REGEXP %s
      AND $wpdb->posts.post_status = 'publish'
      AND $wpdb->posts.post_type = 'cool-place'
      ORDER BY    $wpdb->posts.post_title", $regex
      );

      $postids = $wpdb->get_col( $sql );

      if ( empty( $postids ) ) {
            $postids = array( 0 );
      }
      $query_args = array(
            'post_type' => $post_type,
            'post__in' => $postids,
      );


      /* print_r( $postids ); die(); */
      $query = new WP_Query( $query_args );

      $output = array();
      while ( $query->have_posts() ) {
            $query->the_post();

            //meta
            $meta = array();

            //mapa
            /* $mapa = get_post_meta( get_the_ID(), 'mapa', true ); */
            $mapa = get_post_meta( get_the_ID(), CM_META_MAPA, true );

            $json_mapa = json_decode( $mapa, TRUE );
            if (
                      $json_mapa &&
                      isset( $json_mapa[ 'components' ] ) &&
                      isset( $json_mapa[ 'components' ][ 'formatted_address' ] )
            ) {
                  $meta[ 'address' ] = $json_mapa[ 'components' ][ 'formatted_address' ];
            }

            $output[] = array(
                  'id' => get_the_ID(),
                  'title' => get_the_title(),
                  'img' => get_the_post_thumbnail( get_the_ID(), '290-160-thumb' ),
                  'meta' => $meta
            );
      }
      /* print_r( $output ); */
      header( 'Content-Type: application/json' );

      $response = array(
            'result' => 1,
            'items' => $output
      );

      echo json_encode( $response );
      exit();
      die();
}

add_action( 'base_after_body', 'cm_ajaxurl' );

function cm_ajaxurl() {
      ?>
      <script type="text/javascript">
            window.ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
      </script>
      <?php
}

/**
 * ajax relate
 */
add_action( 'wp_ajax_cm_relate', 'cm_ajax_relate' );
add_action( 'wp_ajax_nopriv_cm_relate', 'cm_ajax_relate' );

function cm_ajax_relate() {
      if ( !is_user_logged_in() ) {
            header( 'HTTP/1.1 403 Forbidden' );
            echo get_template_part( 'tpl/ajax/connect-to-continue' );
            die();
      }

      $from = ( int ) $_GET[ 'from' ];
      $state = ( int ) $_GET[ 'state' ];
      $relation_type = $_GET[ 'type' ];
      $uid = get_current_user_id();
      check_ajax_referer( $relation_type . $uid );

      if ( $state ) {
            // Delete connection
            $result = p2p_type( $relation_type )->disconnect( $from, $uid );
      } else {
            // Create connection
            $result = p2p_type( $relation_type )->connect( $from, $uid, array(
                  'date' => current_time( 'mysql' )
                      ) );
      }

      $response = array(
            'result' => $result,
            'state' => $state,
            'event' => $from
      );
      header( 'Content-Type: application/json' );
      echo json_encode( $response );
      exit();
      die();
}

/**
 * get ajax relation
 */
add_action( 'wp_ajax_cm_get_relation', 'cm_ajax_get_relation' );
add_action( 'wp_ajax_nopriv_cm_get_relation', 'cm_ajax_get_relation' );

function cm_ajax_get_relation() {

      if ( !is_user_logged_in() ) {
            header( 'HTTP/1.1 403 Forbidden' );
            echo get_template_part( 'tpl/ajax/connect-to-continue' );
            die();
      }

      $from = ( int ) $_GET[ 'from' ];
      $state = ( int ) $_GET[ 'state' ];
      $relation_type = $_GET[ 'type' ];
      $uid = get_current_user_id();
      check_ajax_referer( $relation_type . $uid );

      $users = get_users( array(
            'connected_type' => $relation_type,
            'connected_items' => $from,
                /* 'nopaging' => true, */
                ) );

      $content = "";
      if ( !empty( $users ) ) {
            ob_start();
            include(locate_template( 'tpl/ajax/users_to_event.php' ));
            $content = ob_get_clean();
      } else {
            $content = __( 'No users found.', 'cm' );
      }

      $response = array(
            'result' => 1,
            'content' => $content
      );
      header( 'Content-Type: application/json' );
      echo json_encode( $response );
      exit();
}
