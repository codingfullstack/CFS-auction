export async function updateAuctionStatus(auctionId, statusElement) {
    try {
        const response = await fetch(`/wp-json/auction/v1/status/${auctionId}`);
        if (!response.ok) throw new Error(`Server error: ${response.status}`);
        
        const data = await response.json();
        if (data.status && statusElement.textContent !== data.status) {
            statusElement.textContent = data.status;
        }
    } catch (error) {
        console.error("Klaida tikrinant aukciono būseną:", error);
    }
}
