import { checkAuctionStatus } from "../single-auction/frontend.js";
export function updateBids() {
  const bidList = document.getElementById("bid_list");
  const statusElement = document.querySelector(".auction-status");
  const auctionIdElement = document.getElementById("auction_id");

  // Patikriname, ar elementas su id "auction_id" egzistuoja
  if (!auctionIdElement) {
    console.error("Elementas #auction_id nerastas.");
    return; // Nutraukiame funkciją, jei elemento nėra
  }
  const auctionId = auctionIdElement.value;
  if (!bidList) {
    console.error("Elementas #bid_list nerastas.");
    return;
  }
  fetch(`/wp-json/auction/v1/bids/${auctionId}`)
    .then((response) => response.json())
    .then((data) => {
      bidList.innerHTML = ""; // Išvalome esamus pasiūlymus
      if (data && data.length > 0) {
        data.forEach(function (bid) {
          const listItem = document.createElement("li");
          listItem.classList.add("bid-item");
          listItem.textContent = `${bid.bid_amount} EUR`;
          bidList.appendChild(listItem);
        });
      } else {
        const listItem = document.createElement("li");
        listItem.classList.add("bid-item");
        listItem.textContent = "No bids available";
        bidList.appendChild(listItem);
      }
      // Atnaujinti statusą po atnaujinimo pasiūlymų
      if (statusElement) {
        checkAuctionStatus(auctionId, statusElement); // Patikrinti ir atnaujinti statusą
      }
    })
    .catch(() => {
      console.error("Klaida atnaujinant pasiūlymus");
    });
}
document.addEventListener("DOMContentLoaded", function () {
  setInterval(updateBids, 1000);
  updateBids();
});
