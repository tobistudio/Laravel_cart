<!-- =========================================================================================
    File Name: Sidebar.vue
    Description: System layout Sidebar
========================================================================================== -->
<template>
    <div class="sidebar" :class="['sidebar', $store.state.user.settings.sidebar_collapsed && sizeMode === 'desktop' ? 'collapsed' : '', sizeMode === 'mobile' ? (mobileSidebar ? 'mobile open' : 'mobile') : '']">
        <div class="nav-header">
            <a :href="home_url">
                <img src="/images/system/logo.png" class="big" :alt="$store.state.APP_NAME" height="33">
                <img src="/images/system/logo_small.png" class="small" :alt="$store.state.APP_NAME" height="33">
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" @click="toggleSidebarCollapse" viewBox="0 0 24 24"><path fill="currentColor" d="M13.293 6.293L7.586 12l5.707 5.707l1.414-1.414L10.414 12l4.293-4.293z"></path></svg>
        </div>
        <ul class="nav-items">
            <li :class="[nav_item.sub.length ? 'nav-group' : 'nav-link', nav_item.sub.length && nav_item.open ? 'open' : '', nav_item.active ? 'active' : '']" v-for="nav_item in navigation">
                <div class="nav-group-label" v-if="nav_item.sub.length && nav_item.view === 1" @click="openMenu(nav_item)">
                    <inline-svg-icon :icon="nav_item.icon" :active="nav_item.active ? 'active' : ''"/>
                    <span class="nav-item-title" style="">{{ navigation_data[nav_item.name] }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" :class="['icon-open', nav_item.active ? 'active' : '', nav_item.active ? 'open' : '']" viewBox="0 0 24 24"><path fill="currentColor" d="M10.707 17.707L16.414 12l-5.707-5.707l-1.414 1.414L13.586 12l-4.293 4.293z"></path></svg>
                </div>
                <ul class="nav-group-children" v-if="nav_item.sub.length && nav_item.view === 1">
                    <template v-for="sub_nav_item in nav_item.sub">
                        <li class="nav-link" v-if="sub_nav_item.view === 1">
                            <router-link :to="sub_nav_item.link">
                                <inline-svg-icon :icon="sub_nav_item.icon" :active="sub_nav_item.active ? 'active' : ''"/>
                                <span class="nav-item-title" style="">{{ navigation_data[sub_nav_item.name] }}</span>
                            </router-link>
                        </li>
                    </template>
                </ul>
                <router-link :to="nav_item.link" v-if="!nav_item.sub.length && nav_item.view === 1" :class="nav_item.active ? 'active' : ''">
                    <inline-svg-icon :icon="nav_item.icon" :active="nav_item.active ? 'active' : ''"/>
                    <span class="nav-item-title">{{ navigation_data[nav_item.name] }}</span>
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
import InlineSvgIcon from '../icons/InlineSVGIcon.vue';

export default {
    props: {
        user: {
            type: Object,
            required: true
        },
        sizeMode: {
            type: String,
            required: true
        },
        mobileSidebar: {
            type: Boolean,
            required: true
        },
    },
    components: {
        InlineSvgIcon,
    },
    data() {
        return {}
    },
    watch:{
        $route (to, from){
            if(from.path !== to.path){
                this.setActiveMenuItems(to);

                if(this.sizeMode === 'mobile'){
                    this.$emit('toggleSidebar', false)
                }
            }
        }
    },
    computed: {
        home_url() {
            return '/';
        },
        navigation() {
            return this.$store.state.sidebar_menu;
        },
        navigation_data() {
            return this.$store.state.navigation_data;
        }
    },
    methods: {
        toggleSidebarCollapse() {
            if(this.sizeMode === 'mobile'){
                this.$emit('toggleSidebar', false)
            } else {
                let payload = {
                    sidebar_collapsed: !this.$store.state.user.settings.sidebar_collapsed
                }

                this.$store.dispatch('toggleSidebar', payload)
                    .then((data) => {
                        this.$store.state.user.settings.sidebar_collapsed = data.sidebar_collapsed;
                    })
            }
        },
        openMenu(item) {
            let current_item_open = !item.open;

            this.navigation.map(nav => {
                    nav.open = false;
            })

            item.open = current_item_open;
        },
        setActiveMenuItems(route) {
            this.navigation.map(nav_item => {
                if(nav_item.link === route.meta.sidebarPath){
                    if(nav_item.sub.length){
                        let sub_active = false;
                        nav_item.sub.map(sub_nav_item => {
                            if(sub_nav_item.link === route.meta.sidebarPath) {
                                sub_nav_item.active = true;
                                sub_active = true;
                            } else {
                                sub_nav_item.active = false;
                            }
                        });

                        nav_item.active = sub_active;
                        nav_item.open = sub_active;
                    } else {
                        nav_item.active = true;
                    }
                } else {
                    if(nav_item.sub){
                        let sub_active = false;
                        nav_item.sub.map(sub_nav_item => {
                            if(sub_nav_item.link === route.meta.sidebarPath) {
                                sub_nav_item.active = true;
                                sub_active = true;
                            } else {
                                sub_nav_item.active = false;
                            }
                        });

                        nav_item.active = sub_active;
                        nav_item.open = sub_active;
                    } else {
                        nav_item.active = false;
                    }
                }
            })
        }
    },
    mounted() {
        this.setActiveMenuItems(this.$route);
    }
}
</script>
<style lang="scss" scoped>
.sidebar {
    width: 260px;
    display: flex;
    flex-direction: column;
    transition: width .25s ease-in-out;
    z-index: 3;

    background: rgb(var(--sidebar-background-color));

    .nav-header {
        margin-top: 0.75rem;
        padding: 1rem 0.5rem;
        position: relative;
        z-index: 1;

        a {
            img {
                &.big {
                    display: block;
                }

                &.small {
                    display: none;
                }
            }
        }

        svg {
            position: absolute;
            border-radius: 100%;
            background: rgba(var(--primary-color));
            color: rgba(var(--white-color));
            font-size: 22px;
            height: 22px;
            width: 22px;
            z-index: 2;
            inset-block-start: calc(50% - 11px);
            inset-inline-end: -11px;
            cursor: pointer;
            transition: transform .2s;

            &.collapsed {
                transform: rotate(180deg);
            }
        }

        &:after {
            --diameter: 36px;
            position: absolute;
            z-index: 1;
            border-radius: 100%;
            aspect-ratio: 1;
            background: rgba(var(--background-color));
            content: "";
            inline-size: 36px;
            inset-block-start: calc(50% - 36px / 2);
            inset-inline-end: -18px;
        }
    }

    .nav-items {
        list-style-type: none;
        padding: 0;
        padding-top: 0.25rem;
        height: 100%;
        overflow-y: auto;

        &::-webkit-scrollbar {
            display: none;
        }

        .nav-link {
            a {
                text-decoration: unset;
                border-radius: 0.375rem;
                height: 2.75rem;
                display: flex;
                margin: 0 1rem 0.125rem 1rem;
                padding: 0 0.935rem;
                position: relative;
                min-width: 228px;

                &:before {
                    position: absolute;
                    border-radius: inherit;
                    background: rgba(var(--nav-item-color));
                    block-size: 100%;
                    content: "";
                    inline-size: 100%;
                    inset: 0;
                    opacity: 0;
                    pointer-events: none;
                }

                .nav-item-title {
                    color: rgba(var(--nav-item-color));
                    align-self: center;
                    flex-grow: 1;
                    margin-left: 0.625rem;
                    position: relative;
                    overflow: hidden;
                    margin-inline-end: auto;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                }

                &:hover {
                    &:before {
                        opacity: calc(0.04 * 1);
                    }
                }

                &.active {
                    &:before {
                        background: rgba(var(--primary-color));
                        opacity: 1;
                    }

                    .nav-item-title {
                        color: rgba(var(--white-color));
                        z-index: 1;
                    }
                }
            }
        }

        .nav-group {
            .nav-group-label {
                border-radius: 0.375rem;
                height: 2.75rem;
                display: flex;
                margin: 0 1rem 0.125rem 1rem;
                padding: 0 0.935rem;
                position: relative;
                cursor: pointer;

                &:before {
                    position: absolute;
                    border-radius: inherit;
                    background: rgba(var(--nav-item-color));
                    block-size: 100%;
                    content: "";
                    inline-size: 100%;
                    inset: 0;
                    opacity: 0;
                    pointer-events: none;
                }

                .nav-item-title {
                    color: rgba(var(--nav-item-color));
                    align-self: center;
                    flex-grow: 1;
                    margin-left: 0.625rem;
                    position: relative;
                    overflow: hidden;
                    margin-inline-end: auto;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                }

                svg {
                    align-self: center;
                    color: rgba(var(--nav-item-color));

                    &.icon-open {
                        font-size: 20px;
                        height: 20px;
                        width: 20px;
                        flex-shrink: 0;
                        transform-origin: center;
                        transition: transform .15s ease-in-out;
                        will-change: transform;

                        &.open {
                            transform: rotate(90deg);
                        }

                        &.active {
                            color: rgba(var(--white-color));
                        }
                    }
                }

                &:hover {
                    &:before {
                        opacity: calc(0.04 * 1);
                    }
                }
            }

            .nav-group-children {
                list-style-type: none;
                padding: 0;
                max-height: 0;
                overflow: hidden;
            }

            &.open {
                .nav-group-label {
                    &:before {
                        opacity: calc(0.08 * 1);
                    }

                    &:hover {
                        &:before {
                            opacity: calc(0.04 * 1);
                        }
                    }
                }

                .nav-group-children {
                    height: auto;
                    max-height: 1000px;
                    transition: max-height 0.5s ease-in;
                }
            }

            &.active {
                .nav-group-label {
                    &:before {
                        background: rgba(var(--primary-color));
                        opacity: 1;
                    }

                    &:hover {
                        &:before {
                            opacity: 1;
                        }
                    }

                    .nav-item-title {
                        color: rgba(var(--white-color));
                        z-index: 1;
                    }
                }
            }
        }
    }

    &.collapsed {
        width: 84px;

        .nav-header {
            a {
                img {
                    margin: 0 5px;

                    &.big {
                        display: none;
                    }

                    &.small {
                        display: block;
                    }
                }
            }

            svg {
                transform: rotate(180deg);
                display: none;
            }

            &:after {
                display: none;
            }
        }

        .nav-items {
            .nav-link {
                a {
                    min-width: 52px;

                    .nav-item-title {
                        display: none;
                    }
                }
            }
        }

        .nav-group {
            .nav-group-label {
                .nav-item-title {
                    display: none;
                }

                svg {
                    &.icon-open {
                        display: none;
                    }
                }
            }

            &.open {
                .nav-group-children {
                    height: 0;
                }
            }
        }
    }

    &:hover {
        width: 260px;

        .nav-header {
            a {
                img {
                    margin: 0;

                    &.big {
                        display: block;
                    }

                    &.small {
                        display: none;
                    }
                }
            }

            svg {
                display: block;
            }

            &:after {
                display: block;
            }
        }

        .nav-items {
            .nav-link {
                a {
                    min-width: 228px;

                    .nav-item-title {
                        display: block;
                    }
                }
            }
        }

        .nav-group {
            .nav-group-label {
                .nav-item-title {
                    display: block;
                }

                svg {
                    &.icon-open {
                        display: block;
                    }
                }
            }

            &.open {
                .nav-group-children {
                    height: auto;
                }
            }
        }
    }

    &.mobile {
        width: 0;
        position: absolute;

        .nav-header {
            visibility: hidden;
        }

        &.open {
            width: 260px;

            .nav-header {
                visibility: visible;
            }
        }
    }
}
</style>
