import { updateBids } from '../bids/frontend.js';
function showNotification(message, type = "success") {
  const notification = document.getElementById("notification");
  notification.textContent = message;
  notification.classList.remove("success", "error");
  notification.classList.add(type);
  notification.style.display = "block";

  setTimeout(() => {
    notification.style.display = "none";
  }, 5000);
}
document.addEventListener("DOMContentLoaded", function () {
  const submitBidButton = document.getElementById("submit_bid");
  // Patikriname, ar submitBidButton egzistuoja, kad išvengtume klaidų
  if (!submitBidButton) {
    console.error("Elementas #submit_bid nerastas.");
    return; 
  }

  submitBidButton.addEventListener("click", function () {
    const auctionIdElement = document.getElementById("auction_id");
    const bidAmountElement = document.getElementById("bid_amount");

    // Patikriname, ar elementai egzistuoja
    if (!auctionIdElement || !bidAmountElement) {
      console.error("Reikalingi elementai nerasti.");
      return; // Nutraukiame, jei nėra reikiamų elementų
    }

    const auctionId = auctionIdElement.value;
    const bidAmount = bidAmountElement.value;

    const ajaxurl = submitBidButton.getAttribute("data-ajaxurl");
    const nonce = submitBidButton.getAttribute("data-nonce");

    fetch(ajaxurl, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        action: "live_bid",
        security: nonce,
        auction_id: auctionId,
        bid_amount: bidAmount,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          showNotification(data.data.message, "success");
          updateBids();
        } else {
          showNotification(data.data.message, "error");
        }
      })
      .catch(error => {
        // Pateikiame daugiau informacijos apie klaidą
        console.error('Įvyko klaida:', error);
        showNotification('Įvyko klaida. Bandykite dar kartą.', 'error');
    });

    document.getElementById("bid_amount").value = "";
  });
});
