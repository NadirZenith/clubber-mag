
<?php
$artist_page = get_post($artist_page_id);
?>
<?php
if ($artist_page) {
        if (get_current_user_id() == $artist_page->post_author && $artist_page->post_status != 'publish') {
                ?>
                <section class="bg-50 block-5 pb15">
                        <article>
                                <div class="ml5 cb group">
                                        <h1 class="fl"><a href="<?php echo get_permalink($artist_page->ID) ?>">Artista: <?php echo $artist_page->post_title ?></a></h1>
                                        <?php
                                        if (get_current_user_id() == $artist_page->post_author) {
                                                $artist_edit_url = add_query_arg(array('gform_post_id' => $artist_page_id), get_permalink(get_page_by_title('recursos')) . 'artista');
                                                ?>
                                                <span class="fr mr5 mt5">[ <a href="<?php echo $artist_edit_url ?>">editar</a> ]</span>
                                                <?php
                                        }
                                        ?>
                                </div>

                                <div class="cb">
                                        <div class="featured-image col-2-4 fl nm pr">
                                                <?php echo get_the_post_thumbnail($artist_page->ID, '340-155-thumb') ?>
                                                <?php if ($artist_page->post_status != 'publish') { ?>
                                                        <div class="event-date" style="position: absolute;right: 0;top: 0" title="Pendiente de revisión"><?php echo 'pendiente' ?> </div>
                                                <?php } ?>
                                        </div>
                                        <div class="col-2-4 fl ml5">
                                                <p style="text-align: justify"> <?php echo substr($artist_page->post_content, 0, 150) . '...'; ?></p>
                                                <a class="readmore" href="<?php echo get_permalink($artist_page->ID) ?>"><?php echo __('Read more', 'attitude') ?></a>
                                        </div>
                                </div>
                        </article>
                </section>
                <?php
        }
}
?>

<?php
wp_reset_postdata();
?>
