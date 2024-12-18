export function checkAuctionStatus(auctionId, statusElement) {
    fetch(`/wp-json/auction/v1/status/${auctionId}`)
    .then(response => {
        if (!response.ok) {
            throw new Error(`Server error: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.status) {
            statusElement.textContent = data.status;
        }
    })
    .catch(error => console.error('Klaida tikrinant statusą:', error));
}
document.addEventListener('DOMContentLoaded', function () {
    const mainImage = document.getElementById('mainAuctionImage');
    const thumbnails = document.querySelectorAll('.thumbnail-image');
    // Patikriname, ar yra pagrindinė nuotrauka
    if (mainImage) {
        thumbnails.forEach(function (thumbnail) {
            thumbnail.addEventListener('click', function () {
                mainImage.src = this.src;
            });
        });
    }
    const auctionDetails = document.querySelector('.auction-details');
    // Patikriname, ar yra .auction-details
    if (!auctionDetails) {
        return; 
    }

    const auctionId = auctionDetails.dataset.auctionId; 
    const statusElement = auctionDetails.querySelector('.auction-status');

    // Patikriname, ar yra auctionId ir statusElement
    if (!statusElement || !auctionId) {
        return;
    }

    setInterval(function () {
        checkAuctionStatus(auctionId, statusElement);
    }, 5000);

    checkAuctionStatus(auctionId, statusElement);
});
