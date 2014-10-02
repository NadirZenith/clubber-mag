<?php
/*wp_enqueue_style('clubber-mag', get_stylesheet_uri(), null, '1.0');*/
/*wp_enqueue_style('clubber-mag-dev', get_template_directory_uri(). '/assets/css/main.css', null, '1.0');*/

/*font*/
wp_enqueue_style('font-russo-one', 'http://fonts.googleapis.com/css?family=Russo+One');

/* see plugins/ml-slider/inc/slider/metaslider.class.php *line 451 */
wp_enqueue_script('metaslider-' . 'flexslider' . '-slider', METASLIDER_ASSETS_URL . 'sliders/flexslider/jquery.flexslider-min.js', array('jquery'), METASLIDER_VERSION);
wp_enqueue_script('backtotop', ATTITUDE_JS_URL . '/backtotop.js', array('jquery'));

wp_enqueue_style('fancybox', get_template_directory_uri() . '/js/fancybox/source/jquery.fancybox.css', $deps, $ver, $media);
wp_enqueue_script('fancybox', get_template_directory_uri() . '/js/fancybox/source/jquery.fancybox.pack.js', array('jquery'));


wp_enqueue_style('slimmenu', get_template_directory_uri() . '/js/slimmenu/slimmenu.min.css', $deps, $ver, $media);
wp_enqueue_script('slimmenu', get_template_directory_uri() . '/js/slimmenu/jquery.slimmenu.min.js', array('jquery'));


/* AGENDA */
wp_enqueue_style('fullcalendar', get_template_directory_uri() . '/js/fullcalendar/fullcalendar.css');

wp_enqueue_script('fullcalendar', get_template_directory_uri() . '/js/fullcalendar/fullcalendar.min.js', array('jquery'));

/** subir evento*/
wp_enqueue_style('jquery-ui-theme', 'http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css', $deps, $ver, $media);
wp_enqueue_style('jquery-ui-timepicker-theme', get_template_directory_uri() . '/js/datetimepickerJqueryUI/jquery-ui-timepicker-addon.min.css', $deps, $ver, $media);

wp_enqueue_script('jquery-ui', 'http://code.jquery.com/ui/1.10.4/jquery-ui.min.js', array('jquery'));
wp_enqueue_script('jquery-ui-timepicker', get_template_directory_uri() . '/js/datetimepickerJqueryUI/jquery-ui-timepicker-addon.min.js', array('jquery-ui'));
wp_enqueue_script('jquery-ui-datetimepicker-i18n', get_template_directory_uri() . '/js/datetimepickerJqueryUI/i18n/jquery-ui-timepicker-es.js', array('jquery-ui-timepicker'));
wp_enqueue_script('jquery-ui-sliderAccess', get_template_directory_uri() . '/js/datetimepickerJqueryUI/jquery-ui-sliderAccess.js', array('jquery-ui'));

?>

<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php wp_title('|', true, 'right'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!--       start head         -->
        <?php wp_head(); ?>
        <!--       end head         -->
        <?php
        /** @todo nz implement this icons
          <link rel="apple-touch-icon" href="apple-touch-icon-iphone.png" />
          <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-ipad.png" />
          <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-iphone4.png" />
         */
        ?>
        <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri() ?>/images/apple-touch-icon.png" />
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri() ?>/images/faviconv4.ico" type="image/x-icon" />
</head>
