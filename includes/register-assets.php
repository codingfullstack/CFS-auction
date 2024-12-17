<?php
function auction_register_assets()
{
    $adminAssets = include(PLUGIN_DIR . 'build/admin/index.asset.php');
    wp_register_script(
        'auction_admin',
        plugins_url('/build/admin/index.js', PLUGIN_FILE),
        $adminAssets['dependencies'],
        $adminAssets['version'],
        true
    );
}