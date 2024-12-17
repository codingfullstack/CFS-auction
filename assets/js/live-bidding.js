jQuery(document).ready(function ($) { 
      
    function showNotification(message, type = 'success')
    {
        const notification = $('#notification');
        notification
            .text(message)
            .removeClass('success error') 
            .addClass(type) 
            .fadeIn(); 

        setTimeout(() => {
            notification.fadeOut();
        }, 5000);
    } 
    $('#submit_bid').on('click', function () {
        
        const auctionId = $('#auction_id').val();
        const bidAmount = $('#bid_amount').val();

        $.ajax({
            url: liveBid.ajaxurl,
            method: 'POST',
            data: {
                action: 'live_bid',
                security: liveBid.nonce,
                auction_id: auctionId,
                bid_amount: bidAmount,
            },
            success: function (response) {
                if (response.success) {
                    showNotification(response.data.message, 'success'); 
                    updateBids();
                } else {
                    showNotification(response.data.message, 'error'); 
                }
            },
            error: function () {
                showNotification('Įvyko klaida. Bandykite dar kartą.', 'error'); // Klaida serveryje
            },
        });
        $('#bid_amount').val('');
    });

    function updateBids() {
        const auctionId = $('#auction_id').val();
        $.get(`/wp-json/auction/v1/bids/${auctionId}`, function (data) {
            let bidsHtml = '';
            data.forEach(function (bid) {
                bidsHtml += `<p>${bid.bid_amount}  EUR</p>`;
            });
            $('#bid_list').html(bidsHtml);
        });
    }
    setInterval(updateBids, 1000);
    updateBids()

});
