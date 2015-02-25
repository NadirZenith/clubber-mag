<section class="m5">
      <div class="mb5">
            <?php
            cm_home_list_title( 'open-frequency', __( 'Open Frequency', 'cm' ) );
            ?>
      </div>
      <div class="homeCustomScroll oh" style="max-height: 455px;">
            <?php
            $args = array(
                  'post_type' => 'open-frequency',
                  'posts_per_page' => 3,
            );
            $query2 = new WP_Query( $args );

            while ( $query2->have_posts() ) {
                  $query2->the_post();
                  ?>
                  <div class="col-1 fl">
                        <article>
                              <div class="hover-2">
                                    <h2 class="ml5 sf-2">
                                          <a href="<?php the_permalink(); ?>">
                                                <?php
                                                if ( get_the_title() ) {
                                                      the_title();
                                                } else {
                                                      echo 'no name';
                                                }
                                                ?>
                                          </a>
                                    </h2>
                              </div>
                              <div class="col-1">
                                    <?php
                                    if ( $sc_info_str = get_post_meta( get_the_ID(), CM_META_SOUNDCLOUD, true ) ) {
                                          $sc_info = json_decode( $sc_info_str );
                                          if ( $sc_info ) {
                                                echo nz_get_soundcloud_iframe( $sc_info->uri, array( 'visual' => FALSE ) );
                                          }
                                    }
                                    ?>
                              </div>
                        </article>
                  </div>
                  <?php
            } //END while
            ?>
            <?php wp_reset_postdata(); ?>
      </div>
      <?php cm_home_list_more( 'open-frequency', __( 'see more ...', 'cm' ) ) ?>

</section>
<script>
      (function($) {
            $(window).load(function() {

                  $(".homeCustomScroll").mCustomScrollbar({
                        setWidth: false,
                        setHeight: false,
                        setTop: 0,
                        setLeft: 0,
                        axis: "y",
                        scrollbarPosition: "inside",
                        scrollInertia: 950,
                        autoDraggerLength: true,
                        autoHideScrollbar: false,
                        autoExpandScrollbar: false,
                        alwaysShowScrollbar: 0,
                        snapAmount: null,
                        snapOffset: 0,
                        mouseWheel: {
                              enable: true,
                              scrollAmount: "auto",
                              axis: "y",
                              preventDefault: false,
                              deltaFactor: "auto",
                              normalizeDelta: false,
                              invert: false,
                              disableOver: ["select", "option", "keygen", "datalist", "textarea"]
                        },
                        scrollButtons: {
                              enable: true,
                              /*scrollType: "stepped",*/
                              scrollType: "stepless",
                              scrollAmount: "auto"
                                      /*scrollAmount: 100*/
                        },
                        keyboard: {
                              enable: true,
                              scrollType: "stepless",
                              scrollAmount: "auto"
                        },
                        contentTouchScroll: 25,
                        advanced: {
                              autoExpandHorizontalScroll: false,
                              autoScrollOnFocus: "input,textarea,select,button,datalist,keygen,a[tabindex],area,object,[contenteditable='true']",
                              updateOnContentResize: true,
                              updateOnImageLoad: true,
                              updateOnSelectorChange: false,
                              releaseDraggableSelectors: false
                        },
                        theme: "light",
                        callbacks: {
                              onInit: false,
                              onScrollStart: false,
                              onScroll: false,
                              onTotalScroll: false,
                              onTotalScrollBack: false,
                              whileScrolling: false,
                              onTotalScrollOffset: 0,
                              onTotalScrollBackOffset: 0,
                              alwaysTriggerOffsets: true,
                              onOverflowY: false,
                              onOverflowX: false,
                              onOverflowYNone: false,
                              onOverflowXNone: false
                        },
                        live: false,
                        liveSelector: null
                  });

            });
      })(jQuery);
</script>