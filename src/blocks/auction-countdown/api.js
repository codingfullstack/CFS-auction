export function closeAuction(auctionId, endMessageElement) {
    fetch(`/wp-json/auction/v1/close-auction/${auctionId}`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ auction_id: auctionId }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            endMessageElement.innerHTML = "Auction closed successfully.";
        }
    })
    .catch(error => console.error("Klaida siunčiant užklausą:", error));
}
