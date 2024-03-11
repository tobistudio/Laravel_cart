/*=========================================================================================
  File Name: store.js
  Description: Vuex store
==========================================================================================*/


import { createStore } from "vuex";

import state from "./state"
import getters from "./getters.js";
import actions from "./actions/actions.js";


const store = createStore({
    getters,
    state,
    actions,
    // plugins: [createPersistedState()],
    strict: false
})

export default store;
