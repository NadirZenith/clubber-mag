/**
* Template Name: Form Page Template
*
* Displays the contact page template.
*
*/
<?php get_header(); ?>

<div id="container">

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
            .gfield .validation_message {
                  color: blue;
            }
            
            .gform_footer .gform_button{
                  margin: 10px ;
                  display: block;
                  
                  margin-left: 20px
            }
            
            #gforms_confirmation_message{
                  font-size: 150%;
                  font-weight: 700;
                  margin-left: 10px;
            }
      </style>
      <?php
      global $post;
      if (have_posts()) {
            while (have_posts()) {
                  the_post();

                  do_action('attitude_before_post');
                  ?>
                  <section class="bg-50 block-5 pb15" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="">
                              <h1 class="ml5 mt5 bigger">
                                    <?php the_title(); ?>
                              </h1>
                        </header>
                        <div class="mt5 ml5 meddium mr5 cb pb5">
                              <?php
                              the_content()
                              ?>
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
