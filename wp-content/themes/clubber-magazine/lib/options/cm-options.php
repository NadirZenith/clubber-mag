<?php

return array(
      'title' => __( 'CM Options', 'cm' ),
      'logo' => '',
      'menus' => array(
            array(
                  'title' => __( 'Forms', 'cm' ),
                  'name' => 'menu_1',
                  'icon' => 'font-awesome:fa-magic',
                  'controls' => array(
                        array(
                              'type' => 'section',
                              'title' => __( 'Contact Form', 'cm' ),
                              'fields' => array(
                                    array(
                                          'type' => 'textbox',
                                          'name' => 'contact_form_user_message',
                                          'label' => __( 'User message', 'cm' ),
                                          'description' => __( 'Only alphabets allowed here.', 'cm' ),
                                          'validation' => 'alphabet',
                                    ),
                                    array(
                                          'type' => 'wpeditor',
                                          'name' => 'contact_form_admin_email',
                                          'label' => __( 'Admin email', 'cm' ),
                                          'description' => __( 'Wordpress tinyMCE editor.', 'cm' ),
                                          'use_external_plugins' => '1',
                                          'disabled_externals_plugins' => '',
                                          'disabled_internals_plugins' => '',
                                    ),
                              )
                        ),
                        array(
                              'type' => 'section',
                              'title' => __( 'Event Form User email', 'cm' ),
                              'fields' => array(
                                    array(
                                          'type' => 'wpeditor',
                                          'name' => 'event_form_user_email',
                                          'label' => __( 'Event form', 'cm' ),
                                          'description' => __( 'Wordpress tinyMCE editor.', 'cm' ),
                                          'use_external_plugins' => '1',
                                          'disabled_externals_plugins' => '',
                                          'disabled_internals_plugins' => '',
                                    ),
                                    array(
                                          'type' => 'textbox',
                                          'name' => 'event_form_user_message',
                                          'label' => __( 'Alphabet', 'cm' ),
                                          'description' => __( 'Only alphabets allowed here.', 'cm' ),
                                          'validation' => 'alphabet',
                                    ),
                              )
                        )


                  /*           end section (two)                         */
                  )
            )
      )
);
