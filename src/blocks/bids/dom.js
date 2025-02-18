export function updateBids(bidList, bids) {
    if (!bidList) {
        console.error("❌ Klaida: `bidList` yra `null` arba `undefined`!");
        return;
    }
    if (!(bidList instanceof HTMLElement)) {
        console.error("❌ Klaida: `bidList` nėra HTML elementas!", bidList);
        return;
    }
    if (!Array.isArray(bids)) {
        console.error("❌ Klaida: `bids` nėra masyvas! Gavome:", bids);
        return;
    }
    const existingBidIds = new Set([...bidList.children].map(li => li.dataset.id));
    const newBidIds = new Set(bids.map(bid => bid.id.toString()));

    bids.forEach(bid => {
        const bidId = bid.id.toString();
        if (!existingBidIds.has(bidId)) {
            const listItem = document.createElement("li");
            listItem.textContent = `${bid.bid_amount} EUR`;
            listItem.dataset.id = bidId;
            bidList.prepend(listItem);
        }
    });

    [...bidList.children].forEach(listItem => {
        if (!newBidIds.has(listItem.dataset.id)) {
            listItem.remove();
        }
    });
}
