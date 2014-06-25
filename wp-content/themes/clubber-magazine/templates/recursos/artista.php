<?php
/**
 * UNA PÁGINA DE ARTISTA POR USUÁRIO
 * varias paginas de artista por label
 * 
 */
$user = wp_get_current_user();


//test if is artist from label
if ($gform_label_id = $_GET['gform_label_id']) {
        $label = get_post($gform_label_id);
        if ($label->post_type != 'label') {
                die('404');
        }elseif($label->post_author != $user->ID){
                die('403');
        }
        
} else {

        $user_artist_id = get_user_meta($user->ID, 'artist_page', true); //''

        if ($user_artist_id && !isset($_GET['gform_post_id'])) {
                $artist_edit_url = add_query_arg(array('gform_post_id' => $user_artist_id), get_permalink(get_page_by_title('recursos')) . 'artista');
                global $NZS;
                $NZS->getFlashBag()->add('info', 'Solo puedes tener una página de artista, edita la aqui');
                wp_redirect($artist_edit_url);
                die('redirect artist edit page');
        } elseif ($_GET['gform_post_id'] != $user_artist_id) {
                die('403');
        }
}
?>

<?php
get_header();
?>
<div id="container">
        <section class="bg-50 block-5 pb15">
                <div class="mt5 ml5 cb pb5 meddium">
                        <?php
                        nzs_display_messages();

                        if ($label) {
                                ?>
                                <div class="col-2-4 bg-50 block-5">
                                        <div class="col-2-4 fl nm featured-image">
                                                <?php echo get_the_post_thumbnail($label->ID, '340-155-thumb') ?>
                                        </div>
                                        <div class="col-2-4 fl">
                                                <span class="big pl5">
                                                        <?php echo $label->post_title ?>
                                                </span>
                                        </div>
                                </div>
                                <?php
                        }
                        echo $nz['artist_form'];
                        ?>
                </div>
        </section>

</div>


<?php
get_footer();
?>