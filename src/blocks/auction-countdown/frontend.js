document.addEventListener("DOMContentLoaded", function () {
  const countdownElement = document.querySelector("#auction-time");

  // Patikriname, ar yra reikiamas elementas
  if (!countdownElement) {
    return;
  }
  const auctionStartTime = countdownElement.dataset.startTime;
  const auctionEndTime = countdownElement.dataset.endTime;
  const auctionId = countdownElement.dataset.auctionId;
  const auctionEndMessage =
    countdownElement.dataset.endMessage || "Auction has ended";

  if (auctionStartTime && auctionEndTime) {
    const startTime = new Date(auctionStartTime).getTime();
    const endTime = new Date(auctionEndTime).getTime();

    const now = new Date().getTime();
    if (now < startTime) {
      countdownElement.innerHTML = "Auction will start soon!";
      return;
    }
    let timeLeft = endTime - now;

    function updateCountdown() {
      const now = new Date().getTime();
      let timeLeft = endTime - now;
      if (timeLeft <= 0) {
        countdownElement.innerHTML = auctionEndMessage;
        fetch(`/wp-json/auction/v1/close-auction/${auctionId}`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            auction_id: auctionId,
          }),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              console.log('Aukciono statusas buvo atnaujintas į "closed".');
            }
            //  else {
            //   console.error("Klaida atnaujinant aukciono statusą");
            // }
          })
          .catch((error) => console.error("Klaida siunčiant užklausą:", error));
      } else {
        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor(
          (timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        countdownElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
      }
    }
    if (timeLeft > 0) {
      setInterval(updateCountdown, 1000);
    }
    updateCountdown();
  }
});
