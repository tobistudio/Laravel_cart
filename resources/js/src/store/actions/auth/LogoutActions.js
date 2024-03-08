import axios from "axios";
import state from "../../state";

export default {
    /**
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    logout({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/auth/logout', method: 'GET'})
                .then(({data}) => {
                    localStorage.removeItem('access-token');
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
