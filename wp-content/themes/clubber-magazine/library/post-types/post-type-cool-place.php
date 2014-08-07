<?php
/**
 *      REGISTER CUSTOM POST TYPE
 *      TYPE: cool-place
 * 
 *  */
// Hook into the 'init' action
add_action('init', 'register_post_type_cool_place', 0);

// Register User Post Type
function register_post_type_cool_place() {

        $labels = array(
              'name' => 'Cool Places',
              'singular_name' => 'Cool Place',
              'menu_name' => 'Cool Places',
              'parent_item_colon' => 'Parent Item:',
              'all_items' => 'All Cool Places',
              'view_item' => 'View Cool Place',
              'add_new_item' => 'Add Cool Place',
              'add_new' => 'Add Cool Place',
              'edit_item' => 'Edit Cool Place',
              'update_item' => 'Update Cool Place',
              'search_items' => 'Search Cool Places',
              'not_found' => 'Cool Place Not found',
              'not_found_in_trash' => 'Cool Place Not found in Trash',
        );
        $args = array(
              'label' => 'CoOl PlAce',
              'description' => 'Cool Place post type',
              'labels' => $labels,
              'supports' => array('title', 'editor', 'author', 'thumbnail', 'custom-fields',),
              'hierarchical' => false,
              'public' => true,
              'show_ui' => true,
              'show_in_menu' => true,
              'show_in_nav_menus' => TRUE,
              'show_in_admin_bar' => true,
              'menu_position' => 5,
              'can_export' => false,
              'has_archive' => true,
              'exclude_from_search' => false,
              'publicly_queryable' => true, // permalink works if true
              'taxonomies' => array('cool_place_type')
                /* 'capability_type' => 'page', */
                /* 'rewrite' => array('slug' => 'sello', 'with_front' => false), */
        );
        register_post_type('cool-place', $args);
}

// Register Custom Taxonomy
function cool_place_type_taxonomy() {

        $labels = array(
              'name' => _x('Cool Places Types', 'Taxonomy General Name', 'text_domain'),
              'singular_name' => _x('Cool Place Type', 'Taxonomy Singular Name', 'text_domain'),
              'menu_name' => __('Types of Cool Places', 'text_domain'),
              'all_items' => __('All Cool Places Types', 'text_domain'),
              'parent_item' => __('Parent Item', 'text_domain'),
              'parent_item_colon' => __('Parent Item:', 'text_domain'),
              'new_item_name' => __('New Cool Places Type', 'text_domain'),
              'add_new_item' => __('Add Cool Places Type', 'text_domain'),
              'edit_item' => __('Edit Cool Places Type', 'text_domain'),
              'update_item' => __('Update Cool Places Type', 'text_domain'),
              'separate_items_with_commas' => __('Separate items with commas', 'text_domain'),
              'search_items' => __('Search Cool Places Types', 'text_domain'),
              'add_or_remove_items' => __('Add or remove Cool Places Types', 'text_domain'),
              'choose_from_most_used' => __('Choose from the most used Cool Places Types', 'text_domain'),
              'not_found' => __('Not Found', 'text_domain'),
        );
        $args = array(
              'labels' => $labels,
              'hierarchical' => false,
              'public' => true,
              'show_ui' => true,
              'show_admin_column' => true,
              'show_in_nav_menus' => true,
              'show_tagcloud' => true,
              'rewrite' => array('slug' => 'cool-places')
                /* 'update_count_callback' => 'dump_this', */
        );

        register_taxonomy('cool_place_type', array('cool-place'), $args);
}

// Hook into the 'init' action
add_action('init', 'cool_place_type_taxonomy', 0);

/**
 *      META BOX
 */
// Add Meta Boxes
/*
 */
add_action('add_meta_boxes', 'cool_place_meta_boxes');

function cool_place_meta_boxes() {
        add_meta_box('nz_coolplace_meta', 'Meta', 'nz_cool_place_meta', 'cool-place', 'advanced', 'default');
}

