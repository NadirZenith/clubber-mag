<?php

class NZ_WP_Form {

      static $post_featured_slug = '_thumbnail_id';
      static $post_file_slug = '_attachment_id';
      static $preview_relative_path = '/cache/preview/';
      private $img_placeholder_url;
      //main
      public $form_name;
      public $post_type;
      public $form;
      public $auto_process = TRUE;
      //status
      public $isSubmit = FALSE;
      public $isValid = NULL;
      public $isEdit = FALSE;
      public $ajax = FALSE;
      //validations
      public $clientside_validation = TRUE;
      //FIELD DEFAULTS
      //main
      //POST FIELDS REFERENCES
      public $postId = null;
      public $post_author = 0;
      public $post_status = 'pending';
      public $post_name = NULL;
      public $post_title_field = NULL;
      public $post_featured_field = NULL;
      public $post_content_field = NULL;
      //USER FIELDS REFERENCES
      public $user_login = NULL;
      public $user_pass = NULL;
      public $user_nicename = NULL;
      public $user_email = NULL;
      public $user_url = NULL;
      public $user_activation_key = NULL;
      public $user_status = NULL;
      public $user_description = NULL;
      public $user_display_name = NULL;
      //META FIELD REFERENDES
      public $post_meta_fields = array();
      public $post_meta_json_fields = array();
      public $post_file_fields = array();
      public $post_radio_fields = array();
      public $post_map_fields = array();
      //TEMS
      public $post_term_fields = array();
      //callbacks
      public $callbacks = array();
      //notification
      public $redirectTo = false;
      public $confirmations = array();
      public $notifications = array();

      public function __construct( $form_name, $post_type = 'post', $atts = array() ) {
            $this->form_name = $form_name;
            $this->post_type = $post_type;
            $this->img_placeholder_url = get_site_url() . 'wp-content/themes/clubber-magazine/assets/css/img/placeholder.jpg';

            $this->form = new Zebra_Form( $this->form_name );
      }

      public function addUserLogin( $slug, $label, $atts = array(), $rules = array() ) {

            $this->user_login = $slug;

            return $this->addField( 'text', $slug, $label, $atts, $rules );
      }

      public function addUserPass( $slug, $label, $atts = array(), $rules = array() ) {

            $this->user_pass = $slug;


            $passfield = $this->addField( 'password', $slug, $label, $atts, $rules );

            if ( isset( $atts[ 'confirm' ] ) && $atts[ 'confirm' ] ) {
                  $confirm_label = (isset( $atts[ 'confirm_label' ] )) ? $atts[ 'confirm_label' ] : __( 'Confirm password', 'cm' );
                  $confirm_error_message = (isset( $atts[ 'confirm_error' ] )) ? $atts[ 'confirm_error' ] : __( 'Password not confirmed correctly!', 'cm' );
                  $rule = array(
                        'compare' => array( $slug, 'error', $confirm_error_message )
                  );

                  return $this->addField( 'password', 'confirm_' . $slug, $confirm_label, $atts, $rule );
            }
      }

      public function addUserNicename( $slug, $label, $atts = array(), $rules = array() ) {

            $this->user_nicename = $slug;

            $rules[ 'regexp' ] = (isset( $rules[ 'regexp' ] )) ?
                      $rules[ 'regexp' ] :
                      array(
                  '^[a-z0-9_-]{3,16}$', // the regular expression
                  'error', // variable to add the error message to
                  'Invalid([a-z0-9_-]{3,16})'  // error message if value doesn't validate
            );

            return $this->addField( 'text', $slug, $label, $atts, $rules );
      }

      public function addUserDisplayName( $slug, $label, $atts = array(), $rules = array() ) {

            $this->user_display_name = $slug;

            return $this->addField( 'text', $slug, $label, $atts, $rules );
      }

      public function addUserDescription( $slug, $label, $atts = array(), $rules = array() ) {

            $this->user_description = $slug;

            return $this->addField( 'textarea', $slug, $label, $atts, $rules );
      }

      public function addUserEmail( $slug, $label, $atts = array(), $rules = array() ) {
            $this->user_email = $slug;


            $rules[ 'email' ] = (isset( $rules[ 'email' ] )) ? $rules[ 'email' ] : array( 'error', 'Email is unvalid!' );


            $passfield = $this->addField( 'text', $slug, $label, $atts, $rules );
      }

