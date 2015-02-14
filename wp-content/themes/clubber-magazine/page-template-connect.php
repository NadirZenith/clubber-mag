<?php
/**
 * Template Name: Connect Template
 *
 * Displays the login / register forms.
 *
 */
if ( is_user_logged_in() ) {
      ?>
      <script>
            window.onload = function() {
                  window.location.replace("<?php echo get_author_posts_url( get_current_user_id() ); ?>");
            };
      </script>
      <?php
}
?>

<div class="col-1 col-sm-1-2 fl">
      <div class="ibox-5">
            <div class="box-5">
                  <h2>
                        <span class="cm-title">
                              Entra
                        </span>
                  </h2>
                  <p class="tj">
                        Accede a nuestra plataforma y podrás compartir tus eventos, fotografías y vídeos además de colaborar con contenido en nuestras publicaciones.
                  </p>
                  <?php
                  echo do_shortcode( '[nzwp_forms_login]' );
                  ?>
            </div>
      </div>

</div>
<div class="col-1 col-sm-1-2 fl">
      <div class="ibox-5 ">
            <div class="box-5">
                  <h2>
                        <span class="cm-title">
                              Regístrate
                        </span>
                  </h2>
                  <p class="tj">
                        Si te gusta la música electrónica, eres productor, dj, promotor o un club, regístrate en Clubber Mag y sé parte de nosotros.
                  </p>
                  <?php
                  echo do_shortcode( '[nzwp_forms_register]' );
                  ?>
            </div>
      </div>
</div>


