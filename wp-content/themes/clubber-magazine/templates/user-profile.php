
<style>
        #user-profile-main{

        }
        #user-profile-images{
                /*background-color: blueviolet;*/
                /*height: 200px;*/
                overflow: hidden;
        }
        #user-associated-events-main{
                /*background-color: yellowgreen;*/
                /*height: 200px;*/

        }

        #user-profile-background{
                /*position: absolute;*/
                background-color: yellowgreen;
                width: 100%;
                height: 100%;
        }
        #user-profile-picture{
                position: absolute;
                /*background-color: blueviolet;*/
                top: 20px;
                left: 0;
                width: 25%;
                height: 25%;

                /*width: 160px;*/
                /*height: 160px;*/

        }



</style>
<div id="" class="col-2-4 fl pb15 " style="" >
        <section class="bg-50 block-5">
                <div class="ml5 cb group">
                        <h1 class="fl"><?php echo $curauth->get('display_name'); ?></h1>
                        <?php
                        if ($curauth->ID == get_current_user_id()) {
                                ?>
                                <span class="ml15" style="line-height:3">
                                        <?php echo " [<a  href=\"{$edit_perfil_url}\" title=\"Editar perfil\"> Editar </a>] "; ?>
                                        <?php echo " [<a href=\"{$logout_url}\" title=\"Logout\"> Salir </a>] "; ?>
                                </span>
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
                                <?php
                                echo get_the_author_meta('description');
                                ?>
                        </div>

                </div>
        </section>
        <div class="bg-50 block-5 mt5 meddium">

                <div class="ml5">
                        <ul>
                                <li class="">
                                        <span class="bold">Web: </span>
                                        <a href="http://www.clubber-mag.com" target="_blank" rel="nofollow">
                                                http://www.clubber-mag.com
                                        </a>
                                </li>
                                <li class="">
                                        <span class="bold">Twitter: </span>  
                                        <a href="https://facebook.com/clubber-mag" target="_blank" rel="nofollow">
                                                https://facebook.com/clubber-mag
                                        </a>
                                </li>
                                <li class="">
                                        <span class="bold"> Facebook: </span>  
                                        <a href="https://twitter.com/clubber-mag" target="_blank" rel="nofollow">
                                                https://twitter.com/clubber-mag
                                        </a>
                                </li>

                        </ul>
                </div>


        </div>
</div>

<?php
$NZRelation = New NZRelation('events_to_users', 'event_id', 'user_id');
$user_events = $NZRelation->getRelationTo($curauth->ID);

$events = array(0);
foreach ($user_events as $event) {
        $events[] = $event->event_id;
}
$start_date = strtotime("now");
$args = array(
      'post_type' => 'agenda',
      'posts_per_page' => 4,
      'post__in' => $events,
      'order' => 'ASC',
      'orderby' => 'meta_value_num',
      'meta_key' => 'wpcf-event_begin_date',
      'meta_query' => array(
            array(
                  'key' => 'wpcf-event_begin_date',
                  'value' => $start_date,
                  'type' => 'NUMERIC',
                  'compare' => '>='
            )
      )
);


$wp_query = new WP_Query($args);
?>
<div id="" class="col-2-4 fl" >
        <section class="bg-50 block-5  pb15">

                <div class="ml5 cb group">
                        <h1 class="fl">Assistiré</h1>
                        <?php
                        if ($curauth->ID == get_current_user_id()) {
                                ?>
                                <span class="fr mr5 mt5">[ <a href="<?php echo get_permalink(get_page_by_path('subir-evento')) ?>">subir evento</a> ]</span>
                                <?php
                        }
                        ?>
                </div>

                <?php
                if (have_posts()) {
                        ?>

                        <ul>
                                <?php
                                while (have_posts()) {
                                        the_post();
                                        ?>
                                        <li>
                                                <article class="col-2-4 fl">
                                                        <div class="hover-2" style="">
                                                                <h2 class="ml5" style="line-height: normal">
                                                                        <a style="" href="<?php the_permalink(); ?>">
                                                                                <?php
                                                                                echo get_the_title()
                                                                                ?>
                                                                        </a>
                                                                </h2>
                                                        </div>
                                                        <div class="event-date" style="position: absolute; right: 0; top: 0px; opacity: 0.8">
                                                                <?php
                                                                $date = get_post_meta(get_the_ID(), 'wpcf-event_begin_date', true);
                                                                echo date('d/m/y', $date);
                                                                $tax = 'city';
                                                                if ($term = wp_get_post_terms(get_the_ID(), $tax)[0]->name) {
                                                                        $link = get_term_link($term, $tax);
                                                                        echo " <a href='{$link}'>{$term}</a>";
                                                                }
                                                                ?>
                                                        </div>
                                                        <a class="featured-image" href="<?php echo get_permalink($event->ID); ?>"  style="">
                                                                <?php echo get_the_post_thumbnail(get_the_ID(), '290-160-thumb'); ?>
                                                        </a>
                                                </article>
                                        </li>    
                                        <?php
                                }
                                ?>

                        </ul>
                        <?php
                } else {
                        if ($curauth->ID == get_current_user_id()) {
                                ?>
                                <h2 class="ml5">Subscribete a eventos!</h2>
                                <?php
                        } else {
                                ?>
                                <h2 class="ml5">Este usuário no subscribio a ningun evento</h2>
                                <?php
                        }
                        ?>
                        <?php
                }
                ?>
        </section>

</div>