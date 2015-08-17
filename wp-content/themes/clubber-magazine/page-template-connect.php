<?php
/**
 * Template Name: Connect Template
 *
 * Displays the login / register forms.
 *
 */
if (is_user_logged_in()) {
    ?>
    <script>
        window.onload = function () {
            window.location.replace("<?php echo get_author_posts_url(get_current_user_id()); ?>");
        };
    </script>
    <?php
}
?>
<div class="pure-g">
    <div class="pure-u-1-2">
        <section>
            <?php if (!isset($_GET['recover'])) { ?>
                <h1>
                    <span class="title">
                        <?php _e('Sign In', 'cm') ?>
                    </span>
                </h1>
                <p class="tj">
                    <?php _e('Sign in and enjoy our community.', 'cm') ?>
                </p>
            <?php } ?>

            <?php
            echo do_shortcode('[nzwp_forms_login]');
            ?>
        </section>
    </div>
    <?php if (!isset($_GET['recover'])) { ?>
        <div class="pure-u-1-2">
            <section>
                <h1>
                    <span class="title">
                        <?php _e('Sign Up', 'cm') ?>
                    </span>
                </h1>
                <p class="tj">
                    <?php _e('If you like electronic music, you are a producer, dj, promoter, or a club, signup in Clubber Magazine and enjoy our community.', 'cm') ?>
                </p>
                <?php
                echo do_shortcode('[nzwp_forms_register]');
                ?>
            </section>
        </div>
    <?php } ?>
</div>