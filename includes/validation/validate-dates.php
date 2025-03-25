<?php
function validate_auction_dates($start, $end, &$errors) {
    $startDate = DateTime::createFromFormat('Y-m-d\\TH:i', $start);
    $endDate = DateTime::createFromFormat('Y-m-d\\TH:i', $end);
    $now = new DateTime(current_time('Y-m-d H:i:s'));

    if (!$startDate || !$endDate) {
        $errors[] = "Netinkamas datos formatas.";
        return;
    }

    if ($endDate <= $startDate) {
        $errors[] = "Pabaigos data turi būti vėlesnė nei pradžios data.";
    }

    if ($endDate < $now) {
        $errors[] = "Pabaigos data negali būti praeityje.";
    }
}