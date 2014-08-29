
<?php
$tax = 'cool_place_type';
if (!is_tax($tax)) {
        die(404);
}
global $wp_query;
$term = $wp_query->get_queried_object();
?>
<h1>
        <?php echo ucfirst($term->name); ?>
</h1>

<?php
$letter = (isset($_GET['first-letter'])) ? $_GET['first-letter'] : null;
//call MENU
menu_a_z($letter);
?>
<div class="cb"></div>

<?php
//QUERY BY FIRST LETTER
query_by_first_letter('cool-place', $letter, $term);
?>

<div class="cb"></div>

<?php
//sort_all_by_first_letter
sort_all_by_first_letter('cool-place', $term);
?>

