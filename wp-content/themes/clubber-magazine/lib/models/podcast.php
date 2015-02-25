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
$into_the_beat = new CPT( array(
      'post_type_name' => 'into-the-beat',
      'singular' => __( 'Into the beat', 'cm' ),
      'plural' => __( 'Into the beat', 'cm' ),
      'slug' => 'into-the-beat'
          ), array(
      'supports' => array(
            'title',
            'editor',
            'thumbnail',
            'author',
            'custom-fields'
      ),
      'has_archive' => true
          )
);

$open_frequency = new CPT( array(
      'post_type_name' => 'open-frequency',
      'singular' => __( 'Open Frequency', 'cm' ),
      'plural' => __( 'Open Frequency', 'cm' ),
      'slug' => 'open-frequency'
          ), array(
      'supports' => array(
            'title',
            'author',
            'custom-fields'
      ),
      'has_archive' => true
          )
);
add_action( 'p2p_init', 'cm_podcasts_connections' );

function cm_podcasts_connections() {
      p2p_register_connection_type( array(
            'name' => 'into-the-beat-to-artist',
            'from' => 'into-the-beat',
            'to' => 'artist',
            'admin_column' => 'from'
      ) );

      p2p_register_connection_type( array(
            'name' => 'open-frequency-to-artist',
            'from' => 'open-frequency',
            'to' => 'artist',
            'admin_column' => 'from'
      ) );
}

//add soundcloud field scripts
add_action( 'admin_enqueue_scripts', 'cm_podcast_load_scripts' );

function cm_podcast_load_scripts( $hook ) {
      if ( in_array( $hook, array( 'post-new.php', 'post.php' ) ) ) {
            /* return; */
      }

      // Register the script
      wp_register_script( 'soundcloud-api', 'http://connect.soundcloud.com/sdk.js' );
      wp_register_script( 'nzSCField', get_template_directory_uri() . '/assets/js/plugins/nzSCField.js' );

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
      $post_type = array( 'open-frequency', 'into-the-beat' );

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

