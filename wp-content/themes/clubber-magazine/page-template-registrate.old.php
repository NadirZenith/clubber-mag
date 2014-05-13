<?php
/**
 * Template Name: Registrate Template
 *
 * Displays the registrate template.
 *
 */
if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        wp_redirect(get_author_posts_url(get_current_user_id()));
        exit;
}
?>
<?php get_header(); ?>

<div id="container">

        <?php
        d('old');
        $action = get_query_var('action');
        //recover password
        if ($action == 'lostpassword') {
                ?>
                <style>
                        .user-forms .submit{
                                margin-top: 30px;
                        }
                        .user-forms p
                        {
                                width: 50%;
                        }
                </style>

                <div class="col-2-4 fl pb15 pt5 mt15 bg-50 block-5">
                        <div class="ml5 pb15">
                                <h1 class="">Recupera tu password</h1>
                        </div>
                        <div class="ml5">

                                <?php
                                echo do_shortcode('[wppb-recover-password]');
                                ?>
                        </div>
                </div>
                <?php
                //login & register
        } else {

                if (!is_user_logged_in()) {
                        include (locate_template('templates/user-profile-login.php'));
                        ?>

                        <?php
                }
        }
        ?>

</div><!-- #container -->

<?php get_footer(); ?>
