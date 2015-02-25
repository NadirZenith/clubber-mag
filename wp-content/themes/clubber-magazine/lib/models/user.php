<?php
/*
 * user profile custom fields
 */
add_action( 'custom_metadata_manager_init_metadata', 'cm_author_custom_fields' );

function cm_author_custom_fields() {

      /**      */
      $post_types = array( 'user' );

      $metagroup = 'cm_author_metabox';

      x_add_metadata_group( $metagroup, $post_types, array(
            'label' => 'Campos clubber-mag'
      ) );

      $prefix = '';

      x_add_metadata_field( $prefix . 'div', $post_types, array(
            'group' => $metagroup,
            'label' => 'div',
            'description' => 'div',
            /* 'display_column_callback' => '_return_div', */
            'display_callback' => function( ) {
        echo '<h1>CAMPOS USUARIO EXTRA CLUBBER MAG</h1><hr>';
  },
      ) );

      x_add_metadata_field( $prefix . 'description', $post_types, array(
            'group' => $metagroup,
            'label' => 'Description',
            'field_type' => 'textarea',
                //'description' => 'ex: 1988-11-23',
      ) );
      x_add_metadata_field( $prefix . 'birthday', $post_types, array(
            'group' => $metagroup,
            'label' => 'Fecha nascimiento',
            'description' => 'ex: 1988-11-23',
      ) );

      x_add_metadata_field( $prefix . 'gender', $post_types, array(
            'group' => $metagroup,
            'label' => 'Sexo',
            'description' => 'Hombre / Mujer'
      ) );

      x_add_metadata_field( $prefix . 'country', $post_types, array(
            'group' => $metagroup,
            'label' => 'Pais',
                //'description' => 'España / Spain'
      ) );

      x_add_metadata_field( $prefix . 'city', $post_types, array(
            'group' => $metagroup,
            'label' => 'City',
                //'description' => 'Italia / Italy'
      ) );

      /* CONTACT FIELDS */
      $socials = array(
            'home' => 'Link Pagina Oficial',
            'facebook' => 'Link Facebook',
            'soundcloud' => 'Link Soundcoud',
            'instagram' => 'Link Instagram',
            'google-plus' => 'Link Google +',
            'youtube' => 'Link Youtube',
            'twitter' => 'Link Twitter',
      );

      foreach ( $socials as $network => $description ) {

            x_add_metadata_field( $prefix . $network, $post_types, array(
                  'group' => $metagroup,
                  'label' => $description,
            ) );
      }

      /* END CONTACT FIELDS */

      /**      */
      /* $post_types = array( 'user' ); */

      $metagroup = 'cm_profile_metabox';

      x_add_metadata_group( $metagroup, $post_types, array(
            'label' => 'Imagens de perfil de usuario'
                )
      );


      x_add_metadata_field( $prefix . 'div', $post_types, array(
            'group' => $metagroup,
            'label' => 'div',
            'description' => 'div',
            'display_callback' => function($field_slug, $field, $object_type, $object_id, $value ) {


        echo '<h1>IMAGENS PERFIL CLUBBER MAG</h1>'
        . '<h2>(USER PROFILE PAGE)</h2><hr>';
        ?>
        <a href="<?php get_author_link( true, $object_id ); ?>">User profile link</a>
        <iframe src="<?php get_author_link( true, $object_id ); ?>" width="1100" height="400">
        <p>Your browser does not support iframes.</p>
        </iframe>
        <?php
  },
      ) );

      x_add_metadata_field( $prefix . '_nz_user_profile_images', $post_types, array(
            'group' => $metagroup,
            'label' => 'Profile picture',
            'description' => 'Profile image',
            'display_callback' => function( $field_slug, $field, $object_type, $object_id, $value) {
        ?>

        <div>
              DB value
        </div>
        <pre style="max-width: 500px;overflow: scroll;">
              <?php print_r( $value ) ?>
        </pre>
        <div data-slug="<?php echo $field_slug ?>" class="custom-metadata-field text">
              <label for="<?php echo $field_slug ?>"><?php echo $field->label ?></label>
              <div id="<?php echo $field_slug ?>-1" class="<?php echo $field_slug ?>">
                    <input type="text" value='<?php echo $value[ 0 ] ?>' name="<?php echo $field_slug ?>" id="<?php echo $field_slug ?>">
              </div>
        </div> 
        <img src="<?php echo nz_get_user_image( $object_id, 'profile' ); ?>" alt="clubber-mag-profile-picture"  width="160" height="160">
        <img src="<?php echo nz_get_user_image( $object_id, 'background' ); ?>"  alt="clubber-mag-background-picture" width="589" height="200">
        <br>
        <div class="">
              fb likes(implement)
              <div class="fb-like" data-href="<?php echo get_author_posts_url( $object_id ) ?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
        </div>
        <?php
  },
      ) );

      $posts = get_posts( array(
            'post_type' => array( 'artist', 'label', 'cool-place' ),
            'post_status' => 'any',
            'post_author' => 'any',
            'posts_per_page' => -1
                )
      );
      $values = array();
      $values[ '' ] = 'none';
      foreach ( $posts as $post ) {
            $values[ $post->ID ] = $post->post_title;
      }


      x_add_metadata_field( $prefix . CM_USER_META_RESOURCE_ID, $post_types, array(
            'group' => $metagroup,
            'label' => 'Main Resource',
            'description' => 'artist / label / cool-place',
            'field_type' => 'select',
            'chosen' => true,
            'values' => $values,
      ) );
}

