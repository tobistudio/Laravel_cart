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
                        <div class="card">
                            <div class="row">
                                <div class="one-three mr-20" v-if="$route.params.type === 'blog_post' || $route.params.type === 'product_category' || $route.params.type === 'vehicle' || $route.params.type === 'manufacturer' || $route.params.type === 'product'">
                                    <div :class="['input-wrapper', 'input', 'image', featured_image_validation ? 'error' : '']">
                                        <input @change="featuredImageUpload" type="file" accept="image/*" class="image" id="featuredImage" ref="featuredImage">
                                        <div class="image-placeholder">
                                            <div class="label">{{ trans.featured_image }}</div>
                                            <div class="label-more" v-if="$route.params.type === 'blog_post'">{{ trans.featured_image_blog_post_description }}</div>
                                            <div class="label-more" v-if="$route.params.type === 'product_category'">{{ trans.featured_image_description }}</div>
                                            <div class="label-more" v-if="$route.params.type === 'vehicle'">{{ trans.featured_image_description }}</div>
                                            <div class="label-more" v-if="$route.params.type === 'product'">{{ trans.featured_image_product_description }}</div>
                                            <div class="image" @click="triggerFeaturedImageUpload">
                                                <div class="placeholder" v-if="!page.general.featured_image"></div>
                                                <img :src="page.general.featured_image" :alt="trans.background_image" v-if="page.general.featured_image">
                                            </div>
                                        </div>
                                        <span class="error" v-if="featured_image_validation">{{ featured_image_validation }}</span>
                                    </div>
                                </div>
                                <div :class="$route.params.type === 'blog_post' || $route.params.type === 'product_category' || $route.params.type === 'vehicle' || $route.params.type === 'manufacturer' || $route.params.type === 'product' ? 'three-one' : 'full'">
                                    <div :class="['input-wrapper', 'input', page.general.name ? 'has-content' : '', name_validation ? 'error' : '', nameClassFocus]">
                                        <div class="label">{{ $route.params.type === 'product' ? trans.product_name : trans.name }}</div>
                                        <div class="label-floating">{{ $route.params.type === 'product' ? trans.product_name : trans.name }}</div>
                                        <input v-model="page.general.name" type="text" @focus="nameFocus" @blur="nameBlur"/>
                                        <span class="error" v-if="name_validation">{{ name_validation }}</span>
                                    </div>

                                    <template v-if="$route.params.type === 'product'">
                                        <div :class="['input-wrapper', 'input', page.product_data.sku ? 'has-content' : '', sku_validation ? 'error' : '', skuClassFocus]">
                                            <div class="label">{{ trans.sku }}</div>
                                            <div class="label-floating">{{ trans.sku }}</div>
                                            <input v-model="page.product_data.sku" type="text" @focus="skuFocus" @blur="skuBlur"/>
                                            <span class="error" v-if="sku_validation">{{ sku_validation }}</span>
                                        </div>

                                        <div class="row">
                                            <div class="half mr-10">
                                                <div :class="['input-wrapper', 'input', page.product_data.price ? 'has-content' : '', price_validation ? 'error' : '', priceClassFocus]">
                                                    <div class="label">{{ trans.price }}</div>
                                                    <div class="label-floating">{{ trans.price }}</div>
                                                    <input v-model="page.product_data.price" type="text" @focus="priceFocus" @blur="priceBlur"/>
                                                    <span class="error" v-if="price_validation">{{ price_validation }}</span>
                                                </div>
                                            </div>

                                            <div class="half">
                                                <div :class="['input-wrapper', 'input', page.product_data.special_price ? 'has-content' : '', special_price_validation ? 'error' : '', specialPriceClassFocus]">
                                                    <div class="label">{{ trans.special_price }}</div>
                                                    <div class="label-floating">{{ trans.special_price }}</div>
                                                    <input v-model="page.product_data.special_price" type="text" @focus="specialPriceFocus" @blur="specialPriceBlur"/>
                                                    <span class="error" v-if="special_price_validation">{{ special_price_validation }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <WDMultiSelect field="selectedProductCategories" label="name" :title="trans.product_categories" :options="page.product_categories" :selectedOptions="selectedProductCategories" @selectedMultiOptionsUpdated="selectedMultiOptionsUpdated"></WDMultiSelect>
                                        <WDSelect field="selectedProductManufacturer" label="name" :title="trans.product_manufacturer" :options="page.product_manufacturers" :selectedOption="selectedProductManufacturer" @selectedOptionUpdated="selectedOptionUpdated"></WDSelect>
                                        <WDMultiSelect field="selectedProductTypes" label="name" :title="trans.product_types" :options="page.product_types" :selectedOptions="selectedProductTypes" @selectedMultiOptionsUpdated="selectedMultiOptionsUpdated"></WDMultiSelect>
                                        <WDMultiSelect field="selectedProductLabels" label="name" :title="trans.product_labels" :options="page.product_labels" :selectedOptions="selectedProductLabels" @selectedMultiOptionsUpdated="selectedMultiOptionsUpdated"></WDMultiSelect>
                                    </template>

                                    <Editor v-model="page.general.description" :title="trans.description" />
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-if="tab.key === 'seo' && tab.active">
                        <div class="card">
                            <div class="row">
                                <div :class="['input-wrapper', 'input', page.seo.title ? 'has-content' : '', seoTitleClassFocus]">
                                    <div class="label">{{ trans.seo.title }}</div>
                                    <div class="label-floating">{{ trans.seo.title }}</div>
                                    <input v-model="page.seo.title" type="text" @focus="seoTitleFocus" @blur="seoTitleBlur"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="half">
                                    <div :class="['input-wrapper', 'input', page.seo.description ? 'has-content' : '', seoDescriptionClassFocus]">
                                        <div class="label">{{ trans.seo.description }}</div>
                                        <div class="label-floating">{{ trans.seo.description }}</div>
                                        <textarea v-model="page.seo.description" type="text" @focus="seoDescriptionFocus" @blur="seoDescriptionBlur"/>
                                    </div>

                                    <div class="label">{{ trans.seo.index }}</div>
                                    <div class="checkbox-data">
                                        <div :class="['checkbox', page.seo.index ? 'checked' : '']" @click="toggleIndex">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                            <input type="checkbox" v-model="page.seo.index">
                                        </div>
                                        <div class="label-more">{{ page.seo.index ? trans.seo.index_active : trans.seo.index_not_active }}</div>
                                    </div>

                                    <div class="label">{{ trans.seo.fallow }}</div>
                                    <div class="checkbox-data">
                                        <div :class="['checkbox', page.seo.fallow ? 'checked' : '']" @click="toggleFallow">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                            <input type="checkbox" v-model="page.seo.fallow">
                                        </div>
                                        <div class="label-more">{{ page.seo.fallow ? trans.seo.fallow_active : trans.seo.fallow_not_active }}</div>
                                    </div>
                                </div>
                                <div class="half">
                                    <div :class="['input-wrapper', 'input', 'image', meta_image_validation ? 'error' : '', seoImageClassFocus]">
                                        <input @change="seoImageUpload" type="file" accept="image/*" class="image" id="seoImage" ref="seoImage">
                                        <div class="image-placeholder">
                                            <div class="label">{{ trans.seo.image }}</div>
                                            <div class="label-more">{{ trans.seo.image_description }}</div>
                                            <div class="image" @click="triggerSeoImageUpload">
                                                <div class="placeholder" v-if="!page.seo.image"></div>
                                                <img :src="page.seo.image" :alt="page.seo.title" v-if="page.seo.image">
                                            </div>
                                        </div>
                                        <span class="error" v-if="meta_image_validation">{{ meta_image_validation }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-if="tab.key === 'blocks' && tab.active">
                        <div class="add-new-block" ref="blocksDropdown">
                            <button class="primary mb-1" @click="toggleBlocksDropdown">{{ trans.blocks.add }}</button>
                            <div class="blocks-dropdown" v-if="blocksDropdown">
                                <div class="block" @click="addBlock(block)" v-for="block in blocks">
                                    <div class="icon">
                                        <i :class="['bx', 'bx-' + block.icon]"></i>
                                    </div>
                                    <div class="text">{{ block.name }}</div>
                                </div>
                            </div>
                        </div>

                        <draggable
                            v-model="page.blocks"
                            ghost-class="ghost"
                            item-key="id">
                            <template #item="{element}">
                                <div :class="['card', 'with-header', element.active ? 'open' : '']">
                                    <div class="header">
                                        <div class="title">{{ element.name }}</div>
                                        <div class="controls">
                                            <div class="button" @click="closeBlock(element)" v-if="element.active">
                                                <i class='bx bx-chevron-up'></i>
                                            </div>
                                            <div class="button" @click="openBlock(element)" v-if="!element.active">
                                                <i class='bx bx-chevron-down'></i>
                                            </div>
                                            <div class="button" @click="openDeleteConfirmPopup('removeLanguagePageBlock', 'block', element.id ? element.id : element.tmp_id, element.name)">
                                                <i class='bx bx-x'></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content" v-if="element.active">
                                        <BlockHeroSearch v-if="element.key === 'block-hero-search'" :block="element" @blockUpdated="blockUpdated" :vehicleBrands="page.vehicle_brands"/>
                                        <BlockIconText v-if="element.key === 'block-icon-text'" :block="element" @blockUpdated="blockUpdated" @openDeleteConfirmPopup="openDeleteConfirmPopup" :removeLanguagePageBlockOrItem="removeLanguagePageBlockOrItem"/>
                                        <BlockPopularCategories v-if="element.key === 'block-popular-categories'" :block="element" @blockUpdated="blockUpdated" :productCategories="page.product_categories"/>
                                        <BlockTwoBanner v-if="element.key === 'block-two-banner'" :block="element" @blockUpdated="blockUpdated"/>
                                        <BlockPopularProducts v-if="element.key === 'block-popular-products'" :block="element" @blockUpdated="blockUpdated"/>
                                        <BlockRecentPosts v-if="element.key === 'block-recent-posts'" :block="element" @blockUpdated="blockUpdated"/>
                                        <BlockNewsletter v-if="element.key === 'block-newsletter'" :block="element" @blockUpdated="blockUpdated"/>
                                    </div>
                                </div>
                            </template>
                        </draggable>
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
                            <WDSelect field="selectedParentPage" label="name" :title="trans.parentPage" :options="parentPages" :selectedOption="selectedParentPage" @selectedOptionUpdated="selectedOptionUpdated"></WDSelect>
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
                            <WDSelect field="selectedLanguage" label="name" :title="trans.language" :options="languages" :selectedOption="selectedLanguage" @selectedOptionUpdated="selectedOptionUpdated"></WDSelect>
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
                                        <input v-model="language_page.page_name " type="text" @focus="languagePageFocus(language_page)" @blur="languagePageBlur(language_page)"/>
                                    </div>
                                </div>
                            </template>
                        </div>
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
                        <WDSelect field="selectedStatus" label="label" :title="trans.status" :options="status_options" :selectedOption="selectedStatus" @selectedOptionUpdated="selectedOptionUpdated"></WDSelect>

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
import WDSelect from '../../components/wd-select.vue'
import WDMultiSelect from '../../components/wd-multi-select.vue'
import Editor from '../../components/Editor.vue';


import draggable from 'vuedraggable'

import BlockHeroSearch from '../../components/blocks/BlockHeroSearch.vue'
import BlockIconText from '../../components/blocks/BlockIconText.vue'
import BlockPopularCategories from '../../components/blocks/BlockPopularCategories.vue'
import BlockTwoBanner from '../../components/blocks/BlockTwoBanner.vue'
import BlockPopularProducts from '../../components/blocks/BlockPopularProducts.vue'
import BlockRecentPosts from '../../components/blocks/BlockRecentPosts.vue'
import BlockNewsletter from '../../components/blocks/BlockNewsletter.vue'

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
            selectedProductCategories: [],
            selectedProductManufacturer: null,
            selectedProductTypes: [],
            selectedProductLabels: [],
            featured_image_validation: null,
            nameClassFocus: false,
            name_validation: null,
            skuClassFocus: false,
            sku_validation: null,
            priceClassFocus: false,
            price_validation: null,
            specialPriceClassFocus: false,
            special_price_validation: null,
            descriptionClassFocus: false,

            seoTitleClassFocus: false,
            seoDescriptionClassFocus: false,

            seoImage: null,
            seoImageClassFocus: false,
            meta_image_validation: null,

            blocksDropdown: false,
            blocks: [
                {
                    name: 'Hero search block',
                    key: 'block-hero-search',
                    icon: 'search',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Icon text block',
                    key: 'block-icon-text',
                    icon: 'diamond',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Popular categories block',
                    key: 'block-popular-categories',
                    icon: 'package',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Two banner block',
                    key: 'block-two-banner',
                    icon: 'images',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Popular products block',
                    key: 'block-popular-products',
                    icon: 'grid',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Recent posts block',
                    key: 'block-recent-posts',
                    icon: 'news',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Newsletter block',
                    key: 'block-newsletter',
                    icon: 'envelope',
                    data: [],
                    collapsible: true
                },
            ],

            parentPages: null,
            selectedParentPage: null,
            parentPagesOpen: true,

            languages: [],
            selectedLanguage: {},
            country_validation: null,
            languageOpen: true,

            language_pages: [],
            translationsOpen: true,

            status_options: [
                {label: 'Draft', id: 0},
                {label: 'Published', id: 1},
            ],
            selectedStatus: {},
            publishOpen: true,

            error_message: null,

            trans: {
                name: 'Page name',
                product_name: 'Product name',
                sku: 'SKU',
                price: 'Price',
                special_price: 'Special price',
                product_categories: 'Categories',
                product_manufacturer: 'Manufacturer',
                product_types: 'Types',
                product_labels: 'Labels',
                description: 'Description',
                featured_image: 'Featured Image',
                featured_image_description: 'Minimum image size 287x175px, please use 41:25 aspect ratio otherwise image will be cropped',
                featured_image_blog_post_description: 'Minimum image size 287x175px, please use 41:25 aspect ratio otherwise image will be cropped',
                featured_image_product_description: 'Minimum image size 253x253px, please use 1:1 aspect ratio otherwise image will be cropped',
                parentPage: 'Parent page',
                language: 'language',
                status: 'Status',
                save: 'Save',
                cancel: 'Cancel',
                seo: {
                  title: 'Title',
                  description: 'Description',
                  image: 'Image',
                  image_description: 'Minimum image size 1200x630px, please use 1.91:1 aspect ratio otherwise image will be cropped',
                  index: 'Robots index',
                  index_active: 'Allow search engines robots to index the page.',
                  index_not_active: 'Disallow search engines from showing this page in their results.',
                  fallow: 'Robots fallow',
                  fallow_active: 'Tells the search engines robots to follow the links on the page, whether it can index it or not.',
                  fallow_not_active: 'Tells the search engines robots to not follow any links on the page at all.',
                },
                blocks: {
                    add: 'Add Block'
                },
                message: {
                    name_required: 'Page name is required',
                    image_must_be_minimum_size: 'Image must be minimum 1200x630 px'
                }
            }
        }
    },
    watch: {
        removeLanguagePageBlockOrItem: {
            handler(data) {
                if(this.page.blocks) {
                    let findBlockIndex = this.page.blocks.findIndex(block => (block.id === data.id || block.tmp_id === data.id));

                    if(data.item_id){
                        console.log(this.page.blocks[findBlockIndex])
                        let findBlockItemIndex = this.page.blocks[findBlockIndex].data.items.findIndex(item => item.id === data.item_id);
                        this.page.blocks[findBlockIndex].data.items.splice(findBlockItemIndex, 1);
                    } else {
                        this.page.blocks.splice(findBlockIndex, 1);
                    }
                }
            },
            deep: true,
            immediate: true,
        },
    },
    components: {
        Editor,
        WDSelect,
        WDMultiSelect,
        draggable,

        BlockHeroSearch,
        BlockIconText,
        BlockPopularCategories,
        BlockTwoBanner,
        BlockPopularProducts,
        BlockRecentPosts,
        BlockNewsletter,
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
                    this.page = data.page;
                    this.languages = data.languages;
                    this.selectedLanguage = data.active_language;
                    this.language_pages = data.language_pages;
                    this.language_pages.map((language_page) => {
                        language_page.focus = false;
                    });

                    this.$store.state.active_record = {
                        id: this.page.general.id ? this.page.general.id : null,
                        name: this.page.general.name ? this.page.general.name : 'Create',
                        deleteAction: !!this.page.general.name
                    };

                    let find_status_index = this.status_options.findIndex(status => status.id === this.page.general.status);
                    this.selectedStatus = this.status_options[find_status_index];

                    if(this.$route.params.type === 'product') {
                        if(this.page.product_data){
                            let find_manufacturer_index = this.page.product_manufacturers.findIndex(pm => pm.value === this.page.product_data.product_manufacturer_id)
                            if(find_manufacturer_index >= 0){
                                this.selectedProductManufacturer = this.page.product_manufacturers[find_manufacturer_index];
                            }

                            this.selectedProductCategories = this.page.product_data.product_categories;
                            this.selectedProductTypes = this.page.product_data.product_types;
                            this.selectedProductLabels = this.page.product_data.product_labels;
                        }
                    }

                    if(this.$route.params.type !== 'blog_post' && this.$route.params.type !== 'vehicle' && this.$route.params.type !== 'manufacturer' && this.$route.params.type !== 'product') {
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
                    }

                    this.pageLoaded = true;
                }).catch(res => {
                this.$router.push(res.redirect).catch(() => {
                });
            });
        },
        openTab(key) {
          this.tabs.map((tab) => {
              tab.active = tab.key === key;
          });
        },
        nameFocus() {
            this.nameClassFocus = 'focus';
        },
        nameBlur() {
            this.nameClassFocus = false;
        },
        skuFocus() {
            this.skuClassFocus = 'focus';
        },
        skuBlur() {
            this.skuClassFocus = false;
        },
        priceFocus() {
            this.priceClassFocus = 'focus';
        },
        priceBlur() {
            this.priceClassFocus = false;
        },
        specialPriceFocus() {
            this.specialPriceClassFocus = 'focus';
        },
        specialPriceBlur() {
            this.specialPriceClassFocus = false;
        },
        triggerFeaturedImageUpload() {
            document.getElementById('featuredImage').click();
        },
        featuredImageUpload(event) {
            let reader = new FileReader()
            reader.readAsDataURL(event.target.files[0])
            reader.onload = () => {
                this.page.general.featured_image = reader.result;
            };
        },
        descriptionFocus() {
            this.descriptionClassFocus = 'focus';
        },
        descriptionBlur() {
            this.descriptionClassFocus = false;
        },
        seoTitleFocus() {
            this.seoTitleClassFocus = 'focus';
        },
        seoTitleBlur() {
            this.seoTitleClassFocus = false;
        },
        seoDescriptionFocus() {
            this.seoDescriptionClassFocus = 'focus';
        },
        seoDescriptionBlur() {
            this.seoDescriptionClassFocus = false;
        },
        triggerSeoImageUpload() {
            document.getElementById('seoImage').click();
        },
        seoImageUpload(event) {
            let reader = new FileReader()
            reader.readAsDataURL(event.target.files[0])
            reader.onload = () => {
                this.page.seo.image = reader.result;
            };
        },
        toggleIndex() {
            this.page.seo.index = !this.page.seo.index;
        },
        toggleFallow() {
            this.page.seo.fallow = !this.page.seo.fallow;
        },
        toggleBlocksDropdown() {
            this.blocksDropdown = !this.blocksDropdown;
        },
        handleBlocksClickOutside(event) {
            if(this.blocksDropdown){
                const targetElement = this.$refs.blocksDropdown;
                if(targetElement){
                    if (!targetElement[0].contains(event.target)) {
                        this.toggleBlocksDropdown();
                    }
                }
            }
        },
        addBlock(block) {
            let local_block = {
                tmp_id: 'tmp-' + new Date().getUTCMilliseconds(),
                name: block.name,
                key: block.key,
                icon: block.icon,
                data: block.data,
                collapsible: block.collapsible,
                active: true,
            }

            this.page.blocks.push(local_block);
            this.toggleBlocksDropdown();
        },
        openBlock(block) {
            block.active = true;
        },
        closeBlock(block) {
            block.active = false;
        },
        openDeleteConfirmPopup(action, type, id, name, item_id = null) {
            let data = {
                action: action,
                type: type,
                name: name,
                id: id,
                item_id: item_id,
            }
            console.log(data);
            this.$emit('openDeleteConfirmPopup', data);
        },
        blockUpdated(id, tmp_id, data) {
            let block_index = null;
            if (id) {
                block_index = this.page.blocks.findIndex(block => block.id === id);
            } else {
                block_index = this.page.blocks.findIndex(block => block.tmp_id === tmp_id);
            }

            this.page.blocks[block_index].data = data;
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
            if(this.$route.params.page_id){
                let redirect_url = '/system/pages/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + language_id
                if(this.$route.params.type === 'blog_category'){
                    redirect_url = '/system/blog/categories/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + language_id
                } else if(this.$route.params.type === 'blog_post') {
                    redirect_url = '/system/blog/posts/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + language_id
                } else if(this.$route.params.type === 'product_category') {
                    redirect_url = '/system/shop/categories/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + language_id
                } else if(this.$route.params.type === 'vehicle') {
                    redirect_url = '/system/shop/vehicles/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + language_id
                }

                this.$router.push(redirect_url).catch(() => {});
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

                if(this.$route.params.page_id){
                    let redirect_url = '/system/pages/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + selected_language_id
                    if(this.$route.params.type === 'blog_category'){
                        redirect_url = '/system/blog/categories/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + selected_language_id
                    } else if(this.$route.params.type === 'blog_post') {
                        redirect_url = '/system/blog/posts/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + selected_language_id
                    } else if(this.$route.params.type === 'product_category') {
                        redirect_url = '/system/shop/categories/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + selected_language_id
                    } else if(this.$route.params.type === 'vehicle') {
                        redirect_url = '/system/shop/vehicles/' + this.$route.params.type + '/' + this.$route.params.page_id + '/' + selected_language_id
                    }

                    this.$router.push(redirect_url).catch(() => {});
                    this.getPage(selected_language_id);
                } else {
                    this.language_pages.map((language) => {
                        language.show = language.language_id !== selected_language_id;
                    });
                }
            }
        },
        selectedMultiOptionsUpdated(options, field) {
            this[field] = options;
            // this.local_data.vehicle_brands = options;
        },
        savePage() {
            let payload = {
                type: this.$route.params.type,
                page_id: this.$route.params.page_id,
                name: this.page.general.name,
                description: this.page.general.description,
                featured_image: this.page.general.featured_image,
                meta_title: this.page.seo ? this.page.seo.title : null,
                meta_description: this.page.seo ? this.page.seo.description : null,
                meta_image: this.page.seo ? this.page.seo.image : null,
                index: this.page.seo ? this.page.seo.index : null,
                fallow: this.page.seo ? this.page.seo.fallow : null,
                blocks: this.page.blocks ? this.page.blocks : [],
                parent_page: this.selectedParentPage,
                language: this.selectedLanguage,
                language_pages: this.language_pages.filter(page => page.show === true),
                status: this.selectedStatus.id
            }

            if(this.$route.params.type === 'product'){
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
                    },
                }

                payload = {
                    ...payload,
                    ...(product_data)
                }
            }

            console.log(payload);

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

            &.ghost {
                background: rgba(var(--primary-color), var(--opacity-point-three));
            }

            :deep(.ql-toolbar) {
                margin-top: 10px;
                border-radius: 6px 6px 0 0;
                border: 1px solid rgba(var(--secondary-color), var(--opacity-point-three));
                border-bottom: unset;
                z-index: 2;

                path {
                    stroke: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                }

                line {
                    stroke: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                }

                rect {
                    stroke: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                }

                polygon {
                    stroke: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                }

                polyline {
                    stroke: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                }

                .ql-picker {
                    color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                }

                button {
                    &:hover {
                        background-color: rgba(var(--icon-hover-background-color));
                    }
                }

                .ql-picker-label {
                    &:hover {
                        background-color: rgba(var(--icon-hover-background-color));
                    }
                }

                .ql-picker-options {
                    background-color: rgba(var(--accent-color));
                    color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                }
            }

            :deep(.ql-container) {
                border-radius: 0 0 6px 6px;
                border: 1px solid rgba(var(--secondary-color), var(--opacity-point-three));
                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                min-height: 200px;

                &.focus {
                    border: 2px solid rgba(var(--primary-color));
                }

                .ql-editor {
                    &:before {
                        color: rgba(var(--secondary-color), var(--opacity-point-three));
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

                .label-more {
                    height: 75px;
                }

                input {
                    flex: 1;
                    transition: .15s opacity cubic-bezier(.4,0,.2,1);
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
                    transition: .15s opacity cubic-bezier(.4,0,.2,1);
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
                    transition: .15s opacity cubic-bezier(.4,0,.2,1);
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

    .add-new-block {
        position: relative;
        height: 58px;
        width: 124px;
        z-index: 4;

        button {
            position: absolute;
        }

        .blocks-dropdown {
            position: absolute;
            width: 260px;
            top: 50px;
            background: rgba(var(--accent-color));
            padding: 0.5rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px -1px rgba(50, 71, 92, 0.0588235294), 0 4px 5px rgba(50, 71, 92, 0.0392156863), 0 1px 10px rgba(50, 71, 92, 0.0392156863);

            .block {
                padding: 0.5rem;
                border: 1px solid rgba(var(--primary-color), var(--opacity-point-six));
                margin-bottom: 0.5rem;
                cursor: pointer;
                font-weight: 500;
                display: flex;

                .icon {
                    height: 22px;
                    margin-right: 10px;

                    i {
                        font-size: 22px;
                        color: rgba(var(--primary-color));
                    }
                }

                .text {
                    line-height: 22px;
                    color: rgba(var(--primary-color));
                }

                &:hover {
                    border: 1px solid rgba(var(--primary-color));
                    background: rgba(var(--primary-color));
                    color: rgba(var(--white-color));

                    .icon {
                        i {
                            color: rgba(var(--white-color));
                        }
                    }

                    .text {
                        color: rgba(var(--white-color));
                    }
                }

                &:last-of-type {
                    margin-bottom: 0;
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
