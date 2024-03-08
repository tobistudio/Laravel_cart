<!-- =========================================================================================
  File Name: User.vue
  Description: User
========================================================================================== -->
<template>
    <div v-if="pageLoaded" class="content">
        <div class="card">
            <div :class="['input-wrapper', role.name ? 'has-content' : '', name_validation ? 'error' : '', nameClassFocus]">
                <div class="label">{{ trans.name }}</div>
                <div class="label-floating">{{ trans.name }}</div>
                <input v-model="role.name " type="text" @focus="nameFocus" @blur="nameBlur"/>
                <button class="primary" @click="saveRole">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path stroke="currentColor" d="m10 15.586-3.293-3.293-1.414 1.414L10 18.414l9.707-9.707-1.414-1.414z"></path></svg>
                </button>
                <span class="error" v-if="name_validation">{{ name_validation }}</span>
            </div>

            <div class="permissions">
                <div class="permissions-data">
                    <div class="permissions-header">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C9.243 2 7 4.243 7 7v3H6c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-8c0-1.103-.897-2-2-2h-1V7c0-2.757-2.243-5-5-5zm6 10 .002 8H6v-8h12zm-9-2V7c0-1.654 1.346-3 3-3s3 1.346 3 3v3H9z"></path></svg>
                        <div class="title">Permissions</div>
                    </div>
                    <div class="permissions-content">
                        <div class="header">
                            <div class="name"></div>
                            <div class="action">View</div>
                            <div class="action">Create</div>
                            <div class="action">Edit</div>
                            <div class="action">Delete</div>
                        </div>
                        <div class="items" v-for="permission_item in permissions">
                            <div class="item">
                                <div class="name">{{ navigation_data[permission_item.name] }}</div>
                                <div :class="['action', role.super === 0 ? 'pointer' : '']">
                                    <div class="checkbox" @click="savePermission(permission_item.id, 'view',!permission_item.permissions.view ? 1: 0)">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="role.super" class="check-admin" viewBox="0 0 24 24"><path stroke="currentColor" d="m10 15.586-3.293-3.293-1.414 1.414L10 18.414l9.707-9.707-1.414-1.414z"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="!role.super && !permission_item.permissions.view" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="!role.super && permission_item.permissions.view" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                    </div>
                                </div>
                                <div :class="['action', role.super === 0 ? 'pointer' : '']">
                                    <div class="checkbox" @click="savePermission(permission_item.id, 'create',!permission_item.permissions.create ? 1: 0)">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="role.super" class="check-admin" viewBox="0 0 24 24"><path stroke="currentColor" d="m10 15.586-3.293-3.293-1.414 1.414L10 18.414l9.707-9.707-1.414-1.414z"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="!role.super && !permission_item.permissions.create" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="!role.super && permission_item.permissions.create" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                    </div>
                                </div>
                                <div :class="['action', role.super === 0 ? 'pointer' : '']">
                                    <div class="checkbox" @click="savePermission(permission_item.id, 'edit',!permission_item.permissions.edit ? 1: 0)">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="role.super" class="check-admin" viewBox="0 0 24 24"><path stroke="currentColor" d="m10 15.586-3.293-3.293-1.414 1.414L10 18.414l9.707-9.707-1.414-1.414z"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="!role.super && !permission_item.permissions.edit" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="!role.super && permission_item.permissions.edit" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                    </div>
                                </div>
                                <div :class="['action', role.super === 0 ? 'pointer' : '']">
                                    <div class="checkbox" @click="savePermission(permission_item.id, 'delete',!permission_item.permissions.delete ? 1: 0)">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="role.super" class="check-admin" viewBox="0 0 24 24"><path stroke="currentColor" d="m10 15.586-3.293-3.293-1.414 1.414L10 18.414l9.707-9.707-1.414-1.414z"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="!role.super && !permission_item.permissions.delete" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="!role.super && permission_item.permissions.delete" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="item sub" v-for="permission_sub_item in permission_item.sub">
                                <div class="name">{{ navigation_data[permission_sub_item.name] }}</div>
                                <div :class="['action', role.super === 0 ? 'pointer' : '']">
                                    <div class="checkbox" @click="savePermission(permission_sub_item.id,'view',!permission_sub_item.permissions.view ? 1 : 0)">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="role.super" class="check-admin" viewBox="0 0 24 24"><path stroke="currentColor" d="m10 15.586-3.293-3.293-1.414 1.414L10 18.414l9.707-9.707-1.414-1.414z"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="!role.super && !permission_sub_item.permissions.view" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="!role.super && permission_sub_item.permissions.view" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                    </div>
                                </div>
                                <div :class="['action', role.super === 0 ? 'pointer' : '']">
                                    <div class="checkbox" @click="savePermission(permission_sub_item.id,'create',!permission_sub_item.permissions.create ? 1 : 0)">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="role.super" class="check-admin" viewBox="0 0 24 24"><path stroke="currentColor" d="m10 15.586-3.293-3.293-1.414 1.414L10 18.414l9.707-9.707-1.414-1.414z"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="!role.super && !permission_sub_item.permissions.create" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="!role.super && permission_sub_item.permissions.create" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                    </div>
                                </div>
                                <div :class="['action', role.super === 0 ? 'pointer' : '']">
                                    <div class="checkbox" @click="savePermission(permission_sub_item.id,'edit',!permission_sub_item.permissions.edit ? 1 : 0)">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="role.super" class="check-admin" viewBox="0 0 24 24"><path stroke="currentColor" d="m10 15.586-3.293-3.293-1.414 1.414L10 18.414l9.707-9.707-1.414-1.414z"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="!role.super && !permission_sub_item.permissions.edit" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="!role.super && permission_sub_item.permissions.edit" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                    </div>
                                </div>
                                <div :class="['action', role.super === 0 ? 'pointer' : '']">
                                    <div class="checkbox" @click="savePermission(permission_sub_item.id,'delete',!permission_sub_item.permissions.delete ? 1 : 0)">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="role.super" class="check-admin" viewBox="0 0 24 24"><path stroke="currentColor" d="m10 15.586-3.293-3.293-1.414 1.414L10 18.414l9.707-9.707-1.414-1.414z"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="!role.super && !permission_sub_item.permissions.delete" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" v-if="!role.super && permission_sub_item.permissions.delete" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            pageLoaded: false,

            title: 'Role',

            role: {},
            nameClassFocus: false,
            name_validation: null,

            permissions: [],

            trans: {
                name: 'Name',
                save: 'Save',
                cancel: 'Cancel',
            }
        }
    },
    computed: {
        navigation_data() {
            return this.$store.state.navigation_data;
        }
    },
    methods: {
        getRole() {
            let id = this.$route.params.id;
            this.$store.dispatch('getRole', id)
                .then((data) => {
                    this.role = data.role;
                    this.permissions = data.permissions;

                    this.$store.state.active_record = this.role.name;
                    this.$store.state.active_record = {
                        id: id,
                        name: this.role.name ? this.role.name : 'Create',
                        deleteAction: this.role.name && this.role.super !== 1
                    };

                    this.pageLoaded = true;
                }).catch(res => {
                    this.$router.push(res.redirect).catch(() => {});
                });
        },
        nameFocus() {
            this.nameClassFocus = 'focus';
        },
        nameBlur() {
            this.nameClassFocus = false;
        },
        savePermission(permission_item_id, type, allow) {
            if(this.role.super === 0) {
                let payload = {
                    role_id: this.role.id,
                    menu_item_id: permission_item_id,
                    permission: type,
                    allow: allow,
                }

                this.$store.dispatch('savePermission', payload)
                    .then((data) => {
                        if (type === 'view' && data.permission.permission === null) {
                            this.savePermission(permission_item_id, 'create', allow);
                            this.savePermission(permission_item_id, 'edit', allow);
                            this.savePermission(permission_item_id, 'delete', allow);
                        }

                        this.permissions.map((item) => {
                            if (item.id === data.permission.menu_item_id) {
                                item.permissions[data.permission.type] = data.permission.permission;
                            } else {
                                item.sub.map((sub_item) => {
                                    if (sub_item.id === data.permission.menu_item_id) {
                                        sub_item.permissions[data.permission.type] = data.permission.permission;
                                    }
                                })
                            }
                        })

                        this.$store.state.error_message = false;
                        this.$store.state.success_message = data.message;
                        this.$store.state.message_type = data.message_type ? data.message_type : 'system';
                    });
            }
        },
        saveRole() {
            let payload = {
                id: this.role.id,
                name: this.role.name,
            }

            this.$store.dispatch('saveRole', payload).then((data) => {
                this.$store.state.error_message = false;
                this.$store.state.success_message = data.message;
                this.$store.state.message_type = data.message_type ? data.message_type : 'system';
            });
        }
    },
    mounted() {
        this.getRole();
    },
    metaInfo() {
        return {
            title: this.title,
        }
    }
}
</script>
<style lang="scss" scoped>
    .content {
        font-family: var(--font-family);
        font-weight: normal;
        background: var(--background-color);
        color: var(--text-color);
        padding: 1rem;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;

        .card {
            background: rgba(var(--accent-color));
            padding: 2rem 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;

            .input-wrapper {
                grid-area: field;
                position: relative;
                align-items: flex-start;
                display: flex;
                cursor: text;
                font-size: 16px;
                letter-spacing: .009375em;
                padding: 12px 0;
                flex-direction: column;
                z-index: 1;

                &.name {
                    width: 70%;
                }

                &.locale {
                    width: 30%;
                    margin-left: 20px;
                }

                .label {
                    visibility: visible;
                    contain: layout paint;
                    margin-inline-start: 16px;
                    margin-inline-end: 16px;
                    max-width: calc(100% - 16px - 16px);
                    pointer-events: none;
                    position: absolute;
                    top: 20px;
                    transform-origin: left center;
                    transition: .15s cubic-bezier(.4,0,.2,1);
                    transition-property: all;
                    transition-property: opacity,transform;
                    color: rgba(var(--secondary-color), var(--opacity-point-three));
                }

                .label-floating {
                    visibility: hidden;
                    transform: translateY(-50%);
                    margin: 0 4px;
                    font-size: 0.75em;
                    left: 10px;
                    position: absolute;
                    z-index: 999;
                    padding: 0 10px;
                    font-weight: 600;
                    background: rgba(var(--accent-color));
                    color: rgba(var(--secondary-color), var(--opacity-point-three));
                }

                input {
                    color: #000;
                    flex: 1;
                    transition: .15s opacity cubic-bezier(.4,0,.2,1);
                    min-width: 0;
                    display: flex;
                    flex-wrap: wrap;
                    letter-spacing: .009375em;
                    min-height: 40px;
                    max-height: 40px;
                    padding-inline-start: 16px;
                    padding-inline-end: 16px;
                    padding-top: 5px;
                    padding-bottom: 6px;
                    width: 100%;
                    border-radius: 6px;
                    border: 1px solid rgba(var(--secondary-color), var(--opacity-point-three));
                    font-size: 16px;
                    background: rgba(var(--accent-color));
                    color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                    &:focus-visible {
                        outline: unset;
                    }
                }

                &.has-content {
                    .label {
                        visibility: hidden;
                    }

                    .label-floating {
                        visibility: visible;
                    }
                }

                &.error {
                    input {
                        border-color: #f6303a;
                    }

                    .label {
                        color: rgba(var(--primary-color));
                    }

                    .label-floating {
                        color: rgba(var(--primary-color));
                    }
                }

                &.focus {
                    .label {
                        visibility: hidden;
                    }

                    .label-floating {
                        visibility: visible;
                        color: rgba(var(--primary-color));
                    }

                    input {
                        border: 2px solid rgba(var(--primary-color));
                        padding-inline-start: 15px;
                    }
                }

                img {
                    cursor: pointer;
                    opacity: 0.6;
                    width: 24px;
                    position: absolute;
                    top: 28px;
                    right: 16px;
                }

                button {
                    position: absolute;
                    right: 13px;
                    top: 20px;
                    width: 24px;
                    height: 24px;
                    background: rgba(var(--primary-color));
                    border: rgba(var(--primary-color));
                    border-radius: 4px;
                    cursor: pointer;

                    &:hover {
                        opacity: var(--opacity-point-eight-seven);
                    }

                    svg {
                        color: rgba(var(--white-color));
                        fill: rgba(var(--white-color));
                    }
                }

                span.error {
                    color: rgba(var(--primary-color));
                    align-items: flex-end;
                    display: flex;
                    font-size: .75rem;
                    font-weight: 400;
                    letter-spacing: .0333333333em;
                    line-height: normal;
                    min-height: 22px;
                    overflow: hidden;
                    justify-content: space-between;
                    padding: 3px 14px 0 14px;
                }
            }

            .permissions {
                width: 100%;
                border-radius: 6px;
                margin-top: 30px;
                border: 1px solid rgba(var(--secondary-color), var(--opacity-point-four));

                .permissions-data {
                    display: flex;
                    flex-direction: column;
                    padding: 20px;

                    .permissions-header {
                        display: flex;
                        align-items: center;
                        justify-content: flex-start;
                        border-bottom: 1px solid rgba(var(--secondary-color), var(--opacity-point-four));
                        margin-bottom: 10px;
                        padding-bottom: 10px;

                        svg {
                            font-size: 24px;
                            height: 24px;
                            width: 24px;
                            margin-right: 10px;
                            color: rgba(var(--title-color));
                        }

                        .title {
                            line-height: 24px;
                            color: rgba(var(--title-color));
                            font-weight: 700;
                        }
                    }

                    .permissions-content {
                        display: flex;
                        flex-direction: column;
                        margin-top: 10px;

                        .header {
                            display: flex;
                            flex-direction: row;
                            padding: 0;

                            .name {
                                height: 40px;
                                padding: 10px 2px;
                                width: 200px;
                                color: rgba(var(--title-color));
                                flex-grow: 1;
                            }

                            .action {
                                height: 40px;
                                padding: 10px 2px;
                                cursor: pointer;
                                flex: 1;
                                font-weight: 700;
                                color: rgba(var(--title-color));
                                min-width: 28px;
                                text-align: center;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                white-space: nowrap;
                            }
                        }

                        .items {
                            display: flex;
                            flex-direction: column;

                            .item {
                                display: flex;
                                flex-direction: row;
                                font-weight: 600;
                                justify-content: space-between;

                                .name {
                                    height: 40px;
                                    padding: 10px 2px;
                                    width: 200px;
                                    color: rgba(var(--title-color));
                                    flex-grow: 1;
                                }

                                .action {
                                    height: 40px;
                                    padding: 10px 2px;
                                    flex: 1;

                                    &.pointer {
                                        cursor: pointer;
                                    }

                                    .checkbox {
                                        min-width: 24px;
                                        height: 24px;

                                        color: rgba(var(--secondary-color), var(--opacity-point-six));

                                        svg {
                                            width: 100%;
                                            height: 100%;
                                            color: rgba(var(--secondary-color), var(--opacity-point-six));

                                            &.check-active {
                                                color: rgba(var(--primary-color));
                                            }

                                            &.check-admin {
                                                color: rgba(var(--primary-color));
                                                fill: rgba(var(--primary-color));
                                            }
                                        }
                                    }
                                }

                                &.sub {
                                    font-weight: 400;
                                    padding-left: 20px;


                                    .name {
                                        width: 180px;
                                        flex-grow: 1;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            .actions {
                border: 0;
                flex-direction: row;
                padding: 0;
                align-items: center;
                align-self: center;
                display: flex;
                width: 100%;
                margin-top: 20px;

                button {
                    width: 50%;
                    border-radius: 4px;
                    cursor: pointer;
                    line-height: 23px;
                    outline: 0;
                    padding: 8px;
                    transition: all .2s ease-in-out;
                    text-transform: uppercase;
                    font-weight: 600;
                    font-size: 16px;

                    &:hover {
                        opacity: var(--opacity-point-eight-seven);
                    }

                    &:disabled {
                        opacity: var(--opacity-point-six);
                    }

                    &.primary {
                        background: rgba(var(--primary-button-background-color));
                        border: 1px solid rgba(var(--primary-button-background-color));
                        color: rgba(var(--primary-button-color));
                        margin-right: 10px;
                    }

                    &.secondary {
                        background: rgba(var(--secondary-button-background-color));
                        border: 1px solid rgba(var(--secondary-button-background-color));
                        color: rgba(var(--secondary-button-color));
                        margin-left: 10px;
                    }
                }

                &.right {
                    justify-content: end;
                }

                &.small {
                    button {
                        max-width: 200px;
                        min-width: 100px;
                    }
                }
            }
        }
    }
</style>
