<?php
if (in_array(get_post_type(), ['label', 'artist'])) {
    $type = get_post_type();
    cm_render_related_podcasts('Open frequency', [
        'post_type' => 'open-frequency',
        'posts_per_page' => 5,
        'connected_items' => get_queried_object(),
        'connected_type' => 'open-frequency-to-' . $type
    ]);
}

return;
$args = array(
    'post_type' => 'open-frequency',
    'posts_per_page' => 5,
    'connected_items' => get_queried_object(),
);
if (get_post_type() == 'label') {
    $args['connected_type'] = 'open-frequency-to-label';
} elseif (get_post_type() == 'artist') {
    $args['connected_type'] = 'open-frequency-to-artist';
}

$query = new WP_Query($args);
if ($query->have_posts()) {
    ?>
    <section>
        <h2>
            Open frequency -------------
        </h2>
        <div class="cm-custom-scroll" style="max-height: 328px;">
            <ul class="pure-g">
                <?php
                while ($query->have_posts()) {
                    $query->the_post();
                    ?>
                    <li class="pure-u-1">
                        <article>
                            <header class="hover ">
                                <h2>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title() ?>
                                    </a>
                                </h2>
                            </header>
                            <div>
                                <?php
                                if ($sc_info_str = get_post_meta(get_the_ID(), CM_META_SOUNDCLOUD, true)) {
                                    $sc_info = json_decode($sc_info_str);
                                    if ($sc_info) {
                                        echo nz_get_soundcloud_iframe($sc_info->uri, array('visual' => false));
                                    }
                                }
                                ?>
                            </div>
                        </article>
                    </li>
                    <?php
                } //END while
                // Prevent weirdness
                wp_reset_postdata();
                ?>
            </ul>
        </div>
    </section>
    <?php
}
?>

<script>
    (function ($) {
        $(window).load(function () {
            $(".cm-custom-scroll").mCustomScrollbar({});
        });
    })(jQuery);
</script>