/** add inline meta userprofile 
 * @todo nz add single select options for some fields: gender, country, city
 */
/* add_filter( 'user_contactmethods', 'nz_remove_contactmethods', 10, 1 ); */

function nz_remove_contactmethods( $contactmethods ) {
      /* d($contactmethods); */
      return array();
      /* d($contactmethods); */
      // Remove Yahoo IM
      if ( isset( $contactmethods[ 'yim' ] ) )
            unset( $contactmethods[ 'yim' ] );

      // Add Youtube
      if ( !isset( $contactmethods[ 'youtube' ] ) )
            $contactmethods[ 'youtube' ] = 'youtube';
      // Add Country
      if ( !isset( $contactmethods[ 'country' ] ) )
            $contactmethods[ 'country' ] = 'country';
      // Add city
      if ( !isset( $contactmethods[ 'city' ] ) )
            $contactmethods[ 'city' ] = 'city';
      // Add gender
      if ( !isset( $contactmethods[ 'gender' ] ) )
            $contactmethods[ 'gender' ] = 'gender';
      // Add birthday
      if ( !isset( $contactmethods[ 'birthday' ] ) )
            $contactmethods[ 'birthday' ] = 'birthday';
      // Add website
      if ( !isset( $contactmethods[ 'website' ] ) )
            $contactmethods[ 'website' ] = 'website';


      return $contactmethods;
}

/**
 *    PRE GET AUTHOR PROFILE
 * @todo nz possibility do deactivate user author page individualy
 */
add_action( 'pre_get_posts', 'cm_pre_get_author_profile' );

function cm_pre_get_author_profile( $query ) {
      if ( !$query->is_author() || !$query->is_main_query() )
            return;

      $action = get_query_var( 'action' ); // '' , 'editar', 'agenda', 'eventos'
      /* d( $action ); */
      switch ( $action ) {
            case 'editar':
                  if ( $_REQUEST[ NZ_WP_Forms::$edit_query_var ] == get_current_user_id() ) {
                        nz_set_main_template( 'tpl/user/user-profile-edit.php' );
                  } else {
                        $query->set_404();
                  }
                  break;
            case 'agenda':
                  Roots_Wrapping::$raw = TRUE;
                  nz_set_main_template( 'tpl/user/user-agenda-list.php' );

                  break;

            case 'eventos':
                  Roots_Wrapping::$raw = TRUE;
                  nz_set_main_template( 'tpl/user/user-promoter-list.php' );

                  break;
      }
}

