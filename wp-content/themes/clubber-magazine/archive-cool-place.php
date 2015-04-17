<section class="m5">
    <header class="mt5 ml5 mb10">
        <h1 class="sc-2">
            <?php
            post_type_archive_title();
            single_tag_title();
            ?>
        </h1>
    </header>

    <?php
    $letter = (isset($_GET['first-letter'])) ? $_GET['first-letter'] : null;

    if (is_post_type_archive('cool-place') && !isset($letter)) {
        get_template_part('tpl/parts/featured-coolplaces');
    } elseif (is_tax('cool_place_type')) {
        get_template_part('tpl/parts/random-top-list');
    }
    ?>

    <div class="m5 p5 menu-az">
        <div class="group cb mb15">
            <?php echo NzWpLocationTerms::get_location_filter(); ?>
        </div>
        <?php
        //call MENU
        $after = '';
        $terms = get_terms('cool_place_type');
        $query_string = (!empty($_SERVER['QUERY_STRING'])) ? '?' . $_SERVER['QUERY_STRING'] : '';
        foreach ($terms as $term) {
            $term_link = rtrim(get_term_link($term), '/') . $query_string;
            /* d($term_link); */

            $after .= '[ <a href="' . $term_link . '">' . $term->name . '</a> ]';
        }

        $coolplace_form_url = get_permalink(cm_lang_get_post(CM_RESOURCE_COOLPLACE_PAGE_ID));
        $after .= '&nbsp;&nbsp;<a class="readmore" href="' . $coolplace_form_url . '">' . __('Add new place', 'cm') . '</a>';

        menu_a_z($letter, '', $after);
        ?>        
    </div>
    <div class="cb"></div>

    <?php
//QUERY BY FIRST LETTER
    $term_name = get_query_var('cool_place_type', '');

    $term = get_term_by('name', $term_name, 'cool_place_type');
    query_by_first_letter('cool-place', $letter, $term);
    ?>

    <div class="cb"></div>
    <div class="m5 p5 menu-all-first-letter">
        <?php
//sort_all_by_first_letter
        /* sort_all_by_first_letter('cool-place', $term); */
        /*        -----------------------       */

        if (have_posts()) {
            $first = true;
            /** @todo: nz mobile version col-1-6 */
            /* $section_open_tag = '<section class="fl" style="width:16%;margin:0.3%">'; */
            $section_open_tag = '<section class="fl" style="width:150px;margin:5px">';
            ?>

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
            _e('No coolplaces found', 'cm');
        }

        /*        -----------------------       */
        ?>
    </div>

    <div class="cb"></div>
    <?php
    if (NzWpLocationTerms::$current_city->slug == 'barcelona') {
        get_template_part('tpl/parts/coolplaces-archive-map');
    }
    ?>


</section>
