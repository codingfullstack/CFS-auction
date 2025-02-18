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
        this.markAsSold(); // ✅ Pažymime, kad aukcionas baigtas
        return true;
      } else if (data.status === "open") {
        console.log("✅ Aukcionas atidarytas! Paleidžiame laikmatį.");
        this.startCountdown(updateCountdown, auctionId); // ✅ Pradedame laikmatį
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

  startCountdown(updateCountdown, auctionId) {
    if (this.isSold || this.countdownInterval !== null) {
      console.log("⚠️ Aukcionas jau baigtas arba laikmatis jau veikia.");
      return;
    }
    this.countdownInterval = setInterval(updateCountdown, 1000);
    console.log("✅ Intervalas paleistas:", this.countdownInterval);
  },

  stopCountdown() {
    const auctionElement = document.querySelector("#auction-time");
    if (this.countdownInterval) {
      clearInterval(this.countdownInterval);
    } else {
      auctionElement.innerHTML = "Auction has ended. SOLD";
    }
    this.countdownInterval = null;
    this.isSold = true;
  },
};

// ✅ Užtikriname, kad tas pats objektas būtų naudojamas visur
window.__auctionStateSingleton = auctionState;

export default auctionState;
