<?php

class NzWpNewsletterWizard
{

    function __construct()
    {
        add_action('plugins_loaded', array($this, 'update_db_check'));
        register_activation_hook(__FILE__, array($this, 'install'));
        /* register_deactivation_hook(__FILE__, array($this, 'deactivate')); */
        register_uninstall_hook(__FILE__, array($this, 'uninstall'));
    }

    function update_db_check()
    {
        
        if (get_site_option('nz_wp_newsletter_db_version') != NzWpNewsletter::VERSION) {
            $this->install();
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
        
    }

    public function install()
    {

        global $wpdb;

        $table_name = $wpdb->prefix . 'nzwpnewsletter';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
              id INT AUTO_INCREMENT  primary key NOT NULL ,
              time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
              user_id int DEFAULT 0,
              email varchar(55) NOT NULL,
              subscribed boolean NOT NULL DEFAULT 0,
              UNIQUE KEY email (email)
        ) $charset_collate;";
        
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        $r = dbDelta($sql);

        add_option('nz_wp_newsletter_db_version', NzWpNewsletter::VERSION);
    }
}

new NzWpNewsletterWizard();
