document.addEventListener("alpine:init", () => {
    Alpine.data("timerComponent", (endTimeFromServer) => ({
        endTime: endTimeFromServer, // fourni par Symfony
        timeLeft: "--:--",
        interval: null,

        start() {
            if (!this.endTime) return; // évite de lancer si pas initialisé

            this.update();
            this.interval = setInterval(() => this.update(), 1000);
        },

        update() {
            const now = Date.now();
            const diff = Math.floor((this.endTime - now) / 1000);

            if (diff <= 0) {
                clearInterval(this.interval);
                this.timeLeft = "00:00";
                window.location.href = "/game-over";
                return;
            }

            const minutes = Math.floor(diff / 60);
            const seconds = diff % 60;
            this.timeLeft = `${String(minutes).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`;
        }
    }))
})