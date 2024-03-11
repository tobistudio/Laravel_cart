/*=========================================================================================
  File Name: actions.js
  Description: Vuex Store - actions
==========================================================================================*/
import CatalogNavigationActions from "./CatalogNavigationActions.js";

import AuthActions from "./AuthActions";

import VehicleSearchActions from "./VehicleSearchActions";

import ContactFormActions from "./ContactFormActions";

import NewsletterActions from "./NewsletterActions";

import CustomerActions from "./CustomerActions";
import MyVehicleActions from "./MyVehicleActions";
import ProductCompareActions from "./ProductCompareActions";
import CartActions from "./CartActions";
import ProductsActions from "./ProductsActions.js";

const actions = Object.assign(
    CatalogNavigationActions,

    AuthActions,

    VehicleSearchActions,

    ContactFormActions,

    NewsletterActions,

    CustomerActions,
    MyVehicleActions,
    ProductCompareActions,
    CartActions,
    ProductsActions,
);

export default actions
