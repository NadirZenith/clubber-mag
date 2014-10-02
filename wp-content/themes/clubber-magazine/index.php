
<div id="primary">
        <h1>
                <?php
                echo ucfirst(post_type_archive_title($prefix, $display));
                ?>
        </h1>
        <style>
                .archive-list p{
                        font-weight: bold;
                }
        </style>
        <ul class="archive-list">

                <?php
                global $post;

                if (have_posts()) {
                        while (have_posts()) {
                                the_post();
                                ?>
                                <li>

                                        <section class="bg-50 block-5 mb15">
                                                <article>
                                                        <header>
                                                                <h1 class="mt5" style="">
                                                                        <a class="ml5" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                                                </h1>

                                                        </header>
                                                        <hr class="pb5">
                                                        <div class="fl ml5 col-2-4 " style="">
                                                                <div class="" style="text-align:justify">
                                                                        <?php the_excerpt() ?>
                                                                </div>
                                                                <p class="">
                                                                        <a class="readmore" href="<?php the_permalink() ?>" title="<?php the_title() ?>"> <?php echo __('Read more', 'attitude') ?></a>

                                                                </p>

                                                                <div  style="color: #666;">
                                                                        <?php echo get_the_date() ?>

                                                                </div>
                                                        </div>



                                                        <div class="fr col-2-4 nm" >
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
                        }
                } else {
                        ?>
                        <h1 class=""><?php _e('No Posts Found.', 'attitude'); ?></h1>
                        <?php
                }
                ?>
        </ul>
</div>

<div id="secondary" class="no-margin-left">
        <?php get_sidebar('right'); ?>
</div>
