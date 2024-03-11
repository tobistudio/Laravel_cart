<!-- =========================================================================================
  File Name: Languages.vue
  Description: Languages
========================================================================================== -->
<template>
    <div v-if="pageLoaded" class="content">
        <div class="card">
            <DataTable :value="languages" :loading="loading">
                <template #empty> No languages found. </template>
                <template #loading> Loading Language data. Please wait. </template>
                <Column header="LANGUAGE">
                    <template #body="slotProps">
                        <div class="language">
                            <div class="flag">
                                <img :src="slotProps.data.country.flag" :alt="slotProps.data.name">
                            </div>
                            <div class="language-data">
                                <a class="language-name" href="#" @click.prevent="openLanguagePopup(slotProps.data)">{{ slotProps.data.name }}</a>
                                <div class="country-name">{{ slotProps.data.country.name }}</div>
                            </div>
                        </div>
                    </template>
                </Column>
                <Column field="role" header="PRIMARY">
                    <template #body="slotProps">
                        <div class="tag">
                            <span :class="primaryClass(slotProps.data.primary)">{{ getPrimary(slotProps.data.primary) }}</span>
                        </div>
                    </template>
                </Column>
                <Column header="ACTIVE">
                    <template #body="slotProps">
                        <div class="tag">
                            <span :class="activeClass(slotProps.data.active)">{{ getActive(slotProps.data.active) }}</span>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </div>

        <LanguagePopup v-if="languagePopup" @closePopup="closeLanguagePopup" @languageSaved="languageSaved" :language="language" :countries="countries"/>
    </div>
</template>

<script>
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';

import LanguagePopup from '../../components/LanguagePopup.vue'

export default {
    components: {
        DataTable,
        Column,
        LanguagePopup
    },
    data() {
        return {
            pageLoaded: false,
            loading: true,

            title: 'Languages',
            languages: [],

            languagePopup: false,
            language: null,
            countries: [],
        }
    },
    methods: {
        getLanguages() {
            this.$store.dispatch('getLanguages')
                .then((data) => {
                    this.loading = false;
                    this.languages = data.languages;
                    this.countries = data.countries;
                });
        },
        openLanguagePopup(language) {
            this.language = language;
            this.languagePopup = true;
        },
        languageSaved(data) {
            this.languages = data.languages;
            this.closeLanguagePopup();
        },
        closeLanguagePopup() {
            this.languagePopup = false;
        },
        getPrimary(primary) {
            if(primary === 1){
                return 'Primary'
            } else {
                return 'Not Primary'
            }
        },
        primaryClass(primary) {
            if(primary === 1){
                return 'green'
            } else {
                return 'red'
            }
        },
        getActive(active) {
            if(active === 1){
                return 'Active'
            } else {
                return 'Not Active'
            }
        },
        activeClass(active) {
            if(active === 1){
                return 'green'
            } else {
                return 'red'
            }
        }
    },
    mounted() {
        this.getLanguages();
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

                        .language {
                            display: flex;
                            align-items: center;

                            .flag {
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                width: 34px;
                                height: 34px;
                                margin-right: 12px;
                                border-radius: 50%;
                                font-weight: 700;
                            }

                            .language-data {
                                display: flex;
                                flex-direction: column;

                                .language-name {
                                    font-size: .875rem;
                                    line-height: 1.25rem;
                                    color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                                    font-weight: 500;
                                    text-decoration: unset;

                                    &:hover {
                                        color: rgba(var(--primary-color));
                                    }
                                }

                                .country-name {
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
                                    background: rgba(var(--red-color),var(--opacity-point-one-two));
                                    color: rgba(var(--red-color));
                                }

                                &.green {
                                    background: rgba(var(--green-color),var(--opacity-point-one-two));
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
