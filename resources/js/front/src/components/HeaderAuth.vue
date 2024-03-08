<template>
    <li v-if="auth">Authenticated</li>
    <li class="authentication" v-else>
        <a href="#" class="icon">
            <img src="/images/front/user-icon.svg" alt="Profile">
        </a>

        <div class="auth-links">
            <!--TODO: remake this to div or span or something, we dont want hrefs with empty #-->
            <a href="#" class="login" @click="openAuthPopup('login')">Pieslēgties</a>
            <a href="#" class="reg" @click="openAuthPopup('register')">Reģistrēties</a>
        </div>
    </li>
</template>

<script>
export default {
    name: 'HeaderAuth',
    data() {
        return {
            auth: false,
        }
    },
    methods: {
        openAuthPopup(type) {
            this.$store.state.authPopup = type;

            //TODO: if we can have backdrop in vue AuthPoup then this is not needed
            const toggleClass = (el, className) => el.classList.toggle(className);
            toggleClass(document.querySelector('body'), 'popup');
        }
    },
    mounted() {}
}
</script>

<style lang="scss" scoped>
@function rem($size) {
    @return calc($size / 16) * 1rem;
}

.authentication {
    margin: 0 25px 0 0;

    @media screen {
        @media (max-width: 575px) {
            display: none;
        }
    }

    .icon {
        @media screen {
            @media (min-width: 1130px) {
                margin: 0 10px 0 0;
                pointer-events: none;
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

        a {
            line-height: normal;
            line-height: rem(14);
            font-size: rem(14);

            &.reg {
                margin-top: 4px;
                font-weight: 500;
            }
        }
    }
}
</style>
