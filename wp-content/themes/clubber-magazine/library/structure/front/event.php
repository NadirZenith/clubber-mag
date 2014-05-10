<h1>
        <?php
        if (is_archive()) {
                ?>
                <span class="ml5">Eventos destacados</span>
                <?php
        } else {
                ?>
                <a class="ml5" href="<?php echo get_post_type_archive_link('agenda'); ?>">Eventos destacados</a>
                <?php
        }
        ?>
</h1>

<?php
$now_timestamp = time();
$date = date('d/m/Y', $now_timestamp);

$args = array(
      'post_type' => 'agenda',
      'posts_per_page' => 8,
      'order' => 'ASC',
      'orderby' => 'meta_value_num',
      'meta_key' => 'wpcf-event_begin_date',
      'meta_query' => array(
            'relation' => 'AND',
            array(
                  'key' => 'wpcf-event_displayed',
                  'value' => 1,
                  'compare' => '=',
            ),
            array(
                  'key' => 'wpcf-event_begin_date',
                  'value' => time(),
                  'type' => 'NUMERIC',
                  'compare' => '>='
            )
      )
);
$wp_query = new WP_Query($args);
?>
<div id="flexslider-featured-events" class="">

        <ul class="slides">
                <?php
                if ($wp_query->have_posts()) {
                        $count = 0;
                        ?> 
                        <li>
                                <ul>
                                        <?php
                                        while ($wp_query->have_posts()) {
                                                $wp_query->the_post();
                                                if ($count % 4 == 0) {
                                                        
                                                }
                                                if ($count == 4) {
                                                        ?>
                                                </ul>
                                        </li>
                                        <li >
                                                <ul>
                                                        <?php
                                                }
                                                ?>
                                                <li>
                                                        <article class="fl col-1-4">
                                                                <div class="hover-2" style="">
                                                                        <h2 class="ml5" style="line-height: normal">
                                                                                <a style="" href="<?php the_permalink(); ?>">
                                                                                        <?php
                                                                                        echo get_the_title()
                                                                                        ?>
                                                                                </a>
                                                                        </h2>
                                                                </div>
                                                                <div class="event-date" style="position: absolute; right: 0; top: 0px;">
                                                                        <?php
                                                                        $date = get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true);
                                                                        echo date('d/m/y', $date);
                                                                        $tax = 'city';
                                                                        if ($term = wp_get_post_terms(get_the_ID(), $tax)[0]->name) {
                                                                                $link = get_term_link($term, $tax);
                                                                                echo " <a href='{$link}'>{$term}</a>";
                                                                        }
                                                                        ?>
                                                                </div>

                                                                <a class="featured-image" href="<?php echo get_permalink($event->ID); ?>"  style="">
                                                                        <?php echo get_the_post_thumbnail(get_the_ID(), '290-160-thumb'); ?>
                                                                </a>
                                                        </article>
                                                </li>
                                                <?php
                                                $count +=1;
                                        } //END while
                                        ?>
                                </ul>
                        </li>
                        <?php
                } //end if have posts
                ?>
        </ul>
</div>
<script type="text/javascript">
        jQuery(document).ready(function($) {

                $('#flexslider-featured-events').flexslider({
                        animation: "slide",
                        slideshowSpeed: 5000,
                        controlNav: false,
                        directionNav: false,
                        pauseOnHover: false,
                        direction: "horizontal",
                        reverse: false,
                        animationSpeed: 500,
                        prevText: "<",
                        nextText: ">",
                        easing: "linear",
                        slideshow: true,
                        useCSS: false
                });
        });
</script>

<?php
wp_reset_postdata();

/*           
 * slideshowSpeed:4000,
                animation:"fade",
                controlNav:1,
                directionNav:true,
                pauseOnHover:false,
                direction:"horizontal",
                reverse:false,
                animationSpeed:600,
                prevText:"<",
                nextText:">",
                easing:"linear",
                slideshow:true,
                useCSS:false             
 */

?>

