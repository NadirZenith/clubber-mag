<div class="cm-sticky-sidebar oh">
    <?php
    if (is_post_type_archive('agenda')) {
        //archive event
        $new_event_link = get_permalink(cm_lang_get_post(CM_RESOURCE_EVENT_PAGE_ID));
        ?>
        <div class="tc">
            <a class="pure-button pure-button-primary" href="<?php echo $new_event_link ?>" >
                <?php _e('Upload and share event', 'cm') ?>
                <i class="fa fa-users"></i>
            </a>
        </div>
        <?php
        dynamic_sidebar('archive_event_sidebar');
    } else if (is_post_type_archive('open-frequency')) {
        //Single
        $podcast_form_url = get_permalink(CM_RESOURCE_PODCAST_PAGE_ID);
        ?>
        <div class="tc">
            <a class="pure-button pure-button-primary fancybox ajax" data-fancybox-type="ajax" href="<?php echo $podcast_form_url ?>"> 
                <?php _e('Share your', 'cm') ?><i class="fa fa-soundcloud"></i>
            </a>
        </div>
        <?php
    } else if (is_singular()) {
        //singular
        if (is_singular('agenda')) {
            //agenda
            dynamic_sidebar('single_event_sidebar');
        } else {
            //rest
            dynamic_sidebar('singular_sidebar');
        }
    }
    //banners
    dynamic_sidebar('banners_sidebar');
    ?>
</div>

<script>
    (function ($) {

        $(document).ready(function ($) {

            var sticky = new Waypoint.Sticky({
                element: $('.cm-sticky-sidebar')[0],
                offset: 30,
                handler: function () {

                }
            });
            console.log(sticky);


            setSickWidth();
            window.onresize = setSickWidth;

            function setSickWidth()
            {
                $('.cm-sticky-sidebar').css('width', $('.sticky-wrapper').parent().css('width'));

            }
        });

    })(jQuery);
</script>
<?php
