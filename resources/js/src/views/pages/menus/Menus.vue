<!-- =========================================================================================
  File Name: Menus.vue
  Description: Menus
========================================================================================== -->
<template>
    <div v-if="pageLoaded" class="content">
        <div class="card">
            <DataTable :value="menus" :loading="loading">
                <template #empty> No menu found. </template>
                <template #loading> Loading Menu data. Please wait. </template>
                <Column header="MENU">
                    <template #body="slotProps">
                        <router-link class="name" :to="'/system/menus/' + slotProps.data.id">{{ slotProps.data.name }}</router-link>
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
        Column
    },
    data() {
        return {
            pageLoaded: false,
            loading: true,

            title: 'Menu',
            menus: [],
        }
    },
    methods: {
        getMenus() {
            this.$store.dispatch('getMenus')
                .then((data) => {
                    this.loading = false;
                    this.menus = data.menus;
                });
        },
    },
    mounted() {
        this.getMenus();
        this.pageLoaded = true;
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
        padding: 2rem 0;
        border-radius: 10px;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px -1px #32475c0f, 0 4px 5px #32475c0a, 0 1px 10px #32475c0a;

        :deep(.p-datatable) {
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
</style>
