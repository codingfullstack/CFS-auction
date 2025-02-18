<?php
function bid_input_render_cb($attributes)
{
    ob_start(); // Pradeda buferiavimą
    $bid_amount = isset($attributes['bid_amount']) ? $attributes['bid_amount'] : '';
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
    $buy_now_price = get_post_meta($auction_id, '_buy_now_price', true);
    ?>
    <div class="notification" id="notification" style="visibility: hidden; "></div>

    <div class="auction-bid-input-container">
        <h3><?php echo esc_html(__('Enter Your Bid', 'CFS-auction')); ?></h3>
        <input type="text" id="bid_amount" class="auction-bid-input" value="<?php echo esc_attr($bid_amount); ?>"
            placeholder="<?php echo esc_attr(__('Enter your bid...', 'CFS-auction')); ?>" />
        <input type="hidden" id="auction_id" value="<?php echo esc_attr($auction_id); ?>" />
        <button  id="submit_bid" data-ajaxurl="<?php echo admin_url('admin-ajax.php'); ?>"
            data-nonce="<?php echo wp_create_nonce('live_bid_nonce'); ?>"
            data-buy-now ="<?php echo esc_attr($buy_now_price); ?>">
            <?php echo esc_html(__('Siūlyti', 'CFS-auction')); ?>
        </button>
    </div>
    <?php
    return ob_get_clean();
}
