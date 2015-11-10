<!--<section class="">-->
    <!--<h1 class="title"><?php echo get_post_type(); ?></h1>-->

<article class="pr">
    <?php
    while (have_posts()) {
        the_post();
        switch (get_post_type()) {
            case 'label':
            case 'agenda':
                get_template_part('tpl/single/two-column');

                break;

            default:
                get_template_part('tpl/single/one-column');

                break;
        }
    }

    get_template_part('tpl/parts/comments');
    get_template_part('tpl/parts/post-tags');
    ?>
</article>
<!--</section>-->

<?php get_template_part('tpl/single/related-content-bottom'); ?>

<div class="featured-image banner-bottom group"> 
    <?php echo do_shortcode('[sam id=5]'); ?>
</div>