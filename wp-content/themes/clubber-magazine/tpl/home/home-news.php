<section>
    <?php cm_home_list_title(get_permalink(get_page_by_title('noticias')), __('Latest News', 'cm'), true); ?>
    <ul class="">
        <?php
        $query = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => 5,
            )
        );
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <li>
                <div class="p3">
                    <?php get_template_part('tpl/list/list-1'); ?>
                </div>
            </li>
            <?php
        }
        wp_reset_postdata();
        ?>
    </ul>
    <?php cm_home_list_more(get_permalink(get_page_by_title('noticias')), __('see more ...', 'cm'), true) ?>
</section>