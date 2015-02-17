<div class="cb group">

      <?php
      $taxonomy = 'country';
      $term = wp_get_post_terms( get_the_ID(), $taxonomy );
      if ( !is_wp_error( $term ) && ($term = $term[ 0 ]) ) {
            /* $link = get_term_link( $term ); */
            /* $country_name = $term->name; */
            ?>
            <div class="fl">
                  <div class="flag es">
                        <?php
                        echo $term->name;
                        ?>
                  </div>
            </div>
            <?php
      }
      ?>
      <div class="fr">
            <?php
            $meta = get_post_meta(  get_queried_object_id());

            /* CONTACT FIELDS */
            $all_socials = array(
                  'home',
                  'facebook',
                  'soundcloud',
                  'instagram',
                  'google-plus',
                  'youtube',
                  'twitter',
                  /*'beatport',*/
                  /*'bandpage'*/
            );
            foreach ( $all_socials as $network ) {
                  $socials[ $network ] = array(
                        'url' => (isset( $meta[ $network ] )) ? $meta[ $network ][ 0 ] : null,
                  );
            }
           
            ?>
            <?php nz_fa_social_icons( $socials, 'social-icons-single' ); ?>
      </div>
</div>
