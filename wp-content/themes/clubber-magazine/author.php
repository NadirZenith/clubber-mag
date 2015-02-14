<div class="mt10 cb"></div>
<div class="fl col-1 col-lg-1-2">
      <?php
      $curauth = (isset( $_GET[ 'author_name' ] )) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) );

      //USER PROFILE INFO
      include (locate_template( 'tpl/user-profile/user-profile-info.php' ));
      ?>
</div>
<div class="fl col-1 col-lg-1-2">
      <?php
      if ( $main_resource_id = get_user_meta( $curauth->ID, CM_USER_META_RESOURCE_ID, true ) ) {
            $resource = get_post( $main_resource_id );
            if ( $resource ) {
                  if ( $curauth->ID != get_current_user_id() & $resource->post_status != 'publish' ) {
                        
                  } else {
                        include (locate_template( 'tpl/user-profile/user-profile-main-resource.php' ));
                  }
            }
      }
      ?>
      <?php
      //USER EVENTS
      if ( get_user_meta( $curauth->ID, 'is_promoter', true ) ) {
            include (locate_template( 'tpl/user-profile/user-profile-resource-promoter.php' ));
      }
      ?>
      <?php
      //USER AGENDA
      include (locate_template( 'tpl/user-profile/user-profile-resource-agenda.php' ));
      ?>
</div>
<div class="cb"></div>
