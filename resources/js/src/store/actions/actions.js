/*=========================================================================================
  File Name: actions.js
  Description: Vuex Store - actions
==========================================================================================*/

import helperActions from "./HelperActions";

import ForgotPasswordActions from "./auth/ForgotPasswordActions";
import ResetPasswordActions from "./auth/ResetPasswordActions";
import LoginActions from "./auth/LoginActions";
import LogoutActions from "./auth/LogoutActions";

import UserActions from "./user/UserActions";

import RoleActions from "./role/RoleActions";

import PageActions from "./page/PageActions";

import ShopActions from "./shop/ShopActions";

import NewsletterActions from "./newsletter/NewsletterActions";

import MenuActions from "./menu/MenuActions";

import settingsActions from "./settings/SettingsActions";
import languageActions from "./settings/LanguageActions";

const actions = Object.assign(
    helperActions,

    ForgotPasswordActions,
    ResetPasswordActions,
    LoginActions,
    LogoutActions,

    UserActions,

    RoleActions,

    PageActions,

    ShopActions,

    NewsletterActions,

    MenuActions,

    settingsActions,
    languageActions,
);

export default actions
