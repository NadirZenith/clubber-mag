
<?php
$search = get_query_var('s');

$search = str_replace(' ', '-', $search);
$search_params = array(
    'search' => "*{$search}*",
    'search_columns' => array(
        'user_login',
        'user_nicename',
        'user_email',
        'user_url',
    ));
$user_query = new WP_User_Query($search_params);
/* $users_found = $user_query->get_results(); */
?>
<div class="box-5">
    <section>
        <header>
            <h2>
                Usuarios
            </h2>
            <hr class="cb pb5">
        </header>
        <?php
        if (!empty($user_query->results)) {
            ?>
            <ul>
                <?php
                foreach ($user_query->results as $user) {
                    ?>
                    <li class="col-1-4 fl">
                        <article class="">
                            <a href="<?php echo get_author_posts_url($user->ID); ?>" class="fl">
                                <?php
                                $url = nz_get_user_image($user->ID, 'profile');
                                ?>
                                <img src="<?php echo $url ?>" alt="clubber-mag-profile-picture" width="100" height="100">
                            </a>
                            <div class="fl">
                                <a class="ml5" href="<?php echo get_author_posts_url($user->ID); ?>" >

                                    <?php echo $user->display_name ?>
                                </a>
                            </div>
                        </article>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
        } else {
            ?>
            <p class="meddium"><?php _e('No users found', 'cm'); ?> <?php _e('with', 'cm'); ?> <span style="font-style:italic">'<?php echo get_query_var('s') ?>'</span></p>
            <?php
        }
        ?>
    </section>  

    <div class="group pb15"></div>
    <section>
        <header>
            <h2>
                <?php _e('Other results', 'cm') ?>
            </h2>
            <hr class="cb pb5">
        </header>
        <?php
        if (have_posts()) {
            ?>
            <ul class="archive-list">
                <?php
                while (have_posts()) {
                    the_post();
                    ?>
                    <li>
                        <?php
                        get_template_part('tpl/parts/list-3');
                        ?>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
        } else {
            ?>
            <p class="meddium"><?php _e('No content found', 'cm'); ?> <?php _e('with', 'cm'); ?> <span style="font-style:italic">'<?php echo get_query_var('s') ?>'</span></p>
            <?php
        }
        ?>
    </section>
    <?php
    include (locate_template('tpl/parts/pagination.php'));
    ?>
</div>