      /*
       * POST TYPE REFERENCES
       */

      public function addTitle( $type, $slug, $title, $atts = array(), $rules = array() ) {

            if ( isset( $this->post_title_field ) || !in_array( $type, array( 'text', 'hidden' ) ) )
                  return;

            $this->post_title_field = $slug;

            return $this->addField( $type, $slug, $title, $atts, $rules );
      }

      public function addContent( $type, $slug, $title, $atts = array(), $rules = array() ) {
            if ( isset( $this->post_content_field ) || !in_array( $type, array( 'text', 'hidden', 'textarea' ) ) )
                  return;

            $this->post_content_field = $slug;

            return $this->addField( $type, $slug, $title, $atts, $rules );
      }

      public function addFeatured( $slug, $title, $atts = array(), $rules = array() ) {
            $this->post_featured_field = $slug;

            $atts[ 'data-placeholder' ] = (isset( $atts[ 'data-placeholder' ] )) ?
                      $atts[ 'data-placeholder' ] : $this->img_placeholder_url;

            $atts[ 'class' ] = (isset( $atts[ 'class' ] )) ? $atts[ 'class' ] . ' nzwpform_imageupload' : 'nzwpform_imageupload';

            $this->addField( 'text', $slug, $title, $atts, $rules );
      }

      public function addImage( $slug, $title, $atts = array(), $rules = array() ) {
            $atts[ 'data-placeholder' ] = (isset( $atts[ 'data-placeholder' ] )) ?
                      $atts[ 'data-placeholder' ] : $this->img_placeholder_url;

            $atts[ 'class' ] = (isset( $atts[ 'class' ] )) ? $atts[ 'class' ] . ' nzwpform_imageupload' : 'nzwpform_imageupload';

            $this->addFile( 'text', $slug, $title, $atts, $rules );
      }

      public function addFile( $type, $slug, $title, $atts = array(), $rules = array() ) {
            if ( in_array( $slug, $this->post_file_fields ) )
                  return;

            $this->post_file_fields[] = $slug;

            $this->addField( $type, $slug, $title, $atts, $rules );
      }

      public function addMeta( $type, $slug, $title, $atts = array(), $rules = array() ) {
            if ( in_array( $slug, $this->post_meta_fields ) || in_array( $slug, $this->post_radio_fields ) )
                  return;

            switch ( $type ) {
                  case 'checkboxes':
                  case 'radios':
                        $atts[ 'options' ] = (!empty( $atts[ 'options' ] )) ? $atts[ 'options' ] : array();

                        $this->post_radio_fields[ $slug ] = $atts[ 'options' ];

                        $this->addField( $type, $slug, $title, $atts, $rules );
                        break;

                  default:
                        $this->post_meta_fields[] = $slug;

                        $this->addField( $type, $slug, $title, $atts, $rules );
                        break;
            }
      }

      public function addMetaJson( $type, $slug, $title, $atts = array(), $rules = array() ) {
            if ( in_array( $slug, $this->post_meta_json_fields ) || !in_array( $type, array( 'text', 'hidden' ) ) )
                  return;

            $this->post_meta_json_fields[] = $slug;

            $this->addField( $type, $slug, $title, $atts, $rules );
      }

      public function addRelation( $post_type, $slug, $title, $atts = array(), $rules = array() ) {

            $atts[ 'data-to' ] = $post_type;
            $atts[ 'class' ] = (isset( $atts[ 'class' ] )) ? $atts[ 'class' ] . ' nzwpform_relationTo' : 'nzwpform_relationTo';

            $this->addMeta( 'nzselect2', $slug, $title, $atts, $rules );
      }

      /**
       *  add term field
       * @todo nz add option to order terms
       */
      public function addTerm( $slug, $type, $title, $atts = array(), $rules = array() ) {

            switch ( $type ) {
                  case 'radios':
                  case 'checkboxes':
                        $terms = $this->_get_terms( $slug );
                        $options = array();
                        foreach ( $terms as $term ) {
                              $options[ $term->term_id ] = $term->name;
                        }

                        $this->post_term_fields[ $slug ] = $options;
                        $atts[ 'options' ] = $options;
                        $this->addField( $type, $slug, $title, $atts, $rules );
                        break;
            }
      }

