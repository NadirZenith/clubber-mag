<?php
$posts_per_row = 4;

$args = array(
    'post_type' => get_post_type(),
    'posts_per_page' => $posts_per_row * 1,
    'orderby' => 'rand',
    'meta_query' => array(
        array(
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS',
        )
    )
);

$tax = 'coolplace_type';
if (is_tax($tax)) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => $tax,
            'field' => 'id',
            'terms' => get_queried_object_id()
        )
    );
}

$query = new WP_Query($args);
?>
<section>
    <ul class="slides">
        <?php
        if ($query->have_posts()) {
            $count = 0;
            ?> 
            <li>
                <ul class="pure-g">
                    <?php
                    while ($query->have_posts()) {
                        $query->the_post();
                        if ($count == $posts_per_row) {
                            ?>
                        </ul>
                    </li>
                    <li>
                        <ul class="pure-g">
                            <?php
                        }
                        ?>
                        <li class="pure-u-1 pure-u-sm-1-2 pure-u-md-1-4">
                            <div class="p3">
                                <?php get_template_part('tpl/list/list-2'); ?>
                            </div>
                        </li>
                        <?php
                        $count +=1;
                    } //END while
                    ?>
                </ul>
            </li>
            <?php
        } //end if have posts
        ?>
        <?php wp_reset_postdata(); ?>
    </ul>
</section>