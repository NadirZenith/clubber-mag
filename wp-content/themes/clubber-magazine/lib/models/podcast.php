<?php
$podcasts = new CPT( array(
      'post_type_name' => 'podcast',
      'singular' => __( 'Podcast', 'cm' ),
      'plural' => __( 'Podcasts', 'cm' ),
      'slug' => 'podcast'
          ), array(
      'supports' => array(
            'title',
            'editor',
            'thumbnail',
            'author',
            'custom-fields'
      ),
      'has_archive' => 'podcasts'
          )
);

$podcasts->register_taxonomy( array(
      'taxonomy_name' => 'podcast_type',
      'singular' => __( 'Podcast type', 'cm' ),
      'plural' => __( 'Podcast types', 'cm' ),
      'slug' => 'podcasts'
          )
);

//add soundcloud field scripts
add_action( 'admin_enqueue_scripts', 'cm_podcast_load_scripts' );

function cm_podcast_load_scripts( $hook ) {
      if ( in_array( $hook, array( 'post-new.php', 'post.php' ) ) ) {
            /* return; */
      }

      // Register the script
      wp_register_script( 'soundcloud-api', 'http://connect.soundcloud.com/sdk.js' );

      wp_register_script( 'nzSCField', get_template_directory_uri() . '/assets/js/plugins/nzSCField.js' );

      // Localize the script with new data
      $translation_array = array(
            'some_string' => __( 'Some string to translate', 'plugin-domain' ),
            'a_value' => '10'
      );
      wp_localize_script( 'nzSCField', 'nzSCField_options', $translation_array );

      // Enqueued script with localized data.
      wp_enqueue_script( 'soundcloud-api' );
      wp_enqueue_script( 'nzSCField' );
}

/**
 * custom fields 
 */
add_action( 'custom_metadata_manager_init_metadata', 'cm_podcast_custom_fields' );

function cm_podcast_custom_fields() {

      $group = 'podcast_metabox';
      $post_type = 'podcast';

      x_add_metadata_group( $group, $post_type, array(
            'label' => 'Podcast field group'
      ) );

      //fields start here 
      x_add_metadata_field( CM_META_SOUNDCLOUD, $post_type, array(
            'group' => $group,
            'label' => 'Soundcloud url',
            'description' => 'Soundcloud Field',
            'display_callback' => 'nz_scfield_podcast',
                /* 'display_column' => true */
      ) );

      x_add_metadata_field( 'soundcloud_special_guest', $post_type, array(
            'group' => $group,
            'field_type' => 'checkbox',
            'label' => 'Special guest',
            'display_column' => true
      ) );
}

function nz_scfield_podcast( $field_slug, $field, $object_type, $object_id, $value ) {
      //soundclour_url
      ?>
      <div data-slug="<?php echo $field_slug ?>" class="custom-metadata-field text">
            <label for="<?php echo $field_slug ?>">Soundcloud url</label>
            <div id="<?php echo $field_slug ?>-1" class="<?php echo $field_slug ?>">
                  <input style="background-color:yellowgreen;" class="nzSCField_newpodcast" type="text" value="<?php echo htmlspecialchars( $value[ 0 ] ) ?>" name="<?php echo $field_slug ?>" id="<?php echo $field_slug ?>">
            </div>
            <span class="description">Soundcloud Field</span>
      </div>
      <script>
            jQuery(document).ready(function() {
                  setTimeout(initialize, 100);

                  function initialize() {

                        SC.initialize({
                              client_id: '<?php echo SOUNDCLOUD_CLIENT_ID ?>'
                        });

                        jQuery(".nzSCField_newpodcast").nzSCField();
                  }

            });

      </script>
      <style>
            input[type="text"].sc-resolver{
                  min-width: 50%;
            }
            .sc-iframe-container{
                  width: 90%;
                  margin-left: 10px;
            }

            .sc-player{}

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
      /*
        $scripts = '<script type="text/javascript"> $(function() {';

        $scripts .= '$(".nzSCField").nzSCField();';

        $scripts .= '}); </script>';
       */
}

/**
 * pre get podcast
 */
add_action( 'pre_get_posts', 'cm_pre_get_podcast_archive' );

function cm_pre_get_podcast_archive( $query ) {

      if (
                !$query->is_post_type_archive( 'podcast' ) ||
                !$query->is_main_query() || $query->is_admin
      )
            return;
      Roots_Wrapping::$raw = TRUE;
      $query->set( 'orderby', "meta_value_num" );
      /* $query->set( 'order', "ASC" ); */
      $query->set( 'meta_key', "soundcloud_special_guest" );


      $meta_query = array(
            array(
                  'key' => 'soundcloud_special_guest',
                  'value' => 'on',
                  'compare' => '='
            )
      );

      $query->set( 'meta_query', $meta_query );
}