      /**
       *  add field without relation
       *    used by post fields
       */
      public function addField( $type, $slug, $title, $atts = array(), $rules = array() ) {

            if ( !in_array( $type, array( 'note', 'hidden' ) ) )
                  $this->_add_default_label( $slug, $title );


            switch ( $type ) {
                  case 'radios':
                  case 'checkboxes':
                        $slug.=($type == "checkboxes") ? '[]' : '';

                        $field = $this->form->add( $type, $slug, $atts[ 'options' ], $atts );

                        break;

                  case 'note':
                        $attach_to = (isset( $atts[ 'attach_to' ] )) ? $atts[ 'attach_to' ] : null;
                        $caption = (isset( $atts[ 'caption' ] )) ? $atts[ 'caption' ] : '';
                        //$id, $attach_to, $caption, $attributes = '')
                        $field = $this->form->add( $type, $slug, $attach_to, $caption, $atts );

                        break;
                  case 'nzimageold':
                        /*
                          'image',
                          'my_image',
                          'path/to/image',
                          array(
                          'alt' => 'Click to submit form'
                          )
                         */
                        $path = (isset( $atts[ 'path' ] )) ? $atts[ 'path' ] : '';
                        //$id, $attach_to, $caption, $attributes = '')
                        $field = $this->form->add( $type, $slug, $path, $atts );

                        break;
                  case 'nzselect2':
                        $value = $this->_get_value( $atts );

                        if ( NZ_WP_Forms::$isEdit ) {
                              $id = get_query_var( NZ_WP_Forms::$edit_query_var );
                              $atts[ 'data-text' ] = get_the_title( get_post_meta( $id, $slug, true ) );
                        } else {
                              if ( isset( $_GET[ $slug ] ) ) {
                                    $value = $_GET[ $slug ];
                                    $atts[ 'data-text' ] = get_the_title( $value );
                              }
                        }

                        $field = $this->form->add( $type, $slug, $value, $atts );
                        break;
                  default:
                        $value = $this->_get_value( $atts );
                        $field = $this->form->add( $type, $slug, $value, $atts );
                        break;
            }

            if ( !empty( $rules ) )
                  $field->set_rule( $rules );
      }

      /**
       *  add submit button
       */
      public function addSubmit( $slug, $title ) {
            $this->form->add( 'submit', $slug, $title );
      }

      /**
       *  add note
       */
      public function addNote( $slug, $atts ) {
            $this->addField( 'note', $slug, null, $atts );
      }

      /**
       *  add clear
       */
      public function addClear() {

            $field = $this->form->add( 'nzclear', 'cb' );
            /* $field = $this->form->add( 'note', 'cb' ); */
      }

