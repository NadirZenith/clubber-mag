<?php
cm_render_related_podcasts('Into the beat', [
    'post_type' => 'into-the-beat',
    'posts_per_page' => 5,
    'connected_items' => get_queried_object(),
    'connected_type' => 'into-the-beat-to-artist'
]);

return;
$args = array(
    'post_type' => 'into-the-beat',
    'posts_per_page' => 5,
    'connected_items' => get_queried_object(),
    'connected_type' => 'into-the-beat-to-artist'
);

$query = new WP_Query($args);
if ($query->have_posts()) {
    ?>
    <section>
        <h2 class="">
            Into the beat
        </h2>
        <div class="cm-custom-scroll" style="max-height: 328px;">
            <ul class="pure-g">
                <?php
                while ($query->have_posts()) {
                    $query->the_post();
                    ?>
                    <li class="pure-u-1">
                        <article>
                            <header class="hover">
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
                wp_reset_postdata();
                ?>
            </ul>
        </div>
    </section>
    <script>
        (function ($) {
            $(window).load(function () {
                $(".cm-custom-scroll").mCustomScrollbar({});
            });
        })(jQuery);
    </script>

    <?php
}
?>