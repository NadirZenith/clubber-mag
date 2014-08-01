<?php
/**
 * Displays the index section of the theme.
 *
 * @package Theme Horse
 * @subpackage Attitude
 * @since Attitude 1.0
 */
?>



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
        query_by_first_letter('artista', $letter);
        ?>

        <div class="cb"></div>

        <?php
        //sort_all_by_first_letter
        sort_all_by_first_letter('artista');
        ?>


</div>

<?php get_footer(); ?>
