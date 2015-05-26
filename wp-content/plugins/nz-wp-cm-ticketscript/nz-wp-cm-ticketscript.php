<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://nadirzenith.net
 * @since             1.0.0
 * @package           Nz_Wp_Cm_TicketScript
 *
 * @wordpress-plugin
 * Plugin Name:       NzWpCmTicketscript
 * Plugin URI:        http://nadirzenith.net/wp/plugins/NzWpCmTicketscript
 * Description:       Work with ticketscript
 * Version:           1.0.0
 * Author:            NadirZenith
 * Author URI:        http://nadirzenith.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nz-wp-cm-ticketscript
 * Domain Path:       /languages
 */
class NzWpCmTicketscript
{

    function __construct($post_types)
    {
        $this->_load_dependencies();
        new NzWpCmTicketscriptMetaBox($post_types);
    }

    private function _load_dependencies()
    {
        include_once __DIR__ . '/meta_box.php';
    }

    /**
     *     
     * @param string $channel Channel id
     * @param int $id Event id
     * @param string $type Iframe / Popup
     * @param string $lang Language
     */
    static function get_web_iframe($channel, $id = null, $options = array())
    {
        $options = wp_parse_args($options, [
            'type' => 'iframe', //popup
            'lang' => 'en',
            'width' => 550,
            'height' => 600
        ]);
        ?>
        <div id="ts-shop"></div>
        <script type="text/javascript">

            var Ticketscript = {};
            Ticketscript.Application = {
                containerId: "ts-shop",
                channel: "<?php echo $channel; ?>",
                eventId: "<?php echo $id; ?>",
                type: "<?php echo $options['type'] ?>",
                language: "<?php echo $options['lang'] ?>",
                width: "<?php echo $options['width'] ?>",
                height: "<?php echo $options['height'] ?>"
            };
        </script>
        <script type="text/javascript" src="https://shop.ticketscript.com/assets/js/ga-embed.js"></script>
        <?php
    }

    static function get_mobile_iframe($channel, $id = null, $options = array())
    {
        /*
          <script language="javascript" type="text/javascript">
          function resizeIframe(obj) {
          obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
          }
          </script>
          src="https://m.ticketscript.com/channel/web2/get-dates/rid/LSSX45SZ/eid/254478/language/es"
         * 
          <script language="javascript" type="text/javascript">
          function resizeIframe(obj) {
          obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
          alert('loaded');
          }
          </script>
          <iframe name="ts-mobile-iframe" height="1000" width="500" src="https://m.ticketscript.com/channel/web2/get-dates/rid/LSSX45SZ/eid/254478/language/es"
          frameborder="0"
          scrolling="no"
          seamless="seamless"
          onload="resizeIframe(this);"
          >

          </iframe>

         */
        $options = wp_parse_args($options, [
            'type' => 'iframe', //popup
            'lang' => 'en',
            'height' => '600px'
        ]);
        $url = 'https://m.ticketscript.com/channel/web2/get-dates/rid/' . $channel;

        if ($id) {
            $url .= '/eid/' . $id;
        }

        $url.='/language/' . $options['lang']
        ?>
        <style>
            .ts-mobile-iframe{
                width: 100%;
                min-height: <?php echo $options['height'] ?>;
            }
        </style>
        <iframe name="ts-mobile-iframe" class="ts-mobile-iframe" 
                src="<?php echo $url ?>" 
                frameborder="0" 
                seamless="seamless"
                >
        </iframe>
        <?php
        /*
          scrolling="no"
          onload="resizeIframe(this);"
          width="480"
          height="500"

         */
    }
}

new NzWpCmTicketscript(
    array('agenda')
);
