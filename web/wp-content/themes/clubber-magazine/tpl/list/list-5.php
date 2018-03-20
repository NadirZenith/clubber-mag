<?php
/*
 * podcast list item
 */
?>
<article class="pr">

    <?php
    if (get_post_type() == 'into-the-beat') {
        get_template_part('tpl/podcast/into-the-beat-header');
    }

    if (is_post_type_archive('open-frequency')) {
        get_template_part('tpl/podcast/open-frequency-header-top');
    }

    if ('open-frequency' == get_post_type() && is_front_page()) {

        get_template_part('tpl/podcast/open-frequency-header-bottom');
    }
    ?>

    <?php
    get_template_part('tpl/podcast/soundcloud-iframe');
    ?>

</article>
