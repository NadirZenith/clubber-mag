<?php
if (WP_ENV === 'development') {
    define('FACEBOOK_APP_ID', '1549701461914029'); // facebook app id development
} else {
    define('FACEBOOK_APP_ID', '1467286160155560'); // facebook app id 
}

function nz_facebook_sdk_output()
{
    ?>
    <div id="fb-root"></div>

    <script type="text/javascript">
        window.fbAsyncInit = function () {
            FB.init({
                appId: '<?php echo FACEBOOK_APP_ID ?>',
                xfbml: true,
                /*version: 'v1.0'*/
                version: 'v2.2'
            });

        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/es_LA/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

    <?php if (false) { //has fb login test user status  ?>
            window.onload = function () {
                alert('load');
                FB.getLoginStatus(function (response) {
                    alert('response');
                    NZ = (window.NZ) ? NZ : {};
                    NZ.fb = (window.NZ.fb) ? NZ.fb : {};
                    NZ.fb.status = response.status;
                    console.log(response);

                });
            };
    <?php } ?>
    </script> 
    <?php
}
/*
 */
if (FACEBOOK_APP_ID) {
    add_action('base_after_body', 'nz_facebook_sdk_output', 10);
}

/**
 *    see https://developers.facebook.com/docs/plugins/like-button/
 */
function nz_fb_like_iframe($url = null)
{
    $url = ($url) ? $url : get_permalink();
    if (FACEBOOK_APP_ID && $url) {
        $url = urlencode($url);
        $content = '<div class="nz-fblike-iframe">'
            . '<iframe src="//www.facebook.com/plugins/like.php?href=' . $url . '&amp;width=100&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21&amp;appId=' . FACEBOOK_APP_ID . '" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe>'
            . '</div>';
        /* $content = '<h1>asdf</h1>'; */
        return $content;
    }
}

function nz_fb_like($url = null, $options = array())
{
    $url = ($url) ? $url : get_permalink();
    $atts = array_merge(
        array(
        //standard, button_count, button, box_count
        'layout' => 'button_count',
        'action' => 'like', //recommend
        'show-faces' => 'true',
        'colorscheme' => 'light',
        'share' => 'false',
        'width' => 200
        ), $options
    );
    $content = '<div class="nz-fblike">'
        . '<div class="fb-like" data-href="' . $url . '" '
        . 'data-layout="' . $atts['layout'] . '" '
        . 'data-like="' . $atts['like'] . '" '
        . 'data-show-faces="' . $atts['show-faces'] . '" '
        . 'data-share="' . $atts['share'] . '" '
        . 'data-width="' . $atts['width'] . '" >'
        . '</div></div>';

    return $content;
}

function nz_fb_like_box($url = null, $atts = array())
{

    if (FACEBOOK_APP_ID && $url) {

        $atts = array_merge(
            array(
            'colorscheme' => 'light',
            'show-faces' => 'true',
            'header' => 'false',
            'stream' => 'FALSE',
            'width' => '300', //min is 292 default is 300
            'height' => '300',
            'show-border' => 'FALSE'
            ), $atts
        );
        $atts['colorscheme'] = ( in_array($atts['colorscheme'], array('light', 'dark'))) ? $atts['colorscheme'] : 'light';
        $content = '<div class="nz-fblikebox">'
            . '<div class="fb-like-box" '
            . 'data-href="' . $url . '" '
            . 'data-colorscheme="' . $atts['colorscheme'] . '" '
            . 'data-show-faces="' . $atts['show-faces'] . '" '
            . 'data-header="' . $atts['header'] . '" '
            . 'data-stream="' . $atts['stream'] . '" '
            . 'data-width="' . $atts['width'] . '" '
            . 'data-height="' . $atts['height'] . '" '
            . 'data-show-border="' . $atts['show-border'] . '">'
            . '</div></div>';
    }

    return $content;
}

function nz_fb_sharer($url = null, $atts = array())
{
    $url = ($url) ? $url : get_permalink();
    if (FACEBOOK_APP_ID && $url) {
        /*
         * box_count", "button_count", "button", "link", "icon_link", or "icon".
         */
        $atts = array_merge(
            array(
            'layout' => 'button_count',
            'width' => null,
            ), $atts
        );

        $content = '<div class="nz-fbsharebutton">'
            . '<div class="fb-share-button" '
            . 'data-href="' . $url . '" '
            . 'data-layout="' . $atts['layout'] . '" '
            . 'data-width="' . $atts['width'] . '">'
            . '</div></div>';
        return $content;
    }
}

function nz_fb_comments($url = null, $atts = array())
{
    $url = ($url) ? $url : get_permalink();
    if (FACEBOOK_APP_ID && $url) {
        /*
         * box_count", "button_count", "button", "link", "icon_link", or "icon".
         */
        $atts = array_merge(
            array(
            'layout' => 'box_count',
            'numposts' => 5,
            'width' => '100%',
            /* 'colorscheme' => 'dark' */
            'colorscheme' => 'light'
            ), $atts
        );

        $content = '<div class="nz-fbcomments">'
            . '<div class="fb-comments" '
            . 'data-href="' . $url . '" '
            . 'data-width="' . $atts['width'] . '" '
            . 'data-numposts="' . $atts['numposts'] . '" '
            . 'data-colorscheme="' . $atts['colorscheme'] . '">'
            . '</div></div>';

        return $content;
    }
}

function nz_fb_send($url = null, $atts = array())
{

    $url = ($url) ? $url : get_permalink();
    if (FACEBOOK_APP_ID && $url) {

        $atts = array_merge(
            array(
            'kid_directed_site' => 'true',
            'width' => '100%',
            'colorscheme' => 'light'
            ), $atts
        );

        $content = '<div class="nz-fbsend">'
            . '<div class="fb-send" '
            . 'data-href="' . $url . '" '
            . 'data-colorscheme="' . $atts['colorscheme'] . '" '
            . 'data-kid_directed_site="' . $atts['kid_directed_site'] . '" >'
            . '</div></div>';

        return $content;
    }
}
add_shortcode("nz_fb_like", "nz_fb_like_shortcode");

function nz_fb_like_shortcode($atts, $content = null)
{

    return $content . nz_fb_like('https://www.facebook.com/Clubber.Mag');
}
add_shortcode("nz_fb_like_box", "nz_fb_like_box_shortcode");

function nz_fb_like_box_shortcode($atts, $content = null)
{
    return $content . nz_fb_like_box($atts['url'], $atts);
}
