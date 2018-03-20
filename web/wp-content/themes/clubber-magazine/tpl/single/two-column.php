<?php
/*
 * single - event | label 
 */
?>

<div class="pure-g">
    <div class="pure-u-1 pure-u-md-1-2">
        <div class="p5">
            <?php
            if (has_post_thumbnail(get_the_ID())) {
                $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()));
                $url = (isset($image[0])) ? $image[0] : ';'
                ?>
                <a href="<?php echo $url ?>" class="featured-image fancybox" title="<?php the_title_attribute() ?>">
                    <?php the_post_thumbnail(); ?>
                </a>
            <?php } ?>
            <?php
            if ($back_flyer_url = get_post_meta(get_the_ID(), 'wpcf-event_flyer_back', true)) {
                ?>
                <div class="mt15">
                    <a href="<?php echo $back_flyer_url ?>" class="featured-image fancybox" title="<?php the_title_attribute() ?>">
                        <img src="<?php echo $back_flyer_url ?>" alt="<?php _e('backflyer', 'cm') ?>" />
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="pure-u-1 pure-u-md-1-2">
        <div class="p5 mt15">
            <header>
                <h1>
                    <?php the_title(); ?>
                </h1>
                <?php
                if ('agenda' == get_post_type()) {
                    get_template_part('tpl/parts/event-meta');
                }
                if ('label' == get_post_type()) {
                    get_template_part('tpl/parts/social-meta');
                }
                ?>
            </header>
            <div class="mt15 tj">
                <?php the_content(); ?> 
            </div>
        </div>
    </div>
</div>

