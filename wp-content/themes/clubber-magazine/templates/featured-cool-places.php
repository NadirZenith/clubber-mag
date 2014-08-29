

<?php
$args = array(
      'post_type' => 'cool-place',
      'posts_per_page' => 4,
      'order' => 'rand',
      'orderby' => 'meta_value_num',
      'meta_query' => array(
            array(
                  'key' => 'featured',
                  'value' => 1,
                  'compare' => '=',
            )
      )
);
$query = new WP_Query( $args );
if ( $query->have_posts() ) {
    ?>
    <section class="featured-cool-places bg-50 block-5 mb30">
        <h1 class="ml5 fl">
            Cool Places recomendados
        </h1>
        <p class="fl mt5 ml5">
            (
            <?php
            $terms = get_terms( 'cool_place_type' );
            foreach ( $terms as $term ) {
                ?>
                <a href="<?php echo get_term_link( $term ) ?>"><i><?php echo $term->name ?></i></a>
                <?php
            }
            ?>
            )
        </p>

        <div id="flexslider-featured-cool-places" class="cb">

            <ul class="slides">
                <?php
                while ( $query->have_posts() ) {
                    $query->the_post();
                    ?>
                    <li>
                        <article class = "fl col-1-4">
                            <div class = "hover-2" style = "">
                                <h2 class = "ml5" style = "line-height: normal">
                                    <a style = "" href = "<?php the_permalink(); ?>">
                                        <?php
                                        echo get_the_title()
                                        ?>
                                    </a>
                                </h2>
                            </div>
                            <a class="featured-image" href="<?php echo get_permalink( $event->ID ); ?>"  style="">
                                <?php echo get_the_post_thumbnail( get_the_ID(), '290-160-thumb' ); ?>
                            </a>
                        </article>
                    </li>
                    <?php
                    $count +=1;
                } //END while
                ?>
            </ul>
        </div>
    </section>
    <?php
} //end if have posts
?>


<?php
return;
?>
<script type="text/javascript">
    jQuery(document).ready(function($) {

        $('#flexslider-featured-cool-places').flexslider({
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
?>

