<!-- =========================================================================================
    File Name: Header.vue
    Description: System layout Header
========================================================================================== -->
<template>
    <div class="header">
        <div class="inner-header">
            <svg @click="toggleSidebar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="sizeMode === 'mobile'" class="sidebar-hamburger" viewBox="0 0 24 24"><path fill="currentColor" d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"></path></svg>

            <div class="breadcrumbs">
                <div class="item home" v-if="sizeMode !== 'mobile'">
                    <router-link to="/system/dashboard">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="icon" viewBox="0 0 24 24"><path fill="currentColor" d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586l6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"></path></svg>
                    </router-link>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="arrow" viewBox="0 0 24 24"><path fill="currentColor" d="M10.296 7.71 14.621 12l-4.325 4.29 1.408 1.42L17.461 12l-5.757-5.71z"></path><path fill="currentColor" d="M6.704 6.29 5.296 7.71 9.621 12l-4.325 4.29 1.408 1.42L12.461 12z"></path></svg>
                </div>
                <template v-for="(item, index) in $route.meta.breadcrumb">
                    <div :class="['item', item.active ? 'active' : '']" v-if="(sizeMode !== 'mobile') || (sizeMode === 'mobile' && $route.meta.breadcrumb.length > 2 && index !== 0) || (sizeMode === 'mobile' && $route.meta.breadcrumb.length <= 2)">
                        <span v-if="item.active_record || item.active">{{ item.active_record ? $store.state.active_record.name : navigation_data[item.title] }}</span>
                        <router-link :to="item.path" v-else>{{ navigation_data[item.title] }}</router-link>
                        <svg v-if="!item.active || item.visual" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="arrow" viewBox="0 0 24 24"><path fill="currentColor" d="M10.296 7.71 14.621 12l-4.325 4.29 1.408 1.42L17.461 12l-5.757-5.71z"></path><path fill="currentColor" d="M6.704 6.29 5.296 7.71 9.621 12l-4.325 4.29 1.408 1.42L12.461 12z"></path></svg>
                        <svg v-if="item.active_record && $store.state.active_record.deleteAction" @click="openDeleteConfirmPopup(item.action, item.title, $store.state.active_record.id, $store.state.active_record.name)" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="delete" viewBox="0 0 24 24"><path fill="currentColor" d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path><path fill="currentColor" d="M9 10h2v8H9zm4 0h2v8h-2z"></path></svg>
                    </div>
                </template>
            </div>

            <div class="button mode">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" @click="changeTheme('dark')" v-if="user.settings.theme === 'light'" viewBox="0 0 24 24"><path fill="currentColor" d="M6.993 12c0 2.761 2.246 5.007 5.007 5.007s5.007-2.246 5.007-5.007S14.761 6.993 12 6.993S6.993 9.239 6.993 12zM12 8.993c1.658 0 3.007 1.349 3.007 3.007S13.658 15.007 12 15.007S8.993 13.658 8.993 12S10.342 8.993 12 8.993zM10.998 19h2v3h-2zm0-17h2v3h-2zm-9 9h3v2h-3zm17 0h3v2h-3zM4.219 18.363l2.12-2.122l1.415 1.414l-2.12 2.122zM16.24 6.344l2.122-2.122l1.414 1.414l-2.122 2.122zM6.342 7.759L4.22 5.637l1.415-1.414l2.12 2.122zm13.434 10.605l-1.414 1.414l-2.122-2.122l1.414-1.414z"></path></svg>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" @click="changeTheme('light')" v-if="user.settings.theme === 'dark'" viewBox="0 0 24 24"><path fill="currentColor" d="M20.742 13.045a8.088 8.088 0 0 1-2.077.271c-2.135 0-4.14-.83-5.646-2.336a8.025 8.025 0 0 1-2.064-7.723A1 1 0 0 0 9.73 2.034a10.014 10.014 0 0 0-4.489 2.582c-3.898 3.898-3.898 10.243 0 14.143a9.937 9.937 0 0 0 7.072 2.93a9.93 9.93 0 0 0 7.07-2.929a10.007 10.007 0 0 0 2.583-4.491a1.001 1.001 0 0 0-1.224-1.224zm-2.772 4.301a7.947 7.947 0 0 1-5.656 2.343a7.953 7.953 0 0 1-5.658-2.344c-3.118-3.119-3.118-8.195 0-11.314a7.923 7.923 0 0 1 2.06-1.483a10.027 10.027 0 0 0 2.89 7.848a9.972 9.972 0 0 0 7.848 2.891a8.036 8.036 0 0 1-1.484 2.059z"></path></svg>
            </div>

            <div class="button notifications">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path fill="currentColor" d="M19 13.586V10c0-3.217-2.185-5.927-5.145-6.742C13.562 2.52 12.846 2 12 2s-1.562.52-1.855 1.258C7.185 4.074 5 6.783 5 10v3.586l-1.707 1.707A.996.996 0 0 0 3 16v2a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-2a.996.996 0 0 0-.293-.707L19 13.586zM19 17H5v-.586l1.707-1.707A.996.996 0 0 0 7 14v-4c0-2.757 2.243-5 5-5s5 2.243 5 5v4c0 .266.105.52.293.707L19 16.414V17zm-7 5a2.98 2.98 0 0 0 2.818-2H9.182A2.98 2.98 0 0 0 12 22z"></path></svg>
            </div>
            <div class="button user" @click="toggleProfileDropdown" @focusout="closeProfileDropdown" tabindex="0">
                {{ user.first_name[0] + user.last_name[0] }}
                <div class="dropdown" v-if="profileDropdown" @click.stop>
                    <div class="header">
                        <div class="user">
                            <div class="avatar">
                                {{ user.first_name[0] + user.last_name[0] }}
                            </div>
                        </div>
                        <div class="title">
                            <div class="name">{{ user.name ? user.name : user.email }}</div>
                            <div class="role">Administrator</div>
                        </div>
                    </div>
                    <div class="main">
                        <div class="item" @click="openPage('/system/profile')">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" style="font-size: 22px; height: 22px; width: 22px;"><path fill="currentColor" d="M12 2a5 5 0 1 0 5 5a5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3a3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"></path></svg>
                            <div class="text">Profile</div>
                        </div>
                    </div>
                    <div class="footer">
                        <div class="item" @click="logout">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" style="font-size: 22px; height: 22px; width: 22px;"><path fill="currentColor" d="M16 13v-2H7V8l-5 4l5 4v-3z"></path><path fill="currentColor" d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z"></path></svg>
                            <div class="text">Logout</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        user: {
            type: Object,
            required: true
        },
        sizeMode: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            profileDropdown: false,
        }
    },
    computed: {
        navigation_data() {
            return this.$store.state.navigation_data;
        }
    },
    methods: {
        toggleSidebar() {
            this.$emit('toggleSidebar', true)
        },
        changeTheme(theme) {
            this.$emit('changeTheme', theme);
        },
        toggleProfileDropdown() {
            this.profileDropdown = !this.profileDropdown;
        },
        closeProfileDropdown() {
            this.profileDropdown = false;
        },
        openPage(link) {
            this.toggleProfileDropdown();
            this.$router.push(link);
        },
        openDeleteConfirmPopup(action, type, id, name) {
            let data = {
                action: action,
                type: type,
                name: name,
                id: id,
            }
            this.$emit('openDeleteConfirmPopup', data);
        },
        logout() {
            this.$store.dispatch('logout')
                .then((data) => {
                    if(data.redirect){
                        this.toggleProfileDropdown();
                        this.$router.push('/' + data.redirect);
                    }
                })
        },
    }
}
</script>
<style lang="scss" scoped>
    .header {
        position: sticky;
        color: rgba(50, 71, 92, 0.87);
        z-index: 2;

        .inner-header {
            display: flex;
            align-items: center;
            height: 64px;
            margin-top: 0.75rem;
            border-radius: 8px;
            background: rgba(var(--accent-color));
            padding: 0 1.5rem;
            box-shadow: 0 2px 4px -1px rgba(50, 71, 92, .06),0 4px 5px 0 rgba(50, 71, 92, .04),0 1px 10px 0 rgba(50, 71, 92, .04);

            .sidebar-hamburger {
                height: 24px;
                width: 24px;
                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                margin-right: 20px;
                cursor: pointer;
            }

            .breadcrumbs {
                flex-grow: 1;
                display: flex;
                flex-direction: row;

                .item {
                    display: flex;
                    flex-direction: row;
                    cursor: pointer;
                    color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                    align-items: center;

                    a {
                        text-decoration: unset;
                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                        &:hover {
                            color: rgba(var(--primary-color));
                        }
                    }


                    &.home {
                        svg {
                            color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                            font-size: 22px;
                            height: 22px;
                            width: 22px;
                            margin-top: 4px;

                            &:hover {
                                color: rgba(var(--primary-color));
                            }
                        }
                    }

                    &:hover {
                        color: rgba(var(--primary-color));
                    }

                    svg {
                        &.arrow {
                            color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                            font-size: 22px;
                            height: 22px;
                            width: 22px;
                            cursor: default;
                            margin: 0 5px;

                            &:hover {
                                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                            }
                        }

                        &.delete {
                            color: rgba(var(--white-color));
                            font-size: 22px;
                            height: 32px;
                            width: 32px;
                            cursor: pointer;
                            margin-left: 10px;
                            border: 1px solid rgba(var(--primary-color));
                            padding: 5px;
                            border-radius: 5px;
                            background: rgba(var(--primary-color));

                            &:hover {
                                opacity: var(--opacity-point-eight-seven);
                            }
                        }
                    }

                    &.active {
                        color: rgba(var(--primary-color));
                        cursor: default;
                    }
                }
            }

            .button {
                width: 40px;
                height: 40px;
                display: flex;
                justify-content: center;
                align-items: center;
                border-radius: 50%;
                cursor: pointer;

                &.mode {
                    svg {
                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                        font-size: 22px;
                        height: 22px;
                        width: 22px;
                    }

                    &:hover {
                        background: rgba(var(--icon-hover-background-color));
                    }
                }

                &.notifications {
                    svg {
                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                        font-size: 22px;
                        height: 22px;
                        width: 22px;
                    }

                    &:hover {
                        background: rgba(var(--icon-hover-background-color));
                    }
                }

                &.user {
                    display: flex;
                    align-items: center;
                    margin-left: 8px;
                    width: 40px;
                    height: 40px;
                    background: rgba(var(--red-color),var(--opacity-point-one-two));
                    color: rgba(var(--red-color));
                    border-radius: 50%;
                    font-weight: 700;
                    font-size: 14px;

                    .dropdown{
                        position: absolute;
                        top: 80px;
                        right: 3rem;
                        background: rgba(var(--accent-color));
                        border-radius: 6px;
                        padding: 6px 0;
                        box-shadow: 0 5px 5px -3px rgba(var(--shadow-color), var(--opacity-point-zero-six)),0 8px 10px 1px rgba(var(--shadow-color), var(--opacity-point-zero-four)),0 3px 14px 2px rgba(var(--shadow-color), var(--opacity-point-zero-two));

                        .header {
                            min-width: 2.25rem;
                            padding: 4px 16px 12px 16px;
                            min-height: 48px;
                            display: flex;
                            border-bottom: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                            margin-bottom: 8px;

                            .user {
                                width: 40px;
                                height: 40px;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                position: relative;
                                margin-right: 12px;
                                background: rgba(var(--red-color),var(--opacity-point-one-two));
                                color: rgba(var(--red-color));
                                border-radius: 50%;
                                font-weight: 700;
                            }

                            .title {
                                .name {
                                    font-size: 1rem;
                                    line-height: 1.5rem;
                                    letter-spacing: .0094rem;
                                    font-weight: 600;
                                    color: rgba(var(--secondary-color), var(--opacity-point-eight-seven))
                                }

                                .role {
                                    font-size: .875rem;
                                    font-weight: 400;
                                    letter-spacing: .0094rem;
                                    line-height: 1rem;
                                    color: rgba(var(--secondary-color), var(--opacity-point-six));
                                }
                            }
                        }

                        .main {
                            .item {
                                display: flex;
                                padding: 7px 16px 7px 16px;
                                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                                svg {
                                    color: inherit;
                                    margin-right: 8px;
                                }

                                .text {
                                    font-weight: 400;
                                }

                                &:hover {
                                    background: rgba(var(--icon-hover-background-color));
                                }
                            }
                        }

                        .footer {
                            padding-top: 8px;
                            border-top: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                            margin-top: 8px;

                            .item {
                                display: flex;
                                padding: 7px 16px 7px 16px;
                                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                                svg {
                                    margin-right: 8px;
                                    color: inherit;
                                }

                                .text {
                                    font-weight: 400;
                                }

                                &:hover {
                                    background: rgba(var(--icon-hover-background-color));
                                }
                            }
                        }
                    }
                }
            }
        }
    }
</style>
