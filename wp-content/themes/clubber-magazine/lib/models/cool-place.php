<?php
$cool_places = new CPT( array(
      'post_type_name' => 'cool-place',
      'singular' => __( 'Cool Place', 'cm' ),
      'plural' => __( 'Cool Places', 'cm' ),
      'slug' => 'cool-place'
          ), array(
      'supports' => array( 'title', 'editor', 'thumbnail', 'author', 'custom-fields' ),
      'has_archive' => 'cool-places'
          )
);

$cool_places->register_taxonomy( array(
      'taxonomy_name' => 'cool_place_type',
      'singular' => __( 'Place type', 'cm' ),
      'plural' => __( 'Places types', 'cm' ),
      'slug' => 'cool-places'
          )
);

$cool_places->register_taxonomy( array(
      'taxonomy_name' => 'city',
      'singular' => __( 'City', 'cm' ),
      'plural' => __( 'Cities', 'cm' ),
      'slug' => 'ciudad' )
);

//add map field scripts
add_action( 'admin_enqueue_scripts', 'cm_coolplace_load_scripts' );

function cm_coolplace_load_scripts( $hook ) {
      if ( in_array( $hook, array( 'post-new.php', 'post.php' ) ) ) {
            /* return; */
      }

      wp_register_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?v=3&libraries=places' );
      wp_register_script( 'nzGMField', get_template_directory_uri() . '/assets/js/plugins/nzGMField.js' );

      wp_enqueue_script( 'google-maps' );
      wp_enqueue_script( 'nzGMField' );
}

//add custom fields
add_action( 'custom_metadata_manager_init_metadata', 'cm_coolplace_custom_fields' );

function cm_coolplace_custom_fields() {
      /**      */
      $post_types = array( 'cool-place' );

      $metagroup = 'cm_place_metabox';

      x_add_metadata_group( $metagroup, $post_types, array(
            'label' => 'Map Place'
      ) );

      $prefix = '';


      x_add_metadata_field( CM_META_MAPA, $post_types, array(
            'group' => $metagroup,
            'field_type' => 'text',
            'label' => 'address',
            'description' => 'mapa',
            'display_callback' => 'nz_gmfield_coolplace'
      ) );
}

function nz_gmfield_coolplace( $field_slug, $field, $object_type, $object_id, $value ) {
      ?>
      <div data-slug="<?php echo $field_slug ?>" class="custom-metadata-field text">
            <label for="<?php echo $field_slug ?>">Map info</label>
            <div id="<?php echo $field_slug ?>-1" class="<?php echo $field_slug ?>">
                  <input style="background-color:yellowgreen;" class="nzGMField_coolplace" type="text" value="<?php echo htmlspecialchars( $value[ 0 ] ) ?>" name="<?php echo $field_slug ?>" id="<?php echo $field_slug ?>">
            </div>
            <span class="description">map info</span>
      </div>
      <script>
            jQuery(document).ready(function() {

                  jQuery(".nzGMField_coolplace").nzGMField();

            });

      </script>
      <style>

            .gm-container{
                  width: 90%;
                  margin-left: 10px;
            }
            .gm-container img{
                  width: 100%;
            }

            .raw-options label{
                  display: block;
                  clear: both;
            }
            .raw-options label span,
            .raw-options label input{
                  display: block;
                  float: left;
            }
            .raw-options label span{
                  width: 80px;     
            }

            .loading{
                  height: 5px;
                  visibility: hidden;
            }
            .loading.x{
                  visibility: visible;
                  background-color: blue;
            }
      </style>
      <?php
}

//set post taxonomy city
add_action( 'save_post', 'cm_coolplace_set_category' );

function cm_coolplace_set_category( $post_ID ) {
      if ( wp_is_post_autosave( $post_ID ) || wp_is_post_revision( $post_ID ) )
            return $post_ID;

      $post = get_post( $post_ID );
      if ( $post->post_type != 'cool-place' )
            return $post_ID;

      $field_value = isset( $_POST[ CM_META_MAPA ] ) ? $_POST[ CM_META_MAPA ] : '';
      $map_info = json_decode( stripslashes( $field_value ), true );

      /* d($field_value); */
      /* d($map_info); */

      if ( empty( $map_info ) )
            return $post_ID;

      set_map_terms( $map_info, $post_ID );
}

function set_map_terms( $map_info, $post_id ) {

      $city = (isset( $map_info[ 'components' ][ 'city' ] )) ? $map_info[ 'components' ][ 'city' ] : null;
      $county = (isset( $map_info[ 'components' ][ 'county' ] )) ? $map_info[ 'components' ][ 'county' ] : null;
      $country = (isset( $map_info[ 'components' ][ 'country' ] )) ? $map_info[ 'components' ][ 'country' ] : null;

      //user input city
      if ( $city ) {
            $taxonomy = 'city';
            $city_term = term_exists( strtolower( $city ), $taxonomy );
            if ( !$city_term ) {
                  $city_term = wp_insert_term(
                            $city, $taxonomy, array( 'slug' => strtolower( $city ) )
                  );
            }

            if ( !empty( $city_term ) ) {
                  $term_id = ( int ) $city_term[ 'term_id' ];
                  $r = wp_set_object_terms( $post_id, $term_id, $taxonomy );
            }
      }
}
