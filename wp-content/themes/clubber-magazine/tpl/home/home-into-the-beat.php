<section>
    <?php cm_home_list_title('into-the-beat', __('Into the Beat Radio', 'cm')); ?>
    <div class="pr home-clubbermag-podcasts" >
        <ul class="slides">
            <?php
            $args = array(
                'post_type' => 'into-the-beat',
                'posts_per_page' => 3,
                'meta_query' => array(
                    array(
                        'key' => '_thumbnail_id',
                        'compare' => 'EXISTS',
                    )
                )
            );
            $query = new WP_Query($args);
            while ($query->have_posts()) {
                $query->the_post();
                ?>
                <li>
                    <div class="p3">
                        <article class="pr">
                            <?php
                            get_template_part('tpl/podcast/into-the-beat-header');

                            get_template_part('tpl/podcast/soundcloud-iframe');
                            ?>
                        </article>
                    </div>
                </li>
                <?php
            } //END while
            ?>
            <?php wp_reset_postdata(); ?>
        </ul>
    </div>
    <script type="text/javascript">

        jQuery(document).ready(function ($) {

            $('.home-clubbermag-podcasts').flexslider({
                slideshowSpeed: 4000,
                animation: "fade",
                controlNav: true,
                directionNav: false,
                pauseOnHover: false,
                direction: "horizontal",
                reverse: false,
                animationSpeed: 600,
                prevText: "&lt;",
                nextText: "&gt;",
                slideshow: true
            });
        });
    </script>    
    <?php cm_home_list_more('into-the-beat', __('see more...', 'cm')) ?>
</section>
