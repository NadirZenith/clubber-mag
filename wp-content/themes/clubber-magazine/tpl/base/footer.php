<?php
if (
    class_exists('WPSEO_Breadcrumbs') && !is_home() && !is_front_page()
) {
    WPSEO_Breadcrumbs::breadcrumb('<div id="breadcrumbs" class="group ml30">', '</div>', true);
}
?>
<div class="nzparallax parallax pr" id="footer-parallax">
    <img class="" src="<?php echo get_site_url() ?>/wp-content/themes/clubber-magazine/assets/css/img/logo-footer2.png" />
</div>
<nav id="footer-menu" class="group pb15 pr" style="z-index:20;">
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
<div class="back-to-top">
    <a href="#header"><?php echo __('Back to Top', 'cm'); ?></a>
</div>