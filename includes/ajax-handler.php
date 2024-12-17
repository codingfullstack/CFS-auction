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
    if ($status == 'open') {
        if ($bid_amount > $start_price) {
            if ($bid_amount && $auction_id) {
                $table_name = $wpdb->prefix . 'auctions_bid';
                $current_highest_bid = $wpdb->get_var($wpdb->prepare(
                    "SELECT MAX(bid_amount) FROM $table_name WHERE auction_id = %d",
                    $auction_id
                ));

                if ($bid_amount > $current_highest_bid) {
                    if ($current_highest_bid + $bid_step <= $bid_amount) {
                        $wpdb->insert($table_name, [
                            'auction_id' => $auction_id,
                            'user_id' => $user_id,
                            'bid_amount' => $bid_amount,
                        ]);
                        if ($bid_amount >= $buy_now_price) {
                            update_post_meta($auction_id, '_status', 'sold');
                            update_post_meta($auction_id, 'winner', $user_id);
                        }
                        wp_send_json_success(['message' => 'Siūlymas priimtas, Jūs laimėjote!', 'bid_amount' => $bid_amount]);
                    } else {
                        wp_send_json_error(['message' => 'Siūloma kaina neatitinka minimalaus didėjimo žingsnio.']);
                    }
                } else {
                    wp_send_json_error(['message' => 'Siūlymas per mažas.']);
                }
            } else {
                wp_send_json_error(['message' => 'Klaida pateikiant siūlymą.']);
            }
        } else {
            wp_send_json_error(['message' => 'Siūlymas per mažas, neatitinka pradinės kainos.']);
        }
    }else{
        wp_send_json_error(['message' => 'Aukcionas uždarytas.']);
    }

}
add_action('wp_ajax_live_bid', 'handle_live_bid');
add_action('wp_ajax_nopriv_live_bid', 'handle_live_bid');
