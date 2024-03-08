import axios from "axios";
import state from "../../state";

export default {
    /**
     * @returns {Promise<unknown>}
     */
    getPages({commit}, type) {
        return new Promise((resolve) => {
            let page_type = '';
            if(type){
                page_type = '/' + type
            }


            axios({url: state.API_URL + '/auth/pages' + page_type, method: 'GET'})
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    getPage({commit}, payload) {
        let params = '/' + payload.type;
        if(payload.page_id && payload.language_id){
            params = params + '/' + payload.page_id + '/' + payload.language_id
        }

        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/auth/pages/page' + params, method: 'GET'})
                .then(({data}) => {
                    resolve(data);
                }).catch(({response}) => {
                reject(response.data);
            });
        })
    },

    /**
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    savePage({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/auth/pages/save-page', data: payload, method: 'POST'})
                .then(({data}) => {
                    resolve(data);
                }).catch(({response}) => {
                    reject(response.data);
                });
        })
    },

    /**
     * @param commit
     * @param id
     * @returns {Promise<unknown>}
     */
    deletePage({commit}, id) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/auth/pages/delete/' + id, method: 'DELETE'})
                .then(({data}) => {
                    resolve(data);
                }).catch(({response}) => {
                    reject(response.data);
                });
        })
    },
};
