<?php

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_row = 3;
$posts_per_page = 15;
$args = array(
    /* 'posts_per_page' => $posts_per_page, */
    'post_type' => 'musica',
    'orderby' => 'title',
    'order' => 'ASC',
    /* 'paged' => $paged, */
    'tax_query' => array(
        array(
            'taxonomy' => 'music_type',
            'field' => 'slug',
            'terms' => 'artista'
        )
    )
);
$query = new WP_Query($args);

while ($query->have_posts()) {
      $query->the_post();
      /* d(get_the_title()); */
}

            /* wp_reset_query(); */