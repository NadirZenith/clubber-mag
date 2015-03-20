<div class="cm-sticky-sidebar oh">
      <?php
//archive event
      if ( is_post_type_archive( 'agenda' ) ) {
            $new_event_link = get_permalink( cm_lang_get_post( CM_RESOURCE_EVENT_PAGE_ID ) );
            ?>
            <a class="readmore responsive" href="<?php echo $new_event_link ?>" >
                  <span class=""><?php _e( 'Upload and share event', 'cm' ) ?></span>&nbsp;
                  <i class="fa fa-users" style="color: #0583F2"></i>
            </a>
            <?php
            dynamic_sidebar( 'archive_event_sidebar' );
//Single
      } else if ( is_singular() ) {

            if ( is_singular( 'agenda' ) ) {

                  dynamic_sidebar( 'single_event_sidebar' );
            } else {
                  dynamic_sidebar( 'singular_sidebar' );
            }
      }
      dynamic_sidebar( 'banners_sidebar' );
      ?>
</div>
<?php
if ( is_super_admin() ) {
      ?>
      <script>
            (function($) {

                  jQuery(document).ready(function($) {

                        var sticky = new Waypoint.Sticky({
                              element: $('.cm-sticky-sidebar')[0],
                              offset: 30,
                              handler: function() {
                                    console.log(arguments);
                              }
                        })

                        window.onresize = setSickWidth;

                        function setSickWidth()
                        {
                              $('.cm-sticky-sidebar').css('width', $('.sticky-wrapper').parent().css('width'));
                              console.log(
                                      'yes'
                                      );

                        }
                        setSickWidth();
                  });

            })(jQuery);
      </script>
      <?php
}