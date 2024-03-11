\<!-- =========================================================================================
  File Name: BlockTwoBanner.vue
  Description: Block Two Banner
========================================================================================== -->
<template>
    <div class="block-data" v-if="blockLoaded">
        <div class="row">
            <div class="half">
                <div :class="['input-wrapper', 'image', image_validation ? 'error' : '']">
                    <input @change="imageUpload" type="file" accept="image/*" class="image" id="image" ref="image">
                    <div class="image-placeholder">
                        <div class="label">{{ trans.image }}</div>

                        <div class="label-more">{{ trans.image_description }}</div>
                        <div class="image" @click="triggerImageUpload">
                            <div class="placeholder" v-if="!local_data.image"></div>
                            <img :src="local_data.image" :alt="trans.image" v-if="local_data.image">
                        </div>
                    </div>
                    <span class="error" v-if="image_validation">{{ image_validation }}</span>
                </div>
                <div class="row">
                    <div class="full">
                        <div class="checkbox-data" @click="toggleImageRight">
                            <div :class="['checkbox', local_data.image_right ? 'checked' : '']">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                <input type="checkbox" v-model="local_data.image_right">
                            </div>
                            <div class="label">{{ trans.image_right }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="half">
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
                        <Editor v-model="local_data.description" :title="trans.description"/>
                    </div>
                </div>
                <div class="row">
                    <div class="full">
                        <div class="items-title">{{ trans.text_item }}</div>

                        <div class="row">
                            <div class="full">
                                <div class="checkbox-data" @click="toggleVerticalTextItems">
                                    <div :class="['checkbox', local_data.vertical_text_items ? 'checked' : '']">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                        <input type="checkbox" v-model="local_data.vertical_text_items">
                                    </div>
                                    <div class="label">{{ trans.vertical_text_items }}</div>
                                </div>
                            </div>
                        </div>

                        <draggable
                            v-model="local_data.text_items"
                            ghost-class="ghost"
                            item-key="id">
                            <template #item="{element}">
                                <div :class="['card', 'with-header', element.active ? 'open' : '']">
                                    <div class="header">
                                        <div class="title">{{ element.name ? element.name : trans.new_text_item }}</div>
                                        <div class="controls">
                                            <div class="button" @click="closeItem(element)" v-if="element.active">
                                                <i class='bx bx-chevron-up'></i>
                                            </div>
                                            <div class="button" @click="openItem(element)" v-if="!element.active">
                                                <i class='bx bx-chevron-down'></i>
                                            </div>
                                            <div class="button"
                                                 @click="openDeleteConfirmPopup('removeIconTextBlockItem', 'icon-text-block-item', this.block.id, element.title ? element.title : trans.new_item, element.id)">
                                                <i class='bx bx-x'></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content" v-if="element.active">
                                        <div class="row">
                                            <div class="half">
                                                <div class="row">
                                                    <div class="full">
                                                        <div :class="['input-wrapper', element.name ? 'has-content' : '', titleClassFocus]">
                                                            <div class="label">{{ trans.text_item_name }}</div>
                                                            <div class="label-floating">{{ trans.text_item_name }}</div>
                                                            <input v-model="element.name" type="text" @focus="titleFocus" @blur="titleBlur"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="half">
                                                <div class="row">
                                                    <div class="full">
                                                        <div :class="['input-wrapper', element.value ? 'has-content' : '', titleClassFocus]">
                                                            <div class="label">{{ trans.text_item_value }}</div>
                                                            <div class="label-floating">{{ trans.text_item_value }}</div>
                                                            <input v-model="element.value" type="text" @focus="titleFocus" @blur="titleBlur"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </draggable>
                        <button class="primary mb-1" @click="addTextItem">{{ trans.add_text_item }}</button>

                        <div class="row">
                            <div class="full">
                                <div class="checkbox-data" @click="toggleMarginBottom">
                                    <div :class="['checkbox', local_data.margin_bottom ? 'checked' : '']">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                        <input type="checkbox" v-model="local_data.margin_bottom">
                                    </div>
                                    <div class="label">{{ trans.margin_bottom }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import draggable from 'vuedraggable'
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

            imageTitleClassFocus: false,
            image_validation: null,
            titleClassFocus: false,

            trans: {
                image: 'Image',
                image_description: 'Minimum image width 600px',
                image_right: 'Image right',
                title: 'Title',
                description: 'Description',
                text_item: 'Text items',
                vertical_text_items: 'Vertical Text items',
                text_item_name: 'Name',
                text_item_value: 'Value',
                new_text_item: 'New Text item',
                add_text_item: 'Add Text item',
                margin_bottom: 'Margin bottom'
            }
        }
    },
    components: {
        draggable,
        Editor,
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
        triggerImageUpload() {
            document.getElementById('image').click();
        },
        imageUpload(event) {
            let reader = new FileReader()
            reader.readAsDataURL(event.target.files[0])
            reader.onload = () => {
                this.local_data.image = reader.result;
            };
        },
        toggleImageRight() {
            this.local_data.image_right = !this.local_data.image_right;
        },
        toggleMarginBottom() {
            this.local_data.margin_bottom = !this.local_data.margin_bottom;
        },
        titleFocus() {
            this.titleClassFocus = 'focus';
        },
        titleBlur() {
            this.titleClassFocus = false;
        },
        toggleVerticalTextItems() {
            this.local_data.vertical_text_items = !this.local_data.vertical_text_items;
        },
        addTextItem() {
            this.local_data.text_items.push({
                id: new Date().getUTCMilliseconds(),
                name: '',
                value: '',
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
    },
    mounted() {
        if (!this.block.data || this.block.data.length === 0) {
            this.local_data = {
                image: null,
                image_right: null,
                title: '',
                description: '',
                text_items: [],
                vertical_text_items: false,
                margin_bottom: false,
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

            &.image {
                > input {
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

                > .label {
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

                > .label-more {
                    width: 100%;
                    height: 25px;
                }

                > .image {
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
            margin-bottom: 10px;

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

    .items-title {
        font-weight: 700;
        color: rgba(var(--title-color));
        padding-bottom: 5px;
        border-bottom: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
        margin-bottom: 10px;
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

    .mb-1 {
        margin-bottom: 1rem;
    }
}
</style>
