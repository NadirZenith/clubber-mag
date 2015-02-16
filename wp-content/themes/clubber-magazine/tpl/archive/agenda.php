<?php
$main_posts_id = array();
/*    MAIN AGENDA QUERY              */
if ( $query->have_posts() ) {
      $first = TRUE;
      while ( $query->have_posts() ) {
            $query->the_post();
            $main_posts_id[] = get_the_ID();
            $date = get_post_meta( get_the_ID(), 'wpcf-event_begin_date', true ); //1394924400
            if ( is_numeric( $date ) && ( int ) $date == $date ) {
                  $post_date = date( 'l d/m/y', $date ); //"15/03/14"
            /*$post_date = date( 'l d/m/y', $post_timestamp );*/
            }
            if ( $last_date != $post_date ) {
                  if ( $first ) {
                        echo '<section class="cb">';
                        ?>
                        <header class="ml5 mr5">
                              <span class="cm-title2 big">
                                    <?php echo $post_date ?>
                              </span>
                        </header>
                        <?php
                        echo '<ul>';
                        $first = FALSE;
                  } else {
                        echo '</ul>';
                        echo '</section>';
                        echo '<section class="cb">';
                        ?>
                        <header class="ml5 mr5">
                              <span class="cm-title2 big">
                                    <?php echo $post_date ?>
                              </span>
                        </header>
                        <?php
                        echo '<ul>';
                  }
            }
            $last_date = $post_date;
            ?>
            <li class="ibox-5">
                  <?php
                  get_template_part( 'tpl/parts/list-3' );
                  ?>
            </li>
            <?php
            if ( $query->current_post == $query->found_posts ) {
                  echo '</ul>';
                  echo '</section>';
            }
      }//END WHILE
} else {
      get_template_part( 'tpl/parts/not-found' );
}
?>