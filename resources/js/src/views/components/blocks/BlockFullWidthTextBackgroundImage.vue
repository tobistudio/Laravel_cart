\<!-- =========================================================================================
  File Name: BlockPageHeader.vue
  Description: Block Page Header
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
            <div class="half">
                <div :class="['input-wrapper', local_data.button_link ? 'has-content' : '', buttonLinkClassFocus]">
                    <div class="label">{{ trans.button_link }}</div>
                    <div class="label-floating">{{ trans.button_link }}</div>
                    <input v-model="local_data.button_link" type="text" @focus="buttonLinkFocus" @blur="buttonLinkBlur"/>
                </div>
            </div>
            <div class="half">
                <div :class="['input-wrapper', local_data.button_text ? 'has-content' : '', buttonTextClassFocus]">
                    <div class="label">{{ trans.button_text }}</div>
                    <div class="label-floating">{{ trans.button_text }}</div>
                    <input v-model="local_data.button_text" type="text" @focus="buttonTextFocus" @blur="buttonTextBlur"/>
                </div>
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
    </div>
</template>
<script>
import Editor from '../../components/Editor.vue';

export default {
    props: {
        block: {
            type: Object,
            required: true,
        },
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
            buttonLinkClassFocus: false,
            buttonTextClassFocus: false,

            trans: {
                title: 'Title',
                description: 'Description',
                button_link: 'Button link',
                button_text: 'Button text',
                background_image: 'Background image',
                background_image_description: 'Minimum image width 1920px',
            }
        }
    },
    components: {
        Editor
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
        buttonLinkFocus() {
            this.buttonLinkClassFocus = 'focus';
        },
        buttonLinkBlur() {
            this.buttonLinkClassFocus = false;
        },
        buttonTextFocus() {
            this.buttonTextClassFocus = 'focus';
        },
        buttonTextBlur() {
            this.buttonTextClassFocus = false;
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
    },
    mounted() {
        if (!this.block.data || this.block.data.length === 0) {
            this.local_data = {
                title: '',
                description: '',
                button_link: '',
                button_text: '',
                background_image: null,
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
                height: 25px;
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
}
</style>
