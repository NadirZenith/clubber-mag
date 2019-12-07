<?php
/**
 * Scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /theme/assets/css/main.css
 *
 * Enqueue scripts in the following order:
 * 1. jquery-1.11.1.min.js via Google CDN
 * 2. /theme/assets/js/vendor/modernizr.min.js
 * 3. /theme/assets/js/scripts.js (in footer)
 *
 * Google Analytics is loaded after enqueued scripts if:
 * - An ID has been defined in config.php
 * - You're not logged in as an administrator
 */
add_action('wp_enqueue_scripts', 'roots_scripts', 100);

function roots_scripts()
{
    $base = get_template_directory_uri();
    if (WP_ENV === 'development') {

        $assets = array(
            'css' => array(
                'pure-css-min' => '/assets/css/pure-min.css',
//                'pure-css-min' => '//yui.yahooapis.com/pure/0.6.0/pure-min.css',
                'pure-css-responsive-min' => '/assets/css/grids-responsive-min.css',
//                'pure-css-responsive-min' => '//yui.yahooapis.com/pure/0.6.0/grids-responsive-min.css',
                'font-russo-one' => '//fonts.googleapis.com/css?family=Russo+One',
                'font-awesome' => 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
                'main' => $base . '/assets/css/main.css',
                'pure-responsive-debug' => $base . '/assets/css/pure-responsive-debug.css',
            /* 'pure-css-base' => '//yui.yahooapis.com/pure/0.6.0/base-min.css', */
            ),
            'js' => array(
                'main' => $base . '/assets/js/scripts.js',
                'modernizr' => $base . '/assets/vendor/modernizr/modernizr.js',
                'jquery' => '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js',
                'google-places' => 'https://maps.googleapis.com/maps/api/js?v=3&amp;libraries=places',
            ),
        );
    } else {

        $get_assets = file_get_contents(get_template_directory() . '/assets/manifest.json');
        $assets = json_decode($get_assets, true);

        $assets = array(
            'css' => array(
//                'pure-css-min' => '//yui.yahooapis.com/pure/0.6.0/pure-min.css',
                'pure-css-min' => '/assets/css/pure-min.css',
                'pure-css-responsive-min' => '/assets/css/grids-responsive-min.css',
//                'pure-css-responsive-min' => '//yui.yahooapis.com/pure/0.6.0/grids-responsive-min.css',
                'font-russo-one' => '//fonts.googleapis.com/css?family=Russo+One',
                'font-awesome' => 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
                'main' => $base . '/assets/css/main.min.css?' . $assets['assets/css/main.min.css']['hash'],
            ),
            'js' => array(
                'main' => $base . '/assets/js/scripts.min.js?' . $assets['assets/js/scripts.min.js']['hash'],
                'modernizr' => $base . '/assets/js/vendor/modernizr.min.js',
                'jquery' => '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js',
                'google-places' => 'https://maps.googleapis.com/maps/api/js?v=3&amp;libraries=places',
            ),
        );
    }


    /**
     * jQuery is loaded using the same method from HTML5 Boilerplate:
     * Grab Google CDN's latest jQuery with a protocol relative URL; fallback to local if offline
     * It's kept in the header instead of footer to avoid conflicts with plugins.
     */
    if (!is_admin() && current_theme_supports('jquery-cdn')) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', $assets['js']['jquery'], array(), null, false);
        add_filter('script_loader_src', 'roots_jquery_local_fallback', 10, 2);
    }

    nz_enqueue_styles($assets['css']);
    nz_enqueue_scripts($assets['js']);

    /*
      if (is_single() && comments_open() && get_option('thread_comments')) {
      wp_enqueue_script('comment-reply');
      }
     */
}

function nz_enqueue_styles($assets)
{
    foreach ($assets as $handle => $asset) {
        wp_enqueue_style($handle, $asset);
    }
}

function nz_enqueue_scripts($assets)
{
    foreach ($assets as $handle => $asset) {
        wp_enqueue_script($handle, $asset);
    }
}

// http://wordpress.stackexchange.com/a/12450
function roots_jquery_local_fallback($src, $handle = null)
{
    static $add_jquery_fallback = false;

    if ($add_jquery_fallback) {
        echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/assets/vendor/jquery/dist/jquery.min.js?1.11.1"><\/script>\')</script>' . "\n";
        $add_jquery_fallback = false;
    }

    if ($handle === 'jquery') {
        $add_jquery_fallback = true;
    }

    return $src;
}
/** @todo nz change this because of assets rewrite */
/* add_action( 'wp_head', 'roots_jquery_local_fallback' ); */

/**
 * Google Analytics snippet from HTML5 Boilerplate
 */
if (GOOGLE_ANALYTICS_ID && !current_user_can('manage_options')) {
    add_action('wp_footer', 'roots_google_analytics', 20);
}

function roots_google_analytics()
{
    ?>
    <script>
        (function (b, o, i, l, e, r) {
            b.GoogleAnalyticsObject = l;
            b[l] || (b[l] =
                    function () {
                        (b[l].q = b[l].q || []).push(arguments)
                    });
            b[l].l = +new Date;
            e = o.createElement(i);
            r = o.getElementsByTagName(i)[0];
            e.src = '//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e, r)
        }(window, document, 'script', 'ga'));
        ga('create', '<?php echo GOOGLE_ANALYTICS_ID; ?>');
        ga('send', 'pageview');
    </script>

    <?php
}
