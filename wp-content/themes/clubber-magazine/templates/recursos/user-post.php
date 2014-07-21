<?php
/**
 *     User Post ->  Artist or Label
 */
/*
  $user = wp_get_current_user();
  $user_label_id = get_user_meta($user->ID, 'label_page', TRUE);

  if ($user_label_id && !isset($_GET['gform_post_id'])) {
  global $NZS;
  $label_edit_url = add_query_arg(array('gform_post_id' => $user_label_id), get_permalink(get_page_by_title('recursos')) . 'sellos-discograficos');
  $NZS->getFlashBag()->add('info', 'Solo puedes manejar un label. edita lo aqui');
  wp_redirect($label_edit_url);
  exit();
  die('redirect label edit page');
  } elseif ($_GET['gform_post_id'] != $user_label_id) {
  die('403');
  }
 */
?>

<?php
get_header();
?>
<div id="container">
        <section class="bg-50 block-5 pb15">
                <div class="col-3-4" style="margin: auto">
                        <?php
                        nzs_display_messages();
                        echo $nz['userpost_form'];
                        ?>
                </div>
        </section>
</div>

<?php
get_footer();
?>