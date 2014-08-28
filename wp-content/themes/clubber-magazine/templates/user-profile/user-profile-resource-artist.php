
<?php
$artist_id = get_user_meta($curauth->ID, 'artist_page', FALSE);
$args = array(
      'post_type' => 'artista',
      /*'author' => $curauth->ID,*/
      'posts_per_page' => 1,
      'post__in' => $artist_id,
);

if ($curauth->ID == get_current_user_id()) {
        $args['post_status'] = 'any';
}

$query = new WP_Query($args);

if ($query->have_posts()) {
        $query->the_post();
        ?>
        <section class="bg-50 block-5 pb15">
                <article>
                        <div class="ml5 cb group">
                                <h1 class="fl"><a href="<?php echo get_permalink(get_the_ID()) ?>">Artista: <?php the_title() ?></a></h1>
                                <?php
                                if ($curauth->ID == get_current_user_id()) {
                                        $artist_edit_url = apply_filters('gform_update_post/edit_url', get_the_ID(), get_permalink(get_page_by_path('recursos')) . 'artista');
                                        $artist_post_url = add_query_arg(array(), get_permalink(get_page_by_path('recursos')) . 'artista/' . 'nuevo-contenido');
                                        ?>
                                        <span class="fr mr5 mt5" title="Editar página de artista">[ <a href="<?php echo $artist_edit_url ?>">editar</a> ]</span>
                                        <span class="fr mr5 mt5" title="Nuevo contenido">[ <a href="<?php echo $artist_post_url ?>">nuevo contenido</a> ]</span>

                                        <?php
                                }
                                ?>
                        </div>

                        <div class="cb">
                                <div class="featured-image col-2-4 fl nm pr">
                                        <a href="<?php echo get_permalink(get_the_ID()) ?>">
                                                <?php echo get_the_post_thumbnail(get_the_ID(), '340-155-thumb') ?>
                                        </a>
                                        <?php if (get_post_status() != 'publish') { ?>
                                                <div class="event-date" style="position: absolute;right: 0;top: 0" title="Pendiente de revisión"><?php echo 'pendiente' ?> </div>
                                        <?php } ?>
                                </div>
                                <div class="col-2-4 fl ml5">
                                        <p style="text-align: justify"> <?php echo substr(get_the_content(), 0, 50) . '...'; ?></p>
                                        <a class="readmore" href="<?php echo get_permalink(get_the_ID()) ?>"><?php echo __('Read more', 'attitude') ?></a>
                                </div>
                        </div>
                </article>
        </section>
        <?php
}
?>

<?php
wp_reset_postdata();
?>
