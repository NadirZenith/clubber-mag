<?php
if (WP_ENV === 'development') {
    define('SOUNDCLOUD_CLIENT_ID', 'c8ca096c652b8c84856ef241d6e56ab3'); // facebook app id development
} else {
    define('SOUNDCLOUD_CLIENT_ID', 'c8ca096c652b8c84856ef241d6e56ab3'); // facebook app id
}

//SECRET
//093d3a754cb45c7c9791b4709c0c714f
function nz_soundcloud_sdk_output()
{
    ?>
    <script src="//connect.soundcloud.com/sdk.js" ></script>
    <script>
        SC.initialize({
            client_id: '<?php echo SOUNDCLOUD_CLIENT_ID ?>'
        });
    </script>

    <?php if (false) { //optional    ?>

        <script>
            var track_url = 'http://soundcloud.com/forss/flickermood';
            SC.oEmbed(track_url, {auto_play: true}, function (oEmbed) {
                console.log('oEmbed response: ' + oEmbed);
            });
        </script>

    <?php } ?>

    <?php
}
if (SOUNDCLOUD_CLIENT_ID) {
    add_action('base_after_body', 'nz_soundcloud_sdk_output', 10);
}

add_shortcode('nz-soundcloud', 'nz_soundcloud_shortcode');

function nz_soundcloud_shortcode($atts, $content = null)
{

}

function nz_get_soundcloud_iframe($uri, $args = array())
{
    $defaults = array(
        'width' => '100',
        'height' => '166',
        'scrolling' => 'no',
        'color' => '0583F2',
        'frameborder' => 'yes',
        'auto_play' => false,
        'visual' => false
    );

    $args = wp_parse_args($args, $defaults);

    $visual = ($args['visual']) ? '&amp;visual=true' : '';
    $autoplay = ($args['auto_play']) ? '&amp;auto_play=true' : '';

    $content =  '<iframe class="nz-sciframe" '
        . 'width="' . $args['width'] . '" '
        . 'height="' . $args['height'] . '" '
        /*. 'scrolling="' . $args['scrolling'] . '" '*/
        /*. 'frameborder="' . $args['frameborder'] . '" '*/
        . 'src="https://w.soundcloud.com/player/?url=' . $uri . '&amp;color=' . $args['color'] . $visual . $autoplay . '"'
        . '></iframe>';



    return $content;
}
