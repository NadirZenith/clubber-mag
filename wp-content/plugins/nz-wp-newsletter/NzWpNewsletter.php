<?php
/**
 * Description of nzwpnewsletter
 *
 * @author tino
 */
class NzWpNewsletter
{
    const VERSION = 0.6;

    private $options;
    private $mc;

    function __construct()
    {
        $this->options = wp_parse_args([], [
            'template_path' => __DIR__ . '/tpl/nzwpnewsletter-form.php',
            'success_msg' => __('Thank you for subitting your email', 'nzwpnewsletter'),
            'error_msg' => __('Your email is already in our newsletter', 'nzwpnewsletter'),
            'invalid_email_msg' => __('Email is not valid', 'nzwpnewsletter'),
        ]);

        add_shortcode('nzwpnewsletter', array($this, 'shortcode'));
        add_action('wp_ajax_nopriv_nzwpnewsletter', array($this, 'ajax_handler'));
        add_action('wp_ajax_nzwpnewsletter', array($this, 'ajax_handler'));

        //enqueue scripts
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);

        /* add_action('admin_menu', array($this, 'add_menu')); */
        add_action('admin_init', [$this, 'register_settings']);




        if (is_admin()) {

            $options = new OptionsPage('Nz Wp Newsletter', 'manage_options', 'nzwpnewsletter');

            $this->mc = $this->getMailchimp();
            $options->init($this->mc);
        }
    }

    private function getMailchimp()
    {
        $api_key = get_option('nzwpnewsletter_mailchimp_api_key');

        return ($api_key) ?
            new MailChimp($api_key) : false;
    }

    public function register_settings()
    {
        register_setting('nzwpnewsletter-options', 'nzwpnewsletter_mailchimp_api_key');
        register_setting('nzwpnewsletter-options', 'nzwpnewsletter_mailchimp_default_list');
    }

    public function enqueue_scripts()
    {

        if (!is_admin()) {
            wp_register_script('nzwpnewsletter', plugin_dir_url(__FILE__) . 'public/js/main.js', array('jquery'), self::VERSION, true);
            wp_enqueue_script('nzwpnewsletter');
            return;
        }

        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_style('jquery-ui-css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css');
    }

    function setFormTemplate($path)
    {
        $this->options['template_path'] = $path;
    }

    function subscribe_to_mailchimp($email)
    {
        $user_id = (is_user_logged_in()) ? get_current_user_id() : 0;
        $mc = $this->getMailchimp();

        //mail chimp list
        if ($mc) {
            $list_id = get_option('nzwpnewsletter_mailchimp_default_list');
            if ($list_id) {
                $email_info = [
                    'email' => $email,
                    'euid' => $user_id,
                    'leid' => $list_id . '_' . $user_id
                    ]
                ;
                $params = [
                    'id' => $list_id, //list id
                    'email' => $email_info,
                    'double_optin' => false, //send confirmation email // optional default (true)
                    'update_existing' => false, //optional default false -> return error 
                    'replace_interests' => false, //optional default true 
                ];

                try {
                    $mc_list = $mc->call('lists/subscribe', $params);
                    return isset($mc_list['email']) ? true : false;
                } catch (Exception $ex) {

                    return false;
                }
            }
        }
        return false;
    }

    function unsubscribe_to_mailchimp($email)
    {
        $mc = $this->getMailchimp();

        //mail chimp list
        if (!$mc) {
            return false;
        }

        $list_id = get_option('nzwpnewsletter_mailchimp_default_list');
        if (!$list_id) {
            return false;
        }

        $params = [
            'id' => $list_id,
            'email' =>
            [
                'email' => $email,
            /* 'euid' => $newsletter_user->id, */
            /* 'leid' => $list_id . '_' . $newsletter_user->id */
            ],
            'delete_member' => false, //completely delete the member from your list // optional default (false)
            'send_goodbye' => true, //flag to send the goodbye email //optional default true
            'send_notify' => true, //send the unsubscribe notification email // default true
        ];

        try {
            $mc_list = $mc->call('lists/unsubscribe', $params);
            return isset($mc_list['complete']) ? true : false;
        } catch (Exception $ex) {

            return false;
        }
    }

    function subscribe_to_site($email)
    {
        $user_id = (is_user_logged_in()) ? get_current_user_id() : 0;

        global $wpdb;
        $wpdb->suppress_errors = TRUE;
        $table_name = $wpdb->prefix . 'nzwpnewletter';

        $site_list = $wpdb->insert($table_name, array(
            'time' => current_time('mysql'),
            'user_id' => $user_id,
            'email' => $email,
            )
        );

        return $site_list ? true : false;
    }

    function unsubscribe_to_site($email)
    {

        global $wpdb;

        $wpdb->suppress_errors = TRUE;
        $table_name = $wpdb->prefix . 'nzwpnewletter';

        $r = $wpdb->update($table_name, [
            'subscribed' => false,
            ], [
            'email' => $email
            ]
        );

        return $r ? true : false;
    }

    function subscribe_to_all($email)
    {

        $mc = $this->subscribe_to_mailchimp($email);

        $sl = $this->subscribe_to_site($email);

        if ($sl || $mc) {
            global $wpdb;
            $wpdb->suppress_errors = TRUE;
            $table_name = $wpdb->prefix . 'nzwpnewletter';
            $r = $wpdb->update($table_name, [
                'subscribed' => true,
                ], [
                'email' => $email
                ]
            );
            return true;
        }

        return false;
    }

    function unsubscribe_to_all($email)
    {
        
        $mc = $this->unsubscribe_to_mailchimp($email);
        
        $sl = $this->unsubscribe_to_site($email);
        
        return ($mc || $sl) ? true : false;
        
    }

    function ajax_handler()
    {

        check_ajax_referer('nzwpnewsletter', 'security');

        if (isset($_REQUEST['subscribe_email'])) {

            $email = $_REQUEST['subscribe_email'];
            $r = $this->subscribe_to_all($email);

            $msg = $r ?
                __('Thank you for subscribing to our newsletter', 'nzwpnewsletter') :
                __('Your email is already in our newsletter', 'nzwpnewsletter')
            ;
        } elseif (isset($_REQUEST['unsubscribe_email'])) {

            $email = $_REQUEST['unsubscribe_email'];
            $r = $this->unsubscribe_to_all($email);
            $msg = $r ?
                __('You have been successfully unsubscribed', 'nzwpnewsletter') :
                __('Your email is not in our newsletter', 'nzwpnewsletter')
            ;
        }

        echo wp_json_encode(['msg' => $msg]);
        wp_die();

    }

    public function init_script()
    {
        ?>
        <script>
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            jQuery(document).ready(function ($) {
                jQuery('.nzwpnewsletter').NzWpNewsletter({
                    invalid_email_msg: '<?php echo __('Email is not valid', 'nzwpnewsletter') ?>',
                    security: '<?php echo wp_create_nonce('nzwpnewsletter') ?>'
                });
            });
        </script>
        <?php
    }

    function shortcode()
    {

        include $this->options['template_path'];
        
        add_action('wp_footer', array($this, 'init_script'));
    }
}

$nzwpnewsletter = new nzwpnewsletter();
