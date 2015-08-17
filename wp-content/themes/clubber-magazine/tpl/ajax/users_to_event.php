<section>
    <h1><?php _e('Participants', 'cm') ?></h1>
    <ul class="pure-g">
        <?php
        foreach ($users as $user) {
            ?>
            <li class=" pure-u-1 pure-u-md-1-5">
                <div class="p3">
                    <article class="pr">
                        <a href="<?php echo get_author_posts_url($user->ID); ?>" class="featured-image">
                            <?php
                            $default = get_template_directory_uri() . '/assets/images/user/user-profile-ph.jpg';
                            $url = nz_get_user_image($user->ID, 'profile', $default);
                            ?>
                            <img src="<?php echo $url ?>" alt="clubber-mag-profile-picture" width="100" height="100">
                        </a>
                        <div class="hover w-100 bottom">

                            <a href="<?php echo get_author_posts_url($user->ID); ?>" >
                                <?php echo $user->display_name ?>
                            </a>
                        </div>
                    </article>
                </div>
            </li>
            <?php
        }
        ?>
    </ul>
</section>