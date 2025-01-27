<?php


// Pateikti siūlymą
function auction_submit_bid(WP_REST_Request $request)
{
    global $wpdb;

    $auction_id = intval($request->get_param('auction_id'));
    $bid_amount = floatval($request->get_param('bid_amount'));
    $user_id = get_current_user_id();

    if (!$auction_id || !$bid_amount) {
        return new WP_REST_Response(['error' => 'Trūksta duomenų.'], 400);
    }

    $table_name = $wpdb->prefix . 'auctions_bid';
    $current_highest_bid = $wpdb->get_var($wpdb->prepare(
        "SELECT MAX(bid_amount) FROM $table_name WHERE auction_id = %d",
        $auction_id
    ));

    if ($bid_amount > $current_highest_bid) {
        $wpdb->insert($table_name, [
            'auction_id' => $auction_id,
            'user_id' => $user_id,
            'bid_amount' => $bid_amount,
        ]);
        return new WP_REST_Response(['message' => 'Siūlymas priimtas!', 'bid_amount' => $bid_amount], 200);
    } else {
        return new WP_REST_Response(['error' => 'Siūlymas per mažas.'], 400);
    }
}

// Gauti siūlymų sąrašą
function auction_get_bids(WP_REST_Request $request)
{
    global $wpdb;

    $auction_id = intval($request->get_param('id'));
    if (!$auction_id) {
        return new WP_REST_Response(['error' => 'Nurodykite aukciono ID.'], 400);
    }

    $table_name = $wpdb->prefix . 'auctions_bid';
    $bids = $wpdb->get_results($wpdb->prepare(
        "SELECT user_id, bid_amount, bid_time FROM $table_name WHERE auction_id = %d ORDER BY bid_time DESC",
        $auction_id
    ));

    return new WP_REST_Response($bids, 200);
}
function auction_get_auction_data(WP_REST_Request $request)
{
    $auction_id = $request->get_param('auction_id');

    if (!$auction_id) {
        return new WP_REST_Response(['error' => 'Aukciono ID nėra nurodytas.'], 400);
    }

    // Paimame aukciono pradžios ir pabaigos datas iš postmeta
    $start_date = get_post_meta($auction_id, '_auction_date_start', true);
    $end_date = get_post_meta($auction_id, '_auction_date_end', true);

    if (!$start_date || !$end_date) {
        return new WP_REST_Response(['error' => 'Nėra nurodytos pradžios arba pabaigos datos.'], 400);
    }

    return new WP_REST_Response([
        'start_date' => $start_date,
        'end_date' => $end_date,
    ], 200);
}
function get_auction_status($request)
{
    $auction_id = intval($request['id']);
    if (!$auction_id) {
        return new WP_REST_Response(['message' => 'Neteisingas ID'], 400);
    }

    $status = get_post_meta($auction_id, '_status', true);

    return new WP_REST_Response(['status' => $status], 200);
}
// Funkcija, kuri apdoroja aukciono uždarymą
function close_auction_status(WP_REST_Request $request) {
    $auction_id = intval($request['auction_id']);
    
    // Patikrinkite, ar aukcionas egzistuoja
    if (get_post_status($auction_id) !== 'publish') {
        return new WP_REST_Response('Aukcionas nerastas arba nėra paskelbtas', 400);
    }
    update_post_meta($auction_id, '_status', 'closed');
    return new WP_REST_Response('Aukciono statusas atnaujintas į "closed"', 200);
}

