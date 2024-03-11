/*=========================================================================================
  File Name: main.js
  Description: main vue(js) file
==========================================================================================*/

import { createApp } from 'vue/dist/vue.esm-bundler';

import store from './store/store'
import Axios from "axios";

import PageLink from './components/PageLink.vue';

import Compare from './components/Compare.vue';
import HeaderAuth from './components/HeaderAuth.vue';
import HeaderSearch from './components/HeaderSearch.vue';
import HeaderSearchMobile from './components/HeaderSearchMobile.vue';
import HeaderMiniCart from './components/HeaderMiniCart.vue';
import HeaderMyCars from './components/HeaderMyCars.vue';
import HeaderCatalogButton from './components/HeaderCatalogButton.vue';
import AuthPopup from './components/AuthPopup.vue';
import CatalogNavigation from './components/CatalogNavigation.vue';
import ContactForm from './components/ContactForm.vue';
import Download from './components/Download.vue';
import Newsletter from './components/Newsletter.vue';
import ChooseVehicle from './components/ChooseVehicle.vue';
import HeroVehicleSearch from './components/HeroVehicleSearch.vue';

import ProductCategory from './components/ProductCategory.vue';
import Product from './components/Product.vue';

import ProductCompare from './components/ProductCompare.vue';
import Cart from './components/Cart.vue';
import Checkout from './components/Checkout.vue';

import Profile from './components/Profile.vue';

import PurchaseMade from './components/PurchaseMade.vue';

const app = createApp({
    components: {
        PageLink,

        Compare,
        HeaderAuth,
        HeaderSearch,
        HeaderSearchMobile,
        HeaderMiniCart,
        HeaderMyCars,
        HeaderCatalogButton,
        AuthPopup,
        CatalogNavigation,
        ContactForm,
        Download,
        Newsletter,
        ChooseVehicle,
        HeroVehicleSearch,

        ProductCategory,
        Product,

        ProductCompare,
        Cart,
        Checkout,

        Profile,

        PurchaseMade
    }
});

app.provide('$axios', Axios);

// Vue.prototype.$http = Axios;
const token = localStorage.getItem('customer-access-token');
if (token) {
    Axios.defaults.headers.common['Authorization'] = token
}

app.use(store).mount('#app');
