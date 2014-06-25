
<style>
        #user-profile-picture{
                position: absolute;
                /*background-color: blueviolet;*/
                top: 20px;
                left: 0;
                width: 25%;
                height: 25%;
        }

</style>
<!--<div id="" class="" style="" >-->
<!--<div class="group fl">-->

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
                <div id="user-profile-images" class="" >
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
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                        <?php
                        /*echo get_the_author_meta('description');*/
                        ?>
                </div>

        </div>

        <!--<div class="col-2-4 bg-50 block-5 mt5 meddium">-->
        
<!--        
        <div class="">

                <div class="ml5">
                        <ul>
                                <li class="">
                                        <span class="bold">Web: </span>
                                        <a href="http://www.clubber-mag.com" target="_blank" rel="nofollow">
                                                http://www.xxx.com
                                        </a>
                                </li>
                                <li class="">
                                        <span class="bold">Twitter: </span>
                                        <a href="https://facebook.com/clubber-mag" target="_blank" rel="nofollow">
                                                https://facebook.com/xxx
                                        </a>
                                </li>
                                <li class="">
                                        <span class="bold"> Facebook: </span>
                                        <a href="https://twitter.com/clubber-mag" target="_blank" rel="nofollow">
                                                https://twitter.com/xxx
                                        </a>
                                </li>

                        </ul>
                </div>


        </div>
-->
</section>

<?php
wp_reset_postdata();
?>
