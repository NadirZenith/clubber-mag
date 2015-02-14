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
            $socials = array(
                  'facebook' => array(
                  //'url' => 'https://www.facebook.com/Clubber.Mag',
                  ),
                  'twitter' => array(
                        'url' => 'https://www.facebook.com/Clubber.Mag',
                  ),
                  'instagram' => array(
                        'url' => 'https://www.facebook.com/Clubber.Mag',
                  ),
                  'youtube' => array(
                        'url' => 'https://www.facebook.com/Clubber.Mag',
                  ),
                  'soundcloud' => array(
                        'url' => 'https://www.facebook.com/Clubber.Mag',
                  ),
                  'google-plus' => array(
                        'url' => 'https://www.facebook.com/Clubber.Mag',
                  ),
            );
            ?>
            <?php nz_fa_social_icons( $socials, 'social-icons-single' ); ?>
      </div>
</div>
