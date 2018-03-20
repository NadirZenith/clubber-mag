<?php
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
        <?php
        $txt = '<span class="h2">' . $query2->post->post_title . '</span> ';
        $img = get_the_post_thumbnail($query2->post->ID, '290-160-thumb', []);
        ?>
        <div class="hover top right">
            <?php _e('by', 'cm') ?>
            <a class="bold tooltip" href="<?php echo get_permalink($query2->post->ID); ?>"
               title="<?php echo htmlentities($txt . $img) ?>"
               >
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
                    echo 'n/a';
                }
                ?>
            </a>

        </h2>
    </div>
</header>
<?php
