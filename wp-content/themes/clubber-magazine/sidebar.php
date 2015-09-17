<div class="cm-sticky-sidebar oh mt15">
    <?php
    if (is_home()) {
        //noticias
        dynamic_sidebar('archive_sidebar');
    } elseif (is_archive()) {
        //archive
        if (is_post_type_archive('agenda')) {
            //events
            $new_event_link = get_permalink(cm_lang_get_post(CM_RESOURCE_EVENT_PAGE_ID));
            ?>
            <div class="tc">
                <a class="pure-button pure-button-primary" href="<?php echo $new_event_link ?>" >
                    <?php _e('Upload and share event', 'cm') ?>&nbsp;&nbsp;<i class="fa fa-users"></i>
                </a>
            </div>
            <?php
            dynamic_sidebar('archive_event_sidebar');
        } elseif (is_post_type_archive('open-frequency')) {
            //open frequency
            $podcast_form_url = get_permalink(CM_RESOURCE_PODCAST_PAGE_ID);
            ?>
            <div class="tc">
                <a class="pure-button pure-button-primary fancybox ajax" data-fancybox-type="ajax" href="<?php echo $podcast_form_url ?>"> 
                    <?php _e('Share your', 'cm') ?>&nbsp;&nbsp;<i class="fa fa-soundcloud" style="color: #f50;"></i>
                </a>
            </div>
            <?php
            dynamic_sidebar('archive_open_frequency_sidebar');
        } else {

            dynamic_sidebar('archive_sidebar');
        }
    } elseif (is_singular()) {
        //singular
        if (is_singular('agenda')) {
            //event
            dynamic_sidebar('single_event_sidebar');
        } elseif (is_singular('artist')) {
            //artist
            dynamic_sidebar('single_artist_sidebar');
        } else {
            //rest
            dynamic_sidebar('singular_sidebar');
        }
    }
    dynamic_sidebar('banners_sidebar');
    ?>
</div>
<style>
   
</style>
<script>
    (function ($) {

        var stickySidebar = function () {

            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                return;
            }

            var debug = false;

            function log() {
                if (debug === true) {
                    console.log(arguments);
                }
            }

            var $sidebar = $('.cm-sticky-sidebar');
            var $ref = $sidebar.parent();
            var $main = $('.has-sidebar');
            var width = $sidebar.parent().css('width');
            var $wrap = $('<div id="sticky-wrap"></div>').css({
                position: 'relative',
                width: width,
                height: $main.height()
            });
            $sidebar.wrap($wrap);

            window.onresize = function () {
                log('resize');
                $('#sticky-wrap').css('width', $ref.css('width'));

                if ($(window).width() < 1024) {
                    Waypoint.disableAll();
                    $('#sticky-wrap').css('height', 'auto');
                } else {
                    $('#sticky-wrap').css('height', $('.has-sidebar').css('height'));
                    Waypoint.refreshAll();
                }
            };

            /*            
             setInterval(function () {
             $('#sticky-wrap').css('height', $('.has-sidebar').css('height'));
             Waypoint.refreshAll();
             
             }, 1000);
             * */
            $sidebar.find('iframe').load(function () {
                $('#sticky-wrap').css('height', $('.has-sidebar').css('height'));
                Waypoint.refreshAll();

            });

            //sidebar start
            new Waypoint({
                element: $sidebar,
                offset: 15,
                handler: function (direction) {
                    log('sidebar start - ' + direction);
                    if ($sidebar.height() < $(window).height()) {
                        $sidebar.toggleClass('sidebar-top', 'down' === direction);
                    }
                }
            });

            //sidebar finish
            new Waypoint({
                element: $sidebar,
                offset: function () {
                    var $sidebar = $('.cm-sticky-sidebar');
                    var sHeight = $sidebar.height();
                    var wHeight = $(window).height();
                    return -(sHeight - wHeight);
                },
                handler: function (direction) {
                    log('sidebar finish - ' + direction);
                    if ($sidebar.height() > $(window).height()) {
                        $sidebar.toggleClass('sidebar-bottom', 'down' === direction);
                    }
                }
            });

            //footer start
            var $footer = $('#footer');
            new Waypoint({
                element: $footer,
                offset: function () {
                    if ($sidebar.height() > $(window).height()) {
                        return $(window).height();
                    } else {
                        /*return $sidebar.height();*/
                        return $sidebar.height() + 45;
                    }
                },
                handler: function (direction) {
                    log('footer start - ' + direction);

                    $sidebar.toggleClass('sidebar-down', 'down' === direction);
                }
            });
        };

        $(document).ready(function () {
            stickySidebar();
        });
    })(jQuery);

</script>
<?php
