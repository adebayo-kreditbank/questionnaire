import './bootstrap';

import { createApp } from 'vue';
import App from './components/views/App.vue'
import router from './router/index.js'
// import store from './store/index.js'
import Vuex from 'vuex';

const store = new Vuex.Store()

createApp(App)
    .use(router)
    .use(Vuex)
    .use(store)
    .mount("#app")