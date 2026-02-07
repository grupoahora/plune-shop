import { createPinia } from 'pinia';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { initializeTheme } from './composables/useAppearance';
import '../css/app.css';

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.mount('#app');

// This will set light / dark mode on page load...
initializeTheme();
