<?php

class NzWpNewsletterWizard
{

    function __construct($file)
    {
        add_action('plugins_loaded', array($this, 'update_db_check'));
        register_activation_hook($file, array($this, 'install'));
        register_deactivation_hook($file, array($this, 'deactivate'));
        register_uninstall_hook($file, array($this, 'uninstall'));
    }

    function update_db_check()
    {
        $this->install();
        if (get_site_option('nz_wp_newsletter_db_version') != NzWpNewsletter::VERSION) {
            
        }
    }

    public function uninstall()
    {
        delete_option('nz_wp_newsletter_db_version');

        global $wpdb;
        $table_name = $wpdb->prefix . 'nzwpnewsletter';

        $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }

    public function deactivate()
    {
        $this->uninstall();
    }

    public function install()
    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'nzwpnewsletter';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
              user_id int,
              email varchar(55) NOT NULL,
              UNIQUE KEY email (email)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        $r = dbDelta($sql);


        add_option('nz_wp_newsletter_db_version', NzWpNewsletter::VERSION);
        var_dump($r);
        var_dump($wpdb->last_error);
    }
}
