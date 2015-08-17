<?php
/**
 * Template Name: Festivals Template
 *
 * Displays festivals list
 *
 */
?>

<main role="main">
    <?php
    /*
      <div class="mb30 mt15">
      get_template_part( 'tpl/parts/featured-events' );
      </div>
     */
    ?>

    <div class="has-sidebar">

        <?php echo get_template_part('tpl/parts/page-header') ?>

        <?php
        $date = get_query_var('date');

        $DateTime = DateTime::createFromFormat('d-m-Y', $date);
        if ($DateTime) {
            $DateTime->setTime(0, 0, 0); //to avoid date problems
            $start_date = $DateTime->getTimestamp();
        } else {
            $start_date = strtotime("now");
        }

        $args = array(
            'post_type' => 'agenda',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'meta_value_num',
            'meta_key' => 'wpcf-event_begin_date',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'wpcf-event_type',
                    'compare' => '=',
                    'value' => 'festival',
                ),
                array(
                    'key' => 'wpcf-event_begin_date',
                    'value' => $start_date,
                    'type' => 'NUMERIC',
                    'compare' => '>='
                )
            )
        );
        $query = new WP_Query($args);
        $main_posts_id = array();

        nz_pagination_by_date('month');

        include('tpl/archive/agenda.php');
        nz_pagination_by_date('month');
        ?>

        <?php
        /*   LESS THAN 5 EVENTS        */
        if ($query->found_posts < 5 && false) {

            $date = get_query_var('date');

            $DateTime = DateTime::createFromFormat('d-m-Y', $date);
            if ($DateTime) {
                $DateTime->setTime(0, 0, 0); //to avoid date problems
                $start_date = $DateTime->getTimestamp();
            } else {
                $start_date = strtotime("now");
            }

            $args = array(
                'post_type' => 'agenda',
                'post__not_in' => $main_posts_id,
                'posts_per_page' => 10,
                'order' => 'ASC',
                'orderby' => 'meta_value_num',
                'meta_key' => 'wpcf-event_begin_date',
                'meta_query' => array(
                    array(
                        'key' => 'wpcf-event_begin_date',
                        'value' => $start_date,
                        'compare' => '>='
                    )
                )
            );

            /* d( $args ); */

            $query = new WP_Query($args);
            if ($query->found_posts > 0) {
                ?>
                <section>
                    <h1>
                        <?php _e('Next parties and events', 'cm'); ?> 
                    </h1>
                    <?php include('tpl/archive/agenda.php'); ?>
                </section>
                <?php
            }
        }
        /*  --------- //END LESS THAN 5 EVENTS        */
        ?>
    </div>

</main>
<aside role="complementary">
    <?php get_sidebar(); ?>
</aside>