<?php
/**
 * Template Name: Archive noticias
 *
 * Displays archive for noticias (posts)
 *
 */

include 'archive.php';
return;
?>
<section>
    <h1>
        <?php _e('News Archive', 'cm') ?> 
    </h1>
    <?php
    if (have_posts()) {
        ?>
        <ul class="pure-g">
            <?php
            while (have_posts()) {
                the_post();
                ?>
                <li class="pure-u-1">
                    <?php get_template_part('tpl/list/list-3'); ?>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php
    } else {
        get_template_part('tpl/parts/not-found');
    }
    ?>
    <?php get_template_part('tpl/parts/pagination'); ?>
</section>