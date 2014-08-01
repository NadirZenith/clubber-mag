<?php
wp_enqueue_style('fullcalendar', get_template_directory_uri() . '/js/fullcalendar/fullcalendar.css', $deps, $ver, $media);

wp_enqueue_script('fullcalendar', get_template_directory_uri() . '/js/fullcalendar/fullcalendar.min.js', array('jquery'));

/* wp_enqueue_script('stickymojo', get_template_directory_uri() .'/js/stickymojo/stickyMojo.js', array('jquery')); */
?>
<?php get_header(); ?>

<?php
$tax = 'city';
if (is_tax($tax)) {
        global $wp_query;
        $term = $wp_query->get_queried_object();
        $city = ucfirst($term->name);
}
?>

<div id="container">
        <section class="event bg-50 block-5">
                <?php
                require_once 'library/structure/front/event.php';
                ?>
        </section>

        <div id="primary">
                <h1 class="ml5">
                        Eventos esta semana <?php echo ($city) ? "en {$city}" : ''; ?>
                </h1>

                <?php
                $date = get_query_var('date');

                $DateTime = DateTime::createFromFormat('d-m-Y', $date);
                if ($DateTime) {
                        $DateTime->setTime(0, 0, 0); //to avoid date problems
                        $start_date = $DateTime->getTimestamp();
                } else {
                        $start_date = strtotime("now");
                }

                $end_date = strtotime('+ 1 week', $start_date);
                $prev_date = strtotime('- 1 week', $start_date);

                $args = array(
                      'post_type' => 'agenda',
                      'posts_per_page' => -1,
                      'order' => 'ASC',
                      'orderby' => 'meta_value_num',
                      'meta_key' => 'wpcf-event_begin_date',
                      'meta_query' => array(
                            array(
                                  'key' => 'wpcf-event_begin_date',
                                  'value' => array($start_date, $end_date),
                                  'type' => 'NUMERIC',
                                  'compare' => 'BETWEEN'
                            )
                      )
                );
                if ($city) {
                        $args[$tax] = $city;
                }

                $wp_query = new WP_Query($args);
                ?>
                <div id="archive-list">
                        <?php include (locate_template('templates/agenda/date-pagination.php')); ?>
                        <!-- Week events -->
                        <div class="cb">
                                <?php
                                $main_posts_id = array();
                                /*    MAIN AGENDA QUERY              */
                                if (have_posts()) {
                                        $first = FALSE;
                                        while (have_posts()) {
                                                the_post();
                                                $main_posts_id[] = get_the_ID();
                                                $post_timestamp = get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true); //1394924400
                                                $post_date = date('l d/m/y', $post_timestamp); //"15/03/14"

                                                if ($last_date != $post_date) {
                                                        if ($first) {
                                                                echo '<section>';
                                                                ?> 
                                                                <header class="ml5 mr5">
                                                                        <h2 class=" bold sc-3" style="font-size: 200%;"><?php echo $post_date ?> </h2> 
                                                                        <hr class="cb pb5">
                                                                </header>
                                                                <?php
                                                                echo '<ul>';
                                                                $first = FALSE;
                                                        } else {
                                                                echo '</ul>';
                                                                echo '</section>';
                                                                echo '<section>';
                                                                ?>
                                                                <header class="ml5 mr5">
                                                                        <h2 class=" bold sc-3" style="font-size: 200%;"><?php echo $post_date ?> </h2> 
                                                                        <hr class="cb pb5">
                                                                </header>

                                                                <?php
                                                                echo '<ul>';
                                                        }
                                                }
                                                $last_date = $post_date;
                                                /* LI */
                                                ?>
                                                <li class="">
                                                        <?php
                                                        include (locate_template('templates/agenda/event-archive-item.php'));
                                                        ?>
                                                </li>
                                                <?php
                                                /* \LI */
                                        }
                                        echo '</ul>';
                                        echo '</section>';
                                } else {
                                        ?>
                                        <!-- no posts -->
                                        <h2 style="text-align: center;"><?php _e('No Posts Found.', 'attitude'); ?></h2>
                                        <?php
                                }
                                /* ---------- //END MAIN AGENDA QUERY              */
                                ?>
                        </div>
                        <!-- Week event list close -->
                        <?php include (locate_template('templates/agenda/date-pagination.php')); ?>

                        <?php
                        /*   LESS THAN 5 EVENTS        */
                        if ($wp_query->found_posts < 5) {
                                /* d($args); */
                                $args['post__not_in'] = $main_posts_id;
                                $args['posts_per_page'] = 5;
                                $args['meta_query'][0]['value'] = $start_date;
                                $args['meta_query'][0]['compare'] = '>=';
                                /* d($args); */

                                $query2 = new WP_Query($args);
                                if ($query2->have_posts()) {
                                        ?>
                                        <section>
                                                <header>
                                                        <h1 class="ml5">
                                                                Próximos eventos <?php echo ($city) ? "en {$city}" : ''; ?>
                                                        </h1>
                                                </header>
                                                <ul>
                                                        <?php
                                                        while ($query2->have_posts()) {
                                                                $query2->the_post();
                                                                /* LI */
                                                                ?>
                                                                <li class="">
                                                                        <?php
                                                                        include (locate_template('templates/agenda/event-archive-item.php'));
                                                                        ?>
                                                                </li>
                                                                <?php
                                                                /* \LI */
                                                        }
                                                        ?>
                                                </ul>
                                        </section>
                                        <?php
                                }
                        }
                        /*  --------- //END LESS THAN 5 EVENTS        */
                        ?>
                </div>


        </div>
        <?php
        wp_reset_postdata();
        ?>
        <div id="secondary">
                <?php get_sidebar('agenda'); ?>
        </div>

</div><!-- #container -->

<?php get_footer(); ?>
