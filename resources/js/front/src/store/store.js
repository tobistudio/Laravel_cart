/*=========================================================================================
  File Name: store.js
  Description: Vuex store
==========================================================================================*/


import { createStore } from "vuex";

import state from "./state"
import actions from "./actions/actions.js";

const store = createStore({
    state,
    actions,
    // plugins: [createPersistedState()],
    strict: false
})

export default store;
