<!-- =========================================================================================
    File Name: System.vue
    Description: System layout
========================================================================================== -->

<template>
    <div v-if="layoutLoaded" class="system">
        <div class="backdrop" v-if="sizeMode === 'mobile' && mobileSidebar" @click="toggleSidebar(false)"></div>

        <Sidebar :user="user" :sizeMode="sizeMode" :mobileSidebar="mobileSidebar" @toggleSidebar="toggleSidebar"></Sidebar>

        <div class="content-wrapper">
            <Header :user="user" :sizeMode="sizeMode" @toggleSidebar="toggleSidebar" @changeTheme="changeTheme" @openDeleteConfirmPopup="openDeleteConfirmPopup"></Header>
            <router-view
                @openDeleteConfirmPopup="openDeleteConfirmPopup"
                :removeLanguagePageBlockOrItem="removeLanguagePageBlockOrItem"
            ></router-view>
        </div>

        <DeleteConfirmPopup v-if="deleteConfirmPopup" :action="deleteAction" :type="deleteType" :name="deleteName" :id="deleteId" :itemId="deleteItemId" :itemBlockId="deleteItemBlockId" :itemBlockItemId="deleteItemBlockItemId" @recordDeleted="recordDeleted" @closeDeleteConfirmPopup="closeDeleteConfirmPopup"/>

        <div class="message" v-if="message"></div>
        <Toast/>
    </div>
</template>

<script>
import axios from "axios";

import Header from './components/Header.vue';
import Sidebar from './components/Sidebar.vue';

import DeleteConfirmPopup from "../../views/components/DeleteConfirmPopup.vue"

import 'boxicons/css/boxicons.min.css';
import '@vueup/vue-quill/dist/vue-quill.snow.css'

import Toast from 'primevue/toast';

export default {
    components: {
        Header,
        Sidebar,
        DeleteConfirmPopup,
        Toast
    },
    data() {
        return {
            layoutLoaded: false,
            sizeMode: 'desktop',
            mobileSidebar: false,

            deleteConfirmPopup: false,
            deleteAction: null,
            deleteType: null,
            deleteName: null,
            deleteId: null,
            deleteItemId: null,
            deleteItemBlockId: null,
            deleteItemBlockItemId: null,

            removeLanguagePageBlockOrItem: {id: null, item_id: null},

            trans: {
                message: {
                    language_updated: 'Language successfully saved',
                    permission_updated: 'Permissions successfully saved',
                    role_updated: 'Role successfully saved',
                    role_deleted: 'Role successfully deleted',
                    page_created: 'Page successfully created',
                    page_saved: 'Page successfully saved',
                    menu_saved: 'Menu successfully saved',
                }
            }
        }
    },
    computed: {
        user() {
            return this.$store.state.user;
        },
        message() {
            let success_message = this.trans.message[this.$store.state.success_message];
            let error_message = this.trans.message[this.$store.state.error_message];

            if(success_message) {
                this.$toast.add({severity: 'success', summary: success_message, life: 2000});
            } else if(error_message) {
                this.$toast.add({severity: 'error', summary: error_message, life: 2000});
            }

            setTimeout(() => {
                this.$store.state.success_message = false;
                this.$store.state.error_message = false;
                this.$store.state.message_type = false;
            }, 1);
        },
    },
    methods: {
        getUser() {
            this.$store.dispatch('user').then((data) => {
                this.setThemeColors(this.user.settings.theme);
                this.layoutLoaded = true;
            }).catch(res => {
                if (res.message && res.message === 'Unauthenticated.') {
                    localStorage.removeItem('access-token');
                    delete axios.defaults.headers.common['Authorization'];

                    this.$store.state.token = '';

                    this.$router.push('/system/login').catch(() => {
                    });
                } else {
                    this.layoutLoaded = true;
                }
            });
        },
        toggleSidebar(value) {
            this.mobileSidebar = value;
        },
        changeTheme(theme) {
            let payload = {
                theme: theme
            }

            this.$store.dispatch('changeTheme', payload)
                .then((data) => {
                    this.$store.state.user.settings.theme = data.theme;

                    this.setThemeColors(theme);
                })
        },
        setThemeColors(theme) {
            let style = document.documentElement.style;

            style.setProperty("--primary-color", '228,7,19');

            style.setProperty("--white-color", '255,255,255');
            style.setProperty("--black-color", '0,0,0');
            style.setProperty("--sidebar-background-color", '43,44,64');
            style.setProperty("--popup-background-color", '20,21,33');
            style.setProperty("--nav-item-color", '150,151,169');

            style.setProperty("--opacity-point-three", '.3');
            style.setProperty("--opacity-point-four", '.4');
            style.setProperty("--opacity-point-six", '.6');
            style.setProperty("--opacity-point-seven", '.6');
            style.setProperty("--opacity-point-eight-seven", '.87');
            style.setProperty("--opacity-point-one-two", '.12');
            style.setProperty("--opacity-point-zero-six", '.06');
            style.setProperty("--opacity-point-zero-five", '.05');
            style.setProperty("--opacity-point-zero-four", '.04');
            style.setProperty("--opacity-point-zero-two", '.02');

            style.setProperty("--red-color", '228,7,19');
            style.setProperty("--green-color", '90,176,68');

            if(theme === 'light'){
                style.setProperty("--secondary-color", '50,71,92');
                style.setProperty("--shadow-color", '50,71,92');
                style.setProperty("--background-color", '245,245,249');
                style.setProperty("--accent-color", '255,255,255');
                style.setProperty("--title-color", '50,71,92');
                style.setProperty("--icon-hover-background-color", '240,242,244');
                style.setProperty("--primary-button-background-color", '228,7,19');
                style.setProperty("--primary-button-color", '255,255,255');
                style.setProperty("--secondary-button-background-color", '231,234,237');
                style.setProperty("--secondary-button-color", '136, 146, 163');
            } else {
                style.setProperty("--secondary-color", '219,219,235');
                style.setProperty("--shadow-color", '20,21,33');
                style.setProperty("--background-color", '35,35,51');
                style.setProperty("--accent-color", '43,44,64');
                style.setProperty("--title-color", '219,219,235');
                style.setProperty("--icon-hover-background-color", '54,55,75');
                style.setProperty("--primary-button-background-color", '228,7,19');
                style.setProperty("--primary-button-color", '255,255,255');
                style.setProperty("--secondary-button-background-color", '53,55,75');
                style.setProperty("--secondary-button-color", '136,146,163');
            }

        },
        onResize() {

            let windowsWidth = window.innerWidth;
            if(windowsWidth <= 1279){
                this.sizeMode = 'mobile';
            } else {
                this.sizeMode = 'desktop';
            }
        },
        openDeleteConfirmPopup(data) {
            this.deleteAction = data.action;
            this.deleteType = data.type;
            this.deleteName = data.name;
            this.deleteId = data.id;
            this.deleteItemId = data.item_id;
            this.deleteItemBlockId = data.item_block_id;
            this.deleteItemBlockItemId = data.item_block_item_id;
            this.deleteConfirmPopup = true;
        },
        recordDeleted(data) {
            this.closeDeleteConfirmPopup();

            if(data.action && data.action === 'removeLanguagePageBlock'){
                this.removeLanguagePageBlockOrItem = {id: data.id, item_id: null};
            } else if(data.action && data.action === 'removeLanguagePageSidebarBlock'){
                this.removeLanguagePageBlockOrItem = {id: data.id, item_id: null};
            } else if(data.action && data.action === 'removeIconTextBlockItem'){
                this.removeLanguagePageBlockOrItem = {id: data.id, item_id: data.item_id};
            } else if(data.action && data.action === 'removeTableBlockItem'){
                this.removeLanguagePageBlockOrItem = {id: data.id, item_id: data.item_id};
            } else if(data.action && data.action === 'removeTableBlockItemBlock'){
                this.removeLanguagePageBlockOrItem = {id: data.id, item_id: data.item_id, item_block_id: data.item_block_id};
            } else if(data.action && data.action === 'removeTableBlockItemBlockItem'){
                this.removeLanguagePageBlockOrItem = {id: data.id, item_id: data.item_id, item_block_id: data.item_block_id, item_block_item_id: data.item_block_item_id};
            } else if(data.action && data.action === 'removeVehicleModel'){
                this.removeLanguagePageBlockOrItem = {id: data.id, item_id: data.item_id, item_block_id: data.item_block_id, item_block_item_id: data.item_block_item_id};
            } else {
                this.$store.state.error_message = false;
                this.$store.state.success_message = data.message;
                this.$store.state.message_type = data.message_type ? data.message_type : 'system';

                this.$router.push(data.redirect).catch(() => {});
            }
        },
        closeDeleteConfirmPopup() {
            this.deleteConfirmPopup = false;
        },
    },
    mounted() {
        this.getUser();

        this.onResize();
        this.$nextTick(() => {
            window.addEventListener('resize', this.onResize);
        })
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onResize);
    },
}
</script>
<style lang="scss">
@import '@/front/css/primevue_admin';

