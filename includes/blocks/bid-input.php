<?php
function bid_input_render_cb($attributes)
{
    ob_start(); // Pradeda buferiavimą

    $bid_amount = isset($attributes['bid_amount']) ? $attributes['bid_amount'] : '';
    $auction_id = isset($attributes['auction_id']) ? $attributes['auction_id'] : get_the_ID();

    // HTML turinys su tekstu ir mygtuku
    ?>
    <div class="notification" id="notification" style="display: none;"></div>

    <div class="auction-bid-input-container">
        <h3><?php echo esc_html(__('Enter Your Bid', 'CFS-auction')); ?></h3>
        <input type="text" id="bid_amount" class="auction-bid-input" value="<?php echo esc_attr($bid_amount); ?>"
            placeholder="<?php echo esc_attr(__('Enter your bid...', 'CFS-auction')); ?>" class="auction-bid-input-field" />
        <input type="hidden" id="auction_id" value="<?php echo esc_attr($auction_id); ?>" />
        <button id="submit_bid" data-ajaxurl="<?php echo admin_url('admin-ajax.php'); ?>"
            data-nonce="<?php echo wp_create_nonce('live_bid_nonce'); ?>">
            <?php echo esc_html(__('Siūlyti', 'CFS-auction')); ?>
        </button>
    </div>
    <?php
    return ob_get_clean();
}
