<!-- =========================================================================================
  File Name: Users.vue
  Description: Users
========================================================================================== -->
<template>
    <div v-if="pageLoaded" class="content">
        <div class="card">
            <DataTable :filters="filters" :value="users">
                <template #header>
                    <div class="right">
                        <input v-model="filters['global'].value" placeholder="Search..." @focus="searchFocus" @blur="searchBlur" :class="searchClassFocus"/>
                        <button class="primary" @click="addUser">Add user</button>
                    </div>
                </template>
                <template #empty> No Users found. </template>
                <Column header="USER" >
                    <template #body="slotProps">
                        <div class="user">
                            <div class="avatar">
                                {{ slotProps.data.first_name[0] + slotProps.data.last_name[0] }}
                            </div>
                            <div class="user-data">
                                <router-link class="name" :to="'/system/organization/users/' + slotProps.data.id">{{ slotProps.data.first_name + ' ' + slotProps.data.last_name }}</router-link>
                                <div class="email">{{ slotProps.data.email }}</div>
                            </div>
                        </div>
                    </template>
                </Column>
                <Column header="USER" field="first_name" :hidden="true"></Column>
                <Column header="USER" field="last_name" :hidden="true"></Column>
                <Column header="USER" field="email" :hidden="true"></Column>
                <Column header="ROLE" field="role.name">
                    <template #body="slotProps">
                        <div class="tag">
                            <span class="green">{{ slotProps.data.role.name }}</span>
                        </div>
                    </template>
                </Column>
                <Column header="STATUS" field="status_name">
                    <template #body="slotProps">
                        <div class="tag">
                            <span :class="statusClass(slotProps.data.status)">{{ getStatus(slotProps.data.id, slotProps.data.status) }}</span>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>
    </div>
</template>

<script>
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';

export default {
    components: {
        DataTable,
        Column,
    },
    data() {
        return {
            pageLoaded: false,

            title: 'users',
            users: [],

            filters: {
                global: { value: null, matchMode: 'contains' }
            },
            searchClassFocus: false,
        };
    },
    methods: {
        getUsers() {
            this.$store.dispatch('getUsers')
                .then((data) => {
                    this.users = data.users;
                    this.pageLoaded = true;
                });
        },
        searchFocus() {
            this.searchClassFocus = 'focus';
        },
        searchBlur() {
            this.searchClassFocus = false;
        },
        addUser() {

        },
        getStatus(id, status) {
            let status_name = '';
            if(status === 1){
                status_name = 'Active'
            } else {
                status_name = 'Inactive'
            }

            let findUserIndex = this.users.findIndex(user => user.id === id);
            this.users[findUserIndex].status_name = status_name;

            return this.users[findUserIndex].status_name;
        },
        statusClass(status) {
            if(status === 1){
                return 'green'
            } else {
                return 'red'
            }
        }
    },
    mounted() {
        this.getUsers();
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

                .right {
                    display: flex;
                    justify-content: end;

                    input {
                        height: 40px;
                        padding: 8px 16px;
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

            .p-datatable-thead {
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

                        .user {
                            display: flex;
                            align-items: center;

                            .avatar {
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                width: 34px;
                                height: 34px;
                                margin-right: 12px;
                                background: rgba(var(--red-color), var(--opacity-point-one-two));
                                color: rgba(var(--red-color));
                                border-radius: 50%;
                                font-weight: 700;
                            }

                            .user-data {
                                display: flex;
                                flex-direction: column;

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

                                .email {
                                    font-size: .75rem;
                                    line-height: 1rem;
                                    color: rgba(var(--secondary-color), var(--opacity-point-six));
                                }
                            }
                        }

                        .tag {

                            span {
                                padding: 3px 12px;
                                border-radius: 4px;

                                &.red {
                                    background: rgba(var(--red-color), var(--opacity-point-one-two));
                                    color: rgba(var(--red-color));
                                }

                                &.green {
                                    background: rgba(var(--green-color), var(--opacity-point-one-two));
                                    color: rgba(var(--green-color));
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
