/*=========================================================================================
  File Name: state.js
  Description: Vuex Store - state
==========================================================================================*/

import translations from './translations/translations'

const state = {
    APP_NAME: "RB Motors",
    APP_URL: import.meta.env.VITE_APP_URL,
    API_URL: import.meta.env.VITE_API_URL,

    success_message: false,
    error_message: false,
    message_type: false,

    currentTranslations: translations,

    user: null,
    token: localStorage.getItem('customer-access-token') || '',

    activeVehicleId: localStorage.getItem('active-vehicle-id') || null,
    activeVehicle: {
        processing: true
    },
    myVehicles: [],

    activeCartId: localStorage.getItem('active-cart-id') || null,
    activeCart: null,

    comparePage: false,
    activeProductComparing: JSON.parse(localStorage.getItem('active-product-comparing')) || null,

    authPopup: null,
};

export default state
