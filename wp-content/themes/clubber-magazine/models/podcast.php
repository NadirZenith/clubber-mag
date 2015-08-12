<?php

/*
 * Into the beat
 */
add_action('init', 'cm_register_intothebeat_post_type');

function cm_register_intothebeat_post_type()
{
    $labels = array(
        'name' => _x('Into the Beat', 'post type general name', 'cm'),
        'singular_name' => _x('Into the Beat', 'post type singular name', 'cm'),
        'menu_name' => _x('Into the Beat', 'admin menu', 'cm'),
        'name_admin_bar' => _x('Into the Beat', 'add new on admin bar', 'cm'),
        'add_new' => _x('Add New', 'into the beat', 'cm'),
        'add_new_item' => __('Add New Into the Beat', 'cm'),
        'new_item' => __('New Into the Beat', 'cm'),
        'edit_item' => __('Edit Into the Beat', 'cm'),
        'view_item' => __('View Into the Beat', 'cm'),
        'all_items' => __('All Into the Beat', 'cm'),
        'search_items' => __('Search Into the Beat', 'cm'),
        'parent_item_colon' => __('Parent Into the Beat:', 'cm'),
        'not_found' => __('No into the beat found.', 'cm'),
        'not_found_in_trash' => __('No into the beat found in Trash.', 'cm')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'into-the-beat'),
        'capability_type' => 'post',
        'has_archive' => 'into-the-beat',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'author', 'editor', 'thumbnail', 'custom-fields')
    );

    register_post_type('into-the-beat', $args);
}

/*
 * Open frequency
 */
add_action('init', 'cm_register_openfrequency_post_type');

function cm_register_openfrequency_post_type()
{
    $labels = array(
        'name' => _x('Open Frequency', 'post type general name', 'cm'),
        'singular_name' => _x('Open Frequency', 'post type singular name', 'cm'),
        'menu_name' => _x('Open Frequency', 'admin menu', 'cm'),
        'name_admin_bar' => _x('Open Frequency', 'add new on admin bar', 'cm'),
        'add_new' => _x('Add New', 'open frequency', 'cm'),
        'add_new_item' => __('Add New Open Frequency', 'cm'),
        'new_item' => __('New Open Frequency', 'cm'),
        'edit_item' => __('Edit Open Frequency', 'cm'),
        'view_item' => __('View Open Frequency', 'cm'),
        'all_items' => __('All Open Frequency', 'cm'),
        'search_items' => __('Search Open Frequency', 'cm'),
        'parent_item_colon' => __('Parent Open Frequency:', 'cm'),
        'not_found' => __('No open frequency found.', 'cm'),
        'not_found_in_trash' => __('No open frequency found in Trash.', 'cm')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'open-frequency'),
        'capability_type' => 'post',
        'has_archive' => 'open-frequency',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'author', 'editor', 'thumbnail', 'custom-fields')
    );

    register_post_type('open-frequency', $args);
}

/*
 * Conections
 */
add_action('p2p_init', 'cm_podcasts_connections');

function cm_podcasts_connections()
{
    p2p_register_connection_type(array(
        'name' => 'into-the-beat-to-artist',
        'from' => 'into-the-beat',
        'to' => 'artist',
        'admin_column' => 'from'
    ));

    p2p_register_connection_type(array(
        'name' => 'open-frequency-to-artist',
        'from' => 'open-frequency',
        'to' => 'artist',
        'admin_column' => 'from'
    ));
}
//add soundcloud field scripts
add_action('admin_enqueue_scripts', 'cm_podcast_load_scripts');

function cm_podcast_load_scripts($hook)
{
    if (in_array($hook, array('post-new.php', 'post.php'))) {
        /* return; */
    }

    // Register the script
    wp_register_script('soundcloud-api', 'http://connect.soundcloud.com/sdk.js');
    wp_register_script('nzSCField', get_template_directory_uri() . '/assets/js/plugins/nzSCField.js');

    // Enqueued script with localized data.
    wp_enqueue_script('soundcloud-api');
    wp_enqueue_script('nzSCField');
}
/**
 * custom fields 
 */
add_action('custom_metadata_manager_init_metadata', 'cm_podcast_custom_fields');

function cm_podcast_custom_fields()
{

    $group = 'podcast_metabox';
    $post_type = array('open-frequency', 'into-the-beat');

    x_add_metadata_group($group, $post_type, array(
        'label' => 'Podcast field group'
    ));

    //fields start here 
    x_add_metadata_field(CM_META_SOUNDCLOUD, $post_type, array(
        'group' => $group,
        'label' => 'Soundcloud url',
        'description' => 'Soundcloud Field',
        'display_callback' => 'nz_scfield_podcast',
        /* 'display_column' => true */
    ));
}

function nz_scfield_podcast($field_slug, $field, $object_type, $object_id, $value)
{
    //soundclour_url
    ?>
    <div data-slug="<?php echo $field_slug ?>" class="custom-metadata-field text">
        <label for="<?php echo $field_slug ?>">Soundcloud url</label>
        <div id="<?php echo $field_slug ?>-1" class="<?php echo $field_slug ?>">
            <input style="background-color:yellowgreen;" class="nzSCField_newpodcast" type="text" value="<?php echo htmlspecialchars($value[0]) ?>" name="<?php echo $field_slug ?>" id="<?php echo $field_slug ?>">
        </div>
        <span class="description">Soundcloud Field</span>
    </div>
    <script>
        jQuery(document).ready(function () {
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
