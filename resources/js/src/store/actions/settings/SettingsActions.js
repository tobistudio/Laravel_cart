import axios from "axios";
import state from "../../state";

export default {
    /**
     * @param commit
     * @returns {Promise<unknown>}
     */
    getSettings({commit}) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/auth/settings', method: 'GET'})
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    toggleMaintenance({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/auth/settings/toggle-maintenance', data: payload, method: 'POST'})
                .then(() => {
                    resolve();
                });
        })
    },

    /**
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    saveStoreInformation({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/auth/settings/save-store-information', data: payload, method: 'POST'})
                .then(() => {
                    resolve();
                });
        })
    }
};
