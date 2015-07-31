<?php
/**
 * Description of OptionsPage
 *
 * @author tino
 */
class OptionsPage extends NzWpOptionsPageAbstract implements NzWpOptionsPageInterface
{
    private $mc;
    private $valid_api;

    public function mainPage()
    {
        ?>
        <h3>NzWpNewsletter Options Page</h3>
        <?php
    }

    public function mainMenu()
    {
        $this->menuItem('Settings', 'settings');
        $this->menuItem('Site List', 'sitelist');
        $this->menuItem('Mailchimp', 'mailchimp');
    }

    public function init($mc)
    {
        $this->mc = $mc;

        if ($this->mc) {

            try {
                $r = $this->mc->call('/helper/ping', []);
                $this->valid_api = isset($r['msg']);
                return true;
            } catch (Exception $ex) {
                $this->valid_api = false;
                return false;
            }
        }

        $this->valid_api = false;
        return false;
    }

    protected function settings()
    {
        ?>
        <h3>Settings</h3>
        <form method="post" action="options.php"> 
            <?php
            settings_fields('nzwpnewsletter-options');
            do_settings_sections('nzwpnewsletter-options');
            ?>
            <label for="nzwpnewsletter_mailchimp_api_key">Mailchimp api key</label>
            <input class="regular-text" type="text" name="nzwpnewsletter_mailchimp_api_key" value="<?php echo esc_attr(get_option('nzwpnewsletter_mailchimp_api_key')); ?>"/>
            <div style="background-color: <?php echo ($this->valid_api) ? 'green' : 'red'; ?>;height: 20px; width: 70px; text-align: center; display:inline-block;">
                verified
            </div>
            <br>
            <label for="nzwpnewsletter_mailchimp_default_list">Mailchimp default list</label>
            <input class="regular-text" type="text" name="nzwpnewsletter_mailchimp_default_list" value="<?php echo esc_attr(get_option('nzwpnewsletter_mailchimp_default_list')); ?>"/>
            <?php
            submit_button();
            ?>
        </form>
        <?php
    }

    protected function mailchimp()
    {
        if (!$this->valid_api) {
            _e('Api not valid', 'nzwpnewsletter');
            return;
        }

        $list_id = get_option('nzwpnewsletter_mailchimp_default_list');
        if (!$list_id) {
            $this->addNotice('Set default list');
            return;
        }
        ?>

        <h3>Mailchimp defaul list</h3>
        <p>
            list id: <strong>{ <?php echo $list_id ?> }</strong>
        </p>

        <?php
        $members = $this->api('lists/members', ['id' => $list_id]);
        if (empty($members['data'])) {
            echo 'no members.. subscribe';
            return;
        }

        /* $list_activity = $this->pageUrl('list_activity', ['list_id' => '{id}']); */
        $arg = [
            'list_id' => $list_id,
            'email' => '{email}'
        ];
        $member_info = $this->pageUrl('member_info', $arg);
        $member_unsubscribe = $this->pageUrl('member_unsubscribe', $arg);

        $customs = [
            'info' =>
            "<a href='{$member_info}'>info</a> <br>" .
            "<a href='{$member_unsubscribe}'>unsubscribe</a>"
        ];

        $this->buildTable($members['data'], 'List Members', $customs);
    }

    protected function mailchimpSubmenu()
    {
        if ($this->valid_api) {

            $this->menuItem('Lists', 'lists');
            $this->menuItem('Templates', 'templates');
            $this->menuItem('Campaigns', 'campaigns');
        }
    }

    private function api($path, $args = [])
    {
        if (!$this->valid_api) {
            return false;
        }

        try {
            $r = $this->mc->call($path, $args);
            return $r;
        } catch (Exception $ex) {

            echo '<pre>';
            echo print_r($ex);
            echo '</pre>';

            return [];
        }
    }

