
                  </div><!-- #main -->

                  <footer id="site-footer" class="pr clearfix pb15">


                        <nav id="footer-menu" class="hide-767">

                              <?php wp_nav_menu(array('theme_location' => 'footer')); ?>
                        </nav>

                        <div class="featured-image" style="width:150px;position: absolute; bottom: 10px; right: 25px;">
                              <a href="">
                                    <img src="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/images/facebook_footer.png">
                              </a>
                        </div>

                        <div class="back-to-top">
                              <a href="#branding"><?php echo __('Back to Top', 'attitude'); ?></a>
                        </div>

                  </footer>
            </div><!-- .wrapper -->

            <?php
            wp_footer();
            ?>

      </body>
</html>