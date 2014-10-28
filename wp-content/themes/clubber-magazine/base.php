<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
        <?php get_template_part('tpl/head'); ?>
        <body <?php body_class(); ?> >
                <?php
                //facebook and google analytics
                /** @todo nz move to action get_header / after body */
                get_template_part('tpl/after_body');
                ?>

                <?php
                /* do_action('get_header'); */
                ?>
                <div class="wrapper">
                        <header id="branding">
                                <?php
                                //the header of page, logo banner menu etc...
                                get_template_part('tpl/header');
                                ?>
                        </header>

                        <div id="main" class="container clearfix">
                                <div id="container">
                                        <?php
                                        include roots_template_path();
                                        ?>
                                      
                                </div><!-- #container -->


                        </div>

                        <?php
                        get_template_part('tpl/footer');
                        ?>
                </div><!-- /.wrap -->

        </body>
</html>
