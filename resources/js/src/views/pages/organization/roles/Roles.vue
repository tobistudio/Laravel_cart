<!-- =========================================================================================
  File Name: Roles.vue
  Description: Roles
========================================================================================== -->
<template>
    <div v-if="pageLoaded" class="content">
        <div class="card table">
            <DataTable :filters="filters" :value="roles">
                <template #header>
                    <div class="right">
                        <input v-model="filters['global'].value" placeholder="Search..." @focus="searchFocus" @blur="searchBlur" :class="searchClassFocus"/>
                        <button class="primary" @click="openAddRolePopup">Add role</button>
                    </div>
                </template>
                <template #empty> No Roles found. </template>
                <Column header="ROLE" field="name">
                    <template #body="slotProps">
                        <div class="role">
                            <router-link class="name" :to="'/system/organization/roles/' + slotProps.data.id">{{ slotProps.data.name }}</router-link>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <addRolePopup v-if="addRolePopup" @closePopup="closeAddRolePopup" @roleSaved="roleSaved"/>
    </div>
</template>

<script>
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';

import AddRolePopup from '../../../components/AddRolePopup.vue'

export default {
    components: {
        DataTable,
        Column,
        AddRolePopup
    },
    data() {
        return {
            pageLoaded: false,

            title: 'roles',
            roles: [],

            filters: {
                global: { value: null, matchMode: 'contains' }
            },
            searchClassFocus: false,

            addRolePopup: false,
        };
    },
    methods: {
        getRoles() {
            this.$store.dispatch('getRoles')
                .then((data) => {
                    this.roles = data.roles;
                    this.pageLoaded = true;
                });
        },
        searchFocus() {
            this.searchClassFocus = 'focus';
        },
        searchBlur() {
            this.searchClassFocus = false;
        },
        openAddRolePopup() {
            this.addRolePopup = true;
        },
        roleSaved(data) {
            this.roles.push(data.role);
            this.closeAddRolePopup();

            this.$router.push('/system/organization/roles/' + data.role.id).catch(() => {});
        },
        closeAddRolePopup() {
            this.addRolePopup = false;
        },
    },
    mounted() {
        this.getRoles();
    },
    metaInfo() {
        return {
            title: this.title,
        }
    }
};
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

        &.table {
            padding: 2rem 0;
        }

        :deep(.p-datatable) {
            .p-datatable-header {
                background: rgba(var(--accent-color));
                border-top: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                border-bottom: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                padding: 1rem 1rem;

                .right  {
                    display: flex;
                    justify-content: end;

                    input {
                        height: 40px;
                        padding: 8px  16px;
                        border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                        border-radius: 6px;
                        font-size: 16px;
                        background: rgba(var(--accent-color));
                        margin-right: 20px;
                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                        &:focus-visible {
                            outline: unset;
                        }

                        &.focus {
                            border: 2px solid rgba(var(--primary-color));
                            padding-inline-start: 15px;
                        }
                    }

                    button {
                        border-radius: 4px;
                        cursor: pointer;
                        line-height: 20px;
                        outline: 0;
                        padding: 8px 16px;
                        transition: all .2s ease-in-out;
                        text-transform: uppercase;
                        font-weight: 400;
                        font-size: 14px;
                        max-width: 200px;
                        width: auto;

                        &:hover {
                            opacity: var(--opacity-point-eight-seven);
                        }

                        &.primary {
                            background: rgba(var(--primary-button-background-color));
                            border: 1px solid rgba(var(--primary-button-background-color));
                            color: rgba(var(--primary-button-color));
                        }
                    }
                }

            }

            .p-datatable-thead  {
                tr {
                    th {
                        font-size: 12px;
                        font-weight: 500;
                        background: rgba(var(--accent-color));
                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                        border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                        border-width: 0 0 1px 0;
                    }
                }
            }

            .p-datatable-tbody {
                tr {
                    td {
                        font-size: 12px;
                        font-weight: 500;
                        padding: 0.5rem 1rem;
                        background: rgba(var(--accent-color));
                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                        border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                        border-width: 0 0 1px 0;

                        .role {
                            display: flex;
                            align-items: center;

                            .name {
                                font-size: .875rem;
                                line-height: 1.25rem;
                                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                                font-weight: 500;
                                text-decoration: unset;

                                &:hover {
                                    color: rgba(var(--primary-color));
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
</style>
