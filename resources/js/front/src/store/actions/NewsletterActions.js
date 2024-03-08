import axios from "axios";
import state from "../state";

export default {
    subscribe({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/subscribe', data: payload, method: 'POST'})
                .then(({data}) => {
                    resolve(data);
                }).catch(({response}) => {
                    reject(response.data);
                });
        })
    },
};
