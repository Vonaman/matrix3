const innocents = window.APP?.innocents || [];

import Alpine from 'alpinejs';


import './bootstrap.js';
import './js/login';
import './js/timer.js';
import './js/popUpAgent.js';

import './styles/app.css';

window.Alpine = Alpine;
Alpine.start();

if (innocents.length > 1) {
    const agent = innocents[1];
    console.log(`/* ${agent.name} n'est pas dangereux. */`);
} else{
    console.log('nop')
}