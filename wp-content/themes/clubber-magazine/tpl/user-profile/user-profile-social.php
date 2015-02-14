<?php

/* d( $curauth ); */
$meta = get_user_meta( $curauth->ID );
/*d( $meta );*/

/* CONTACT FIELDS */
$all_socials = array(
      'home',
      'facebook',
      'soundcloud',
      'instagram',
      'google-plus',
      'youtube',
      'twitter'
);
foreach ( $all_socials as $network ) {
      $socials[ $network ] = array(
            'url' => (isset( $meta[ $network ] )) ? $meta[ $network ][ 0 ] : null,
      );
}
?>
<?php nz_fa_social_icons( $socials, 'social-icons-single' ); ?>
