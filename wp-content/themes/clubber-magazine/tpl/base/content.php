
<?php
/* $raw = false; */

/* $layout = get_post_meta( get_the_ID(), 'layout', TRUE ); */
/* d( $layout ); */
/* d( is_page_template() ); */
/*
  if (
  is_post_type_archive( 'agenda' ) ||
  is_page_template()||
  $layout == 'raw'
  ) {
  $raw = TRUE;
  }
 */
/* d(Roots_Wrapping::$raw); */
if (Roots_Wrapping::$raw) {
    include roots_template_path();
} else {
    ?>
    <main class="<?php echo roots_main_class(); ?>" role="main">
        <?php include roots_template_path(); ?>
    </main>
    <?php if (roots_display_sidebar()) : ?>
        <aside class="<?php echo roots_sidebar_class(); ?>" role="complementary">
            <?php include roots_sidebar_path(); ?>
        </aside>
    <?php endif; ?>
    <?php
}
?>