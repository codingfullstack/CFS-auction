<?php
function auction_save_custom_meta($post_id)
{
    // Patikriname, ar mes ne esame automatiškai saugomi
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;

    // Patikriname, ar mes turime teisę saugoti šiuos duomenis
    if (!current_user_can('edit_post', $post_id))
        return $post_id;

    // Masyvas, kuriame laikysime laukų informaciją (pavadinimas ir atitinkama funkcija)
    $fields = [
        '_start_price' => 'start_price',
        '_buy_now_price' => 'buy_now_price',
        '_bid_step' => 'bid_step',
        '_reserve_price' => 'reserve_price',
        '_auction_date_start' => 'auction_date_start',
        '_auction_date_end' => 'auction_date_end',
        '_status' => 'status'
    ];

    foreach ($fields as $meta_key => $field_name) {
        if (isset($_POST[$field_name])) {
            // Gaukime įvestą reikšmę
            $value = sanitize_text_field($_POST[$field_name]);

            switch ($meta_key) {
                case '_start_price':
                case '_buy_now_price':
                case '_reserve_price':
                case '_bid_step':
                    $value = $value < 0 ? 0 : $value;
                    break;
                case '_auction_date_start':
                case '_auction_date_end':
                    if (empty($value)) {
                        $value = current_time('Y-m-d H:i:s');
                    } else {
                        $date = DateTime::createFromFormat('Y-m-d\TH:i', $value);
                        if ($date) {
                            $value = $date->format('Y-m-d H:i:s');
                        } else {
                            $value = current_time('Y-m-d H:i:s'); 
                        }
                    }
                    break;

            }
            update_post_meta($post_id, $meta_key, $value);
        }
    }
    if (isset($_POST['auction_media_url']) && !empty($_POST['auction_media_url'])) {
        $media_urls = array_map('esc_url_raw', explode(',', $_POST['auction_media_url']));
        update_post_meta($post_id, '_auction_media_url', $media_urls);
    }
}