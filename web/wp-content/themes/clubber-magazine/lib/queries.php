<?php

//hook filters to search
add_filter('pre_get_posts', 'nz_search_query');

function nz_search_query($query)
{
    if (!$query->is_search || $query->is_admin) {
        return $query;
    }

    $query->set('post_type', array(
        'post',
        'artist',
        'cool-place',
        'agenda',
        'label',
        'music',
        'photo',
        'open-frequency',
        'into-the-beat',
        'video',
    ));
    return $query;
}
/*
 * Get Future Featured Events* With Thumbnail Ordered by Date
 */
add_action('pre_get_posts', 'cm_get_featured_events');

function cm_get_featured_events($query)
{

    if (
        !isset($query->query['cm_get_featured_events'])
    )
        return;

    //Future
    $future = array(
        'key' => 'wpcf-event_begin_date',
        'value' => time(),
        'type' => 'NUMERIC',
        'compare' => '>='
    );
    //Featured
    $featured = array(
        'key' => 'wpcf-event_featured',
        'compare' => 'EXISTS',
    );
    //Events
    $query->set('post_type', 'agenda');

    //With Thumbnail
    $with_tumbnail = array(
        'key' => '_thumbnail_id',
        'compare' => 'EXISTS',
    );

    $query->set('posts_per_page', 10);
    //Ordered by Meta Date
    $query->set('order', 'ASC');
    $query->set('orderby', 'meta_value_num');
    $query->set('meta_key', 'wpcf-event_begin_date');

    $meta_query = array(
        'relation' => 'AND',
        $future, $featured, $with_tumbnail
    );
    $query->set('meta_query', $meta_query);
}