    protected function mailchimp_lists()
    {

        $lists = $this->api('lists/list');
        if (empty($lists['data'])) {
            echo 'no lists.. create';
            return;
        }

        $data = $lists['data'];

        $list_activity = $this->pageUrl('list_activity', ['list_id' => '{id}']);
        $list_members = $this->pageUrl('list_members', ['list_id' => '{id}']);

        $customs = [
            'links' =>
            "<a href='{$list_activity}'>activity</a><br>" .
            "<a href='{$list_members}'>members</a>"
        ];

        $this->buildTable($data, 'Mail chimp lists', $customs);
    }

    protected function mailchimp_list_members()
    {

        $members = $this->api('lists/members', ['id' => $_GET['list_id']]);
        if (empty($members['data'])) {
            echo 'no members.. subscribe';
            return;
        }

        /* $list_activity = $this->pageUrl('list_activity', ['list_id' => '{id}']); */
        $arg = [
            'list_id' => $_GET['list_id'],
            'email' => '{email}'
            /* 'email' => 'albertino05@gmail.com' */
        ];
        $member_info = $this->pageUrl('member_info', $arg);
        $member_unsubscribe = $this->pageUrl('member_unsubscribe', $arg);

        $customs = [
            'info' => "<a href='{$member_info}'>info</a> <br>" .
            "<a href='{$member_unsubscribe}'>unsubscribe</a>"
        ];


        $this->buildTable($members['data'], 'List Members', $customs);
    }

    protected function mailchimp_member_unsubscribe()
    {


        $params = [
            'id' => $_GET['list_id'], //list id
            'email' =>
            [
                'email' => $_GET['email'],
            /* 'euid' => $newsletter_user->id, */
            /* 'leid' => $list_id . '_' . $newsletter_user->id */
            ],
            'delete_member' => false, //completely delete the member from your list // optional default (false)
            'send_goodbye' => false, //flag to send the goodbye email //optional default true
            'send_notify' => false, //send the unsubscribe notification email // default true
        ];

        $return = $this->api('lists/unsubscribe', $params);

        if (isset($return['complete'])) {
            global $wpdb;
            $wpdb->suppress_errors = TRUE;
            $table_name = $wpdb->prefix . 'nzwpnewletter';

            $r = $wpdb->update($table_name, [
                'subscribed' => false,
                ], [
                'email' => $_GET['email']
                ]
            );
            if ($r) {
                echo '<p>rows updated as unsubscribed: ' . $r . '</p>';
            }
        }

        $this->buildTable($return, 'Response');
    }

    protected function mailchimp_member_info()
    {
        /* die(__FUNCTION__); */
        $args = [
            'id' => $_GET['list_id'],
            'emails' => [
                [ 'email' => $_GET['email']]
            ]
        ];

        $member_info = $this->api('lists/member-info', $args);

        /* return; */
        if (!empty($member_info['errors'])) {
            $this->buildTable($member_info['errors'], 'Errors');
        }
        if (!empty($member_info['data'])) {
            $this->buildTable($member_info['data'], 'Member info');
        }
    }

    protected function mailchimp_list_activity()
    {
        $activities = $this->api('lists/activity', ['id' => $_GET['list_id']]);

        if ($activities) {

            $this->buildTable($activities, 'List activity');
        }
        //sub menu
    }

    protected function mailchimp_templates()
    {
        $params = [
            'types' => [
                'user' => true,
                'gallery' => true
            ]
        ];
        $tpls = $this->api('templates/list', $params);


        if (isset($tpls['user']) && isset($tpls['gallery'])) {

            $arg = [
                'id' => '{id}'
            ];

            $info = '<a href="%s">' . __('info', 'nzwpnewsletter') . '</a><br>';
            $customs = [
                'actions' =>
                sprintf($info, $this->pageUrl('template_info', $arg)),
                'preview' =>
                '<img style="width:100px; height:auto" class="img-preview" data-src="{preview_image}"/>'
            ];

            $this->buildTable($tpls['user'], 'User Templates', $customs);
            $this->buildTable($tpls['gallery'], 'Gallery Templates', $customs);
            ?>
            <script>
                jQuery(document).ready(function () {
                    var imgs = jQuery('.img-preview');
                    jQuery.each(imgs, function () {
                        var img = jQuery(this);
                        var src = this.dataset.src;
                        this.src = decodeURIComponent(src);
                    });
                });

            </script>
            <?php
        }
    }

