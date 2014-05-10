
<?php
$login_url = get_permalink(get_page_by_path('registrate'));
$logout_url = wp_logout_url(home_url());
/*
  if (!is_user_logged_in()) {
  wp_redirect($login_url);
  exit;
  }
 */
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));

$edit_perfil_url = add_query_arg(array('action' => 'edit'), get_author_posts_url($curauth->ID));
//http://lab.dev/clubber-mag-dev/perfil/{current_author}/?action=edit

/*$curusr = wp_get_current_user();*/

/*if ($curusr && $curusr->data->user_login != 'clubber-mag') {wp_redirect(home_url()); }*/
?>



<?php get_header(); ?>

<div id="container">

        <?php
        $action = get_query_var('action');
        /* if ()  */
        switch ($action) {
                case 'edit':

                        include (locate_template('templates/user-profile-edit.php'));
                        break;

                default:
                        include (locate_template('templates/user-profile.php'));


                        break;
        }
        /* require_once 'templates/user-profile.php'; */
        ?>



</div>

<?php get_footer(); ?>
