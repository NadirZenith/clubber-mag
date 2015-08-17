<header class="hover top w-100">
    <h1 class="sc-3 mt3">
        <?php the_title(); ?> 
    </h1>
</header>

<div class="pure-g">
    <div class="pure-u-1 pr">

        <?php
        //featured image
        if (has_post_thumbnail()) :
            ?>
            <div class="featured-image">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php endif; ?>

        <?php
        // video featured 
        if ('video' == get_post_type()) {
            if ($meta_video_url = get_metadata('post', get_the_ID(), 'wpcf-video-url', true)) {
                ?>
                <div class="iframe-container">
                    <?php
                    $shortcode = ' [embed width="640" height="390"]' . $meta_video_url . '[/embed]';
                    global $wp_embed;
                    echo $wp_embed->run_shortcode($shortcode);
                    ?>
                </div>
                <?php
            }
        }
        ?>

        <?php
        // podcast artist featured image
        if (in_array(get_post_type(), array('into-the-beat', 'open-frequency'))) {

            $args = array(
                'connected_items' => get_queried_object(),
                'nopaging' => true,
                'posts_per_page' => 1,
                'suppress_filters' => false
            );

            if (get_post_type() == 'into-the-beat') {
                $args['connected_type'] = 'into-the-beat-to-artist';
            } elseif (get_post_type() == 'open-frequency') {
                $args['connected_type'] = 'open-frequency-to-artist';
            }

            $artist = get_posts($args);

            if (!empty($artist)) {
                $artist = $artist[0];
                if (get_post_type() == 'open-frequency') {
                    ?>
                    <div class="featured-image">
                        <?php echo get_the_post_thumbnail($artist->ID, 'single'); ?>
                    </div>
                    <?php
                }
                ?>
                <i class="clubbermag-podcast-wm"></i>
                <div class="hover-3">
                    <div class="pod-title">
                        <a href="<?php echo get_permalink($artist) ?>">
                            <span class="sc-1">
                                <?php if (get_post_type() == 'into-the-beat') : ?>
                                    Special Guest
                                <?php else: ?>
                                    Open Signal
                                <?php endif ?>
                            </span>
                            <?php echo $artist->post_title ?>
                            <span class="sf-2" style="font-size: 60%">
                                <?php the_date(); ?>                                                               
                            </span>
                        </a>
                    </div>
                </div>

                <?php
            }

            //podacast
            $sc_info_str = get_post_meta(get_the_ID(), CM_META_SOUNDCLOUD, true);
            if ($sc_info_str) {
                $sc_info = json_decode($sc_info_str);
                if ($sc_info) {
                    echo nz_get_soundcloud_iframe($sc_info->uri, array('visual' => false));
                }
            }
            ?> 
        <?php } ?>
    </div>
</div>