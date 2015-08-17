<section class="">
    <?php cm_home_list_title('agenda', __('Recommended parties and events', 'cm')); ?>
    <?php
    $query = new WP_Query('cm_get_featured_events');
    if ($query->have_posts()) {
        $posts_per_row = 5;
        $count = 0;
        ?> 
        <div id="featured-events-slider">
            <ul class="slides">
                <li>
                    <ul class="pure-g">
                        <?php
                        while ($query->have_posts()) {
                            $query->the_post();
                            if ($count == $posts_per_row) {
                                ?>
                            </ul>
                        </li>
                        <li>
                            <ul class="pure-g">
                                <?php
                            }
                            ?>
                            <li class="pure-u-1 pure-u-sm-1-2 pure-u-md-1-5">
                                <div class="p3">
                                    <?php get_template_part('tpl/list/list-2'); ?>
                                </div>
                            </li>
                            <?php
                            $count +=1;
                        } //END while
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
        <?php
    } //end if have posts
    wp_reset_postdata();
    ?>

    <script type="text/javascript">

        $(function () {
            $('#featured-events-slider').flexslider({
                animation: "slide",
                slideshowSpeed: 5000,
                controlNav: false,
                directionNav: false,
                pauseOnHover: false,
                direction: "horizontal",
                reverse: false,
                animationSpeed: 500,
                prevText: "&lt;",
                nextText: "&gt;",
                easing: "linear",
                slideshow: true,
                useCSS: true
            });
        });

    </script>
</section>
