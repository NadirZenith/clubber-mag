<?php
/*
 * this template render events related to some coolplace
 */
$args = array(
    'post_type' => 'agenda',
    'author' => -$curauth->ID,
    'meta_query' => array(
        'compare' => 'AND',
        array(
            'key' => 'wpcf-event_begin_date',
            'value' => time(),
            'type' => 'NUMERIC',
            'compare' => '>='
        ),
        array(
            'key' => 'relation-to-coolplace',
            'value' => $resource->ID,
            'type' => 'NUMERIC',
            'compare' => '='
        )
    )
);

if ($curauth->ID == get_current_user_id())
    $args['post_status'] = 'any';

$query2 = new WP_Query($args);

if ($query2->have_posts()) {
    ?>
    <ul class="pure-g">
        <?php
        while ($query2->have_posts()) {
            $query2->the_post();
            ?>
            <li class="pure-u-1-3">
                <div class="p3">
                    <?php get_template_part('tpl/home/list-2'); ?>
                </div>
            </li>
            <?php
        }
        ?>
    </ul>
    <?php
    wp_reset_postdata();
}
?>
