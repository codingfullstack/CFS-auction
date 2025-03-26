<?php


// Pateikti siūlymą
function auction_submit_bid(WP_REST_Request $request)
{
    global $wpdb;

    $auction_id = absint($request->get_param('auction_id'));
    $bid_amount = floatval($request->get_param('bid_amount'));
    $user_id = get_current_user_id();

    if (!$auction_id || !$bid_amount) {
        return new WP_REST_Response(['error' => __('pateikti ne visi duomenys.', 'cfs-auction')], 400);
    }

    $table_name = $wpdb->prefix . 'auctions_bid';
    // Gauti dabartinę aukščiausią kainą
    $current_highest_bid = $wpdb->get_var($wpdb->prepare(
        "SELECT MAX(bid_amount) FROM $table_name WHERE auction_id = %d",
        $auction_id
    ));

    $current_highest_bid = $current_highest_bid ? floatval($current_highest_bid) : 0;

    if ($bid_amount <= $current_highest_bid) {
        return new WP_REST_Response(['error' => __('Pasiūlymas per mažas.', 'cfs-auction')], 400);
    }

    // Įterpti naują siūlymą
    $wpdb->insert($table_name, [
        'auction_id' => $auction_id,
        'user_id'    => $user_id,
        'bid_amount' => $bid_amount,
        'bid_time'   => current_time('mysql'),
    ]);

    return new WP_REST_Response(['message' => __('Sūlymas priimtas!', 'cfs-auction'), 'bid_amount' => $bid_amount], 200);
}

// Gauti siūlymų sąrašą
function auction_get_bids(WP_REST_Request $request) {
    global $wpdb;

    // Gauti "id" iš užklausos
    $auction_id = absint($request->get_param('id'));

    // Patikrinti, ar ID pateiktas
    if (!$auction_id) {
        return new WP_Error(
            'missing_id',
            __('Nėra aukciono id.', 'cfs-auction'),
            ['status' => 400]
        );
    }

    // SQL užklausa gauti siūlymus
    $table_name = $wpdb->prefix . 'auctions_bid';
    $bids = $wpdb->get_results($wpdb->prepare(
        "SELECT id, user_id, bid_amount, bid_time 
        FROM $table_name 
        WHERE auction_id = %d 
        ORDER BY bid_time DESC 
        LIMIT 2",
        $auction_id
    ));

    // Jei siūlymų nėra
    if (empty($bids)) {
        return new WP_REST_Response([], 200); // Grąžiname tuščią sąrašą vietoj klaidos
    }

    // Grąžinti siūlymus
    return new WP_REST_Response($bids, 200);
}

function auction_get_auction_data(WP_REST_Request $request) {
    $auction_id = absint($request->get_param('auction_id'));

    if (!$auction_id) {
        return new WP_REST_Response(['error' => __('Nėra aukciono id.', 'cfs-auction')], 400);
    }

    // Gauti meta duomenis
    $start_date = get_post_meta($auction_id, '_auction_date_start', true);
    $end_date = get_post_meta($auction_id, '_auction_date_end', true);

    if (!$start_date || !$end_date) {
        return new WP_REST_Response(['error' => __('Aukciono duomenis nerasti.', 'cfs-auction')], 404);
    }

    return new WP_REST_Response([
        'start_date' => $start_date,
        'end_date'   => $end_date,
    ], 200);
}
function get_auction_status($request)
{
    $auction_id = intval($request['id']);
    if (!$auction_id) {
        return new WP_REST_Response(['message' => __('Neteisingas ID', 'cfs-auction')], 400);
    }

    $status = get_post_meta($auction_id, '_status', true);

    return new WP_REST_Response(['status' => $status], 200);
}
// Funkcija, kuri apdoroja aukciono uždarymą
function close_auction_status(WP_REST_Request $request) {
    $auction_id = intval($request['auction_id']);
    
    // Patikrinkite, ar aukcionas egzistuoja
    if (get_post_status($auction_id) !== 'publish') {
        return new WP_REST_Response(__('Aukcionas nerastas arba nėra paskelbtas', 'cfs-auction'), 400);
    }
    update_post_meta($auction_id, '_status', 'closed');
    return new WP_REST_Response( __('Aukciono statusas atnaujintas į "closed"', 'cfs-auction'), 200);
}


