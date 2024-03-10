/*=========================================================================================
  File Name: store.js
  Description: Vuex store
==========================================================================================*/


import { createStore } from "vuex";

import state from "./state";
import actions from "./actions/actions.js";

const mutations = {
    SET_CART_ITEMS(state, cartItems) {
        state.cartItems = cartItems.map(item => ({
            productId: item.product_id,
            name: item.name,
            image: item.image,
            slug: item.slug,
            sku: item.sku,
            price: item.price,
            specialPrice: item.special_price,
            manufacturer: item.manufacturer,
            quantity: item.quantity
        }));
    },

    INCREMENT_QUANTITY(state, { productId }) {
        const itemIndex = state.cartItems.findIndex(item => item.productId === productId);
        if (itemIndex !== -1) {
            state.cartItems[itemIndex].quantity++;
        }
    },

    DECREMENT_QUANTITY(state, { productId }) {
        const itemIndex = state.cartItems.findIndex(item => item.productId === productId);
        if (itemIndex !== -1 && state.cartItems[itemIndex].quantity > 1) {
            state.cartItems[itemIndex].quantity--;
        }
    },

    REMOVE_PRODUCT(state, productId) {
        state.cartItems = state.cartItems.filter(item => item.productId !== productId);
    },

    SET_QUANTITY(state, { productId, qty }) {
        const itemIndex = state.cartItems.findIndex(item => item.productId === productId);
        if (itemIndex !== -1) {
            state.cartItems[itemIndex].quantity = qty;
        }
    }
};

const store = createStore({
    state,
    actions,
    mutations,
    // plugins: [createPersistedState()],
    strict: false
});

export default store;

