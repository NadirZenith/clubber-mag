<?php

/**
 *      filter for pre get page_recursos
 */
function nz_pre_get_page_recursos($query) {

        if (!$query->is_main_query())
                return;

        if (
                !$query->is_main_query() ||
                !$query->is_page('recursos')
        )
                return;

        /* d($query); */
        $type = get_query_var('type'); // 'artista' , 'cool-place', 'sellos'
        $action = get_query_var('action'); // '' , 'nuevo contenido'

        if (($type || $action ) && !is_user_logged_in()) {
                $login_url = get_permalink(get_page_by_path('registrate'));
                global $NZS;
                $NZS->getFlashBag()->add('error', 'Haz login o registrate para que puedas manejar los recursos');
                wp_redirect($login_url);
                exit('redirecting...');
        }

        global $nz_form, $nz;

        if ($action == 'nuevo-contenido') {
                $nz_form = $nz['userpost_form'];
                add_filter('roots/wrap_base', 'nz_page_recursos_form_view');
        } else {

                switch ($type) {
                        case 'artista':

                                $user_artist_id = get_user_meta(get_current_user_id(), 'artist_page', true);

                                //if there is artist page redirect to it
                                if ($user_artist_id && !isset($_GET['gform_post_id'])) {
                                        $artist_edit_url = apply_filters('gform_update_post/edit_url', $user_artist_id, get_permalink(get_page_by_path('recursos')) . 'artista');
                                        global $NZS;
                                        /* d(time()); */
                                        $NZS->getFlashBag()->add('success', 'Solo puedes tener una página de artista, edita la aqui');
                                        wp_redirect($artist_edit_url);
                                        die('redirect artist edit page');
                                } elseif ($_GET['gform_post_id'] != $user_artist_id) {
                                        /* status_header(403); */
                                        /* $template = locate_template('403.php'); */
                                        die('403');
                                }

                                $nz_form = $nz['artist_form'];

                                add_filter('roots/wrap_base', 'nz_page_recursos_form_view');

                                break;
                        case 'sello':
                                $user_label_id = get_user_meta(get_current_user_id, 'label_page', TRUE);

                                //redirect user to edit label page
                                if ($user_label_id && !isset($_GET['gform_post_id'])) {
                                        global $NZS;
                                        $label_edit_url = apply_filters('gform_update_post/edit_url', $user_label_id, $recursos_link . 'sello');

                                        $NZS->getFlashBag()->add('success', 'Solo puedes manejar un label. edita lo aqui');
                                        wp_redirect($label_edit_url);
                                        exit();
                                        die('redirect label edit page');
                                } elseif ($_GET['gform_post_id'] != $user_label_id) {
                                        die('403');
                                }


                                $nz_form = $nz['label_form'];

                                add_filter('roots/wrap_base', 'nz_page_recursos_form_view');

                                break;
                        case 'cool-place':
                                $coolplaces = get_user_meta(get_current_user_id(), 'coolplaces_ids', true);
                                d($coolplaces);
                                if (isset($_GET['gform_post_id'])) {
                                        if (!in_array($_GET['gform_post_id'], $coolplaces)) {

                                                /* die('403'); */
                                        }
                                }
                                $nz_form = $nz['coolplace_form'];

                                add_filter('roots/wrap_base', 'nz_page_recursos_form_view');
                                break;

                        default:
                                add_filter('roots/wrap_base', 'nz_page_recursos_default_view');
                                break;
                }
        }

        return;
}

add_action('pre_get_posts', 'nz_pre_get_page_recursos');

function nz_page_recursos_default_view($wrap) {

        Roots_Wrapping::$main_template = locate_template('templates/recursos/default.php');
        return $wrap;
}

function nz_page_recursos_form_view($wrap) {
        Roots_Wrapping::$main_template = locate_template('templates/recursos/form.php');
        return $wrap;
}
