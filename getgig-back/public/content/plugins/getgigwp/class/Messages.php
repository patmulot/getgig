<?php
namespace getgigwp;

class Messages
{
    public function __construct()
    {
        // $wpdb https://developer.wordpress.org/reference/classes/wpdb/
        global $wpdb;
        $this->database = $wpdb;
    }
    public function createTable()
    {
        $sql = "
        CREATE TABLE `messages` (
            `id` bigint(24) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `sender_id` bigint(24) unsigned NOT NULL,
            `recipient_id` bigint(24) unsigned NOT NULL,
            `content` longtext NOT NULL,
            `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
            `updated_at` datetime NULL
            );
        ";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);
    }
    public function dropTable()
    {
        $sql = "DROP TABLE `messages`";
        $this->database->query($sql);
    }
}
