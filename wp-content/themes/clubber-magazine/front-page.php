<ul id="home-list" class="pure-g">
    <li class="pure-u-1">
        <?php get_template_part('tpl/parts/featured-events'); ?>
    </li>
    <li class="pure-u-1 pure-u-md-7-24 col-small">
        <?php get_template_part('tpl/home/home-news'); ?>
    </li>
    <li class="pure-u-1 pure-u-md-9-24 col-big">
        <?php get_template_part('tpl/home/home-photo'); ?>
        <?php get_template_part('tpl/home/home-video'); ?>
        <?php echo do_shortcode('[nzwpnewsletter]'); ?>        
    </li>
    <li class="pure-u-1 pure-u-md-7-24 col-small">
        <?php get_template_part('tpl/home/home-music'); ?>
    </li>
    <li class="pure-u-1">
        <div class="featured-image banner-bottom"> 
            <?php echo do_shortcode('[sam id=5]'); ?>
        </div>
    </li>
    <li class="pure-u-1 pure-u-md-1-2">
        <?php get_template_part('tpl/home/home-into-the-beat'); ?>
    </li>
    <li class="pure-u-1 pure-u-md-1-2">
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