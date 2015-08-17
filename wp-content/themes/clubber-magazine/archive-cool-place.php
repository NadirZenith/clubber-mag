
<?php
$letter = (isset($_GET['first-letter'])) ? $_GET['first-letter'] : null;
if (is_post_type_archive('cool-place') && !isset($letter)) {
    //featured coolplaces
    get_template_part('tpl/parts/featured-coolplaces');
}
?>

<div class="mt15">
    <div class="group ">
        <?php echo NzWpLocationTerms::get_location_filter(); ?>
    </div>

    <div class="menu-az mt15">
        <?php
        //call MENU
        $after = '';
        $terms = get_terms('cool_place_type');
        $query_string = (!empty($_SERVER['QUERY_STRING'])) ? '?' . $_SERVER['QUERY_STRING'] : '';
        foreach ($terms as $term) {
            $term_link = rtrim(get_term_link($term), '/') . $query_string;
            /* d($term_link); */

            $after .= '[ <a class="sc-2" href="' . $term_link . '">' . $term->name . '</a> ]';
        }

        $coolplace_form_url = get_permalink(cm_lang_get_post(CM_RESOURCE_COOLPLACE_PAGE_ID));
        $after .= '&nbsp;&nbsp;<a class="pure-button" href="' . $coolplace_form_url . '">' . __('Add new place', 'cm') . '</a>';

        menu_a_z($letter, '', $after);
        ?>        
    </div>
    <?php
    //QUERY BY FIRST LETTER
    $term_name = get_query_var('cool_place_type', '');

    $term = get_term_by('name', $term_name, 'cool_place_type');
    query_by_first_letter('cool-place', $letter, $term);
    ?>

</div>
<section>
    <header>
        <h1>
            <?php
            post_type_archive_title();
            single_tag_title();
            ?>
        </h1>
    </header>
    <!--  ALL GROUPED BY FIRST LETTER  -->
    <div class="menu-all-first-letter">
        <?php cm_sort_all_by_first_letter(); ?>
    </div>
    <?php
    if (NzWpLocationTerms::$current_city->slug == 'barcelona') {
        get_template_part('tpl/parts/coolplaces-archive-map');
    }
    ?>
</section>