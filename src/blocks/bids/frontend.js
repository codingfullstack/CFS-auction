import { fetchBids } from "./api.js";
import { updateBids } from "./dom.js";

document.addEventListener("DOMContentLoaded", function () {
    const bidList = document.getElementById("bid_list");
    const auctionIdElement = document.getElementById("auction_id");
    

    if (!bidList || !auctionIdElement) return;

    function refreshBids() {
        const auctionId = auctionIdElement.value.trim();
        fetchBids(auctionId)
            .then(bids => updateBids(bidList, bids))
            .catch(error => console.error("Klaida atnaujinant pasiūlymus:", error));
    }
    

    setInterval(refreshBids, 1000);
    refreshBids();
});
