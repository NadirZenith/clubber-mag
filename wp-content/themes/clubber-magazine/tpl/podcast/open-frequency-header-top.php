<?php
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
        <?php
        $txt = '<span class="h2">' . $query2->post->post_title . '</span> ';
        $img = get_the_post_thumbnail($query2->post->ID, '290-160-thumb', []);
        ?>
        <div class="fr">
            <?php _e('by', 'cm') ?>
            <a class="sc-1 bold tooltip" href="<?php echo get_permalink($query2->post->ID); ?>"
               title="<?php echo htmlentities($txt . $img) ?>"
               >
                   <?php echo $query2->post->post_title; ?>
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
<?php
