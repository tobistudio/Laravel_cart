/*=========================================================================================
  File Name: store.js
  Description: Vuex store
==========================================================================================*/


import { createStore } from "vuex";

import state from "./state"
import getters from "./getters"
import mutations from "./mutations"
import actions from "./actions/actions"

const store = createStore({
    getters,
    mutations,
    state,
    actions,
    // plugins: [createPersistedState()],
    strict: false
})

export default store;
