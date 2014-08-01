<?php

/**
 *      CREATE MENU A -> Z FROM CURRENT PAGE
 */
function menu_a_z($default = null) {
        global $wp;
        $this_page = home_url() . '/' . $wp->request;
        $query_letter = null;
        if (!empty($default)) {
                $query_letter = ($_GET['first-letter']) ? $_GET['first-letter'] : 'A';
        }
        ?>

        <ul class="group mb15 meddium">
                <?php
                for ($i = 0; $i < 26; ++$i) {
                        $this_letter = chr(ord('A') + $i);
                        $letter_link = add_query_arg('first-letter', $this_letter, $this_page);
                        ?>
                        <li>
                                <a class="fl ml5 <?php echo ($query_letter == $this_letter) ? 'sc-eee' : ''; ?>" href="<?php echo $letter_link; ?>" title="letter-<?php echo $this_letter; ?>"> [ <?php echo $this_letter; ?> ] </a>
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
function query_by_first_letter($post_type = null, $letter = null) {

        if (!$letter) {
                return;
        }

        $query_letter = (ctype_alpha($letter)) ? ucfirst($letter) : 'A';

        $query_letter = '^' . $query_letter; // Prefix with caret to match beginning of string.
        global $wpdb;

        $sql = $wpdb->prepare("
                  SELECT      * FROM $wpdb->posts
                  WHERE $wpdb->posts.post_type = %s
                  and $wpdb->posts.post_status = 'publish'
                  and $wpdb->posts.post_title REGEXP %s
                  ORDER BY $wpdb->posts.post_title ASC
                  ", $post_type, $query_letter);

        $posts = $wpdb->get_results($sql);
        ?>
        <?php
        if ($posts) {
                ?>
                <ul>
                        <?php
                        global $post;
                        foreach ($posts as $post) {
                                setup_postdata($post);

                                $float = 'left';
                                $terms = wp_get_post_terms(get_the_ID(), 'music_type');
                                ?>
                                <li>
                                        <section>

                                                <article class="bg-50 block-5 fl col-1-4">
                                                        <h1 class="ml5">
                                                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                                                        <?php
                                                                        /* echo get_the_title() */
                                                                        echo mb_strimwidth(get_the_title(), 0, 32, ' ...');
                                                                        ?>
                                                                </a>
                                                        </h1>
                                                        <hr class="pb5">

                                                        <div class="fl"  style="width: 100%">
                                                                <?php
                                                                if (has_post_thumbnail()) {
                                                                        ?>
                                                                        <a class="featured-image" href="<?php the_permalink() ?>">
                                                                                <?php
                                                                                the_post_thumbnail('290-160-thumb');
                                                                                ?>
                                                                        </a>
                                                                        <?php
                                                                }
                                                                ?>
                                                        </div>
                                                        <div class="cb"></div>
                                                        <div class="ml5 mb5 mt5 mr5 meddium" style="text-align: justify; height: 70px;">
                                                                <?php
                                                                echo wp_trim_words(get_the_content(), 15, $more = null);
                                                                ?>
                                                        </div>
                                                        <a class="readmore mr15 mb15" href="<?php the_permalink() ?>" title="<?php the_title() ?>"> <?php echo __('Read more', 'attitude') ?></a>

                                                </article>
                                        </section>

                                </li>
                                <?php
                        }//end foreach
                        ?>
                </ul>
                <?php
        }//end if posts
        else {
                if ($letter) {
                        ?>
                        <li class="meddium"><?php _e('No Posts Found.', 'attitude'); ?></li>
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
function sort_all_by_first_letter($post_type = null) {

        if (!$post_type) {
                return;
        }
        $args = array(
              'post_type' => $post_type,
              'orderby' => 'title',
              'order' => 'ASC',
              'posts_per_page' => -1,
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
                $first = true;
                /** @todo: nz mobile version col-1-6 */
                /* $section_open_tag = '<section class="fl" style="width:16%;margin:0.3%">'; */
                $section_open_tag = '<section class="fl" style="width:150px;margin:5px">';
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
                                                <h2 class="ml5 bold sc-3">
                                                        <?php echo '<a href="' . $letter_link . '">' . $first_letter . '</a>'; ?> 
                                                </h2> 
                                                <hr class="pb5">
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
                                                <h2 class="ml5 bold sc-3">
                                                        <?php echo '<a href="' . $letter_link . '">' . $first_letter . '</a>'; ?> 
                                                </h2> 
                                                <hr class="pb5">
                                        </header>
                                        <?php
                                        echo '<ul>';
                                }
                                $curr_letter = $first_letter;
                        }
                        // LI
                        ?>
                        <li class="ml5" style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden">
                                <a href="<?php the_permalink() ?>" style="color: #eee" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
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
