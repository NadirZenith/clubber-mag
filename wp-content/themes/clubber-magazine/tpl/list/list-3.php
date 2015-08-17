<?php
/*
 * post types archive single item (including agenda)
 */
?>
<article class="pr">
    <h2>
        <?php printf('<a class="title" href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute('echo=0'), get_the_title()); ?>
    </h2>
    <?php if (is_super_admin()) { ?>
        <div style="position: absolute; right: 5px;top: 0;">
            [<a href="<?php echo get_edit_post_link(get_the_ID()); ?>">
                editar
            </a>]
        </div>
    <?php } ?>
    <hr>
    <div class="pure-g">
        <div class="pure-u-1 pure-u-sm-1-2">
            <p class="tj p5">
                <?php echo wp_trim_words(strip_shortcodes(get_the_content()), 30); ?>
            </p>

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
        <div class="pure-u-1 pure-u-sm-1-2 pr">
            <?php if (has_post_thumbnail()) { ?>
                <a class="featured-image" href="<?php the_permalink() ?>">
                    <?php
                    the_post_thumbnail('430-190-thumb');
                    ?>
                </a>
                <?php
            } else if ($meta_video_url = get_post_meta(get_the_ID(), 'wpcf-video-url', true)) {
                ?>
                <div class="iframe-container">
                    <?php
                    echo cm_render_video($meta_video_url);
                    ?>
                </div>
                <?php
            }
            $date = get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true);
            if ($date) {
                ?>
                <div class="hover top right">
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
        </div>
    </div>
    <div class="hover bottom left ml15 mb10">
        <a class="pure-button" href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php echo __('Read more', 'cm') ?></a>
        <?php
        $eid = get_post_meta(get_the_ID(), 'nzwpcm_ticketscript_event_id', true);
        if ($eid && class_exists('NzWpCmTicketscript')) {
            ?>
            <a href="<?php the_permalink() ?>#open-tickets">
                <button  class="buy-tickets pure-button">
                    <?php echo _e('Get your tickets!', 'cm') ?>
                </button>
            </a>
            <?php
            /* <a style="color: #0583F2;" class="readmore" href="<?php the_permalink() ?>#open-tickets" title="<?php _e('Get your tickets!') ?>"> <?php echo _e('Get your tickets!', 'cm') ?></a> */
        }
        ?>
    </div>


</article>

