<?php
/*
 * podcast list item
 */
?>
<article class="pr">
    <?php
    if (is_post_type_archive('open-frequency')) {
        //get resource author in archive pages
        $args = array(
            'post_type' => array('artist', 'label'),
            'post_status' => 'any',
            'posts_per_page' => 1,
            'connected_items' => get_post(),
            'connected_type' => array('open-frequency-to-artist', 'open-frequency-to-label'),
        );
        $query2 = new WP_Query($args);
        ?>
        <header>
            <?php if ($query2->have_posts()): ?>
                <div class="fr">
                    <?php _e('by', 'cm') ?>
                    <a class="sc-1 bold" href="<?php echo get_permalink($query2->post->ID); ?>">
                        <?php echo $query2->post->post_title ?>
                    </a>
                </div>
            <?php endif; ?>
            <h2>
                <a class="title" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <?php
                    $mytitle = get_the_title();
                    if (strlen($mytitle) > 65) {
                        $mytitle = substr($mytitle, 0, 65) . '...';
                    }
                    echo $mytitle;
                    ?>
                </a>
            </h2>
        </header>

        <hr class="pb5- cb-">
        <?php
    }

    if (get_post_type() == 'into-the-beat') {
        ?>
        <div class="pr">
            <?php
            if (has_post_thumbnail()) {
                ?>
                <a class="featured-image" href="<?php the_permalink() ?>" >
                    <?php the_post_thumbnail('650-300-thumb'); ?>
                </a>
                <?php
            }
            ?>
            <i class="clubbermag-podcast-wm"></i>
            <?php
            $args = array(
                'post_type' => 'artist',
                'posts_per_page' => 1,
                'connected_items' => get_post(),
                'nopaging' => true,
                'connected_type' => 'into-the-beat-to-artist',
            );

            $query2 = new WP_Query($args);
            if ($query2->have_posts()) {
                ?>
                <div class="hover-3">
                    <div class="pod-title">
                        <header>
                            <a href="<?php the_permalink(); ?>">
                                <h2 class="reset">
                                    <span class="sc-1">
                                        Special Guest:
                                    </span>
                                    <?php echo $query2->post->post_title ?>
                                </h2>
                                <span class="fr" style="font-size: 50%">
                                    <?php the_date(); ?>
                                </span>
                            </a>
                        </header>
                    </div>
                </div>
                <?php
            }
            ?>


        </div>
        <?php
    }
    if ('open-frequency' == get_post_type() && is_front_page()) {
        $args = array(
            'post_type' => array('artist', 'label'),
            'post_status' => 'any',
            'posts_per_page' => 1,
            'connected_items' => get_post(),
            'connected_type' => array('open-frequency-to-artist', 'open-frequency-to-label'),
        );
        $query2 = new WP_Query($args);
        ?>


        <?php if ($query2->have_posts()): ?>
            <div class="hover top right">
                <!--<div class="fr mr10">-->
                <span class="sc-3">
                    <?php _e('by', 'cm') ?>
                </span>
                <a class="bold" href="<?php echo get_permalink($query2->post->ID); ?>">
                    <?php echo $query2->post->post_title ?>
                </a>
            </div>
        <?php endif; ?>

        <div class="hover bottom w-100">
            <h2 class="reset">
                <a href="<?php the_permalink(); ?>">
                    <?php
                    if (get_the_title()) {
                        the_title();
                    } else {
                        echo 'no name';
                    }
                    ?>
                </a>

            </h2>
        </div>
        <?php
    }
    ?>

    <?php
    if ($sc_info_str = get_post_meta(get_the_ID(), CM_META_SOUNDCLOUD, true)) {

        $sc_info = json_decode($sc_info_str);
        /* d( $sc_info_str, $sc_info ); */
        if ($sc_info) {
            $visual = is_front_page() ? false : true;
            ?>
            <div class="cb">
                <?php
                echo nz_get_soundcloud_iframe($sc_info->uri, array('visual' => $visual));
                ?>
            </div>
            <?php
        }
    }
    ?>

</article>