      /**
       *  fill form
       */
      public function fillForm( $model, $meta ) {
            /* $meta = apply_filters( 'nzwp_forms_fill_form_metadata_' . $this->form_name, $meta ); */

            $fill = array();

            /* user */
            $type = $this->get_object_type();
            //pocess user type
            if ( $type == 'user' ) {
                  if ( isset( $this->user_login ) ) {
                        $fill[ $this->user_login ] = $model->get( 'user_login' );
                  }
                  /*
                    if ( isset( $this->user_pass ) ) {
                    $user[ 'user_pass' ] = $this->form->controls[ $this->user_pass ]->submitted_value;
                    }
                   */
                  if ( isset( $this->user_nicename ) ) {
                        $fill[ $this->user_nicename ] = $model->get( 'user_nicename' );
                  }
                  if ( isset( $this->user_email ) ) {
                        $fill[ $this->user_email ] = $model->get( 'user_email' );
                  }
                  if ( isset( $this->user_url ) ) {
                        $fill[ $this->user_url ] = $model->get( 'user_url' );
                  }
                  if ( isset( $this->user_activation_key ) ) {
                        $fill[ $this->user_activation_key ] = $model->get( 'user_activation_key' );
                  }
                  if ( isset( $this->user_status ) ) {
                        $fill[ $this->user_status ] = $model->get( 'user_status' );
                  }
                  if ( isset( $this->user_description ) ) {
                        $fill[ $this->user_description ] = $model->get( 'description' );
                  }
                  if ( isset( $this->user_display_name ) ) {
                        $fill[ $this->user_display_name ] = $model->get( 'display_name' );
                  }
            }

            //fill post type(custom)
            if ( $type == 'post' ) {

                  //fill post title
                  if ( isset( $this->post_title_field ) ) {
                        $fill[ $this->post_title_field ] = $model->post_title;
                  }
                  //fill post content
                  if ( isset( $this->post_content_field ) ) {
                        $fill[ $this->post_content_field ] = $model->post_content;
                  }
                  //fill featured image
                  if ( isset( $this->post_featured_field ) ) {
                        $url = wp_get_attachment_thumb_url( $meta[ self::$post_featured_slug ][ 0 ] );
                        if ( $url ) {
                              $fill[ $this->post_featured_field ] = $url;
                        } else {
                              
                        }
                  }
                  //fill term  fields
                  if ( !empty( $this->post_term_fields ) ) {
                        foreach ( $this->post_term_fields as $term_slug => $options ) {
                              $terms = wp_get_post_terms( $model->ID, $term_slug );
                              /* d( $terms ); */
                              /* d( $this ); */
                              /* d( $options ); */
                              $checked = array();
                              foreach ( $terms as $term ) {
                                    $checked[] = $term->term_id;
                              }
                              /* d( $checked ); */
                              if ( sizeof( $checked ) == 1 ) {
                                    $fill[ $term_slug ] = $checked[ 0 ];
                              } else {
                                    $fill[ $term_slug ] = $checked;
                              }

                              /*
                                $keys = array_keys( $options );
                                foreach ( $keys as $key ) {
                                d( $this->form->controls[ $term_slug . '_' . $key ] );
                                if ( in_array( $key, $checked ) ) {
                                $value = $this->form->controls[ $term_slug . '_' . $key ]->submitted_value;
                                $fill[ $term_slug . '_' . $key ] = $key;
                                } else {
                                }
                                }
                               */
                        }
                  }
            }

            //fill file fields
            if ( !empty( $this->post_file_fields ) ) {
                  foreach ( $this->post_file_fields as $meta_field ) {
                        $url = wp_get_attachment_thumb_url( $meta[ $meta_field . self::$post_file_slug ][ 0 ] );
                        if ( $url ) {
                              $fill[ $meta_field ] = $url;
                        } else {
                              /* $this->form->controls[ $this->post_featured_field ]->attributes[ 'data-placeholder' ] = $url; */
                        }
                  }
            }

            //fill meta fields
            if ( !empty( $this->post_meta_fields ) ) {
                  foreach ( $this->post_meta_fields as $metafield ) {
                        $fill[ $metafield ] = $meta[ $metafield ][ 0 ];
                  }
            }
            //fill meta json fields
            if ( !empty( $this->post_meta_json_fields ) ) {
                  foreach ( $this->post_meta_json_fields as $metafield ) {
                        /* $fill[ $metafield ] = htmlentities($meta[ $metafield ][ 0 ]); */
                        /* $fill[ $metafield ] = stripslashes($meta[ $metafield ][ 0 ]); */
                        /* $fill[ $metafield ] = html_entity_decode($meta[ $metafield ][ 0 ]); */
                        $fill[ $metafield ] = htmlspecialchars( $meta[ $metafield ][ 0 ] );
                  }
            }
            //fill radio meta fields
            if ( !empty( $this->post_radio_fields ) ) {
                  /*
                   */
                  foreach ( $this->post_radio_fields as $slug => $options ) {
                        $keys = array_keys( $options );
                        /* d( $meta ); */
                        foreach ( $keys as $key ) {
                              if ( isset( $meta[ $slug ] ) ) {
                                    if ( count( $meta[ $slug ][ 0 ] ) == 1 ) {
                                          $fill[ $slug ] = $meta[ $slug ][ 0 ];
                                    } else {
                                          $fill[ $slug ] = $meta[ $slug ];
                                    }
                              } else {
                                    $fill[ $slug ] = array();
                              }
                        }
                  }
            }
            /*
              d( $post );
              d( $meta );
              d( $fill );
             */

            /* d( $fill ); */
            $this->form->auto_fill( $fill );
            $this->form->validate();
      }

