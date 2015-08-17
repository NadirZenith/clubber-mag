
<?php
//related content
$args = array(
    'post_type' => get_post_type(),
    'posts_per_page' => 4,
    'orderby' => 'rand',
    'post__not_in' => array(get_queried_object_id())
);
if (get_post_type() == 'agenda') {
    //events in future with image
    $args['meta_query'] = array(
        'relation' => 'AND',
        array(
            'key' => 'wpcf-event_begin_date',
            'value' => time(),
            'type' => 'NUMERIC',
            'compare' => '>='
        ),
        array(
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS',
        )
    );
} elseif (in_array(get_post_type(), ['artist', 'cool-place'])) {
    //artist or coolplace with image
    $args['meta_query'] = array(
        array(
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS',
        )
    );
} elseif (in_array(get_post_type(), ['into-the-beat', 'open-frequency'])) {
    
} elseif ('photo' == get_post_type()) {
    
} else {
    // other types should query more recent posts -1 month
    $args['meta_query'] = array(
        array(
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS',
        )
    );
    $args['date_query'] = array(
        array(
            'after' => '-1 month',
        )
    );
}
$query = new WP_Query($args);
if ($query->have_posts()) {
    ?>
    <section>
        <h2>
            <span class="title-highlight">
                <?php _e('Related Contents', 'cm') ?>
            </span>
        </h2>
        <ul class="pure-g">
            <?php
            while ($query->have_posts()) {
                $query->the_post();
                ?>
                <li class="pure-u-1-4">
                    <div class="p3">
                        <?php get_template_part('tpl/list/list-2'); ?>
                    </div>
                </li>
                <?php
            }
            wp_reset_postdata();
            ?>
        </ul>     
    </section>
    <?php
}
?>