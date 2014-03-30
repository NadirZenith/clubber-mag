<h1>
      <a class="ml5" href="<?php echo get_post_type_archive_link('event'); ?>">Eventos</a>
</h1>

<?php
/*

$args = array(
    'post_type' => 'event',
    'posts_per_page' => 4,
    'order' => 'ASC',
    'orderby' => 'meta_value_num',
    'meta_key' => 'wpcf-event_displayed',
    'meta_query' => array(
        array(
            'key' => 'wpcf-event_begin_date',
            'value' => strtotime('now'),
            'type' => 'NUMERIC',
            'compare' => '>='
        ),
    )
);
 *  */
global $wpdb;

$sql = "
                  SELECT  $wpdb->posts.* , $wpdb->postmeta.* FROM $wpdb->posts, $wpdb->postmeta
                  WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
                  AND $wpdb->postmeta.meta_key = 'begin_date'
                  AND $wpdb->posts.post_status = 'publish'
                  AND $wpdb->posts.post_type = 'event'
                  ORDER BY $wpdb->postmeta.meta_value ASC
                  LIMIT 4
                  ";
$events = $wpdb->get_results($sql);
?>
<ul>
      <?php if ($events) { ?>

            <?php
            global $post;
            foreach ($events as $event) {
                  setup_postdata($event);
                  ?>
                  <li class="" style="">
                        <article class="fl col-1-4">
                              <div class="hover" style="">
                                    <h2 class="ml5" style="line-height: normal">
                                          <a style="" href="<?php the_permalink(); ?>">
                                                <?php echo $event->post_title ?>
                                          </a>
                                    </h2>
                                    <p class="" style="background-color: red; position: absolute; right: 0; top: -15px;">
                                          <?php
                                          echo date('d/m/y', $event->meta_value);
                                          ?>
                                    </p>
                              </div>

                              <a class="featured-image" href="<?php echo get_permalink($event->ID); ?>"  style="">
                                    <?php echo get_the_post_thumbnail($event->ID, '290-160-thumb'); ?>
                                    <!--<div style="background-color:red; width: 290px;height: 160px;"></div>-->
                              </a>
                        </article>
                  </li>
                  <?php
            } //END WHILE
      } else {
            ?>
            <li>NO posts for EVENTs</li>      
            <?php
      }
      ?>
</ul>

<?php 
wp_reset_postdata(); 
?>
