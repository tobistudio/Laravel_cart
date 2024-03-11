import axios from "axios";
import state from "../state";

export default {
    /**
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    countries({commit}) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/auth/countries', method: 'GET'})
                .then(({data}) => {
                    resolve(data);
                });
        })
    },
};
