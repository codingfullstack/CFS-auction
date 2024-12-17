<?php
/**
 * Plugin Name:       CFS-auction
 * Plugin URI:        https://udemy.com
 * Description:       A plugin for adding blocks to a theme.
 * Version:           1.0.0
 * Requires at least: 5.9
 * Requires PHP:      7.2
 * Author:            CodingFullStack
 * Author URI:        https://udemy.com
 * Text Domain:       auction-plugin
 * Domain Path:       /languages
 */

if (!function_exists('add_action')) {
  echo 'Seems like you stumbled here by accident. 😛';
  exit;
}
define('PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PLUGIN_FILE', __FILE__);

// Dinamiškai įkelkite visus PHP failus iš includes/ katalogo
$rootFiles = glob(PLUGIN_DIR . 'includes/*.php');
$subdirectoryFiles = glob(PLUGIN_DIR . 'includes/**/*.php');
$allFiles = array_merge($rootFiles, $subdirectoryFiles);

foreach ($allFiles as $filename) {
    include_once($filename);
}
register_activation_hook(__FILE__, 'create_wp_auctions_table');
add_action('admin_enqueue_scripts', 'auction_admin_enqueue');
add_action('init', 'register_blocks');
add_action('init', 'auction_register_cpt');  
add_action('add_meta_boxes', 'auction_add_meta_boxes');
add_action('save_post', 'auction_save_custom_meta'); 
add_action('init', 'auction_register_assets');
