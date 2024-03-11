<!-- =========================================================================================
  File Name: BlockIconText.vue
  Description: Block Icon Text
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
                            <div class="button" @click="openDeleteConfirmPopup('removeTableBlockItem', 'table-block-item', block.id, element.title ? element.title : trans.new_item, element.id)">
                                <i class='bx bx-x'></i>
                            </div>
                        </div>
                    </div>
                    <div class="content" v-if="element.active">
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
                                <div class="checkbox-data" @click="toggleHideTitle(element)">
                                    <div :class="['checkbox', element.hide_title ? 'checked' : '']">
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
                                        <input type="checkbox" v-model="element.hide_title">
                                    </div>
                                    <div class="label-more">{{ element.hide_title ? trans.hide_title_active : trans.hide_title_not_active }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="full">
                                <div class="checkbox-data" @click="toggleWarning(element)">
                                    <div :class="['checkbox', element.warning ? 'checked' : '']">
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
                                        <input type="checkbox" v-model="element.warning">
                                    </div>
                                    <div class="label-more">{{ element.warning ? trans.warning_active : trans.warning_not_active }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="full">
                                <Editor v-model="element.description" :title="trans.description" />
                            </div>
                        </div>
                        <BlockTextItemBlocks :block="block" :item="element" @openDeleteConfirmPopup="openDeleteConfirmPopup" :removeLanguagePageBlockOrItem="removeLanguagePageBlockOrItem"></BlockTextItemBlocks>

                        <div class="row">
                            <div class="full">
                                <button class="primary mb-1" @click="addItemBlock(element.id)">{{ trans.add_item_block }}</button>
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
import Editor from '../../components/Editor.vue';
import BlockTextItemBlocks from './BlockTextItemBlocks.vue';

export default {
    props: {
        block: {
            type: Object,
            required: true,
        },
        removeLanguagePageBlockOrItem: {
            type: Object,
        }
    },
    data() {
        return {
            blockLoaded: false,
            block_id: null,
            block_tmp_id: null,
            local_data: null,

            titleClassFocus: false,

            trans: {
                title: 'Title',
                description: 'Description',
                add_item: 'Add Item',
                new_item: 'New Item',
                add_item_block: 'Add Block',
                hide_title_active: 'Hide Title',
                hide_title_not_active: 'Show Title',
                warning_active: 'Warning Block',
                warning_not_active: 'Image block',
                new_item_block: 'New Block',
            }
        }
    },
    components: {
        draggable,
        Editor,
        BlockTextItemBlocks,
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
                title: '',
                hide_title: false,
                warning: false,
                description: '',
                blocks: [],
            })
        },
        openItem(item) {
            item.active = true;
        },
        toggleWarning(item_block) {
            item_block.warning = !item_block.warning;
        },
        addItemBlock(item_id) {
            let findItemIndex = this.local_data.items.findIndex(item => item.id === item_id);

            if(findItemIndex >= 0){
                this.local_data.items[findItemIndex].blocks.push({
                    id: new Date().getUTCMilliseconds(),
                    title: '',
                    icon_image: '',
                    description: '',
                })
            }
        },
        openItemBlock(item_block) {
            item_block.active = true;
        },
        closeItemBlock(item_block) {
            item_block.active = false;
        },
        closeItem(item) {
            item.active = false;
        },
        openDeleteConfirmPopup(action, type, id, name, item_id, item_block_id, item_block_item_id) {
            this.$emit('openDeleteConfirmPopup', action, type, id, name, item_id, item_block_id, item_block_item_id);
        },
        titleFocus() {
            this.titleClassFocus = 'focus';
        },
        titleBlur() {
            this.titleClassFocus = false;
        },
        toggleHideTitle(item) {
            item.hide_title = !item.hide_title;
        }
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
        }

        .one-three {
            width: 35%;
        }

        .ml-20 {
            margin-left: 20px;
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
