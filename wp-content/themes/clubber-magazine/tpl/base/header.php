<div id="branding" class="fl hide show-md">
    <h1>
        <span>Clubber-Mag</span>
        <a href="<?php echo esc_url(home_url('/')); ?>" title="Clubber-Mag" rel="home" >
            <img src="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/assets/images/clubber-mag.png" alt="Clubber-Mag">
        </a>	
    </h1>
</div>

<div id="social-area-top">
    <?php
    $socials = array(
        'facebook' => array(
            'url' => 'https://www.facebook.com/Clubber.Mag',
        ),
        'twitter' => array(
            'url' => 'https://www.twitter.com/clubbermag',
        ),
        'instagram' => array(
            'url' => 'https://www.instagram.com/clubbermagazine',
        ),
        'youtube' => array(
            'url' => 'https://www.youtube.com/channel/UCOC8TKzHI985Nn-sAGIDKFw',
        ),
        'soundcloud' => array(
            'url' => 'https://soundcloud.com/clubber-magazine',
        ),
        'google-plus' => array(
            'url' => 'https://plus.google.com/+Clubbermagazine',
        ),
    );
    ?>
    <?php nz_fa_social_icons($socials, 'social-icons-top social-icons'); ?>

    <?php echo nz_fb_like_iframe('https://www.facebook.com/Clubber.Mag'); ?>

</div>

<div id="top-banner"> 
    <?php echo do_shortcode('[sam id=1]'); ?>
</div>

<?php
/**
 *  ################ BETA
 */
if (current_user_can('manage_options')) {
    ?>
    <style>
        #desktop-menu{
            background-color: #c4c4c4;

        }
        #desktop-menu.static-menu{
            top: 0px;
            position: fixed;
            background-color: #ddd;
            z-index: 10000000;
            width: 100%;

            -webkit-transition: background-color 500ms linear;
            -moz-transition: background-color 500ms linear;
            -o-transition: background-color 500ms linear;
            -ms-transition: background-color 500ms linear;
            transition: background-color 500ms linear;
        }

        .static-menu #main-menu li{
            opacity: 1;
        }

        .static-menu #main-menu > li:not(.menu-search):not(.menu-ticketscript):not(.menu-connect){

            visibility: hidden;
            opacity: 0;
            -webkit-transition: all 500ms linear;
            -moz-transition: all 500ms linear;
            -o-transition: all 500ms linear;
            -ms-transition: all 500ms linear;
            transition: all 500ms linear;
        }
    </style>
    <script>
        $(function () {

            var windowWidth = $(window).width();

            if (windowWidth < 1280) {
                return;
            }

            var $el = $('#desktop-menu');

            var $promo = $el.wrap($('<div></div>').css({height: $el.css('height')}));

            var waypoint = new Waypoint({
                element: document.getElementById('access'),
                handler: function (direction) {
                    if (direction === 'down') {
                        $promo.addClass('static-menu');
                    } else {
                        $promo.removeClass('static-menu');
                    }
                }
            });

        });

    </script>
    <?php
}
/**
 * END ################ BETA
 */
?>

<nav id="access" class="cb hide show-md">
    <div id="desktop-menu" class="group">
        <?php
        $args = array(
            'theme_location' => 'primary',
            'container' => '',
            'items_wrap' => '<ul id="main-menu" >%3$s</ul>'
        );
        ?>
        <?php wp_nav_menu($args); ?>
    </div>
</nav>

<div id="mobile-menu-title">
    <div class="logo" >
        <a href="<?php echo esc_url(home_url('/')); ?>" title="Clubber-Mag" rel="home">
            <img width="200" style="margin-left: -3px;" alt="Clubber-Mag" src="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/assets/images/clubber-mag-inline.png">
        </a>
    </div>
    <div id="open-search-bar">
        <i class="fa fa-search sc-eee"></i>
    </div>
    <div class="search-form">
        <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
            <input type="text" placeholder="<?php _e('Search for parties, clubs, artists...', 'cm'); ?>" class="s field sf-2" name="s" value="<?php echo get_query_var('s', '') ?>">
        </form>
    </div>
</div>