<section class="m5">
    <div class="mb5">
        <?php
        cm_home_list_title('open-frequency', __('Open Frequency', 'cm'));
        ?>
    </div>
    <div class="homeCustomScroll oh" style="max-height: 455px;">
        <ul>

            <?php
            $args = array(
                'post_type' => 'open-frequency',
                'posts_per_page' => 3,
            );
            $query2 = new WP_Query($args);

            while ($query2->have_posts()) {
                $query2->the_post();
                ?>
                <li class="col-1 fl">
                    <?php
                    get_template_part('tpl/parts/list-5');
                    ?>
                </li>
                <?php
            } //END while
            ?>
        </ul>

        <?php wp_reset_postdata(); ?>
    </div>
    <?php cm_home_list_more('open-frequency', __('see more ...', 'cm')) ?>

</section>
<script>
    (function ($) {
        $(window).load(function () {

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