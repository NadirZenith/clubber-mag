
<?php get_header(); ?>

<div id="container">

      <link rel="stylesheet" href="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/js/datetimepicker/jquery.datetimepicker.css" type="text/css">

      <script type="text/javascript" src="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/js/datetimepicker/jquery.datetimepicker.js"></script>

      <script type="text/javascript">
            jQuery(document).ready(function($) {
                  $('#input_1_3').datetimepicker({
                        format: 'd/m/Y H:i',
                        minDate: 0
                  });
                  $('#input_1_19').datetimepicker({
                        format: 'd/m/Y H:i',
                        minDate: 0
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
                  margin-left: 10px;
                  margin-top: 10px;
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
