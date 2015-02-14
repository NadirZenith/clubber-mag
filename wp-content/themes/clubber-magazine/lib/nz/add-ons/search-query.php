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
              'music',
              'cool-place',
              'artist',
              'label'
        ));
        return $query;
}

//hook filters to search
add_filter('pre_get_posts', 'nz_search_query');

