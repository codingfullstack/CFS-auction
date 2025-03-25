<?php
function validate_auction_prices($prices, &$errors) {
    if ($prices['start_price'] >= $prices['buy_now_price']) {
        $errors[] = "Pradinė kaina turi būti mažesnė nei „pirk dabar“ kaina.";
    }

    if ($prices['bid_step'] <= 0) {
        $errors[] = "Žingsnio vertė turi būti didesnė nei nulis.";
    }
}