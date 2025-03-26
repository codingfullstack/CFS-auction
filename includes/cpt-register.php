<?php
// Aukciono custom post type registracija
function auction_register_cpt() {
    $labels = array(
        'name'               => __('Aukcionai', "cfs-auction"),
        'singular_name'      => __('Aukcionas', "cfs-auction"),
        'menu_name'          => __('Aukcionai', "cfs-auction"),
        'name_admin_bar'     => __('Aukcionas', "cfs-auction"),
        'add_new'            => __('Pridėti Naują', "cfs-auction"),
        'add_new_item'       => __('Pridėti Naują Aukcioną', "cfs-auction"),
        'new_item'           => __('Naujas Aukcionas', "cfs-auction"),
        'edit_item'          => __('Redaguoti Aukcioną', "cfs-auction"),
        'view_item'          => __('Peržiūrėti Aukcioną', "cfs-auction"),
        'all_items'          => __('Visi Aukcionai', "cfs-auction"),
        'search_items'       => __('Ieškoti Aukcionų', "cfs-auction"),
        'not_found'          => __('Aukcionai nerasti', "cfs-auction"),
        'not_found_in_trash' => __('Aukcionai šiukšlių dėžėje nerasti', "cfs-auction"),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'hierarchical'       => false,
        'supports'           => array('title','excerpt'),
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'auction'),
        'show_in_rest'       => true,
    );

    register_post_type('auction', $args);
}


