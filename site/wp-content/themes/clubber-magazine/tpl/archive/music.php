<?php
$items = [];
//artists
$args = array(
    'post_type' => 'artist',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'orderby' => 'rand',
);
$query = new WP_Query($args);
if ($query->have_posts()) {

    while ($query->have_posts()) {
        $query->the_post();
        $item['title'] = '<span class="sc-1">' . __('Artists', 'cm') . '</span> ' . get_the_title();
        $item['content'] = wp_trim_words(get_the_content(), 20);
        $item['link'] = get_post_type_archive_link('artist');
        $item['thumbnail'] = get_the_post_thumbnail(null, '340-155-thumb');
        /* include_tpl($item); */
    }

    $items[] = $item;
    wp_reset_postdata();
}

//into the beat
$args = array(
    'post_type' => 'into-the-beat',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'orderby' => 'rand',
    'meta_query' => array(
        array(
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS',
        )
    )
);
$query = new WP_Query($args);
if ($query->have_posts()) {

    while ($query->have_posts()) {
        $query->the_post();
        $item['title'] = '<span class="sc-1">' . __('Into the Beat', 'cm') . '</span> ' . get_the_title();
        $item['content'] = wp_trim_words(get_the_content(), 20);
        $item['link'] = get_post_type_archive_link('into-the-beat');
        $item['thumbnail'] = get_the_post_thumbnail(null, '340-155-thumb');
    }

    $items[] = $item;
    wp_reset_postdata();
}

//open frequency
$args = array(
    'post_type' => 'open-frequency',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'orderby' => 'rand',
);
$query = new WP_Query($args);
if ($query->have_posts()) {

    while ($query->have_posts()) {
        $query->the_post();
        $item['title'] = '<span class="sc-1">' . __('Open Frequency', 'cm') . '</span> ' . get_the_title();
        $item['content'] = wp_trim_words(get_the_content(), 20);
        $item['link'] = get_post_type_archive_link('open-frequency');
        $item['thumbnail'] = get_the_post_thumbnail(null, '340-155-thumb');
        $item['thumbnail'] = '<img alt="' . get_the_title() . '" src="' . get_site_url() . '/wp-content/themes/clubber-magazine/assets/images/types/clubber-mag-open-frequency.jpg"/>';
    }

    $items[] = $item;
    wp_reset_postdata();
}
//labels
$args = array(
    'post_type' => 'label',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'orderby' => 'rand',
);
$query = new WP_Query($args);
if ($query->have_posts()) {

    while ($query->have_posts()) {
        $query->the_post();
        $item['title'] = '<span class="sc-1">' . __('Labels', 'cm') . '</span> ' . get_the_title();
        $item['content'] = wp_trim_words(get_the_content(), 20);
        $item['link'] = get_post_type_archive_link('label');
        $item['thumbnail'] = get_the_post_thumbnail(null, '340-155-thumb');
    }
    $items[] = $item;
    wp_reset_postdata();
}
//music items
$post_type = 'music';
$taxonomy = 'music_type';

$music_terms = get_terms($taxonomy, array(
    'orderby' => 'count',
    'hide_empty' => 0
    ));
foreach ($music_terms as $term) {
    $term_link = get_term_link($term);
    $args = array(
        'posts_per_page' => 1,
        'post_type' => $post_type,
        'orderby' => 'rand',
        'tax_query' => array(
            array(
                'taxonomy' => 'music_type',
                'field' => 'slug',
                'terms' => $term->slug
            )
        )
    );

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        $query->the_post();
        $item['title'] = '<span class="sc-1">' . $term->name . '</span> ' . get_the_title();
        $item['content'] = wp_trim_words(get_the_content(), 20);
        $item['link'] = $term_link;
        $item['thumbnail'] = get_the_post_thumbnail(null, '340-155-thumb');
    }
    $items[] = $item;
    wp_reset_postdata();
}
?>
<ul class="pure-g">
    <?php
    foreach ($items as $item) {
        ?>
        <li class="pure-u-1">
            <div class="p3">
                <?php include __DIR__ . '/../list/list-4.php'; ?>
            </div>
        </li>
        <?php
    }
    ?>
</ul>
