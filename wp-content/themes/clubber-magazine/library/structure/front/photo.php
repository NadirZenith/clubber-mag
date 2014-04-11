<?php
$args = array(
      'post_type' => 'photo',
      'label_name' => 'Photo review',
      'post_status' => 'publish',
      /* 'name' => $wp_query->query_vars['name'], */
      'posts_per_page' => 3
);
$query = new WP_Query($args);
?>
<style>
        .thumbs li{
                float: left; 
                width: 23%; 
                margin: 1%;
        }


</style>
<h1>
        <a class="ml5" href="<?php echo get_post_type_archive_link($args['post_type']); ?>"> <?php echo $args['label_name'] ?></a>
</h1>
<div class="gallery-slideshow">
        <ul class="slides" style="">
                <?php
                if ($query->have_posts()) {
                        while ($query->have_posts()) {
                                $query->the_post();
                                $permalink = get_permalink();
                                ?>
                                <li>
                                        <article>
                                                <div class="pr">
                                                        <div class="hover-2">
                                                                <h2>
                                                                        <a class="ml5" href="<?php echo $permalink ?>">
                                                                                <?php the_title() ?>
                                                                        </a>
                                                                </h2>
                                                        </div>
                                                        <a class="featured-image" href="<?php echo $permalink; ?>">
                                                                <?php the_post_thumbnail('430-190-thumb'); ?>
                                                        </a>

                                                </div>
                                                <?php
                                                /* $images = get_field('photos'); */
                                                $images = array_slice(get_field('photo-gallery'), 0, 4);
                                                /* d($images); */
                                                ?>
                                                <ul class="thumbs" style="">
                                                        <?php foreach ($images as $image) { ?>
                                                                <li class="" style="">
                                                                        <a href="<?php echo $permalink; ?>">
                                                                                <img src="<?php echo $image['sizes']['340-155-thumb']; ?>" alt="<?php echo $image['alt'] ?>">
                                                                                <!--<img src="<?php echo $image['sizes']['430-190-thumb']; ?>" alt="<?php echo $image['alt'] ?>">-->
                                                                        </a>
                                                                </li>
                                                                <?php
                                                        }
                                                        ?>
                                                </ul>
                                        </article>
                                </li>
                                <?php
                        }
                } else {
                        ?>
                        <li>no posts for gallery</li>
                        <?php
                }
                ?>
        </ul>
</div>

<?php
wp_reset_postdata();
?>

<script type="text/javascript">

        jQuery(document).ready(function($) {

                $('.gallery-slideshow').flexslider({
                        animation: "fade",
                        slideshowSpeed: 5000,
                        controlNav: false,
                        directionNav: false,
                        pauseOnHover: false,
                        direction: "horizontal",
                        reverse: false,
                        animationSpeed: 1000,
                        prevText: "<",
                        nextText: ">",
                        easing: "linear",
                        slideshow: true,
                        useCSS: false
                });
        });
</script>