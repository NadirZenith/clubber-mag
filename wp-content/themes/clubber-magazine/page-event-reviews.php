
<?php get_header(); ?>

<div id="container">

      <ul class="archive-list">

          
            <li class="bg-50 block-5 mt15">

                  <section class="">
                        <div class="fr col-3-4 col-min">
                              <h1>
                                    <a class="ml5" href="<?php echo get_post_type_archive_link('photo'); ?>">
                                          Photo review
                                    </a>
                              </h1>

                              <div class="meddium bold">
                                    <p>
                                          Mira, búscate y comparte las fotografías de los eventos más importantes de tu cuidad.
                                    </p>
                              </div>
                              <a class="readmore mr5" href="<?php echo get_post_type_archive_link('photo'); ?>" title=""> <?php echo __('Read more', 'attitude') ?></a>
                        </div>
                        <div class="fl col-1-4 nm">
                              <a class="featured-image" href="<?php echo get_post_type_archive_link('photo'); ?>">
                                    <?php
                                    $img_src = get_site_url() . '/wp-content/themes/clubber-magazine/images/photo_review.png';
                                    ?>
                                    <img src="<?php echo $img_src ?>"/>
                              </a>
                        </div>

                  </section>  
            </li>

            <li class="bg-50 block-5 mt15">

                  <section class="">
                        <div class="fr col-3-4 col-min">
                              <h1>
                                    <a class="ml5" href="<?php echo get_post_type_archive_link('video'); ?>">
                                          Video review
                                    </a>
                              </h1>

                              <div class="meddium bold">
                                    <p>
                                          Revive los eventos más destacados en tú cuidad con nosotros.
                                    </p>
                              </div>
                              <a class="readmore mr5" href="<?php echo get_post_type_archive_link('video'); ?>" title=""> <?php echo __('Read more', 'attitude') ?></a>
                        </div>
                        <div class="fl col-1-4 nm">
                              <a class="featured-image" href="<?php echo get_post_type_archive_link('video'); ?>">
                                    <?php
                                    $img_src = get_site_url() . '/wp-content/themes/clubber-magazine/images/video_review.png';
                                    ?>
                                    <img src="<?php echo $img_src ?>"/>
                              </a>
                        </div>

                  </section>  
            </li>
      </ul>


</div><!-- #container -->

<?php get_footer(); ?>
