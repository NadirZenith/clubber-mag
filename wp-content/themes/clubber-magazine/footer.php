
                        </div><!-- #main -->

                        <footer id="site-footer" class="pr clearfix pb15">


                                <nav id="footer-menu" class="hide-767">

                                        <?php wp_nav_menu(array('theme_location' => 'footer')); ?>
                                </nav>

                                <a class="" href="https://www.facebook.com/Clubber.Mag"  target="_blank">
                                        <span class="follow-us"></span>
                                </a>

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