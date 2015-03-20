<?php

class NzTaxTools {

      public function __construct() {

            if ( is_admin() && current_user_can( 'manage_options' ) ) {
                  /* d('ad'); */
                  add_action( 'admin_menu', array( $this, 'add_menu' ) );
                  add_action( 'wp_ajax_nz_install_contry_terms', array( $this, 'ajax_install_terms' ) );
                  add_action( 'wp_ajax_nz_change_tax_name', array( $this, 'ajax_change_tax_name' ) );
                  add_action( 'wp_ajax_nz_set_terms_parent', array( $this, 'ajax_set_terms_parent' ) );
                  add_action( 'wp_ajax_nz_add_object_term', array( $this, 'ajax_add_object_term' ) );
            }
            ;
      }

      public function ajax_add_object_term() {
            $taxonomy = $_GET[ 'taxonomy' ];
            $post_types = explode( ',', $_GET[ 'post_types' ] );
            $original_terms = explode( ',', $_GET[ 'original_terms' ] );
            $new_term = get_term_by( 'slug', $_GET[ 'new_term' ], $taxonomy );
            if ( !$new_term )
                  wp_die( 'new term does not exist' );

            $args = array(
                  'post_type' => $post_types,
                  'posts_per_page' => -1,
                  'tax_query' => array(
                        array(
                              'taxonomy' => $taxonomy,
                              'field' => 'slug',
                              'terms' => $original_terms
                        )
                  )
            );
            $the_query = new WP_Query( $args );

            if ( $the_query->have_posts() ) {
                  ini_set( 'memory_limit', '512M' );
                  ini_set( 'max_execution_time', 300 );
                  $response = array();
                  while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        $current_terms = wp_get_object_terms( get_the_ID(), $taxonomy );
                        $new_terms = array( $new_term->term_id );
                        foreach ( $current_terms as $ct ) {
                              $new_terms[] = $ct->term_id;
                        }

                        $r = wp_set_object_terms( get_the_id(), $new_terms, 'location' );
                        if ( is_wp_error( $r ) )
                              $response[ 'errors' ][] = $r;
                        else
                              $response[ 'terms' ][] = $r;
                  }
            } else {
                  wp_die( 'no posts found' );
            }


