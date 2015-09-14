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