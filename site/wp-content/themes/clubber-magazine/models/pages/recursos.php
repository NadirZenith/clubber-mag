<?php
/**
 *      filter for pre get page_recursos
 */
add_action('pre_get_posts', 'nz_pre_get_page_recursos');

function nz_pre_get_page_recursos($query)
{
    if (
        !$query->is_main_query() || !is_page_template('page-template-resources.php')
    ) {
        return;
    }
    $current_page = $query->get_queried_object();
    /* $resource_page_id = cm_lang_get_post( $query->get_queried_object_id(), 'es' ); */
    $resource_page_id = $query->get_queried_object_id();

    if ($resource_page_id == CM_RESOURCE_MAIN_PAGE_ID) {

        return;
    } else {
        if (!is_user_logged_in()) {
            global $NZS;

            $NZS->getFlashBag()->add('success', __('Please login to manage resources', 'cm'));
            $login_url = get_permalink(CM_CONNECT_PAGE_ID);

            wp_redirect($login_url);
            exit();
        }
    }
    $main_resource_id = get_user_meta(get_current_user_id(), CM_USER_META_RESOURCE_ID, true);

    $main_resource = get_post($main_resource_id);
    $edit_id = (int) $query->get(NZ_WP_Forms::$edit_query_var);

    if ($resource_page_id == CM_RESOURCE_ARTIST_PAGE_ID) {//IS RESOURCE ARTIST
        //check for main resource
        if (!empty($main_resource) & $main_resource->post_type != 'artist') {
            global $NZS;

            $NZS->getFlashBag()->add('success', __('You can only manage one resource per user','cm'));

            $url = get_author_posts_url(get_current_user_id());
            wp_redirect($url);
            exit();
        }

        //if there is artist page and is not editing redirect to it
        if ($main_resource && !$edit_id) {
            global $NZS;
            $NZS->getFlashBag()->add('success', sprintf(__('You can only manage one %s page per user, edit it here', 'cm'), __('artist')));


            $path = NZ_WP_Forms::link($query->get('pagename'), $main_resource_id);
            $link = home_url($path);
            wp_redirect($link);
            exit();
        } elseif ($edit_id != $main_resource_id) {
            //if the artist page is not the user artist page set 404      
            status_header(403);
            $query->set_404();
            return;
            /* die( 'artist - 403' ); */
        }
    } elseif ($resource_page_id == CM_RESOURCE_LABEL_PAGE_ID) {//IS RESOURCE LABEL
        //check for main resource
        if (!empty($main_resource) & $main_resource->post_type != 'label') {
            global $NZS;
            $NZS->getFlashBag()->add('success', __('You can only manage one resource per user','cm'));

            $url = get_author_posts_url(get_current_user_id());
            wp_redirect($url);
            exit();
        }

        //if there is label page and is not editing redirect to it
        if ($main_resource && !$edit_id) {
            global $NZS;
            $NZS->getFlashBag()->add('success', sprintf(__('You can only manage one %s page per user, edit it here', 'cm'), __('label')));

            $path = NZ_WP_Forms::link($query->get('pagename'), $main_resource_id);
            $link = home_url($path);
            wp_redirect($link);
            exit();
        } elseif ($edit_id != $main_resource_id) {
            //if the artist page is not the user artist page set 404      
            status_header(403);
            $query->set_404();
            die('label - 403');
        }
    } elseif ($resource_page_id == CM_RESOURCE_COOLPLACE_PAGE_ID) {//IS RESOURCE COOLPLACE
        // //check for main resource
        if (!empty($main_resource) & $main_resource->post_type != 'cool-place') {
            global $NZS;
            $NZS->getFlashBag()->add('success', __('You can only manage one resource per user','cm'));

            $url = get_author_posts_url(get_current_user_id());
            wp_redirect($url);
            exit();
        }

        //if there is artist page and is not editing redirect to it
        if ($main_resource && !$edit_id) {
            global $NZS;
            $NZS->getFlashBag()->add('success', sprintf(__('You can only manage one %s page per user, edit it here', 'cm'), __('cool place')));

            $path = NZ_WP_Forms::link($query->get('pagename'), $main_resource_id);
            $link = home_url($path);
            wp_redirect($link);
            exit();
        } elseif ($edit_id != $main_resource_id) {
            //if the artist page is not the user artist page set 404      
            status_header(403);
            $query->set_404();
            die('coolplace - 403');
        }
    }
}
/**
 *      filter for pre get page_recursos
 */
add_action('pre_get_posts', 'cm_pre_get_page_new_podcast');

function cm_pre_get_page_new_podcast($query)
{
    if (
        !$query->is_main_query() || !is_page(CM_RESOURCE_PODCAST_PAGE_ID)
    ) {
        return;
    }
    if (!is_user_logged_in()) {
        global $NZS;

        $NZS->getFlashBag()->add('success', __('Please login to manage resources', 'cm'));
        $login_url = get_permalink(CM_CONNECT_PAGE_ID);

        wp_redirect($login_url);
        exit();
    }

    if (!nz_is_ajax()) {

        $query->set_404();
        return;
    }

    if (isset($_REQUEST[NZ_WP_Forms::$edit_query_var])) {
        $post = get_post($_REQUEST[NZ_WP_Forms::$edit_query_var]);
        if ($post->post_author != get_current_user_id() || $post->post_type != 'open-frequency')
            $query->set_404();
    }
}
add_action('pre_get_posts', 'cm_pre_get_page_new_event');

function cm_pre_get_page_new_event($query)
{
    if (
        !$query->is_main_query() || !is_page(CM_RESOURCE_EVENT_PAGE_ID)
    ) {
        return;
    }

    if (isset($_REQUEST[NZ_WP_Forms::$edit_query_var])) {
        $post = get_post($_REQUEST[NZ_WP_Forms::$edit_query_var]);
        if ($post->post_author != get_current_user_id())
            $query->set_404();
    }
}
