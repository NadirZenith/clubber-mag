
<h1 class="bigger ml5 mt5">
        <?php the_title(); ?>
</h1>
<ul class="archive-list">
        <?php
        $recursos = array(
              'artista' => array(
                    'title' => 'Artistas',
                    'description' => 'Comparte tu música, biografía, noticias y fechas!',
                    'img' => 'recurso_artista.jpg',
                    'url' => 'artista'
              ),
              'promotor' => array(
                    'title' => 'Promotores',
                    'description' => 'Produces eventos y te gustaría promocionarlos? Compártelos en Clubber-mag!',
                    'img' => 'recurso_promotor.jpg',
                    'url' => '/subir-evento'
              ),
              'label' => array(
                    'title' => 'Sellos discográficos',
                    'description' => 'Promociona tus artistas, sus noticas y  música en Clubber Magazine!',
                    'img' => 'recurso_label.jpg',
                    'url' => 'sello'
              ),
              'coolplace' => array(
                    'title' => 'Cool Places',
                    'description' => 'Tienes un Club, Restaurant o bar? Este es tú sitio!',
                    'img' => 'recurso_coolplace.jpg',
                    'url' => 'cool-place'
              )
        );

        //artista
        $artist_form_url = 'artista';
        ?>
        <?php
        foreach ($recursos as $key => $value) {
                /* d($key); */
                /* d($value); */
                ?>
                <li class="bg-50 block-5 mt15">
                        <section class="">
                                <div class="fr col-3-4 col-min">
                                        <h1>
                                                <a class="ml5" href="<?php echo $value['url'] ?>">
                                                        <?php echo $value['title'] ?>
                                                </a>
                                        </h1>
                                        <div class="meddium bold">
                                                <?php echo $value['description'] ?>

                                        </div>
                                        <a class="readmore mr5" href="<?php echo $value['url']; ?>" title=""> <?php echo __('Read more', 'attitude') ?></a>
                                </div>
                                <div class="fl col-1-4 nm">
                                        <a class="featured-image" href="<?php echo $value['url']; ?>">
                                                <?php
                                                $img_src = get_site_url() . '/wp-content/themes/clubber-magazine/images/types/' . $value['img'];
                                                ?>
                                                <img src="<?php echo $img_src ?>"/>
                                        </a>
                                </div>
                        </section>
                </li>
                <?php
        }
        ?>

</ul>
