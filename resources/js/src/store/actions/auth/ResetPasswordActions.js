import axios from "axios";
import state from "../../state";

export default {
    /**
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    getResetPassword({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/reset-password/' + payload.token, method: 'GET'})
                .then(({data}) => {
                    state.error_message = false;
                    state.success_message = data.message;
                    state.message_type = data.message_type ? data.message_type : 'reset_passwords';

                    resolve(data);
                }).catch(({response}) => {
                if(response.data.message){
                    state.error_message = response.data.message;
                    state.success_message = false;
                    state.message_type = response.data.message_type ? response.data.message_type : 'reset_passwords';
                }

                reject(response.data);
            })
        });
    },

    /**
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    resetPassword({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/reset-password', data: payload, method: 'POST'})
                .then(({data}) => {

                    state.error_message = false;
                    state.success_message = data.message;
                    state.message_type = data.message_type ? data.message_type : 'reset_passwords';

                    resolve(data);
                }).catch(({response}) => {
                if(response.data.message){
                    state.error_message = response.data.message;
                    state.success_message = false;
                    state.message_type = response.data.message_type ? response.data.message_type : 'reset_passwords';
                }

                reject(response.data);
            })
        });
    },
};
