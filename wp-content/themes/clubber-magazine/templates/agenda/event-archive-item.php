<article class="bg-50 block-5 mb15">
        <h1 class="mt5">
                <a class="ml5" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php
                        $mytitle = get_the_title();
                        if (strlen($mytitle) > 65) {
                                $mytitle = substr($mytitle, 0, 65) . '...';
                        }
                        echo $mytitle;
                        ?>
                </a>
        </h1>
        <hr class="pb5">
        <div class="fr col-2-4 nm pr">
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

                <div class="event-date" style="position: absolute; right: 0; top: -10px;">
                        <?php
                        echo date('d/m/y - H:i', get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true));

                        if ($term = wp_get_post_terms(get_the_ID(), $tax)[0]->name) {
                                $link = get_term_link($term, $tax);
                                echo " <a href='{$link}'>en {$term}</a>";
                        }
                        ?>
                </div>

        </div>
        <div class="fl ml5 col-2-4 ">
                <div class="meddium bold" style="text-align: justify">
                        <p><?php echo wp_trim_words(get_the_content(), 20); ?></p>
                </div>
        </div>

        <div style="position: absolute; bottom: 10px;left: 20px;">
                <a class="readmore" href="<?php the_permalink() ?>" title="<?php the_title() ?>"> <?php echo __('Read more', 'attitude') ?></a>
        </div>
</article>

<?php return; ?>