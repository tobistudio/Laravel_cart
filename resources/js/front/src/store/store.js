/*=========================================================================================
  File Name: store.js
  Description: Vuex store
==========================================================================================*/


import { createStore } from "vuex";

import state from "./state";
import { actions, getters } from "./actions/actions.js";

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
    },

    ADD_TO_COMPARISON(state, product) {
        if (state.comparisonList.length < 3 && !state.comparisonList.find(p => p.id === product.id)) {
            state.comparisonList.push(product);
        }
    },

    REMOVE_FROM_COMPARISON(state, productId) {
        const index = state.comparisonList.findIndex(item => item.id === productId);
        if (index !== -1) {
            state.comparisonList.splice(index, 1);
        }
    },

    CLEAR_COMPARISON_LIST(state) {
        state.comparisonList = [];
    },
};

const store = createStore({
    state,
    actions,
    mutations,
    getters,
    // plugins: [createPersistedState()],
    strict: false
});

export default store;

