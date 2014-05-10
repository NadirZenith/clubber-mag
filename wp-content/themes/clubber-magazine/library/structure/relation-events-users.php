<?php
add_action('wp_head', 'nz_ajaxurl');

add_action('wp_ajax_relate_user_to_event', 'relate_user_to_event');
add_action('wp_ajax_nopriv_relate_user_to_event', 'get_event_users');

function relate_user_to_event() {
        $event = (int) $_GET['event'];
        $arg = $_GET['arg'];


        $NZRelation = New NZRelation('events_to_users', 'event_id', 'user_id');
         $result = $NZRelation->install_table(); 
        if ($arg == 'relate') {

                $result = $NZRelation->setRelationFrom($event, get_current_user_id());
        }
        if ($arg == 'unrelate') {
                $result = $NZRelation->removeRelationFrom($event, get_current_user_id());
        }
        echo $result;

        die();
}

add_action('wp_ajax_get_event_users', 'get_event_users');
add_action('wp_ajax_nopriv_get_event_users', 'get_event_users');

function get_event_users() {

        if (!is_user_logged_in()) {
                header('HTTP/1.1 403 Forbidden');
                $login_url = get_permalink(get_page_by_path('registrate'));
                ?>
                <div>
                        <h1><a href="<?php echo $login_url ?>">Registrate para aceder</a></h1>
                </div>
                <?php
                die();
        }

        $NZRelation = New NZRelation('events_to_users', 'event_id', 'user_id');

        $event_users = $NZRelation->getRelationFrom((int) $_GET['event']);
        $users = array(0);
        foreach ($event_users as $user) {
                $users[] = $user->user_id;
        }
        $args = array(
              'include' => $users
        );


        $user_query = new WP_User_Query($args);
// User Loop
        if (!empty($user_query->results)) {
                ?>
                <div>
                        <h1>Participantes</h1>
                        <hr class="pb5">
                        <ul>
                                <?php
                                foreach ($user_query->results as $user) {
                                        ?>
                                        <li class="col-1-4 fl bg-50 block-5">
                                                <!--<article class="">-->

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
                                                <!--</article>-->

                                        </li>
                                        <?php
                                }
                                ?>
                        </ul>
                </div>
                <?php
        } else {
                echo 'No users found.';
        }






        die();
}
