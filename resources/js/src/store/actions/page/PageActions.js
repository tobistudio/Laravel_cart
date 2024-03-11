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

    /**
     *
     * @param commit
     * @param payload
     * @return {Promise<unknown>}
     */
    getGalleryImages({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/page/gallery/get/${payload.page_id}`, method: 'GET' })
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @return {Promise<unknown>}
     */
    addGalleryImage({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/page/gallery/create/${payload.page_id}`, method: 'POST', data: payload })
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @return {Promise<unknown>}
     */
    updateGalleryImages({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/page/gallery/update/${payload.page_id}`, method: 'POST', data: payload })
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @return {Promise<unknown>}
     */
    deleteGalleryImage({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/page/gallery/delete/${payload.page_id}/${payload.id}`, method: 'GET' })
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @return {Promise<unknown>}
     */
    getDownloadFiles({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/page/downloads/get/${payload.language_id}/${payload.page_id}`, method: 'GET' })
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @return {Promise<unknown>}
     */
    addDownloadFile({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/page/downloads/create/${payload.page_id}`, method: 'POST', data: payload })
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @return {Promise<unknown>}
     */
    updateDownloadFiles({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/page/downloads/update/${payload.language_id}/${payload.page_id}`, method: 'POST', data: payload })
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @return {Promise<unknown>}
     */
    deleteDownloadFile({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/page/downloads/delete/${payload.page_id}/${payload.id}`, method: 'GET' })
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @return {Promise<unknown>}
     */
    getProducts({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/page/products/get/${payload.language_id}/${payload.page_id}`, method: 'GET' })
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @return {Promise<unknown>}
     */
    getProductRelations({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/page/relations/get/${payload.page_id}/${payload.language_id}/${payload.type}`, method: 'GET' })
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @return {Promise<unknown>}
     */
    createProductRelation({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/page/relations/create/${payload.page_id}`, method: 'POST', data: payload })
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @return {Promise<unknown>}
     */
    deleteProductRelation({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/page/relations/delete/${payload.page_id}/${payload.related_product_id}`, method: 'GET' })
                .then(({data}) => {
                    resolve(data);
                });
        })
    }
};
