<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://nzlabs.es
 * @since             1.0.0
 * @package           Nzwpsocials
 *
 * @wordpress-plugin
 * Plugin Name:       NzWpSocials
 * Plugin URI:        http://nzlabs.es/wp/plugin/nzwpsocials
 * Description:       Social functions
 * Version:           1.0.0
 * Author:            Nadir Zenith
 * Author URI:        http://nzlabs.es
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nzwpsocials
 * Domain Path:       /languages
 */
/* define('NZWPSOCIAL_FACEBOOK_APP_ID', 694295497297854); */
/* define('NZWPSOCIAL_FACEBOOK_APP_SECRET', '35c5790da99ffa04bf642ae610fd9214'); */
include 'abstractnzwpsociallogins.php';
include 'admin.php';

class NzWpSocialsInit extends NzWpSocialloginsAbstract
{

    /**
     * After user Authorization facebook redirects to here
     * 
     */
    public function facebook_redirect_process($headers)
    {
        if (isset($_GET['error_reason']) || isset($_GET['error_message'])) {
            //error=access_denied&error_code=200&error_description=Permissions+error&error_reason=user_denied#_=_
            //?error_code=1349126&error_message=App+Not+Setup%3A+This+app+is+still+in+development+mode%2C+and+you+don%27t+have+access+to+it.+Switch+to+a+registered+test+user+or+ask+an+app+admin+for+permissions.#_=_
            $error = isset($_GET['error_reason']) ? $_GET['error_reason'] : $_GET['error_message'];
            die($error);
            return;
        }

        if (!isset($_GET['code']) || empty($_GET['code'])) {
            //http://wpplugins.nzlab.es/?code=AQDKDxji2N8lKc3wm6x70fchjDbdBPzoGNthb_sloZi8OQO-7UjuaKitnYfS20KtSW2FKp4plmZxat7Df2QkWljY9ZsJ3Yi_P-UKzWZ3TXRMCoPJ1Ge7cvWN-Bc5J57n_Dev6swnLRzUjI2BKyEmEnsXR2LSjn-kK3PFMMuVFVPEsfnuU0Srvc9MIZqXyhEeuZ0n5PUQjd2bG2pdtwoJQHGw0-WGok7ltrQhjCuc4_ULWE5wxLIcvclqALjT2tIjetV1nhEmILUKhqusHCUNdaLMXW2L6gs5TrdZHYzZT64QRPVqfWvzjMzgfEoa6-mfLoOZv3oWKIT7it2MsiJHd9yI#_=_
            return;
        }
        $code = $_GET['code'];
        //validate code
        $params = [
            'client_id' => $this->options['facebook']['app_id'],
            'redirect_uri' => rtrim(site_url(), '/') . '/',
            'client_secret' => $this->options['facebook']['app_secret'],
            'code' => $code,
        ];
        $access = $this->facebook_api('/oauth/access_token', 'GET', $params)->getDecodedBody();

        if (empty($access['access_token'])) {
            die('Code not valid');
        }

        //get user data with access token
        $access_token = $access['access_token'];
        $params = [
            'client_secret' => $this->options['facebook']['app_secret'],
            'client_id' => $this->options['facebook']['app_id'],
            'redirect_uri' => urlencode(site_url()),
            'fields' => 'id,name,email,first_name,last_name',
            'access_token' => $access_token
        ];
        $fb_profile = $this->facebook_api('/me', 'GET', $params)->getDecodedBody();

        $social_user = $this->get_wp_user_from_facebook_profile($fb_profile);

        $user_id = $this->get_user_id_by_meta('nzwpsocials_facebook_user_id', $social_user['id']);

        if (!$user_id) {
            //first time login from oauth
            if (($user_id = email_exists($social_user['user_email'])) !== false) {
                //wp user already exist

                $current_user = get_userdata($user_id);
                $this->update_sociallogin_user_meta($social_user, 'facebook', $current_user);
            } else {
                //new wp user

                $user_id = wp_insert_user($social_user);
                $current_user = get_userdata($user_id);
                $this->update_sociallogin_user_meta($social_user, 'facebook', $current_user);

                do_action('user_register', $user_id);
            }
        }

        //login user
        $user = get_userdata($user_id);

        if (!$user) {
            return;
        }

        update_user_meta($user_id, 'nzwpsocials_facebook_token', $access_token);
        $this->login_user($user);

        $this->redirect_window_script($user);
    }

