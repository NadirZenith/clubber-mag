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
class Roots_Sidebar {

      private $conditionals;
      private $templates;
      public $display = true;

      function __construct( $conditionals = array(), $templates = array() ) {
            $this->conditionals = $conditionals;
            $this->templates = $templates;

            $conditionals = array_map( array( $this, 'check_conditional_tag' ), $this->conditionals );
            $templates = array_map( array( $this, 'check_page_template' ), $this->templates );

            if ( in_array( true, $conditionals ) || in_array( true, $templates ) ) {
                  $this->display = false;
            }
      }

      private function check_conditional_tag( $conditional_tag ) {
            if ( is_array( $conditional_tag ) ) {
                  return $conditional_tag[ 0 ]( $conditional_tag[ 1 ] );
            } else {
                  return $conditional_tag();
            }
      }

      private function check_page_template( $page_template ) {
            return is_page_template( $page_template );
      }

}

// unregister default widgets
add_action( 'widgets_init', 'nz_unregister_default_widgets', 11 );

function nz_unregister_default_widgets() {
      unregister_widget( 'WP_Widget_Pages' );
      unregister_widget( 'WP_Widget_Calendar' );
      unregister_widget( 'WP_Widget_Archives' );
      unregister_widget( 'WP_Widget_Links' );
      unregister_widget( 'WP_Widget_Meta' );
      unregister_widget( 'WP_Widget_Search' );
      /* unregister_widget( 'WP_Widget_Text' ); */
      unregister_widget( 'WP_Widget_Categories' );
      unregister_widget( 'WP_Widget_Recent_Posts' );
      unregister_widget( 'WP_Widget_Recent_Comments' );
      unregister_widget( 'WP_Widget_RSS' );
      unregister_widget( 'WP_Widget_Tag_Cloud' );
      unregister_widget( 'WP_Nav_Menu_Widget' );
}

/**
 * Register our sidebars and widgetized areas.
 *
 */
function cm_widgets_init() {

      register_sidebar( array(
            'id' => 'singular_sidebar',
            'name' => 'Singular sidebar',
            'before_widget' => '<div class="mb15 col-1 col-sm-1-2 col-md-1-3 col-lg-1 fl"><div class="ibox-5">',
            'after_widget' => '</div></div>',
            'before_title' => '<h3 class="mb3">',
            'after_title' => '</h3>',
      ) );
      register_sidebar( array(
            'id' => 'banners_sidebar',
            'name' => 'Banners sidebar',
            'before_widget' => '<div class="mb15 col-1 col-sm-1-2 col-md-1-3 col-lg-1 fl"><div class="ibox-5">',
            'after_widget' => '</div></div>',
            'before_title' => '<h3 class="mb3">',
            'after_title' => '</h3>',
      ) );

      register_sidebar( array(
            'id' => 'archive_event_sidebar',
            'name' => 'Agenda sidebar',
            'before_widget' => '<div class="ibox-5 mb15">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="mb3">',
            'after_title' => '</h3>',
      ) );

      register_sidebar( array(
            'id' => 'single_event_sidebar',
            'name' => 'Event sidebar',
            'before_widget' => '<div class="ibox-5 mb15">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="mb3">',
            'after_title' => '</h3>',
      ) );
}

add_action( 'widgets_init', 'cm_widgets_init' );
