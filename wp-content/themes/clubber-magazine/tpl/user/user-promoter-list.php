<?php
$start_date = strtotime("now");


$args = array(
    'post_type' => 'agenda',
    'post_status' => 'any',
    'author' => $curauth->ID,
    'posts_per_page' => -1,
    /* 'order' => 'ASC', */
    'order' => 'DESC',
    'orderby' => 'meta_value_num',
    'meta_key' => 'wpcf-event_begin_date',
    'meta_query' => array(
        array(
            'key' => 'wpcf-event_begin_date',
            'value' => $start_date,
            'type' => 'NUMERIC',
            'compare' => '>='
        )
    )
);

$wp_query = new WP_Query($args);
?>
<main role="main" class="has-sidebar">
    <section>
        <header>
            <h1>
                <?php _e('User events'); ?>
            </h1>
        </header>


        <?php
        if (have_posts()) {
            ?>
            <ul>
                <?php
                while (have_posts()) {
                    the_post();
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
                <h2 class="ml5"><?php _e('Share events', 'cm') ?></h2>
                <?php
            } else {
                ?>
                <h2 class="ml5"><?php _e('This user has not shared any event', 'cm') ?></h2>
                <?php
            }
            ?>
            <?php
        }
        ?>
    </section>
</main>
<aside class="<?php echo roots_sidebar_class(); ?>" role="complementary">
    <?php include roots_sidebar_path(); ?>
</aside>