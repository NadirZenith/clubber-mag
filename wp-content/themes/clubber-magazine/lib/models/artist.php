<?php

$artists = new CPT( array(
      'post_type_name' => 'artist',
      'singular' => __( 'Artist', 'cm' ),
      'plural' => __( 'Artists', 'cm' ),
          /* 'slug' => 'agenda' */
          ), array(
      'supports' => array( 'title', 'editor', 'thumbnail', 'author'
            , 'custom-fields'
      ),
      'has_archive' => 'artistas'
          )
);

$artists->register_taxonomy( array(
      'taxonomy_name' => 'country',
      'singular' => __( 'Country', 'cm' ),
      'plural' => __( 'Countries', 'cm' ),
      'slug' => 'nation'
          )
);

add_action( 'p2p_init', 'cm_artists_connections' );

function cm_artists_connections() {
      p2p_register_connection_type( array(
            'name' => 'artists_to_labels',
            'from' => 'artist',
            'to' => 'label'
      ) );
      p2p_register_connection_type( array(
            'name' => 'artists_to_podcasts',
            'from' => 'artist',
            'to' => 'podcast'
      ) );
}

add_action( 'custom_metadata_manager_init_metadata', 'cm_artist_contact_custom_fields' );
/*
 * OLD FIELDS
 * wpcf-link-youtube
 * wpcf-link-twitter
 * wpcf-link-soundcloud
 * wpcf-link-pagina-oficial
 * wpcf-link-facebook
 * wpcf-link-contact -> EMAIL
 * 
 * NEW
 * home
 * email
 * facebook
 * soundcloud
 * instagram
 * google-plus
 * youtube
 * twitter
 * beatport
 * bandpage
 * 
 */

function cm_artist_contact_custom_fields() {

      $post_types = array( 'artista' );
      $prefix = '';
      $metagroup = 'contact_metabox';
      x_add_metadata_group( $metagroup, $post_types, array(
            'label' => 'Contact'
      ) );

      /* CONTACT FIELDS */
      $socials = array(
            'home' => 'Link Pagina Oficial',
            'email' => 'Email Oficial',
            'facebook' => 'Link Facebook',
            'soundcloud' => 'Link Soundcoud',
            'instagram' => 'Link Instagram',
            'google-plus' => 'Link Google +',
            'youtube' => 'Link Youtube',
            'twitter' => 'Link Twitter',
            'beatport' => 'Link Beatport',
            'bandpage' => 'Link Bandpage'
      );

      foreach ( $socials as $network => $description ) {

            x_add_metadata_field( $prefix . $network, $post_types, array(
                  'group' => $metagroup,
                  'label' => $description,
            ) );
      }

      /* END CONTACT FIELDS */
}