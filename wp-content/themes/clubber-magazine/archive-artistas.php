<?php

/**
 * Displays the index section of the theme.
 *
 * @package Theme Horse
 * @subpackage Attitude
 * @since Attitude 1.0
 */
// CREATE MENU A-Z
function menu_a_z() {
        global $wp;
        $this_page = home_url() . '/' . $wp->request;
        ?>

        <ul class="group mb15">
                <?php
                for ($i = 0; $i < 26; ++$i) {
                        $this_letter = chr(ord('A') + $i);
                        $letter_link = add_query_arg('first-letter', $this_letter, $this_page);
                        ?>
                        <li>
                                <a class="fl ml5" href="<?php echo $letter_link; ?>" title="letter-<?php echo $this_letter; ?>"> [ <?php echo $this_letter; ?> ] </a>
                        </li>
                        <?php
                }
                ?>
        </ul>

        <?php
}

//query by firs letter
function query_by_first_letter() {

        $query_letter = ($_GET['first-letter']) ? $_GET['first-letter'] : 'A';
        $query_letter = '^' . $query_letter; // Prefix with caret to match beginning of string.
        global $wpdb;

        $sql = $wpdb->prepare("
                  SELECT      * FROM $wpdb->posts
                  WHERE $wpdb->posts.post_type = 'artistas'
                  and $wpdb->posts.post_status = 'publish'
                  and $wpdb->posts.post_title REGEXP %s
                  ORDER BY $wpdb->posts.post_title ASC
                  ", $query_letter);

        $posts = $wpdb->get_results($sql);
        ?>
        <ul class="">

                <?php
                if ($posts) {
                        global $post;
                        foreach ($posts as $post) {
                                setup_postdata($post);

                                $float = 'left';
                                $terms = wp_get_post_terms(get_the_ID(), 'music_type');
                                ?>
                                <li>

                                        <section class="bg-50 block-5 fl col-1-4"  >
                                                <article>
                                                        <header class="">
                                                                <h1 class="ml5">
                                                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                                                </h1>
                                                        </header>
                                                        <hr class="pb5">

                                                        <div class="fl featured-image" style="width: 100%">
                                                                <?php
                                                                if (has_post_thumbnail()) {
                                                                        the_post_thumbnail('290-160-thumb');
                                                                }
                                                                ?>
                                                        </div>
                                                        <div class="ml5 mb5 mt5 mr5 meddium" style="text-align: justify;">
                                                                <?php the_excerpt(); ?>
                                                        </div>
                                                        <a class="readmore mr15 mb15" href="<?php the_permalink() ?>" title="<?php the_title() ?>"> <?php echo __('Read more', 'attitude') ?></a>

                                                </article>
                                        </section>
                                </li>

                                <?php
                        }//end while
                } else {
                        ?>
                        <h1 class=""><?php _e('No Posts Found.', 'attitude'); ?></h1>
                        <?php
                }
                ?>

        </ul>
        <?php
        wp_reset_postdata();
}

//sort_all_by_first_letter
function sort_all_by_first_letter() {
        /* $posts_per_row = 3; */
        $args = array(
              'post_type' => 'artistas',
              'orderby' => 'title',
              'order' => 'ASC',
              'posts_per_page' => -1,
        );
        $query = new WP_Query($args);
        d($query);
        if ($query->have_posts()) {
                ?>
                <ul class="group mt15">
                        <?php
                        while ($query->have_posts()) {
                                $query->the_post();
                                $first_letter = strtoupper(substr(get_the_title(), 0, 1));
                                //IF NEW LETTER
                                if ($first_letter != $curr_letter) {
                                        if ($open_ul) {
                                                echo '</ul>';
                                                $open_ul = false;
                                        }
                                        echo '<ul class="fl bg-50 block-5" style="width:150px;">';
                                        $open_ul = true;
                                        $letter_link = add_query_arg('first-letter', $first_letter, $this_page);
                                        ?>
                                        <lh style="">
                                                <h1 class="ml5"><a href="<?php echo $letter_link ?>"><?php echo $first_letter ?></a></h1>
                                                <hr class="pb5">
                                        </lh>

                                        <?php
                                        $curr_letter = $first_letter;
                                }
                                ?>

                                <li class="ml5" style="">
                                        <a href="<?php the_permalink() ?>" style="color: #eee" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                </li>

                                <?php
                        }//END WHILE
                        echo '</ul>';
                        ?>
                </ul><!-- End id='a-z' -->

                <?php
        } else {
                echo "<h2>Sorry, no posts were found!</h2>";
        }
        wp_reset_postdata();
}
?>



<?php get_header(); ?>

<div id="container">

        <?php
//call MENU
        menu_a_z();
        ?>
        <div class="cb"></div>

        <?php
//QUERY BY FIRST LETTER
        query_by_first_letter();
         
        ?>

        <div class="cb"></div>

        <?php
//sort_all_by_first_letter
        sort_all_by_first_letter();
        ?>

</div><!-- #container -->

<?php get_footer(); ?>
