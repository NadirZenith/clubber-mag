<?php
/*    MAIN AGENDA QUERY              */

$first = true;
$last_date = null;
$section_open = '<section>';
$section_close = '</section>';
$list_open = '<ul>';
$list_close = '</ul>';

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        //save events id for later use
        $main_posts_id[] = get_the_ID();

        $date = get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true); //1394924400

        if (is_numeric($date) && (int) $date == $date) {
            $post_date = date('l d/m/y', $date); //"15/03/14"
        }

        if ($last_date != $post_date) {
            if ($first) {
                $first = FALSE;
                // ---------------------------
                echo $section_open;
                ?>
                <header>
                    <h1>
                        <span class="title-highlight">
                            <?php echo $post_date ?>
                        </span>
                    </h1>
                </header>
                <?php
                echo $list_open;
                // ---------------------------
            } else {
                echo $list_close;
                echo $section_close;
                // ---------------------------
                echo $section_open;
                ?>
                <header>
                    <h1>
                        <span class="title-highlight">
                            <?php echo $post_date ?>
                        </span>
                    </h1>
                </header>
                <?php
                echo $list_open;
                // ---------------------------
            }
        }
        $last_date = $post_date;
        ?>
        <li>
            <?php get_template_part('tpl/list/list-3'); ?>
        </li>
        <?php
        if ($query->current_post == ($query->found_posts - 1)) {
            echo $list_close;
            echo $section_close;
        }
    }//END WHILE
} else {
    $new_event_link = get_permalink(cm_lang_get_post(CM_RESOURCE_EVENT_PAGE_ID));
    ?>
    <p class="tc">
        <?php _e('Sorry! Currently we don´t have events available in this region. You can upload your events in the following link', 'cm') ?>
    </p>
    <p class="tc mt15">
        <a class="pure-button pure-button-primary" href="<?php echo $new_event_link ?>" >
            <?php _e('Upload and share event', 'cm') ?>&nbsp;
            <i class="fa fa-users" style="color: #0583F2"></i>
        </a>
    </p>
    <?php
}
?>