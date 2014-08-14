<?php
/** @todo nz move this to stylesheet */
?>
<style>
        #user-profile-picture{
                position: absolute;
                top: 20px;
                left: 0;
                width: 25%;
                height: 25%;
        }
        #user-profile-picture img{
                background-color: #fff;
        }

</style>

<section class="bg-50 block-5">
        <div class="ml5 cb group">
                <h1 class="fl"><span><?php echo $curauth->get('display_name'); ?></span></h1>
                <?php
                if ($curauth->ID == get_current_user_id()) {
                        $edit_perfil_url = get_author_posts_url($curauth->ID) . 'editar';
                        //http://lab.dev/clubber-mag-dev/perfil/{current_author}/edit
                        ?>
                        <div class="fr mr5 mt5">
                                <span class="">[ <a href="<?php echo $edit_perfil_url ?>">Editar</a> ]</span>
                                <span class="">[ <a href="<?php echo $logout_url ?>">Salir</a> ]</span>
                        </div>
                        <?php
                }
                ?>
        </div>
        <div id="user-profile-main" class="" >
                <div id="user-profile-images" class="" style="border-bottom:1px solid #aaa">
                        <div class="pr">

                                <div id="user-profile-background" class="featured-image">
                                        <?php
                                        $url = nz_get_user_image($curauth->ID, 'background');
                                        ?>
                                        <img src="<?php echo $url ?>" alt="clubber-mag-background-picture" width="589" height="200">
                                </div>
                                <div id="user-profile-picture" >
                                        <?php
                                        $url = nz_get_user_image($curauth->ID, 'profile');
                                        ?>
                                        <img src="<?php echo $url ?>" alt="clubber-mag-profile-picture" width="160" height="160">
                                </div>
                        </div>

                </div>
                <div class="meddium" style="text-align:justify; padding: 5px;">
                        <?php
                        echo get_user_meta($curauth->ID, 'description', true);
                        ?>
                </div>
                <hr class="pb5" style="border-color: #aaa">

                <ul class="ml5">
                        <?php
                        $website = get_user_meta($curauth->ID, 'website', true);
                        if ($website) {
                                ?>
                                <li class="">
                                        <span class="bold">Web: </span>
                                        <a href="<?php echo $website ?>" target="_blank" rel="nofollow">
                                                <?php echo $website ?>
                                        </a>
                                </li>  
                                <?php
                        }
                        ?>
                        <?php
                        $facebook = get_user_meta($curauth->ID, 'facebook', true);
                        if ($facebook) {
                                ?>
                                <li class="">
                                        <span class="bold">Facebook: </span>
                                        <a href="<?php echo $facebook ?>" target="_blank" rel="nofollow">
                                                <?php echo $facebook ?>
                                        </a>
                                </li>  
                                <?php
                        }
                        ?>
                        <?php
                        $twitter = get_user_meta($curauth->ID, 'twitter', true);
                        if ($twitter) {
                                ?>
                                <li class="">
                                        <span class="bold">Twitter: </span>
                                        <a href="<?php echo $twitter ?>" target="_blank" rel="nofollow">
                                                <?php echo $twitter ?>
                                        </a>
                                </li>  
                                <?php
                        }
                        ?>
                        <?php
                        $youtube = get_user_meta($curauth->ID, 'youtube', true);
                        if ($youtube) {
                                ?>
                                <li class="">
                                        <span class="bold">Youtube: </span>
                                        <a href="<?php echo $youtube ?>" target="_blank" rel="nofollow">
                                                <?php echo $youtube ?>
                                        </a>
                                </li>  
                                <?php
                        }
                        ?>

                </ul>

                <div class="cb m15 p15">
                        <div class="fb-like" data-href="<?php echo get_author_posts_url($curauth->ID) ?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
                </div>

        </div>


</section>

<?php
wp_reset_postdata();
?>
