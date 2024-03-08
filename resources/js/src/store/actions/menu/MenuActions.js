import axios from "axios";
import state from "../../state";

export default {
    /**
     * @param commit
     * @returns {Promise<unknown>}
     */
    getMenus({commit}) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/auth/menus', method: 'GET'})
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     *
     * @param commit
     * @param id
     * @returns {Promise<unknown>}
     */
    getMenu({commit}, id) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/auth/menus/' + id, method: 'GET'})
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
    saveMenu({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/auth/menus/save', data: payload, method: 'POST'})
                .then(({data}) => {
                    resolve(data);
                }).catch(({response}) => {
                reject(response.data);
            });
        })
    },
};
