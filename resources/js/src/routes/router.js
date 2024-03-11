/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  Object Strucutre:
                    path => router path
                    name => router name
                    component(lazy loading) => component to load
                    meta : {
                      rule => which user can have access (ACL)
                      breadcrumb => Add breadcrumb to specific page
                      pageTitle => Display title besides breadcrumb
                    }
==========================================================================================*/

import { createWebHistory, createRouter } from "vue-router";
import store from '../store/store.js'

// Vue.use(Router);

const routes = [
    {
        // =============================================================================
        // BACKEND ROUTES
        // =============================================================================
        path: '/system',
        component: () => import('../layouts/system/System.vue'),
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/system/profile',
                name: 'navigation.profile',
                component: () => import('../views/pages/profile/Profile.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'navigation.profile', active: true},
                    ],
                    sidebarPath: null,
                    pageTitle: 'navigation.profile',
                }
            },
            {
                path: '/system/dashboard',
                name: 'navigation.dashboard',
                component: () => import('../views/pages/dashboard/Dashboard.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'dashboard', active: true},
                    ],
                    sidebarPath: '/system/dashboard',
                    pageTitle: 'navigation.dashboard',
                }
            },
            {
                path: '/system/organization',
                name: 'navigation.organization',
                component: () => import('../views/pages/organization/Organization.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'organization', active: true},
                    ],
                    sidebarPath: '/system/organization',
                    pageTitle: 'navigation.organization',
                }
            },
            {
                path: '/system/organization/users',
                name: 'navigation.organization.users',
                component: () => import('../views/pages/organization/users/Users.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'organization', active: true, visual: true},
                        {title: 'organization_users', active: true},
                    ],
                    sidebarPath: '/system/organization/users',
                    pageTitle: 'navigation.organization.users',
                }
            },
            {
                path: '/system/organization/users/:id',
                name: 'navigation.organization.users.user',
                component: () => import('../views/pages/organization/users/User.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'organization', active: true, visual: true},
                        {title: 'organization_users', path: '/system/organization/users', active: false},
                        {title: 'user', active: true, active_record: true, action: 'deleteUser'},
                    ],
                    sidebarPath: '/system/organization/users',
                    pageTitle: 'navigation.organization.users.user',
                }
            },
            {
                path: '/system/organization/roles',
                name: 'navigation.organization.roles',
                component: () => import('../views/pages/organization/roles/Roles.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'organization', active: true, visual: true},
                        {title: 'organization_roles', active: true},
                    ],
                    sidebarPath: '/system/organization/roles',
                    pageTitle: 'navigation.organization.roles',
                }
            },
            {
                path: '/system/organization/roles/:id',
                name: 'navigation.organization.roles.user',
                component: () => import('../views/pages/organization/roles/Role.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'organization', active: true, visual: true},
                        {title: 'organization_roles', path: '/system/organization/roles', active: false},
                        {title: 'role', active: true, active_record: true, action: 'deleteRole'},
                    ],
                    sidebarPath: '/system/organization/roles',
                    pageTitle: 'navigation.organization.roles.role',
                }
            },
            {
                path: '/system/pages',
                name: 'navigation.pages',
                component: () => import('../views/pages/pages/Pages.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'pages', active: true},
                    ],
                    sidebarPath: '/system/pages',
                    pageTitle: 'navigation.pages',
                }
            },
            {
                path: '/system/pages/:type/:page_id?/:language_id?',
                name: 'navigation.pages.create',
                component: () => import('../views/pages/pages/Page.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'pages', path: '/system/pages', active: false},
                        {title: 'page', active: true, active_record: true, action: 'deletePage'},
                    ],
                    sidebarPath: '/system/pages',
                    pageTitle: 'navigation.pages.page',
                }
            },
            {
                path: '/system/menus',
                name: 'navigation.menus',
                component: () => import('../views/pages/menus/Menus.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'menus', active: true},
                    ],
                    sidebarPath: '/system/menus',
                    pageTitle: 'navigation.menus',
                }
            },
            {
                path: '/system/menus/:menu_id',
                name: 'navigation.menus.menu',
                component: () => import('../views/pages/menus/Menu.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'menus', path: '/system/menus', active: false},
                        {title: 'menu', active: true, active_record: true, action: 'deleteMenu'},

                    ],
                    sidebarPath: '/system/menus',
                    pageTitle: 'navigation.menus.menu',
                }
            },
            {
                path: '/system/blog',
                name: 'navigation.blog',
                component: () => import('../views/pages/blog/Blog.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'blog', active: true},
                    ],
                    sidebarPath: '/system/blog',
                    pageTitle: 'navigation.blog',
                }
            },
            {
                path: '/system/blog/categories',
                name: 'navigation.blog.categories',
                component: () => import('../views/pages/blog/Categories.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'blog', active: true, visual: true},
                        {title: 'blog_categories', active: true},
                    ],
                    sidebarPath: '/system/blog/categories',
                    pageTitle: 'navigation.blog.categories',
                }
            },
            {
                path: '/system/blog/categories/:type/:page_id?/:language_id?',
                name: 'navigation.blog.categories.create',
                component: () => import('../views/pages/pages/Page.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'blog', active: true, visual: true},
                        {title: 'blog_categories', path: '/system/blog/categories', active: false, visual: true},
                        {title: 'blog_category', active: true, active_record: true, action: 'deletePage'},
                    ],
                    sidebarPath: '/system/blog/categories',
                    pageTitle: 'navigation.blog.categories.category',
                }
            },
            {
                path: '/system/blog/posts',
                name: 'navigation.blog.posts',
                component: () => import('../views/pages/blog/Posts.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'blog', active: true, visual: true},
                        {title: 'blog_posts', active: true},
                    ],
                    sidebarPath: '/system/blog/posts',
                    pageTitle: 'navigation.blog.posts',
                }
            },
            {
                path: '/system/blog/posts/:type/:page_id?/:language_id?',
                name: 'navigation.blog.posts.create',
                component: () => import('../views/pages/pages/Page.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'blog', active: true, visual: true},
                        {title: 'blog_posts', path: '/system/blog/posts', active: false, visual: true},
                        {title: 'blog_post', active: true, active_record: true, action: 'deletePage'},
                    ],
                    sidebarPath: '/system/blog/posts',
                    pageTitle: 'navigation.blog.posts.post',
                }
            },
            {
                path: '/system/shop',
                name: 'navigation.shop',
                component: () => import('../views/pages/shop/Shop.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'shop', active: true},
                    ],
                    sidebarPath: '/system/shop',
                    pageTitle: 'navigation.shop',
                }
            },
            {
                path: '/system/shop/attributes',
                name: 'navigation.shop.attributes',
                component: () => import('../views/pages/shop/Attributes.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'shop', active: true, visual: true},
                        {title: 'shop_attributes', active: true},
                    ],
                    sidebarPath: '/system/shop/attributes',
                    pageTitle: 'navigation.shop.attributes',
                }
            },
            {
                path: '/system/shop/warehouses',
                name: 'navigation.shop.warehouses',
                component: () => import('../views/pages/shop/Warehouses.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'shop', active: true, visual: true},
                        {title: 'shop_warehouses', active: true},
                    ],
                    sidebarPath: '/system/shop/warehouses',
                    pageTitle: 'navigation.shop.warehouses',
                }
            },
            {
                path: '/system/shop/customers',
                name: 'navigation.shop.customers',
                component: () => import('../views/pages/shop/Customers.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'shop', active: true, visual: true},
                        {title: 'shop_customers', active: true},
                    ],
                    sidebarPath: '/system/shop/customers',
                    pageTitle: 'navigation.shop.customers',
                }
            },
            {
                path: '/system/shop/categories',
                name: 'navigation.shop.categories',
                component: () => import('../views/pages/shop/Categories.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'shop', active: true, visual: true},
                        {title: 'shop_categories', active: true},
                    ],
                    sidebarPath: '/system/shop/categories',
                    pageTitle: 'navigation.shop.categories',
                }
            },
            {
                path: '/system/shop/categories/:type/:page_id?/:language_id?',
                name: 'navigation.shop.categories.create',
                component: () => import('../views/pages/pages/Page.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'shop', active: true, visual: true},
                        {title: 'shop_categories', path: '/system/shop/categories', active: false, visual: true},
                        {title: 'shop_category', active: true, active_record: true, action: 'deletePage'},
                    ],
                    sidebarPath: '/system/shop/categories',
                    pageTitle: 'navigation.shop.categories.category',
                }
            },
            {
                path: '/system/shop/vehicles',
                name: 'navigation.shop.vehicles',
                component: () => import('../views/pages/shop/Vehicles.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'shop', active: true, visual: true},
                        {title: 'shop_vehicles', active: true},
                    ],
                    sidebarPath: '/system/shop/vehicles',
                    pageTitle: 'navigation.shop.vehicles',
                }
            },
            {
                path: '/system/shop/vehicles/:type/:page_id?/:language_id?',
                name: 'navigation.shop.vehicles.create',
                component: () => import('../views/pages/pages/Page.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'shop', active: true, visual: true},
                        {title: 'shop_vehicles', path: '/system/shop/vehicles', active: false, visual: true},
                        {title: 'shop_vehicle', active: true, active_record: true, action: 'deletePage'},
                    ],
                    sidebarPath: '/system/shop/vehicles',
                    pageTitle: 'navigation.shop.vehicles.vehicle',
                }
            },
            {
                path: '/system/shop/manufacturers',
                name: 'navigation.shop.manufacturers',
                component: () => import('../views/pages/shop/Manufacturers.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'shop', active: true, visual: true},
                        {title: 'shop_manufacturers', active: true},
                    ],
                    sidebarPath: '/system/shop/manufacturers',
                    pageTitle: 'navigation.shop.manufacturers',
                }
            },
            {
                path: '/system/shop/manufacturers/:type/:page_id?/:language_id?',
                name: 'navigation.shop.manufacturers.create',
                component: () => import('../views/pages/pages/Page.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'shop', active: true, visual: true},
                        {title: 'shop_manufacturers', path: '/system/shop/manufacturers', active: false, visual: true},
                        {title: 'shop_manufacturer', active: true, active_record: true, action: 'deletePage'},
                    ],
                    sidebarPath: '/system/shop/manufacturers',
                    pageTitle: 'navigation.shop.manufacturers.manufacturer',
                }
            },
            {
                path: '/system/shop/products',
                name: 'navigation.shop.products',
                component: () => import('../views/pages/shop/Products.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'shop', active: true, visual: true},
                        {title: 'shop_products', active: true},
                    ],
                    sidebarPath: '/system/shop/products',
                    pageTitle: 'navigation.shop.products',
                }
            },
            {
                path: '/system/shop/products/:type/:page_id?/:language_id?',
                name: 'navigation.shop.products.create',
                component: () => import('../views/pages/pages/Page.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'shop', active: true, visual: true},
                        {title: 'shop_products', path: '/system/shop/products', active: false, visual: true},
                        {title: 'shop_product', active: true, active_record: true, action: 'deletePage'},
                    ],
                    sidebarPath: '/system/shop/products',
                    pageTitle: 'navigation.shop.products.product',
                }
            },
            {
                path: '/system/shop/shipping',
                name: 'navigation.shop.shipping',
                component: () => import('../views/pages/shop/Shipping.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'shop', active: true, visual: true},
                        {title: 'shop_shipping', active: true},
                    ],
                    sidebarPath: '/system/shop/shipping',
                    pageTitle: 'navigation.shop.shipping',
                }
            },
            {
                path: '/system/shop/discount-codes',
                name: 'navigation.shop.discount-codes',
                component: () => import('../views/pages/shop/DiscountCodes.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'shop', active: true, visual: true},
                        {title: 'shop_discount_codes', active: true},
                    ],
                    sidebarPath: '/system/shop/discount-codes',
                    pageTitle: 'navigation.shop.discount-codes',
                }
            },
            {
                path: '/system/shop/orders',
                name: 'navigation.shop.orders',
                component: () => import('../views/pages/shop/Orders.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'shop', active: true, visual: true},
                        {title: 'shop_orders', active: true},
                    ],
                    sidebarPath: '/system/shop/orders',
                    pageTitle: 'navigation.shop.orders',
                }
            },
            {
                path: '/system/shop/newsletter',
                name: 'navigation.shop.newsletter',
                component: () => import('../views/pages/shop/Newsletter.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'shop', active: true, visual: true},
                        {title: 'shop_newsletter', active: true},
                    ],
                    sidebarPath: '/system/shop/newsletter',
                    pageTitle: 'navigation.shop.newsletter',
                }
            },
            {
                path: '/system/settings',
                name: 'navigation.settings',
                component: () => import('../views/pages/settings/Settings.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'settings', active: true, visual: true},
                        {title: 'settings_general', active: true},
                    ],
                    sidebarPath: '/system/settings',
                    pageTitle: 'navigation.settings',
                }
            },
            {
                path: '/system/settings/languages',
                name: 'navigation.settings.languages',
                component: () => import('../views/pages/settings/Languages.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'settings', active: true, visual: true},
                        {title: 'settings_languages', active: true},
                    ],
                    sidebarPath: '/system/settings/languages',
                    pageTitle: 'navigation.settings.languages',
                }
            },
            {
                path: '/system/settings/translations',
                name: 'navigation.settings.translations',
                component: () => import('../views/pages/settings/Translations.vue'),
                meta: {
                    breadcrumb: [
                        {title: 'settings', active: true, visual: true},
                        {title: 'settings_translations', active: true},
                    ],
                    sidebarPath: '/system/settings/translations',
                    pageTitle: 'navigation.settings.translations',
                }
            },
        ]
    },
    {
        // =============================================================================
        // BACKEND AUTH ROUTES
        // =============================================================================
        path: '/system/',
        component: () => import('../layouts/system/Auth.vue'),
        children: [
            {
                path: '/system/login',
                name: 'page.login',
                component: () => import('../views/pages/auth/Login.vue'),
            },
            {
                path: '/system/forgot-password',
                name: 'page.forgot_password',
                component: () => import('../views/pages/auth/ForgotPassword.vue')
            },
            {
                path: '/system/reset-password/:token',
                name: 'page.reset_password',
                component: () => import('../views/pages/auth/ResetPassword.vue')
            }
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    base: '/',
    routes,
    scrollBehavior(to, from, savedPosition) {
        return {x: 0, y: 0};
    }
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.state.token) {
            next();
        } else {
            next('/system/login');
        }
    } else {
        if (store.state.token &&
            (
                to.name === 'page.login' ||
                to.name === 'page.forgot_password' ||
                to.name === 'page.reset_password' ||
                to.name === 'page.create_password' ||
                to.name === 'page.change_password' ||
                to.name === 'page.change_email' ||
                to.name === 'page.confirm'
            )
        ) {
            next('/system/dashboard');
        } else {
            next();
        }
    }
});


export default router
