<?php
/*
 * single post item (post coolplace news music video photo podcast etc)
 */
?>
<?php
if (get_post_type() != 'artist') {
    echo get_template_part('tpl/single/single-header');
} else {
    /* echo get_template_part('tpl/parts/artist-home'); */
    ?>
    <div class="pr artist-title">
        <div class="hover-3">
            <div class="pod-title">
                <span class="sc-1">
                    <?php _e('Artist', 'cm') ?>
                </span>
                <h2 class="m0 sc-3" style="display: inline-block">
                    <?php the_title() ?> 
                </h2>
            </div>
        </div>
    </div>
    <?php
}
?>

<?php
//social items
if (in_array(get_post_type(), array('artist', 'label'))):
    get_template_part('tpl/parts/social-meta');
endif;
?>

<?php
//post author info
if (
    in_array(
        get_post_type(), array('post', 'music', 'photo', 'into-the-beat', 'open-frequency'))
) {
    get_template_part('tpl/parts/post-author-info');
}
?>

<div class="m10">
    <?php the_content(); ?> 
</div>

<?php
//old gallery items
if (!empty($imgs_ids = get_post_meta(get_the_ID(), 'photo-gallery', true))):
    ?>
    <div class="m15">
        <?php
        include(locate_template('tpl/parts/acf-gallery-list-preview.php'));
        ?>
    </div>
    <?php
endif;
?>

<?php

//label artist relation
cm_render_related_label('Labels', [
    'post_type' => 'label',
    'posts_per_page' => 5,
    'connected_items' => get_queried_object(),
    'connected_type' => 'artists_to_labels'
]);

// podcast relation
if (in_array(get_post_type(), ['label', 'artist'])) {
    cm_render_related_podcasts('Into the beat', [
        'post_type' => 'into-the-beat',
        'posts_per_page' => 5,
        'connected_items' => get_queried_object(),
        'connected_type' => 'into-the-beat-to-artist'
    ]);

    $type = get_post_type();
    cm_render_related_podcasts('Open frequency', [
        'post_type' => 'open-frequency',
        'posts_per_page' => 5,
        'connected_items' => get_queried_object(),
        'connected_type' => 'open-frequency-to-' . $type
    ]);
}
?>

<?php
//render map
cm_render_google_map(get_the_ID(), true);

//coolplace events relation
cm_render_coolplace_events(get_the_ID());

?>

