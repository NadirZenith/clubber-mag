<?php
add_action('attitude_title', 'attitude_add_meta', 5);

/**
 * Add meta tags.
 */
function attitude_add_meta() {
        ?>
        <meta charset="<?php bloginfo('charset'); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <?php
}

/* * ************************************************************************************* */

add_action('attitude_title', 'attitude_show_title', 10);

/**
 * Showing the title in the browser tab.
 * 
 * @uses wp_title() Display the title on the browser tab.
 */
function attitude_show_title() {
        ?>
        <title>
                <?php
                wp_title('|', true, 'right');
                ?>
        </title>
        <?php
}

add_filter('wp_title', 'attitude_filter_wp_title');

/**
 * Modifying the Title
 *
 * Function tied to the wp_title filter hook.
 * @uses filter wp_title
 */
function attitude_filter_wp_title($title) {
        global $page, $paged;

        // Get the Site Name
        $site_name = get_bloginfo('name');

        // Get the Site Description
        $site_description = get_bloginfo('description');

        $filtered_title = '';

        // For Homepage or Frontpage
        if (is_home() || is_front_page()) {
                $filtered_title .= $site_name;
                if (!empty($site_description)) {
                        $filtered_title .= ' &#124; ' . $site_description;
                }
        } elseif (is_feed()) {
                $filtered_title = '';
        } else {
                $filtered_title = $title . $site_name;
        }

        // Add a page number if necessary:
        if ($paged >= 2 || $page >= 2) {
                $filtered_title .= ' &#124; ' . sprintf(__('Page %s', 'attitude'), max($paged, $page));
        }

        // Return the modified title
        return $filtered_title;
}

/* * ************************************************************************************* */

add_action('attitude_links', 'attitude_add_links', 10);

/**
 * Adding link to stylesheet file
 *
 * @uses get_stylesheet_uri()
 */
function attitude_add_links() {
        ?>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />	
        <?php
}

/* * ************************************************************************************* */

// Load Favicon in Header Section
add_action('attitude_links', 'attitude_favicon', 15);
// Load Favicon in Admin Section
add_action('admin_head', 'attitude_favicon');

function attitude_favicon() {

        echo '<link rel="shortcut icon" href="' . get_site_url() . '/wp-content/themes/clubber-magazine/images/faviconv4.ico" type="image/x-icon" />';
}

/* * ************************************************************************************* */

// Load webpageicon in Header Section
add_action('attitude_links', 'attitude_webpageicon', 20);

function attitude_webpageicon() {

        /*
          <link rel="apple-touch-icon" href="apple-touch-icon-iphone.png" />
          <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-ipad.png" />
          <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-iphone4.png" />
         */

        echo '<link rel="apple-touch-icon" href="' . get_site_url() . '/wp-content/themes/clubber-magazine/images/apple-touch-icon.png" />';
}

/* * ************************************************************************************* */

add_action('attitude_header', 'attitude_headerdetails', 10);

/**
 * Shows Header Part Content
 *
 * Shows the site logo, title, description, searchbar, social icons etc.
 */
