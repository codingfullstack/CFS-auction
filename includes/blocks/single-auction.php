<?php
function single_auction_render_cb($attributes)
{
    if (empty($attributes['auction_id']))
        return "nerastas id";
        $auction_id = isset($attributes['auction_id']) ? intval($attributes['auction_id']) : 0;
    $start_price = get_post_meta($auction_id, '_start_price', true);
    $buy_now = get_post_meta($auction_id, '_buy_now_price', true);
    $bid_step = get_post_meta($auction_id, '_bid_step', true);
    $auction_date_start = get_post_meta($auction_id, '_auction_date_start', true);
    $auction_date_end = get_post_meta($auction_id, '_auction_date_end', true);
    $post_title = get_the_title($auction_id);
    $auction_media = get_post_meta($auction_id, '_auction_media_url', true);
    $main_image = esc_url($auction_media[0]);
    ob_start();
    ?>
    <div class="auction-details" data-auction-id="<?php echo esc_attr($auction_id); ?>">
    <h2><?php echo esc_html($post_title, 'auction-plugin'); ?></h2>
        <div class="main-image-container">
            <img id="mainAuctionImage" src="<?php echo $main_image; ?>" alt="<?php echo esc_attr($post_title); ?>"
                class="main-auction-image">
        </div>
        <div class="thumbnail-container" id="thumbnailContainer">
            <?php foreach ($auction_media as $img_url):
                $img_url = esc_url($img_url);
                if (filter_var($img_url, FILTER_VALIDATE_URL)): ?>
                    <img src="<?php echo $img_url; ?>" alt="<?php echo esc_attr($post_title); ?>" class="thumbnail-image">
                <?php endif; endforeach; ?>
        </div>
        <p><?php echo esc_html(__('Pradinė kaina:', 'auction-plugin')); ?><span><?php echo esc_html($start_price, 'auction-plugin'); ?></span>
        </p>
        <p><?php echo esc_html(__('Pirkti dabar:', 'auction-plugin')); ?><span><?php echo esc_html($buy_now, 'auction-plugin'); ?></span>
        </p>
        <p><?php echo esc_html(__('Statymo "žingsnis":', 'auction-plugin')); ?><span><?php echo esc_html($bid_step, 'auction-plugin'); ?></span>
        </p>
        <p><?php echo esc_html(__('Aukciono pradžia:', 'auction-plugin')); ?><span><?php echo esc_html($auction_date_start, 'auction-plugin'); ?></span>
        </p>
        <p><?php echo esc_html(__('Aukciono pabaiga:', 'auction-plugin')); ?><span><?php echo esc_html($auction_date_end, 'auction-plugin'); ?></span>
        </p>
        <p><?php echo esc_html(__('Statusas:', 'auction-plugin')); ?><span class="auction-status"></span>
        </p>
    </div>
    <?php
    return ob_get_clean();
}
