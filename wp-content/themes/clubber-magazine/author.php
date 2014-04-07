
<?php
if (!is_user_logged_in()) {
      $login_url = get_permalink(get_page_by_path('registrate'));
      wp_redirect($login_url);
      exit;
}
?>

<?php get_header(); ?>

<div id="container">

      <h1>
            PERFIL
      </h1>
      <?php
      $logout_redirect = home_url();
      $logout_url = wp_logout_url($logout_redirect);
      ?>
      <ul class="archive-list">
            <li><?php echo " [<a href=\"{$logout_url}\" title=\"Logout\">Logout</a> ]"; ?></li>
      </ul>


</div>

<?php get_footer(); ?>
