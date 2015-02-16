<?php

add_action( 'admin_bar_menu', 'nz_toolbar_todo', 1050 );

function nz_toolbar_todo( $wp_admin_bar ) {
      /*
        global $wpdb;

        d($wpdb);
        $sql = "
        SELECT * FROM $wpdb->posts
        WHERE $wpdb->posts.post_status = 'pending'
        AND $wpdb->posts.post_type IN ('agenda', 'cool-place')
        ";
        d($sql);
        $posts = $wpdb->get_results($sql);
        d($posts);

       */
      /*      do a better performance query */
      $todo_total = 0;
      $post_types = get_post_types(
                array(
                      'public' => TRUE,
                      /* 'publicly_queryable' => true, */
                      'show_ui' => true
                )
      );

      unset( $post_types[ 'page' ] );
      unset( $post_types[ 'post' ] );
      unset( $post_types[ 'music' ] );
      /* unset( $post_types[ 'label' ] ); */
      /* unset( $post_types[ 'artist' ] ); */
      unset( $post_types[ 'video' ] );
      unset( $post_types[ 'photo' ] );
      unset( $post_types[ 'attachment' ] );


      /* d($post_types); */
      $info_string = '<span style="color:red;">( %d )</span>';

      foreach ( $post_types as $key => $value ) {
            $posts = get_posts(
                      array(
                            'posts_per_page' => -1,
                            'post_type' => $value,
                            'post_status' => array( 'pending', 'draft' ),
                            'suppress_filters' => true
                      )
            );
            /* d($posts); */
            $total_posts = count( $posts );

            if ( $total_posts > 0 ) {

                  $url = ($total_posts == 1) ?
                            get_edit_post_link( $posts[ 0 ]->ID ) :
                            admin_url( 'edit.php?post_status=pending&post_type=' . $key );

                  $args = array(
                        'id' => 'pending-' . $key,
                        'title' => $key . sprintf( $info_string, $total_posts ), // alter the title of existing node
                        'href' => $url,
                        'parent' => 'nz-todo', // set parent to false to make it a top level (parent) node
                  );
                  $todo_total += $total_posts;

                  $wp_admin_bar->add_node( $args );
            }
      }
      $args = array(
            'id' => 'nz-todo',
            'title' => '@Todo ' . sprintf( $info_string, $todo_total ),
            'meta' => array( 'class' => 'nz-toolbar-todo' )
      );

      /* $todo_main = $wp_admin_bar->get_node('nz-todo'); */
      /* $todo_main->title = $todo_main->title . sprintf($info_string, $todo_total); */
      $wp_admin_bar->add_node( $args );
}
