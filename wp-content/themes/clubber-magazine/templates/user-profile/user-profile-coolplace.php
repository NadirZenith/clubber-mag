<?php
$NZRelation = New NZRelation('coolplaces_to_users', 'coolplace_id', 'user_id');
/* $NZRelation->install_table(); */

$coolplaces = $NZRelation->getRelationTo($curauth->ID, true);
?>
<?php
$args = array(
      'post_type' => 'cool-place',
      'post_status' => 'any',
      'posts_per_page' => 3,
      'post__in' => $coolplaces,
      'order' => 'ASC',
);

$wp_query = new WP_Query($args);
?>

<section class="bg-50 block-5 pb15">
        <div class="ml5 cb group">
                <h1 class=" fl"><a href="<?php echo get_post_type_archive_link('cool-place') ?>">Cool Places</a></h1>
                <?php
                $new_coolplace_url = get_permalink(get_page_by_title('recursos')) . 'cool-place';
                ?>
                <span class="fr mr5 mt5">[ <a href="<?php echo $new_coolplace_url ?>">Nuevo local</a> ]</span>
        </div>

        <?php
        if ($wp_query->have_posts()) {
                ?>
                <ul>
                        <?php
                        while ($wp_query->have_posts()) {
                                $wp_query->the_post();
                                ?>
                                <li class="mb5 cb group">
                                        <article>
                                                <div class="featured-image col-2-4 fl nm pr">
                                                        <?php echo get_the_post_thumbnail(get_the_ID(), '340-155-thumb') ?>
                                                        <?php if ($artist_page->post_status != 'publish') { ?>
                                                                <div class="event-date" style="position: absolute;right: 0;top: 0" title="Pendiente de revisión"><?php echo 'pendiente' ?> </div>
                                                        <?php } ?>
                                                </div>
                                                <div class="col-2-4 fl ml5">
                                                        <?php
                                                        $coolplace_edit_url = add_query_arg(array('gform_post_id' => get_the_ID()), get_permalink(get_page_by_title('recursos')) . 'cool-place');
                                                        ?>
                                                        <span class="fr mr5 mt5">[ <a href="<?php echo $coolplace_edit_url ?>">editar</a> ]</span>
                                                        <h2 class="big" style="line-height: 1.5;"><a href="<?php echo get_permalink(get_the_ID()) ?>"><?php the_title() ?></a></h2>
                                                        <p> <?php echo substr(get_the_content(), 0, 100) . '...'; ?></p>
                                                        <p> <?php echo get_post_meta(get_the_ID(), 'mapa', TRUE) ?></p>
                                                </div>
                                        </article>
                                </li>
                                <?php
                        }
                        ?>
                </ul>
                <?php
        }
        ?>
</section>

<?php
wp_reset_postdata();
?>
