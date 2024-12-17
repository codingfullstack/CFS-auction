<?php
function create_wp_auctions_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'auctions_bid';
    $charset_collate = $wpdb->get_charset_collate();

    // SQL užklausa lentelės sukūrimui
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        auction_id mediumint(9) NULL,
        user_id mediumint(9) NULL,
        bid_amount decimal(10,2) NULL,
        bid_time datetime NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    // Vykdome SQL užklausą
    dbDelta($sql);
}