<?php

/**
 * Theme wrapper
 *
 * @link http://roots.io/an-introduction-to-the-roots-theme-wrapper/
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */
function roots_template_path()
{
    return Roots_Wrapping::$main_template;
}

function roots_sidebar_path()
{
    return new Roots_Wrapping('sidebar.php');
}
/*
 * Class responsible for wrapping templates
 */
add_filter('template_include', array('Roots_Wrapping', 'wrap'), 99);
class Roots_Wrapping
{
    static $raw = false;
    // Stores the full path to the main template file
    static $main_template;
    // Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
    static $base;

    public function __construct($template = 'base.php')
    {
        $this->slug = basename($template, '.php'); //base
        $this->templates = array($template);

        if (self::$base) {
            $str = substr($template, 0, -4);
            array_unshift($this->templates, sprintf($str . '-%s.php', self::$base));
        }
    }

    public function __toString()
    {

        $this->templates = apply_filters('roots/wrap_' . $this->slug, $this->templates);

        return locate_template($this->templates);
    }

    static function wrap($main)
    {
        self::$main_template = $main;
        self::$base = basename(self::$main_template, '.php'); //?page-recursos, front-page, archive-agenda

        if (self::$base === 'index') {
            self::$base = false;
        }

        return new Roots_Wrapping();
    }
}

//return only content in fancybox calls
add_filter('roots/wrap_base', 'nz_fancybox_ajax_template', 99);

function nz_fancybox_ajax_template($templates)
{
    if (nz_is_ajax()) {
        /* if ( nz_is_fancybox() ) { */
        if (is_array($templates)) {
            $result = str_replace('base-', '', $templates[0]);

            array_unshift($templates, $result);
        }
        /* } */
    }
    return $templates;
}
if (!function_exists('nz_is_ajax')) {

    function nz_is_ajax()
    {
        if (php_sapi_name() == "cli")
            return false;

	//$headers = apache_request_headers();
	//
	return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ;
        //return (isset($headers['X-Requested-With']) && $headers['X-Requested-With'] == 'XMLHttpRequest');
    }
}
if (!function_exists('nz_is_fancybox')) {

    function nz_is_fancybox()
    {
        if (php_sapi_name() == "cli")
            return false;

        $headers = apache_request_headers();
        return (isset($headers['X-fancyBox']) && $headers['X-fancyBox'] == "true");
    }
}
