<?php

/**
 *      CREATE MENU A -> Z FROM CURRENT PAGE
 */
function menu_a_z( $default = null, $before = '', $after = '' ) {
      global $wp;
      $this_page = home_url() . '/' . $wp->request;
      $query_letter = null;
      if ( !empty( $default ) ) {
            $query_letter = ($_GET[ 'first-letter' ]) ? $_GET[ 'first-letter' ] : 'A';
      }
      $li_class = 'fl ml3';
      ?>
      <ul class="group">
            <?php
            if ( $before ) {
                  ?>
                  <li class='<?php echo $li_class ?>'>
                        <?php echo $after ?>
                  </li>
                  <?php
            }

            for ( $i = 0; $i < 26; ++$i ) {
                  $this_letter = chr( ord( 'A' ) + $i );
                  $letter_link = add_query_arg( 'first-letter', $this_letter, $this_page );
                  ?>
                  <li class="<?php echo $li_class ?>">
                        <a class="<?php echo ($query_letter == $this_letter) ? 'sc-eee' : ''; ?>" href="<?php echo $letter_link; ?>" title="letter-<?php echo $this_letter; ?>"> [ <?php echo $this_letter; ?> ] </a>
                  </li>
                  <?php
            }
            if ( $after ) {
                  ?>
                  <li class='<?php echo $li_class ?>'>
                        <?php echo $after ?>
                  </li>
                  <?php
            }
            ?>
      </ul>

      <?php
}

/**
 *      Query post type by first letter
 */
function query_by_first_letter( $post_type = null, $letter = null, $term = null ) {

      if ( !$letter ) {
            /* return; */
      }

      $query_letter = (ctype_alpha( $letter )) ? ucfirst( $letter ) : 'A';

      $query_letter = '^' . $query_letter; // Prefix with caret to match beginning of string.
      global $wpdb;

      /*
        $languages = get_terms( 'language' );
        d( $languages );
        $languages_ids = array();
        foreach ( $languages as $language ) {
        $languages_ids[] = $language->term_id;
        }
        if ( !empty( $languages_ids ) ) {
        $join = $wpdb->prepare( " INNER JOIN $wpdb->term_relationships AS pll_tr ON pll_tr.object_id = $wpdb->posts.ID" );
        $where_lang = $wpdb->prepare( " AND pll_tr.term_taxonomy_id IN (" . implode( ', ', $languages_ids ) . ")" );
        }
       */

      if ( !$term ) {

            $sql = $wpdb->prepare( "
                  SELECT      * FROM $wpdb->posts
                  WHERE $wpdb->posts.post_type = %s
                  and $wpdb->posts.post_status = 'publish'
                  and $wpdb->posts.post_title REGEXP %s
                  ORDER BY $wpdb->posts.post_title ASC
                  ", $post_type, $query_letter );
      } else {
            /* d($wpdb); */
            /* d($term); */
            $sql = $wpdb->prepare( "
                  SELECT      * FROM $wpdb->posts
                LEFT JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id)
                LEFT JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
                        LEFT JOIN $wpdb->terms ON($wpdb->term_taxonomy.term_id = $wpdb->terms.term_id)
                  WHERE $wpdb->posts.post_type = %s
                  AND $wpdb->posts.post_status = 'publish'
                  AND $wpdb->posts.post_title REGEXP %s
                  AND $wpdb->term_taxonomy.taxonomy = %s
                  AND $wpdb->terms.slug = %s
                  ORDER BY $wpdb->posts.post_title ASC
                  ", $post_type, $query_letter, $term->taxonomy, $term->slug );
      }
      $posts = $wpdb->get_results( $sql );
      ?>
      <?php
      if ( $posts ) {
            ?>
            <ul>
                  <?php
                  global $post;
                  foreach ( $posts as $post ) {
                        setup_postdata( $post );

                        $float = 'left';
                        $terms = wp_get_post_terms( get_the_ID(), 'music_type' );
                        ?>
                        <li class="col-1 col-sm-1-2 col-lg-1-4 fl mb30">
                              <?php
                              get_template_part( 'tpl/parts/list-0' );
                              ?>
                        </li>

                        <?php
                  }//end foreach
                  ?>
            </ul>
            <?php
      }//end if posts
      else {
            if ( $letter ) {
                  ?>
                  <div class="m15 p5 tc">
                        <span class="h2">
                              <?php _e( 'No Posts Found.', 'cm' ); ?>
                        </span>
                  </div>
                  <?php
            }
      }
      ?>

      <?php
      wp_reset_postdata();
}

/**
 *      Sort all post type by first letter
 */
function sort_all_by_first_letter( $post_type = null, $term = null ) {

      if ( !$post_type ) {
            return;
      }
      $args = array(
            'post_type' => $post_type,
            'orderby' => 'title',
            'order' => 'ASC',
            'posts_per_page' => -1,
            /*'lang' => implode( ' ,', pll_languages_list() ),*/
      );
      /* d($term); */
      if ( $term ) {
            $args[ $term->taxonomy ] = $term->name;
      }

      $query = new WP_Query( $args );
      if ( $query->have_posts() ) {
            $first = true;
            /** @todo: nz mobile version col-1-6 */
            /* $section_open_tag = '<section class="fl" style="width:16%;margin:0.3%">'; */
            $section_open_tag = '<section class="fl" style="width:150px;margin:5px">';
            ?>

            <?php
            while ( $query->have_posts() ) {
                  $query->the_post();
                  $first_letter = strtoupper( substr( get_the_title(), 0, 1 ) );

                  //IF NEW LETTER
                  if ( $curr_letter != $first_letter ) {
                        $letter_link = add_query_arg( 'first-letter', $first_letter );
                        if ( $first ) {
                              echo $section_open_tag;
                              ?> 
                              <header>
                                    <h2 class="m5">
                                          <?php echo '<a class="cm-title" href="' . $letter_link . '">' . $first_letter . '</a>'; ?> 
                                    </h2> 
                              </header>
                              <?php
                              echo '<ul>';
                              $first = FALSE;
                        } else {
                              echo '</ul>';
                              echo '</section>';
                              echo $section_open_tag;
                              ?>
                              <header>
                                    <h2 class="m5">
                                          <?php echo '<a class="cm-title" href="' . $letter_link . '">' . $first_letter . '</a>'; ?> 
                                    </h2> 
                              </header>
                              <?php
                              echo '<ul>';
                        }
                        $curr_letter = $first_letter;
                  }
                  // LI
                  ?>
                  <li class="ml5" style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden">
                        <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
                              <?php the_title(); ?>
                        </a>
                  </li>
                  <?php
                  // \LI
            }//END WHILE
            echo '</ul>';
            echo '</section>';
            ?>

            <?php
      }// END HAVE POSTS 
      else {
            echo "<h2>Sorry, no posts were found!</h2>";
      }
      wp_reset_postdata();
}
