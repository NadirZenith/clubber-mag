
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
                        $('#input_1_3').datetimepicker({
                                addSliderAccess: true,
                                sliderAccessArgs: {touchonly: false}
                        });
                        $('#input_1_19').datetimepicker({
                                addSliderAccess: true,
                                sliderAccessArgs: {touchonly: false}
                        });
                });
        </script>
        <style>

                .gform_fields .small{
                        width: 30%;
                        margin-left: 5px;
                }
                .gform_fields .medium{
                        width: 70%;
                        margin-left: 5px;
                }
                .gform_fields .large{
                        width: 90%;
                        margin-left: 5px;
                }
                .gfield_label {
                        margin-left: 5px;
                }
                .gfield_required{
                        margin-left: 5px;
                        /*color: ;*/
                }
                .gfield_description{
                        margin-left: 5px;
                        color: #bbb;
                }
                .gfield:hover .gfield_description{
                        color: #ddd;
                }
                .validation_error, .gfield .validation_message {
                        color: blue;
                }

                #field_2_18 .gfield_description a{
                        font-weight: bold;
                }
                #field_2_18 .gfield_description{
                        color: #0583F2;
                }
                #gform_submit_button_1{
                        margin: 15px;
                        /*clear: both;*/
                        float: right;
                }
                .gform_confirmation_wrapper {
                        font-size: 150%;
                        font-weight: 700;
                        margin-left: 20px;
                        margin-top: 30px;
                        color:#333;
                }

        </style>
        <?php
        /* d('page'); */
        global $post;
        if (have_posts()) {
                while (have_posts()) {
                        the_post();

                        do_action('attitude_before_post');
                        ?>
                        <section class="bg-50 block-5" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <header class="">
                                        <h1 class="ml5 mt5">
                                                <?php the_title(); ?>
                                        </h1>
                                </header>
                                <div class="mt5 ml5 meddium mr5 cb">
                                        <?php
                                        the_content()
                                        ?>
                                        Los campos marcados con * son obligatorios

                                </div>

                        </section>
                        <?php
                }
        } else {
                ?>
                <h1 class="entry-title"><?php _e('No Posts Found.', 'attitude'); ?></h1>
                <?php
        }
        ?>


</div><!-- #container -->

<?php get_footer(); ?>
