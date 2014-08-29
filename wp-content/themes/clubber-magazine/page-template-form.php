<?php
/**
 * Template Name: Form Page Template
 *
 * Displays the contact page template.
 *
 */
?>

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
