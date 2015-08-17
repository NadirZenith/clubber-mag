<?php

/*
 * Nz Document Outliner
 *
 * Plugin Name: Nz Document Outliner
 * Plugin URI:  https://www.nzlabs.es
 * Description: creates a top bar button to outline current page
 * Version:     0.1
 * Author:      Nadir Zenith
 * Author URI:  https://www.nzlabs.es
 * License:     MIT
 * Copyright:   2015 nzlabs
 *
 * Text Domain: nz-doc-outliner
 * Domain Path: /languages/
 */
/**
 * Description of nz-doc-outliner
 *
 * @author tino
 */
class NzDocOutliner
{
    private $version = '0.1';

    public function __construct()
    {
        $this->addFilter();

        $this->enqueue_assets();
    }

    public function enqueue_assets()
    {

        add_action('wp_enqueue_scripts', [$this, 'include_styles']);
        add_action('wp_enqueue_scripts', [$this, 'include_scripts']);
    }

    public function include_styles()
    {
        wp_enqueue_style('nz-doc-ouliner-plugin', plugins_url('/assets/css/nz-doc-outliner.css', __FILE__));
    }

    public function include_scripts()
    {
        wp_enqueue_script('nz-doc-outliner', plugins_url('/assets/js/dist/outliner.min.js', __FILE__), [], $this->version, true);
        wp_enqueue_script('nz-doc-outliner-plugin', plugins_url('/assets/js/nz-doc-outliner.js', __FILE__), ['nz-doc-outliner', 'jquery'], $this->version, true);

        /* wp_enqueue_script('nz-doc-ouliner'); */
        /* wp_enqueue_script('nz-doc-ouliner-plugin'); */
    }

    private function addFilter()
    {
        add_action('admin_bar_menu', [$this, 'outliner_menu'], 1060);
    }

    public function outliner_menu($wp_admin_bar)
    {
        $args = array(
            'id' => 'nz-doc-outliner',
            'title' => 'Outliner',
            'meta' => array('class' => 'nz-doc-outliner')
        );
        $wp_admin_bar->add_node($args);
    }
//put your code here
}

new NzDocOutliner();

/*
function my_scripts_method() {
	wp_enqueue_script(
		'newscript',
		plugins_url( '/js/newscript.js' , __FILE__ ),
		array( 'scriptaculous' )
	);
}

add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
 */