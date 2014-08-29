
<?php
$sello_id = get_user_meta($curauth->ID, 'label_page', FALSE);
$args = array(
      'post_type' => 'sello',
      'author' => $curauth->ID,
      'posts_per_page' => 1,
      'post__in' => $sello_id,
);

if ($curauth->ID == get_current_user_id()) {
        $args['post_status'] = 'any';
}

$query = new WP_Query($args);

if ($query->have_posts()) {
        $query->the_post();
        ?>
        <section class="bg-50 block-5 pb15">
                <article class="group">
                        <div class="ml5 cb group">
                                <h1 class="fl"><a href="<?php echo get_permalink($post->ID) ?>">Sello: <?php echo $post->post_title ?></a></h1>
                                <?php
                                if ($curauth->ID == get_current_user_id()) {
                                        $recursos_link = get_permalink(get_page_by_path('recursos'));
                                        $label_edit_url = apply_filters('gform_update_post/edit_url', $post->ID, $recursos_link . 'sello');
                                        $artist_post_url = $recursos_link . 'sello/' . 'nuevo-contenido';
                                        ?>
                                        <div class="fr mr5 mt5">
                                                <span>[ <a title="Edidar label" href="<?php echo $label_edit_url ?>">editar</a> ]</span>
                                                <span title="Nuevo contenido">[ <a href="<?php echo $artist_post_url; ?>">nuevo contenido</a> ]</span>
                                        </div>
                                        <?php
                                }
                                ?>
                        </div>
                        <div class="">
                                <div class="featured-image col-2-4 fl nm pr">
                                        <?php echo get_the_post_thumbnail($post->ID, '340-155-thumb') ?>
                                        <?php if ($post->post_status != 'publish') { ?>
                                                <div class="event-date" style="position: absolute;right: 0;top: 0" title="Pendiente de revisión"><?php echo 'pendiente' ?> </div>
                                        <?php } ?>
                                </div>
                                <div class="col-2-4 fl ml5">

                                                                                                                                                                                                                <!--<h2 class="big" style="line-height: 1.5;"><a href="<?php echo get_permalink($post->ID) ?>"><?php echo $post->post_title ?></a></h2>-->
                                        <p style="text-align: justify"> <?php echo substr($post->post_content, 0, 150) . '...'; ?></p>
                                        <a class="readmore" href="<?php echo get_permalink($post->ID) ?>"><?php echo __('Read more', 'attitude') ?></a>

                                </div>
                        </div>
                </article>
        </section>
        <?php
        wp_reset_postdata();
}
?>