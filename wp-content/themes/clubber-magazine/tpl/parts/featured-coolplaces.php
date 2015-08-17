<?php
$posts_per_row = 4;

$args = array(
    'post_type' => 'cool-place',
    'posts_per_page' => $posts_per_row * 1,
    'order' => 'rand',
    'orderby' => 'meta_valua',
    'meta_query' => array(
        array(
            'key' => 'featured',
            'value' => 'on',
            'compare' => '=',
        )
    )
);

$query = new WP_Query($args);
?>
<section>
    <header>
        <h1>
            <span class="title">
                <?php _e('Featured Cool Places', 'cm') ?>
            </span>
        </h1>
    </header>

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