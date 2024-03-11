import axios from "axios";
import state from "../../state";

export default {
    /**
     * @param commit
     * @returns {Promise<unknown>}
     */
    getLanguages({commit}) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/auth/settings/languages', method: 'GET'})
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    saveLanguage({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/auth/settings/languages/save', data: payload, method: 'POST'})
                .then(({data}) => {
                    resolve(data);
                }).catch(({response}) => {
                    reject(response.data);
                });
        })
    },
};
