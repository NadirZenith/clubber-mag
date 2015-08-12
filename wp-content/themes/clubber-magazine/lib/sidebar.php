<?php

/**
 * Determines whether or not to display the sidebar based on an array of conditional tags or page templates.
 *
 * If any of the is_* conditional tags or is_page_template(template_file) checks return true, the sidebar will NOT be displayed.
 *
 * @link http://roots.io/the-roots-sidebar/
 *
 * @param array list of conditional tags (http://codex.wordpress.org/Conditional_Tags)
 * @param array list of page templates. These will be checked via is_page_template()
 *
 * @return boolean True will display the sidebar, False will not
 */
class Roots_Sidebar
{
    private $conditionals;
    private $templates;
    public $display = true;

    function __construct($conditionals = array(), $templates = array())
    {
        $this->conditionals = $conditionals;
        $this->templates = $templates;

        $conditionals = array_map(array($this, 'check_conditional_tag'), $this->conditionals);
        $templates = array_map(array($this, 'check_page_template'), $this->templates);

        if (in_array(true, $conditionals) || in_array(true, $templates)) {
            $this->display = false;
        }
    }

    private function check_conditional_tag($conditional_tag)
    {
        if (is_array($conditional_tag)) {
            return $conditional_tag[0]($conditional_tag[1]);
        } else {
            return $conditional_tag();
        }
    }

    private function check_page_template($page_template)
    {
        return is_page_template($page_template);
    }
}

/**
 * .main classes
 */
function roots_main_class()
{
    if (roots_display_sidebar()) {
        // Classes on pages with the sidebar
        $class = 'has-sidebar';
    } else {
        // Classes on full width pages
        $class = 'no-sidebar';
    }

    return apply_filters('roots/main_class', $class);
}

/**
 * .sidebar classes
 */
function roots_sidebar_class()
{
    return apply_filters('roots/sidebar_class', '');
}

/**
 * Define which pages shouldn't have the sidebar
 *
 * See lib/sidebar.php for more details
 */
function roots_display_sidebar()
{
    /**
     * Conditional tag checks (http://codex.wordpress.org/Conditional_Tags)
     * Any of these conditional tags that return true won't show the sidebar
     *
     * To use a function that accepts arguments, use the following format:
     *
     * array('function_name', array('arg1', 'arg2'))
     *
     * The second element must be an array even if there's only 1 argument.
     */
    $sidebar_config = new Roots_Sidebar(
        array(
        'is_404',
        'is_front_page',
        'is_page',
        'is_author',
        array('is_post_type_archive',
            array('cool-place', 'artist', 'music')
        ),
        array('is_tax',
            array('cool_place_type')
        )
        )
    );

    return apply_filters('roots/display_sidebar', $sidebar_config->display);
}
/**
 * Register our sidebars and widgetized areas.
 */
add_action('widgets_init', 'cm_widgets_init');

function cm_widgets_init()
{

    register_sidebar(array(
        'id' => 'singular_sidebar',
        'name' => 'Singular sidebar',
        'before_widget' => '<div class="mb15 col-1 col-sm-1-2 col-md-1-3 col-lg-1 fl"><div class="ibox-5">',
        'after_widget' => '</div></div>',
        'before_title' => '<h3 class="mb3">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'id' => 'banners_sidebar',
        'name' => 'Banners sidebar',
        'before_widget' => '<div class="mb15 col-1 col-sm-1-2 col-md-1-3 col-lg-1 fl"><div class="ibox-5">',
        'after_widget' => '</div></div>',
        'before_title' => '<h3 class="mb3">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'id' => 'archive_event_sidebar',
        'name' => 'Agenda sidebar',
        'before_widget' => '<div class="ibox-5 mb15">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="mb3">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'id' => 'single_event_sidebar',
        'name' => 'Event sidebar',
        'before_widget' => '<div class="ibox-5 mb15 single_event_sidebar_item">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="mb3">',
        'after_title' => '</h3>',
    ));
}
