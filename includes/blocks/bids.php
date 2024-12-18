<?php
function bids_auction_render_cb($attributes) {
    global $wpdb;

    $auction_id = isset($attributes['auction_id']) ? intval($attributes['auction_id']) : 0;

    if (!$auction_id) {
        return '<p>' . esc_html__('Please provide a valid Auction ID.', 'CFS-auction') . '</p>';
    }


    $table_name = $wpdb->prefix . 'auctions_bid';
    $bids = $wpdb->get_results($wpdb->prepare(
        "SELECT user_id, bid_amount, bid_time FROM $table_name WHERE auction_id = %d ORDER BY bid_time DESC",
        $auction_id
    ));
    ob_start();
    ?>
    <div class="auction-bids-list-container" >
        <h3><?php esc_html_e('Auction Bids', 'CFS-auction'); ?></h3>
        <ul id="bid_list">
        </ul>
    </div>
    <?php
    return ob_get_clean();
}
