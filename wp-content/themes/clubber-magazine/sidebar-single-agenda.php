
<?php
/* $nonce = wp_create_nonce('relate_user_' . get_current_user_id() . '_to_event'); */
?>

<div class="bg-50 block-5 pb5 mt15 ">
      <div class="mt5" style="color:#333; text-align: center; font-size: 18px;font-family: 'Russo One', sans-serif;">
            Participa y Compártelo
      </div>
      <hr class="ml5 mr5">
      <?php
      $event = get_the_ID();
      $NZRelation = New NZRelation( 'events_to_users', 'event_id', 'user_id' );
      /* $NZRelation->install_table(); */
      $event_participants = $NZRelation->getRelationFrom( $event );
      $user_subscribed = $NZRelation->hasRelationFrom( $event, get_current_user_id() );

      if ( $user_subscribed ) {
            $class = 'nzr-active';
            $name = 'Asistiré';
      } else {
            $class = '';
            $name = 'Me apunto!';
      }

      $total_participants = count( $event_participants );
      $total_style = ($total_participants == 0) ? 'style="visibility:hidden"' : '';
      /* $view_participants_url = add_query_arg(array('action' => 'get_event_users', 'event' => get_the_ID()), admin_url('admin-ajax.php')); */
      ?>
      <div id="nz-relate-user-to-event" class="nz-relate big">
            <a id="relate_user_to_event" class="nz-relate-btn <?php echo $class ?>" href="#participar" >
                  <span class="nzr-icon"></span>
                  <span class="nzr-text"><?php echo $name ?></span>
            </a>

            <a id="get-event-users" class="fancybox.ajax nz-get-relation" href="#participantes" <?php echo $total_style ?>>
                  (<span class="nzr-total"><?php echo $total_participants ?></span>)
            </a>

      </div>

      <div class="ml15 mt30" style="">
            <?php
            nz_fb_like();
            ?>
            <div class="mt15"></div>
            <?php
            nz_tt_tweet();
            ?>
      </div>

      <script type="text/javascript">

            jQuery(document).ready(function($) {
                  $('#relate_user_to_event').on('click', nzr_process_relation);
                  $("#get-event-users").on('click', nzr_process_get_relation);


                  function nzr_process_relation(e) {
                        e.preventDefault();
                        $btn = $(this);
                        $relation = $('#get-event-users');
                        $relation_count = $relation.find('.nzr-total');
                        if (!$btn.hasClass('nzr-active')) {
                              //relate
                              $btn.find('.nzr-text').html('Asistiré');
                              $relation.css('visibility', 'visible');
                              $relation.find('.nzr-total').html(parseInt($relation_count.text()) + 1);
                              nzr_set_relation_from();
                        } else {
                              //unrelate
                              $btn.find('.nzr-text').html('Me apunto!');
                              count = parseInt($relation_count.text());
                              if (count == 1) {
                                    $relation.css('visibility', 'hidden');
                              }
                              $relation.find('.nzr-total').html(count - 1);
                              nzr_set_relation_from(false);

                        }
                        $btn.toggleClass('nzr-active');
                  }

                  function nzr_process_get_relation(e) {
                        e.preventDefault();
                        nzr_get_relation_from();

                  }


                  function nzr_ajax(data) {
                        defaults = {
                              event: '<?php echo get_the_ID() ?>'
                        };
                        settings = $.extend({}, defaults, data);
                        jQuery.ajax({
                              url: ajaxurl,
                              data: settings,
                              type: 'GET',
                              success: function(data, status, xhr) {
                                    $.fancybox({
                                          'transitionIn': 'elastic',
                                          'transitionOut': 'elastic',
                                          'speedIn': 600,
                                          'speedOut': 200,
                                          'overlayShow': false,
                                          'width': '80%',
                                          'height': '80%',
                                          'autoSize': false,
                                          'content': data
                                    });
                              },
                              error: function(xhr) {
                                    $.fancybox({
                                          'content': xhr.responseText
                                    });
                              },
                              complete: function(xhr, status) {
                              }

                        });
                  }


                  function nzr_get_relation_from() {
                        data = {
                              action: 'get_event_users',
                        };

                        nzr_ajax(data);
                  }

                  function nzr_set_relation_from(state) {
                        state = state === false ? 'unrelate' : 'relate';
                        data = {
                              action: 'relate_user_to_event',
                              arg: state
                        };
                        nzr_ajax(data);
                  }

            })

      </script>

</div>
<div class="bg-50 mt30 block-5 pb5">
      <?php
      nz_fb_like_box( 'https://www.facebook.com/Clubber.Mag' );
      ?>
</div>
<?php
/*    banners       */
include_once 'banners/single-event-1.php';
include_once 'banners/single-event-2.php';
?>