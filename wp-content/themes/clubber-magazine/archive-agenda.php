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
                        Eventos esta semana
                        <?php
                        if ($city) {
                                echo " en {$city}";
                        }
                        ?>
                </h1>

                <?php
                if (isset($_GET['date'])) {
                        $DateTime = date_create_from_format('d-m-Y', $_GET['date']);

                        if ($DateTime) {
                                $DateTime->setTime(0, 0, 0); //to avoid date problems
                                $start_date = $DateTime->getTimestamp();
                        }
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
                <?php
                include (locate_template('templates/agenda/date-pagination.php'));
                ?>

                <ul class="cb archive-list ">
                        <?php
                        /*    MAIN AGENDA QUERY              */
                        if (have_posts()) {
                                $main_posts_id = array();
                                while (have_posts()) {
                                        the_post();
                                        $main_posts_id[] = get_the_ID();
                                        $post_timestamp = get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true); //1394924400
                                        $post_date = date('l d/m/y', $post_timestamp); //"15/03/14"

                                        if ($last_date != $post_date) {
                                                ?> 
                                                <li class="ml5 mr5">
                                                        <h2 class=" bold sc-3" style="font-size: 200%;"><?php echo $post_date ?> </h2> 
                                                        <hr class="cb pb5">
                                                </li>
                                                <?php
                                        }
                                        $last_date = $post_date;
                                        include (locate_template('templates/agenda/event-archive-item.php'));
                                        ?>

                                        <?php
                                }
                        } else {
                                ?>
                                <li>
                                        <h2><?php _e('No Posts Found.', 'attitude'); ?></h2>

                                </li>
                                <?php
                        }
                        /* ---------- //END MAIN AGENDA QUERY              */
                        ?>
                </ul>
                <?php
                include (locate_template('templates/agenda/date-pagination.php'));
                ?>

                <?php
                /*   LESS THAN 5 EVENTS        */
                if ($wp_query->found_posts < 5) {
                        /* wp_reset_postdata(); */
                        /* d('less than 5 results -> query nexts'); */

                        $args = array(
                              'post_type' => 'agenda',
                              'post__not_in' => $main_posts_id,
                              'posts_per_page' => 5,
                              'order' => 'ASC',
                              'orderby' => 'meta_value_num',
                              'meta_key' => 'wpcf-event_begin_date',
                              'meta_query' => array(
                                    array(
                                          'key' => 'wpcf-event_begin_date',
                                          'value' => $start_date,
                                          'type' => 'NUMERIC',
                                          'compare' => '>='
                                    )
                              )
                        );

                        if ($city) {
                                $args[$tax] = $city;
                        }

                        $wp_query = new WP_Query($args);
                        if (have_posts()) {
                                ?>
                                <h1 class="ml5">
                                        Próximos eventos
                                        <?php
                                        if ($city) {
                                                echo " en {$city}";
                                        }
                                        ?>
                                </h1>
                                <ul>

                                        <?php
                                        while (have_posts()) {
                                                the_post();
                                                include (locate_template('templates/agenda/event-archive-item.php'));
                                        }
                                        ?>
                                </ul>
                                <?php
                        }
                }

                /*  --------- //END LESS THAN 5 EVENTS        */
                ?>


        </div>
        <?php
        wp_reset_postdata();
        ?>
        <div id="secondary">
                <?php get_sidebar('agenda'); ?>
        </div>

</div><!-- #container -->

<?php get_footer(); ?>
