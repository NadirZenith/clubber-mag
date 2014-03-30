<?php
/**
 * Displays the footer section of the theme.
 *
 * @package 		Theme Horse
 * @subpackage 	Attitude
 * @since 			Attitude 1.0
 */
?>
</div><!-- #main -->

<?php
/**
 * attitude_after_main hook
 */
/*do_action('attitude_after_main');*/
?>

<?php
/**
 * attitude_before_footer hook
 */
/*do_action('attitude_before_footer');*/
?>	

<!--<footer id="site-footer" class="clearfix">-->
<footer id="colophon" class="clearfix">
      <!--<footer id="colophon" class="clearfix">-->
      <div class="bg-50  col-2-4 fl" style="border-radius: 5px;">
           
           
      </div>
      <div class="bg-50  col-2-4 fl" style="border-radius: 5px;">
            <h1 class="ml5">
                  Partners:
            </h1>
            <ul>
                  <li>li li li li</li> 
            </ul>
            <ul>
                  <li>li li li li</li> 
            </ul>
            <ul>
                  <li>li li li li</li> 
            </ul>
      </div>
      <div class="back-to-top">
            <a href="#branding"><?php echo __('Back to Top', 'attitude'); ?></a>
      </div>
      <?php
      /**
       * attitude_footer hook		       
       *
       * HOOKED_FUNCTION_NAME PRIORITY
       *
       * attitude_footer_widget_area 10
       * attitude_open_sitegenerator_div 20
       * attitude_socialnetworks 25
       * attitude_footer_info 30
       * attitude_close_sitegenerator_div 35
       * attitude_backtotop_html 40
       */
       /*do_action('attitude_footer'); */
      /* echo '<div class="back-to-top"><a href="#branding">' . __('Back to Top', 'attitude') . '</a></div>'; */
      /* $output = '<div class="copyright">' . __('Copyright &copy;', 'attitude') . ' ' . '[the-year] [site-link]' . ' ' . __('Theme by:', 'attitude') . ' ' . '[th-link]' . ' ' . __('Powered by:', 'attitude') . ' ' . '[wp-link] ' . '</div><!-- .copyright -->'; */
      /* echo do_shortcode($output); */
      ?>
</footer>

<?php
/**
 * attitude_after_footer hook
 */
/*do_action('attitude_after_footer');*/
?>	

</div><!-- .wrapper -->

<?php
/**
 * attitude_after hook
 */
/*do_action('attitude_after');*/
?> 

<?php 
wp_footer(); 
?>

</body>
</html>