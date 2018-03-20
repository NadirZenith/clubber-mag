<?php

add_action('init', 'cm_register_event_post_type');

function cm_register_event_post_type() {
    $labels = array(
        'name' => __('Events', 'cm'),
        'singular_name' => _x('Event', 'post type singular name', 'cm'),
        'menu_name' => _x('Events', 'admin menu', 'cm'),
        'name_admin_bar' => _x('Event', 'add new on admin bar', 'cm'),
        'add_new' => _x('Add New', 'event', 'cm'),
        'add_new_item' => __('Add New Event', 'cm'),
        'new_item' => __('New Event', 'cm'),
        'edit_item' => __('Edit Event', 'cm'),
        'view_item' => __('View Event', 'cm'),
        'all_items' => __('All Events', 'cm'),
        'search_items' => __('Search Events', 'cm'),
        'parent_item_colon' => __('Parent Events:', 'cm'),
        'not_found' => __('No events found.', 'cm'),
        'not_found_in_trash' => __('No events found in Trash.', 'cm')
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'agenda'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields')
    );

    register_post_type('agenda', $args);
}

/* relation to users */
add_action('p2p_init', 'cm_events_connections');

function cm_events_connections() {
    p2p_register_connection_type(array(
        'name' => 'events_to_users',
        'from' => 'agenda',
        'to' => 'user'
    ));
}

add_action('custom_metadata_manager_init_metadata', 'cm_agenda_custom_fields');

function cm_agenda_custom_fields() {
    $group = 'event_metabox';
    $post_type = 'agenda';
    $prefix = 'wpcf-';

    x_add_metadata_group($group, $post_type, array(
        'label' => 'Agenda field group'
    ));

    x_add_metadata_field('relation-to-coolplace', $post_type, array(
        'group' => $group,
        'field_type' => 'select',
        'label' => 'Coolplace',
        'description' => 'Cool place',
        'display_callback' => 'cm_relation_to_coolplace_metafield',
    ));

    x_add_metadata_field($prefix . 'event_begin_date', $post_type, array(
        'group' => $group, // the group name
        'label' => 'Fecha inicio', // field label
        /* 'description' => 'Fecha inicio evento', // description for the field */
        'display_column' => true, // show this field in the column listings
        'display_column_callback' => function($field_slug, $field, $object_type, $object_id, $value) {
            $Datetime = new DateTime();
            $Datetime->setTimestamp($value[0]);
            return $Datetime->format('l d/m/y');
        },
        'field_type' => 'datetimepicker',
        /* 'readonly' => FALSE, */
    ));
    x_add_metadata_field($prefix . 'event_end_date', $post_type, array(
        'group' => $group,
        'label' => 'Fecha Final',
        'field_type' => 'datetimepicker',
    ));

    x_add_metadata_field($prefix . 'event_price', $post_type, array(
        'group' => $group,
        'label' => 'Precio',
    ));
    x_add_metadata_field($prefix . 'event_price_conditions', $post_type, array(
        'group' => $group,
        'label' => 'Condiciones del Precio',
    ));

    x_add_metadata_field($prefix . 'event_flyer_back', $post_type, array(
        'group' => $group,
        'label' => 'Back flyer',
        'field_type' => 'upload'
    ));
    /*
     */
    x_add_metadata_field($prefix . 'event_type', $post_type, array(
        'group' => $group,
        'field_type' => 'radio',
        'label' => 'Tipo de evento',
        'values' => array(
            'party' => 'party',
            'festival' => 'festival'
        )
    ));
    x_add_metadata_field($prefix . 'event_promoter', $post_type, array(
        'group' => $group,
        'label' => 'Promotor del evento',
    ));

    x_add_metadata_field($prefix . 'event_featured', $post_type, array(
        'group' => $group,
        'label' => 'Destacado',
        'field_type' => 'checkbox',
    ));


    /*

      x_add_metadata_field($prefix . 'event_place_name', $post_type, array(
      'group' => $group,
      'label' => 'Nombre del lugar',
      ));
      x_add_metadata_field($prefix . 'event_place_address', $post_type, array(
      'group' => $group,
      'label' => 'Dirección del lugar',
      ));
     */
}

function cm_relation_to_coolplace_metafield($field_slug, $field, $object_type, $object_id, $value) {
    $posts = get_posts(array(
        'post_type' => 'cool-place',
        'post_status' => 'any',
        'post_author' => 'any',
        'posts_per_page' => -1
        )
    );

    printf('<select id="%s" class="custom-metadata-select2" name="%s">', esc_attr($field_slug), esc_attr($field_slug));
    echo '<option value="">OTRO - wpcf-event_place_address / name</option>';
    foreach ($posts as $post) {
        printf('<option value="%s"%s>', esc_attr($post->ID), selected($post->ID, $value[0], false));
        echo $post->post_title;
        echo '</option>';
    }
    echo '</select>';
}

add_action('pre_get_posts', 'cm_pre_get_archive_agenda');

function cm_pre_get_archive_agenda($query) {

    if (
        !$query->is_main_query() || $query->is_admin || !$query->is_post_type_archive('agenda')
    )
        return;

    Roots_Wrapping::$raw = TRUE;
    $query->set('posts_per_page', -1);
    $query->set('post_type', "agenda");

    $query->set('orderby', "meta_value_num");
    $query->set('meta_key', "wpcf-event_begin_date");
    $query->set('order', "ASC");

    $start_date = strtotime("now");

    $date = get_query_var('date');
    $DateTime = DateTime::createFromFormat('d-m-Y', $date);
    if ($DateTime) {
        $DateTime->setTime(0, 0, 0); //to avoid date problems
        $start_date = $DateTime->getTimestamp();
    }

    $end_date = strtotime('+ 1 week', $start_date);

    $date_meta_query = array(
        'key' => 'wpcf-event_begin_date',
        'value' => array($start_date, $end_date),
        'type' => 'NUMERIC',
        'compare' => 'BETWEEN'
    );

    $meta_query = array(
        $date_meta_query,
    );
    $query->set('meta_query', $meta_query);
}
