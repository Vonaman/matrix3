import Alpine from 'alpinejs';

import './bootstrap.js';
import './js/login';
import './js/timer.js';
import './js/popUpAgent.js';
import './js/matrixRain';
import './styles/app.css';

window.Alpine = Alpine;
Alpine.start();

// Récupération sûre de la donnée injectée par Twig
const innocents = (typeof window !== 'undefined' && Array.isArray(window.APP?.innocents))
    ? window.APP.innocents
    : [];
// Maintenant on peut l'utiliser partout
if (innocents.length > 1) {
    const agent = innocents[1];
    console.log(`/* ${agent.name} n'est pas dangereux. */`);
} else {
    console.log('nop');
}