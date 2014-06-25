<?php

/**
 *      UNA PÁGINA DE ARTISTA POR USUÁRIO
 * 
 *      UN LABEL POR USUÁRIO
 * 
 *      VÁRIOS LOCALES POR USUÁRIO
 */
$action = get_query_var('action'); // ''
$type = get_query_var('type'); // 'artista' , 'cool-place', 'sellos'
/*d($_GET['label']);*/

if ($type && !is_user_logged_in()) {
        /* only loged in users */
        $login_url = get_permalink(get_page_by_path('registrate'));

        global $NZS;
        $NZS->getFlashBag()->add('info', 'Haz login o registrate para que puedas manejar los recursos');
        wp_redirect($login_url);
        exit();
}

switch ($type) {
        case 'artista':
                include (locate_template('templates/recursos/artista.php'));
                break;
        case 'sellos-discograficos':
                include (locate_template('templates/recursos/label.php'));
                break;
        case 'cool-place':
                include (locate_template('templates/recursos/cool-place.php'));
                break;

        default:
                include (locate_template('templates/recursos/default.php'));
                break;
}
?>

