/*=========================================================================================
  File Name: actions.js
  Description: Vuex Store - actions
==========================================================================================*/
import newsletterActions from "./NewsletterActions";
import cartActions from "./CartActions";

const actions = Object.assign(
    newsletterActions,
    cartActions
);

export default actions;

