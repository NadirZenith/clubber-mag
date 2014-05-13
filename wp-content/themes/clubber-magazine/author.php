
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

/* $edit_perfil_url = add_query_arg(array('action' => 'edit'), get_author_posts_url($curauth->ID)); */
//http://lab.dev/clubber-mag-dev/perfil/{current_author}/?action=edit
$edit_perfil_url = get_author_posts_url($curauth->ID) . 'editar';
//http://lab.dev/clubber-mag-dev/perfil/{current_author}/edit


/* $curusr = wp_get_current_user(); */

/* if ($curusr && $curusr->data->user_login != 'clubber-mag') {wp_redirect(home_url()); } */
?>



<?php get_header(); ?>

<div id="container">
        <?php
        global $wp_rewrite;
        /*d($wp_rewrite->get_author_permastruct());*/
        $action = get_query_var('action');
        switch ($action) {
                case 'editar':
                        include (locate_template('templates/user-profile-edit.php'));
                        break;

                default:
                        include (locate_template('templates/user-profile.php'));
                        break;
        }
        ?>

</div>

<?php get_footer(); ?>
