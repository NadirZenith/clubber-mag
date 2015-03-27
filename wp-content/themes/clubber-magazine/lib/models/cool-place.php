<?php
add_action('init', 'cm_register_coolplace_post_type');

function cm_register_coolplace_post_type() {
    $labels = array(
        'name' => _x('Cool Places', 'post type general name', 'cm'),
        'singular_name' => _x('Cool Place', 'post type singular name', 'cm'),
        'menu_name' => _x('Cool Places', 'admin menu', 'cm'),
        'name_admin_bar' => _x('Cool Place', 'add new on admin bar', 'cm'),
        'add_new' => _x('Add New', 'cool place', 'cm'),
        'add_new_item' => __('Add New Cool Place', 'cm'),
        'new_item' => __('New Cool Place', 'cm'),
        'edit_item' => __('Edit Cool Place', 'cm'),
        'view_item' => __('View Cool Place', 'cm'),
        'all_items' => __('All Cool Places', 'cm'),
        'search_items' => __('Search Cool Places', 'cm'),
        'parent_item_colon' => __('Parent Cool Places:', 'cm'),
        'not_found' => __('No cool places found.', 'cm'),
        'not_found_in_trash' => __('No cool places found in Trash.', 'cm')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'cool-place'),
        'capability_type' => 'post',
        'has_archive' => 'cool-places',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','author', 'editor', 'thumbnail', 'custom-fields')
    );

    register_post_type('cool-place', $args);

    $labels = array(
        'name' => _x('Places types', 'taxonomy general name', 'cm'),
        'singular_name' => _x('Places type', 'taxonomy singular name', 'cm'),
        'search_items' => __('Search Places types', 'cm'),
        'popular_items' => __('Popular Places types', 'cm'),
        'all_items' => __('All Places types', 'cm'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __('Edit Places type', 'cm'),
        'update_item' => __('Update Places type', 'cm'),
        'add_new_item' => __('Add New Places type', 'cm'),
        'new_item_name' => __('New Places type Name', 'cm'),
        'separate_items_with_commas' => __('Separate places types with commas', 'cm'),
        'add_or_remove_items' => __('Add or remove places types', 'cm'),
        'choose_from_most_used' => __('Choose from the most used places types', 'cm'),
        'not_found' => __('No places types found.', 'cm'),
        'menu_name' => __('Places types', 'cm'),
    );

    $args = array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        /*'update_count_callback' => '_update_post_term_count',*/
        'query_var' => true,
        'rewrite' => array('slug' => 'cool-places'),
    );

    register_taxonomy('cool_place_type', 'cool-place', $args);
}

//add map field scripts
add_action('admin_enqueue_scripts', 'cm_coolplace_load_scripts');

function cm_coolplace_load_scripts($hook) {
    if (in_array($hook, array('post-new.php', 'post.php'))) {
        /* return; */
    }

    wp_register_script('google-maps', 'https://maps.googleapis.com/maps/api/js?v=3&libraries=places');
    wp_register_script('nzGMField', get_template_directory_uri() . '/assets/js/plugins/nzGMField.js');

    wp_enqueue_script('google-maps');
    wp_enqueue_script('nzGMField');
}

//add custom fields
add_action('custom_metadata_manager_init_metadata', 'cm_coolplace_custom_fields');

function cm_coolplace_custom_fields() {
    /**      */
    $post_types = array('cool-place');

    $metagroup = 'cm_place_metabox';

    x_add_metadata_group($metagroup, $post_types, array(
        'label' => 'Map Place'
    ));

    $prefix = '';


    x_add_metadata_field(CM_META_MAPA, $post_types, array(
        'group' => $metagroup,
        'field_type' => 'text',
        'label' => 'address',
        'description' => 'mapa',
        'display_callback' => 'nz_gmfield_coolplace'
    ));

    x_add_metadata_field('featured', $post_types, array(
        'group' => $metagroup,
        'label' => 'Destacado',
        'field_type' => 'checkbox',
    ));
}

function nz_gmfield_coolplace($field_slug, $field, $object_type, $object_id, $value) {
    ?>
    <div data-slug="<?php echo $field_slug ?>" class="custom-metadata-field text">
        <label for="<?php echo $field_slug ?>">Map info</label>
        <div id="<?php echo $field_slug ?>-1" class="<?php echo $field_slug ?>">
            <input style="background-color:yellowgreen;" class="nzGMField_coolplace" type="text" value="<?php echo htmlspecialchars($value[0]) ?>" name="<?php echo $field_slug ?>" id="<?php echo $field_slug ?>">
        </div>
        <span class="description">map info</span>
    </div>
    <script>
        jQuery(document).ready(function () {

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
add_action('save_post', 'cm_coolplace_set_category');

function cm_coolplace_set_category($post_ID) {
    if (wp_is_post_autosave($post_ID) || wp_is_post_revision($post_ID))
        return $post_ID;

    $post = get_post($post_ID);
    if ($post->post_type != 'cool-place')
        return $post_ID;

    $field_value = isset($_POST[CM_META_MAPA]) ? $_POST[CM_META_MAPA] : '';
    $map_info = json_decode(stripslashes($field_value), true);

    /* d($field_value); */
    /* d($map_info); */

    if (empty($map_info))
        return $post_ID;

    set_map_terms($map_info, $post_ID);
}

function set_map_terms($map_info, $post_id) {
    $taxonomy = 'location';
    $current_terms = wp_get_object_terms($post_id, $taxonomy);
    if (!empty($current_terms))
        return;

    $city = (isset($map_info['components']['city'])) ? $map_info['components']['city'] : null;
    $county = (isset($map_info['components']['county'])) ? $map_info['components']['county'] : null;
    $country = (isset($map_info['components']['country'])) ? $map_info['components']['country'] : null;

    //user input city
    if ($city) {
        $city_term = term_exists(strtolower($city), $taxonomy);
        if (!$city_term) {
            $city_term = wp_insert_term(
                $city, $taxonomy, array('slug' => strtolower($city))
            );
        }

        if (!empty($city_term)) {
            $term_id = (int) $city_term['term_id'];
            $r = wp_set_object_terms($post_id, $term_id, $taxonomy);
        }
    }
}

add_action('pre_get_posts', 'cm_pre_get_archive_coolplace');

function cm_pre_get_archive_coolplace($query) {
    

    if (
        !$query->is_main_query() || $query->is_admin || !$query->is_post_type_archive('cool-place')
    )
        return;
    
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
    
    
    

}