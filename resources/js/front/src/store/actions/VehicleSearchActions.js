import axios from "axios";
import state from "../state";

export default {
    /**
     *
     * @param commit
     * @param payload
     * @returns {Promise<unknown>}
     */
    getVehicle({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/vehicle-search/' + payload.brand_id + '/' + payload.year.from + '/' + payload.year.to, method: 'GET'})
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
    activeVehicle({commit}, payload) {
        return new Promise((resolve) => {
            axios({url: state.API_URL + '/active-vehicle', data: payload, method: 'POST'})
                .then(({data}) => {
                    if(!data.active_vehicle_id){
                        localStorage.removeItem('active-vehicle-id');
                        state.activeVehicleId = null;
                        state.activeVehicle = {processing: true};
                    } else if(!payload.active_vehicle_id || payload.active_vehicle_id !== data.active_vehicle_id) {
                        localStorage.setItem('active-vehicle-id', data.active_vehicle_id);
                        state.activeVehicleId = data.active_vehicle_id;
                    }

                    resolve(data);
                });
        })
    },
};
