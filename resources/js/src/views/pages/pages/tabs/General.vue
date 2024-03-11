<!-- =========================================================================================
  File Name: Page.vue
  Description: Page
========================================================================================== -->
<template>
    <div class="card">
        <div class="row">
            <div class="one-three mr-20"
                 v-if="$route.params.type === 'blog_post' || $route.params.type === 'product_category' || $route.params.type === 'vehicle' || $route.params.type === 'manufacturer' || $route.params.type === 'product'">
                <div :class="['input-wrapper', 'input', 'image', featuredImageValidation ? 'error' : '']">
                    <input @change="featuredImageUpload" type="file" accept="image/*" class="image" id="featuredImage" ref="featuredImage">

                    <div class="image-placeholder">
                        <div class="label">{{ trans.featured_image }}</div>
                        <div class="label-more" v-if="$route.params.type === 'blog_post'">{{ trans.featured_image_blog_post_description }}</div>
                        <div class="label-more" v-if="$route.params.type === 'product_category'">{{ trans.featured_image_description }}</div>
                        <div class="label-more" v-if="$route.params.type === 'vehicle'">{{ trans.featured_image_description }}</div>
                        <div class="label-more" v-if="$route.params.type === 'product'">{{ trans.featured_image_product_description }}</div>
                        <div class="image" @click="triggerFeaturedImageUpload">
                            <div class="placeholder" v-if="!pageGeneral.featured_image"></div>
                            <img :src="pageGeneral.featured_image" :alt="trans.background_image" v-if="pageGeneral.featured_image" ref="featured-image">
                        </div>

                        <div v-if="pageGeneral.featured_image" class="delete" @click="deleteFeaturedImage" ref="delete-image">
                            <i class='bx bx-x'></i>
                        </div>
                    </div>

                    <span class="error" v-if="featuredImageValidation">{{ featuredImageValidation }}</span>
                </div>
            </div>
            <div
                :class="$route.params.type === 'blog_post' || $route.params.type === 'product_category' || $route.params.type === 'vehicle' || $route.params.type === 'manufacturer' || $route.params.type === 'product' ? 'three-one' : 'full'">
                <div :class="['input-wrapper', 'input', pageGeneral.name ? 'has-content' : '', nameValidation ? 'error' : '', nameClassFocus]">
                    <div class="label">{{ $route.params.type === 'product' ? trans.product_name : trans.name }}</div>
                    <div class="label-floating">{{ $route.params.type === 'product' ? trans.product_name : trans.name }}</div>
                    <input v-model="pageGeneral.name" type="text" @focus="nameFocus" @blur="nameBlur"/>
                    <span class="error" v-if="nameValidation">{{ nameValidation }}</span>
                </div>

                <template v-if="$route.params.type === 'product'">
                    <div :class="['input-wrapper', 'input', pageProductData.sku ? 'has-content' : '', skuValidation ? 'error' : '', skuClassFocus]">
                        <div class="label">{{ trans.sku }}</div>
                        <div class="label-floating">{{ trans.sku }}</div>
                        <input v-model="pageProductData.sku" type="text" @focus="skuFocus" @blur="skuBlur"/>
                        <span class="error" v-if="skuValidation">{{ skuValidation }}</span>
                    </div>

                    <div class="row">
                        <div class="half mr-10">
                            <div
                                :class="['input-wrapper', 'input', pageProductData.price ? 'has-content' : '', priceValidation ? 'error' : '', priceClassFocus]">
                                <div class="label">{{ trans.price }}</div>
                                <div class="label-floating">{{ trans.price }}</div>
                                <input v-model="pageProductData.price" type="text" @focus="priceFocus" @blur="priceBlur"/>
                                <span class="error" v-if="priceValidation">{{ priceValidation }}</span>
                            </div>
                        </div>

                        <div class="half">
                            <div
                                :class="['input-wrapper', 'input', pageProductData.special_price ? 'has-content' : '', specialPriceValidation ? 'error' : '', specialPriceClassFocus]">
                                <div class="label">{{ trans.special_price }}</div>
                                <div class="label-floating">{{ trans.special_price }}</div>
                                <input v-model="pageProductData.special_price" type="text" @focus="specialPriceFocus" @blur="specialPriceBlur"/>
                                <span class="error" v-if="specialPriceValidation">{{ specialPriceValidation }}</span>
                            </div>
                        </div>
                    </div>

                    <WDMultiSelect field="selectedProductCategories" label="name" :title="trans.product_categories" :options="pageProductCategories"
                                   :selectedOptions="pageProductData.product_categories" @selectedMultiOptionsUpdated="selectedMultiOptionsUpdated"></WDMultiSelect>
                    <WDSelect field="selectedProductManufacturer" label="name" :title="trans.product_manufacturer" :options="pageProductManufacturers"
                              :selectedOption="pageProductData.product_manufacturer" @selectedOptionUpdated="selectedOptionUpdated"></WDSelect>
                    <WDMultiSelect field="selectedProductTypes" label="name" :title="trans.product_types" :options="pageProductTypes"
                                   :selectedOptions="pageProductData.product_types" @selectedMultiOptionsUpdated="selectedMultiOptionsUpdated"></WDMultiSelect>
                    <WDMultiSelect field="selectedProductLabels" label="name" :title="trans.product_labels" :options="pageProductLabels"
                                   :selectedOptions="pageProductData.product_labels" @selectedMultiOptionsUpdated="selectedMultiOptionsUpdated"></WDMultiSelect>
                </template>

                <Editor v-model="pageGeneral.description" :title="trans.description"/>

                <template v-if="$route.params.type === 'product_category'">
                    <WDSelect field="selectedProductCategoryDisplayMode" label="name" :title="trans.product_category_display_mode" :options="productCategoryDisplayModeOptions"
                              :selectedOption="selectedProductCategoryDisplayMode" @selectedOptionUpdated="selectedOptionUpdated"></WDSelect>
                </template>

                <template v-if="$route.params.type === 'page'">
                    <div class="label">{{ trans.page_header }}</div>
                    <div class="checkbox-data" @click="togglePageHeader">
                        <div :class="['checkbox', pageGeneral.page_header ? 'checked' : '']">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24">
                                <g fill="none">
                                    <path fill="currentColor"
                                          d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path>
                                    <path fill="#fff"
                                          d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path>
                                </g>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-width="1.5"
                                      d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path>
                            </svg>
                            <input type="checkbox" v-model="pageGeneral.page_header">
                        </div>
                        <div class="label-more">{{ pageGeneral.page_header ? trans.page_header_active : trans.page_header_not_active }}</div>
                    </div>
                </template>

                <div v-if="$route.params.type === 'page' && pageGeneral.page_header"
                     :class="['input-wrapper', 'input', 'image', featuredImageValidation ? 'error' : '']">
                    <input @change="featuredImageUpload" type="file" accept="image/*" class="image" id="featuredImage" ref="featuredImage">

                    <div class="image-placeholder">
                        <div class="label">{{ trans.featured_image }}</div>
                        <div class="label-more">{{ trans.featured_image_page_description }}</div>
                        <div class="image" @click="triggerFeaturedImageUpload">
                            <div class="placeholder" v-if="!pageGeneral.featured_image"></div>
                            <img :src="pageGeneral.featured_image" :alt="trans.background_image" v-if="pageGeneral.featured_image">
                        </div>
                    </div>

                    <span class="error" v-if="featuredImageValidation">{{ featuredImageValidation }}</span>
                </div>

                <template v-if="$route.params.type === 'page' && pageGeneral.page_header">
                    <div class="label">{{ trans.featured_image_big }}</div>
                    <div class="checkbox-data" @click="toggleFeaturedImageBig">
                        <div :class="['checkbox', pageGeneral.featured_image_big ? 'checked' : '']">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24">
                                <g fill="none">
                                    <path fill="currentColor"
                                          d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path>
                                    <path fill="#fff"
                                          d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path>
                                </g>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-width="1.5"
                                      d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path>
                            </svg>
                            <input type="checkbox" v-model="pageGeneral.featured_image_big">
                        </div>
                        <div class="label-more">{{
                                pageGeneral.featured_image_big ? trans.featured_image_big_active : trans.featured_image_big_not_active
                            }}
                        </div>
                    </div>
                </template>
                <template v-if="$route.params.type === 'page' && pageGeneral.page_header">
                    <div class="label">{{ trans.breadcrumbs }}</div>
                    <div class="checkbox-data" @click="toggleBreadcrumbs">
                        <div :class="['checkbox', pageGeneral.breadcrumbs ? 'checked' : '']">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24">
                                <g fill="none">
                                    <path fill="currentColor"
                                          d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path>
                                    <path fill="#fff"
                                          d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path>
                                </g>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-width="1.5"
                                      d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path>
                            </svg>
                            <input type="checkbox" v-model="pageGeneral.breadcrumbs">
                        </div>
                        <div class="label-more">{{ pageGeneral.breadcrumbs ? trans.breadcrumbs_active : trans.breadcrumbs_not_active }}</div>
                    </div>
                </template>

                <template v-if="$route.params.type === 'page'">
                    <div class="label">{{ trans.newsletter }}</div>
                    <div class="checkbox-data" @click="toggleNewsletter">
                        <div :class="['checkbox', pageGeneral.newsletter ? 'checked' : '']">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24">
                                <g fill="none">
                                    <path fill="currentColor"
                                          d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path>
                                    <path fill="#fff"
                                          d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path>
                                </g>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-width="1.5"
                                      d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path>
                            </svg>
                            <input type="checkbox" v-model="pageGeneral.newsletter">
                        </div>
                        <div class="label-more">{{ pageGeneral.newsletter ? trans.newsletter_active : trans.newsletter_not_active }}</div>
                    </div>
                </template>
            </div>
        </div>

        <template v-if="$route.params.type === 'product'">
            <ProductGallery />

            <ProductAttributes
                :title="trans.product_attributes"
                :pageProductAttributes="pageProductAttributes"
                :selectedLanguage="selectedLanguage"
                @select-attributes="selectAttributes"
            />

            <ProductAttributes
                :title="trans.product_substitutes"
                :pageProductAttributes="pageProductSubstitutes"
                :selectedLanguage="selectedLanguage"
                @select-attributes="selectSubstitutes"
            />

            <ProductParameters
                :pageProductParameters="pageProductParameters"
                @update-parameters="updateParameters"
            />

            <ProductWarehouse
                :productWarehouseCount="productWarehouseCount"
                :productWarehousePacked="productWarehousePacked"
                :selectedLanguage="selectedLanguage"
                @update-warehouse-product-count="updateWarehouseProductCount"
            />

            <ProductDownloads
                :selectedLanguage="selectedLanguage"
            />

            <ProductRelation
                :title="trans.inPackage"
                :selectedLanguage="selectedLanguage"
                type="inPackage"
            />

            <ProductRelation
                :title="trans.crossSell"
                :selectedLanguage="selectedLanguage"
                type="crossSell"
            />
        </template>
    </div>

    <vehicle-models v-if="$route.params.type === 'vehicle'" :vehicleModels="vehicleModels" @vehicleUpdated="vehicleUpdated" @openDeleteConfirmPopup="openDeleteConfirmPopup" :removeLanguagePageBlockOrItem="removeLanguagePageBlockOrItem"></vehicle-models>
