<?php

abstract class NzWpSocialloginsAbstract
{

    protected $options = [];

    /**
     *  Plugin constructor
     * 
     *  @param array $options Array of plugin options
     */
    function __construct($options)
    {
        $this->options = wp_parse_args($options, [
            'connection_handler' => 'curl', //file_get_contents
            'init_apis_action' => 'wp_head',
            'redirect' => true,
            'redirect_to' => get_home_url(),
            'link_account' => true,
            'enqueue_scripts' => true,
            'default_email_mask' => 'user_%d@wpplugins.nzlab.es',
            'facebook' => [
                'app_id' => NULL,
                'app_secret' => NULL,
                'scope' => 'public_profile,email',
                'page_id' => NULL
            ],
            'twitter' => [
                'api_key' => null,
                'api_secret' => null,
                'token' => null,
                'token_secret' => NULL
            ]
        ]);


        //enqueue scripts
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);

        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);

        //init sdks scripts
        if ($this->options['init_apis_action']) {
            add_action($this->options['init_apis_action'], [$this, 'init_apis_action']);
        }
        add_action('admin_head', [$this, 'init_apis_action']);

        //facebook ajax social login
        /* add_action('wp_ajax_nopriv_nzwpsocials', [$this, 'nzwpsocials_ajax_action']); */
        /* add_action('wp_ajax_nzwpsocials', [$this, 'nzwpsocials_ajax_action_loggedin']); */

        add_action('parse_request', [$this, 'handle_sociallogin_ajax']);

        add_action('parse_request', [$this, 'twitter_redirect_process']);
        add_action('parse_request', [$this, 'facebook_redirect_process']);
    }

    /**
     *  Logs user in
     * 
     *  @param Object $user Wp User object
     */
    protected function login_user($user)
    {
        $user_login = $user->get('user_login');

        wp_set_current_user($user->ID, $user_login);
        wp_set_auth_cookie($user->ID);
        do_action('wp_login', $user_login);
    }

    /**
     * Handle ajax call to login with oauth
     * 
     * @param array $headers WP header array
     */
    public function handle_sociallogin_ajax($headers)
    {
        if (!isset($_GET['nzwpsocials'])) {
            return;
        }

        $action = $_GET['nzwpsocials'];
        $method = 'link_' . $action; // link_facebook_login | link_twitter_login

        if (!method_exists($this, $method)) {
            return;
        }

        $this->$method();
    }
    /*
     * 
     */

    protected function get_user_id_by_meta($meta_key, $meta_value)
    {
        global $wpdb;
        $sql = "SELECT u.ID FROM " . $wpdb->usermeta . " AS um	INNER JOIN " . $wpdb->users . " AS u ON (um.user_id=u.ID)"
            . "	WHERE um.meta_key = '%s' AND um.meta_value=%s";

        return $wpdb->get_var($wpdb->prepare($sql, $meta_key, $meta_value));
    }

    /**
     *  Redirects parent or current window to location option
     * 
     *  @param object $user Wp User object
     */
    protected function redirect_window_script($user)
    {
        if (!$this->options['redirect']) {
            return;
        }

        if (is_callable($this->options['redirect_to'])) {
            $location = $this->options['redirect_to']->__invoke($user);
        } else {

            $location = $this->options['redirect_to'];
        }
        ?>
        <script>
            (function () {
                if (window.opener) {
                    window.opener.location.replace('<?php echo $location ?>');
                    window.close();
                } else {
                    window.location.replace('<?php echo $location ?>');
                }

            })();
        </script>
        <?php
    }

    /**
     *  Init clients scripts
     */
    public function init_apis_action()
    {
        if (!empty($this->options['facebook'])) {
            $this->init_script_facebook();
        }

        if (!empty($this->options['twitter'])) {
            $this->init_script_twitter();
        }
    }

    /**
     *  Match username with existing ones and return a valid one
     * 
     *  @param string $username Username to test
     */
    protected function username_exists($username)
    {
        $nameexists = true;
        $index = 0;
        $userName = $username;
        while ($nameexists == true) {
            if (username_exists($userName) != 0) {
                $index++;
                $userName = $username . $index;
            } else {
                $nameexists = false;
            }
        }
        return $userName;
    }

    /**
     *  Update user meta for client
     * 
     *  @param array $social_user Array of remote user
     *  @param string $context Social context (facebook | twitter)
     *  @param object $user Wordpress user object
     */
    protected function update_sociallogin_user_meta($social_user, $context, $user)
    {
        if ($this->options['link_account']) {
            update_user_meta($user->ID, 'nzwpsocials_' . $context . '_user_id', $social_user['id']);
            if (!empty($social_user['thumbnail'])) {
                update_user_meta($user->ID, 'nzwpsocials_' . $context . '_user_thumbnail', $social_user['thumbnail']);
            }
            wp_cache_delete($user->ID, 'users');
            wp_cache_delete($user->user_login, 'userlogins');
        }
    }

    public function enqueue_scripts()
    {

        if ($this->options['enqueue_scripts']) {

            //register
            wp_register_script('nzwpsocials', plugins_url('js/nzwpsocials.js', __FILE__), ['jquery'], '1.0.0', TRUE);
        }

        // Localize the script with new data
        $socials_info = [
            'ajax_url' => admin_url('admin-ajax.php'),
            'redirect_uri' => get_home_url(),
            'facebook' => [
                'app_id' => $this->options['facebook']['app_id']
            ]
        ];
        wp_localize_script('nzwpsocials', 'nzwpsocials_data', $socials_info);
        wp_enqueue_script('nzwpsocials');

        if (is_admin()) {
            $socials_info['facebook']['app_secret'] = $this->options['facebook']['app_secret'];
            $socials_info['facebook']['app_token'] = get_option('nzwpsocials_fb_app_token');

            wp_enqueue_script('jquery-ui-dialog');
            wp_enqueue_script('jquery-ui-tabs');

            wp_enqueue_style('jquery-ui-css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css');
        }

        //enqueue
    }
}
