<?php
$resource_type = get_post_type_object( $resource->post_type );
?>
<section class="ibox-5">
      <header class="mb5">
            <h2>
                  <a href="<?php echo get_permalink( $resource->ID ) ?>">
                        <span class="sc-1">  <?php _e($resource_type->labels->singular_name , 'cm') ?>: </span>
                        <?php echo $resource->post_title ?>
                  </a>
            </h2>
      </header>
      <div id="user-profile-<?php echo $resource->post_type ?>" class="bg-50 block-5">
            <article class="mb5 cb group pr">
                  <div class="col-1-2 fl pr">
                        <a class="featured-image" href="<?php echo get_permalink( $resource->ID ) ?>">
                              <?php echo get_the_post_thumbnail( $resource->ID, '340-155-thumb' ) ?>
                        </a>
                        <div class="p-detail">
                              <?php if ( $resource->post_status != 'publish' ) : ?>
                                    <span style="color:red" title="<?php _e( 'pending review', 'cm' ); ?>"> <i class="fa fa-eye-slash"></i></span>
                              <?php endif; ?>
                              <?php
                              if ( $curauth->ID == get_current_user_id() ) :
                                    $link = get_permalink( constant( CM_RESOURCE_ . strtoupper( str_replace( '-', '', $resource->post_type ) . _PAGE_ID ) ) );
                                    /* $link = get_permalink( cm_lang_get_post( constant( CM_RESOURCE_ . strtoupper( str_replace( '-', '', $resource->post_type ) ) . _PAGE_ID ) ) ); */
                                    $resource_edit_url = NZ_WP_Forms::link( $link, $resource->ID );
                                    ?>
                                    <a href="<?php echo $resource_edit_url ?>" title="<?php _e( 'edit', 'cm' ) ?>"><i class="fa fa-pencil-square-o"></i></a> 
                              <?php endif; ?>
                        </div>
                  </div>
                  <div class="col-1-2 fl">
                        <div class="tj p5">
                              <?php echo substr( strip_tags( $resource->post_content ), 0, 80 ) . '...'; ?>
                        </div>
                  </div>
                  <?php
                  if ( $curauth->ID == get_current_user_id() ) :
                        //relate content button
                        ?>
                        <div class="p5" style="position: absolute; bottom: 0px; right: 0px; width: 50%;">
                              <?php
                              switch ( $resource->post_type ) {
                                    case 'artist':
                                    case 'label':
                                          $podcast_form_url = get_permalink( CM_RESOURCE_PODCAST_PAGE_ID );
                                          ?>
                                          <a class="readmore responsive fancybox ajax" data-fancybox-type="ajax" href="<?php echo $podcast_form_url ?>"> 
                                                <?php _e( 'Share your', 'cm' ) ?>&nbsp;&nbsp;<i class="fa fa-soundcloud" style="color: #f50;"></i>
                                          </a>
                                          <?php
                                          break;

                                    case 'cool-place':
                                          $event_form_url = get_permalink( cm_lang_get_post( CM_RESOURCE_EVENT_PAGE_ID ) );
                                          $event_form_url = add_query_arg( array( 'relation-to-coolplace' => $resource->ID ), $event_form_url );
                                          ?>
                                          <a class="readmore responsive" href="<?php echo $event_form_url ?>"> 
                                                <?php _e( 'Share Event', 'cm' ) ?>&nbsp;&nbsp;<i class="fa fa-users" style="color: #0583f2" ></i>
                                          </a>
                                          <?php
                                          break;

                                    default:
                                          break;
                              }
                              ?>
                        </div>
                        <?php
                  endif;
                  ?>
            </article> 

            <?php if ( in_array( $resource->post_type, array( 'artist', 'label' ) ) ): ?>
                  <?php include_once 'resource-related-podcasts.php'; ?>
            <?php elseif ( $resource->post_type = 'cool-place' ): ?>
                  <?php include_once 'resource-related-events.php'; ?>
            <?php endif; ?>
      </div>

</section>
