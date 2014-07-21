<?php
$args = array(
      'post_type' => 'userpost',
      'posts_per_page' => 3,
      'post_status' => 'publish',
      'order' => 'DESC',
      'orderby' => 'date',
      'meta_query' => array(
            array(
                  'key' => 'parent',
                  'value' => get_the_ID(),
                  'type' => 'NUMERIC',
                  'compare' => '='
            )
      )
);

$wp_query = new WP_Query($args);
if ($wp_query->have_posts()) {
        
        $here = get_permalink();
        ?>
        <div class="group">
                <h1 class="fl">Ultimo contenido</h1>
                <?php
                if (get_the_author() === wp_get_current_user()->display_name) {
                        $artist_post_url = add_query_arg(array(), get_permalink(get_page_by_path('recursos')) . $post_type . '/nuevo-contenido');
                        ?>
                        <span class="fr mt15 mr5" title="Nuevo contenido">[ <a href="<?php echo $artist_post_url ?>">nuevo contenido</a> ]</span>
                <?php } ?>
        </div>

        <hr>
        <ul class="group mb15">
                <?php
                while ($wp_query->have_posts()) {
                        $wp_query->the_post();
                        ?>
                        <li class="pr col-1-3 fl">
                                <div class="hover">
                                        <h2>
                                                <a class="ml5"  href="<?php echo $here . basename(get_the_permalink()) ?>">
                                                        <?php
                                                        $mytitle = get_the_title();
                                                        if (strlen($mytitle) > 40) {
                                                                $mytitle = substr($mytitle, 0, 40) . '...';
                                                        }
                                                        echo $mytitle;
                                                        ?>
                                                </a>
                                        </h2>

                                </div>

                                <a class="featured-image" href="<?php echo $here . basename(get_the_permalink()) ?>" >
                                        <?php the_post_thumbnail('340-155-thumb'); ?>
                                </a>
                        </li>
                        <?php
                }
                ?>
        </ul>
        <?php
}
wp_reset_query();
wp_reset_postdata();
