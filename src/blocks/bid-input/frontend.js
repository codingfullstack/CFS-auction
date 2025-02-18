import { submitBid } from "./bidding.js";

document.addEventListener("DOMContentLoaded", function () {
    const submitBidButton = document.getElementById("submit_bid");
    const auctionIdElement = document.getElementById("auction_id");
    const bidAmountElement = document.getElementById("bid_amount");

    if (!submitBidButton || !auctionIdElement || !bidAmountElement) return;

    const ajaxurl = submitBidButton.getAttribute("data-ajaxurl");
    const nonce = submitBidButton.getAttribute("data-nonce");

    submitBidButton.addEventListener("click", async function () {
        const auctionId = auctionIdElement.value;
        const bidAmount = bidAmountElement.value;
        if (!auctionId || !bidAmount) return;
        
        await submitBid(ajaxurl, nonce, auctionId, bidAmount);
        bidAmountElement.value = "";
    });
});
