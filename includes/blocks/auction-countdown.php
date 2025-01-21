<?php
function auction_countdown_render_cb($attributes)
{
    ob_start();

    // Patikrinkite, ar aukciono ID pateikta
    if (get_post_type() === 'auction') {
        $auction_id = get_the_ID();
    } elseif (!empty($attributes['auction_id']) && intval($attributes['autcion_id']) > 0) {
        $auction_id = intval($attributes['auction_id']);
    } else{
        return 'nerastas id';
    }

    // Paėmame aukciono pradžios ir pabaigos datas
    $auction_id = $attributes['auction_id'];
    $start_date = get_post_meta($auction_id, '_auction_date_start', true);
    $end_date = get_post_meta($auction_id, '_auction_date_end', true);

    if (!$start_date || !$end_date) {
        return 'Nėra nurodytos pradžios arba pabaigos datos.';
    }
    ?>
    <div class="auction-countdown-container">
        <h3><?php echo __('Auction Countdown', 'auction-plugin'); ?></h3>
        <p class="auction-countdown-time">
            <span id="auction-time" data-start-time="<?php echo esc_attr($start_date); ?>"
                data-end-time="<?php echo esc_attr($end_date); ?>"
                data-end-message="<?php echo esc_attr(__('Auction has ended', 'auction-plugin')); ?>">
            </span>
        </p>
    </div>
    <?php
    return ob_get_clean();
}
