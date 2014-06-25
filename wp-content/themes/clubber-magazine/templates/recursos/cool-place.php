<?php
/**

 */
$user = wp_get_current_user();

$NZRelation = New NZRelation('coolplaces_to_users', 'coolplace_id', 'user_id');
/* $NZRelation->install_table(); */
if (isset($_GET['gform_post_id'])) {
        if ($coolplace_relation = $NZRelation->hasRelationFrom($_GET['gform_post_id'], $user->ID)) {
                /*d($coolplace_relation);*/
                /*d($coolplace_relation[0]->coolplace_id);*/
                //user is owner of this club
        }  else {
                die(403);
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
                        echo $nz['coolplace_form'];
                        ?>
                </div>
        </section>

</div>


<?php
get_footer();
?>