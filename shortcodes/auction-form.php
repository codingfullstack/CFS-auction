<?php
// Užtikriname, kad failas nebūtų pasiektas tiesiogiai
if (!defined('ABSPATH'))
    exit;

/**
 * Shortcode: [auction_form]
 * Parodo aukciono kūrimo formą
 */
function auction_form_shortcode()
{
    ob_start(); ?>
    <form id="auction-form">
        <label for="post_title"><?php __("Pavadinimas", "cfs-auction")?></label>
        <input type="text" name="post_title" size="30" id="post_title" spellcheck="true" autocomplete="off">

        <label for="start_price"><?php __("Pradinė kaina", "cfs-auction")?></label>
        <input type="number" id="start_price" name="start_price" step="0.01" />

        <label for="buy_now_price"><?php __("Pirk iš karto kaina", "cfs-auction")?></label>
        <input type="number" id="buy_now_price" name="buy_now_price" step="0.01" />

        <label for="bid_step"><?php __('Statymo "žingsnis"', "cfs-auction")?></label>
        <input type="number" id="bid_step" name="bid_step" step="0.01" />

        <label for="auction_date_start"><?php __("Aukciono pradžia", "cfs-auction")?></label>
        <input type="datetime-local" id="auction_date_start" name="auction_date_start" />

        <label for="auction_date_end"><?php __("Aukciono pabaiga", "cfs-auction")?></label>
        <input type="datetime-local" id="auction_date_end" name="auction_date_end" />

        <label for="reserve_price"><?php __("Rezervinė kaina", "cfs-auction")?></label>
        <input type="number" id="reserve_price" name="reserve_price" step="0.01" />

        <label for="excerpt"><?php __("Aprašymas", "cfs-auction")?></label>
        <textarea rows="1" cols="40" name="excerpt" id="excerpt"></textarea>
        <label for="status"><?php __("Statusas", "cfs-auction")?></label>
        <select id="status" name="status">
            <?php
            $status_options = [
                'closed' => 'Uždarytas',
                'open' => 'Atidarytas',
            ];
            foreach ($status_options as $value => $label) {
                echo "<option value='$value'>$label</option>";
            } ?>
        </select>
        <button type="button" id="og-img-btn" class="button upload-media-button"><?php __("Įkelti Mediją", "cfs-auction")?></button>
        <input type="hidden" name="auction_media_url" id="up_og_image" value="" />
        <p class="description"><?php __("Įkelkite arba pasirinkite mediją aukcionui.", "cfs-auction")?></p>
        <div class="media-preview">
        </div>
        <input type="submit" id="submit-auction" class="button button-primary button-large" value="Sukurti aukcioną">
        <p id="auction-message"></p>
    </form>

    <?php
    return ob_get_clean();
}
