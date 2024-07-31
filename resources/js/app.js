import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


import { createApp } from 'vue';
import PriceCounter from './components/PriceCounter.vue';

createApp({})
    .component('PriceCounter', PriceCounter)
    .mount('#app')