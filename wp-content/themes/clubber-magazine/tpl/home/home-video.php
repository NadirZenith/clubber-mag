<section class="video">
    <?php cm_home_list_title('video', __('Video review', 'cm')); ?>
    <div class="home-slider pr">
        <ul class="slides">
            <?php
            $query = new WP_Query(array(
                'post_type' => 'video',
                'posts_per_page' => 3,
                )
            );
            while ($query->have_posts()) {
                $query->the_post();
                if ($meta_video_url = get_post_meta(get_the_ID(), 'wpcf-video-url', true)) {
                    ?>
                    <li>
                        <div class="p3">
                            <article class="pr">
                                <header class="hover top w-100">
                                    <h2 class="reset"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
                                </header>
                                <div class="iframe-container">
                                    <?php echo cm_render_video($meta_video_url); ?>
                                </div>
                            </article>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
            <?php wp_reset_postdata(); ?>
        </ul>
        <?php cm_home_list_more('video', __('see more ...', 'cm')) ?>
    </div>
</section>