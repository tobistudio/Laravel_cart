<template>
    <!--TODO: Good if u can make overlay here instead of adding class to body, but if need class to body can add it here as well thru function in HeaderAuth.vue-->
    <!--TODO: Make sure background is no scrollable-->
    <!--TODO: remake this to actual popups etc. dont use empty forms just use div .form style everything in bottom of this file-->
    <div class="popup" v-if="authPopup">
        <div v-if="authPopup === 'login'">
            Login popup
        </div>
        <div v-if="authPopup === 'register'">
            register popup
        </div>
        <div v-if="authPopup === 'forgotPassword'">
            forgot password popup
        </div>
        <!--TODO: use this click function to close popup @click="closeAuthPopup" this is just example-->
        <div @click="closeAuthPopup">close</div>
        <!--TODO: use this click function to switch between popups @click="openAuthPopup('register')" this is just example-->
        <div @click="openAuthPopup('register')">Register</div>
    </div>
</template>

<script>
export default {
    name: 'AuthPopup',
    data() {
        return {

        }
    },
    computed: {
        authPopup() {
            return this.$store.state.authPopup;
        }
    },
    methods: {
        closeAuthPopup() {
            this.$store.state.authPopup = null;

            //TODO: if we can have backdrop in vue AuthPopup.vue then this is not needed
            const toggleClass = (el, className) => el.classList.toggle(className);
            toggleClass(document.querySelector('body'), 'popup');
        },
        openAuthPopup(type) {
            this.$store.state.authPopup = type;
        }
    },
    mounted() {}
}
</script>

<style lang="scss" scoped>
</style>
