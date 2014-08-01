
<?php get_header(); ?>

<div id="container">
        <?php
        $letter = (isset($_GET['first-letter'])) ? $_GET['first-letter'] : null;
        //call MENU
        menu_a_z($letter);
        ?>
        <div class="cb"></div>

        <?php
        //QUERY BY FIRST LETTER
        query_by_first_letter('cool-place', $letter);
        ?>

        <div class="cb"></div>

        <?php
        //sort_all_by_first_letter
        sort_all_by_first_letter('cool-place');
        ?>


</div>

<?php get_footer(); ?>
