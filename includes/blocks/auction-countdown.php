<?php
function auction_countdown_render_cb($attributes)
{
    ob_start();

    // Patikrinkite, ar aukciono ID pateikta
    if (get_post_type() === 'auction') {
        // Jei dabartinis puslapis yra aukcionas, gauname ID iš dabartinio įrašo
        $auction_id = get_the_ID();
        
    } elseif (!empty($attributes['auction_id']) && intval($attributes['auction_id']) > 0) {
        // Jei tai ne aukciono puslapis, tikriname, ar atributai turi galiojantį auction_id
        $auction_id = intval($attributes['auction_id']);
    } else {
        // Nei dabartinis puslapis nėra aukcionas, nei ID nėra perduotas
        return __("Nerastas aukciono ID", 'cfs-auction');
    }

    // Paėmame aukciono pradžios ir pabaigos datas
    $start_date = get_post_meta($auction_id, '_auction_date_start', true);
    $end_date = get_post_meta($auction_id, '_auction_date_end', true);
    $style = '';
    if (isset($attributes['marginTop'])) {
        $style .= 'margin-top: ' . esc_attr($attributes['marginTop']) . 'px; ';
    }
    if (isset($attributes['marginBottom'])) {
        $style .= 'margin-bottom: ' . esc_attr($attributes['marginBottom']) . 'px; ';
    }
    if (isset($attributes['padding'])) {
        $style .= 'padding: ' . esc_attr($attributes['padding']) . 'px; ';
    }
    if (isset($attributes['fontSize'])) {
        $style .= 'font-size: ' . esc_attr($attributes['fontSize']) . 'px; ';
    }
    if (!$start_date || !$end_date) {
        return __('Nėra nurodytos pradžios arba pabaigos datos.','cfs-auction');
    }
    ?>
    <div class="auction-countdown-container" style="<?php echo $style; ?>">
        <h3><?php echo __('Auction Countdown', 'cfs-auction'); ?></h3>
        <p class="auction-countdown-time">
            <span id="auction-time" data-start-time="<?php echo esc_attr($start_date); ?>"
                data-end-time="<?php echo esc_attr($end_date); ?>"
                data-end-message="<?php echo esc_attr(__('Aukcionas baigėsi', 'cfs-auction')); ?>"
                data-auction-id ="<?php echo esc_attr($auction_id); ?>" >
            </span>
        </p>
    </div>
    <?php
    return ob_get_clean();
}