      /**
       *  Process form create/update post / user
       */
      public function processForm( $update_id = 0 ) {

            if ( !$this->auto_process )
                  return;

            $type = $this->get_object_type();
            //process post type(custom)
            if ( $type == 'post' ) {

                  $post = array();

                  //process post title
                  if ( isset( $this->post_title_field ) ) {
                        $post[ 'post_title' ] = $this->form->controls[ $this->post_title_field ]->submitted_value;
                  }
                  //process post name(slug)
                  if ( NULL !== $this->post_name ) {
                        $post[ 'post_name' ] = $this->post_name;
                  }
                  //process post content
                  if ( isset( $this->post_content_field ) ) {
                        $post[ 'post_content' ] = $this->form->controls[ $this->post_content_field ]->submitted_value;
                  }

                  $post[ 'post_type' ] = $this->post_type;
                  $post[ 'post_status' ] = $this->post_status;
                  $post[ 'post_author' ] = $this->post_author;

                  if ( $update_id != 0 ) {
                        $post[ 'ID' ] = $update_id;
                  }
                  $post = apply_filters( 'nzwp_forms_process_form_' . $this->form_name, $post, $this );
                  /**
                   *  Process  insert post
                   */
                  if ( isset( $post[ 'ID' ] ) ) {
                        $post_id = wp_update_post( $post );
                  } else {
                        $post_id = wp_insert_post( $post );
                        $this->postId = $post_id;
                  }
            }
            //pocess user type
            if ( $type == 'user' ) {

                  $user = array();

                  /* $user[ 'user_login' ] = $this->user_login; */
                  if ( isset( $this->user_login ) ) {
                        $user[ 'user_login' ] = $this->form->controls[ $this->user_login ]->submitted_value;
                  }
                  if ( isset( $this->user_pass ) ) {
                        $user[ 'user_pass' ] = $this->form->controls[ $this->user_pass ]->submitted_value;
                  }
                  if ( isset( $this->user_nicename ) ) {
                        $user[ 'user_nicename' ] = $this->form->controls[ $this->user_nicename ]->submitted_value;
                  }
                  if ( isset( $this->user_email ) ) {
                        $user[ 'user_email' ] = $this->form->controls[ $this->user_email ]->submitted_value;
                  }
                  if ( isset( $this->user_url ) ) {
                        $user[ 'user_url' ] = $this->form->controls[ $this->user_url ]->submitted_value;
                  }
                  if ( isset( $this->user_activation_key ) ) {
                        $user[ 'user_activation_key' ] = $this->form->controls[ $this->user_activation_key ]->submitted_value;
                  }
                  if ( isset( $this->user_status ) ) {
                        $user[ 'user_status' ] = $this->form->controls[ $this->user_status ]->submitted_value;
                  }
                  if ( isset( $this->user_display_name ) ) {
                        $user[ 'display_name' ] = $this->form->controls[ $this->user_display_name ]->submitted_value;
                  }
                  if ( isset( $this->user_description ) ) {
                        $user[ 'description' ] = $this->form->controls[ $this->user_description ]->submitted_value;
                  }

                  if ( $update_id != 0 ) {
                        $user[ 'ID' ] = $update_id;
                  }
                  $user = apply_filters( 'nzwp_forms_process_form_' . $this->form_name, $user );

                  /**
                   *  Process  insert user
                   */
                  if ( isset( $user[ 'ID' ] ) ) {
                        $post_id = wp_update_user( $user );
                  } else {
                        $post_id = wp_insert_user( $user );
                  }
                  /* df( $post_id ); */
            }


            if ( is_wp_error( $post_id ) ) {
                  /* f( 'error' ); */
            } else {
                  $metadata = array();
                  /**
                   *  Process  featured image
                   */
                  if ( isset( $this->post_featured_field ) ) {
                        $preview_url = trim( $this->form->controls[ $this->post_featured_field ]->submitted_value, '"' );
                        if ( !empty( $preview_url ) ) {
                              $upload = wp_upload_dir();
                              $relative_url = str_replace( $upload[ 'baseurl' ], "", $preview_url );
                              if ( FALSE !== strpos( $relative_url, self::$preview_relative_path ) ) {//  /cache/preview/1419290241-15.jpg
                                    //move image create thumb
                                    $file_name = basename( $preview_url );
                                    $wp_filetype = wp_check_filetype( $file_name, null );

                                    $destination_file_path = trailingslashit( $upload[ 'path' ] ) . $file_name;

                                    $attachment = array(
                                          'post_parent' => $post_id,
                                          'post_mime_type' => $wp_filetype[ 'type' ],
                                          'post_title' => preg_replace( '/\.[^.]+$/', '', $file_name ),
                                          'post_content' => '',
                                          'post_status' => 'inherit'
                                    );

                                    /* d($attachment); */
                                    //mv file to uploads and instert into library
                                    rename( $upload[ 'basedir' ] . self::$preview_relative_path . $file_name, $destination_file_path );

                                    $attach_id = wp_insert_attachment( $attachment, $destination_file_path, $post_id );

                                    // for the function wp_generate_attachment_metadata() to work
                                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                                    $attach_metadata = wp_generate_attachment_metadata( $attach_id, $destination_file_path );
                                    wp_update_attachment_metadata( $attach_id, $attach_metadata );

                                    $metadata[ '_thumbnail_id' ] = $attach_id; //working

                                    /* $result = update_metadata( 'post', $post_id, '_thumbnail_id', $attach_id ); */
                              } else {
                                    //  /2014/12/1419290241-15.jpg
                              }
                        }
                  }

                  /**
                   *  Process file fields
                   */
                  if ( !empty( $this->post_file_fields ) ) {
                        $upload = wp_upload_dir();

                        foreach ( $this->post_file_fields as $meta ) {

                              $preview_url = trim( $this->form->controls[ $meta ]->submitted_value, '"' );
                              if ( !empty( $preview_url ) ) {
                                    $relative_url = str_replace( $upload[ 'baseurl' ], "", $preview_url );
                                    if ( FALSE !== strpos( $relative_url, self::$preview_relative_path ) ) {//  /cache/preview/1419290241-15.jpg
                                          $file_name = basename( $preview_url );
                                          $current_file_path = $upload[ 'basedir' ] . self::$preview_relative_path . $file_name;

                                          $continue = apply_filters( 'nz_wp_form_' . $this->form_name . '_' . $meta, $current_file_path );

                                          if ( !$continue )
                                                continue;

                                          //nz_wp_form_form_name_slug
                                          $wp_filetype = wp_check_filetype( $file_name, null );
                                          $attachment = array(
                                                'post_mime_type' => $wp_filetype[ 'type' ],
                                                'post_title' => preg_replace( '/\.[^.]+$/', '', $file_name ),
                                                'post_content' => '',
                                                'post_status' => 'inherit'
                                          );

                                          $destination_file_path = $upload[ 'path' ] . "/$file_name";
                                          //mv file to uploads and instert into library
                                          rename( $current_file_path, $destination_file_path );

                                          $attach_id = wp_insert_attachment( $attachment, $destination_file_path, $post_id );
                                          // for the function wp_generate_attachment_metadata() to work
                                          require_once(ABSPATH . 'wp-admin/includes/image.php');
                                          $attach_metadata = wp_generate_attachment_metadata( $attach_id, $destination_file_path );
                                          $destination_file_url = trailingslashit( $upload[ 'baseurl' ] ) . $attach_metadata[ 'file' ];
                                          wp_update_attachment_metadata( $attach_id, $attach_metadata );

                                          //working
                                          $metadata[ $meta . self::$post_file_slug ] = $attach_id;
                                          $metadata[ $meta ] = $destination_file_url;

                                          /* $result1 = update_metadata( $type, $post_id, $meta . self::$post_file_slug, $attach_id ); */
                                          /* $result2 = update_metadata( $type, $post_id, $meta, $destination_file_url ); */
                                    } else {
                                          //  /2014/12/1419290241-15.jpg
                                    }
                              }
                        }
                  }

                  /**
                   *  Process 'post' meta fields
                   */
                  if ( !empty( $this->post_meta_fields ) ) {
                        foreach ( $this->post_meta_fields as $meta ) {
                              $value = $this->form->controls[ $meta ]->submitted_value;
                              $metadata[ $meta ] = $value;
                        }
                  }

                  /**
                   *  Process 'post' meta JSON fields
                   */
                  if ( !empty( $this->post_meta_json_fields ) ) {
                        foreach ( $this->post_meta_json_fields as $meta ) {
                              $value = $this->form->controls[ $meta ]->submitted_value;
                              /* $value = trim( stripslashes( html_entity_decode( $value ) ) ); */
                              /* $value = trim(  $value ) ; */
                              $value = trim( html_entity_decode( $value ) );
                              $metadata[ $meta ] = $value;
                        }
                  }

                  /**
                   *  Process radio / checkbox meta fields single value
                   */
                  if ( !empty( $this->post_radio_fields ) ) {
                        foreach ( $this->post_radio_fields as $meta => $options ) {
                              $keys = array_keys( $options );
                              foreach ( $keys as $key ) {
                                    $submitted_value = $this->form->controls[ $meta . '_' . $key ]->submitted_value;
                                    $value = ( is_array( $submitted_value ) ) ? $submitted_value[ 0 ] : $submitted_value;
                                    break;
                              }
                              $result = update_metadata( $type, $post_id, $meta, $value );
                        }
                  }

                  /**
                   * FILTER & INSERT METADATA
                   */
                  if ( !empty( $metadata ) ) {
                        $metadata = apply_filters( 'nzwp_forms_process_form_metadata_' . $this->form_name, $metadata );

                        foreach ( $metadata as $meta => $value ) {

                              $result = update_metadata( $type, $post_id, $meta, $value );
                        }
                  }

                  /**
                   *  Process TERM FIELDS radio / checkboxes
                   */
                  if ( !empty( $this->post_term_fields ) ) {
                        foreach ( $this->post_term_fields as $term => $options ) {
                              $keys = array_keys( $options );
                              foreach ( $keys as $key ) {
                                    $submitted_value = $this->form->controls[ $term . '_' . $key ]->submitted_value;
                                    $value = (!is_array( $submitted_value ) ) ? array( $submitted_value ) : $submitted_value;
                                    break;
                              }
                              $value = array_map( 'intval', array_unique( $value ) );

                              $result = wp_set_object_terms( $post_id, $value, $term );
                        }
                  }
            }
      }

