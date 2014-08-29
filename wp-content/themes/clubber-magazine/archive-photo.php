
<style>
        .thumbs li{
                float: left; 
                width: 23%; 
                margin: 1%;
        }

        .thumbs li:first-child{
                /*margin-left: 2%;*/
        }

</style>
<div class="">
        <ul>
                <?php
                global $post;

                if (have_posts()) {
                        while (have_posts()) {
                                the_post();
                                ?>
                                <li class="">
                                        <section class="bg-50 block-5 mt15">
                                                <article >
                                                        <div class="col-2-4 fl nm">

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
                                                        <div class="col-2-4 fl">
                                                                <h1>
                                                                        <a class="ml5" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                                                                <?php echo htmlspecialchars(get_the_title()); ?>
                                                                        </a>
                                                                </h1>
                                                                <div class="meddium bold" style="text-align: justify">
                                                                        <?php echo wp_trim_words(get_the_content(), 15); ?>
                                                                </div>

                                                                <a class="readmore mr5 mb5" href="<?php echo $permalink . basename(get_permalink($post->ID)); ?>" title=""> 
                                                                        <?php echo __('Read more', 'attitude') ?>
                                                                </a>

                                                                <div class="cb"></div>

                                                                <?php
                                                                $images = array_slice(get_field('photo-gallery'), 0, 4);
                                                                if ($images) {
                                                                        ?>
                                                                        <ul class="thumbs" style="">
                                                                                <?php foreach ($images as $image) { ?>
                                                                                        <li >
                                                                                                <a href="<?php the_permalink() ?>">
                                                                                                      <!--<img src="<?php echo $image['sizes']['290-160-thumb']; ?>" alt="<?php echo $image['alt'] ?>">-->
                                                                                                        <img src="<?php echo $image['sizes']['340-155-thumb']; ?>" alt="<?php echo $image['alt'] ?>">
                                                                                                </a>
                                                                                        </li>
                                                                                <?php } ?>
                                                                        </ul>
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
                        <li class=""><?php _e('No Posts Found.', 'attitude'); ?></li>
                        <?php
                }

                wp_reset_query();
                ?>
        </ul>
        <?php
        include (locate_template('templates/pagination.php'));
        ?>

</div>

