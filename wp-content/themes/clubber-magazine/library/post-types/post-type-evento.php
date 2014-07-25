<?php

/* add_action('pre_get_posts', 'nz_events_admin_query'); */

function nz_events_admin_query($query) {

        //only front end && main query
        if (!is_admin() || !$query->is_main_query() || $query->query['post_type'] != 'agenda')
                return;

        $query->query_vars['orderby'] = 'post_status';
        $query->query_vars['order'] = 'DESC';

        d('is admin & is main query', $query);
        d($query->query['post_type']);
}

