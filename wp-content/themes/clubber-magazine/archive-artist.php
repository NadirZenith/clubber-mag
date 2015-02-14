<div class="mt15"></div>
<?php
//QUERY BY FIRST LETTER
$letter = (isset( $_GET[ 'first-letter' ] )) ? $_GET[ 'first-letter' ] : null;
query_by_first_letter( 'artist', $letter );
?>

<div class="cb"></div>

<div class="m5 p5 menu-az">
      <?php
      $artist_form_url = get_permalink( cm_lang_get_post( CM_RESOURCE_ARTIST_PAGE_ID ) );
      $after = '&nbsp;&nbsp;<a class="readmore" href="' . $artist_form_url . '">' . __( 'New artist', 'cm' ) . '</a>';
      //call MENU
      menu_a_z( $letter, '', $after );
      ?>
</div>


<hr class="m5 cb">


<div class="m5 p5 menu-all-first-letter">
      <?php
//sort_all_by_first_letter
      sort_all_by_first_letter( 'artist' );
      ?>
</div>
