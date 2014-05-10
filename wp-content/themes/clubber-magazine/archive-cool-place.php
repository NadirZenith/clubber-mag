
<?php get_header(); ?>

<div id="container">
        <h1>
                Clubber Mag te invita a visitar los lugares más frescos y mejor valorados en tu ciudad donde podrás disfrutar de la calidad de sus servicios además del confort de sus ambientes.
        </h1>

        <?php
        $terms = get_terms('cool_place_type', array('hide_empty' => FALSE));
        /* d($terms); */
        ?>
        <ul class="archive-list">
                <?php
                $Term_club = $terms[1];
                $term_archive_url = get_term_link($Term_club);
                ?>
                <li class="bg-50 block-5 mt15">
                        <section class="">
                                <div class="fr col-3-4 col-min">
                                        <h1>
                                                <a class="ml5" href="<?php echo $term_archive_url; ?>">
                                                        Clubs
                                                </a>
                                        </h1>

                                        <div class="meddium bold">

                                        </div>
                                        <a class="readmore mr5" href="<?php echo $term_archive_url; ?>" title=""> <?php echo __('Read more', 'attitude') ?></a>
                                </div>
                                <div class="fl col-1-4 nm">
                                        <a class="featured-image" href="<?php echo $term_archive_url; ?>">
                                                <?php
                                                $img_src = get_site_url() . '/wp-content/themes/clubber-magazine/images/club.png';
                                                ?>
                                                <img src="<?php echo $img_src ?>"/>
                                        </a>
                                </div>
                        </section>
                </li>
                <?php
                $Term_club = $terms[0];
                $term_archive_url = get_term_link($Term_club);
                ?>
                <li class="bg-50 block-5 mt15">
                        <section class="">
                                <div class="fr col-3-4 col-min">
                                        <h1>
                                                <a class="ml5" href="<?php echo $term_archive_url; ?>">
                                                        Bares
                                                </a>
                                        </h1>

                                        <div class="meddium bold">

                                        </div>
                                        <a class="readmore mr5" href="<?php echo $term_archive_url; ?>" title=""> <?php echo __('Read more', 'attitude') ?></a>
                                </div>
                                <div class="fl col-1-4 nm">
                                        <a class="featured-image" href="<?php echo $term_archive_url; ?>">
                                                <?php
                                                $img_src = get_site_url() . '/wp-content/themes/clubber-magazine/images/bar.png';
                                                ?>
                                                <img src="<?php echo $img_src ?>"/>
                                        </a>
                                </div>
                        </section>
                </li>
                <?php
                $Term_club = $terms[2];
                $term_archive_url = get_term_link($Term_club);
                ?>
                <li class="bg-50 block-5 mt15">
                        <section class="">
                                <div class="fr col-3-4 col-min">
                                        <h1>
                                                <a class="ml5" href="<?php echo $term_archive_url; ?>">
                                                        Restaurantes
                                                </a>
                                        </h1>

                                        <div class="meddium bold">

                                        </div>
                                        <a class="readmore mr5" href="<?php echo $term_archive_url; ?>" title=""> <?php echo __('Read more', 'attitude') ?></a>
                                </div>
                                <div class="fl col-1-4 nm">
                                        <a class="featured-image" href="<?php echo $term_archive_url; ?>">
                                                <?php
                                                $img_src = get_site_url() . '/wp-content/themes/clubber-magazine/images/restaurante.png';
                                                ?>
                                                <img src="<?php echo $img_src ?>"/>
                                        </a>
                                </div>
                        </section>
                </li>


        </ul>
</div><!-- #container -->

<?php get_footer(); ?>
