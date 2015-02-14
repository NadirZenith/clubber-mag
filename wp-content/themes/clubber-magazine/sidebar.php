<?php
//archive event
if ( is_post_type_archive( 'agenda' ) ) {
      $new_event_link = get_permalink( cm_lang_get_post( CM_RESOURCE_EVENT_PAGE_ID ) );
      ?>
      <a class="readmore responsive" href="<?php echo $new_event_link ?>" >
            <span class=""><?php _e( 'Share event', 'cm' ) ?></span>&nbsp;
            <i class="fa fa-users" style="color: #0583F2"></i>
      </a>
      <?php
      if ( is_active_sidebar( 'archive_event_sidebar' ) ) {
            dynamic_sidebar( 'archive_event_sidebar' );
      }
//Single
} else if ( is_singular() ) {
      if ( is_singular( 'agenda' ) ) {
            if ( is_active_sidebar( 'single_event_sidebar' ) ) {
                  dynamic_sidebar( 'single_event_sidebar' );
            }
      } else {
            if ( is_active_sidebar( 'singular_sidebar' ) ) {
                  dynamic_sidebar( 'singular_sidebar' );
            }
      }
}
if ( is_active_sidebar( 'banners_sidebar' ) ) {
      dynamic_sidebar( 'banners_sidebar' );
}
?>