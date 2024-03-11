/*=========================================================================================
  File Name: actions.js
  Description: Vuex Store - actions
==========================================================================================*/
// actions.js
import newsletterActions from "./NewsletterActions";
import cartActions from "./CartActions";
import { comparisonCheckActions, comparisonCheckGetters } from './comparisonCheckActions';

const actions = Object.assign(
    newsletterActions,
    cartActions,
    comparisonCheckActions,
);

const getters = Object.assign(
    comparisonCheckGetters,
);

export { actions, getters }; // Export as named exports


