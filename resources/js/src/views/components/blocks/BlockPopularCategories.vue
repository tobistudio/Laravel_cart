<!-- =========================================================================================
  File Name: BlockPopularCategories.vue
  Description: Block Popular Categories
========================================================================================== -->
<template>
    <div class="block-data" v-if="blockLoaded">

        <draggable
            v-model="local_data.items"
            ghost-class="ghost"
            item-key="id">
            <template #item="{element}">
                <div :class="['card', 'with-header', element.active ? 'open' : '']">
                    <div class="header">
                        <div class="title">{{ element.title ? element.title : trans.new_item }}</div>
                        <div class="controls">
                            <div class="button" @click="closeItem(element)" v-if="element.active">
                                <i class='bx bx-chevron-up'></i>
                            </div>
                            <div class="button" @click="openItem(element)" v-if="!element.active">
                                <i class='bx bx-chevron-down'></i>
                            </div>
                            <div class="button" @click="openDeleteConfirmPopup('removeIconTextBlockItem', 'icon-text-block-item', this.block.id, element.title ? element.title : trans.new_item, element.id)">
                                <i class='bx bx-x'></i>
                            </div>
                        </div>
                    </div>
                    <div class="content" v-if="element.active">
                        <div class="row">
                            <div class="one-three">
                                <div :class="['input-wrapper', 'image', product_category_image_validation ? 'error' : '', productCategoryImageClassFocus]">
                                    <input @change="productCategoryImageUpload($event, element)" type="file" accept="image/*" class="image" :id="['productCategoryImage-' + element.id]" ref="iconImage">
                                    <div class="image-placeholder">
                                        <div class="label">{{ trans.product_category_image }}</div>
                                        <div class="label-more">{{ trans.product_category_image_description }}</div>
                                        <div class="image" @click="triggerProductCategoryImageUpload('productCategoryImage-' + element.id)">
                                            <div class="placeholder" v-if="!element.product_category_image"></div>
                                            <img :src="element.product_category_image" :alt="trans.product_category_image" v-if="element.product_category_image">
                                        </div>
                                    </div>
                                    <span class="error" v-if="product_category_image_validation">{{ product_category_image_validation }}</span>
                                </div>
                            </div>
                            <div class="three-one">
                                <div class="row">
                                    <div class="full">
                                        <div :class="['input-wrapper', element.title ? 'has-content' : '', titleClassFocus]">
                                            <div class="label">{{ trans.title }}</div>
                                            <div class="label-floating">{{ trans.title }}</div>
                                            <input v-model="element.title" type="text" @focus="titleFocus" @blur="titleBlur"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="full">
                                        <WDSelect field="selectedProductCategory" label="name" :item_id="element.id" :title="trans.product_category" :options="productCategories" :selectedOption="element.product_category" @selectedOptionUpdated="selectedOptionUpdated"></WDSelect>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </template>
        </draggable>

        <button class="primary mb-1" @click="addItem">{{ trans.add_item }}</button>
    </div>
</template>
<script>
import draggable from 'vuedraggable'
import WDSelect from '../../components/WD-select.vue'

export default {
    props: {
        block: {
            type: Object,
            required: true,
        },
        removeLanguagePageBlockOrItem: {
            type: Object,
        },
        productCategories: {
            type: Array,
            required: true,
        }
    },
    data() {
        return {
            blockLoaded: false,
            block_id: null,
            block_tmp_id: null,
            local_data: null,

            productCategoryImageClassFocus: false,
            product_category_image_validation: null,
            titleClassFocus: false,

            trans: {
                product_category_image: 'Category image',
                product_category_image_description: 'Minimum image size 185x138px, please use 185x138 aspect ratio otherwise image will be cropped',
                title: 'Title',
                product_category: 'Product category',
                add_item: 'Add Item',
                new_item: 'New Item',
            }
        }
    },
    components: {
        draggable,
        WDSelect,
    },
    watch: {
        local_data: {
            handler(oldData, newData) {
                if (newData) {
                    this.$emit('blockUpdated', this.block.id, this.block.tmp_id, this.local_data, null);
                }
            },
            deep: true,
            immediate: true,
        },
    },
    methods: {
        addItem() {
            this.local_data.items.push({
                id: new Date().getUTCMilliseconds(),
                product_category_image: null,
                title: '',
                product_category: null,
            })
        },
        openItem(block) {
            block.active = true;
        },
        closeItem(block) {
            block.active = false;
        },
        openDeleteConfirmPopup(action, type, id, name, item_id) {
            this.$emit('openDeleteConfirmPopup', action, type, id, name, item_id);
        },
        triggerProductCategoryImageUpload(id) {
            document.getElementById(id).click();
        },
        productCategoryImageUpload(event, element) {
            let reader = new FileReader()
            reader.readAsDataURL(event.target.files[0])
            reader.onload = () => {
                element.product_category_image = reader.result;
            };
        },
        titleFocus() {
            this.titleClassFocus = 'focus';
        },
        titleBlur() {
            this.titleClassFocus = false;
        },
        selectedOptionUpdated(option, field, item_id) {
            let itemIndex = this.local_data.items.findIndex(item => item.id === item_id);
            this.local_data.items[itemIndex].product_category = {id: option.value, name: option.name};
        },
    },
    mounted() {
        if (!this.block.data || this.block.data.length === 0) {
            this.local_data = {
                items: []
            }
        } else {
            this.local_data = this.block.data;
        }

        this.blockLoaded = true;
        this.$emit('blockUpdated', this.block.id, this.block.tmp_id, this.local_data, null);
    }
}
</script>

<style lang="scss" scoped>
.block-data {
    margin-top: 10px;
    margin-bottom: 10px;

    .card {
        background: rgba(var(--accent-color));
        padding: 2rem 1rem;
        border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
        border-radius: 8px;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px -1px #32475c0f, 0 4px 5px #32475c0a, 0 1px 10px #32475c0a;

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
            flex-grow: 1;

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
    }

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
            width: 65%;
            margin-left: 20px;
        }

        .one-three {
            width: 35%;
        }
    }

    button {
        width: 100%;
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
    }
}
</style>
