<?php

function init_example_options() {
      // Built path to options template array file
      $tmpl_opt = get_template_directory() . '/lib/options/example-options.php';
      // Initialize the Option's object
      $example_options = new VP_Option( array(
            'is_dev_mode' => FALSE,
            'option_key' => 'vpt_option',
            'page_slug' => 'vpt_option',
            'template' => $tmpl_opt,
            'menu_page' => 'themes.php',
            'use_auto_group_naming' => true,
            'use_exim_menu' => true,
            'minimum_role' => 'edit_theme_options',
            'layout' => 'fixed',
            'page_title' => __( 'Example Options', 'vp_textdomain' ),
            'menu_label' => __( 'Example Options', 'vp_textdomain' ),
                ) );
}

add_action( 'after_setup_theme', 'init_example_options' );

function init_cm_options() {
      // Built path to options template array file
      $tmpl_opt = get_template_directory() . '/lib/options/cm-options.php';
      // Initialize the Option's object
      $cm_options = new VP_Option( array(
            'is_dev_mode' => false,
            'option_key' => 'cm_option',
            'page_slug' => 'cm_option',
            'template' => $tmpl_opt,
            'menu_page' => 'themes.php',
            'use_auto_group_naming' => true,
            'use_exim_menu' => true,
            'minimum_role' => 'edit_theme_options',
            'layout' => 'fixed',
            'page_title' => __( 'CM Options', 'cm_textdomain' ),
            'menu_label' => __( 'CM Options', 'cm_textdomain' ),
                ) );
}

// the safest hook to use, since Vafpress Framework may exists in Theme or Plugin
add_action( 'after_setup_theme', 'init_cm_options' );

function cm_option( $name ) {
      return vp_option( "cm_option." . $name );
}



