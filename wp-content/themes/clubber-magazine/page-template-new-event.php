<?php
/**
 * Template Name: New event Template
 *
 * Displays the new event or edit form.
 *
 */
?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <section <?php post_class(); ?>>
            <article id="post-<?php the_ID(); ?>">
                <?php echo get_template_part('tpl/parts/page-header') ?>
                <?php the_content(); ?>
            </article>
        </section>
    <?php endwhile; ?>
<?php endif; ?>

<style>
    .nzwpform_relationTo{
        width: 60%;
        min-width: 200px;
    }
    .row-relation-to-coolplace > a{
        margin-left: 15px;
    }
    .row-wpcf-event_price,
    .row-wpcf-event_user_email,
    .row-event_featured{
        clear: left;
    }
</style>
<script>
    $(function () {
        //------ fancybox
        $('.fancybox').fancybox({
            autoSize: false,
            width: "80%"
        });

        var dt1 = null;

        var nz_dtp_globalize = function (currentDateTime) {
            dt1 = currentDateTime;
        };

        var nz_dtp_litmit = function () {
            if (typeof dt1 !== "undefined") {
                this.setOptions({
                    minDate: dt1
                });
            }
        };


        var mytimes = [];

        for (var H = 23; H !== -1; H--) {
            for (var i = 45; i !== -15; i = (i < 0) ? 45 : i - 15) {
                var fix = (i === 0) ? '0' : '';
                mytimes.push(H.toString() + ':' + i.toString() + fix);
            }
        }
        mytimes.unshift('23:59');

        var dtoptions = {
            lang: 'es',
            allowTimes: mytimes,
            onChangeDateTime: nz_dtp_globalize,
            format: 'd/m/Y H:i'
        };
        var $datetime1 = $('#wpcf-event_begin_date');
        var $datetime2 = $('#wpcf-event_end_date');

        $datetime1.datetimepicker(dtoptions);

        $.extend(dtoptions, {onShow: nz_dtp_litmit, onChangeDateTime: null, allowTimes: mytimes.reverse()});

        $datetime2.datetimepicker(dtoptions);

    });


</script>