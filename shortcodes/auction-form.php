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
        <label for="post_title">Title</label>
        <input type="text" name="post_title" size="30" id="post_title" spellcheck="true" autocomplete="off">

        <label for="start_price">Pradinė kaina</label>
        <input type="number" id="start_price" name="start_price" step="0.01" />

        <label for="buy_now_price">Pirk iš karto kaina</label>
        <input type="number" id="buy_now_price" name="buy_now_price" step="0.01" />

        <label for="bid_step">Bid Step (Žingsnis)</label>
        <input type="number" id="bid_step" name="bid_step" step="0.01" />

        <label for="auction_date_start">Aukciono pradžia</label>
        <input type="datetime-local" id="auction_date_start" name="auction_date_start" />

        <label for="auction_date_end">Aukciono pabaiga</label>
        <input type="datetime-local" id="auction_date_end" name="auction_date_end" />

        <label for="reserve_price">Rezervinė kaina</label>
        <input type="number" id="reserve_price" name="reserve_price" step="0.01" />

        <label for="excerpt">Aprašymas</label>
        <textarea rows="1" cols="40" name="excerpt" id="excerpt"></textarea>
        <label for="status">Statusas</label>
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
        <button type="button" id="og-img-btn" class="button upload-media-button">Įkelti Mediją</button>
        <input type="hidden" name="auction_media_url" id="up_og_image" value="" />
        <p class="description">Įkelkite arba pasirinkite mediją aukcionui.</p>
        <div class="media-preview">
        </div>
        <input type="submit" id="submit-auction" class="button button-primary button-large" value="Sukurti aukcioną">
        <p id="auction-message"></p>
    </form>

    <?php
    return ob_get_clean();
}
