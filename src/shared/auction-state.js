const auctionState = window.__auctionStateSingleton || {
  countdownInterval: null,
  isSold: false,

  async checkAuctionStatus(auctionId, updateCountdown) {
    try {
      const response = await fetch(`/wp-json/auction/v1/status/${auctionId}`);
      if (!response.ok) throw new Error(`Server error: ${response.status}`);

      const data = await response.json();
      console.log("🔍 Aukciono statusas iš API:", data.status);

      if (data.status === "sold") {
        this.markAsSold();
        return true;
      } else if (data.status === "open") {
        console.log("✅ Aukcionas atidarytas! Paleidžiame laikmatį.");
        this.startCountdown(updateCountdown);
        return false;
      } else {
        console.warn("⚠️ Nepalaikomas aukciono statusas:", data.status);
        return false;
      }
    } catch (error) {
      console.error("⚠️ Klaida tikrinant aukciono būseną:", error);
      return false;
    }
  },

  markAsSold() {
    if (!this.isSold) {
      this.isSold = true;
      this.stopCountdown();
      console.log("✅ Aukcionas pažymėtas kaip parduotas.");
    }
  },

  startCountdown(updateCountdown) {
    if (this.isSold) {
      console.log("⛔ Aukcionas jau baigtas – laikmatis nepaleistas.");
      return;
    }

    if (this.countdownInterval !== null) {
      console.log("⚠️ Laikmatis jau veikia.");
      return;
    }

    this.countdownInterval = setInterval(updateCountdown, 1000);
    console.log("✅ Laikmatis paleistas:", this.countdownInterval);
  },

  stopCountdown() {
    const auctionElement = document.querySelector("#auction-time");

    if (this.countdownInterval) {
      clearInterval(this.countdownInterval);
      console.log("🛑 Laikmatis sustabdytas.");
    }

    if (auctionElement) {
      auctionElement.innerHTML = "Auction has ended. SOLD";
    }

    this.countdownInterval = null;
    this.isSold = true;
  },
};

// ✅ Užtikriname, kad singletonas išliktų
window.__auctionStateSingleton = auctionState;

export default auctionState;
