<?php

/**
 *      CREATE MENU A -> Z FROM CURRENT PAGE
 */
function menu_a_z($default = null, $before = '', $after = '')
{
    global $wp;
    $this_page = home_url() . '/' . $wp->request;
    $query_letter = null;
    if (!empty($default)) {
        $query_letter = ($_GET['first-letter']) ? $_GET['first-letter'] : 'A';
    }
    $li_class = 'fl ml3';
    ?>
    <ul class="group">
        <?php
        if ($before) {
            ?>
            <li class='<?php echo $li_class ?>'>
                <?php echo $after ?>
            </li>
            <?php
        }

        for ($i = 0; $i < 26; ++$i) {
            $this_letter = chr(ord('A') + $i);
            $letter_link = add_query_arg('first-letter', $this_letter, $this_page);
            ?>
            <li class="<?php echo $li_class ?>">
                <a class="<?php echo ($query_letter == $this_letter) ? 'sc-3' : 'sc-2'; ?>" href="<?php echo $letter_link; ?>" title="letter-<?php echo $this_letter; ?>"> [ <?php echo $this_letter; ?> ] </a>
            </li>
            <?php
        }
        if ($after) {
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
function query_by_first_letter($post_type = null, $letter = null, $term = null)
{

    if (!$letter) {
        return;
    }

    $query_letter = (ctype_alpha($letter)) ? ucfirst($letter) : '-';

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

    if (!$term) {

        $sql = $wpdb->prepare("
                  SELECT      * FROM $wpdb->posts
                  WHERE $wpdb->posts.post_type = %s
                  and $wpdb->posts.post_status = 'publish'
                  and $wpdb->posts.post_title REGEXP %s
                  ORDER BY $wpdb->posts.post_title ASC
                  ", $post_type, $query_letter);
    } else {

        $sql = $wpdb->prepare("
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
                  ", $post_type, $query_letter, $term->taxonomy, $term->slug);
    }

    $posts = $wpdb->get_results($sql);
    if ($posts) {
        ?>
        <section>
            <h1>
                <?php _e('Result', 'cm') ?>
            </h1>
            <ul class="pure-g">
                <?php
                global $post;
                foreach ($posts as $post) {
                    setup_postdata($post);

                    $float = 'left';
                    $terms = wp_get_post_terms(get_the_ID(), 'music_type');
                    ?>
                    <li class="pure-u-1-4">
                        <div class="p3">
                            <?php get_template_part('tpl/list/list-0'); ?>
                        </div>
                    </li>
                    <?php
                }//end foreach
                ?>
            </ul>
        </section>
        <?php
    }//end if posts
    else {
        if ($letter) {
            ?>
            <div class="m15 p5 tc">
                <span class="h2">
                    <?php _e('Not Found.', 'cm'); ?>
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
function sort_all_by_first_letter($post_type = null, $term = null)
{

    if (!$post_type) {
        return;
    }
    $args = array(
        'post_type' => $post_type,
        'orderby' => 'title',
        'order' => 'ASC',
        'posts_per_page' => -1,
        /* 'lang' => implode( ' ,', pll_languages_list() ), */
    );
    /* d($term); */
    if ($term) {
        $args[$term->taxonomy] = $term->name;
    }

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        ?>
        <div class="pure-g">
            <?php
            $first = true;
            /** @todo: nz mobile version col-1-6 */
            $section_open_tag = '<section class="pure-u-1-8">';
            ?>

            <?php
            while ($query->have_posts()) {
                $query->the_post();
                $first_letter = strtoupper(substr(get_the_title(), 0, 1));

                //IF NEW LETTER
                if ($curr_letter != $first_letter) {
                    $letter_link = add_query_arg('first-letter', $first_letter);
                    if ($first) {
                        echo $section_open_tag;
                        ?> 
                        <header>
                            <h2 class="m5-">
                                <?php echo '<a class="cm-title-" href="' . $letter_link . '">' . $first_letter . '</a>'; ?> 
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
                            <h2 class="m5-">
                                <?php echo '<a class="cm-title-" href="' . $letter_link . '">' . $first_letter . '</a>'; ?> 
                            </h2> 
                        </header>
                        <?php
                        echo '<ul>';
                    }
                    $curr_letter = $first_letter;
                }
                // LI
                ?>
                <li class="ml5-" style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden">
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
        </div>

        <?php
    }// END HAVE POSTS 
    else {
        echo "<h2>Sorry, no posts were found!</h2>";
    }
    wp_reset_postdata();
}

function cm_sort_all_by_first_letter()
{
    if (have_posts()) {
        $first = true;
        $curr_letter = null;
        $section_open_tag = '<section class="pure-u-1-3 pure-u-sm-1-5 pure-u-lg-1-8">'; //letter section
        $list_open_tag = '<ul class="p3">';
        ?>
        <div class="pure-g">
            <?php
            while (have_posts()) {
                the_post();
                $first_letter = strtoupper(substr(get_the_title(), 0, 1));

                //IF NEW LETTER
                if ($curr_letter != $first_letter) {
                    $letter_link = add_query_arg('first-letter', $first_letter);
                    if ($first) {
                        echo $section_open_tag;
                        ?> 
                        <h2>
                            <a class="title" href="<?php echo $letter_link ?>"><?php echo $first_letter ?></a>
                        </h2> 
                        <?php
                        echo $list_open_tag;
                        $first = FALSE;
                    } else {
                        echo '</ul>';
                        echo '</section>';
                        echo $section_open_tag;
                        ?>
                        <h2>
                            <a class="title" href="<?php echo $letter_link ?>"><?php echo $first_letter ?></a>
                        </h2> 
                        <?php
                        echo $list_open_tag;
                    }
                    $curr_letter = $first_letter;
                }
                // LI
                ?>
                <li>
                    <article>
                        <h3 class="reset" style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden">
                            <a class="sc-2" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                    </article>
                </li>
                <?php
                // \LI
            }//END WHILE
            echo '</ul>';
            echo '</section>';
            ?>
        </div>

        <?php
    }// END HAVE POSTS 
    else {
        _e('Not found', 'cm');
    }
}

/**
 * render related podcasts()
 */
function cm_render_related_podcasts($title, $args)
{
    /*
      $args = array(
      'post_type' => 'open-frequency',
      'posts_per_page' => 5,
      'connected_items' => get_queried_object(),
      );
      if (get_post_type() == 'label') {
      $args['connected_type'] = 'open-frequency-to-label';
      } elseif (get_post_type() == 'artist') {
      $args['connected_type'] = 'open-frequency-to-artist';
      }
     */

    $query = new WP_Query($args);
    /* d($query); */
    if ($query->have_posts()) {
        ?>
        <section class="group mt15">
            <h2>
                <span  class="title">
                    <?php echo $title; ?>
                </span>
            </h2>
            <div class="cm-custom-scroll" style="max-height: 328px;">
                <ul class="pure-g">
                    <?php
                    while ($query->have_posts()) {
                        $query->the_post();
                        ?>
                        <li class="pure-u-1">
                            <article class="pr">
                                <header class="hover bottom w-100">
                                    <h2 class="reset">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title() ?>
                                        </a>
                                    </h2>
                                </header>
                                <div>
                                    <?php
                                    if ($sc_info_str = get_post_meta(get_the_ID(), CM_META_SOUNDCLOUD, true)) {
                                        $sc_info = json_decode($sc_info_str);
                                        if ($sc_info) {
                                            echo nz_get_soundcloud_iframe($sc_info->uri, array('visual' => false));
                                        }
                                    }
                                    ?>
                                </div>
                            </article>
                        </li>
                        <?php
                    } //END while
                    // Prevent weirdness
                    wp_reset_postdata();
                    wp_reset_query();
                    ?>
                </ul>
            </div>
        </section>
        <?php
    }
    ?>

    <script>
        (function ($) {
            $(window).load(function () {
                $(".cm-custom-scroll").mCustomScrollbar({});
            });
        })(jQuery);
    </script>
    <?php
}

/**
 * render related label( artist page)
 */
function cm_render_related_label($title, $args)
{

    $query = new WP_Query($args);
    /* d($query); */
    if ($query->have_posts()) {
        ?>
        <section>
            <h2>
                <span class="title">
                    <?php echo $title; ?>
                </span>
            </h2>
            <ul class="pure-g">
                <?php
                while ($query->have_posts()) {
                    $query->the_post();
                    ?>
                    <li class="pure-u-1-4">
                        <div class="p3">
                            <?php
                            get_template_part('tpl/list/list-2');
                            ?>
                        </div>
                    </li>
                    <?php
                } //END while
                // Prevent weirdness
                wp_reset_postdata();
                wp_reset_query();
                ?>
            </ul>
        </section>
        <?php
    }
    ?>

    <?php
}

/**
 * render related label( artist page)
 * 
 * //Future
  $future = array(
  'key' => 'wpcf-event_begin_date',
  'value' => time(),
  'type' => 'NUMERIC',
  'compare' => '>='
  );
  //Featured
  $featured = array(
  'key' => 'wpcf-event_featured',
  'compare' => 'EXISTS',
  );
  //Events
  $query->set('post_type', 'agenda');

  //With Thumbnail
  $with_tumbnail = array(
  'key' => '_thumbnail_id',
  'compare' => 'EXISTS',
  );

  $query->set('posts_per_page', 10);
  //Ordered by Meta Date
  $query->set('order', 'ASC');
  $query->set('orderby', 'meta_value_num');
  $query->set('meta_key', 'wpcf-event_begin_date');

  $meta_query = array(
  'relation' => 'AND',
  $future, $featured, $with_tumbnail
  );
  $query->set('meta_query', $meta_query);
 */
function cm_render_coolplace_events($place_id)
{

    //Future
    $future = array(
        'key' => 'wpcf-event_begin_date',
        'value' => time(),
        'type' => 'NUMERIC',
        'compare' => '>='
    );

    //recent -2month
    $recent = array(
        'key' => 'wpcf-event_begin_date',
        'value' => '-1 month',
        'type' => 'NUMERIC',
        'compare' => '>='
    );

    //relation to coolplace
    $relation_to_coolplace = [
        'key' => 'relation-to-coolplace',
        'compare' => '=',
        'value' => $place_id
    ];

    //with thumb
    $with_thumb = [
        'key' => '_thumbnail_id',
        'compare' => 'EXISTS',
    ];

    $base = [
        'post_type' => 'agenda',
        'posts_per_page' => '4',
        'order' => 'ASC',
        'orderby' => 'meta_value_num',
        'meta_key' => 'wpcf-event_begin_date',
    ];


    $args = array_merge($base, [
        'meta_query' => [
            'relation' => 'AND',
            $with_thumb, $relation_to_coolplace, $future
        ]
    ]);
    $title = __('Next Events', 'cm');
    $query = new WP_Query($args);

    //if no events show recent
    if (!$query->have_posts()) {

        $args = array_merge($base, [
            'meta_query' => [
                'relation' => 'AND',
                $with_thumb, $relation_to_coolplace//, $recent
            ]
        ]);
        $title = __('Recent Events', 'cm');
        $query = new WP_Query($args);
        /* d($query); */
    }

    if ($query->have_posts()) {
        ?>
        <section>
            <h2>
                <span class="title">
                    <?php echo $title; ?>
                </span>
            </h2>
            <ul class="pure-g">
                <?php
                while ($query->have_posts()) {
                    $query->the_post();
                    ?>
                    <li class="pure-u-1-4">
                        <div class="p3">
                            <?php
                            get_template_part('tpl/list/list-2');
                            ?>
                        </div>
                    </li>
                    <?php
                } //END while
                // Prevent weirdness
                wp_reset_postdata();
                wp_reset_query();
                ?>
            </ul>
        </section>
        <?php
    }
    ?>

    <?php
}
