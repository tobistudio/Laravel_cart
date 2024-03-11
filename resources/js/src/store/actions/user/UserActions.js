import axios from "axios";
import state from "../../state";

export default {
    /**
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    user({commit}) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/auth/user', method: 'GET'})
                .then(({data}) => {
                    state.user = data.user;

                    state.sidebar_menu = data.sidebar_menu;

                    resolve(data);
                })
                .catch(({response}) => {
                    reject(response.data);
            });
        })
    },

    /**
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    changeTheme({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/auth/user/change-theme', data: payload, method: 'POST'})
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
    toggleSidebar({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/auth/user/toggle-sidebar', data: payload, method: 'POST'})
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    getUsers() {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/auth/users', method: 'GET'})
                .then(({data}) => {
                    resolve(data);
                });
        })
    },
};
