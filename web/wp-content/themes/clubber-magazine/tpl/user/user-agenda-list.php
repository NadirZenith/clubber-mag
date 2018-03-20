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
    <section>

        <header>
            <h1>
                <?php _e('Agenda', 'cm') ?>
                <?php echo $curauth->get('display_name'); ?>
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
                    <li class="pure-u-1-2 pure-u-md-1-5">
                        <div class="p3">
                            <?php get_template_part('tpl/list/list-2'); ?>
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
                <h2>
                    <?php _e('¡Subscribe to events!', 'cm'); ?>

                </h2>
                <?php
            } else {
                ?>
                <h2>
                    <?php _e('This user has not subscribed to any event', 'cm'); ?>
                </h2>
                <?php
            }
        }
        ?>
    </section>
</main>
<aside class="<?php echo roots_sidebar_class(); ?>" role="complementary">
    <?php include roots_sidebar_path(); ?>
</aside>