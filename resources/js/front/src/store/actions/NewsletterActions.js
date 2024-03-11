import axios from "axios";
import state from "../state";

export default {
    /**
     *
     * @param commit
     * @returns {Promise<unknown>}
     */
    getSubscription({commit}) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/subscriptions', method: 'GET'})
                .then(({data}) => {
                    resolve(data);
                }).catch(({response}) => {
                reject(response.data);
            });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    saveSubscriptions({commit}, payload) {
        return new Promise(() => {
            axios({url: state.API_URL + '/subscriptions/save', data: payload, method: 'POST'});
        })
    }
};
