export function calculateTimeLeft(endTime) {
    const now = new Date().getTime();
    const auctionEndTime = new Date(endTime).getTime();
    return auctionEndTime - now;
}

export function formatTimeLeft(timeLeft) {
    if (timeLeft <= 0) return "Auction has ended.";
    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
    return `${days}d ${hours}h ${minutes}m ${seconds}s`;
}
