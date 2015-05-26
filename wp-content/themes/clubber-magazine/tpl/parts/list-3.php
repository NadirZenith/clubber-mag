<?php
/*
 * post types archive single item (including agenda)
 */
?>
<article class="mb15 bg-50 block-5">
    <header class="m5">
        <h2>

            <a class="sc-2" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php
                $mytitle = get_the_title();
                if (strlen($mytitle) > 65) {
                    $mytitle = substr($mytitle, 0, 65) . '...';
                }
                echo $mytitle;
                ?>
            </a>
        </h2>
        <?php if (is_super_admin()) { ?>
            <div style="position: absolute; right: 5px;top: 0;">
                [<a href="<?php echo get_edit_post_link(get_the_ID()); ?>">
                    editar
                </a>]
            </div>
        <?php } ?>
    </header>

    <hr class="pb5">



    <div class="fr nm pr col-1 col-sm-1-2">

        <?php
        if (has_post_thumbnail()) {
            ?>
            <a class="featured-image" href="<?php the_permalink() ?>"  style="">
                <?php
                the_post_thumbnail('430-190-thumb');
                ?>
            </a>
            <?php
        }
        ?>

        <?php
        $date = get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true);
        if ($date) {
            ?>
            <div class="p-detail">
                <?php
                if (is_numeric($date) && (int) $date == $date) {
                    echo date('d/m/y H:i ', $date);
                }
                echo nz_get_post_city_link(get_the_ID());
                ?>

            </div>
            <?php
        }
        ?>
        <?php
        $meta_video_url = get_metadata('post', get_the_ID(), 'wpcf-video-url', true);
        if ($meta_video_url) {
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
        ?>
    </div>
    <div class="fl col-1 col-sm-1-2 pb15">
        <div class="m5 bold tj">
            <?php echo wp_trim_words(strip_shortcodes(get_the_content()), 20); ?>
        </div>

        <?php
        if ($sc_info_str = get_post_meta(get_the_ID(), CM_META_SOUNDCLOUD, true)) {
            $sc_info = json_decode($sc_info_str);
            if ($sc_info) {
                echo nz_get_soundcloud_iframe($sc_info->uri, array('visual' => true));
            }
        }
        ?>

        <?php
        $gallery = get_post_gallery(get_the_ID(), FALSE);
        if ($gallery):
            $imgs_ids = explode(',', $gallery['ids']);
        else:
            $imgs_ids = get_post_meta(get_the_ID(), 'photo-gallery', true);
        endif;
        if (!empty($imgs_ids)):
            $imgs_ids = array_slice($imgs_ids, 0, 4);
            ?>
            <div class="cb mt10 mb10">
                <?php
                include(locate_template('tpl/parts/acf-gallery-list-preview.php'));
                ?>
            </div>
            <?php
        endif;
        ?>
    </div>

    <div style="position: absolute; bottom: 10px;left: 20px;">
        <a class="readmore" href="<?php the_permalink() ?>" title="<?php the_title() ?>"> <?php echo __('Read more', 'cm') ?></a>
        <?php
        $eid = get_post_meta(get_the_ID(), 'nzwpcm_ticketscript_event_id', true);
        if ($eid && class_exists('NzWpCmTicketscript')) {
            ?>
            <a style="color: #0583F2;" class="readmore" href="<?php the_permalink() ?>#open-tickets" title="<?php the_title() ?>"> <?php echo __('Buy tickets', 'cm') ?></a>
            <?php
        }
        ?>
    </div>
</article>

