import axios from "axios";
import state from "../state";

export default {
    /**
     *
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    getCart({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/cart/' + payload.locale + '/' + payload.id, method: 'GET'})
                .then(({data}) => {
                    state.activeCart = data.cart;

                    resolve(data);
                });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    addToCart({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/cart/save', data: payload, method: 'POST'}).then(({data}) => {
                console.log(data);
                if(!data.cart || !data.cart.id || !data.cart.products){
                    localStorage.removeItem('active-cart-id');
                    state.activeCartId = null;
                    state.activeCart = null;
                } else {
                    localStorage.setItem('active-cart-id', data.cart.id);
                    state.activeCartId = data.cart.id;
                    state.activeCart = data.cart;
                }

                resolve(data);
            });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    updateCartProductQuantity({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/cart/update', data: payload, method: 'POST'}).then(({data}) => {
                state.activeCart = data.cart;

                resolve(data);
            });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    removeFromCart({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/cart/remove/' + payload.locale + '/' + payload.id + '/' + payload.product_id, data: payload, method: 'DELETE'}).then(({data}) => {
                if(!data.cart || !data.cart.id || !data.cart.products){
                    localStorage.removeItem('active-cart-id');
                    state.activeCartId = null;
                    state.activeCart = null;
                } else {
                    localStorage.setItem('active-cart-id', data.cart.id);
                    state.activeCartId = data.cart.id;
                    state.activeCart = data.cart;
                }

                resolve(data);
            });
        })
    },
};
