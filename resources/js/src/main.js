/*=========================================================================================
  File Name: main.js
  Description: main vue(js) file
==========================================================================================*/


import { createApp } from 'vue'

import App from './App.vue'
import router from './routes/router'
import store from './store/store'
import Axios from 'axios'

const app = createApp(App)

app.provide('$axios', Axios);
// Vue.prototype.$http = Axios;
const token = localStorage.getItem('access-token');
if (token) {
    Axios.defaults.headers.common['Authorization'] = token
}

import PrimeVue from 'primevue/config';

// import "primeflex/primeflex.css";
import "primevue/resources/themes/lara-light-blue/theme.css";
import "primevue/resources/primevue.min.css";
// import "primeicons/primeicons.css";

import ToastService from 'primevue/toastservice';

app.config.productionTip = false;

app.use(router)
    .use(store)
    .use(PrimeVue)
    .use(ToastService)
    .mount("#app");