    protected function mailchimp_template_info()
    {
        $template_id = $_GET['id'];

        $info = $this->api('templates/info', ['template_id' => $template_id]);
        d($info);
        if (!empty($info['default_content'])) {

            $this->buildTable($info['default_content'], 'Template info');
        }
        if (!empty($info['preview'])) {
            ?>
            <iframe style="margin-left:auto;margin-right: auto;width: 80%;"  height="700px" id="template-preview"></iframe>
            <script>
                var html = <?php echo json_encode($info['preview']) ?>;
                var dstFrame = document.getElementById('template-preview');
                var dstDoc = dstFrame.contentDocument || dstFrame.contentWindow.document;
                dstDoc.write(html);
                dstDoc.close();
            </script>
            <?php
        }
    }

    protected function mailchimp_campaigns()
    {
        $campaigns = $this->api('campaigns/list');

        if (empty($campaigns['data'])) {
            echo 'error getting campaigns';
            return;
        }

        $items = $campaigns['data'];
        $this->buildTable($items, 'Campaings');
    }

    protected function sitelistSubmenu()
    {

        $this->menuItem('Merge wp users', 'merge_wp_users');
        if ($this->valid_api) {

            $this->menuItem('Merge From Mailchimp', 'mc_merge_local');
            $this->menuItem('Send to mail chimp', 'mc_batch_subscribe');
        }
    }

    private function _get_newsletter_users()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'nzwpnewletter';
        $newsletter_users = $wpdb->get_results("SELECT * FROM $table_name");

