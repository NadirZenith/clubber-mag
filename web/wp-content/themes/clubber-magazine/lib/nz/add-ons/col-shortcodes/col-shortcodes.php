<?php

/**
 * process shortcodes for create columns
 *
 * @author tino
 */
class ColShortcodes
{

    function __construct()
    {
        if (is_admin()) {
            add_filter('mce_buttons', array($this, 'myplugin_register_buttons'));
            add_filter('mce_external_plugins', array($this, 'myplugin_register_tinymce_javascript'));
        } else {
            add_shortcode('cm-col', array($this, 'col_shortcode'));
        }
    }

    // add new buttons

    public function myplugin_register_buttons($buttons)
    {
        array_push($buttons, 'separator', 'colshortcodes');
        return $buttons;
    }

// Load the TinyMCE plugin : editor_plugin.js (wp2.5)

    public function myplugin_register_tinymce_javascript($plugin_array)
    {
        $plugin_array['colshortcodes'] = get_stylesheet_directory_uri() . '/lib/nz/add-ons/col-shortcodes/tiny-mce-button/col-shortcodes.js';
        return $plugin_array;
    }

    public function col_shortcode($atts, $content = null)
    {

        $a = array();
        if (empty($atts)) {
            return;
        } else if (count($atts) === 1) {
            $a['class'] = $atts[0];
        } else if (isset($atts['class'])) {
            $a = shortcode_atts(array(
                'class' => NULL
                ), $atts);
        } else {
            //missing attr class
            return;
        }


        $html = '';
        $html.= '<div class="' . $a['class'] . ' fl">';
        $html.= $content;
        /* $html.= do_shortcode($content); */
        $html.= '</div>';
        return $html;
    }
//put your code here
}

new ColShortcodes;


