import axios from "axios";
import state from "../state";

export default {
    /**
     *
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    sendMessage({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/send-message', data: payload, method: 'POST'})
                .then(({data}) => {
                    resolve(data);
                }).catch(({response}) => {
                    reject(response.data);
                });
        })
    },
};
