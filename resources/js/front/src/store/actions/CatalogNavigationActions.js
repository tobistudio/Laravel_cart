import axios from "axios";
import state from "../state";

export default {
    /**
     *
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    getProductCategories({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/product-categories/' + payload.locale, method: 'GET'})
                .then(({data}) => {
                    resolve(data);
                });
        })
    },
};
