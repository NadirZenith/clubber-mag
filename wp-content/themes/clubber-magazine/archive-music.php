<section class="m5">
      <header class="mt5 ml5 mb10">
          <h1 class="sc-2">
                  <?php _e( post_type_archive_title( '', false ), 'cm' ); ?>     
            </h1>
      </header>

      <ul>
            <?php
            $args = array(
                  /* 'label_name' => 'Artistas', */
                  'post_type' => 'artist',
                  'post_status' => 'publish',
                  'posts_per_page' => 1,
                  'orderby' => 'rand',
            );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) {

                  while ( $query->have_posts() ) {
                        $query->the_post();
                        $item[ 'title' ] = '<span class="sc-1">' . __( 'Artists', 'cm' ) . '</span> ' . get_the_title();
                        $item[ 'content' ] = wp_trim_words( get_the_content(), 20 );
                        $item[ 'link' ] = get_post_type_archive_link( 'artist' );
                        $item[ 'thumbnail' ] = get_the_post_thumbnail( null, '340-155-thumb' );
                        ?>
                        <li class="ibox-5 col-1">
                              <?php
                              include 'tpl/home/list-4.php';
                              ?>
                        </li>
                        <?php
                  }
            }

            wp_reset_postdata();
            $args = array(
                  'post_type' => 'podcast',
                  'post_status' => 'publish',
                  'posts_per_page' => 1,
                  'orderby' => 'rand',
                  'meta_query' => array(
                        'relation' => 'AND',
                        array(
                              'key' => 'soundcloud_special_guest',
                              'compare' => 'EXISTS',
                        ),
                        array(
                              'key' => '_thumbnail_id',
                              'compare' => 'EXISTS',
                        )
                  )
            );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) {

                  while ( $query->have_posts() ) {
                        $query->the_post();
                        $item[ 'title' ] = '<span class="sc-1">' . __( 'Podcasts', 'cm' ) . '</span> ' . get_the_title();
                        $item[ 'content' ] = wp_trim_words( get_the_content(), 20 );
                        $item[ 'link' ] = get_post_type_archive_link( 'podcast' );
                        $item[ 'thumbnail' ] = get_the_post_thumbnail( null, '340-155-thumb' );
                        ?>
                        <li class="ibox-5 col-1">
                              <?php
                              include 'tpl/home/list-4.php';
                              ?>
                        </li>
                        <?php
                  }
            }

            wp_reset_postdata();

            $post_type = 'music';
            $taxonomy = 'music_type';

            $music_terms = get_terms( $taxonomy, array(
                  'orderby' => 'count',
                  'hide_empty' => 0
                      ) );

            foreach ( $music_terms as $term ) {
                  $term_link = get_term_link( $term );
                  $args = array(
                        'posts_per_page' => 1,
                        'post_type' => $post_type,
                        'orderby' => 'rand',
                        'tax_query' => array(
                              array(
                                    'taxonomy' => 'music_type',
                                    'field' => 'slug',
                                    'terms' => $term->slug
                              )
                        )
                  );

                  $query = new WP_Query( $args );
                  if ( $query->have_posts() ) {
                        $query->the_post();
                        $item[ 'title' ] = '<span class="sc-1">' . $term->name . '</span> ' . get_the_title();
                        $item[ 'content' ] = wp_trim_words( get_the_content(), 20 );
                        $item[ 'link' ] = $term_link;
                        $item[ 'thumbnail' ] = get_the_post_thumbnail( null, '340-155-thumb' );
                        ?>
                        <li class="ibox-5 col-1">
                              <?php
                              include 'tpl/home/list-4.php';
                              ?>
                        </li>
                        <?php
                  }// have posts
            }//for each
            wp_reset_postdata();
            ?>
      </ul>
</section>
