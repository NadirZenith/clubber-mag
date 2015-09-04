
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
<section>
    <header>
        <h2>
            <span class="title-highlight">
                <?php _e('Users', 'cm') ?>
            </span>
        </h2>
    </header>
    <?php
    if (!empty($user_query->results)) {
        ?>
        <ul class="pure-g">
            <?php
            foreach ($user_query->results as $user) {
                ?>
                <li class="pure-u-1 pure-u-md-1-4">
                    <article>
                        <a href="<?php echo get_author_posts_url($user->ID); ?>">
                            <?php
                            $default = get_template_directory_uri() . '/assets/images/user/user-profile-ph.jpg';

                            $url = nz_get_user_image($user->ID, 'profile', $default);
                            ?>
                            <img src="<?php echo $url ?>" alt="clubber-mag-profile-picture" width="100" height="100">
                        </a>
                        <a class="title" href="<?php echo get_author_posts_url($user->ID); ?>" >
                            <?php echo $user->display_name ?>
                        </a>
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
            <span class="title-highlight">
                <?php _e('Other results', 'cm') ?>
            </span>
        </h2>
    </header>
    <?php
    if (have_posts()) {
        ?>
        <ul class="pure-g">
            <?php
            while (have_posts()) {
                the_post();
                ?>
                <li class="pure-u-1">
                    <?php get_template_part('tpl/list/list-3'); ?>
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
