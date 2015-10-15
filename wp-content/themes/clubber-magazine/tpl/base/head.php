<meta charset="utf-8">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php wp_title('|', true, 'right'); ?></title>
<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri() ?>/assets/images/apple-touch-icon.png" />
<link rel="shortcut icon" type="image/x-icon" sizes="16x16 24x24 32x32 48x48 64x64" href="<?php echo get_template_directory_uri() ?>/assets/images/favicon.ico">
<?php wp_head(); ?>
<?php
/**
 * ################ BETA
 */
if (current_user_can('manage_options')) {
    ?>
    <style>
        html{
            opacity: 0;
        }
    </style>

    <noscript>
    <style>
        html{
            opacity: 1;
        }
    </style>
    </noscript>

    <script>
        $(function () {

            var is_home = <?php echo is_front_page() ? 1 : 0 ?>;

            var $el = $('html');
            if (document.cookie.replace(/(?:(?:^|.*;\s*)cm_init_opacity_animation\s*\=\s*([^;]*).*$)|^.*$/, "$1") !== "true"
                    /*|| is_home*/
                    ) {

                document.cookie = "cm_init_opacity_animation=true; path=/";

                $el.animate({
                    opacity: 1
                }, 800);
                /*alert('set cookie');*/
            } else {
                $el.css({opacity: 1});
            }

        });
    </script>

    <?php
}
/**
 * END ################ BETA
 */
?>
