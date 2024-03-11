\<!-- =========================================================================================
  File Name: BlockHeroSearch.vue
  Description: Block Hero Search
========================================================================================== -->
<template>
    <div class="block-data" v-if="blockLoaded">
        <div class="row">
            <div class="full">
                <div :class="['input-wrapper', local_data.title ? 'has-content' : '', titleClassFocus]">
                    <div class="label">{{ trans.title }}</div>
                    <div class="label-floating">{{ trans.title }}</div>
                    <input v-model="local_data.title" type="text" @focus="titleFocus" @blur="titleBlur"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="full">
                <Editor v-model="local_data.description" :title="trans.description" />
            </div>
        </div>
        <div class="row">
            <div class="full">
                <div :class="['input-wrapper', 'image', background_image_validation ? 'error' : '', backgroundImageClassFocus]">
                    <input @change="backgroundImageUpload" type="file" accept="image/*" class="image" id="backgroundImage" ref="backgroundImage">
                    <div class="image-placeholder">
                        <div class="label">{{ trans.background_image }}</div>
                        <div class="label-more">{{ trans.background_image_description }}</div>
                        <div class="image" @click="triggerBackgroundImageUpload">
                            <div class="placeholder" v-if="!local_data.background_image"></div>
                            <img :src="local_data.background_image" :alt="trans.background_image" v-if="local_data.background_image">
                        </div>
                    </div>
                    <span class="error" v-if="background_image_validation">{{ background_image_validation }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="full">
                <div class="checkbox-data" @click="toggleShowVehicleBrands">
                    <div :class="['checkbox', local_data.show_vehicle_brands ? 'checked' : '']">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                        <input type="checkbox" v-model="local_data.show_vehicle_brands">
                    </div>
                    <div class="label">{{ trans.show_vehicle_brands }}</div>
                </div>
            </div>
        </div>
        <div class="row" v-if="local_data.show_vehicle_brands">
            <div class="full">
                <div :class="['input-wrapper', local_data.vehicle_brands_title ? 'has-content' : '', vehicleBrandsTitleClassFocus]">
                    <div class="label">{{ trans.vehicle_brands_title }}</div>
                    <div class="label-floating">{{ trans.vehicle_brands_title }}</div>
                    <input v-model="local_data.vehicle_brands_title" type="text" @focus="vehicleBrandsTitleFocus" @blur="vehicleBrandsTitleBlur"/>
                </div>
            </div>
        </div>
        <div class="row" v-if="local_data.show_vehicle_brands">
            <div class="full">
                <WDMultiSelect field="selectedVehicleBrands" label="name" :title="trans.vehicle_brands" :options="vehicleBrands" :selectedOptions="local_data.vehicle_brands" @selectedMultiOptionsUpdated="selectedMultiOptionsUpdated"></WDMultiSelect>
            </div>
        </div>
    </div>
</template>
<script>
import Editor from '../../components/Editor.vue';
import WDMultiSelect from '../../components/WD-multi-select.vue'

export default {
    props: {
        block: {
            type: Object,
            required: true,
        },
        vehicleBrands: {
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

            titleClassFocus: false,
            backgroundImageClassFocus: false,
            background_image_validation: null,
            vehicleBrandsTitleClassFocus: false,

            trans: {
                title: 'Title',
                description: 'Description',
                background_image: 'Background image',
                background_image_description: 'Minimum image width 1920px',
                show_vehicle_brands: 'Show vehicle brands',
                vehicle_brands_title: 'Vehicle Brands title',
                vehicle_brands: 'Vehicle Brands',
            }
        }
    },
    components: {
        Editor,
        WDMultiSelect
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
        titleFocus() {
            this.titleClassFocus = 'focus';
        },
        titleBlur() {
            this.titleClassFocus = false;
        },
        descriptionFocus() {
            this.descriptionClassFocus = 'focus';
        },
        descriptionBlur() {
            this.descriptionClassFocus = false;
        },
        vehicleBrandsTitleFocus() {
            this.vehicleBrandsTitleClassFocus = 'focus';
        },
        vehicleBrandsTitleBlur() {
            this.vehicleBrandsTitleClassFocus = false;
        },
        triggerBackgroundImageUpload() {
            document.getElementById('backgroundImage').click();
        },
        backgroundImageUpload(event) {
            let reader = new FileReader()
            reader.readAsDataURL(event.target.files[0])
            reader.onload = () => {
                this.local_data.background_image = reader.result;
            };
        },
        toggleShowVehicleBrands() {
            this.local_data.show_vehicle_brands = !this.local_data.show_vehicle_brands;
        },
        selectedMultiOptionsUpdated(options) {
            this.local_data.vehicle_brands = options;
        }
    },
    mounted() {
        if (!this.block.data || this.block.data.length === 0) {
            this.local_data = {
                title: '',
                text: '',
                background_image: null,
                show_vehicle_brands: false,
                vehicle_brands_title: '',
                vehicle_brands: []

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
    margin-bottom: 10px;

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
            height: 50px;
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

    .checkbox-data {
        display: flex;
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

        .label {
            color: rgba(var(--secondary-color), var(--opacity-point-six));
            line-height: 30px;

            a {
                color: rgba(var(--primary-color));
                text-decoration: unset;
            }
        }
    }
}
</style>
