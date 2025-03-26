<?php
function handle_live_bid()
{
    global $wpdb;

    check_ajax_referer('live_bid_nonce', 'security');

    $auction_id = intval($_POST['auction_id']);
    $bid_amount = floatval($_POST['bid_amount']);
    $user_id = get_current_user_id();
    $start_price = get_post_meta($auction_id, '_start_price', true);
    $bid_step = get_post_meta($auction_id, '_bid_step', true);
    $start_price = floatval($start_price);
    $buy_now_price = get_post_meta($auction_id, '_buy_now_price', true);
    $status = get_post_meta($auction_id, '_status', true);
    $buy_now_price = floatval($buy_now_price);
    if ($status !== 'open') {
        wp_send_json_error(['message' => __('Aukcionas uždarytas.', 'cfs-auction')]);
    }
    if (!$bid_amount || !$auction_id) {
        wp_send_json_error(['message' => __('Klaida pateikiant siūlymą.', 'cfs-auction')]);
    }
    if ($bid_amount <= $start_price) {
        wp_send_json_error(['message' => __('Siūlymas per mažas, neatitinka pradinės kainos.', 'cfs-auction')]);
    }
    $table_name = $wpdb->prefix . 'auctions_bid';
    $current_highest_bid = $wpdb->get_var($wpdb->prepare(
        "SELECT MAX(bid_amount) FROM $table_name WHERE auction_id = %d",
        $auction_id
    ));
    $current_highest_bid = $current_highest_bid ? floatval($current_highest_bid) : 0;
    if ($bid_amount <= $current_highest_bid) {
        wp_send_json_error(['message' => __('Siūlymas per mažas.', 'cfs-auction')]);
    }
    if ($bid_amount < $current_highest_bid + $bid_step || $bid_amount < $start_price + $bid_step) {
        wp_send_json_error(['message' => __('Siūloma kaina neatitinka minimalaus didėjimo žingsnio.', 'cfs-auction')]);
    }
    $wpdb->insert($table_name, [
        'auction_id' => intval($auction_id),
        'user_id' => intval($user_id),
        'bid_amount' => floatval($bid_amount),
    ]);
    if ($bid_amount >= $buy_now_price) {
        update_post_meta($auction_id, '_status', 'sold');
        update_post_meta($auction_id, 'winner', $user_id);
        wp_send_json_success(['message' => __('Siūlymas priimtas, Jūs laimėjote!', 'cfs-auction'), 'bid_amount' => $bid_amount, 'stop_timer' => true]);
    }
    
    wp_send_json_success(['message' => __('Siūlymas priimtas','cfs-auction'), 'bid_amount' => $bid_amount]); 
}
add_action('wp_ajax_live_bid', 'handle_live_bid');
add_action('wp_ajax_nopriv_live_bid', 'handle_live_bid');
function create_auction() {
    // 🔐 Saugumo patikra
    check_ajax_referer('auction_nonce', 'security');
    if (!current_user_can('edit_posts')) {
        wp_send_json([
            'success' => false,
            'message' => __('Neturite teisės kurti aukcionų.', 'cfs-auction')
        ]);
        return;
    }

    // 🔽 Importuojame validacijos funkcijas
    require_once plugin_dir_path(__FILE__) . 'validation/validate-fields.php';
    require_once plugin_dir_path(__FILE__) . 'validation/validate-dates.php';
    require_once plugin_dir_path(__FILE__) . 'validation/validate-prices.php';

    // 📥 Pradiniai kintamieji
    $errors = [];
    $sanitized = [];

    // 📌 Reikalingi laukai
    $required_fields = [
        'post_title',
        'start_price',
        'buy_now_price',
        'bid_step',
        'reserve_price',
        'excerpt',
        'auction_date_start',
        'auction_date_end'
    ];

    // ✅ Atliekame validacijas
    validate_required_fields($required_fields, $errors, $sanitized);
    validate_auction_dates($_POST['auction_date_start'], $_POST['auction_date_end'], $errors);
    validate_auction_prices($sanitized, $errors);

    // ❌ Jei yra klaidų – sustabdome
    if (!empty($errors)) {
        wp_send_json(['success' => false, 'message' => implode('<br>', $errors)]);
        return;
    }

    // 📝 Sukuriame aukcioną
    $auction_id = wp_insert_post([
        'post_title'  => $sanitized['post_title'],
        'post_type'   => 'auction',
        'post_status' => 'publish',
    ]);

    // 💾 Įrašome metaduomenis, jei viskas gerai
    if ($auction_id) {
        auction_save_custom_meta($auction_id); // naudoja $_POST kaip visada
        wp_send_json([
            'success' => true,
            'message' => __('Aukcionas sukurtas sėkmingai!', 'cfs-auction'),
            'auction_id' => $auction_id
        ]);
    } else {
        wp_send_json([
            'success' => false,
            'message' => __('❌ Klaida įrašant duomenis!', 'cfs-auction')
        ]);
    }
}
add_action('wp_ajax_create_auction', 'create_auction');


