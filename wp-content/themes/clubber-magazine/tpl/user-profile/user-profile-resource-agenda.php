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

$query2 = new WP_Query( $args );
?>
<section class="m5 pb15">
      <header class="m5 cb group">
            <?php if ( $curauth->ID == get_current_user_id() ) { ?>
                  <div  class="fr mr5">
                        <a href="<?php echo get_post_type_archive_link( 'agenda' ) ?>" title="<?php _e( 'Apúntate a eventos', 'cm' ); ?>">
                              <i class="fa fa-calendar"></i>
                        </a> 
                  </div>
            <?php } ?>
            <?php
            $user_agenda_url = get_author_posts_url( $curauth->ID ) . 'agenda';
            ?>
            <h2>
                  <a href="<?php echo $user_agenda_url ?>" title="<?php _e( 'Ver agenda de usuário', 'cm' ) ?>">
                        Agenda
                  </a>
            </h2>
      </header>
      <div id="user-profile-agenda" class="bg-50 block-5">

            <?php
            if ( $query2->have_posts() ) {
                  ?>
                  <ul>
                        <?php
                        while ( $query2->have_posts() ) {
                              $query2->the_post();
                              ?>
                              <li class="col-1-3 fl">
                                    <div class="ibox-3 mt0">
                                          <?php
                                          get_template_part( 'tpl/home/list-2' );
                                          ?>
                                    </div>
                              </li>
                              <?php
                        }
                        ?>

                  </ul>
                  <?php
            } else {
                  //ultimos eventos
                  $meta_query[ 0 ][ 'compare' ] = '<';
                  $args[ 'meta_query' ] = $meta_query;
                  $query3 = new WP_Query( $args );
                  ?>
                  <?php
                  if ( $query3->have_posts() ) {
                        ?>

                        <ul>
                              <?php
                              while ( $query3->have_posts() ) {
                                    $query3->the_post();
                                    ?>
                                    <li class="col-1-3 fl">
                                          <div class="ibox-3 mt0">
                                                <?php
                                                get_template_part( 'tpl/home/list-2' );
                                                ?>
                                          </div>
                                    </li>
                                    <?php
                              }
                              ?>

                        </ul>
                        <?php
                  }
                  ?>
                  <div class="tc box-10 cb">
                        <?php
                        if ( $curauth->ID == get_current_user_id() ) ://author message

                              if ( $query3->have_posts() )://have past events
                                    ?> 
                                    <a class="h3" href="<?php echo get_post_type_archive_link( 'agenda' ) ?>">
                                          <?php
                                          _e( '¡Apúntate a eventos en nuestra agenda!', 'cm' );
                                          ?>
                                    </a>
                                    <?php
                              else ://Never used button
                                    ?> 
                                    <a class="h3" href="<?php echo get_post_type_archive_link( 'agenda' ) ?>">
                                          <?php
                                          _e( '¡Apúntate a eventos en nuestra agenda!', 'cm' );
                                          ?>
                                    </a>
                              <?php
                              endif;
                        else :
                              ?>
                              <span class="h3">
                                    <?php
                                    if ( $query3->have_posts() )://have past events
                                          _e( 'Últimos eventos asistidos', 'cm' );
                                    else ://Never used button
                                          _e( 'Este usuario no se ha apuntado a eventos', 'cm' );
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

<?php
wp_reset_postdata();
?>