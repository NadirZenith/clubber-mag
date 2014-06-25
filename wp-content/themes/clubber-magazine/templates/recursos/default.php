
<?php
get_header();
?>

<div id="container">

        <?php
        global $post;
        if (have_posts()) {
                while (have_posts()) {
                        the_post();
                        ?>
                        <section class="bg-50 block-5">
                                <article class="">
                                        <header class="ml5 mt5">
                                                <h1 class="bigger">
                                                        <?php the_title(); ?>
                                                </h1>
                                        </header>
                                        <div class="mt5 ml5 meddium bold">
                                                <?php
                                                the_content()
                                                ?>
                                        </div>
                                </article>
                        </section>
                        <?php
                }
        }
        ?>

</div>

<?php
get_footer();
?>