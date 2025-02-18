import { updateBids } from "../bids/dom.js";
import { fetchBids } from "../bids/api.js";
import { showNotification } from "./notifications.js";
import auctionState from "../../shared/auction-state.js"; 
export async function submitBid(ajaxurl, nonce, auctionId, bidAmount) {
    const buyNowPrice = parseFloat(document.getElementById("submit_bid").dataset.buyNow);

    // ✅ Patikriname, ar aukcionas jau parduotas
    if (await auctionState.checkAuctionStatus(auctionId)) {
        console.warn("🛑 Aukcionas jau parduotas. Bid negali būti priimtas.");
        showNotification("Auction is already sold. You can't bid.", "error");
        return;
    }

    try {
        const response = await fetch(ajaxurl, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({
                action: "live_bid",
                security: nonce,
                auction_id: auctionId,
                bid_amount: bidAmount,
            }),
        });

        const data = await response.json();
        bidAmount = parseFloat(bidAmount);

        if (data.success) {
            showNotification(data.data.message, "success");

            // ✅ Atnaujiname bids sąrašą
            fetchBids(auctionId).then(bids => {
                console.log("🔄 Gavome naujus bids iš API:", bids);
                updateBids(document.getElementById("bid_list"), bids);
            });

            // ✅ Jei bid pasiekia Buy Now kainą, stabdome aukcioną
            if (bidAmount >= buyNowPrice) {
                auctionState.markAsSold();
            }
        } else {
            showNotification(data.data.message, "error");
        }
    } catch (error) {
        console.error("Klaida:", error);
        showNotification("Įvyko klaida. Bandykite dar kartą.", "error");
    }
}
