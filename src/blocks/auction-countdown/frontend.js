import { calculateTimeLeft, formatTimeLeft } from "./countdown.js";
import { closeAuction } from "./api.js";
import auctionState from "../../shared/auction-state.js"; 

export function updateCountdown() {
    const auctionElement = document.querySelector("#auction-time");
    if (!auctionElement) return;

    let endTime = auctionElement.dataset.endTime;
    if (!endTime) {
        console.error("❌ Klaida: `data-endTime` nėra nustatytas!");
        return;
    }

    endTime = new Date(endTime).getTime();
    if (isNaN(endTime)) {
        console.error("❌ Klaida: `endTime` neteisingas po konvertavimo!", endTime);
        return;
    }

    const timeLeft = calculateTimeLeft(endTime);
    if (isNaN(timeLeft) || timeLeft <= 0) {
        console.log("🛑 Aukciono laikas baigtas!");
        auctionState.stopCountdown();
        auctionElement.innerHTML = "Auction has ended.";
        closeAuction(auctionElement.dataset.auctionId, auctionElement);
        return;
    }
    auctionElement.innerHTML = formatTimeLeft(timeLeft);
}

document.addEventListener("DOMContentLoaded", function () {
    updateCountdown();
    const auctionId = document.querySelector("#auction-time")?.dataset.auctionId;
    const btn = document.querySelector("#submit_bid");
    if (!auctionId) {
        console.error("❌ Nerastas `auctionId`!");
        return;
    }
    auctionState.checkAuctionStatus(auctionId, updateCountdown);
});