    public function twitter_redirect_process($headers)
    {
        if (!isset($_GET['oauth_token'], $_GET['oauth_verifier'])) {
            return;
        }

        $oauth_token = $_GET['oauth_token'];
        $oauth_verifier = $_GET['oauth_verifier'];

        $access = $this->twitter_token_verifier($oauth_token, $oauth_verifier);

        $access['include_email'] = true;
        $profile = $this->twitter_api('account/verify_credentials', $access);
        /* d($profile); */

        if (!isset($profile->id)) {
            return;
        }

        $social_user = $this->get_wp_user_from_twitter_profile($profile);
        /* dd($social_user); */
        $user_id = $this->get_user_id_by_meta('nzwpsocials_twitter_user_id', $social_user['id']);
        /* $user_login = sanitize_user($social_user['username'], true); */

        if (!$user_id) {
            //first time login from oauth

            /* $new_user = false; */
            if (($user_id = email_exists($social_user['email'])) !== false) {
                //wp user already exist
                $current_user = get_userdata($user_id);
                
                $this->update_sociallogin_user_meta($social_user, 'twitter', $current_user);
            } else {
                //new wp user
                /* $new_user = true; */

                $user_id = wp_insert_user($social_user);
                $current_user = get_userdata($user_id);
                $this->update_sociallogin_user_meta($social_user, 'twitter', $current_user);

                do_action('user_register', $user_id);
            }
        }
        //login user
        $user = get_userdata($user_id);

        if (!$user) {
            return;
        }

        update_user_meta($user_id, 'nzwpsocials_twitter_token', $access['oauth_token']);
        update_user_meta($user_id, 'nzwpsocials_twitter_token_secret', $access['oauth_token_secret']);

        $this->login_user($user);

        $this->redirect_window_script($user);
    }

    protected function get_wp_user_from_facebook_profile($profile)
    {
        $wpuser = [];

        $wpuser['id'] = (!empty($profile['id']) ? $profile['id'] : '');

        $wpuser['user_login'] = (!empty($profile['name']) ? sanitize_user($profile['name']) : 'fb' . $profile['id']);

        $wpuser['first_name'] = !empty($profile['first_name']) ? $profile['first_name'] : '';
        $wpuser['last_name'] = !empty($profile['last_name']) ? $profile['last_name'] : '';

        $wpuser['username'] = (!empty($profile['name']) ? sanitize_user($profile['name']) : 'fb' . $profile['id']);

        if(empty($profile['email'])){
            die('The email is obligatory');
        }
        /*$wpuser['user_email'] = (!empty($profile['email'])) ? $profile['email'] : sprintf('facebook_user_%d@mail.local', $profile['id']);*/
        $wpuser['user_email'] = $profile['email'];

        $wpuser['thumbnail'] = "https://graph.facebook.com/v2.3/" . $wpuser['id'] . "/picture";

        $wpuser['role'] = get_option('default_role');
        $wpuser['user_pass'] = wp_generate_password();
        return $wpuser;
    }

    protected function get_wp_user_from_twitter_profile($profile)
    {
        $wpuser = [];

        $wpuser['id'] = (!empty($profile->id) ? $profile->id : '');

        $wpuser['user_login'] = (!empty($profile->screen_name) ? sanitize_user($profile->screen_name) : 'tt' . $profile->id);

        $wpuser['first_name'] = (!empty($profile->name) ? $profile->name : 'tt' . $profile->id);
        $wpuser['last_name'] = '';

        $wpuser['username'] = (!empty($profile->screen_name) ? sanitize_user($profile->screen_name) : 'tt' . $profile->id);

        $wpuser['user_email'] = property_exists($profile, 'user_email') ? $profile->user_email : sprintf($this->options['default_email_mask'], $profile->id);
        /* $wpuser['user_email'] = sprintf($this->options['default_email_mask'], $profile->id); */

        $wpuser['thumbnail'] = (!empty($profile->profile_image_url) ? $profile->profile_image_url : '');

        $wpuser['role'] = get_option('default_role');
        $wpuser['user_pass'] = wp_generate_password();
        return $wpuser;
    }

    protected function get_facebook_api()
    {
        if (!isset($this->options['facebook']['app_id'], //
                $this->options['facebook']['app_secret'] //
            )) {
            return false;
        }

        include_once 'lib/facebook/facebook-sdk/autoload.php';
        $args = [
            'app_id' => $this->options['facebook']['app_id'],
            'app_secret' => $this->options['facebook']['app_secret'],
            'default_graph_version' => 'v2.5',
            //'default_access_token' => '{access-token}', // optional
        ];

        if (get_option('nzwpsocials_fb_app_token')) {
            $fb['default_access_token'] = get_option('nzwpsocials_fb_app_token');
        }
        try {
            $fb = new Facebook\Facebook($args);

            return $fb ? $fb : false;
        } catch (Exception $ex) {
            d($ex);
            return FALSE;
        }
    }