</template>

<script>
import WDSelect from '../../../components/WD-select.vue'
import WDMultiSelect from '../../../components/WD-multi-select.vue'
import Editor from '../../../components/Editor.vue';
import VehicleModels from '../../../components/VehicleModels.vue';

import ProductGallery from '@/js/src/views/components/ProductGallery.vue';
import ProductAttributes from '@/js/src/views/components/ProductAttributes.vue';
import ProductParameters from '@/js/src/views/components/ProductParameters.vue';
import ProductWarehouse from '@/js/src/views/components/ProductWarehouse.vue';
import ProductDownloads from '@/js/src/views/components/ProductDownloads.vue';
import ProductRelation from '@/js/src/views/components/ProductRelation.vue';


export default {
    props: [
        'pageGeneral',
        'pageProductCategoryData',
        'pageProductData',
        'productWarehouseCount',
        'productWarehousePacked',
        'pageProductAttributes',
        'pageProductSubstitutes',
        'pageProductParameters',
        'pageProductCategories',
        'pageProductManufacturers',
        'pageProductTypes',
        'pageProductLabels',
        'featuredImageValidation',
        'nameValidation',
        'skuValidation',
        'priceValidation',
        'specialPriceValidation',
        'removeLanguagePageBlockOrItem',
        'selectedLanguage',
    ],
    emits: ['openDeleteConfirmPopup', 'vehicleUpdated'],
    data() {
        return {
            page: {},
            selectedProductCategories: [],
            selectedProductManufacturer: null,
            selectedProductTypes: [],
            selectedProductLabels: [],
            nameClassFocus: false,
            skuClassFocus: false,
            priceClassFocus: false,
            specialPriceClassFocus: false,

            productCategoryDisplayModeOptions: [
                {
                    name: 'Products', id: 'products'
                },
                {
                    name: 'Blocks', id: 'blocks'
                },
                {
                    name: 'Products and blocks', id: 'products_blocks'
                }
            ],
            selectedProductCategoryDisplayMode: null,

            vehicleModels: [],

            trans: {
                name: 'Page name',
                page_header: 'Page header',
                page_header_active: 'Show page header',
                page_header_not_active: 'Do not show page header',
                page_header_image: 'Page header image',
                product_name: 'Product name',
                sku: 'SKU',
                price: 'Price',
                special_price: 'Special price',
                product_categories: 'Categories',
                product_manufacturer: 'Manufacturer',
                product_types: 'Types',
                product_labels: 'Labels',
                product_attributes: 'Attributes',
                product_substitutes: 'Substitutes',
                description: 'Description',
                product_category_display_mode: 'Display mode',
                featured_image: 'Featured Image',
                featured_image_big: 'Featured Image big',
                featured_image_big_active: 'Featured Image big',
                featured_image_big_not_active: 'Featured Image not big',
                breadcrumbs: 'Breadcrumbs',
                breadcrumbs_active: 'Breadcrumbs active',
                breadcrumbs_not_active: 'Breadcrumbs not active',
                featured_image_description: 'Minimum image size 287x175px, please use 41:25 aspect ratio otherwise image will be cropped',
                featured_image_blog_post_description: 'Minimum image size 287x175px, please use 41:25 aspect ratio otherwise image will be cropped',
                featured_image_product_description: 'Minimum image size 253x253px, please use 1:1 aspect ratio otherwise image will be cropped',
                featured_image_page_description: 'Minimum image width 1920px',
                newsletter: 'Newsletter',
                newsletter_active: 'Show newsletter block',
                newsletter_not_active: 'Do not show newsletter block',
                message: {
                    name_required: 'Page name is required',
                    image_must_be_minimum_size: 'Image must be minimum 1200x630 px'
                },
                inPackage: 'Package',
                crossSell: 'Cross sell',
            }
        }
    },
    watch: {
        vehicleModels: {
            handler(oldData, newData) {
                if (newData) {
                    this.$emit('vehicleUpdated', this.vehicleModels);
                }
            },
            deep: true,
            immediate: true,
        },
        'pageGeneral.featured_image': {
            handler(oldData, newData) {
                setTimeout(() => {
                    if (this.$refs['featured-image']) {
                        this.$refs['delete-image'].style.bottom = `${this.$refs['featured-image'].height}px`;
                    }
                }, 100);
            },
        }
    },
    components: {
        ProductDownloads,
        ProductGallery,
        ProductAttributes,
        ProductParameters,
        ProductWarehouse,
        ProductRelation,
        Editor,
        WDSelect,
        WDMultiSelect,
        VehicleModels,
    },
    methods: {
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
        deleteFeaturedImage() {
            this.pageGeneral.featured_image = '';
            document.getElementById('featuredImage').value = '';
        },
        triggerFeaturedImageUpload() {
            document.getElementById('featuredImage').click();
        },
        featuredImageUpload(event) {
            let reader = new FileReader()
            reader.readAsDataURL(event.target.files[0])
            reader.onload = () => {
                this.pageGeneral.featured_image = reader.result;
            };
        },
        selectAttributes(attributes) {
            this.pageGeneral.attributes = attributes;
        },
        selectSubstitutes(attributes) {
            this.pageGeneral.substitutes = attributes;
        },
        updateParameters(parameters) {
            this.pageGeneral.parameters = parameters;
        },
        updateWarehouseProductCount(opts) {
            this.pageGeneral.warehouse_product = opts;
        },
        selectedOptionUpdated(option, field) {
            this[field] = option;

            if(field === 'selectedProductCategoryDisplayMode'){
                this.pageProductCategoryData.display_mode = option.id
            }

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

                    this.$router.push(redirect_url).catch(() => {
                    });
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
        togglePageHeader() {
            this.pageGeneral.page_header = !this.pageGeneral.page_header;
        },
        toggleFeaturedImageBig() {
            this.pageGeneral.featured_image_big = !this.pageGeneral.featured_image_big;
        },
        toggleBreadcrumbs() {
            this.pageGeneral.breadcrumbs = !this.pageGeneral.breadcrumbs;
        },
        toggleNewsletter() {
            this.pageGeneral.newsletter = !this.pageGeneral.newsletter;
        },
        openDeleteConfirmPopup(action, type, id, name, item_id = null, item_block_id = null, item_block_item_id = null) {
            let data = {
                action: action,
                type: type,
                name: name,
                id: id,
                item_id: item_id,
                item_block_id: item_block_id,
                item_block_item_id: item_block_item_id
            }

            this.$emit('openDeleteConfirmPopup', data);
        },
        vehicleUpdated(data) {
            console.log(data);
        },
    },
    mounted() {
        if(this.$route.params.type === 'vehicle') {
            this.vehicleModels = this.pageGeneral.vehicle_models;

            let fuelOptions = [
                {key: 'gasoline', name: 'Gasoline'},
                {key: 'gasoline_electric', name: 'Gasoline/Electric'},
                {key: 'diesel', name: 'Diesel'},
                {key: 'diesel_electric', name: 'Diesel/Electric'}
            ];

            if (this.vehicleModels.length > 0) {
                this.vehicleModels.map(model => {
                    if (model.names.length > 0) {
                        model.names.map(name => {
                            if (name.engines.length > 0) {
                                name.engines.map(engine => {
                                    let findFuelIndex = fuelOptions.findIndex(fo => fo.key === engine.fuel);
                                    if (findFuelIndex >= 0) {
                                        engine.fuel = fuelOptions[findFuelIndex];
                                    }
                                })
                            }
                        })
                    }
                })
            }

            this.$emit('vehicleUpdated', this.vehicleModels);
        }

        if(this.$route.params.type === 'product_category') {
            let findProductCategoryDisplayModeIndex = this.productCategoryDisplayModeOptions.findIndex(pcdmo => pcdmo.id === this.pageProductCategoryData.display_mode);
            if (findProductCategoryDisplayModeIndex >= 0) {
                this.selectedProductCategoryDisplayMode = this.productCategoryDisplayModeOptions[findProductCategoryDisplayModeIndex];
            }
        }
    },
}
</script>
<style lang="scss" scoped>
.row {
    display: flex;

    .full {
        width: 100%;
    }

    .three-one {
        width: 66.67%;
    }

    .one-three {
        width: 33.33%;
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
                    cursor: pointer;

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

                .delete {
                    position: absolute;
                    top: -0.5rem;
                    right: -0.5rem;
                    background: rgba(var(--white-color));
                    border-radius: 1rem;
                    width: 1.5rem;
                    height: 1.5rem;
                    line-height: 1.5rem;
                    text-align: center;
                    color: rgba(var(--red-color));
                    border: 1px solid rgba(var(--secondary-color),var(--opacity-point-three));
                    cursor: pointer;

                    &:hover {
                        border: 1px solid rgba(var(--red-color));
                        color: rgba(var(--white-color));
                        background: rgba(var(--red-color));
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
            cursor: pointer;

            .checkbox {
                position: relative;
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
    }
}
</style>
