import { updateAuctionStatus } from "./status.js";

document.addEventListener("DOMContentLoaded", async function () {
    const auctionDetails = document.querySelector(".auction-details");
    if (!auctionDetails) return;

    const auctionId = auctionDetails.dataset.auctionId;
    const statusElement = auctionDetails.querySelector(".auction-status");
    if (!auctionId || !statusElement) return;

    async function refreshAuctionStatus() {
        await updateAuctionStatus(auctionId, statusElement);
    }

    // ✅ Apsauga nuo kelių `setInterval()`: sustabdome esamą prieš kuriant naują
    if (window.auctionStatusInterval) {
        clearInterval(window.auctionStatusInterval);
    }

    // ✅ Išsaugome intervalą globaliame kintamajame
    window.auctionStatusInterval = setInterval(refreshAuctionStatus, 5000);

    // ✅ Paleidžiame iškart vieną kartą
    refreshAuctionStatus();
});
