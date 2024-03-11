import axios from "axios";
import state from "../../state";

export default {
    /**
     * @returns {Promise<unknown>}
     */
    getSubscribers({commit}, type) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/auth/subscribers', method: 'GET'})
                .then(({data}) => {
                    resolve(data);
                });
        })
    },
};
