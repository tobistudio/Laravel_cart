import axios from 'axios';
import state from '../state';

export default {
    getCategoryProducts({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + `/category-products/${payload.locale}/${payload.page_id}${payload.filters ? '?filters=' + payload.filters : ''}`, method: 'GET'})
                .then(({data}) => {
                    resolve(data);
                });
        })
    }
}
