<section>
    <header>
        <h1 class="section-title">
            <?php
            if (is_category()) :
                single_cat_title();
            elseif (is_tax()) :
                single_tag_title();
            elseif (is_archive()) :
                _e(post_type_archive_title('', false), 'cm');
            elseif (is_front_page() && is_home()) :
                //default home
                the_title();
            elseif (is_home()) :
                //blog
                echo get_the_title(get_option('page_for_posts', true));
            endif;
            ?>
        </h1>
    </header>
    <?php
    // if is archive music AND not taxonomy from music
    if (get_post_type() == 'music' && !is_tax('music_type')) {
        get_template_part('tpl/archive/music');
    } else {
        global $post;
        if (have_posts()) {
            ?>
            <ul class="pure-g">
                <?php
                while (have_posts()) {
                    the_post();
                    if (in_array(get_post_type(), array('into-the-beat', 'open-frequency'))) {

                        $class = (get_post_type() == 'into-the-beat') ? 'pure-u-1 pure-u-md-1-2' : 'pure-u-1';
                        ?>
                        <li class="<?php echo $class ?>">
                            <div class="p3">
                                <?php get_template_part('tpl/list/list-5'); ?>
                            </div>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class="pure-u-1">
                            <?php get_template_part('tpl/list/list-3'); ?>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
            <?php
            include (locate_template('tpl/parts/pagination.php'));
        } else {
            get_template_part('tpl/parts/not-found');
        }
    }
    ?>
</section>