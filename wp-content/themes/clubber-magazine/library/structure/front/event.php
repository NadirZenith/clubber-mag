<h1>
      <?php
      if (is_archive()) {
            ?>
            <span class="ml5">Eventos destacados</span>
            <?php
      } else {
            ?>
            <a class="ml5" href="<?php echo get_post_type_archive_link('event'); ?>">Eventos destacados</a>
            <?php
      }
      ?>
</h1>

<?php
$args = array(
    'post_type' => 'event',
    'posts_per_page' => 4,
    'order' => 'ASC',
    'orderby' => 'meta_value_num',
    'meta_key' => 'wpcf-event_begin_date',
    'meta_query' => array(
        array(
            'key' => 'wpcf-event_displayed',
            'value' => 1,
            'compare' => '=',
        )
    )
);
$wp_query = new WP_Query($args);
?>
<ul>
      <?php
      if ($wp_query->have_posts()) {
            while ($wp_query->have_posts()) {
                  $wp_query->the_post();
                  ?>
                  <li class="" style="">
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
            } //END FOREACH
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
