/*=========================================================================================
  File Name: main.js
  Description: main vue(js) file
==========================================================================================*/

import { createApp } from 'vue/dist/vue.esm-bundler';

import store from './store/store'
import Axios from "axios";

import HeaderAuth from './components/HeaderAuth.vue';
import HeaderSearch from './components/HeaderSearch.vue';
import HeaderSearchMobile from './components/HeaderSearchMobile.vue';
import HeaderMiniCart from './components/HeaderMiniCart.vue';
import HeaderMyCars from './components/HeaderMyCars.vue';
import AuthPopup from './components/AuthPopup.vue';
import Newsletter from './components/Newsletter.vue';

const app = createApp({
    components: {
        HeaderAuth,
        HeaderSearch,
        HeaderSearchMobile,
        HeaderMiniCart,
        HeaderMyCars,
        AuthPopup,
        Newsletter,
    }
});

app.provide('$axios', Axios);

// Vue.prototype.$http = Axios;
const token = localStorage.getItem('access-token');
if (token) {
    Axios.defaults.headers.common['Authorization'] = token
}

app.use(store).mount('#app');
