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
        <input type="text" name="post_title" size="30" value="" id="title" spellcheck="true" autocomplete="off">
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

        <input type="submit" name="publish" id="publish" class="button button-primary button-large" value="Publish">
        <p id="auction-message"></p>
    </form>

    <script>
        jQuery(document).ready(function ($) {
            $("#auction-form").on("submit", function (e) {
                e.preventDefault();
                let formData = {
                    action: "create_auction",
                    title: $("#auction-title").val(),
                    price: $("#starting-price").val(),
                    end_date: $("#end-date").val(),
                    security: "<?php echo wp_create_nonce('auction_nonce'); ?>"
                };

                $.post("<?php echo admin_url('admin-ajax.php'); ?>", formData, function (response) {
                    $("#auction-message").html(response.message).css("color", response.success ? "green" : "red");
                    if (response.success) $("#auction-form")[0].reset();
                }, "json");
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
