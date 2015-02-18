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
                              <?php _e( 'Sign In', 'cm' ) ?>
                        </span>
                  </h2>
                  <p class="tj">
                        <?php _e( 'Sign in and enjoy our community.', 'cm' ) ?>
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
                              <?php _e( 'Sign Up', 'cm' ) ?>
                        </span>
                  </h2>
                  <p class="tj">
                        <?php _e( 'If you like electronic music, you are a producer, dj, promoter, or a club, signup in Clubber Magazine and enjoy our community.', 'cm' ) ?>
                  </p>
                  <?php
                  echo do_shortcode( '[nzwp_forms_register]' );
                  ?>
            </div>
      </div>
</div>


