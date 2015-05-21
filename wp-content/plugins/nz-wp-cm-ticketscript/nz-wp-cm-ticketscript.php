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
    static function get_ticket_script($id = null)
    {

        $type = 'iframe'; //popup
        //$type = 'popup'; //popup
        $channel = "LSSX45SZ";
        $language = 'es';
        ?>
        <div id="ts-shop"></div>
        <script type="text/javascript">

            var Ticketscript = {};
            Ticketscript.Application = {
                containerId: "ts-shop",
                channel: "<?php echo $channel; ?>",
                eventId: "<?php echo $id; ?>",
                type: "<?php echo $type ?>",
                language: "<?php echo $language; ?>",
                width: "500",
                height: "600"
            };
        </script>
        <script type="text/javascript" src="https://shop.ticketscript.com/assets/js/ga-embed.js"></script>
        <?php
    }

    static function mobile_iframe($id = null)
    {
        /*
          <script language="javascript" type="text/javascript">
          function resizeIframe(obj) {
          obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
          }
          </script>
         */
        ?>
        <style>
            .ts-mobile-iframe{
                width: 100%;
                min-height: 300px;
            }
        </style>
        <iframe name="ts-mobile-iframe" class="ts-mobile-iframe" 
                src="https://m.ticketscript.com/channel/web2/get-dates/rid/LSSX45SZ/eid/254478/language/es" 
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
