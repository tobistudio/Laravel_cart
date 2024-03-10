import axios from 'axios';

const cartActions = {
    addToCart({ commit }, { productId, quantity }) {
        axios.post('/api/cart/add', {
            product_id: productId,
            qty: quantity
        })
            .then(response => {
                commit('ADD_TO_CART', { productId, quantity });
            })
            .catch(error => {
                console.error(error);
            });
    },

    fetchCartItems({ commit }) {
        axios.get('/api/cart/items')
            .then(response => {
                commit('SET_CART_ITEMS', response.data.cart_items);
            })
            .catch(error => {
                console.error(error);
            });
    },

    increaseQuantity({ commit }, { productId }) {
        axios.post('/api/cart/increase', { product_id: productId, qty: 1 })
            .then(response => {
                commit('INCREMENT_QUANTITY', { productId, qty: 1 });
            })
            .catch(error => {
                console.error(error);
            });
    },
    decreaseQuantity({ commit }, { productId }) {
        axios.post('/api/cart/decrease', { product_id: productId, qty: 1 })
            .then(response => {
                commit('DECREMENT_QUANTITY', { productId, qty: -1 });
            })
            .catch(error => {
                console.error(error);
            });
    },


    removeProduct({ commit }, { productId }) {
        axios.post('/api/cart/remove', { product_id: productId })
            .then(response => {
                commit('REMOVE_PRODUCT', productId);
            })
            .catch(error => {
                console.error(error);
                // Handle error, e.g., commit an error state or show an error message
            });
    },

    updateQuantity({ commit }, { productId, quantity }) {
        axios.post('/api/cart/update', { product_id: productId, qty: quantity })
            .then(response => {
                commit('SET_QUANTITY', { productId, qty: quantity });
            })
            .catch(error => {
                console.error(error);
            });
    }

};

export default cartActions;
