<?php
/*
 *   this template render user profile info
 */

$meta = get_user_meta($curauth->ID);

/* CONTACT FIELDS */
$all_socials = array(
    'home',
    'facebook',
    'soundcloud',
    'instagram',
    'google-plus',
    'youtube',
    'twitter'
);
$socials = array();
foreach ($all_socials as $network) {
    $socials[$network] = array(
        'url' => (isset($meta[$network])) ? $meta[$network][0] : null,
    );
}
?>
<header>
    <h2>
        <a class="title" href="#profile-info">
            <?php echo $curauth->get('display_name'); ?>
        </a>
    </h2>
</header>
<div id="user-profile-main" class="pr">
    <?php
    if ($curauth->ID == get_current_user_id()):
        $edit_perfil_url = add_query_arg(array('edit-id' => $curauth->ID, 'action' => 'editar'), get_author_posts_url($curauth->ID));
        $logout_url = wp_logout_url(home_url());
        ?>
        <div class="hover top right">
            <a title="<?php _e('sign-out', 'cm') ?>" href="<?php echo $logout_url ?>"><i class="fa  fa-sign-out"></i></a>
            <a title="<?php _e('edit', 'cm') ?>" href="<?php echo $edit_perfil_url ?>"><i class="fa fa-edit"></i></a>
        </div>
    <?php endif; ?>
    <div id="user-profile-images" class="pr">
        <div id="user-profile-picture">
            <?php
            $default = get_template_directory_uri() . '/assets/images/user/user-profile-ph.jpg';
            $url = nz_get_user_image($curauth->ID, 'profile', $default);
            ?>
            <img src="<?php echo $url ?>" alt="clubber-mag-profile-picture" width="160" height="160">
        </div>
        <div id="user-profile-background" class="featured-image">
            <?php
            $default = get_template_directory_uri() . '/assets/images/user/user-background-ph.jpg';
            $url = nz_get_user_image($curauth->ID, 'background', $default);
            ?>
            <img src="<?php echo $url; ?>" alt="clubber-mag-background-picture" width="589" height="200">
        </div>
    </div>

    <div class="m5 tj">
        <p>
            <?php echo get_user_meta($curauth->ID, 'description', true); ?>
        </p>
    </div>

    <hr class="pb5-" style="border-color: #aaa">
    <div class="group- pb10-">
        <?php nz_fa_social_icons($socials, 'social-icons-single'); ?>
    </div>
</div>
<?php wp_reset_postdata(); ?>