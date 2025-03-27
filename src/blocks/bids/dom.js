export function updateBids(bidList, bids) {
    if (!bidList || !(bidList instanceof HTMLElement)) {
        console.error("❌ bidList nėra tinkamas HTML elementas");
        return;
    }

    if (!Array.isArray(bids)) {
        console.error("❌ bids nėra masyvas:", bids);
        return;
    }
    bids.sort((a, b) => Number(b.bid_amount) - Number(a.bid_amount));
    bidList.innerHTML = "";
    bids.forEach(bid => {
        const listItem = document.createElement("li");
        const amount = Number(bid.bid_amount).toFixed(2);

        listItem.textContent = `${amount} EUR`;
        listItem.dataset.id = bid.id.toString();

        bidList.appendChild(listItem);
    });
}
