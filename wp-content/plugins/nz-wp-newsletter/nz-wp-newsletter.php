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
 * Text Domain:       nz-wp-newsletter
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
/* require plugin_dir_path(__FILE__) . 'wizard.php'; */
include_once __DIR__ . '/wizard.php';
new NzWpNewsletterWizard(__FILE__);

require plugin_dir_path(__FILE__) . 'NzWpNewsletter.php';

add_action('plugins_loaded', 'myplugin_load_textdomain');

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function myplugin_load_textdomain()
{
    load_plugin_textdomain('nz-wp-newsletter', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
