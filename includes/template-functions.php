<?php
function myplugin_register_templates() {
    $post_types = ['page', 'auction']; // Pridėkite CPT arba naudokite tik 'page'
    foreach ($post_types as $post_type) {
        register_block_template(
            'cfs-auction//' . $post_type, // Pridėkite namespace
            [
                'title'       => __( 'Custom Auction Template', 'auction-plugin' ),
                'description' => __( 'A custom template for auctions.', 'auction-plugin' ),
                'content'     => myplugin_get_template_content('single-custom-template.html'), // Naudojame HTML šabloną
            ]
        );
    }
  }
  function myplugin_get_template_content($template) {
    // Patikrinkite, ar šablonas egzistuoja temoje
    $theme_template_path = get_stylesheet_directory() . '/cfs-auction/' . $template;
  
    // Jei yra temos šablonas, grąžinkite jo turinį
    if (file_exists($theme_template_path)) {
        return file_get_contents($theme_template_path);
    }
  
    // Jei nėra temos šablono, grąžinkite įskiepio šabloną
    $plugin_template_path = plugin_dir_path(__FILE__) . '../templates/' . $template;
  
    if (file_exists($plugin_template_path)) {
        return file_get_contents($plugin_template_path);
    }
  
    // Debugging, jei failas nerastas
    error_log('Template file not found: ' . $template);
    return ''; // Jei failas nerastas, grąžins tuščią turinį
  }
  
