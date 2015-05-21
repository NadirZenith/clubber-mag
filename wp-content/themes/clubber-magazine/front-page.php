<ul class="home-list">

    <li class="col-1">
        <?php get_template_part('tpl/parts/featured-events'); ?>
    </li>

    <li class="col-1 col-md-1-2 col-small fl">
        <?php get_template_part('tpl/home/home-news'); ?>
    </li>

    <li class="col-1 col-md-1-2 col-small fr">
        <?php get_template_part('tpl/home/home-music'); ?>
    </li>

    <li class="col-1 col-big fl">
        <?php get_template_part('tpl/home/home-photo'); ?>

        <?php get_template_part('tpl/home/home-video'); ?>

        <?php
        //php get_template_part('tpl/home/newsletter'); 
        echo do_shortcode('[nzwpnewsletter]');
        ?>        
    </li>

    <li class="col-1">
        <div class="featured-image banner-bottom"> 
            <?php echo do_shortcode('[sam id=5]'); ?>
        </div>
    </li>

    <li class="col-1 col-md-1-2 fl">
        <?php get_template_part('tpl/home/home-into-the-beat'); ?>

    </li>
    <li class="col-1 col-md-1-2 fl">
        <?php get_template_part('tpl/home/home-open-frequency'); ?>

    </li>
</ul>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.home-slider').flexslider({
            controlNav: false,
            directionNav: false,
            pauseOnHover: true
        });
    });
</script> 