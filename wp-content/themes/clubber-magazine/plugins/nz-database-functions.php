<?php

/*
  Plugin Name: nz-database-functions
  Plugin URI:
  Description:
  Version: 1.0.0
  Author:
  Author URI:
  License: GPLv2
 */

function jal_install() {
        global $wpdb;
        global $jal_db_version;

        $table_name = $wpdb->prefix . "nz_events_users";

        $sql = "CREATE TABLE $table_name (
  event_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  PRIMARY KEY (event_id, user_id)
    );";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);

        add_option("jal_db_version", $jal_db_version);
}

/* register_activation_hook(__FILE__, 'jal_install'); */

class NZRelation {

        public $name;
        public $from;
        public $to;

        public function __construct($name, $from, $to) {
                $this->name = $name;
                $this->from = $from;
                $this->to = $to;
        }

        public function setRelationFrom($from, $to) {
                return $this->insert($from, $to);
        }

        public function removeRelationFrom($from, $to) {
                global $wpdb;
                $table_name = $wpdb->prefix . $this->name;
                $rows_affeted = $wpdb->delete($table_name, array($this->from => $from, $this->to => $to));
                return $rows_affeted;
        }

        public function getRelationFrom($from) {
                return $this->get_results($this->from, $from);
        }

        public function hasRelationFrom($from, $to) {
                global $wpdb;
                $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}{$this->name} WHERE {$this->from} = %d AND {$this->to} = %d", $from, $to);
                return $wpdb->get_results($sql, OBJECT);
                /* return $this->get_results($this->from, $from); */
        }

        public function setRelationTo($to, $from) {
                return $this->insert($from, $to);
        }

        public function getRelationTo($to, $single = FALSE) {

                $result = $this->get_results($this->to, $to);

                if ($single) {
                        $results = array(0);
                        $var = $this->from;
                        foreach ($result as $object) {
                                $results[] = $object->$var;
                        }
                        /* dd($results); */
                        return $results;
                }

                return $result;
        }

        private function insert($from, $to) {
                global $wpdb;
                $table_name = $wpdb->prefix . $this->name;
                $rows_affected = $wpdb->insert($table_name, array($this->from => $from, $this->to => $to));
                return $rows_affected;
        }

        private function get_results($comparation, $like, $type = OBJECT) {
                global $wpdb;
                $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}{$this->name} WHERE {$comparation} = %d", $like);
                return $wpdb->get_results($sql, $type);
        }

        public function install_table() {
                global $wpdb;
                $table_name = $wpdb->prefix . $this->name;
                $sql = $wpdb->prepare('CREATE TABLE %1$s(
                        time TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                        %2$s int(11) NOT NULL,
                        %3$s int(11) NOT NULL,
                        PRIMARY KEY (%2$s, %3$s)
                );', $table_name, $this->from, $this->to);


                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta($sql);
        }

}