      /**
       * Set redirectTo property
       */
      public function redirectTo( $url ) {
            $this->redirectTo = $url;
      }

      /**
       * add confirmation message
       */
      public function addConfirmation( $message ) {
            $this->confirmations[] = $message;
      }

      /**
       * add notification email
       */
      public function addNotification( $message ) {
            $this->notifications[] = $message;
      }

      /**
       * Add callback function by type
       */
      public function addCallback( $type, $callback ) {
            $this->callbacks[ $type ] = $callback;
      }

      /**
       * return value from attributes and unset
       */
      private function _get_value( $atts ) {
            if ( isset( $atts[ 'value' ] ) ) {
                  $value = $atts[ 'value' ];
                  unset( $atts[ 'value' ] );
            } else
                  $value = null;

            return $value;
      }

      /**
       *  add label field
       */
      private function _add_default_label( $slug, $title ) {
            $this->form->add( 'label', 'label_' . $slug, $slug, $title );
      }

      /**
       *  get wordpress terms by terms name
       */
      private function _get_terms( $terms ) {
            /* if ( in_array( $slug, $this->post_meta_fields ) ) */
            /* return; */

            if ( !is_array( $terms ) ) {
                  $terms = array( $terms );
            }

            $args = array(
                  'orderby' => 'name',
                  'order' => 'ASC',
                  'hide_empty' => false,
                  'exclude' => array(),
                  'exclude_tree' => array(),
                  'include' => array(),
                  'number' => '',
                  'fields' => 'all',
                  'slug' => '',
                  'parent' => '',
                  'hierarchical' => true,
                  'child_of' => 0,
                  'get' => '',
                  'name__like' => '',
                  'description__like' => '',
                  'pad_counts' => false,
                  'offset' => '',
                  'search' => '',
                  'cache_domain' => 'core'
            );

            return get_terms( $terms, $args );
      }

      /**
       *  get wordpress terms by terms name
       */
      public function get_object_type() {


            $type = 'post';
            if ( $this->post_type == 'user' ) {
                  $type = 'user';
            }
            return $type;
      }

}
