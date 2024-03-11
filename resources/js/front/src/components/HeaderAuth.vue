<template>
    <li class="authentication">
        <button v-if="!auth" class="icon" @click="openAuthPopup('login')">
            <img src="/images/front/user-icon.svg" alt="Profile">
        </button>
        <button v-if="auth && user" class="icon" @click="openProfileNavigationPopup">
            <img src="/images/front/user-icon.svg" alt="Profile">
        </button>

        <div class="auth-links">
            <button v-if="!auth" class="login" @click="openAuthPopup('login')">{{ trans.login }}</button>
            <button v-if="!auth" class="reg" @click="openAuthPopup('register')">{{ trans.register }}</button>
            <button v-if="auth && user" class="hello" @click="openProfileNavigationPopup">
                <div class="greet">{{ trans.greetings + ',' }}</div>
                <div class="name">{{ user.first_name }}</div>
            </button>
        </div>

        <div class="backdrop" v-if="auth && user && profileNavigationDropdown" @click="closeProfileNavigationPopup"></div>

        <div class="profile-navigation-dropdown" v-if="auth && user && profileNavigationDropdown">
            <div class="hello">
                <div class="greet">{{ trans.greetings + ',' }}</div>
                <div class="name">{{ user.first_name }}</div>
            </div>

            <div class="navigation">
                <button class="nav-link" @click="openProfile('orders')">{{ trans.orders }}</button>
                <button class="nav-link" @click="openProfile('myVehicles')">{{ trans.myVehicles }}</button>
                <button class="nav-link" @click="openProfile('addresses')">{{ trans.addresses }}</button>
                <button class="nav-link" @click="openProfile('accountInformation')">{{ trans.accountInformation }}</button>
                <button class="nav-link" @click="openProfile('paymentMethods')">{{ trans.paymentMethods }}</button>
                <button class="nav-link" @click="openProfile('newsletters')">{{ trans.newsletters }}</button>
            </div>

            <button class="logout" @click="logout">{{ trans.logout }}</button>
        </div>
    </li>
</template>

<script>
import axios from "axios";

export default {
    name: 'HeaderAuth',
    props: ['locale', 'profile_page_slug'],
    data() {
        return {
            auth: false,
            user: null,
            profileNavigationDropdown: false,
        }
    },
    computed: {
      trans() {
          return {
              login: this.translate('profile', 'login'),
              register: this.translate('profile', 'register'),
              greetings: this.translate('profile', 'greetings'),
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
                this.user = data.user;
            }).catch(res => {
                if (res.message && res.message === 'Unauthenticated.') {
                    localStorage.removeItem('customer-access-token');
                    delete axios.defaults.headers.common['Authorization'];

                    this.$store.state.token = '';
                }
            });
        },
        openAuthPopup(type) {
            this.$store.state.authPopup = type;

            document.getElementsByTagName('html')[0].style.overflow = "hidden";
        },
        openProfileNavigationPopup() {
            this.profileNavigationDropdown = true;

            document.getElementsByTagName('html')[0].style.overflow = "hidden";
        },
        openProfile(page) {
            window.open(this.profile_page_slug + "?page=" + page,"_self");
        },
        logout() {
            this.$store.dispatch('customerLogout')
                .then((data) => {
                    if(data.redirect){
                        window.location.replace(data.redirect);
                    }
                })
        },
        closeProfileNavigationPopup() {
            this.profileNavigationDropdown = false;

            document.getElementsByTagName('html')[0].style.overflow = "auto";
        }
    },
    mounted() {
        if(this.$store.state.token){
            this.auth = true;

            this.getCustomer();
        }
    }
}
</script>

<style lang="scss" scoped>
@function rem($size) {
    @return calc($size / 16) * 1rem;
}

.authentication {
    margin: 0 25px 0 0;
    position: relative;

    @media screen {
        @media (max-width: 575px) {
            display: none;
        }
    }

    .icon {
        @media screen {
            @media (min-width: 1130px) {
                margin: 0 10px 0 0;
                cursor: pointer;
            }

            @media (max-width: 1129px) {

            }
        }
    }

    .auth-links {
        display: flex;
        flex-direction: column;


        @media screen {
            @media (max-width: 1129px) {
                display: none;
            }
        }

        button {
            font-family: 'Inter';
            text-align: left;
            line-height: rem(14);
            font-size: rem(14);
            cursor: pointer;

            &.reg {
                margin-top: 4px;
                font-weight: 500;
            }
        }

        .hello {
            position: relative;
            padding: 0 16px 0 0;
            line-height: 14px;
            font-size: 14px;
            color: #0D2441;
            cursor: pointer;

            .greet, .name {
                display: block;
            }

            .name {
                margin: 3px 0 0 0;
                font-weight: 600;
            }

            &::after {
                content: "";
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
                margin: auto 0;
                width: 8px;
                height: 6px;
                background: url('../../../../front/images/user-auto-arrow-down.svg') right center no-repeat;
                transition: all 0.3s ease-in-out;
            }
        }
    }

    .backdrop {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 1;
        visibility: visible;
        transition: all .3s ease-in-out;
        background: rgba(0, 0, 0, 0.70);
        z-index: 100;
    }

    .profile-navigation-dropdown {
        position: absolute;
        top: calc(100% + 28px);
        left: 0;
        width: 270px;
        max-width: 85vw;
        background-color: #fafafa;
        opacity: 1;
        visibility: visible;
        transition: all .3s ease-in-out;
        border-radius: 12px;
        z-index: 999;

        &::before {
            content: "";
            position: absolute;
            top: -7px;
            left: 59px;
            width: 0px;
            height: 0px;
            border-style: solid;
            border-width: 0 10px 7px 10px;
            border-color: transparent transparent #fafafa transparent;
            transform: rotate(0deg);
        }

        .hello {
            margin: 0 0 20px 0;
            padding: 20px 24px;
            border-bottom: 1px solid #E9EAEC;

            .greet {
                display: block;
                margin: 0 0 4px 0;
                line-height: 14px;
                font-size: 14px;
            }

            .name {
                display: block;
                color: #0D2441;
                line-height: 16px;
                font-size: 16px;
                font-weight: 500;
            }
        }

        .navigation {
            padding-bottom: 17px;
            border-bottom: 1px solid #E9EAEC;

            .nav-link {
                display: block;
                width: 100%;
                padding: 10px 24px;
                border: 0;
                background: transparent;
                line-height: 16px;
                color: #0D2441;
                font-size: 16px;
                font-weight: 400;
                cursor: pointer;
                transition: all .3s ease-in-out;
                text-align: left;

                &:hover {
                    background: #F2F3F5;
                }
            }
        }

        .logout {
            padding: 20px 24px;
            line-height: 16px;
            font-size: 16px;
            color: #0D2441;
            cursor: pointer;
            transition: all .3s ease-in-out;

            &:hover {
                color: #E72E2C;
            }
        }
    }
}
</style>
