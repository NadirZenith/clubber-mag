<?php

/**
 * The plugin bootstrap file
 *
 * @link              http://nadirzenith.net
 * @since             1.0.0
 * @package           Nz_Wp_Newsletter
 *
 * @wordpress-plugin
 * Plugin Name:       NzWpNewsletter
 * Plugin URI:        http://nadirzenith.net/wp/plugins/nzwpnewsletter
 * Description:       Capture emails
 * Version:           1.0.0
 * Author:            NadirZenith
 * Author URI:        http://nadirzenith.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nzwpnewsletter
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'wizard.php';
require plugin_dir_path(__FILE__) . 'lib/Mailchimp/Mailchimp.php';
require plugin_dir_path(__FILE__) . 'lib/NzWpOptionsPage.php';
require plugin_dir_path(__FILE__) . 'lib/OptionsPage.php';
require plugin_dir_path(__FILE__) . 'NzWpNewsletter.php';

add_action('plugins_loaded', 'nzwpnewsletter_load_textdomain');

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function nzwpnewsletter_load_textdomain()
{
    load_plugin_textdomain('nzwpnewsletter', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
