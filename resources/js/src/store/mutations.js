/*=========================================================================================
  File Name: mutations.js
  Description: Vuex Store - mutations
==========================================================================================*/

const mutations = {
    CLEAR_MESSAGES(state) {
        state.success_message = false;
        state.error_message = false;
        state.message_type = false;
    },
};

export default mutations
