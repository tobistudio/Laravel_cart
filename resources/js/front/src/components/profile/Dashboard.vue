<template>
    <h1 class="content-heading tablet-hidden">{{ trans.dashboard }}</h1>

    <div class="welcome-msg">
        <div class="tablet-letters"><span>RR</span></div>
        <div>{{ trans.greetings + ', ' }}<strong>{{ user.first_name + (user.last_name ? ' ' + user.last_name : '') }}</strong> <span class="tablet-hidden">{{ '(' + trans.not + ' ' +  user.first_name + (user.last_name ? ' ' + user.last_name : '') + '? ' }}<a href="#" @click="logout">{{ trans.logout }}</a>)</span></div>
    </div>

    <div class="info-panels">
        <p>{{ trans.dashboardDescription }}</p>

        <div class="panels-list">
            <a href="#" class="panel" @click="openProfilePage('orders')">
                <div class="icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 20C6 12.4575 6 8.68629 8.34315 6.34315C10.6863 4 14.4575 4 22 4H26C33.5425 4 37.3137 4 39.6569 6.34315C42 8.68629 42 12.4575 42 20V28C42 35.5425 42 39.3137 39.6569 41.6569C37.3137 44 33.5425 44 26 44H22C14.4575 44 10.6863 44 8.34315 41.6569C6 39.3137 6 35.5425 6 28V20Z" stroke="#9398A3" stroke-width="2"/>
                        <path d="M16 24H32" stroke="#9398A3" stroke-width="2" stroke-linecap="round"/>
                        <path d="M16 16H32" stroke="#9398A3" stroke-width="2" stroke-linecap="round"/>
                        <path d="M16 32H26" stroke="#9398A3" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>

                <div>
                    <span class="panel-name">{{ trans.orders }}</span>
                    <span class="mobile-text">{{ trans.ordersDescriptionShort }}</span>
                </div>
            </a>

            <a href="#" class="panel" @click="openProfilePage('myVehicles')">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="20" stroke="#9398A3" stroke-width="2"/>
                        <circle cx="24" cy="24" r="12" stroke="#9398A3" stroke-width="2"/>
                        <circle cx="24" cy="24" r="4" stroke="#9398A3" stroke-width="2"/>
                        <path d="M12 24L20 24" stroke="#9398A3" stroke-width="2" stroke-linecap="round"/>
                        <path d="M28 24L36 24" stroke="#9398A3" stroke-width="2" stroke-linecap="round"/>
                        <path d="M18 34.3926L22 27.4644" stroke="#9398A3" stroke-width="2" stroke-linecap="round"/>
                        <path d="M25.9998 20.5371L29.9998 13.6089" stroke="#9398A3" stroke-width="2" stroke-linecap="round"/>
                        <path d="M30 34.3926L26 27.4644" stroke="#9398A3" stroke-width="2" stroke-linecap="round"/>
                        <path d="M22 20.5352L18 13.607" stroke="#9398A3" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>

                <div>
                    <span class="panel-name">{{ trans.myVehicles }}</span>
                    <span class="mobile-text">{{ trans.myVehiclesDescriptionShort }}</span>
                </div>
            </a>

            <a href="#" class="panel" @click="openProfilePage('addresses')">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="39" viewBox="0 0 32 39" fill="none">
                        <path d="M30.2 15.6C30.2 20.1711 27.6548 25.8145 24.4129 30.377C22.8041 32.6413 21.0611 34.5855 19.4479 35.9517C18.6411 36.6349 17.8851 37.1579 17.2112 37.5059C16.5274 37.8589 15.9893 38 15.6 38C15.2107 38 14.6726 37.8589 13.9888 37.5059C13.3149 37.1579 12.5589 36.6349 11.7521 35.9517C10.1389 34.5855 8.39588 32.6413 6.78706 30.377C3.54522 25.8145 1 20.1712 1 15.6C1.00002 11.8976 2.15802 8.24521 4.53072 5.53353C6.88466 2.8433 10.5014 1 15.6 1C20.6986 1 24.3154 2.8433 26.6693 5.53352C29.042 8.24518 30.2 11.8975 30.2 15.6Z" stroke="#9398A3" stroke-width="2"/>
                        <circle cx="15.6" cy="15.6008" r="6.8" stroke="#9398A3" stroke-width="2"/>
                    </svg>
                </div>

                <div>
                    <span class="panel-name">{{ trans.addresses }}</span>
                    <span class="mobile-text">{{ trans.addressesDescriptionShort }}</span>
                </div>
            </a>

            <a href="#" class="panel" @click="openProfilePage('accountInformation')">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <path d="M36.3334 17.3333C36.3334 24.1448 30.8116 29.6667 24.0001 29.6667C17.1886 29.6667 11.6667 24.1448 11.6667 17.3333C11.6667 10.5218 17.1886 5 24.0001 5C30.8116 5 36.3334 10.5218 36.3334 17.3333Z" stroke="#9398A3" stroke-width="2"/>
                        <path d="M4 44.0013C4 41.7791 8.44444 30.668 24 30.668C39.5556 30.668 44 41.7791 44 44.0013" stroke="#9398A3" stroke-width="2"/>
                    </svg>
                </div>

                <div>
                    <span class="panel-name">{{ trans.accountInformation }}</span>
                    <span class="mobile-text">{{ trans.accountInformationDescriptionShort }}</span>
                </div>
            </a>

            <a href="#" class="panel" @click="openProfilePage('paymentMethods')">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <path d="M4 24C4 16.4575 4 12.6863 6.34315 10.3431C8.68629 8 12.4575 8 20 8H28C35.5425 8 39.3137 8 41.6569 10.3431C44 12.6863 44 16.4575 44 24C44 31.5425 44 35.3137 41.6569 37.6569C39.3137 40 35.5425 40 28 40H20C12.4575 40 8.68629 40 6.34315 37.6569C4 35.3137 4 31.5425 4 24Z" stroke="#9398A3" stroke-width="2"/>
                        <path d="M20 32H12" stroke="#9398A3" stroke-width="2" stroke-linecap="round"/>
                        <path d="M28 32H25" stroke="#9398A3" stroke-width="2" stroke-linecap="round"/>
                        <path d="M4 20L44 20" stroke="#9398A3" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>

                <div>
                    <span class="panel-name">{{ trans.paymentMethods }}</span>
                    <span class="mobile-text">{{ trans.paymentMethodsDescriptionShort }}</span>
                </div>
            </a>

            <a href="#" class="panel" @click="openProfilePage('newsletter')">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <path d="M10.4657 19.0797C10.9752 11.7144 17.0985 6 24.4814 6C31.8632 6 37.986 11.7128 38.4969 19.0769L39.8212 38.1642C39.8613 38.7424 39.4031 39.2335 38.8236 39.2335H10.1431C9.56368 39.2335 9.10553 38.7425 9.14551 38.1645L10.4657 19.0797Z" stroke="#9398A3" stroke-width="2"/>
                        <rect x="19.9343" y="41.9141" width="9.10238" height="1.58674" rx="0.5" fill="#9398A3" stroke="#9398A3"/>
                    </svg>
                </div>

                <div>
                    <span class="panel-name">{{ trans.newsletters }}</span>
                    <span class="mobile-text">{{ trans.newslettersDescriptionShort }}</span>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
