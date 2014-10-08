
<div id="primary">
        <?php
        $taxonomy_type['music_type'] = array(
              'title' => 'Música',
              'terms' => array(
                    'reviews' => 'Reviews',
                    'podcasts' => 'Podcasts',
                    'entrevistas' => 'Entrevistas',
        ));
        $taxonomy_type['cool_place_type'] = array(
              'title' => 'Cool Places',
              'terms' => array(
                    'clubs' => 'Clubs',
                    'bares' => 'Bares',
                    'restaurantes' => 'Restaurantes'
        ));
        if (array_key_exists(get_query_var('taxonomy'), $taxonomy_type)) {
                $title = $taxonomy_type[get_query_var('taxonomy')]['title'];
                if (isset($taxonomy_type[get_query_var('taxonomy')]['terms'][get_query_var('term')])) {
                        $title .= ' - ' . $taxonomy_type[get_query_var('taxonomy')]['terms'][get_query_var('term')];
                }
        }
        ?>

        <h1>
                <?php
                echo $title;
                ?>
        </h1>
        <ul class="taxonomy-list">
                <?php
                global $post;

                if (have_posts()) {
                        while (have_posts()) {
                                the_post();
                                $float = 'right';
                                $terms = wp_get_post_terms(get_the_ID(), 'music_type');
                                ?>
                                <li>
                                        <section class="bg-50 block-5 mb15" >
                                                <article>
                                                        <header>
                                                                <h1 class="mt5">
                                                                        <a class="ml5" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>

                                                                </h1>
                                                        </header>
                                                        <hr class="pb5">
                                                        <div class="fl col-2-4">
                                                                <p class="meddium pl5">
                                                                        <?php echo get_the_excerpt() ?>
                                                                </p>
                                                                <span style="color: #666;">
                                                                        <?php echo get_the_date() ?>

                                                                </span>
                                                                <a class="readmore mr15" href="<?php the_permalink() ?>" title="<?php the_title() ?>"> <?php echo __('Read more', 'attitude') ?></a>

                                                        </div>

                                                        <div class="fr mt5 col-2-4 nm">

                                                                <?php
                                                                if (has_post_thumbnail()) {
                                                                        ?>
                                                                        <a class="featured-image" href="<?php the_permalink() ?>"  style="">
                                                                                <?php
                                                                                the_post_thumbnail('430-190-thumb');
                                                                                ?>
                                                                        </a>
                                                                        <?php
                                                                }
                                                                ?>
                                                        </div>

                                                </article>
                                        </section>
                                </li>


                                <?php
                                ?>
                                <?php
                        }
                } else {
                        ?>
                        <h1 class=""><?php _e('No Posts Found.', 'attitude'); ?></h1>
                        <?php
                }
                ?>
        </ul>
</div>

<div id="secondary" >
        <?php get_sidebar('right'); ?>
</div><!-- #secondary -->
