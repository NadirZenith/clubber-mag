<?php
/*
 * user profile custom fields
 */

function nz_add_contactmethods( $contactmethods ) {
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

/** add inline meta userprofile 
 * @todo nz add single select options for some fields: gender, country, city
 */
add_filter( 'user_contactmethods', 'nz_add_contactmethods', 10, 1 );

add_action( 'show_user_profile', 'clubber_mag_extra_profile_fields' );
add_action( 'edit_user_profile', 'clubber_mag_extra_profile_fields' );

function clubber_mag_extra_profile_fields( $user ) {
      ?>

      <h3>CLUBBER MAG PROFILE</h3>
      <table class="form-table">
            <tr>
                  <th><label>User images</label></th>
                  <td>
                        <div style="position:relative">

                              <div style="float:left">
                                    <?php
                                    $url = nz_get_user_image( $user->ID, 'background' );
                                    ?>
                                    <img src="<?php echo $url ?>" alt="clubber-mag-background-picture" width="589" height="200">
                              </div>
                              <div style="position: absolute;top: 20px;">
                                    <?php
                                    $url = nz_get_user_image( $user->ID, 'profile' );
                                    ?>
                                    <img style="background-color: #fff" src="<?php echo $url ?>" alt="clubber-mag-profile-picture" width="160" height="160">
                              </div>
                        </div>


                  </td>
            </tr>
            <!--  USER META -->
            <tr>
                  <th><label>User meta</label></th>
                  <td>
                        <ul class="m">
                              <?php
                              $info = get_user_meta( $user->ID, 'description', TRUE );
                              if ( $info ) {
                                    ?>
                                    <li class="">
                                          <span class="bold">INFO: </span>
                                          <?php
                                          echo $info;
                                          ?>
                                    </li>  
                                    <?php
                              }
                              ?>

                              <?php
                              $website = get_user_meta( $user->ID, 'website', true );
                              if ( $website ) {
                                    ?>
                                    <li class="">
                                          <span class="bold">Web: </span>
                                          <a href="<?php echo $website ?>" target="_blank" rel="nofollow">
                                                <?php echo $website ?>
                                          </a>
                                    </li>  
                                    <?php
                              }
                              ?>
                              <?php
                              $facebook = get_user_meta( $user->ID, 'facebook', true );
                              if ( $facebook ) {
                                    ?>
                                    <li class="">
                                          <span class="bold">Facebook: </span>
                                          <a href="<?php echo $facebook ?>" target="_blank" rel="nofollow">
                                                <?php echo $facebook ?>
                                          </a>
                                    </li>  
                                    <?php
                              }
                              ?>
                              <?php
                              $twitter = get_user_meta( $user->ID, 'twitter', true );
                              if ( $twitter ) {
                                    ?>
                                    <li class="">
                                          <span class="bold">Twitter: </span>
                                          <a href="<?php echo $twitter ?>" target="_blank" rel="nofollow">
                                                <?php echo $twitter ?>
                                          </a>
                                    </li>  
                                    <?php
                              }
                              ?>
                              <?php
                              $youtube = get_user_meta( $user->ID, 'youtube', true );
                              if ( $youtube ) {
                                    ?>
                                    <li class="">
                                          <span class="bold">Youtube: </span>
                                          <a href="<?php echo $youtube ?>" target="_blank" rel="nofollow">
                                                <?php echo $youtube ?>
                                          </a>
                                    </li>  
                                    <?php
                              }
                              ?>

                        </ul>
                  </td>
            </tr>
            <!-- MAIN RESOURCE -->
            <tr>
                  <th><label>main resource</label></th>
                  <td>
                        <?php
                        $main_resource = get_user_meta( $user->ID, 'main_resource', true );
                        /*d( $main_resource );*/
                        //check if main resource exist
                        if ( 'artist' == $main_resource ) {
                              $artist_page_id = ( int ) get_user_meta( $user->ID, 'artist_page', true );
                              $artist = get_post( $artist_page_id );
                              if ( NULL == $artist /* || $artist->post_type != 'artist' */ ) {
                                    delete_user_meta( $user->ID, 'main_resource' );
                                    unset( $main_resource );
                              }
                        } elseif ( 'label' == $main_resource ) {
                              $label_page_id = ( int ) get_user_meta( $user->ID, 'label_page', true );
                              /*d( $label_page_id );*/
                        } elseif ( 'cool-place' == $main_resource ) {
                              $user_coolplaces = get_user_meta( $user->ID, 'coolplaces_ids', true );
                              /*d( $user_coolplaces );*/
                        }
                        ?>
                        <p>
                              <?php echo ($main_resource) ? $main_resource : 'empty' ?>
                        </p>
                        <select name="main_resource">
                              <option value="" >'-vacío-'</option> 
                              <option value="artist" <?php echo ($main_resource == 'artist') ? 'selected' : '' ?>>artist</option> 
                              <option value="label" <?php echo ($main_resource == 'label') ? 'selected' : '' ?>>label</option>
                              <option value="cool-place" <?php echo ($main_resource == 'cool-place') ? 'selected' : '' ?>>cool-place</option>
                        </select>
                  </td>
            </tr>
            <!--  COOL PLACES               -->
            <tr>
                  <th><label>CoolPlaces</label></th>
                  <td>

                        <?php
                        $user_coolplaces = get_user_meta( $user->ID, 'coolplaces_ids', true );
                        /*d( $user_coolplaces );*/
                        if ( $user_coolplaces ) {

                              $args = array(
                                    'post_type' => 'cool-place',
                                    'post_status' => 'any',
                                    'posts_per_page' => -1,
                                    'post__in' => $user_coolplaces,
                                    'order' => 'ASC',
                              );

                              $query = new WP_Query( $args );
                              if ( $query->have_posts() ) {
                                    $ids = array();
                                    ?>
                                    <ul style="float: left">
                                          <?php
                                          while ( $query->have_posts() ) {
                                                $query->the_post();
                                                $ids[] = get_the_ID();
                                                ?>
                                                <li>
                                                      <?php echo the_post_thumbnail( array( 50, 50 ) ) ?>
                                                      <a href="<?php echo get_edit_post_link( get_the_ID() ) ?>"><?php the_title(); ?></a>
                                                      (<?php echo get_post()->post_status ?>)
                                                </li>
                                                <?php
                                          }
                                          ?>
                                    </ul>
                                    <?php
                              }
                        }
                        ?>
                        <select  style="float: left;width: 300px;" name="user_cool_places[]" class="current-values"  multiple size="8">
                              <?php
                              $query = new WP_Query( array( 'post_type' => 'cool-place', 'posts_per_page' => -1 ) );
                              if ( $query->have_posts() ) {
                                    while ( $query->have_posts() ) {
                                          $query->the_post();
                                          ?>
                                          <option value="<?php the_ID() ?>" <?php echo (in_array( get_the_ID(), $ids )) ? 'selected' : null; ?>><?php the_title() ?></option>
                                          <?php
                                    }
                              }
                              ?>

                        </select>

                        <?php
                        wp_reset_postdata();
                        ?>
                  </td>
            </tr>
            <!--  ARTIST PAGE       -->
            <tr>
                  <th><label>Artist Page</label></th>
                  <td>
                        <?php
                        if ( $artist_page_id =  get_user_meta( $user->ID, 'artist_page' ) ) {
                              $artist = get_post( $artist_page_id );
                              /*d( $artist );*/
                              if ( NULL == $artist /* || $artist->post_type != 'artist' */ ) {
                                    delete_user_meta( $user->ID, 'artist_page' );
                                    unset( $artist_page_id );
                              } else {

                                    echo get_the_post_thumbnail( $artist->ID, array( 50, 50 ) );
                                    ?>
                                    <a href="<?php echo get_edit_post_link( $artist->ID ) ?>">
                                          <?php echo $artist->post_title; ?>
                                    </a>
                                    (<?php echo $artist->post_status ?>)
                                    <?php
                              }
                        }
                        /*d($artist_page_id);*/
                        ?>
                        <select  style="width: 300px;height: 100px" name="user_artist_page" size="8" >
                              <option value="" <?php echo (is_null( $artist_page_id )) ? 'selected ' : null; ?>> - empty - </option>
                              <?php
                              $query = new WP_Query( array( 'post_type' => 'artist', 'posts_per_page' => -1 ) );
                              if ( $query->have_posts() ) {
                                    while ( $query->have_posts() ) {
                                          $query->the_post();
                                          /* echo (get_the_ID() == $artist_page_id) ? 'selected '.  get_the_ID() : null; */
                                          ?>
                                          <option value="<?php the_ID() ?>" <?php echo (get_the_ID() == $artist_page_id) ? 'selected ' : null; ?>><?php the_title() ?></option>
                                          <?php
                                    }
                              }
                              ?>
                        </select>
                  </td>
            </tr>
            <!--  LABEL PAGE       -->
            <tr>
                  <th><label>Label page</label></th>
                  <td>
                        <?php
                        if ( $label_page_id = ( int ) get_user_meta( $user->ID, 'label_page', true ) ) {
                              $label_page = get_post( $label_page_id );
                              ?>
                              <?php echo get_the_post_thumbnail( $label_page->ID, array( 50, 50 ) ) ?>

                              <a href="<?php echo get_edit_post_link( $label_page->ID ) ?>"><?php echo $label_page->post_title; ?></a>
                              (<?php echo get_post()->post_status ?>)
                              <?php
                        }
                        ?>
                        <select  style="width: 300px;height: 100px" name="user_label_page" size="8" >
                              <option value=""> - empty - </option>

                              <?php
                              $query = new WP_Query( array( 'post_type' => 'label', 'posts_per_page' => -1 ) );
                              if ( $query->have_posts() ) {
                                    while ( $query->have_posts() ) {
                                          $query->the_post();
                                          ?>
                                          <option value="<?php the_ID() ?>" <?php echo (get_the_ID() == $label_page_id) ? 'selected ' : null; ?>><?php the_title() ?></option>
                                          <?php
                                    }
                              }
                              ?>

                        </select>
                  </td>
            </tr>

            <!--       Promotor         -->
            <tr>
                  <th><label>Promotor</label></th>
                  <td>
                        <?php
                        $promoter = get_user_meta( $user->ID, 'is_promoter', 'true' );
                        if ( $promoter ) {
                              $args = array(
                                    'post_type' => 'agenda',
                                    'posts_per_page' => 3,
                                    /* 'post__in' => $user_events, */
                                    'author' => $user->ID,
                                    'order' => 'ASC',
                                    'orderby' => 'meta_value_num',
                                    'meta_key' => 'wpcf-event_begin_date',
                                        /*
                                          'meta_query' => array(
                                          array(
                                          'key' => 'wpcf-event_begin_date',
                                          'value' => $start_date,
                                          'type' => 'NUMERIC',
                                          'compare' => '>='
                                          )
                                          )
                                         */
                              );

                              $query = new WP_Query( $args );
                              if ( $query->have_posts() ) {
                                    ?>
                                    <ul>

                                          <?php
                                          while ( $query->have_posts() ) {
                                                $query->the_post();
                                                ?>
                                                <li>
                                                      <?php echo get_the_post_thumbnail( get_the_ID(), array( 50, 50 ) ) ?>
                                                      <a href="<?php echo get_edit_post_link( get_the_ID() ) ?>"><?php the_title(); ?></a>
                                                      (<?php echo get_post()->post_status ?>)
                                                </li>
                                                <?php
                                          }
                                          ?>
                                    </ul>
                                    <?php
                              }
                        }
                        ?>
                  </td>
            </tr>
            <!--       USER AGENDA         -->
            <tr>
                  <th><label>User Agenda</label></th>
                  <td>
                        <?php
                        $NZRelation = New NZRelation( 'events_to_users', 'event_id', 'user_id' );
                        $user_events = $NZRelation->getRelationTo( $user->ID, TRUE );
                        $start_date = strtotime( "now" );
                        $args = array(
                              'post_type' => 'agenda',
                              'posts_per_page' => 3,
                              'post__in' => $user_events,
                              'order' => 'ASC',
                              'orderby' => 'meta_value_num',
                              'meta_key' => 'wpcf-event_begin_date',
                              'meta_query' => array(
                                    array(
                                          'key' => 'wpcf-event_begin_date',
                                          'value' => $start_date,
                                          'type' => 'NUMERIC',
                                          'compare' => '>='
                                    )
                              )
                        );

                        $query = new WP_Query( $args );
                        if ( $query->have_posts() ) {
                              ?>
                              <ul style="">

                                    <?php
                                    while ( $query->have_posts() ) {
                                          $query->the_post();
                                          ?>
                                          <li>
                                                <?php echo get_the_post_thumbnail( get_the_ID(), array( 50, 50 ) ) ?>
                                                <a href="<?php echo get_edit_post_link( get_the_ID() ) ?>"><?php the_title(); ?></a>
                                                (<?php echo get_post()->post_status ?>)
                                          </li>
                                          <?php
                                    }
                                    ?>
                              </ul>
                              <?php
                        }
                        ?>
                  </td>
            </tr>

      </table>
      <?php
}

/*
 */
add_action( 'personal_options_update', 'clubber_mag_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'clubber_mag_save_extra_profile_fields' );

function clubber_mag_save_extra_profile_fields( $user_id ) {

      if ( !current_user_can( 'edit_user', $user_id ) )
            return false;

      update_user_meta( $user_id, 'main_resource', $_POST[ 'main_resource' ] );

      update_user_meta( $user_id, 'coolplaces_ids', $_POST[ 'user_cool_places' ] );

      update_user_meta( $user_id, 'artist_page', $_POST[ 'user_artist_page' ] );

      update_user_meta( $user_id, 'label_page', $_POST[ 'user_label_page' ] );
}
