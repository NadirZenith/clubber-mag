
<?php
//QUERY BY FIRST LETTER
$letter = (isset($_GET['first-letter'])) ? $_GET['first-letter'] : null;
if (!isset($letter)) {
    get_template_part('tpl/parts/random-top-list');
}
?>

<div class="mt15">

    <div class="menu-az mt15">
        <?php
        $artist_form_url = get_permalink(cm_lang_get_post(CM_RESOURCE_ARTIST_PAGE_ID));
        $after = '&nbsp;&nbsp;<a class="pure-button" href="' . $artist_form_url . '">' . __('Add new artist', 'cm') . '</a>';
//call MENU
        menu_a_z($letter, '', $after);
        ?>
    </div>
    
    <?php query_by_first_letter('artist', $letter); ?>
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
        <?php
        cm_sort_all_by_first_letter();
        ?>
    </div>
</section>