function nz_set_main_template( $template ) {
      global $nz_base_template;
      $nz_base_template = $template;
      add_filter( 'roots/wrap_base', 'nz_set_roots_main_template' );
}

function nz_set_roots_main_template( $templates ) {
      global $nz_base_template;
      Roots_Wrapping::$main_template = locate_template( $nz_base_template );
      return $templates;
}

/*    CHANGE HOME/author/{name} to HOME/perfil/{name} */
add_action( 'init', 'change_author_profile_url' );

function change_author_profile_url() {
      global $wp_rewrite;
      $author_slug = 'perfil';

      $wp_rewrite->author_base = $author_slug;
}

add_action( 'init', 'set_author_resources_url' );

function set_author_resources_url() {
      global $wp_rewrite;
      $query_var_name = 'action';
      $author_slug = 'perfil';
      $author_edit_slug = 'editar';


      //editar perfil
      $regex = sprintf( '^%s/([^/]+)/(%s)/?$', $author_slug, $author_edit_slug );
      $redirect = sprintf( 'index.php?author_name=$matches[1]&%s=$matches[2]', $query_var_name );

      $wp_rewrite->add_rule( $regex, $redirect );

      //agenda list
      $regex = sprintf( '^%s/([^/]+)/(%s)/?$', $author_slug, 'agenda' );
      $redirect = sprintf( 'index.php?author_name=$matches[1]&%s=$matches[2]', $query_var_name );

      $wp_rewrite->add_rule( $regex, $redirect );

      //promoter list
      $regex = sprintf( '^%s/([^/]+)/(%s)/?$', $author_slug, 'eventos' );
      $redirect = sprintf( 'index.php?author_name=$matches[1]&%s=$matches[2]', $query_var_name );

      $wp_rewrite->add_rule( $regex, $redirect );

      /* d($wp_rewrite); */
}

/* add_filter( 'wpseo_breadcrumb_links', 'debugbreadcumbs' ); */

function debugbreadcumbs( $val ) {
      d( $val );
      return $val;
}

/* --------------------------- */
foreach ( array( 'edit.php', 'post.php' ) as $hook )
      add_action( "load-$hook", 'wpse39084_replace_post_meta_author' );

/* Show Subscribers in post author dropdowns - edit and quickEdit */

function wpse39084_replace_post_meta_author() {
      global $typenow;
      if ( 'open-frequency' != $typenow )
            return;

      add_action( 'admin_menu', 'wpse50827_author_metabox_remove' );
      add_action( 'post_submitbox_misc_actions', 'wpse50827_author_metabox_move' );
      add_filter( 'wp_dropdown_users', 'wpse39084_showme_dropdown_users' );
}

/* Modify authors dropdown */

function wpse39084_showme_dropdown_users( $args = '' ) {
      $post = get_post();
      $selected = $post->post_author;
      $siteusers = get_users( 'orderby=nicename&order=ASC' ); // you can pass filters and option
      $re = '';
      if ( count( $siteusers ) > 0 ) {
            $re = '<select name="post_author_override" id="post_author_override">';
            foreach ( $siteusers as $user ) {
                  $re .= '<option value="' . $user->ID . '">' . $user->user_nicename . '</option>';
            }
            $re .= '</select>';
            $re = str_replace( 'value="' . $selected . '"', 'value="' . $selected . '" selected="selected"', $re );
      }
      echo $re;
}

/* Remove Author meta box from post editing */

function wpse50827_author_metabox_remove() {
      remove_meta_box( 'authordiv', 'post', 'normal' );
}

/* Move Author meta box inside Publish Actions meta box */

function wpse50827_author_metabox_move() {
      global $post;

      echo '<div id="author" class="misc-pub-section" style="border-top-style:solid; border-top-width:1px; border-top-color:#EEEEEE; border-bottom-width:0px;">Author: ';
      post_author_meta_box( $post );
      echo '</div>';
}
