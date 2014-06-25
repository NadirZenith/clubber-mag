<?php
$post = get_post($label_page_id);
?>
<section class="bg-50 block-5 pb15">
        <article class="group">
                <div class="ml5 cb group">
                        <h1 class="fl"><a href="<?php echo get_permalink($post->ID) ?>">Sello: <?php echo $post->post_title ?></a></h1>
                        <?php
                        if ($curauth->ID == get_current_user_id()) {
                                $label_edit_url = add_query_arg(array('gform_post_id' => $post->ID), get_permalink(get_page_by_title('recursos')) . 'sellos-discograficos');
                                $artist_new_url = add_query_arg(array('gform_label_id' => $label_page_id), get_permalink(get_page_by_title('recursos')) . 'artista');
                                ?>
                                <span class="fr mr5 mt5">[ <a title="Edidar label" href="<?php echo $label_edit_url ?>">editar</a> ]</span>
                                <span class="fr mr5 mt5" title="Nuevo artista">[ <a href="<?php echo $artist_new_url ?>">nuevo artista</a> ]</span>
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
        <div class="cb group">

                <?php
                $args = array(
                      'post_type' => 'artistas',
                      'posts_per_page' => -1,
                      'post_status' => 'any',
                      'order' => 'ASC',
                      'orderby' => 'post_title',
                      /* 'meta_key' => 'wpcf-label-id', */
                      'meta_query' => array(
                            array(
                                  'key' => 'wpcf-label-id',
                                  'value' => $post->ID,
                                  'type' => 'NUMERIC',
                                  'compare' => '='
                            )
                      )
                );

                $wp_query = new WP_Query($args);
                /* d($wp_query); */
                ?>
                <div class="cb group mt5">
                        <?php
                        if ($wp_query->have_posts()) {
                                ?>
                                <ul>

                                        <?php
                                        while ($wp_query->have_posts()) {
                                                $wp_query->the_post();
                                                /* d($wp_query); */
                                                ?>
                                                <li class="col-1-4 fl">
                                                        <article>
                                                                <?php
                                                                if ($curauth->ID == get_current_user_id()) {
                                                                        $artist_edit_url = add_query_arg(array('gform_post_id' => get_the_ID(), 'gform_label_id' => $label_page_id), get_permalink(get_page_by_title('recursos')) . 'artista');
                                                                        ?>
                                                                        <div class="event-date" style="position: absolute;right: 0;"><?php echo ($wp_query->post->post_status == 'pending') ? 'pendiente' : ''; ?> [ <a href="<?php echo $artist_edit_url; ?>">editar</a> ]</div>
                                                                        <?php
                                                                }
                                                                ?>
                                                                <h2 class="hover" style="line-height: normal; height: 30%">
                                                                        <a href="<?php the_permalink() ?>">
                                                                                <?php echo get_the_title(); ?>
                                                                        </a>
                                                                </h2>
                                                                <a class="featured-image">
                                                                        <?php echo the_post_thumbnail('340-155-thumb') ?>
                                                                </a>
                                                        </article>
                                                </li>

                                                <?php
                                        }
                                        ?>
                                </ul>
                                <?php
                        }
                        ?>
                </div>
        </div>
</section>

<?php
wp_reset_postdata();
?>