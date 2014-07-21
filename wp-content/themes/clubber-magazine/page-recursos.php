<?php

/**
 *      UNA PÁGINA DE ARTISTA POR USUÁRIO
 * 
 *      UN LABEL POR USUÁRIO
 * 
 *      VÁRIOS LOCALES POR USUÁRIO
 */
$action = get_query_var('action'); // '' , 'nuevo contenido'
$type = get_query_var('type'); // 'artista' , 'cool-place', 'sellos'

if ($type && !is_user_logged_in()) {
        /* only loged in users */
        $login_url = get_permalink(get_page_by_path('registrate'));
        global $NZS;
        $NZS->getFlashBag()->add('info', 'Haz login o registrate para que puedas manejar los recursos');
        wp_redirect($login_url);
        exit();
}

/* d('action ' . $action); */
switch ($type) {
        case 'artista':
                if ($action != 'nuevo-contenido') {
                        include (locate_template('templates/recursos/artista.php'));
                } else {
                        include (locate_template('templates/recursos/user-post.php'));
                }
                break;
        case 'sello':
                d('hehe');
                if ($action != 'nuevo-contenido') {
                        d('sello');
                        include (locate_template('templates/recursos/sello.php'));
                } else {
                        d('user post');
                        include (locate_template('templates/recursos/user-post.php'));
                }
                break;
        case 'cool-place':
                include (locate_template('templates/recursos/cool-place.php'));
                break;

        default:
                include (locate_template('templates/recursos/default.php'));
                break;
}
?>

