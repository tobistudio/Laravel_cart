import axios from "axios";
import state from "../state";

export default {
    /**
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    customer({commit}) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/auth/customer', method: 'GET'})
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
     *
     * @returns {Promise<unknown>}
     */
    getAccountInformation() {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/account-information', method: 'GET'})
                .then(({data}) => {
                    resolve(data);
                })
                .catch(({response}) => {
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
    saveAccountInformation({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/account-information/save', data: payload, method: 'POST'})
                .then(({data}) => {
                    resolve(data);
                })
                .catch(({response}) => {
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
    changePassword({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/account-information/change-password', data: payload, method: 'POST'})
                .then(({data}) => {
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
    customerLogout({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/auth/customer-logout', method: 'GET'})
                .then(({data}) => {
                    localStorage.removeItem('customer-access-token');
                    delete axios.defaults.headers.common['Authorization'];

                    state.token = '';

                    state.error_message = false;
                    state.success_message = data.message;
                    state.message_type = data.message_type ? data.message_type : 'login';

                    resolve(data);
                });
        })
    },
};
