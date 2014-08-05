
<?php get_header(); ?>

<div id="container">
        <?php
        /*get_template_part('templates/featured-cool-places');*/
        ?>



        <?php
        $letter = (isset($_GET['first-letter'])) ? $_GET['first-letter'] : null;
//call MENU
        menu_a_z($letter);
        ?>        
        <div class="cb"></div>

        <?php
//QUERY BY FIRST LETTER
        query_by_first_letter('cool-place', $letter);
        ?>

        <div class="cb"></div>

        <?php
//sort_all_by_first_letter
        sort_all_by_first_letter('cool-place');
        ?>

        <?php
        /* $terms = get_terms('cool_place_type', array('hide_empty' => FALSE)); */
        /* d($terms); */
        if (false) {
                /* if (!is_wp_error($terms)) { */
                ?>

                <div class="cb"></div>
                <h1>
                        Clubber Mag te invita a visitar los lugares más frescos y mejor valorados en tu ciudad donde podrás disfrutar de la calidad de sus servicios además del confort de sus ambientes.
                </h1>
                <?php
                foreach ($terms as $term) {
                        $term_archive_url = get_term_link($term);
                        ?>
                        <ul class="archive-list">
                                <li class="bg-50 block-5 mt15">
                                        <section class="">
                                                <div class="fr col-3-4 col-min">
                                                        <h1>
                                                                <a class="ml5" href="<?php echo $term_archive_url; ?>">
                                                                        <?php echo $term->name; ?>
                                                                </a>
                                                        </h1>


                                                        <a class="readmore mr5" href="<?php echo $term_archive_url; ?>" title=""> <?php echo __('Read more', 'attitude') ?></a>
                                                </div>
                                                <div class="fl col-1-4 nm">
                                                        <a class="featured-image" href="<?php echo $term_archive_url; ?>">
                                                                <?php
                                                                $img_src = get_site_url() . "/wp-content/themes/clubber-magazine/images/types/{$term->slug}.jpg";
                                                                ?>
                                                                <img src="<?php echo $img_src ?>"/>
                                                        </a>
                                                </div>
                                        </section>
                                </li> 
                        </ul>

                        <?php
                }
        }
        ?>

</div>

<?php get_footer(); ?>
