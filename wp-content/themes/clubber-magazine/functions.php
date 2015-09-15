<?php
/**
 * Clubber Mag constants, adding files and WordPress core functionality.
 *
 * Defining some constants, loading all the required files and Adding some core functionality.
 *
 * package ClubberMag
 * since ClubberMag 1.0
 */
/* --------------------------- */

define('CM_LIB_DIR', '/lib');
define('CM_ADDONS_DIR', '/lib/nz/add-ons');
define('CM_MODELS_DIR', '/models');

//pages
define('CM_RESOURCE_EVENT_PAGE_ID', 406);
define('CM_CONNECT_PAGE_ID', 675);
define('CM_RESOURCE_MAIN_PAGE_ID', 2610);
define('CM_RESOURCE_ARTIST_PAGE_ID', 4912);
define('CM_RESOURCE_LABEL_PAGE_ID', 4913);
define('CM_RESOURCE_COOLPLACE_PAGE_ID', 4914);
define('CM_RESOURCE_COOLPLACE_FAST_PAGE_ID', 4915);
define('CM_RESOURCE_PODCAST_PAGE_ID', 4916);
define('CM_TICKETSCRIPT_PAGE_ID', 7521);
//\pages
//metafields
define('CM_META_MAPA', 'coolplace_mapaddress');
define('CM_META_SOUNDCLOUD', 'soundcloud_url');

//user meta
define('CM_USER_META_RESOURCE_ID', 'main_resource_id');
//\metafields
/**
 * Roots includes
 *
 * The $roots_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/roots/pull/1042
 */
$roots_includes = array(
    'vendor/autoload.php',
    'lib/soil/soil.php',
    'lib/config.php',
    'lib/utils.php',
    'lib/api.php',
    'lib/nav.php',
    'lib/wrapper.php',
    'lib/assets.php',
    'lib/sidebar.php',
    'lib/queries.php',
    'lib/nz/widgets/widget-soundcloud.php',
    'lib/nz/widgets/widget-calendar.php',
    'lib/nz/widgets/widget-relate.php',
    'lib/nz/widgets/widget-cm-lists.php',
    'lib/nz/widgets/widget-share.php',
    'lib/nz/widgets/widget-fb-like-box.php',
    /* 'lib/nz/widgets/widget-newsletter.php', */
    'lib/nz/shortcodes/shortcode-soundcloud.php',
    'lib/nz/social/social-icons-list.php',
    'lib/nz/social/facebook-config.php',
    'lib/nz/social/soundcloud-config.php',
    'lib/nz/social/twitter-config.php',
    'lib/nz/social/sharer.php',
    /** CLUBBER POST TYPES      */
    CM_MODELS_DIR . '/user.php',
    CM_MODELS_DIR . '/menu.php',
    CM_MODELS_DIR . '/artist.php',
    CM_MODELS_DIR . '/label.php',
    CM_MODELS_DIR . '/cool-place.php',
    CM_MODELS_DIR . '/event.php',
    CM_MODELS_DIR . '/music.php',
    CM_MODELS_DIR . '/video.php',
    CM_MODELS_DIR . '/photo.php',
    CM_MODELS_DIR . '/page.php',
    CM_MODELS_DIR . '/news.php',
    CM_MODELS_DIR . '/podcast.php',
    CM_MODELS_DIR . '/pages/recursos.php', // Page recursos specific queries
    CM_MODELS_DIR . '/pages/festivals.php', // Page festivals queries
    'lib/nz/lib/nzsession.php',
    //forms /login /register
    'lib/nz/lib/nz-wp-form/nz-wp-forms.php', //forms to be replaced
    //
    /** CLUBBER add-ons      */
    CM_ADDONS_DIR . '/nz-start-msgs/NzStartMsgs.php',
    CM_ADDONS_DIR . '/location-taxonomy/contry-list.php', //tax tools cm specific
    CM_ADDONS_DIR . '/col-shortcodes/col-shortcodes.php', //shortcodes cm specific()
    CM_ADDONS_DIR . '/todo-pending-posts.php',
    CM_ADDONS_DIR . '/query-functions.php', //artist archive filter
    CM_ADDONS_DIR . '/language-selector.php', //to be removed by plugin localization
    /* 'tpl/shortcodes/layout-shortcodes.php' */
);

foreach ($roots_includes as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'roots'), $file), E_USER_ERROR);
    }

    require_once $filepath;
}
unset($file, $filepath);


global $nzwpnewsletter;

if (isset($nzwpnewsletter)) {
    $nzwpnewsletter->setFormTemplate(__DIR__ . '/tpl/home/newsletter.php');
    /* d($nzwpnewsletter); */
}



/* add_filter('wpseo_breadcrumb_output', 'mc_microdata_breadcrumb'); */

