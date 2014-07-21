<?php
/**

 */
$user = wp_get_current_user();
$coolplaces = get_user_meta(get_current_user_id(), 'coolplaces_ids', true);


if (isset($_GET['gform_post_id'])) {
        if (in_array($_GET['gform_post_id'], $coolplaces)) {

                //user is owner of this club
        } else {
                die('403');
        }
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
                        echo $nz['coolplace_form'];
                        ?>
                </div>
        </section>

</div>


<?php
get_footer();
?>