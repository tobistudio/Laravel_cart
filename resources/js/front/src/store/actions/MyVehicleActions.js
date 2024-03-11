import axios from "axios";
import state from "../state";

export default {
    /**
     *
     * @param commit
     * @param local
     * @returns {Promise<unknown>}
     */
    getMyVehicles({commit}, local) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/my-vehicles/' + local, method: 'GET'})
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    addMyVehicle({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/my-vehicles/add', data: payload, method: 'POST'})
                .then(({data}) => {
                    resolve(data);
                });
        })
    },

    /**
     *
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    setMyVehicleActive({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/my-vehicles/set-active', data: payload, method: 'POST'})
                .then(({}) => {
                    resolve();
                });
        })
    },

    /**
     *
     * @param commit
     * @param id
     * @returns {Promise<unknown>}
     */
    removeMyVehicle({commit}, id) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/my-vehicles/remove/' + id, method: 'DELETE'})
                .then(({}) => {
                    resolve();
                });
        })
    },
};
