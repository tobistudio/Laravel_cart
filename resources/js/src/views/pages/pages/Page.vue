<!-- =========================================================================================
  File Name: Page.vue
  Description: Page
========================================================================================== -->
<template>
    <div v-if="pageLoaded" class="content">
        <div v-if="error_message" class="error-message">{{ error_message }}</div>

        <div class="row">
            <div class="full">
                <div class="card tabs" v-if="page.general.id">
                    <div v-for="tab in tabs" :class="['tab', tab.active ? 'active' : '']" @click="openTab(tab.key)">{{ tab.name }}</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="four-one">
                <template v-for="tab in tabs">
                    <template v-if="tab.key === 'general' && tab.active">
                        <general-tab
                            :pageGeneral="page.general"
                            :productWarehouseCount="productWarehouseCount"
                            :productWarehousePacked="productWarehousePacked"
                            :pageProductCategoryData="pageProductCategoryData"
                            :pageProductAttributes="pageProductAttributes"
                            :pageProductSubstitutes="pageProductSubstitutes"
                            :pageProductData="page.product_data"
                            :pageProductParameters="productParameters"
                            :pageProductCategories="page.product_categories"
                            :pageProductManufacturers="page.product_manufacturers"
                            :pageProductTypes="page.product_types"
                            :pageProductLabels="page.product_labels"
                            :featuredImageValidation="featured_image_validation"
                            :nameValidation="name_validation"
                            :skuValidation="sku_validation"
                            :priceValidation="price_validation"
                            :specialPriceValidation="special_price_validation"
                            :selectedLanguage="selectedLanguage"
                            :removeLanguagePageBlockOrItem="removeLanguagePageBlockOrItem"

                            @vehicleUpdated="vehicleUpdated"
                            @openDeleteConfirmPopup="openDeleteConfirmPopup"
                        ></general-tab>
                    </template>
                    <template v-if="tab.key === 'seo' && tab.active">
                        <seo-tab
                            :pageSeo="page.seo"
                            :metaImageValidation="meta_image_validation"
                        ></seo-tab>
                    </template>
                    <template v-if="tab.key === 'blocks' && tab.active">
                        <blocks-tab
                            :pageBlocks="page.blocks"
                            :pageSidebarBlocks="page.sidebar_blocks"
                            :removeLanguagePageBlockOrItem="removeLanguagePageBlockOrItem"
                            :vehicleBrands="page.vehicle_brands"
                            :productCategories="page.product_categories"
                            :pagesOptions="pagesOptions"
                            @pageSidebarBlockOrderChanged="pageSidebarBlockOrderChanged"
                            @pageBlockOrderChanged="pageBlockOrderChanged"
                            @openDeleteConfirmPopup="openDeleteConfirmPopup"
                        ></blocks-tab>
                    </template>
                </template>
            </div>
            <div class="one-four ml-20">
                <div :class="['card', 'with-header', parentPagesOpen ? 'open' : '']" v-if="parentPages">
                    <div class="header">
                        <div class="title">Parent page</div>
                        <div class="controls">
                            <div class="button" @click="toggleParentPages" v-if="parentPagesOpen">
                                <i class='bx bx-chevron-up'></i>
                            </div>
                            <div class="button" @click="toggleParentPages" v-if="!parentPagesOpen">
                                <i class='bx bx-chevron-down'></i>
                            </div>
                        </div>
                    </div>

                    <div class="content" v-if="parentPagesOpen">
                        <div class="parent-pages">
                            <WDSelect field="selectedParentPage" label="name" :title="trans.parentPage" :options="parentPages"
                                      :selectedOption="selectedParentPage" @selectedOptionUpdated="selectedOptionUpdated"></WDSelect>
                        </div>
                    </div>
                </div>

                <div :class="['card', 'with-header', languageOpen ? 'open' : '']">
                    <div class="header">
                        <img :src="selectedLanguage.country.flag" :alt="selectedLanguage.name">
                        <div class="title">Language</div>
                        <div class="controls">
                            <div class="button" @click="toggleLanguage" v-if="languageOpen">
                                <i class='bx bx-chevron-up'></i>
                            </div>
                            <div class="button" @click="toggleLanguage" v-if="!languageOpen">
                                <i class='bx bx-chevron-down'></i>
                            </div>
                        </div>
                    </div>

                    <div class="content" v-if="languageOpen">
                        <div class="languages">
                            <WDSelect field="selectedLanguage" label="name" :title="trans.language" :options="languages" :selectedOption="selectedLanguage"
                                      @selectedOptionUpdated="selectedOptionUpdated"></WDSelect>
                        </div>
                    </div>
                </div>

                <div :class="['card', 'with-header', translationsOpen ? 'open' : '']">
                    <div class="header">
                        <div class="title">Translations</div>
                        <div class="controls">
                            <div class="button" @click="toggleTranslations" v-if="translationsOpen">
                                <i class='bx bx-chevron-up'></i>
                            </div>
                            <div class="button" @click="toggleTranslations" v-if="!translationsOpen">
                                <i class='bx bx-chevron-down'></i>
                            </div>
                        </div>
                    </div>

                    <div class="content" v-if="translationsOpen">
                        <div class="translations">
                            <template v-for="language_page in language_pages">
                                <div class="language" v-if="language_page.show">
                                    <img :src="language_page.flag" :alt="language_page.name" @click="openLanguagePage(language_page.language_id)">

                                    <div :class="['input-wrapper', 'input', language_page.page_name ? 'has-content' : '', language_page.focus ? 'focus' : '']">
                                        <div class="label">{{ trans.name }}</div>
                                        <div class="label-floating">{{ trans.name }}</div>
                                        <input v-model="language_page.page_name " type="text" @focus="languagePageFocus(language_page)"
                                               @blur="languagePageBlur(language_page)"/>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div :class="['card', 'with-header', popularOpen ? 'open' : '']" v-if="$route.params.type === 'vehicle'">
                    <div class="header">
                        <div class="title">Popular</div>
                        <div class="controls">
                            <div class="button" @click="togglePublish" v-if="popularOpen">
                                <i class='bx bx-chevron-up'></i>
                            </div>
                            <div class="button" @click="togglePublish" v-if="!popularOpen">
                                <i class='bx bx-chevron-down'></i>
                            </div>
                        </div>
                    </div>

                    <div class="content" v-if="popularOpen">
                        <WDSelect field="selectedPopular" label="label" :title="trans.popular" :options="popular_options" :selectedOption="selectedPopular"
                                  @selectedOptionUpdated="selectedOptionUpdated"></WDSelect>
                    </div>
                </div>

                <div :class="['card', 'with-header', publishOpen ? 'open' : '']">
                    <div class="header">
                        <div class="title">Publish</div>
                        <div class="controls">
                            <div class="button" @click="togglePublish" v-if="publishOpen">
                                <i class='bx bx-chevron-up'></i>
                            </div>
                            <div class="button" @click="togglePublish" v-if="!publishOpen">
                                <i class='bx bx-chevron-down'></i>
                            </div>
                        </div>
                    </div>

                    <div class="content" v-if="publishOpen">
                        <WDSelect field="selectedStatus" label="label" :title="trans.status" :options="status_options" :selectedOption="selectedStatus"
                                  @selectedOptionUpdated="selectedOptionUpdated"></WDSelect>

                        <div class="actions">
                            <button class="primary" @click="savePage">{{ trans.save }}</button>
                            <button class="secondary" @click="cancel">{{ trans.cancel }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {defineAsyncComponent} from 'vue'

export default {
    props: {
        removeLanguagePageBlockOrItem: {
            type: Object
        },
    },
    data() {
        return {
            pageLoaded: false,

            title: 'Create page',

            tabs: [
                {name: 'General', key: 'general', active: true},
                {name: 'SEO', key: 'seo', active: false},
                {name: 'Blocks', key: 'blocks', active: false}
            ],

            page: {},
            featured_image_validation: null,
            name_validation: null,
            sku_validation: null,
            price_validation: null,
            special_price_validation: null,

            vehicleBrands: [],

            pageProductCategoryData: null,

            meta_image_validation: null,

            parentPages: null,
            selectedParentPage: null,
            parentPagesOpen: true,

            languages: [],
            selectedLanguage: {},
            country_validation: null,
            languageOpen: true,

            language_pages: [],
            translationsOpen: true,

            popular_options: [
                {label: 'No', value: 0},
                {label: 'Yes', value: 1},
            ],
            selectedPopular: {},
            popularOpen: true,

            status_options: [
                {label: 'Draft', value: 0},
                {label: 'Published', value: 1},
            ],
            selectedStatus: {},
            publishOpen: true,

            error_message: null,

            trans: {
                parentPage: 'Parent page',
                language: 'language',
                popular: 'Popular',
                status: 'Status',
                save: 'Save',
                cancel: 'Cancel',
                message: {
                    name_required: 'Page name is required',
                    image_must_be_minimum_size: 'Image must be minimum 1200x630 px'
                }
            },

            pagesOptions: [],

            pageProductAttributes: [],
            pageProductSubstitutes: [],
            productParameters: [],
            productWarehouseCount: [],
            productWarehousePacked: {},
        }
    },
    components: {
        WDSelect: defineAsyncComponent(() => import('../../components/WD-select.vue')),

        generalTab: defineAsyncComponent(() => import('./tabs/General.vue')),
        seoTab: defineAsyncComponent(() => import('./tabs/Seo.vue')),
        blocksTab: defineAsyncComponent(() => import('./tabs/Blocks.vue')),
    },
    methods: {
        getPage(lang_id = null) {
            let payload = {
                type: this.$route.params.type,
                page_id: this.$route.params.page_id,
                language_id: lang_id ? lang_id : this.$route.params.language_id
            }

            this.$store.dispatch('getPage', payload)
                .then((data) => {
                    this.pageProductCategoryData = data.page.product_category_data;
                    if(data.page.product_warehouse) {
                        this.productWarehouseCount = data.page.product_warehouse.count;
                        this.productWarehousePacked = data.page.product_warehouse.packed;
                    }
                    this.page = data.page;
                    this.languages = data.languages;
                    this.selectedLanguage = data.active_language;
                    this.language_pages = data.language_pages;
                    this.language_pages.map((language_page) => {
                        language_page.focus = false;
                    });
                    this.pageProductAttributes = data.page.product_attributes;
                    this.pageProductSubstitutes = data.page.product_substitutes || [];
                    this.productParameters = data.page.product_parameters;

                    this.$store.state.active_record = {
                        id: this.page.general.id ? this.page.general.id : null,
                        name: this.page.general.name ? this.page.general.name : 'Create',
                        deleteAction: !!this.page.general.name
                    };

                    if (this.$route.params.type === 'vehicle') {
                        let find_popular_index = this.popular_options.findIndex(popular => popular.value === this.page.general.popular);
                        this.selectedPopular = this.popular_options[find_popular_index];
                    }

                    let find_status_index = this.status_options.findIndex(status => status.value === this.page.general.status);
                    this.selectedStatus = this.status_options[find_status_index];

                    if (this.$route.params.type === 'product') {
                        if (this.page.product_data) {
                            let find_manufacturer_index = this.page.product_manufacturers.findIndex(pm => pm.value === this.page.product_data.product_manufacturer_id)
                            if (find_manufacturer_index >= 0) {
                                this.selectedProductManufacturer = this.page.product_manufacturers[find_manufacturer_index];
                            }

                            this.selectedProductCategories = this.page.product_data.product_categories;
                            this.selectedProductTypes = this.page.product_data.product_types;
                            this.selectedProductLabels = this.page.product_data.product_labels;
                        }
                    }

                    if (this.$route.params.type !== 'blog_post' && this.$route.params.type !== 'vehicle' && this.$route.params.type !== 'manufacturer' && this.$route.params.type !== 'product') {
                        this.parentPages = data.parent_pages;
                        this.parentPages.map((lpp) => {
                            if (lpp.id === data.active_parent_page_id) {
                                this.selectedParentPage = lpp;
                            }

                            lpp.sub.map((s) => {
                                if (s.id === data.active_parent_page_id) {
                                    this.selectedParentPage = s;
                                }
                            })
                        })

                        this.pagesOptions = data.parent_pages;
                    }

                    this.pageLoaded = true;
                }).catch(res => {
                this.$router.push(res.redirect).catch(() => {
                });
            });
        },
        vehicleUpdated(data) {
            this.vehicleBrands = data;
        },
        openTab(key) {
            this.tabs.map((tab) => {
                tab.active = tab.key === key;
            });
        },
        pageSidebarBlockOrderChanged(blocks) {
            this.page.sidebar_blocks = blocks;
        },
        pageBlockOrderChanged(blocks) {
            this.page.blocks = blocks;
        },
        openDeleteConfirmPopup(deleteData) {
            let data = {
                action: deleteData.action,
                type: deleteData.type,
                name: deleteData.name,
                id: deleteData.id,
                item_id: deleteData.item_id,
                item_block_id: deleteData.item_block_id,
                item_block_item_id: deleteData.item_block_item_id,
            }

            this.$emit('openDeleteConfirmPopup', data);
        },
        toggleParentPages() {
            this.parentPagesOpen = !this.parentPagesOpen;
        },
        toggleLanguage() {
            this.languageOpen = !this.languageOpen;
        },
        toggleTranslations() {
            this.translationsOpen = !this.translationsOpen;
        },
        togglePublish() {
            this.publishOpen = !this.publishOpen;
        },
        openLanguagePage(language_id) {
            if (this.$route.params.page_id) {
                let redirect_url = '/system/pages/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + language_id
                if (this.$route.params.type === 'blog_category') {
                    redirect_url = '/system/blog/categories/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + language_id
                } else if (this.$route.params.type === 'blog_post') {
                    redirect_url = '/system/blog/posts/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + language_id
                } else if (this.$route.params.type === 'product_category') {
                    redirect_url = '/system/shop/categories/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + language_id
                } else if (this.$route.params.type === 'vehicle') {
                    redirect_url = '/system/shop/vehicles/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + language_id
                }

                this.$router.push(redirect_url).catch(() => {
                });
                this.getPage(language_id);
            } else {
                this.language_pages.map((language) => {
                    language.show = language.language_id !== language_id;
                });
            }
        },
        languagePageFocus(languagePage) {
            languagePage.focus = true;
        },
        languagePageBlur(languagePage) {
            languagePage.focus = false;
        },
        selectedOptionUpdated(option, field) {
            this[field] = option;

            if (field === 'selectedLanguage') {
                let selected_language_id = option.id;

                if (this.$route.params.page_id) {
                    let redirect_url = '/system/pages/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + selected_language_id
                    if (this.$route.params.type === 'blog_category') {
                        redirect_url = '/system/blog/categories/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + selected_language_id
                    } else if (this.$route.params.type === 'blog_post') {
                        redirect_url = '/system/blog/posts/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + selected_language_id
                    } else if (this.$route.params.type === 'product_category') {
                        redirect_url = '/system/shop/categories/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + selected_language_id
                    } else if (this.$route.params.type === 'vehicle') {
                        redirect_url = '/system/shop/vehicles/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + selected_language_id
                    }

                    this.getPage(selected_language_id);
                    this.$router.push(redirect_url).catch(() => {});
                } else {
                    this.language_pages.map((language) => {
                        language.show = language.language_id !== selected_language_id;
                    });
                }
            }
        },
        selectedMultiOptionsUpdated(options, field) {
            this[field] = options;
        },
        savePage() {
            let payload = {
                type: this.$route.params.type,
                page_id: this.$route.params.page_id,
                name: this.page.general.name,
                description: this.page.general.description,
                featured_image: this.page.general.featured_image,
                page_header: this.page.general.page_header,
                featured_image_big: this.page.general.featured_image_big,
                breadcrumbs: this.page.general.breadcrumbs,
                newsletter: this.page.general.newsletter,
                meta_title: this.page.seo ? this.page.seo.title : null,
                meta_description: this.page.seo ? this.page.seo.description : null,
                meta_image: this.page.seo ? this.page.seo.image : null,
                index: this.page.seo ? this.page.seo.index : null,
                fallow: this.page.seo ? this.page.seo.fallow : null,
                sidebar_blocks: this.page.sidebar_blocks ? this.page.sidebar_blocks : [],
                blocks: this.page.blocks ? this.page.blocks : [],
                parent_page: this.selectedParentPage,
                language: this.selectedLanguage,
                language_pages: this.language_pages.filter(page => page.show === true),
                status: this.selectedStatus.value,
                popular: this.selectedPopular ? this.selectedPopular.value : null
            }

            if (this.$route.params.type === 'product_category') {
                let product_category_data = {
                    product_category_data: this.page.product_category_data
                };

                payload = {
                    ...payload,
                    ...(product_category_data)
                }
            }

            if (this.$route.params.type === 'product') {
                let product_data = {
                    product_data: {
                        id: this.page.product_data.id,
                        sku: this.page.product_data.sku,
                        price: this.page.product_data.price,
                        special_price: this.page.product_data.special_price,
                        product_categories: this.selectedProductCategories,
                        product_manufacturer_id: this.selectedProductManufacturer ? this.selectedProductManufacturer.value : null,
                        product_types: this.selectedProductTypes,
                        product_labels: this.selectedProductLabels,
                        gallery: this.page.general.gallery ? this.page.general.gallery : null,
                        attributes: this.page.general.attributes ? this.page.general.attributes : null,
                        substitutes: this.page.general.substitutes ? this.page.general.substitutes : null,
                        parameters: this.page.general.parameters ? this.page.general.parameters : null,
                        warehouse_product: {
                            count: this.page.general.warehouse_product && this.page.general.warehouse_product.count
                                ? this.page.general.warehouse_product.count
                                : null,
                            packed_weight: this.page.general.warehouse_product && this.page.general.warehouse_product.packedWeight
                                ? this.page.general.warehouse_product.packedWeight
                                : null,
                            packed_width: this.page.general.warehouse_product && this.page.general.warehouse_product.packedWidth
                                ? this.page.general.warehouse_product.packedWidth
                                : null,
                            packed_height: this.page.general.warehouse_product && this.page.general.warehouse_product.packedHeight
                                ? this.page.general.warehouse_product.packedHeight
                                : null,
                            packed_volume: this.page.general.warehouse_product && this.page.general.warehouse_product.packedVolume
                                ? this.page.general.warehouse_product.packedVolume
                                : null,
                        }
                    },
                }

                payload = {
                    ...payload,
                    ...(product_data)
                }
            }

            if(this.$route.params.type === 'vehicle') {
                let vehicle_brands = {
                    vehicle_brands: this.vehicleBrands
                }

                payload = {
                    ...payload,
                    ...(vehicle_brands)
                };
            }

            this.$store.dispatch('savePage', payload).then((data) => {
                this.name_validation = null;
                this.sku_validation = null;
                this.price_validation = null;
                this.special_price_validation = null;
                this.featured_image_validation = null;
                this.meta_image_validation = null;
                this.error_message = null;

                this.$store.state.error_message = false;
                this.$store.state.success_message = data.message;
                this.$store.state.message_type = data.message_type ? data.message_type : 'system';

                if (data.redirect) {
                    this.$router.push('/' + data.redirect).catch(() => {
                    });
                } else {
                    this.page.general.featured_image = data.page.general.featured_image;
                    this.page.seo.image = data.page.seo.image;
                    this.page.sidebar_blocks = data.page.sidebar_blocks;
                    this.page.blocks = data.page.blocks;
                }
            }).catch(res => {
                if (res.errors) {
                    this.name_validation = res.errors.name ? this.trans.message[res.errors.name[0]] : null;
                    this.sku_validation = res.errors.sku ? this.trans.message[res.errors.sku[0]] : null;
                    this.price_validation = res.errors.price ? this.trans.message[res.errors.price[0]] : null;
                    this.special_price_validation = res.errors.special_price ? this.trans.message[res.errors.special_price[0]] : null;
                    this.featured_image_validation = res.errors.featured_image ? this.trans.message[res.errors.featured_image[0]] : null;
                    this.meta_image_validation = res.errors.meta_image ? this.trans.message[res.errors.meta_image[0]] : null;
                } else {
                    this.error_message = res.message ? this.trans.message[res.message] : null;
                }
            });
        },
        cancel() {
            this.$router.push('/system/pages').catch(() => {
            });
        }
    },
    mounted() {
        this.getPage();

        document.addEventListener('click', this.handleBlocksClickOutside);
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
    display: flex;
    flex-direction: column;

    .row {
        display: flex;

        .full {
            width: 100%;
        }

        .half {
            width: 50%;

            &:first-of-type {
                padding-right: 10px;
            }

            &:nth-of-type(2) {
                padding-left: 10px;
            }
        }

        .three-one {
            width: 66.67%;
        }

        .one-three {
            width: 33.33%;
        }

        .four-one {
            width: 75%;
        }

        .one-four {
            width: 25%;
        }

        .ml-20 {
            margin-left: 20px
        }

        .mr-20 {
            margin-right: 20px
        }

        .card {
            background: rgba(var(--accent-color));
            padding: 2rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px -1px #32475c0f, 0 4px 5px #32475c0a, 0 1px 10px #32475c0a;

            &.tabs {
                display: flex;
                padding: 0;
                border-radius: 8px 8px 0 0;

                .tab {
                    padding: 8px 12px;
                    border-bottom: 4px solid rgba(var(--accent-color));
                    cursor: pointer;
                    color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                    &.active {
                        color: rgba(var(--primary-color));
                        font-weight: 700;
                        border-bottom: 4px solid rgba(var(--primary-color));
                    }
                }
            }

            &.with-header {
                padding: 0;

                .header {
                    display: flex;
                    align-items: center;
                    padding: 0.5rem 1rem;

                    img {
                        height: 20px;
                        margin-right: 10px;
                    }

                    .title {
                        font-weight: 700;
                        color: rgba(var(--title-color));
                        flex-grow: 1;
                    }

                    .controls {
                        display: flex;

                        .button {
                            width: 24px;
                            height: 24px;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            border-radius: 50%;
                            cursor: pointer;

                            i {
                                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                                font-size: 24px;
                            }

                            &:hover {
                                background: rgba(var(--icon-hover-background-color));
                            }
                        }
                    }
                }

                .content {
                    display: flex;
                    flex-direction: column;
                    padding: 0.5rem 1rem;
                    margin: 0;
                }

                &.open {
                    .header {
                        border-bottom: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                    }
                }
            }

            .input-wrapper {
                &.input {
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
                    flex-grow: 1;
                }

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
                    transition: .15s cubic-bezier(.4, 0, .2, 1);
                    transition-property: all;
                    transition-property: opacity, transform;
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

                .label-more {
                    height: 75px;
                }

                input {
                    flex: 1;
                    transition: .15s opacity cubic-bezier(.4, 0, .2, 1);
                    min-width: 0;
                    display: flex;
                    flex-wrap: wrap;
                    letter-spacing: .009375em;
                    min-height: 40px;
                    max-height: 40px;
                    padding: 6px 16px;
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

                textarea {
                    flex: 1;
                    transition: .15s opacity cubic-bezier(.4, 0, .2, 1);
                    min-width: 0;
                    display: flex;
                    flex-wrap: wrap;
                    letter-spacing: .009375em;
                    max-height: 40px;
                    padding: 16px 16px 6px 16px;
                    width: 100% !important;
                    min-height: 200px;
                    border-radius: 6px;
                    border: 1px solid rgba(var(--secondary-color), var(--opacity-point-three));
                    font-size: 16px;
                    background: rgba(var(--accent-color));
                    color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                    &:focus-visible {
                        outline: unset;
                    }
                }

                &.image {
                    input {
                        display: none;
                    }
                }

                .image-placeholder {
                    flex: 1;
                    transition: .15s opacity cubic-bezier(.4, 0, .2, 1);
                    min-width: 0;
                    display: flex;
                    flex-wrap: wrap;
                    letter-spacing: .009375em;
                    padding: 16px;
                    width: 100% !important;
                    min-height: 200px;
                    border-radius: 6px;
                    border: 1px solid rgba(var(--secondary-color), var(--opacity-point-three));
                    font-size: 16px;
                    background: rgba(var(--accent-color));
                    color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                    position: relative;
                    cursor: pointer;

                    .label {
                        top: -10px;
                        left: 10px;
                        position: absolute;
                        font-size: 0.75em;
                        z-index: 1;
                        background: rgba(var(--accent-color));
                        color: rgba(var(--secondary-color), var(--opacity-point-three));
                        padding: 0 10px;
                        margin: 0 4px;
                        font-weight: 600;
                    }

                    .image {
                        width: 100%;
                        padding-top: 8px;

                        .placeholder {
                            width: 100%;
                            height: 200px;
                            background: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                        }

                        img {
                            width: 100%;
                            height: auto;
                            position: static;
                        }
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
                        border-color: rgba(var(--primary-color));
                    }

                    textarea {
                        border-color: rgba(var(--primary-color));
                    }

                    .image-placeholder {
                        border-color: rgba(var(--primary-color));
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
                        padding-left: 15px;
                    }

                    textarea {
                        border: 2px solid rgba(var(--primary-color));
                        padding-left: 15px;
                    }

                    .image-placeholder {
                        border: 2px solid rgba(var(--primary-color));
                        padding-left: 15px;
                    }
                }

                img {
                    cursor: pointer;
                    width: 24px;
                    position: absolute;
                    top: 28px;
                    right: 16px;
                }

                button {
                    position: absolute;
                    right: 13px;
                    top: 25px;
                    width: 30px;
                    height: 30px;
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

            .label {
                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
            }

            .checkbox-data {
                display: flex;
                margin-bottom: 10px;

                .checkbox {
                    position: relative;
                    cursor: pointer;
                    width: 28px;
                    height: 28px;
                    margin-left: -4px;
                    margin-right: 4px;

                    svg {
                        width: 100%;
                        height: 100%;
                        display: block;
                        color: rgba(var(--secondary-color), var(--opacity-point-six));

                        &.check-active {
                            display: none;
                            color: rgba(var(--primary-color));
                        }
                    }

                    input {
                        display: none;
                    }

                    &.checked {
                        svg {
                            display: none;

                            &.check-active {
                                display: block;
                            }
                        }
                    }
                }

                .label-more {
                    color: rgba(var(--secondary-color), var(--opacity-point-six));
                    line-height: 30px;
                    font-size: 12px;

                    a {
                        color: rgba(var(--primary-color));
                        text-decoration: unset;
                    }
                }
            }

            .parent-pages {
                display: flex;
                align-items: center;
                z-index: 3;
            }

            .languages {
                display: flex;
                align-items: center;
                z-index: 2;
            }

            .translations {
                .language {
                    display: flex;
                    align-items: center;

                    img {
                        cursor: pointer;
                        height: 40px;
                        margin-right: 10px;
                        border-radius: 6px;
                        padding: 8px;
                        border: 1px solid rgba(var(--secondary-color), var(--opacity-point-six));
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

    button {
        border-radius: 4px;
        cursor: pointer;
        line-height: 23px;
        outline: 0;
        padding: 8px;
        transition: all 0.2s ease-in-out;
        text-transform: uppercase;
        font-weight: 600;
        font-size: 16px;

        &.primary {
            background: rgba(var(--primary-button-background-color));
            border: 1px solid rgba(var(--primary-button-background-color));
            color: rgba(var(--primary-button-color));
            margin-right: 10px;

            &:hover {
                opacity: var(--opacity-point-eight-seven);
            }
        }
    }

    .mb-1 {
        margin-bottom: 1rem;
    }
}
</style>
