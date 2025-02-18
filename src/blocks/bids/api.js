export async function fetchBids(auctionId) {
    if (typeof auctionId !== "string" || auctionId <= 0) {
        console.error("❌ Netinkamas auctionId:", auctionId);
        return [];
    }

    const apiUrl = `/wp-json/auction/v1/bids/${auctionId}`;
    try {
        const response = await fetch(apiUrl);
        if (!response.ok) throw new Error(`Klaida: ${response.status}`);

        const data = await response.json();
        

        return Array.isArray(data) ? data : []; // 🔥 Užtikriname, kad grąžiname masyvą
    } catch (error) {
        console.error("Klaida gaunant pasiūlymus:", error);
        return [];
    }
}
