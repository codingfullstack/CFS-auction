<?php
// Aukciono custom post type registracija
function auction_register_cpt() {
    $labels = array(
        'name'               => 'Aukcionai',
        'singular_name'      => 'Aukcionas',
        'menu_name'          => 'Aukcionai',
        'name_admin_bar'     => 'Aukcionas',
        'add_new'            => 'Pridėti Naują',
        'add_new_item'       => 'Pridėti Naują Aukcioną',
        'new_item'           => 'Naujas Aukcionas',
        'edit_item'          => 'Redaguoti Aukcioną',
        'view_item'          => 'Peržiūrėti Aukcioną',
        'all_items'          => 'Visi Aukcionai',
        'search_items'       => 'Ieškoti Aukcionų',
        'not_found'          => 'Aukcionai nerasti',
        'not_found_in_trash' => 'Aukcionai šiukšlių dėžėje nerasti',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'hierarchical'       => false,
        'supports'           => array('title', 'editor'),
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'auction'),
        'show_in_rest'       => true,
    );

    register_post_type('auction', $args);
}

