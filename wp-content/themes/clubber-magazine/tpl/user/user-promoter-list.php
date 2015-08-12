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
<div id="primary">
    <section class="pb15">
        <div class="ml5 cb group">
            <?php
            $user_agenda_url = get_author_posts_url($curauth->ID) . 'agenda';
            ?>
            <h1 class="fl"><span title="<?php _e('User events') ?>"><?php _e('User events'); ?></span></h1>
            <span class="fr mr5 mt5">
                [ <a href="<?php echo get_permalink(get_page_by_path('subir-evento')) ?>"><?php _e('Share event', 'cm') ?></a> ]
            </span>
        </div>

        <?php
        if (have_posts()) {
            ?>
            <ul>
                <?php
                while (have_posts()) {
                    the_post();
                    ?>
                    <li class="col-1-4 fl">
                        <article>
                            <h2 class="hover" style="line-height: normal;" >
                                <a href="<?php the_permalink(); ?>" style="">
                                    <?php
                                    echo get_the_title();
                                    ?>
                                </a>
                            </h2>
                            <div class="p-detail">
                                <?php
                                $date = get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true);
                                echo date('d/m/y', $date);
                                $tax = 'city';
                                if ($term = wp_get_post_terms(get_the_ID(), $tax)[0]->name) {
                                    $link = get_term_link($term, $tax);
                                    echo " <a href='{$link}'>{$term}</a>";
                                }
                                ?>
                            </div>
                            <a class="featured-image" href="<?php echo get_permalink($event->ID); ?>">
                                <?php echo get_the_post_thumbnail(get_the_ID(), '290-160-thumb'); ?>
                            </a>
                        </article>
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

</div>
<div id="secondary">
    <?php get_sidebar('right'); ?>
</div>