    protected function facebook_api($endpoint, $method = 'GET', array $params = [])
    {

        $fb = $this->get_facebook_api();

        if (!$fb) {
            return false;
        }

        try {
            return $fb->sendRequest($method, $endpoint, $params);

            // Get the Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    protected function get_twitter_api()
    {

        if (!isset($this->options['twitter']['api_key'], //
                $this->options['twitter']['api_secret'], //
                $this->options['twitter']['token'], //
                $this->options['twitter']['token_secret'])) {
            return false;
        }

        include_once 'lib/twitter/twitteroauth/autoload.php';


        $twitteroauth = new Abraham\TwitterOAuth\TwitterOAuth(
            $this->options['twitter']['api_key'], //
            $this->options['twitter']['api_secret'], //
            $this->options['twitter']['token'], //
            $this->options['twitter']['token_secret']
        );

        return $twitteroauth;
    }

    protected function twitter_api($path, $method = 'GET', array $params = [])
    {
        $twitter = $this->get_twitter_api();

        if (!$twitter) {
            return;
        }

        try {

            switch ($method) {
                case 'POST':

                    $response = $twitter->post($path, $params);
                    break;

                case 'OAUTH':

                    $response = $twitter->oauth($path, $params);
                    break;

                default:

                    $response = $twitter->get($path, $params);
            }

            return $response;
        } catch (Exception $exc) {
            d($exc->getMessage());
            /* $this->log($exc); */
            return false;
        }
    }

    protected function twitter_token_verifier($oauth_token, $oauth_verifier)
    {

        $params = [
            'oauth_token' => $oauth_token,
            'oauth_verifier' => $oauth_verifier
        ];

        $access = $this->twitter_api('oauth/access_token', 'OAUTH', $params);

        if (!isset($access['oauth_token'], $access['oauth_token_secret'])) {
            die('Oauth token and secred not defined');
        }

        return $access;
        /*
          'oauth_token' => string (50) "1863767197-twKM9K2clVI7IHFw7ImhFHdjm39eobVn09CY3N3"
          'oauth_token_secret' => string (45) "HgDcW5wYXeEAJmqqdVq5OyaLa3Ww5ZQno2eFWxDF2KtRe"
          'user_id' => string (10) "1863767197"
          'screen_name' => string (12) "NadirZenith3"
          'x_auth_expires' => string (1) "0"
         */
    }

    protected function twitter_authenticate_token()
    {
        $params = [
            /* 'oauth_callback' => urlencode(site_url()) */
        ];

        $access = $this->twitter_api('oauth/request_token', 'OAUTH', $params);

        if (!isset($access['oauth_token'])) {
            die('Error requesting oauth token');
        }

        return $access;
    }

    protected function link_twitter_login()
    {

        $access = $this->twitter_authenticate_token();

        $oauth_token = $access['oauth_token'];

        $tt_oauth_url = 'https://api.twitter.com/oauth/authenticate?';


        $query_arg = http_build_query(['oauth_token' => $oauth_token]);
        $location = $tt_oauth_url . $query_arg;
        wp_redirect($location, 302);

        exit;
    }

    /**
     * User is redirect here after click button
     */
    protected function link_facebook_login()
    {

        $fb_oauth_url = 'https://www.facebook.com/dialog/oauth?';

        $query_arg = http_build_query([
            'client_id' => $this->options['facebook']['app_id'],
            'redirect_uri' => home_url(),
            'scope' => $this->options['facebook']['scope']
        ]);

        $location = $fb_oauth_url . $query_arg;

        wp_redirect($location, 302);

        exit;
    }

    protected function init()
    {

        if (get_option('nzwpsocials_fb_app_token') !== false) {
            return;
        }

        $url = 'https://graph.facebook.com/v2.3/oauth/access_token?' .
            'client_id=' . $this->options['facebook']['app_id'] . '&' .
            'client_secret=' . $this->options['facebook']['app_secret'] . '&' .
            'grant_type=client_credentials'
        ;

        $oauth_data = $this->get_api_contents($url, true);

        if (isset($oauth_data['error']) && !isset($oauth_data['access_token'])) {
            return;
        }

        update_option('nzwpsocials_fb_app_token', $oauth_data['access_token'], 'yes');
    }

    protected function get_token_info($token)
    {
        $app_token = get_option('nzwpsocials_fb_app_token');

        $params = [
            'input_token' => $token,
            'access_token' => $app_token,
        ];
        $r = $this->facebook_api('token_info', 'GET', $params);

        return $r;
    }

    protected function post_to_feed($access_token, $id, $new = false)
    {
        $attachment = array(
            'access_token' => $access_token,
            'message' => 'just testing',
            'name' => 'primeiro!',
            'link' => 'http://www.nzlabs.es',
            'description' => 'my site description',
            'picture' => 'http://www.nhn.ou.edu/~jeffery/astro/glossary/zenith.png'
        );

        if (function_exists('curl_init')) {
            $url = "https://graph.facebook.com/v2.3/" . $id . "/feed";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $attachment);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
        }
    }


    protected function init_script_facebook()
    {
        ?>

        <script>
            window.fbAsyncInit = function () {
                FB.init({
                    appId: '<?php echo $this->options['facebook']['app_id'] ?>',
                    xfbml: true,
                    version: 'v2.5'
                });
                /*nzwpsocials.fb_sdk_loaded();*/
            };

            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

        <?php
    }

    protected function init_script_twitter()
    {
        ?>
        <script>
            window.twttr = (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0],
                        t = window.twttr || {};
                if (d.getElementById(id))
                    return t;
                js = d.createElement(s);
                js.id = id;
                js.src = "https://platform.twitter.com/widgets.js";
                fjs.parentNode.insertBefore(js, fjs);

                t._e = [];
                t.ready = function (f) {
                    t._e.push(f);
                };

                return t;
            }(document, "script", "twitter-wjs"));
        </script>
        <?php
    }
}

