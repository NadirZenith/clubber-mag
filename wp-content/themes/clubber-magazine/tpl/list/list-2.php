<?php
/*
 * Featured list item
 */
?>
<article class="pr">
    <div class="hover bottom w-100 slideU">
        <h2 class="reset h3">
            <a href="<?php the_permalink(); ?>">
                <?php echo get_the_title() ?>
            </a>
        </h2>
    </div>
    <?php if ($date = get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true)): ?>
        <div class="hover top right">
            <?php
            if (is_numeric($date) && (int) $date == $date) {
                echo date('d/m/y ', $date);
            }
            echo nz_get_post_city_link(get_the_ID());
            ?>
        </div>
    <?php endif; ?>
    <?php
    if ($sc_info_str = get_post_meta(get_the_ID(), CM_META_SOUNDCLOUD, true)) {
        $sc_info = json_decode($sc_info_str);
        if ($sc_info) {
            echo nz_get_soundcloud_iframe($sc_info->uri);
        }
    } elseif (has_post_thumbnail()) {
        ?>
        <a class="featured-image" href="<?php echo get_permalink($event->ID); ?>">
            <?php the_post_thumbnail('290-160-thumb'); ?>
        </a>
        <?php
    } elseif ($meta_video_url = get_metadata('post', get_the_ID(), 'wpcf-video-url', true)) {
        ?>
        <div class="iframe-container">
            <?php
            echo cm_render_video($meta_video_url);
            ?>
        </div>
        <?php
    }
    ?>
</article>