export default {
    name: 'profileDashboard',
    props: ['locale', 'user'],
    emits: ["openProfilePage"],
    data() {
        return {
            viewLoaded: false
        }
    },
    computed: {
        trans() {
            return {
                dashboard: this.translate('profile', 'dashboard'),
                greetings: this.translate('profile', 'greetings'),
                not: this.translate('profile', 'not'),
                dashboardDescription: this.translate('profile', 'dashboard_description'),
                orders: this.translate('profile', 'orders'),
                ordersDescriptionShort: this.translate('profile', 'orders_description_short'),
                myVehicles: this.translate('profile', 'my_vehicles'),
                myVehiclesDescriptionShort: this.translate('profile', 'my_vehicles_description_short'),
                addresses: this.translate('profile', 'addresses'),
                addressesDescriptionShort: this.translate('profile', 'addresses_description_short'),
                accountInformation: this.translate('profile', 'account_information'),
                accountInformationDescriptionShort: this.translate('profile', 'account_information_description_short'),
                paymentMethods: this.translate('profile', 'payment_methods'),
                paymentMethodsDescriptionShort: this.translate('profile', 'payment_methods_description_short'),
                newsletters: this.translate('profile', 'newsletters'),
                newslettersDescriptionShort: this.translate('profile', 'newsletters_description_short'),
                logout: this.translate('profile', 'logout'),
            }
        }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        openProfilePage(page) {
            this.$emit('openProfilePage', page);
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

    }
}
</script>

<style lang="scss" scoped>
.content-heading {
    margin: 0 0 32px 0;
    font-size: 28px;
    line-height: 34px;
    letter-spacing: -0.56px;

    @media screen {
        @media (max-width: 991px) {
            font-size: 23px;
            line-height: 29px;
            letter-spacing: -0.46px;
        }
    }

    &.tablet-hidden {
        @media screen {
            @media (max-width: 991px) {
                display: none;
            }
        }
    }
}

.sub-heading {
    display: block;
    margin: 0 0 32px 0;
    color: #49515A;
    font-size: 16px;
    line-height: 24px;
}

.welcome-msg {
    margin: 0 0 24px 0;
    font-size: 20px;
    line-height: 20px;

    b, strong {
        color: #0D2441;
        font-weight: 500;
    }

    a {
        color: #E72E2C;

        &:hover {
            text-decoration: underline;
        }
    }

    .tablet-letters {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        line-height: 28px;
        background: #E1E2E5;
        color: #7D8391;
        font-size: 18px;
        font-weight: 600;
        text-transform: uppercase;
        border-radius: 50%;

        @media screen {
            @media (min-width: 992px) {
                display: none;
            }
        }
    }

    @media screen {
        @media (max-width: 991px) {
            display: flex;
            align-items: center;
            gap: 0 16px;
            padding: 16px;
            margin: 0 0 32px 0;
            background: #F0F2F4;
            font-size: 14px;
            border-radius: 8px;

            strong {
                display: block;
                margin: 1px 0 0 0;
                font-size: 18px;
                line-height: 24px;
            }

            .tablet-hidden {
                display: none;
            }
        }

        @media (max-width: 575px) {
            width: calc(100% + 30px);
            margin-top: -24px;
            margin-left: -15px;
            border-radius: 0;
        }
    }
}

.info-panels {
    > p {
        margin: 0 0 47px 0;
        font-size: 16px;
        line-height: 24px;

        @media screen {
            @media (max-width: 991px) {
                display: none;
            }
        }
    }
}

.panels-list {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));

    @media screen {
        @media (max-width: 991px) {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        @media (max-width: 575px) {
            grid-template-columns: auto;
            gap: 16px 0;
        }
    }

    .panel {
        padding: 16px 20px;
        border-top: 1px solid #E9EAEC;
        border-right: 1px solid #E9EAEC;
        text-align: center;

        @media screen {
            @media (min-width: 992px) {
                &:nth-child(3n) {
                    border-right: 0;
                }

                &:nth-child(1),
                &:nth-child(2),
                &:nth-child(3) {
                    border-top: 0;
                }
            }

            @media (max-width: 991px) {
                padding-bottom: 25px;

                &:nth-child(1),
                &:nth-child(2) {
                    border-top: 0;
                }

                &:nth-child(2n) {
                    border-right: 0;
                }
            }

            @media (max-width: 575px) {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                padding: 18px 16px;
                border: 1px solid #E9EAEC !important;
                text-align: left;
                border-radius: 8px;
            }
        }

        .icon {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 48px;
            margin: 0 0 12px 0;

            @media screen {
                @media (max-width: 991px) {
                    height: 40px;
                    margin: 0 0 7px 0;
                }

                @media (max-width: 575px) {
                    height: 32px;
                    width: 32px;
                    margin: 0 12px 0 0;
                }
            }

            svg {
                max-height: 48px;

                @media screen {
                    @media (max-width: 991px) {
                        max-height: 40px;
                    }
                }

                path, circle, rect {
                    transition: all .3s ease-in-out;
                }
            }
        }

        .panel-name {
            font-size: 16px;
            line-height: 16px;
            color: #0D2441;
            transition: all .3s ease-in-out;

            @media screen {
                @media (max-width: 768px) {
                    font-size: 14px;
                    line-height: 14px;
                }

                @media (max-width: 575px) {
                    display: block;
                    margin: 0 0 8px 0;
                    line-height: 14px;
                    font-size: 16px;
                    font-weight: 600;
                }
            }
        }

        .mobile-text {
            display: block;
            line-height: 14px;
            font-size: 12px;
            color: #616571;

            @media screen {
                @media (min-width: 576px) {
                    display: none;
                }
            }
        }

        &:hover {
            @media screen {
                @media (min-width: 576px) {
                    background: #FAFAFA;
                    box-shadow: 0px 3px 15px 0px rgba(45, 48, 57, 0.10);

                    .icon {
                        svg {
                            path, circle, rect {
                                stroke: #E72E2C;
                            }
                        }
                    }

                    .panel-name {
                        color: #E72E2C;
                    }
                }
            }
        }
    }
}
</style>
