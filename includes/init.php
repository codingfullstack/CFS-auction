<?php
// Registruoti REST API endpoint'us
add_action('rest_api_init', function () {
    // Pateikti siūlymą
    register_rest_route('auction/v1', '/bid', [
        'methods' => 'POST',
        'callback' => 'auction_submit_bid',
        'permission_callback' => function () {
            return is_user_logged_in(); // Tik prisijungusiems vartotojams
        },
    ]);

    // Gauti siūlymų sąrašą
    register_rest_route('auction/v1', '/bids/(?P<id>\d+)', [
        'methods' => 'GET',
        'callback' => 'auction_get_bids',
        'permission_callback' => '__return_true',
    ]);
    register_rest_route('auction/v1', '/auction-data/(?P<auction_id>\d+)', [
        'methods' => 'GET',
        'callback' => 'auction_get_auction_data',
        'permission_callback' => '__return_true',
    ]);
});