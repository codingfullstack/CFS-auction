jQuery(document).ready(function($) {
    $("#auction-form").on("submit", function(e) {
        e.preventDefault(); // Neleidžiame puslapiui persikrauti

        let formData = {
            action: "create_auction", // WordPress AJAX veiksmas
            security: auctionFormData.nonce, // Saugumo nonce
            post_title: $("#post_title").val(),
            start_price: $("#start_price").val(),
            buy_now_price: $("#buy_now_price").val(),
            bid_step: $("#bid_step").val(),
            auction_date_start: $("#auction_date_start").val(),
            auction_date_end: $("#auction_date_end").val(),
            reserve_price: $("#reserve_price").val(),
            excerpt: $("#excerpt").val()
        };

        $.post(auctionFormData.ajax_url, formData, function(response) {
            $("#auction-message").html(response.message).css("color", response.success ? "green" : "red");
            if (response.success) {
                $("#auction-form")[0].reset(); // Išvalome formą po sėkmingo įrašo
            }
        }, "json");
    });
});
