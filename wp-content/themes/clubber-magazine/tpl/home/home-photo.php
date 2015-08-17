<section>
    <?php cm_home_list_title('photo', __('Photo Gallery', 'cm')); ?>
    <div class="home-slider">
        <ul class="slides">
            <?php
            $query = new WP_Query(array(
                'post_type' => 'photo',
                'posts_per_page' => 3,
                )
            );
            while ($query->have_posts()) {
                $query->the_post();
                ?>
                <li>
                    <div class="p3">
                        <?php get_template_part('tpl/list/photo-list-0'); ?>
                    </div>
                </li>
                <?php
            }
            ?>
            <?php wp_reset_postdata(); ?>
        </ul>
        <?php cm_home_list_more('photo', __('see more ...', 'cm')) ?>
    </div>
</section>