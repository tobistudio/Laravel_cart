import axios from "axios";
import state from "../state";

export default {
    /**
     *
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    getCompareList({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/product-comparison/' + payload.locale + '/' + payload.id, method: 'GET'})
                .then(({data}) => {
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
    addToCompare({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/product-comparison/save', data: payload, method: 'POST'}).then(({data}) => {
                if(!data.comparing || !data.comparing.id || !data.comparing.products){
                    localStorage.removeItem('active-product-comparing');
                    state.activeProductComparing = data.comparing;
                } else {
                    localStorage.setItem('active-product-comparing', JSON.stringify(data.comparing));
                    state.activeProductComparing = null;
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
    removeProductFromProductCompare({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/product-comparison/remove/' + payload.locale + '/' + payload.id + '/' + payload.product_id, method: 'DELETE'})
                .then(({data}) => {
                    if(!data.comparing || !data.comparing.id || !data.comparing.products){
                        localStorage.removeItem('active-product-comparing');
                        state.activeProductComparing = null;
                    } else {
                        localStorage.setItem('active-product-comparing', JSON.stringify(data.comparing));
                        state.activeProductComparing = data.comparing;
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
    deleteProductCompare({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/product-comparison/remove/' + payload.id, method: 'DELETE'})
                .then(({data}) => {
                    localStorage.removeItem('active-product-comparing');
                    state.activeProductComparing = data.comparing;

                    resolve(data);
                });
        })
    },
};