// user post Metabox 1
function nz_cool_place_meta() {
        global $post;

        /**
         *      mapa
         */
        // Get the location data if its already been entered
        $mapa = '';
        $street = '';
        if (!$post->post_status == 'auto-draft') {
                $mapa = get_post_meta($post->ID, 'mapa', true);
                if ($mapa) {
                        $mapa = json_decode($mapa);
                        $street = $mapa->address;
                }
        }
        ?>
        <p>Address</p>
        <input type="hidden" name="coolplacemeta_noncename" id="coolplacemeta_noncename" value="<?php echo wp_create_nonce(basename(__FILE__)) ?>"/>
        <input type="text" name="_nz_coolplace_address" id="_nz_coolplace_address" value="<?php echo htmlspecialchars($mapa) ?>" class="widefat" />
        <input type="text" name="_nz_coolplace_address_search" id="_nz_coolplace_address_search" value="<?php echo htmlspecialchars($street) ?>" class="widefat" />
        <div id="map_canvas" class="map_canvas"></div>

        <?php
        add_action('admin_footer', 'cool_place_meta_scripts');

        /**
         *      featured
         */
        $featured = get_post_meta($post->ID, 'featured', true);
        /*d($featured);*/
        if ($featured) {
                ?>
                <input type="checkbox" name="featured" value="1" checked="true">
                <?php
        } else {
                ?>
                <input type="checkbox" name="featured" value="1" >
                <?php
        }
        ?>
        <p>Featured</p>
        <?php
}

// Save the Metabox 1
add_action('save_post', 'nz_save_cool_place_meta', 1, 2); // save the custom fields

function nz_save_cool_place_meta($post_id, $post) {
        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        if (!wp_verify_nonce($_POST['coolplacemeta_noncename'], basename(__FILE__))) {
                return $post->ID;
        }
        if ($post->post_type == 'revision') {
                return;
        }

        // Is the user allowed to edit the post or page?
        if (!current_user_can('edit_post', $post->ID)) {
                return $post->ID;
        }

        $mapa = $_POST['_nz_coolplace_address'];

        if (!empty($mapa)) {
                update_post_meta($post->ID, 'mapa', $mapa);
        } else {
                delete_post_meta($post->ID, 'mapa'); // Delete if blank
        }


        $featured = $_POST['featured'];
        if ($featured) {
                $return = update_post_meta($post->ID, 'featured', 1);
                /*d($return);*/
/*               
                d('update');
                d($featured);
 *  */
        } else {
               delete_post_meta($post->ID, 'featured'); // Delete if blank
        }
        /* d($_POST); */
}

function cool_place_meta_scripts() {
        ?>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&sensor=true"></script>
        <style>
                .map_canvas {
                        width: 98%;
                        margin: 5px auto;
                        height: 300px;
                }
        </style>
        <script>
                jQuery(function($) {
                        /*            
                         * 
                         */
                        //do not sent form on enter
                        //allow to select address with keyboard
                        $('#post').bind("keyup keypress", function(e) {
                                var code = e.keyCode || e.which;
                                if (code == 13) {
                                        e.preventDefault();
                                        return false;
                                }
                        });
                        //get current address from hidden field
                        try {
                                jsonAdress = $.parseJSON($('#_nz_coolplace_address').val());
                                console.log('aqui');
                        } catch (e) {
                                console.log("nz - error: " + e);
                        }
                        ;
                        /*console.log(jsonAddress);*/
                        //if is not empty build LatLng
                        //else default to bcn
                        if (jsonAdress !== null && typeof jsonAdress === 'object') {
                                currentLatlng = new google.maps.LatLng(jsonAdress.lat, jsonAdress.long);
                                //$('#_nz_coolplace_address_search').val(jsonAdress.address);
                        } else {
                                currentLatlng = new google.maps.LatLng(41.382573, 2.175293);
                        }

                        // vars
                        var args = {
                                zoom: 15,
                                center: currentLatlng,
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                        };

                        // create map
                        map = new google.maps.Map(document.getElementById("map_canvas"), args);

                        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('_nz_coolplace_address_search'));
                        autocomplete.map = map;
                        autocomplete.bindTo('bounds', map);

                        var marker = new google.maps.Marker({
                                position: currentLatlng,
                                map: map
                        });

                        //process place change
                        google.maps.event.addListener(autocomplete, 'place_changed', function(e) {
                                var place = autocomplete.getPlace();

                                //if no place
                                if (!place.geometry) {
                                        $('#_nz_coolplace_address').val('');
                                        return;
                                }

                                // If the place has a geometry, then present it on a map. ??
                                if (place.geometry.viewport) {
                                        map.fitBounds(place.geometry.viewport);
                                } else {
                                        map.setCenter(place.geometry.location);
                                        map.setZoom(17);  // Why 17? Because it looks good.
                                }

                                //build json to save full address latlong
                                var save = {
                                        lat: place.geometry.location.k,
                                        long: place.geometry.location.B,
                                        address: place.formatted_address
                                };

                                $('#_nz_coolplace_address').val(JSON.stringify(save));

                                marker.setPosition(place.geometry.location);
                                marker.setVisible(true);

                        });


                });
        </script>

        <?php
}
