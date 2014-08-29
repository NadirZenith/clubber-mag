
<footer id="site-footer" class="content-info pr clearfix pb15" role="contentinfo">
        <nav id="footer-menu" class="hide-767">
                <?php
                $footer_menu = get_transient('footer_menu_html');
                if (!$footer_menu) {
                        $footer_menu = wp_nav_menu(array(
                              'theme_location' => 'footer',
                              'echo' => FALSE
                        ));
                        set_transient('footer_menu_html', $footer_menu, 60 * 15);
                }
                echo $footer_menu;
                ?>
        </nav>
        <a class="" href="https://www.facebook.com/Clubber.Mag"  target="_blank">
                <span class="follow-us"></span>
        </a>
        <div class="back-to-top">
                <a href="#branding"><?php echo __('Back to Top', 'attitude'); ?></a>
        </div>
</footer>

<?php wp_footer(); ?>
