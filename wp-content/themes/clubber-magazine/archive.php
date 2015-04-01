<section class="m5">
    <header class="mt15 mb10">
        <h1>
            <span class="cm-title">
                <?php
                if (is_category()) :
                    single_cat_title();
                elseif (is_tax()) :
                    single_tag_title();
                elseif (is_archive()) :
                    post_type_archive_title();
                endif;
                ?>
            </span>
        </h1>
    </header>
    <?php
    global $post;
    if (have_posts()) {
        ?>
        <ul>
            <?php
            while (have_posts()) {
                the_post();
                if (in_array(get_post_type(), array('into-the-beat', 'open-frequency'))) {
                    $class = (get_post_type() == 'into-the-beat') ? 'col-md-1-2 fl' : '';
                    ?>
                    <li class="col-1 <?php echo $class ?>">
                        <div class="box-3">
                            <?php
                            get_template_part('tpl/parts/list-5');
                            ?>
                        </div>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="col-1">
                        <?php
                        get_template_part('tpl/parts/list-3');
                        ?>
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
    ?>
</section>