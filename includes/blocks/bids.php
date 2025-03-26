<?php
function bids_auction_render_cb($attributes) {
    global $wpdb;

    if (get_post_type() === 'auction') {
        // Jei dabartinis puslapis yra aukcionas, gauname ID iš dabartinio įrašo
        $auction_id = get_the_ID();
        
    } elseif (!empty($attributes['auction_id']) && intval($attributes['auction_id']) > 0) {
        // Jei tai ne aukciono puslapis, tikriname, ar atributai turi galiojantį auction_id
        $auction_id = intval($attributes['auction_id']);
    } else {
        // Nei dabartinis puslapis nėra aukcionas, nei ID nėra perduotas
        return "Nerastas aukciono ID";
    }
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
        <input type="hidden" id="auction_id" value="<?php echo esc_attr($auction_id); ?>">
        <h3><?php esc_html_e('Visi siūlymai', 'CFS-auction'); ?></h3>
        <ul id="bid_list">
        </ul>
    </div>
    <?php
    return ob_get_clean();
}
