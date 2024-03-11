import axios from "axios";
import state from "../../state";

export default {
    /**
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    login({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/login', data: payload.userData, method: 'POST'})
                .then(({data}) => {
                    if (data.access_token) {
                        const auth_data = {
                            token: data.token_type + ' ' + data.access_token,
                            user_id: data.user.id,
                        };

                        localStorage.setItem('access-token', auth_data.token);
                        axios.defaults.headers.common['Authorization'] = auth_data.token;
                        localStorage.setItem('user_id', auth_data.user_id);

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
                localStorage.removeItem('access-token');
                localStorage.removeItem('user_id');

                state.error_message = response.data.message;
                state.success_message = false;
                state.message_type = response.data.message_type ? response.data.message_type : 'login';

                reject(response.data);
            });
        })
    },
};