        $link = '<a href="%s">' . __('edit', 'nzwpnewsletter') . '</a>';
        return $newsletter_users;
    }

    private function _get_site_users()
    {
        $site_users = get_users();

        $users = [];
        foreach ($site_users as $user) {
            $users[] = $user->data;
        }
        return $users;
    }

    protected function sitelist_remove_user()
    {
        global $wpdb;
        $wpdb->suppress_errors = TRUE;
        $table_name = $wpdb->prefix . 'nzwpnewletter';

        // Default usage.
        $r = $wpdb->delete($table_name, array('id' => $_GET['id']));

        $status = ($r) ? 'done' : 'error';
        ?>
        <div class="updated">
            <p><?php _e($status, 'my-text-domain'); ?></p>
        </div>
        <?php
    }

    protected function sitelist_clearSubmenu()
    {
        $this->menuItem('Confirm', 'confirm');
    }

    protected function sitelist_clear_confirm()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'nzwpnewletter';

        $delete = $wpdb->query("TRUNCATE TABLE `{$table_name}`");
        $status = ($delete) ? 'deleted' : 'error ocurred';
        ?>
        <div class="updated">
            <p><?php echo $status ?></p>
        </div>
        <?php
    }

    protected function sitelist_clear()
    {
        echo '<p>please confirm your action</p>';
    }

    protected function sitelist()
    {
        $newsletter_users = $this->_get_newsletter_users();

        $arg = [
            'id' => '{id}'
        ];

        $remove = '<a href="%s">' . __('Remove', 'nzwpnewsletter') . '</a><br>';
        $subscribe = '<a href="%s">' . __('Subscribe', 'nzwpnewsletter') . '</a><br>';
        $unsubscribe = '<a href="%s">' . __('Unsubscribe', 'nzwpnewsletter') . '</a>';
        $customs = [
            'actions' =>
            sprintf($remove, $this->pageUrl('remove_user', $arg)) .
            sprintf($subscribe, $this->pageUrl('mc_subscribe_user', $arg)) .
            sprintf($unsubscribe, $this->pageUrl('mc_unsubscribe_user', $arg))
        ];
        $this->buildTable($newsletter_users, 'Newsletter List', $customs);

        $this->menuItem('Clear all', 'clear');
        //site users
        $site_users = $this->_get_site_users();

        $this->buildTable($site_users, 'Site List');
    }

    protected function sitelist_mc_subscribe_user()
    {
        $id = $_GET['id'];
        global $wpdb;

        $table_name = $wpdb->prefix . 'nzwpnewletter';
        $newsletter_user = $wpdb->get_row("SELECT * FROM $table_name WHERE id = {$id}");

        if ($newsletter_user) {
            $list_id = get_option('nzwpnewsletter_mailchimp_default_list');

            $email = [
                'email' => $newsletter_user->email,
                'euid' => $newsletter_user->id,
                'leid' => $list_id . '_' . $newsletter_user->id
                ]
            ;

            $params = [
                'id' => $list_id, //list id
                'email' => $email, //list id
                'double_optin' => false, //send confirmation email // optional default (true)
                'update_existing' => false, //optional default false -> return error 
                'replace_interests' => false, //optional default true 
            ];
            /* d($params); */
            $return = $this->api('lists/subscribe', $params);
        }

        /* d($return); */

        if (isset($return['email'])) {

            global $wpdb;
            $wpdb->suppress_errors = TRUE;

            $table_name = $wpdb->prefix . 'nzwpnewletter';

            $r = $wpdb->update($table_name, [
                'subscribed' => true,
                ], [
                'email' => stripslashes($return['email'])
                ]
            );
            if ($r) {
                echo '<p>rows updated as subscribed: ' . $r . '</p>';
            }
        }

        $this->buildTable($return, 'Response');
    }

    protected function sitelist_mc_unsubscribe_user()
    {
        $id = $_GET['id'];
        global $wpdb;

        $table_name = $wpdb->prefix . 'nzwpnewletter';
        $newsletter_user = $wpdb->get_row("SELECT * FROM $table_name WHERE id = {$id}");

        if ($newsletter_user) {
            $list_id = get_option('nzwpnewsletter_mailchimp_default_list');

            $email = [
                'email' => $newsletter_user->email,
                'euid' => $newsletter_user->id,
                'leid' => $list_id . '_' . $newsletter_user->id
                ]
            ;

            $params = [
                'id' => $list_id, //list id
                'email' => $email, //list id
                'delete_member' => false, //completely delete the member from your list // optional default (false)
                'send_goodbye' => false, //flag to send the goodbye email //optional default true
                'send_notify' => false, //send the unsubscribe notification email // default true
            ];
            /* d($params); */
        }
        $return = $this->api('lists/unsubscribe', $params);
        /* d($return); */

        if (isset($return['complete'])) {
            global $wpdb;
            $wpdb->suppress_errors = TRUE;

            $table_name = $wpdb->prefix . 'nzwpnewletter';

            $r = $wpdb->update($table_name, [
                'subscribed' => false,
                ], [
                'id' => $_GET['id']
                ]
            );
            if ($r) {
                echo '<p>rows updated as unsubscribed: ' . $r . '</p>';
            }
        }

        $this->buildTable($return, 'Response');
    }

    protected function sitelist_merge_wp_users()
    {

        $site_users = $this->_get_site_users();
        global $wpdb;
        $wpdb->suppress_errors = TRUE;
        $table_name = $wpdb->prefix . 'nzwpnewletter';

        foreach ($site_users as $user) {
            $success = $wpdb->insert($table_name, array(
                'time' => current_time('mysql'),
                'user_id' => $user->ID,
                'email' => $user->user_email,
                'subscribed' => false
                )
            );
            /*
             */
        }
        $this->buildTable(array($wpdb), 'response');
    }

    protected function sitelist_mc_merge_local()
    {

        $list_id = get_option('nzwpnewsletter_mailchimp_default_list');
        if (!$list_id) {
            $this->addNotice('Set default list');
            return;
        }

        $this->menuItem('Confirm', 'mc_merge_local_confirm');

        $list_id = get_option('nzwpnewsletter_mailchimp_default_list');

        $members = $this->api('lists/members', ['id' => $list_id]);
        if (empty($members['data'])) {
            echo 'no members.. subscribe';
            return;
        }

        $this->buildTable($members['data'], 'List Members');
    }

    protected function sitelist_mc_merge_local_confirm()
    {


        $members = $this->api('lists/members', ['id' => $list_id]);
        if (empty($members['data'])) {
            echo '<p>no members.. subscribe</p>';
            return;
        }
        $members = $members['data'];

        global $wpdb;
        $wpdb->suppress_errors = TRUE;

        $table_name = $wpdb->prefix . 'nzwpnewletter';

        $info = [];
        foreach ($members as $member) {
            $success = $wpdb->insert($table_name, array(
                'time' => current_time('mysql'),
                'user_id' => null,
                'email' => $member['email'],
                'subscribed' => ($member['status'] == "subscribed") ? true : false
                )
            );

            if ($success) {
                $info['adds'][] = [
                    'email' => $member['email'],
                ];
            } else {
                $info['errors'][] = [
                    'email' => $member['email'],
                    'msg' => $wpdb->last_error
                ];
            }
        }
        $this->buildTable($info, 'Result');
    }

    protected function sitelist_mc_batch_subscribe()
    {

        $list_id = get_option('nzwpnewsletter_mailchimp_default_list');
        if (!$list_id) {
            $this->addNotice('Set default list');
            return;
        }

        $this->menuItem('Confirm Send', 'mc_batch_subscribe_confirm');

        $users = $this->_get_newsletter_users();
        $count = 0;
        $batch = [];
        foreach ($users as $user) {

            $batch[$count]['email'] = [
                'email' => $user->email,
                'euid' => $user->id,
                'leid' => $list_id . '_' . $user->id
            ];
            $batch[$count]['email_type'] = 'html';
            $count++;
        }

        $this->buildTable($batch, 'batch send');
    }

    protected function sitelist_mc_batch_subscribe_confirm()
    {

        $list_id = get_option('nzwpnewsletter_mailchimp_default_list');
        $count = 0;
        $batch = [];
        $users = $this->_get_newsletter_users();
        foreach ($users as $user) {

            $batch[$count]['email'] = [
                'email' => $user->email,
                'euid' => $user->id,
                'leid' => $list_id . '_' . $user->id
            ];
            $batch[$count]['email_type'] = 'html';
            $count++;
        }
        $params = [
            'id' => $list_id, //list id
            'batch' => $batch, //list id
            'double_optin' => false, //send confirmation email // optional default (true)
            'update_existing' => false, //optional default false -> return error 
            'replace_interests' => false, //optional default true 
        ];

        $return = $this->api('lists/batch-subscribe', $params);

        //marc added users subscribed
        if (!empty($return['adds'])) {
            $added = $return['adds'];

            foreach ($added as $add) {

                global $wpdb;
                $wpdb->suppress_errors = TRUE;

                $table_name = $wpdb->prefix . 'nzwpnewletter';

                $r = $wpdb->update($table_name, [
                    'subscribed' => true,
                    ], [
                    'email' => stripslashes($add['email'])
                    ]
                );
                if ($r) {
                    echo '<p>rows updated as subscribed: ' . $r . '</p>';
                }
            }
        }

        $this->buildTable($return['adds'], 'Adds');
        $this->buildTable($return['updates'], 'Updates');
        $this->buildTable($return['errors'], 'Errors');
    }
}
