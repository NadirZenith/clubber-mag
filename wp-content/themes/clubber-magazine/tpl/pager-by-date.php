<?php
/*
 * archive event pager (post archive and user event listings)
 */

$date = get_query_var( 'date' );

$DateTime = DateTime::createFromFormat( 'd-m-Y', $date );
if ( $DateTime ) {
      $DateTime->setTime( 0, 0, 0 ); //to avoid date problems
      $start_date = $DateTime->getTimestamp();
} else {
      $start_date = strtotime( "now" );
}

$end_date = strtotime( '+ 1 week', $start_date );
$prev_date = strtotime( '- 1 week', $start_date );

if ( $end_date && $prev_date ) {
      ?>
      <div class="group p15 pager-date">
            <ul>
                  <li class="fl">
                        <a href="<?php echo add_query_arg( array( 'date' => date( 'd-m-Y', $prev_date ) ) ); ?>" rel="nofollow">
                              <span class="meddium sc-2">&#8678; </span>
                              <?php _e( 'previous week', 'cm' ) ?>
                        </a>
                  </li>
                  <li class="fr">
                        <a href="<?php echo add_query_arg( array( 'date' => date( 'd-m-Y', $end_date ) ) ); ?>" rel="nofollow">
                              <?php _e( 'next week', 'cm' ) ?>
                              <span class="meddium sc-2"> &#8680;</span>
                        </a>
                  </li>
            </ul>
      </div>
      <?php
}
?>