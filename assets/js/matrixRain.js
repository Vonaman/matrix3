class MatrixRain {
    constructor() {
        this.canvas = document.getElementById('matrixRain');
        this.characters = 'アァカサタナハマヤャラワガザダバパイィキシチニヒミリヰギジヂビピウゥクスツヌフムユュルグズブヅプエェケセテネヘメレヱゲゼデベペオォコソトホモヨョロヲゴゾドボポヴッン0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        this.drops = [];
        this.init();
    }

    init() {
        // Créer les colonnes de caractères
        const numColumns = Math.floor(window.innerWidth / 20);
        
        for (let i = 0; i < numColumns; i++) {
            this.createDrop(i);
        }

        // Créer de nouveaux caractères périodiquement
        setInterval(() => {
            if (Math.random() < 0.1) {
                const column = Math.floor(Math.random() * numColumns);
                this.createDrop(column);
            }
        }, 100);

        // Nettoyer les anciens caractères
        setInterval(() => {
            this.cleanupDrops();
        }, 5000);
    }

    createDrop(column) {
        const char = document.createElement('div');
        char.className = 'matrix-char';
        char.textContent = this.characters[Math.floor(Math.random() * this.characters.length)];
        char.style.left = (column * 20) + 'px';
        char.style.fontSize = (Math.random() * 10 + 12) + 'px';
        char.style.animationDuration = (Math.random() * 3 + 2) + 's';
        char.style.animationDelay = Math.random() * 2 + 's';
        
        // Opacité variable pour créer un effet de profondeur
        char.style.opacity = Math.random() * 0.8 + 0.2;

        this.canvas.appendChild(char);
        this.drops.push(char);
    }

    cleanupDrops() {
        const oldDrops = this.drops.filter(drop => {
            const rect = drop.getBoundingClientRect();
            return rect.top > window.innerHeight;
        });

        oldDrops.forEach(drop => {
            if (drop.parentNode) {
                drop.parentNode.removeChild(drop);
            }
            const index = this.drops.indexOf(drop);
            if (index > -1) {
                this.drops.splice(index, 1);
            }
        });
    }
}

// Initialiser l'effet Matrix quand la page est chargée
document.addEventListener('DOMContentLoaded', () => {
    new MatrixRain();
});

// Gérer le redimensionnement de la fenêtre
window.addEventListener('resize', () => {
    const matrixRain = document.getElementById('matrixRain');
    matrixRain.innerHTML = '';
    new MatrixRain();
});