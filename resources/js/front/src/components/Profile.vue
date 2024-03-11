<template>
    <div class="profile" v-if="viewLoaded">
        <div class="container">
            <div class="content-with-sidebar">
                <aside class="sidebar">
                    <ul class="nav-bar">
                        <li :class="[activeProfilePage === 'dashboard' ? 'active' : '']">
                            <a :href="profile_page_slug + '?page=dashboard'" @click.prevent="openProfilePage('dashboard')">{{ trans.dashboard }}</a>
                        </li>

                        <li :class="[activeProfilePage === 'orders' ? 'active' : '']">
                            <a :href="profile_page_slug + '?page=orders'" @click.prevent="openProfilePage('orders')">{{ trans.orders }}</a>
                        </li>

                        <li :class="[activeProfilePage === 'myVehicles' ? 'active' : '']">
                            <a :href="profile_page_slug + '?page=myVehicles'" @click.prevent="openProfilePage('myVehicles')">{{ trans.myVehicles }}</a>
                        </li>

                        <li :class="[activeProfilePage === 'addresses' ? 'active' : '']">
                            <a :href="profile_page_slug + '?page=addresses'" @click.prevent="openProfilePage('addresses')">{{ trans.addresses }}</a>
                        </li>

                        <li :class="[activeProfilePage === 'accountInformation' ? 'active' : '']">
                            <a :href="profile_page_slug + '?page=accountInformation'" @click.prevent="openProfilePage('accountInformation')">{{ trans.accountInformation }}</a>
                        </li>

                        <li :class="[activeProfilePage === 'paymentMethods' ? 'active' : '']">
                            <a :href="profile_page_slug + '?page=paymentMethods'" @click.prevent="openProfilePage('paymentMethods')">{{ trans.paymentMethods }}</a>
                        </li>

                        <li :class="[activeProfilePage === 'newsletter' ? 'active' : '']">
                            <a :href="profile_page_slug + '?page=newsletter'" @click.prevent="openProfilePage('newsletter')">{{ trans.newsletters }}</a>
                        </li>
                    </ul>

                    <div class="logout-holder">
                        <button @click="logout" class="logout-btn">{{ trans.logout }}</button>
                    </div>

                </aside>

                <div class="content">
                    <dashboard :locale="locale" :user="user" v-if="activeProfilePage === 'dashboard'" @openProfilePage="openProfilePage"></dashboard>
                    <orders :locale="locale" v-if="activeProfilePage === 'orders'"></orders>
                    <myVehicles :locale="locale" :vehicle_brands="vehicle_brands" v-if="activeProfilePage === 'myVehicles'"></myVehicles>
                    <addresses :locale="locale" v-if="activeProfilePage === 'addresses'"></addresses>
                    <accountInformation :locale="locale" v-if="activeProfilePage === 'accountInformation'"></accountInformation>
                    <paymentMethods :locale="locale" v-if="activeProfilePage === 'paymentMethods'"></paymentMethods>
                    <newsletter :locale="locale" v-if="activeProfilePage === 'newsletter'"></newsletter>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {defineAsyncComponent} from 'vue'

