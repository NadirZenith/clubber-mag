
<?php
wp_enqueue_style('jquery-ui-theme', 'http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css', $deps, $ver, $media);
wp_enqueue_style('jquery-ui-timepicker-theme', get_template_directory_uri() . '/js/datetimepickerJqueryUI/jquery-ui-timepicker-addon.min.css', $deps, $ver, $media);

wp_enqueue_script('jquery-ui', 'http://code.jquery.com/ui/1.10.4/jquery-ui.min.js', array('jquery'));
wp_enqueue_script('jquery-ui-timepicker', get_template_directory_uri() . '/js/datetimepickerJqueryUI/jquery-ui-timepicker-addon.min.js', array('jquery-ui'));
wp_enqueue_script('jquery-ui-datetimepicker-i18n', get_template_directory_uri() . '/js/datetimepickerJqueryUI/i18n/jquery-ui-timepicker-es.js', array('jquery-ui-timepicker'));
wp_enqueue_script('jquery-ui-sliderAccess', get_template_directory_uri() . '/js/datetimepickerJqueryUI/jquery-ui-sliderAccess.js', array('jquery-ui'));
?>

<?php get_header(); ?>

<div id="container">

        <script type="text/javascript">
                jQuery(document).ready(function($) {
                        $('#input_<?php echo $nz['form.event']['id'];?>_3').datetimepicker({
                                addSliderAccess: true,
                                sliderAccessArgs: {touchonly: false}
                        });
                        $('#input_<?php echo $nz['form.event']['id'];?>_19').datetimepicker({
                                addSliderAccess: true,
                                sliderAccessArgs: {touchonly: false}
                        });
                });
        </script>
        <style>


                .gform_confirmation_wrapper {
                        font-size: 150%;
                        font-weight: 700;
                        margin-left: 20px;
                        margin-top: 30px;
                        color:#333;
                }

        </style>

        <section class="bg-50 block-5">
               
                <div class="col-3-4" style="margin: auto">

                        <?php
                                                echo $nz['event_form'];
/*
                        $event_form_id = 10;
                        echo do_shortcode('[gravityform id="' . $event_form_id . '" name="Evento" title="false" description="false" ajax="false"]');
 */
                        ?>
                </div>
        </section>



</div><!-- #container -->

<?php get_footer(); ?>
