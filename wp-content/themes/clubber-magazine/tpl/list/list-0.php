<?php
/* artist item */
?>
<article>
    <header>
        <h2>
            <a class="title" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php echo mb_strimwidth(get_the_title(), 0, 32, ' ...'); ?>
            </a>
        </h2>
    </header>
    <?php if (current_user_can('manage_options')) { ?>
        <div style="position: absolute; right: 5px;top: 0;">
            [<a href="<?php echo get_edit_post_link(get_the_ID()); ?>">
                editar
            </a>]
        </div>
    <?php } ?>
    <div class="col-1" style="min-height: 160px">
        <?php
        if (has_post_thumbnail()) {
            ?>
            <a class="featured-image" href="<?php the_permalink() ?>">
                <?php the_post_thumbnail('290-160-thumb'); ?>
            </a>
            <?php
        }
        ?>     
    </div>
    <div class="m3 tj" style="min-height: 80px">
        <?php
        echo wp_trim_words(get_the_content(), 16, $more = null);
        ?>
    </div>
</article>