            wp_die( json_encode( $response ) );
      }

      public function ajax_set_terms_parent() {
            $taxonomy = $_GET[ 'taxonomy' ];
            $child_terms_slug = $_GET[ 'childs' ];
            $child_terms_slug = explode( ',', $child_terms_slug );
            $parent_term_slug = $_GET[ 'parent' ];

            $parent_term = get_term_by( 'slug', $parent_term_slug, $taxonomy );

            if ( !$parent_term )
                  wp_die( 'parent term does not exits' );

            $response = array();
            foreach ( $child_terms_slug as $term_slug ) {
                  $child_term = get_term_by( 'slug', $term_slug, $taxonomy );
                  if ( !$child_term )
                        continue;

                  $new_term = wp_update_term( $child_term->term_id, $taxonomy, array( 'parent' => $parent_term->term_id ) );

                  if ( is_wp_error( $new_term ) )
                        $response[ 'error' ][] = $new_term;
                  else
                        $response[ 'updated' ][] = $new_term;
            }

            echo json_encode( $response );
            wp_die();
      }

      public function ajax_change_tax_name() {
            if ( isset( $_GET[ 'current_name' ] ) && isset( $_GET[ 'new_name' ] ) ) {
                  $current_name = $_GET[ 'current_name' ];
                  $new_name = $_GET[ 'new_name' ];
                  $query = 'UPDATE  `wp_term_taxonomy` SET  `taxonomy` =  "' . $new_name . '" WHERE  `taxonomy` = "' . $current_name . '";';
                  global $wpdb;
                  $x = $wpdb->query( $query );

                  wp_die( 'rows affected ' . $x );
            }
            wp_die( 'missing arguments' );
      }

      public function ajax_install_terms() {

            /* nz_delete_all_tax( $taxonomy ); */
            $taxonomy = $_GET[ 'tax_name' ];
            if ( empty( $taxonomy ) ) {
                  echo json_encode( 'not a valid tax name(empty)' );
                  wp_die();
            }

            $contry_list = $this->nz_get_file_contry_list();

            $added = $this->nz_add_terms( $contry_list, $taxonomy );

            echo json_encode( $added );
            wp_die();
      }

      public function add_menu() {
            add_options_page( 'Nz Tax Tools', 'Nz Tax Tools', 'manage_options', 'nz-tax-tools', array( $this, 'options_page' ) );
      }

      public function options_page() {
            ?>
            <div class="wrap">
                  <p>current taxonomies</p>
                  <?php
                  var_dump( get_taxonomies() );
                  ?>
                  <div id="change-tax-name-wrap">
                        <p>Change taxonomy name</p>
                        <label for="tax-current-name">
                              current
                              <input type="text" name="tax-current-name" class="tax-current-name"/>
                        </label>
                        <label for="tax-new-name">
                              new
                              <input type="text"  name="tax-new-name" class="tax-new-name"/>
                        </label>
                        <a class="button action">change tax name</a>
                  </div>
                  <hr>

                  <label for="install-tax-name">
                        Install terms in tax
                        <input type="text" id="install-tax-name" name="install-tax-name"/>
                  </label>
                  <a id="install-terms" class="button action">install terms</a>
                  <hr>

                  <div id="set-terms-parent-wrap">
                        <p>Bulk set parent term</p>
                        <label for="current-tax">
                              Taxonomy
                              <input type="text" class="taxonomy" name="taxonomy"/>
                        </label><br>
                        <label for="child-term-name">
                              child term slug(city name: ex. barcelona, madrid)
                              <input type="text" class="child-terms-slug" name="child-terms-slug"/>
                        </label>
                        <label for="parent-term-slug">
                              parent term slug(contry code: ex. es|fr|en)
                              <input type="text" class="parent-term-slug" name="parent-term-slug"/>
                        </label>
                        <a class="button action">set terms parent</a>
                  </div>
                  <hr>
                  <div id="add-object-term-wrap">
                        <p>Bulk add object term</p>
                        <label for="current-tax">
                              Taxonomy
                              <input type="text" class="taxonomy" name="taxonomy"/>
                        </label>
                        <label for="post-types">
                              post types(ex: agenda, cool-place)
                              <input type="text" class="post-types" name="post-types"/>
                        </label><br>
                        <label for="original-terms">
                              original-terms(ex: madrid, barcelona)
                              <input type="text" class="original-terms" name="original-terms"/>
                        </label>
                        <label for="new-term">
                              new term(ex: es, fr)
                              <input type="text" class="new-term" name="new-term"/>
                        </label>
                        <a class="button action">add object terms</a>
                  </div>
            </div>
            <script>
                  jQuery(document).ready(function($) {
                        $('#change-tax-name-wrap .button').on('click', function() {
                              var $btn = $(this);
                              var current_name = $btn.parent().find(".tax-current-name").val();
                              var new_name = $btn.parent().find(".tax-new-name").val();
                              console.log(current_name, new_name);
                              $.get(ajaxurl + "?action=nz_change_tax_name&current_name=" + current_name + "&new_name=" + new_name, function(data) {
                                    $btn.after(data);
                              });
                        });
                        $('#install-terms').on('click', function() {
                              var $btn = $(this);
                              var tax_name = $('#install-tax-name').val();
                              $.get(ajaxurl + "?action=nz_install_contry_terms&tax_name=" + tax_name, function(data) {
                                    $btn.after(data);
                              });

                        });
                        $('#set-terms-parent-wrap .button').on('click', function() {
                              var $btn = $(this);
                              var taxonomy = $btn.parent().find('.taxonomy').val();
                              var child_terms_slug = $btn.parent().find('.child-terms-slug').val();
                              var parent_term_slug = $btn.parent().find('.parent-term-slug').val();
                              $.get(ajaxurl + "?action=nz_set_terms_parent&childs=" + child_terms_slug + "&parent=" + parent_term_slug + "&taxonomy=" + taxonomy, function(data) {
                                    $btn.after(data);
                              });
                        });
                        $('#add-object-term-wrap .button').on('click', function() {
                              var $btn = $(this);
                              var taxonomy = $btn.parent().find('.taxonomy').val();
                              var post_types = $btn.parent().find('.post-types').val();
                              var original_terms = $btn.parent().find('.original-terms').val();
                              var new_term = $btn.parent().find('.new-term').val();

                              $.get(ajaxurl + "?action=nz_add_object_term&taxonomy=" + taxonomy + "&post_types=" + post_types + "&original_terms=" + original_terms + "&new_term=" + new_term, function(data) {
                                    $btn.after(data);
                              });
                        });
                  });
            </script>
            <?php
      }

      //delete tax terms
      public function nz_delete_all_tax( $taxonomy ) {
            ini_set( 'memory_limit', '512M' );
            ini_set( 'max_execution_time', 300 );
            $terms = get_terms( $taxonomy, array( 'fields' => 'ids', 'hide_empty' => false ) );
            foreach ( $terms as $value ) {
                  /* d($value); */
                  wp_delete_term( $value, $taxonomy );
            }
      }

      private function nz_add_terms( $terms = array(), $taxonomy = 'post_tag' ) {
            ini_set( 'memory_limit', '512M' );
            ini_set( 'max_execution_time', 300 );

            $errors = array();
            $added = array();
            foreach ( $terms as $term ) {
                  $new_term = wp_insert_term( $term[ 'name' ], $taxonomy, $term[ 'options' ] );
                  if ( is_wp_error( $new_term ) )
                        $errors[] = $new_term;
                  else {
                        $added[] = $new_term;
                  }
            }
            return array(
                  'terms' => $added,
                  'errors' => $errors
            );
      }

      private function nz_get_file_contry_list() {

            $list_src = __DIR__ . '/resources/contry-list.txt';
            $contry_list = array();
            $i = 0;
            $handle = fopen( $list_src, "r" );
            if ( $handle ) {
                  while ( ($line = fgets( $handle )) !== false ) {
                        if ( strpos( $line, '#' ) !== false ) {
                              continue;
                        }
                        list($slug, $name ) = explode( ':', $line );

                        $contry_list[ $i ][ 'name' ] = ucfirst( trim( $name ) );
                        $contry_list[ $i ][ 'options' ] = array(
                              'slug' => strtolower( $slug )
                        );

                        $i++;
                  }

                  fclose( $handle );
            } else {
                  $contry_list = array();
            }

            return $contry_list;
      }

}

new NzTaxTools();


