<?php
$meta_query = array(
    array(
        'key' => 'wpcf-event_begin_date',
        'value' => time(),
        'type' => 'NUMERIC',
        'compare' => '>='
    )
);
$args = array(
    'post_type' => 'agenda',
    'connected_type' => 'events_to_users',
    'connected_items' => $curauth->ID,
    'meta_query' => $meta_query,
    'posts_per_page' => 6
);

$query2 = new WP_Query($args);
?>
<section>
    <header>
        <?php if ($curauth->ID == get_current_user_id()) { ?>
            <div class="fr">
                <a class="sc-1" href="<?php echo get_post_type_archive_link('agenda') ?>" title="<?php _e('Subscribe to events', 'cm'); ?>">
                    <i class="fa fa-calendar"></i>
                </a> 
            </div>
        <?php } ?>
        <?php
        $user_agenda_url = get_author_posts_url($curauth->ID) . 'agenda';
        ?>
        <h2>
            <a class="title" href="<?php echo $user_agenda_url ?>" title="<?php _e('See user agenda', 'cm') ?>">
                <?php _e('Agenda', 'cm') ?>
            </a>
        </h2>
    </header>
    <div id="user-profile-agenda">
        <?php
        if ($query2->have_posts()) {
            ?>
            <ul class="pure-g">
                <?php
                while ($query2->have_posts()) {
                    $query2->the_post();
                    ?>
                    <li class="pure-u-1-2 pure-u-md-1-5">
                        <div class="p3">
                            <?php get_template_part('tpl/list/list-2'); ?>
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
        } else {
            //ultimos eventos
            $meta_query[0]['compare'] = '<';
            $args['meta_query'] = $meta_query;
            $query3 = new WP_Query($args);

            if ($query3->have_posts()) {
                ?>
                <ul class="pure-g">
                    <?php
                    while ($query3->have_posts()) {
                        $query3->the_post();
                        ?>
                        <li class="pure-u-1-3">
                            <div class="p3">
                                <?php get_template_part('tpl/list/list-2'); ?>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
            }
            ?>
            <div class="tc cb">
                <?php
                if ($curauth->ID == get_current_user_id()) :
                    //author message
                    if ($query3->have_posts()):
                        //have past events
                        ?> 
                        <a class="pure-button pure-button-primary" href="<?php echo get_post_type_archive_link('agenda') ?>">
                            <?php _e('¡Subscribe to events!', 'cm'); ?>
                        </a>
                        <?php
                    else :
                        //Never used button
                        ?> 
                        <a class="pure-button pure-button-primary" href="<?php echo get_post_type_archive_link('agenda') ?>">
                            <?php _e('¡Subscribe to events!', 'cm'); ?>
                        </a>
                    <?php
                    endif;
                else :
                    //guest
                    ?>
                    <span class="h3">
                        <?php
                        if ($query3->have_posts()):
                            //have past events
                            _e('Last subscribed events', 'cm');
                        else :
                            //Never used button
                            _e('This user has not subscribed to any event', 'cm');
                        endif;
                        ?>
                    </span>
                <?php
                endif;
                ?>
            </div> 

            <?php
        }//else -> does not have recent events
        ?>
    </div>

</section>
<?php wp_reset_postdata(); ?>