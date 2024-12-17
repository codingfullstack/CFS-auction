document.addEventListener('DOMContentLoaded', function () {
    const submitBidButton = document.getElementById('submit_bid');
    const bidList = document.getElementById('bid_list'); // Patikriname, ar #bid_list yra pasiekiamas


    submitBidButton.addEventListener('click', function () {
        const auctionId = document.getElementById('auction_id').value;
        const bidAmount = document.getElementById('bid_amount').value;

        const ajaxurl = submitBidButton.getAttribute('data-ajaxurl');
        const nonce = submitBidButton.getAttribute('data-nonce');

        fetch(ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'live_bid',
                security: nonce,
                auction_id: auctionId,
                bid_amount: bidAmount,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.data.message, 'success');
                updateBids();  // Atnaujina pasiūlymus po sėkmingo užklausos
            } else {
                showNotification(data.data.message, 'error');
            }
        })
        .catch(() => {
            showNotification('Įvyko klaida. Bandykite dar kartą.', 'error');
        });

        document.getElementById('bid_amount').value = '';
    });

    function showNotification(message, type = 'success') {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.classList.remove('success', 'error');
        notification.classList.add(type);
        notification.style.display = 'block';

        setTimeout(() => {
            notification.style.display = 'none';
        }, 5000);
    }

    function updateBids() {
        const auctionId = document.getElementById('auction_id').value;

        // Patikrinkite, ar yra bid_list elementas
        if (!bidList) {
            console.error("Elementas #bid_list nerastas.");
            return;
        }

        fetch(`/wp-json/auction/v1/bids/${auctionId}`)
            .then(response => response.json())
            .then(data => {
                // Valome esamą sąrašą
                bidList.innerHTML = '';

                // Jei pasiūlymai yra, pridedame juos
                if (data && data.length > 0) {
                    data.forEach(function (bid) {
                        const listItem = document.createElement('li');
                        listItem.textContent = `${bid.bid_amount} EUR`;
                        bidList.appendChild(listItem);  // Pridedame į #bid_list
                    });
                } else {
                    // Jei nėra pasiūlymų, įdedame pranešimą
                    const listItem = document.createElement('li');
                    listItem.textContent = 'No bids available';
                    bidList.appendChild(listItem);
                }
            })
            .catch(() => {
                console.error('Klaida atnaujinant pasiūlymus');
            });
    }

    setInterval(updateBids, 1000);  // Periodiškai atnaujiname pasiūlymus
    updateBids();  // Pirmas atnaujinimas
});
