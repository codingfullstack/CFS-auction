<?php
// Meta laukų sukūrimas
function auction_add_meta_boxes() {
    add_meta_box(
        'auction_price_meta',
        'Aukciono Kainos',
        'auction_price_meta_box_callback',
        'auction',  // Priskiriame prie aukciono tipo
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'auction_add_meta_boxes');

// Meta laukų forma
function auction_price_meta_box_callback($post) {
    // Gaukime esamus meta duomenis
    $start_price = get_post_meta($post->ID, '_start_price', true);
    $buy_now_price = get_post_meta($post->ID, '_buy_now_price', true);
    $bid_step = get_post_meta($post->ID, '_bid_step', true);
    $auction_date_start = get_post_meta($post->ID, '_auction_date_start', true);
    $auction_date_end = get_post_meta($post->ID, '_auction_date_end', true);
    $reserve_price = get_post_meta($post->ID, '_reserve_price', true);
    $status = get_post_meta($post->ID, '_status', true);

    // Atvaizduokime įvedimo laukus
    echo '<label for="start_price">Pradinė kaina</label>';
    echo '<input type="number" id="start_price" name="start_price" value="' . esc_attr($start_price) . '" step="0.01" />';

    echo '<label for="buy_now_price">Pirk iš karto kaina</label>';
    echo '<input type="number" id="buy_now_price" name="buy_now_price" value="' . esc_attr($buy_now_price) . '" step="0.01" />';

    echo '<label for="bid_step">Bid Step (Žingsnis)</label>';
    echo '<input type="number" id="bid_step" name="bid_step" value="' . esc_attr($bid_step) . '" step="0.01" />';

    echo '<label for="auction_date_start">Aukciono pradžia</label>';
    echo '<input type="datetime-local" id="auction_date_start" name="auction_date_start" value="' . esc_attr($auction_date_start) . '" />';

    echo '<label for="auction_date_end">Aukciono pabaiga</label>';
    echo '<input type="datetime-local" id="auction_date_end" name="auction_date_end" value="' . esc_attr($auction_date_end) . '" />';

    echo '<label for="reserve_price">Rezervinė kaina</label>';
    echo '<input type="number" id="reserve_price" name="reserve_price" value="' . esc_attr($reserve_price) . '" step="0.01" />';

    // Atidarytas / Neatidarytas (Select)
    $status_options = [
        'closed' => 'Uždarytas',
        'open' => 'Atidarytas', 
    ];

    echo '<label for="status">Statusas</label>';
    echo '<select id="status" name="status">';
    foreach ($status_options as $value => $label) {
        $selected = selected($status, $value, false);
        echo "<option value='$value' $selected>$label</option>";
    }
    echo '</select>';
    echo '<button type="button" id="og-img-btn" class="button upload-media-button">Įkelti Mediją</button>';
    echo '<input type="hidden" name="auction_media_url" id="up_og_image" value="" />';
    echo '<p class="description">Įkelkite arba pasirinkite mediją aukcionui.</p>';
    echo '<div class="media-preview">';
    echo '</div>';
}

