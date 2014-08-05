<?php

function nz_search_query($query) {
        if (!$query->is_search || $query->is_admin) {
                return $query;
        }

        $query->set('post_type', array(
              'agenda',
              'page',
              'photo',
              'video',
              'musica',
              'cool-place',
              'artista',
              'sello'
        ));
        return $query;
}

//hook filters to search
add_filter('pre_get_posts', 'nz_search_query');

function nz_search_order($orderby, $query) {
        global $wpdb;

        if (!is_admin() && is_search())
                $orderby = $wpdb->prefix . "posts.post_type DESC, {$wpdb->prefix}posts.post_date DESC";

        return $orderby;
}

/*add_filter('posts_orderby','nz_search_order',10,2);*/
