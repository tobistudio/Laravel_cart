<!-- =========================================================================================
  File Name: Newsletter.vue
  Description: Newsletter
========================================================================================== -->
<template>
    <div v-if="pageLoaded" class="content">
        <div class="card table">
            <TreeTable :value="subscribers" :filters="filters">
                <template #header>
                    <div class="right">
                        <input v-model="filters['global']" placeholder="Search..." @focus="searchFocus" @blur="searchBlur" :class="searchClassFocus"/>
                    </div>
                </template>
                <template #empty> No Newsletter users found. </template>
                <Column field="email" header="Name">
                    <template #body="slotProps">
                        <div class="name">
                            {{ slotProps.node.data.email }}
                        </div>
                    </template>
                </Column>
                <Column field="language" header="Language" class="language">
                    <template #body="slotProps">
                        <img :src="slotProps.node.data.flag" alt="" class="flag">
                    </template>
                </Column>
                <Column field="created_at" header="Created at">
                    <template #body="slotProps">
                        <div class="name">
                            {{ slotProps.node.data.created_at }}
                        </div>
                    </template>
                </Column>
            </TreeTable>
        </div>
    </div>
</template>

<script>
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import TreeTable from 'primevue/treetable';

export default {
    components: {
        DataTable,
        Column,
        TreeTable
    },
    data() {
        return {
            pageLoaded: false,

            title: 'Newsletter',
            subscribers: [],

            filters: {},
            searchClassFocus: false,

            trans: {
            }
        };
    },
    methods: {
        getSubscribers() {
            this.$store.dispatch('getSubscribers')
                .then((data) => {
                    this.subscribers = data.subscribers;
                    this.pageLoaded = true;
                });
        },
        searchFocus() {
            this.searchClassFocus = 'focus';
        },
        searchBlur() {
            this.searchClassFocus = false;
        },
    },
    mounted() {
        this.getSubscribers();
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
        box-shadow: 0 2px 4px -1px #32475c0f, 0 4px 5px #32475c0a, 0 1px 10px #32475c0a;

        &.table {
            padding: 2rem 0;
        }

        :deep(.p-treetable) {
            .p-treetable-header {
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
                }
            }

            .p-treetable-thead  {
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

            .p-treetable-tbody {
                tr {
                    td {
                        font-size: 12px;
                        font-weight: 500;
                        padding: 0.5rem 1rem;
                        background: rgba(var(--accent-color));
                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                        border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                        border-width: 0 0 1px 0;

                        .p-treetable-toggler {
                            margin-top: -4px;

                            &:focus {
                                box-shadow: unset;
                            }

                            &:focus-visible {
                                outline: unset;
                            }
                        }

                        &.email {
                            display: inline-block;
                            font-size: .875rem;
                            color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                            font-weight: 500;
                            text-decoration: unset;
                            line-height: 32px;
                        }

                        &.language {
                            padding: 0 1rem;

                            .flag {
                                height: 24px;
                                margin-top: 5px;
                            }
                        }
                    }
                }
            }
        }
    }
}
</style>
