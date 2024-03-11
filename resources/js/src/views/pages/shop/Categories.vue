<!-- =========================================================================================
  File Name: Categories.vue
  Description: Categories
========================================================================================== -->
<template>
    <div v-if="pageLoaded" class="content">
        <div class="card table">
            <TreeTable :value="pages" :filters="filters">
                <template #header>
                    <div class="right">
                        <input v-model="filters['global']" placeholder="Search..." @focus="searchFocus" @blur="searchBlur" :class="searchClassFocus"/>
                        <router-link class="button primary" :to="'/system/shop/categories/product_category'">Add Category</router-link>
                    </div>
                </template>
                <template #empty> No Categories found.</template>
                <Column field="name" header="Name" expander>
                    <template #body="slotProps">
                        <div class="image" v-if="slotProps.node.data.image">
                            <img :src="slotProps.node.data.image" :alt="slotProps.node.data.name">
                        </div>
                        <div :class="['name', slotProps.node.data.image ? 'with-image' : '']">
                            {{ slotProps.node.data.name }}
                        </div>
                    </template>
                </Column>
                <Column field="languages" header="">
                    <template #header>
                        <div class="languages">
                            <div class="language" v-for="language in languages">
                                <img :src="language.country.flag" :alt="language.name" class="flag">
                            </div>
                        </div>
                    </template>
                    <template #body="slotProps">
                        <div class="languages">
                            <div class="language" v-for="language in slotProps.node.data.languages">
                                <router-link class="button primary"
                                             :to="'/system/shop/categories/product_category/' + slotProps.node.data.id + '/' + language.id">
                                    <svg v-if="language.page_id" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="edit"
                                         viewBox="0 0 24 24">
                                        <path stroke="currentColor"
                                              d="M8.707 19.707 18 10.414 13.586 6l-9.293 9.293a1.003 1.003 0 0 0-.263.464L3 21l5.242-1.03c.176-.044.337-.135.465-.263zM21 7.414a2 2 0 0 0 0-2.828L19.414 3a2 2 0 0 0-2.828 0L15 4.586 19.414 9 21 7.414z"></path>
                                    </svg>
                                </router-link>

                                <router-link v-if="!language.page_id" class="button primary"
                                             :to="'/system/shop/categories/product_category/' + slotProps.node.data.id + '/' + language.id">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="create" viewBox="0 0 24 24">
                                        <path stroke="currentColor" d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path>
                                    </svg>
                                </router-link>
                            </div>
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

            title: 'pages',
            pages: [],
            languages: [],

            filters: {},
            searchClassFocus: false,

            trans: {
                home: 'Home page',
                search: 'Search page',
                log_in: 'Log in page',
                sign_up: 'Register page',
                forgot_password: 'Forgot password page',
                user_profile: 'User profile page',
                cart: 'Cart page',
                checkout: 'Checkout page',
                page_not_found: 'Page not found page',
                maintenance_page: 'Maintenance page',
            }
        };
    },
    methods: {
        getPages() {
            this.$store.dispatch('getPages', 'product_category')
                .then((data) => {
                    this.pages = data.pages;
                    this.languages = data.languages;
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
        this.getPages();
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

                    a {
                        &.button {
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
                            text-decoration: unset;

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
            }

            .p-treetable-thead {
                tr {
                    th {
                        font-size: 12px;
                        font-weight: 500;
                        background: rgba(var(--accent-color));
                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                        border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                        border-width: 0 0 1px 0;

                        .languages {
                            display: flex;
                            justify-content: end;

                            .language {
                                width: 30px;
                                margin-right: 16px;

                                .flag {
                                    height: 16px;
                                }
                            }
                        }
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

                        .image {
                            display: inline-block;
                            position: absolute;
                        }

                        .name {
                            display: inline-block;
                            font-size: .875rem;
                            color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                            font-weight: 500;
                            text-decoration: unset;
                            line-height: 32px;

                            &.with-image {
                                margin-left: 50px;
                            }
                        }

                        .languages {
                            display: flex;
                            justify-content: end;

                            .language {
                                margin-right: 16px;
                                display: flex;
                                align-items: center;
                                cursor: pointer;
                                width: 30px;

                                .flag {
                                    height: 14px;
                                }

                                .edit {
                                    height: 18px;
                                    width: 18px;
                                    color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                                    fill: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                                    &:hover {
                                        color: rgba(var(--secondary-color), var(--opacity-point-four));
                                        fill: rgba(var(--secondary-color), var(--opacity-point-four));
                                    }
                                }

                                .create {
                                    height: 18px;
                                    width: 18px;
                                    color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                                    fill: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                                    &:hover {
                                        color: rgba(var(--secondary-color), var(--opacity-point-four));
                                        fill: rgba(var(--secondary-color), var(--opacity-point-four));
                                    }
                                }
                            }
                        }
                    }

                    &[aria-level="2"] {
                        td {
                            button {
                                &[style*="visible"] {
                                    margin-left: 2rem !important;
                                }
                            }
                        }
                    }

                    &[aria-level="3"] {
                        td {
                            button {
                                &[style*="visible"] {
                                    margin-left: 6rem !important;
                                }

                                &[style*="hidde"] {
                                    margin-left: 4rem !important;
                                }
                            }
                        }
                    }

                    &[aria-level="4"] {
                        td {
                            button {
                                &[style*="hidden"] {
                                    margin-left: 9rem !important;
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
