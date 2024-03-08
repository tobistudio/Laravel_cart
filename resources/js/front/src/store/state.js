/*=========================================================================================
  File Name: state.js
  Description: Vuex Store - state
==========================================================================================*/

const state = {
    APP_NAME: "RB Motors",
    APP_URL: import.meta.env.VITE_APP_URL,
    API_URL: import.meta.env.VITE_API_URL,

    authPopup: null,
};

export default state
