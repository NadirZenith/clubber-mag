<?php
/**
 * UNA PÁGINA DE ARTISTA POR USUÁRIO
 * varias paginas de artista por label
 * 
 */
$user = wp_get_current_user();

//get user artist page id
$user_artist_id = get_user_meta($user->ID, 'artist_page', true); //''
//if there is artist page redirect to it
if ($user_artist_id && !isset($_GET['gform_post_id'])) {
        /*$artist_edit_url = add_query_arg(array('gform_post_id' => $user_artist_id), get_permalink(get_page_by_title('recursos')) . 'artista');*/
        $artist_edit_url = apply_filters('gform_update_post/edit_url', $user_artist_id, get_permalink(get_page_by_path('recursos')) . 'artista');

        global $NZS;
        $NZS->getFlashBag()->add('info', 'Solo puedes tener una página de artista, edita la aqui');
        wp_redirect($artist_edit_url);
        die('redirect artist edit page');
} elseif ($_GET['gform_post_id'] != $user_artist_id) {
        die('403');
}
?>

<?php
get_header();
?>
<div id="container">
        <section class="bg-50 block-5 pb15">
                <div class="col-3-4" style="margin: auto">
                        <?php
                        nzs_display_messages();
                        echo $nz['artist_form'];
                        ?>
                </div>
        </section>

</div>


<?php
get_footer();
?>