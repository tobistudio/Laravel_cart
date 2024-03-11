/*=========================================================================================
  File Name: state.js
  Description: Vuex Store - state
==========================================================================================*/

const state = {
    APP_NAME: "RB Motors",
    APP_URL: import.meta.env.VITE_APP_URL,
    API_URL: import.meta.env.VITE_API_URL,
    MAINTENANCE_TOKEN: import.meta.env.VITE_MAINTENANCE_TOKEN,

    success_message: false,
    error_message: false,
    message_type: false,

    user: null,
    token: localStorage.getItem('access-token') || '',
    // token: '',

    sidebar_menu: [],
    navigation_data: {
        dashboard: 'Dashboard',
        organization: 'Organization',
        organization_users: 'Users',
        organization_roles: 'Roles',
        pages: 'Pages',
        create: 'Create',
        menus: 'Menus',
        blog: 'Blog',
        blog_categories: 'Categories',
        blog_posts: 'Posts',
        shop: 'Shop',
        shop_attributes: 'Attributes',
        shop_warehouses: 'Warehouses',
        shop_customers: 'Customers',
        shop_categories: 'Categories',
        shop_vehicles: 'Vehicles',
        shop_manufacturers: 'Manufacturers',
        shop_products: 'Products',
        shop_shipping: 'Shipping',
        shop_discount_codes: 'Discount codes',
        shop_newsletter: 'Newsletter',
        shop_orders: 'Orders',
        settings: 'Settings',
        settings_general: 'General',
        settings_languages: 'Languages',
        settings_translations: 'Translations',
    },
    active_record: {
        id: null,
        name: '',
        deleteAction: false
    },

    settings: {
        maintenance: false,
    }
};

export default state
