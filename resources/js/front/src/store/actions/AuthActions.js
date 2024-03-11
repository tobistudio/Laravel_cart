import axios from "axios";
import state from "../state";

export default {
    /**
     *
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    customerRegister({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/customer-register', data: payload, method: 'POST'})
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
    customerLogin({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/customer-login', data: payload, method: 'POST'})
                .then(({data}) => {
                    if (data.access_token) {
                        const auth_data = {
                            token: data.token_type + ' ' + data.access_token,
                            user_id: data.user.id,
                        };

                        localStorage.setItem('customer-access-token', auth_data.token);
                        axios.defaults.headers.common['Authorization'] = auth_data.token;

                        state.token = data.access_token;
                        state.user = data.user;

                        state.error_message = false;
                        state.success_message = data.message;
                        state.message_type = data.message_type ? data.message_type : 'login';

                        resolve(data);
                    } else {
                        resolve(data);
                    }
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
    customerRemindPassword({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/customer-remind-password', data: payload, method: 'POST'})
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
    customerResetPassword({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/customer-reset-password', data: payload, method: 'POST'})
                .then(({data}) => {
                    resolve(data);
                }).catch(({response}) => {
                reject(response.data);
            });
        })
    },
};
