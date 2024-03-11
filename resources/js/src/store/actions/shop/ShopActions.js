import axios from "axios";
import state from "../../state";


export default {
    /**
     * @returns {Promise<unknown>}
     */
    getAttributes({commit},) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + '/shop/attributes/get', method: 'GET' })
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
    addAttribute({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + '/shop/attributes/save', method: 'POST', data: payload })
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
    deleteAttribute({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/shop/attributes/delete/${payload}`, method: 'GET' })
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
    deleteAttributeValue({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/shop/attributes/delete/value/${payload}`, method: 'GET' })
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
    updateAttribute({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/shop/attributes/update/${payload.id}`, method: 'POST', data: payload })
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     *
     * @return {Promise<unknown>}
     */
    getWarehouses({commit}) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/shop/warehouses/get`, method: 'GET' })
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
    createWarehouse({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/shop/warehouses/create`, method: 'POST', data: payload })
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
    updateWarehouse({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/shop/warehouses/update/${payload.id}`, method: 'POST', data: payload })
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
    deleteWarehouse({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/shop/warehouses/delete/${payload}`, method: 'GET' })
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
    createWarehouseGroup({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/shop/warehouses/create/group`, method: 'POST', data: payload })
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
    updateWarehouseGroup({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/shop/warehouses/update/group/${payload.id}`, method: 'POST', data: payload.warehouses })
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
    deleteWarehouseGroup({commit}, payload) {
        return new Promise((resolve) => {
            axios({ url: state.API_URL + `/shop/warehouses/delete/group/${payload}`, method: 'GET' })
                .then(({data}) => {
                    resolve(data);
                });
        })
    }
}
