import general from './general'
import languages from './languages'
import login from './auth/login'
import register from './auth/register'
import forgotPassword from './auth/forgotPassword'
import confirm from './auth/confirm'
import resetPassword from './auth/resetPassword'
import home from './front/home'
import privacyPolicy from './front/privacyPolicy'
import termsAndConditions from './front/termsAndConditions'
import pageNotFound from './front/pageNotFound'
import header from './header'
import sidebar from './sidebar'
import dashboard from './dashboard/dashboard'
import dashboardComplete from './dashboard/complete'
import dashboardCompleteWarehouse from './dashboard/completeWarehouse'
import dashboardStorage from './dashboard/storage'
import dashboardFulfillment from './dashboard/fulfillment'
import storageWarehouses from './storage/warehouses'
import storageStores from './storage/stores'
import storageProductCategories from './storage/productCategories'
import storageProducts from './storage/products'
import storageSettings from './storage/settings'
import fulfillmentOrders from './fulfillment/orders'
import fulfillmentTracking from './fulfillment/tracking'
import fulfillmentSettings from './fulfillment/settings'

const translations = {
    general,
    languages,
    login,
    register,
    forgotPassword,
    confirm,
    resetPassword,
    home,
    privacyPolicy,
    termsAndConditions,
    pageNotFound,
    header,
    sidebar,
    dashboard,
    dashboardComplete,
    dashboardCompleteWarehouse,
    dashboardStorage,
    dashboardFulfillment,
    storageWarehouses,
    storageStores,
    storageProductCategories,
    storageProducts,
    storageSettings,
    fulfillmentOrders,
    fulfillmentTracking,
    fulfillmentSettings,
}

export default translations
