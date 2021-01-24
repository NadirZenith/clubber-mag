<?php

/* * *************************************************************************** */
add_action('show_user_profile', 'add_extra_social_links');
add_action('edit_user_profile', 'add_extra_social_links');

function add_extra_social_links($user)
{
    ?>
    <h3>NzWpSocials</h3>
    <div id="nzwpsocials-tabs">
        <ul>
            <li><a href="#tab-facebook">facebook</a></li>
            <li><a href="#tab-twitter">twitter</a></li>
        </ul>
        <div id="tab-facebook">
            <table class="widefat">
                <tr>
                    <td class="row-title">
                        <img src="<?php echo get_user_meta($user->ID, 'nzwpsocials_facebook_user_thumbnail', true); ?>" >
                    </td>
                    <td>
                        <label for="facebook_user_id">Id</label>
                        <input readonly="true" type="text" name="facebook_user_id" value="<?php echo esc_attr(get_the_author_meta('nzwpsocials_facebook_user_id', $user->ID)); ?>" class="all-options" />

                        <div>
                            <input type="button" value="Account Info" onclick="myFbAccountInfo('<?php echo esc_attr(get_the_author_meta('nzwpsocials_facebook_user_id', $user->ID)); ?>')"/>
                            <input type="button" value="Permissions" onclick="myFbPermissions('<?php echo esc_attr(get_the_author_meta('nzwpsocials_facebook_user_id', $user->ID)); ?>')"/>
                            <input type="button" value="Manage Pages permissions" onclick="myFbAskPermissions()"/>
                            <input type="button" value="Manage Lab Page Permission" onclick="myFbManageSitePage('<?php echo esc_attr(get_the_author_meta('nzwpsocials_facebook_user_id', $user->ID)); ?>')"/>
                            <input type="button" value="Get Page Posts" onclick="myFbPagePosts('533384016799314')"/>
                            <input type="button" value="Create Page Post" onclick="myFbPageCreatePost('533384016799314')"/>
                        </div>
                    </td>
                    <td>
                        <label for="facebook_token">Token</label>
                        <input readonly="true" type="text" name="facebook_token" id="facebook_token" value="<?php echo esc_attr(get_the_author_meta('nzwpsocials_facebook_token', $user->ID)); ?>" class="regular-text" />

                        <div>
                            <input type="button" value="Token Info" onclick="myFbTokenInfo('<?php echo esc_attr(get_the_author_meta('nzwpsocials_facebook_token', $user->ID)); ?>')"/>
                            <input type="button" value="Unlink" onclick="myFbUnlink('<?php echo esc_attr(get_the_author_meta('nzwpsocials_facebook_user_id', $user->ID)); ?>')"/>
                            <input type="button" value="Renew(!)" onclick="myFbRenew('<?php echo esc_attr(get_the_author_meta('nzwpsocials_facebook_token', $user->ID)); ?>')"/>
                        </div>

                    </td>
                </tr>
                <tr>

                </tr>
            </table>
        </div>
        <div id="tab-twitter">
            twitter tab content
        </div>

    </div>

    <script>
        jQuery(function () {
            jQuery('#nzwpsocials-tabs').tabs();
        });
        

        function myFbTokenInfo(token) {
            FB.api('/debug_token/', 'get',
                    {
                        access_token: nzwpsocials_data.facebook.app_token,
                        input_token: token,
                    }, nzjqdialogdump);

        }

        function myFbAccountInfo(id) {
            
            FB.api('/' + id, 'get', {
                fields: 'email,name',

            }, nzjqdialogdump);
        }

        function myFbPermissions(id) {
            FB.api('/' + id + '/permissions', 'get', {
                
            }, nzjqdialogdump);
        }

        function myFbAskPermissions(id) {

            FB.login(function (r) {
                if (r.authResponse) {
                    $('#facebook_token').value(r.authResponse.accessToken);
                }
                // handle the response
                nzjqdialogdump(r);
            }, {
                scope: 'manage_pages,publish_pages', //,publish_actions',
                return_scopes: true
            });

        }

        function myFbManageSitePage(id) {
            FB.api('/' + id + '/accounts', 'get', {}, nzjqdialogdump);


        }
        function myFbPagePosts(page_id) {
            FB.api('/' + page_id + '/feed', 'get', {}, nzjqdialogdump);


        }
        function myFbPageCreatePost(page_id) {
            FB.api('/' + page_id + '/feed', 'post', {
                message: 'This is a test message',
                access_token: 'CAAJ3dUR8T74BABV8FYCQxaqiLqgo9BU09oV8ohEOrWVJvRdvVyqPl6HzIQLor8gVLoWvn3a7LyuAye7lyJx6BGg6MpxjsMfbOaaCZBXIaG6I6biznF2xqsfPF9YElbdQngZCZAlTTZAHdOYjZAt0fsyZBkZBrv7fWcVZCAYh3YdZAFITFqXKBHUd16cedkdiZAd0ySKMy9UVI0Tf7pxdlXgAdv'
            }, nzjqdialogdump);


        }


        function myFbUnlink(id) {
            FB.api('/' + id + '/permissions', 'delete', {}, nzjqdialogdump);
        }

        function myFbRenew(currentToken) {
            /* 
             /oauth/access_token?  
             grant_type=fb_exchange_token&           
             client_id={app-id}&
             client_secret={app-secret}&
             fb_exchange_token={short-lived-token}        
                 
                 
             https://graph.facebook.com/oauth/client_code
             ?access_token=...&
             client_secret=...&
             redirect_uri=...&
             client_id=...
             */
            nzjqdialogdump('working in progress ...');
            return;
            /*console.log(nzwpsocials_data);*/
            FB.api('/oauth/access_token', 'get', {
                grant_type: 'fb_exchange_token',
                client_id: nzwpsocials_data.facebook.app_id,
                client_secret: nzwpsocials_data.facebook.app_secret,
                fb_exchange_token: currentToken
                        /*redirect_uri : '<?php echo urlencode(site_url()) ?>'*/
            }, nzjqdialogdump);
        }

        /*        ---------------------------         */
        function nzdump(o) {
            return '<pre>' + JSON.stringify(o, null, '\t') + '</pre>';
        }

        function nzjqdialogdump(o, op) {
            var $d = jQuery('#dialog').length ? jQuery('#dialog') : jQuery('<div id="dialog"></div>').appendTo('body');
            var op = op || {modal: true, width: 600, title: 'dump'};
            $d.html(nzdump(o)).dialog(op).dialog('open');
        }

    </script>

    <?php
}
/* add_action('personal_options_update', 'save_extra_social_links'); */
/* add_action('edit_user_profile_update', 'save_extra_social_links'); */

function save_extra_social_links($user_id)
{
    update_user_meta($user_id, 'nzwpsocials_facebook_token', sanitize_text_field($_POST['facebook_token']));
}