function attitude_headerdetails() {
        ?>
        <div class="container clearfix">
                <div class="hgroup-wrap clearfix">
                        <div class="hide-767">
                                <hgroup id="site-logo" class="clearfix">
                                        <h1> 
                                                <a class="featured-image mt15 mb15" href="<?php echo esc_url(home_url('/')); ?>" title="Clubber-Mag" rel="home">
                                                        <img src="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/images/clubber-mag-logo-v2.png" class="" width="180" height="164" alt="Clubber-Mag">
                                                </a>	
                                        </h1>
                                </hgroup>

                                <section id="social-wrapper" class="fr">
                                        <div class="fb-like mt15" data-href="https://www.facebook.com/Clubber.Mag" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false" data-font="tahoma"></div>
                                        <div id="social-profiles">
                                                <ul id="social-profiles-list" class="">
                                                        <li>
                                                                <a href="https://www.facebook.com/Clubber.Mag"  target="_blank">
                                                                        <img src="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/images/social/facebook.png">
                                                                </a>
                                                        </li> 
                                                        <li>
                                                                <a href="https://twitter.com/ClubberMag" target="_blank">
                                                                        <img src="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/images/social/twitter.png">
                                                                </a>
                                                        </li> 
                                                        <li>
                                                                <a href="https://www.youtube.com/channel/UCVEK0H-FgtXo45AfdEDN61g" target="_blank">
                                                                        <img src="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/images/social/youtube.png">
                                                                </a>
                                                        </li> 
                                                </ul>
                                        </div>
                                        <?php ?>
                                </section>
                        </div>

                        <div class="fl top-banner featured-image"> 
                                <?php
                                echo do_shortcode('[sam id=1]');
                                ?>
                        </div>
                </div><!-- .hgroup-wrap -->
        </div><!-- .container -->	

        <nav id="access" class="clearfix">
                <div class="container clearfix">
                        <?php
                        $args = array(
                              'theme_location' => 'primary',
                              'container' => '',
                              'items_wrap' => '<ul id="main-menu" class="">%3$s</ul>'
                        );
                        ?>
                        <div id="desktop-menu"><?php wp_nav_menu($args); ?></div>
                </div>
        </nav>
        <?php
        $img = '<img style="margin-left:-25px;margin-top:3px" width="230" height="50" alt="Clubber-Mag" src="' . get_site_url() . "/wp-content/themes/clubber-magazine/images/clubber-mag-logo-inline-v2.png" . '">';
        $logo = '<a href="' . esc_url(home_url('/')) . '" title="Clubber-Mag" rel="home">' . $img . '</a>';
        ?>
        <script type="text/javascript">
                jQuery(document).ready(function($) {
                        /* drop down*/
                        $('nav#access li').hover(
                                function() {
                                        $('ul', this).stop().slideDown(200);
                                },
                                function() {
                                        $('ul', this).stop().slideUp(200);
                                }
                        );

                        /* mobile menu */
                        $("<div></div>").attr('id', 'mobile-menu').prependTo('body');

                        $('#main-menu').clone().attr({
                                'class': 'slimmenu',
                                'id': 'slimmenu'
                        }).prependTo('#mobile-menu');

                        /*title = '<div style="text-align:center; width:100%;"><img src="<?php echo $logo ?>" class="" width="235" height="50" alt="Clubber-Mag">' + $('#social-profiles2').html() + '</div>';*/

                        $('#slimmenu').slimmenu(
                                {
                                        resizeWidth: '1078',
                                        collapserTitle: '<div style="text-align:center;"><?php echo $logo ?></div>',
                                        easingEffect: 'easeInOutQuint',
                                        animSpeed: 'medium',
                                        indentChildren: true,
                                        childrenIndenter: '&raquo; '
                                }
                        );


                });
        </script>
        <?php
}

/* * ************************************************************************************* */

if (!function_exists('attitude_breadcrumb')) :

        /**
         * Display breadcrumb on header.
         *
         * If the page is home or front page, slider is displayed.
         * In other pages, breadcrumb will display if breadcrumb NavXT plugin exists.
         */
        function attitude_breadcrumb() {
                if (function_exists('bcn_display')) {
                        echo '<div class="breadcrumb">';
                        bcn_display();
                        echo '</div> <!-- .breadcrumb -->';
                }
        }

endif;

/* * ************************************************************************************* */

if (!function_exists('attitude_header_title')) :

        /**
         * Show the title in header
         *
         * @since Attitude 1.0
         */
        function attitude_header_title() {
                if (is_archive()) {
                        $attitude_header_title = single_cat_title('', FALSE);
                } elseif (is_404()) {
                        $attitude_header_title = __('Page NOT Found', 'attitude');
                } elseif (is_search()) {
                        $attitude_header_title = __('Search Results', 'attitude');
                } elseif (is_page_template()) {
                        $attitude_header_title = get_the_title();
                } else {
                        $attitude_header_title = '';
                }

                return $attitude_header_title;
        }

endif;
?>