export default {
    name: 'profile',
    props: ['locale', 'profile_page_slug', 'vehicle_brands'],
    data() {
        return {
            viewLoaded: false,
            activeProfilePage: 'dashboard',

            user: null
        }
    },
    components: {
        dashboard: defineAsyncComponent(() => import('./profile/Dashboard.vue')),
        orders: defineAsyncComponent(() => import('./profile/Orders.vue')),
        myVehicles: defineAsyncComponent(() => import('./profile/MyVehicles.vue')),
        addresses: defineAsyncComponent(() => import('./profile/Addresses.vue')),
        accountInformation: defineAsyncComponent(() => import('./profile/AccountInformation.vue')),
        paymentMethods: defineAsyncComponent(() => import('./profile/PaymentMethods.vue')),
        newsletter: defineAsyncComponent(() => import('./profile/Newsletter.vue')),
    },
    computed: {
        trans() {
            return {
                dashboard: this.translate('profile', 'dashboard'),
                orders: this.translate('profile', 'orders'),
                myVehicles: this.translate('profile', 'my_vehicles'),
                addresses: this.translate('profile', 'addresses'),
                accountInformation: this.translate('profile', 'account_information'),
                paymentMethods: this.translate('profile', 'payment_methods'),
                newsletters: this.translate('profile', 'newsletters'),
                logout: this.translate('profile', 'logout'),
            }
        }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        getCustomer() {
            this.$store.dispatch('customer').then((data) => {
                this.viewLoaded = true;
                this.user = data.user;

                let urlParams = new URLSearchParams(window.location.search);
                let profilePage = urlParams.get('page');
                if(profilePage){
                    this.openProfilePage(profilePage)
                } else {
                    this.openProfilePage('dashboard');
                }
            }).catch(res => {
                if (res.message && res.message === 'Unauthenticated.') {
                    localStorage.removeItem('customer-access-token');
                    delete axios.defaults.headers.common['Authorization'];

                    this.$store.state.token = '';
                } else {
                    this.viewLoaded = true;
                }
            });
        },
        openProfilePage(page) {
            this.activeProfilePage = page;
            window.history.pushState("","", this.profile_page_slug + '?page=' + page);
        },
        logout() {
            this.$store.dispatch('customerLogout')
                .then((data) => {
                    if(data.redirect){
                        window.location.replace(data.redirect);
                    }
                })
        },
    },
    mounted() {
        this.getCustomer();
    }
}
</script>

<style lang="scss" scoped>
    .profile {
        margin: 55px 0 0 0;

        @media screen {
            @media (max-width: 991px) {
                margin: 45px 0 0 0;
            }

            @media (max-width: 991px) {
                margin: 24px 0 0 0;
            }
        }

        .content-with-sidebar {
            display: flex;
            align-items: flex-start;
            flex-direction: row;
            gap: 0 24px;

            @media screen {
                @media (max-width: 700px) {
                    flex-direction: column;
                }
            }
        }

        .sidebar {
            flex-shrink: 0;
            width: 288px;
            padding: 20px 0;
            border: 1px solid #CDCFD5;
            border-radius: 8px;

            @media screen {
                @media (max-width: 991px) {
                    width: 249px;
                }

                @media (max-width: 700px) {
                    width: 100%;
                    gap: 0;
                    margin: 0 0 50px 0;
                }
            }

            .nav-bar {
                padding: 0 0 14px 0;

                li {
                    a {
                        position: relative;
                        display: block;
                        padding: 12px 20px;
                        line-height: 16px;
                        color: #0D2441;

                        &:hover {
                            color: #E72E2C;
                        }
                    }

                    &.active {
                        a {
                            font-weight: 500;
                            color: #E72E2C;

                            &::before {
                                content: "";
                                position: absolute;
                                top: 0;
                                left: 5px;
                                bottom: 0;
                                margin: auto 0;
                                width: 6px;
                                height: 12px;
                                background: url('../../../../front/images/sidebar-nav-arrow.svg') left center no-repeat;
                            }
                        }
                    }
                }
            }

            .logout-holder {
                width: calc(100% - 40px);
                margin-left: 20px;
                padding: 16px 0 0 0;
                border-top: 1px solid #E9EAEC;

                .logout-btn {
                    display: block;
                    width: 100%;
                    padding: 12px 0;
                    border: 0;
                    background: none;
                    line-height: 16px;
                    font-size: 16px;
                    font-weight: 500;
                    color: #0D2441;
                    text-transform: uppercase;
                    text-align: left;
                    cursor: pointer;
                    transition: all .3s ease-in-out;

                    &:hover {
                        color: #E72E2C;
                    }
                }
            }
        }

        .content {
            flex-grow: 1;

            @media screen {
                @media (max-width: 700px) {
                    width: 100%;
                }
            }
        }
    }
</style>
