<?php
/**
 *    @todo nz show all next events, show last events (1 line - pagination) if any
 */
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$meta_query = array(
    array(
        'key' => 'wpcf-event_begin_date',
        'value' => time(),
        'type' => 'NUMERIC',
        'compare' => '>='
    )
);
$args = array(
    'post_type' => 'agenda',
    'connected_type' => 'events_to_users',
    'connected_items' => $curauth->ID,
    'nopaging' => true,
    'meta_query' => $meta_query
);

$query2 = new WP_Query($args);
?>

<main role="main" class="has-sidebar">
    <section class="pb15 cb">

        <header class="mt5 mb10 ml5 mt15">
            <h1>
                <span class="cm-title">
                    <?php _e('Agenda', 'cm') ?>
                </span>
            </h1>
        </header>


        <?php
        if ($query2->have_posts()) {
            ?>
            <ul>
                <?php
                while ($query2->have_posts()) {
                    $query2->the_post();
                    ?>
                    <li class="col-1-5 fl">
                        <div class="ibox-3 mt0">
                            <?php
                            get_template_part('tpl/home/list-2');
                            ?>
                        </div>
                    </li>
                    <?php
                }
                ?>

            </ul>
            <?php
        } else {
            if ($curauth->ID == get_current_user_id()) {
                ?>
                <h2 class="ml5">
                    <?php _e('¡Subscribe to events!', 'cm'); ?>

                </h2>
                <?php
            } else {
                ?>
                <h2 class="ml5">
                    <?php e('This user has not subscribed to any event', 'cm'); ?>
                </h2>
                <?php
            }
            ?>
            <?php
        }
        ?>
    </section>

</main>
<aside role="complementary">
    <?php get_sidebar(); ?>
</aside>