<?php
add_action('attitude_meta', 'attitude_add_meta', 5);

/**
 * Add meta tags.
 */
function attitude_add_meta() {
        ?>
        <title><?php wp_title('|', true, 'right'); ?></title>

        <meta charset="<?php bloginfo('charset'); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="apple-touch-icon" href="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/images/apple-touch-icon.png" />
        <?php
        /*
          <link rel="apple-touch-icon" href="apple-touch-icon-iphone.png" />
          <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-ipad.png" />
          <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-iphone4.png" />
         */
}

// Load Favicon in Header Section
add_action('attitude_meta', 'attitude_favicon', 15);
// Load Favicon in Admin Section
add_action('admin_head', 'attitude_favicon');

function attitude_favicon() {

        echo '<link rel="shortcut icon" href="' . get_site_url() . '/wp-content/themes/clubber-magazine/images/faviconv4.ico" type="image/x-icon" />';
}

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
                                        <iframe class="fb-like mt15" src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FClubber.Mag&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px; width: 90px;" allowTransparency="true"></iframe>
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
        <script>
                jQuery(document).ready(function($) {

                        //append searchform inside desktop menu
                        $('ul#main-menu').append($('<li></li>').html($('.search-form').clone()));

                        /* desktop drop down*/
                        $('nav#access li').hover(
                                function() {
                                        $('ul', this).stop().slideDown(200);
                                },
                                function() {
                                        $('ul', this).stop().slideUp(200);
                                }
                        );
                });
        </script>

        <?php
        $img = '<img style="margin-left:-25px;margin-top:3px" width="230" height="50" alt="Clubber-Mag" src="' . get_site_url() . "/wp-content/themes/clubber-magazine/images/clubber-mag-logo-inline-v2.png" . '">';
        $logo = '<a href="' . esc_url(home_url('/')) . '" title="Clubber-Mag" rel="home">' . $img . '</a>';
        ?>
        <style>
                #mobile-menu-title{
                        display: none;
                }
                #open-search-bar{
                        background: url(<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/images/search.png) #0e0e0e 14px 7px no-repeat;
                        position: absolute;
                        height: 31px; 
                        left: 5px;
                        top: 24%;
                        width: 42px;
                        cursor: pointer;
                        border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
                        border-radius: 4px;
                        border-style: solid;
                        border-width: 1px;
                        box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset, 0 1px 0 rgba(255, 255, 255, 0.075);
                        box-sizing: border-box;
                        /*transform: translate(0px, -50%);*/
                }
                #open-search-bar.active{
                        background-color: #666;
                }
                #mobile-menu .search-form{
                        height: 45px;width: 100%; position: absolute;top: 55px;left: 0px;display: none;background-color: #464d52;
                }
                #mobile-menu .search-form input{
                        margin-left: 5px;       
                }

                #main-menu .search-form{
                        margin-top: 10px;
                }

        </style>
        <div id="mobile-menu-title">
                <div style='text-align: center'>
                        <a href="<?php echo esc_url(home_url('/')); ?>" title="Clubber-Mag" rel="home">
                                <img style="margin-left:-35px;margin-top:3px" width="220" height="50" alt="Clubber-Mag" src="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/images/clubber-mag-logo-inline-v2.png">
                        </a>
                </div>
                <a id="open-search-bar"></a>
                <div class="search-form">
                        <form action="<?php echo esc_url(home_url('/')); ?>" class="" method="get">
                                <input type="text" placeholder="Busca personas, fiestas, clubes, artistas..." class="s field" name="s" value="<?php echo get_query_var('s', '') ?>">
                        </form><!-- .searchform -->

                </div>
        </div>
        <script type="text/javascript">
                jQuery(document).ready(function($) {


                        //mobile menu search form slide efect
                        $('body').on('click', '#open-search-bar', function() {
                                $btn = $(this);
                                $search = $btn.siblings('.search-form');

                                if ($search.is(':hidden')) {
                                        $btn.addClass('active');
                                        $search.slideDown("fast").find('input').focus();

                                } else {
                                        $btn.removeClass('active');
                                        $search.slideUp("fast");

                                }
                        });




                        /* mobile menu */
                        $("<div></div>").attr('id', 'mobile-menu').prependTo('body');

                        $('#main-menu').clone().attr({
                                'class': 'slimmenu',
                                'id': 'slimmenu'
                        }).prependTo('#mobile-menu');

                        $('#slimmenu').slimmenu(
                                {
                                        resizeWidth: '1078',
                                        /*collapserTitle: $('#mobile-menu-title').html(),*/
                                        /*collapserTitle: '<div style="text-align:center;"><?php echo $logo ?></div>',*/
                                        collapserTitle: '',
                                        animSpeed: 'medium',
                                        indentChildren: true,
                                        childrenIndenter: '&raquo; '
                                }
                        );

                        $('#mobile-menu .menu-collapser').prepend($('#mobile-menu-title').css('display', 'block'));



                });
        </script>
        <?php
}
?>