body {
    height: 100vh;
    //width: 100vw;
    overflow: auto;
    overflow-x: hidden;
}
.system {
    display: flex;
    min-height: 100vh;
    background: rgba(var(--background-color));

    .backdrop {
        border-radius: inherit;
        bottom: 0;
        left: 0;
        opacity: 1;
        position: fixed;
        right: 0;
        top: 0;
        background: rgba(var(--popup-background-color), var(--opacity-point-six));
        z-index: 3;
    }

    .content-wrapper {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
        min-height: 0;
        height: 100%;

        & > .content {
            margin-bottom: .5rem;
        }

        .header {
            padding: 0 1.5rem;
        }

        .content {
            margin-top: 0.75rem;
            padding: 1.5rem;

            h1 {
                color: rgba(var(--title-color), var(--opacity-point-six));
                font-size: 1.5rem;
                line-height: 2rem;
                font-weight: 300;
            }
        }
    }

    .message {
        position: absolute;
        bottom: 1rem;
        right: 1.5rem;

        .success {
            background: rgba(var(--green-color), var(--opacity-point-one-two));
            color: rgba(var(--green-color));
            border-radius: 6px;
            padding: 10px;
            box-shadow: 0 2px 9px -2px rgba(var(--green-color),var(--opacity-point-zero-six)),0 4px 9px 1px rgba(var(--green-color),var(--opacity-point-zero-four)),0 2px 6px 4px rgba(var(--green-color),var(--opacity-point-zero-two));
        }

        .error {
            background: rgba(var(--red-color), var(--opacity-point-one-two));
            color: rgba(var(--red-color));
            border-radius: 6px;
            padding: 10px;
            box-shadow: 0 2px 9px -2px rgba(var(--red-color),var(--opacity-point-zero-six)),0 4px 9px 1px rgba(var(--red-color),var(--opacity-point-zero-four)),0 2px 6px 4px rgba(var(--red-color),var(--opacity-point-zero-two));
        }
    }
}
</style>
