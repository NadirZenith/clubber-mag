<?php

/* * ************************************************************************************* */

add_action('wp_enqueue_scripts', 'attitude_scripts_styles_method');

/**
 * Register jquery scripts
 */
function attitude_scripts_styles_method() {

        global $attitude_theme_options_settings;
        $options = $attitude_theme_options_settings;
        /* d($options); */
        /**
         * Loads our main stylesheet.
         */
        wp_enqueue_style('attitude_style', get_stylesheet_uri());

        /**
         * Register JQuery cycle js for photo gallery featured
         */
        wp_register_script('jquery_cycle', ATTITUDE_JS_URL . '/jquery.cycle.all.min.js', array('jquery'), '2.9999.5', true);

        /**
         * Enqueue Slider setup js file.
         * Enqueue Fancy Box setup js and css file.	 
         */
        /*
          if (( is_home() || is_front_page() ) && "0" == $options['disable_slider']) {
          }
          wp_enqueue_script('attitude_slider', ATTITUDE_JS_URL . '/attitude-slider-setting.js', array('jquery_cycle'), false, true);
         *  */
        wp_enqueue_script('metaslider-' . 'flexslider' . '-slider', METASLIDER_ASSETS_URL . 'sliders/flexslider/jquery.flexslider-min.js', array('jquery'), METASLIDER_VERSION);

        wp_enqueue_script('tinynav', ATTITUDE_JS_URL . '/tinynav.js', array('jquery'));
        wp_enqueue_script('backtotop', ATTITUDE_JS_URL . '/backtotop.js', array('jquery'));
}

/* * ************************************************************************************* */

add_filter('excerpt_length', 'attitude_excerpt_length');

/**
 * Sets the post excerpt length to 30 words.
 *
 * function tied to the excerpt_length filter hook.
 *
 * @uses filter excerpt_length
 */
function attitude_excerpt_length($length) {
        return 40;
}

/* * ************************************************************************************* */

add_action('template_redirect', 'attitude_feed_redirect');

/**
 * Redirect WordPress Feeds To FeedBurner
 */
function attitude_feed_redirect() {
        global $attitude_theme_options_settings;
        $options = $attitude_theme_options_settings;

        if (!empty($options['feed_url'])) {
                $url = 'Location: ' . $options['feed_url'];
                if (is_feed() && !preg_match('/feedburner|feedvalidator/i', $_SERVER['HTTP_USER_AGENT'])) {
                        header($url);
                        header('HTTP/1.1 302 Temporary Redirect');
                }
        }
}

?>