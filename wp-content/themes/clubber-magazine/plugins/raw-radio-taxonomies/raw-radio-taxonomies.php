<?php

/*
  Plugin Name: raw radio taxonomies
  Plugin URI:
  Description: Use radio buttons for any taxonomy
  Version: 0.1
  Text Domain: raw-radio-taxonomies
  Author: Nadir Zenith
  Author URI: http://www.slice.com.es
  License: GPL2


  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

 */

if (!defined('ABSPATH'))
      exit; // Exit if accessed directly


if (!class_exists('RawRadioTaxonomies')) :

      class RawRadioTaxonomies {

            /**
             * @var RawRadioTaxonomies The single instance of the class
             * @since 1.6
             */
            protected static $_instance = null;

            /**
             * Main WooCommerce Instance
             *
             * Ensures only one instance of WooCommerce is loaded or can be loaded.
             *
             * @since 1.6
             * @static
             * @see Radio_Buttons_for_Taxonomies()
             * @return RawRadioTaxonomies - Main instance
             */
            public static function instance() {
                  if (is_null(self::$_instance)) {
                        self::$_instance = new self();
                  }
                  return self::$_instance;
            }

            /**
             * Cloning is forbidden.
             *
             * @since 1.6
             */
            public function __clone() {
                  _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), '1.6');
            }

            /**
             * Unserializing instances of this class is forbidden.
             *
             * @since 1.6
             */
            public function __wakeup() {
                  _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), '1.6');
            }

            /**
             * RawRadioTaxonomies Constructor.
             * @access public
             * @return Radio_Buttons_for_Taxonomies
             * @since  1.0
             */
            public function __construct() {

                  // Include required files
                  include_once( 'inc/class.WordPress_Radio_Taxonomy.php' );
                  include_once( 'inc/class.Walker_Category_Radio.php' );

                  // Set-up Action and Filter Hooks
                  register_uninstall_hook(__FILE__, array(__CLASS__, 'delete_plugin_options'));

                  // load plugin text domain for translations
                  add_action('plugins_loaded', array($this, 'load_text_domain'));

                  // launch each taxonomy class on a hook
                  add_action('init', array($this, 'launch'), 99);

                  // register admin settings
                  add_action('admin_init', array($this, 'admin_init'));

                  // add plugin options page
                  add_action('admin_menu', array($this, 'add_options_page'));

                  // Load admin scripts
                  add_action('admin_enqueue_scripts', array($this, 'admin_script'));

                  // add settings link to plugins page
                  add_filter('plugin_action_links', array($this, 'add_action_links'), 10, 2);
            }

            /**
             * Delete options table entries ONLY when plugin deactivated AND deleted
             * @access public
             * @return void
             * @since  1.0
             */
            public function delete_plugin_options() {
                  $options = get_option('raw_radio_taxonomies_options', true);
                  if (isset($options['delete']) && $options['delete'])
                        delete_option('raw_radio_taxonomies_options');
            }

            /**
             * Make plugin translation-ready
             * @access public
             * @return void
             * @since  1.0
             */
            public function load_text_domain() {
                  load_plugin_textdomain("raw-radio-taxonomies", false, dirname(plugin_basename(__FILE__)) . '/languages/');
            }

            /**
             * Create a class property for each taxonomy that we are converting to radio buttons, ex: $this->categories
             * @access public
             * @return object
             * @since  1.0
             */
            public function launch() {

                  $options = get_option('raw_radio_taxonomies_options', true);

                  if (isset($options['taxonomies'])) {

                        foreach ($options['taxonomies'] as $taxonomy) {

                              if (taxonomy_exists($taxonomy)) {
                                    $this->{$taxonomy} = new WordPress_Radio_Taxonomy($taxonomy);
                              }
                        }
                  }
            }

            // ------------------------------------------------------------------------------
            // Admin options
            // ------------------------------------------------------------------------------

            /**
             * Whitelist plugin options
             * @access public
             * @return void
             * @since  1.0
             */
            public function admin_init() {
                  register_setting('raw_radio_taxonomies_options', 'raw_radio_taxonomies_options', array($this, 'validate_options'));
            }

            /**
             * Add plugin's options page
             * @access public
             * @return void
             * @since  1.0
             */
            public function add_options_page() {
                  add_options_page(__('Radio for Taxonomies Options Page', "raw-radio-taxonomies"), __('Radio Buttons for Taxonomies', "raw-radio-taxonomies"), 'manage_options', 'raw-radio-taxonomies', array($this, 'render_form'));
            }

            /**
             * Render the Plugin options form
             * @access public
             * @return void
             * @since  1.0
             */
            public function render_form() {
                  include( 'inc/plugin-options.php' );
            }

            /**
             * Sanitize and validate options
             * @access public
             * @param  array $input
             * @return array
             * @since  1.0
             */
            public function validate_options($input) {

                  $clean = array();

                  //probably overkill, but make sure that the taxonomy actually exists and is one we're cool with modifying
                  $args = array(
                      'public' => true,
                      'show_ui' => true
                  );

                  $taxonomies = get_taxonomies($args);

                  if (isset($input['taxonomies']))
                        foreach ($input['taxonomies'] as $tax) {
                              if (in_array($tax, $taxonomies))
                                    $clean['taxonomies'][] = $tax;
                        }

                  $clean['delete'] = isset($input['delete']) && $input['delete'] ? 1 : 0;  //checkbox

                  return $clean;
            }

            /**
             * Enqueue Scripts
             * @access public
             * @return void
             * @since  1.0
             */
            public function admin_script() {

                  $options = get_option('raw_radio_taxonomies_options', true);

                  if (!isset($options['taxonomies']))
                        return;

                  if (function_exists('get_current_screen')) {

                        $screen = get_current_screen();

                        /*if (!is_wp_error($screen) && in_array($screen->base, array('edit', 'post')))*/
                              /*wp_enqueue_script('radiotax', plugins_url('js/radiotax.js', __FILE__), array('jquery'), null, true);*/
                  }
            }

            /**
             * Display a Settings link on the main Plugins page
             * @access public
             * @param  array $links
             * @param  string $file
             * @return array
             * @since  1.0
             */
            public function add_action_links($links, $file) {

                  if ($file == plugin_basename(__FILE__)) {
                        $plugin_link = '<a href="' . admin_url('options-general.php?page=raw-radio-taxonomies') . '">' . __('Settings') . '</a>';
                        // make the 'Settings' link appear first
                        array_unshift($links, $plugin_link);
                  }

                  return $links;
            }

      }

      // end class
endif;

/**
 * Launch the whole plugin
 * Returns the main instance of WC to prevent the need to use globals.
 *
 * @since  1.6
 * @return WooCommerce
 */
function Raw_Radio_Taxonomies() {
      return RawRadioTaxonomies::instance();
}

// Global for backwards compatibility.
$GLOBALS['Raw_Radio_Taxonomies'] = Raw_Radio_Taxonomies();
