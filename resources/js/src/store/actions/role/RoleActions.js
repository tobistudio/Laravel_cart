import axios from "axios";
import state from "../../state";

export default {
    getRoles() {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/auth/roles', method: 'GET'})
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    getRole({commit}, id) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/auth/roles/' + id, method: 'GET'})
                .then(({data}) => {
                    resolve(data);
                }).catch(({response}) => {
                    reject(response.data);
                });
        })
    },

    savePermission({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/auth/roles/save-permission', data: payload, method: 'POST'})
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    saveRole({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/auth/roles/save-role', data: payload, method: 'POST'})
                .then(({data}) => {
                    resolve(data);
                }).catch(({response}) => {
                    reject(response.data);
                });
        })
    },

    deleteRole({commit}, id) {
        return new Promise((resolve, reject) => {
            axios({url: state.API_URL + '/auth/roles/delete/' + id, method: 'DELETE'})
                .then(({data}) => {
                    resolve(data);
                }).catch(({response}) => {
                    reject(response.data);
                });
        })
    },
};