function mc_microdata_breadcrumb($link_output)
{
    /* d($link_output); */
    /* $link_output = preg_replace(array('#<span xmlns:v="http://rdf.data-vocabulary.org/\#">#', '#<span typeof="v:Breadcrumb"><a href="(.*?)" .*?' . '>(.*?)</a></span>#', '#<span typeof="v:Breadcrumb">(.*?)</span>#', '# property=".*?"#', '#</span>$#'), array('', '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="$1" itemprop="url"><span itemprop="title">$2</span></a></span>', '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">$1</span></span>', '', ''), $link_output); */
    $link_output = preg_replace(array(
        '#<span xmlns:v="http://rdf.data-vocabulary.org/\#">#',
        '#<span typeof="v:Breadcrumb"><a href="(.*?)" .*?' . '>(.*?)</a></span>#',
        '#<span typeof="v:Breadcrumb">(.*?)</span>#',
        '# property=".*?"#', '#</span>$#'
        ), array('',
        '<div prefix="v: http://rdf.data-vocabulary.org/#"> | <a href="$1" property="v:url" > <span property="v:title">$2</span> </a> </div>',
        /* '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="$1" itemprop="url"><span itemprop="title">$2</span></a></span>', */
        '<span prefix="v: http://rdf.data-vocabulary.org/#"><span property="v:title">$1</span></span>',
        '',
        ''
        ), $link_output);

    return $link_output;
    /*
     * <span typeof="v:Breadcrumb">
     * <a href="http://nz.lab/clubber-mag-dev" rel="v:url" property="v:title">Home</a> »
     *  <span rel="v:child" typeof="v:Breadcrumb">
     * <a href="http://nz.lab/clubber-mag-dev/agenda/" rel="v:url" property="v:title">Eventos</a> 
     * » <span class="breadcrumb_last">Club4 Pres. Nastia, Luca Fabiani</span>
     * </span>
     * </span>
     */
    /**
     * <span xmlns:v="http://rdf.data-vocabulary.org/#">
     *      <span typeof="v:Breadcrumb">
     *          <a href="http://nz.lab/clubber-mag-dev" rel="v:url" property="v:title">Home</a>
     *          <span rel="v:child" typeof="v:Breadcrumb">
     *              <a href="http://nz.lab/clubber-mag-dev/agenda/" rel="v:url" property="v:title">Eventos</a>
     *              <span class="breadcrumb_last">Club4 Pres. Nastia, Luca Fabiani</span>
     *          </span>
     *      </span>
     * </span>
     * 
     * 
     * <div prefix="v: http://rdf.data-vocabulary.org/#">
     *   <span typeof="v:Breadcrumb">
     *       <a property="v:url" href="http://www.bellavou.co.uk/">
     *           <span property="v:title">Home</span>
     *       </a>
     *   </span>
     *   <span typeof="v:Breadcrumb">
     *       <a property="v:url" href="http://www.bellavou.co.uk/contact-us/">
     *           <span property="v:title">Contact Us</span>
     *       </a>
     *   </span>
     * </div>
     */
}

function cm_tinymce_filter_heading($arr)
{
    $arr['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4';
    return $arr;
}
add_filter('tiny_mce_before_init', 'cm_tinymce_filter_heading');

function cm_render_google_map($post_id, $direction = false)
{
    if (!$post_id) {
        return;
    }

    $map_data = get_post_meta($post_id, CM_META_MAPA, true);
    $json_mapa = json_decode($map_data, true);

    if (!isset($json_mapa, $json_mapa['type'])) {
        return;
    }

    if ($json_mapa['type'] == 'map' && isset($json_mapa['components']['lat'], $json_mapa['components']['lng'])) {
        ?>  

        <div class="cm-map m15">
            <script>
                jQuery(document).ready(function ($) {

                    function nz_map(id, lat, lng, options) {
                        var myLatlng = new google.maps.LatLng(lat, lng);

                        var mapOptions = {
                            zoom: 13,
                            center: myLatlng
                        };

                        $.extend(mapOptions, options);

                        var map = new google.maps.Map(document.getElementById(id), mapOptions);

                        var marker = new google.maps.Marker({
                            position: myLatlng,
                            map: map,
                            title: '<?php echo get_the_title($post_id) ?>'
                        });

                    }


                    google.maps.event.addDomListener(window, 'load', function () {
                        nz_map('map-canvas',
        <?php echo $json_mapa['components']['lat'] ?>,
        <?php echo $json_mapa['components']['lng'] ?>,
                                {
                                    zoom: 15
                                }
                        );
                    });

                });

            </script>
            <div id="map-canvas" class="map-canvas"></div>

            <?php if ($direction) { ?>
                <div class="map-address tc">
                    <?php echo $json_mapa['components']['formatted_address'] ?>
                </div>
            <?php } ?>
        </div>
        <?php
    } elseif ($json_mapa['type'] == 'raw') {
        if ($direction) {
            ?>
            <div class="map-address tc">
                <?php echo $json_mapa['components']['address'] ?>
            </div>
            <?php
        }
    }
}

function cm_render_video($url, array $options = array())
{
    $shortcode = ' [embed width="640" height="390"]' . $url . '[/embed]';

    global $wp_embed;

    $output = $wp_embed->run_shortcode($shortcode);

    $output = str_replace([
        'frameborder="0"',
        'webkitallowfullscreen',
        'mozallowfullscreen'
        ], [
        '',
        '',
        ''
        ], $output);

    return $output;
}
