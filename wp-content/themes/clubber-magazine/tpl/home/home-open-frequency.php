<section>
    <?php cm_home_list_title('open-frequency', __('Open Frequency', 'cm')); ?>
    <div class="homeCustomScroll oh" style="max-height: 455px;">
        <ul class="pure-g">
            <?php
            $args = array(
                'post_type' => 'open-frequency',
                'posts_per_page' => 3
            );
            $query2 = new WP_Query($args);
            while ($query2->have_posts()) {
                $query2->the_post();
                ?>
                <li class="pure-u-1">
                    <div class="p3">
                        <?php get_template_part('tpl/list/list-5'); ?>
                    </div>
                </li>
                <?php
            } //END while
            ?>
        </ul>
        <?php wp_reset_postdata(); ?>
    </div>
    <?php cm_home_list_more('open-frequency', __('see more ...', 'cm')) ?>
</section>
<script>
    (function ($) {
        $(".homeCustomScroll").mCustomScrollbar();
    })(jQuery);
</script>