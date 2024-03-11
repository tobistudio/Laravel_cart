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
                <Editor v-model="local_data.description" :title="trans.description"/>
            </div>
        </div>
        <div class="row">
            <div class="full">
                <div :class="['input-wrapper', 'file', file_validation ? 'error' : '']">
                    <input @change="fileUpload" type="file" accept=".docx, .pdf" class="file" id="file" ref="file">
                    <div class="file-placeholder">
                        <div class="label">{{ trans.file }}</div>
                        <div class="label-more">{{ trans.file_description }}</div>
                        <div class="file" @click="triggerFileUpload">
                            <div class="placeholder" v-if="!local_data.file.file"></div>
                            <div :class="['file-name', local_data.file.extension]" v-if="local_data.file.file">
                                <a :href="local_data.file.file">{{ local_data.file.name }}</a>
                            </div>
                        </div>
                    </div>
                    <span class="error" v-if="file_validation">{{ file_validation }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="full">
                <div class="checkbox-data" @click="toggleMarginTop">
                    <div :class="['checkbox', local_data.margin_top ? 'checked' : '']">
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
                        <input type="checkbox" v-model="local_data.margin_top">
                    </div>
                    <div class="label-more">{{ local_data.margin_top ? trans.margin_top : trans.margin_bottom }}</div>
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
            file_validation: null,

            trans: {
                title: 'Title',
                description: 'Description',
                file: 'File',
                file_description: 'File must be of docx or pdf format',
                margin_top: 'Margin top',
                margin_bottom: 'Margin bottom',
                show_breadcrumbs: 'Show breadcrumbs',
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
        triggerFileUpload() {
            document.getElementById('file').click();
        },
        fileUpload(event) {
            let reader = new FileReader()
            reader.readAsDataURL(event.target.files[0])
            reader.onload = () => {
                this.local_data.file.file = reader.result;
                this.local_data.file.name = event.target.files[0].name;
                this.local_data.file.extension = this.local_data.file.name.split('.').pop();
            };
        },
        toggleMarginTop() {
            this.local_data.margin_top = !this.local_data.margin_top;
        }
    },
    mounted() {
        if (!this.block.data || this.block.data.length === 0) {
            this.local_data = {
                title: '',
                description: '',
                file: {
                    name: '',
                    file: null,
                },
                margin_top: false,
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
            height: 25px;
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

        &.file {
            input {
                display: none;
            }
        }

        .file-placeholder {
            flex: 1;
            transition: .15s opacity cubic-bezier(.4, 0, .2, 1);
            min-width: 0;
            display: flex;
            flex-wrap: wrap;
            letter-spacing: .009375em;
            padding: 16px;
            width: 100% !important;
            min-height: 100px;
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

            .file {
                width: 100%;
                padding-top: 8px;

                .placeholder {
                    width: 100%;
                    height: 32px;
                    background: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                }

                .file-name {
                    display: flex;
                    line-height: 32px;

                    &.docx {
                        &::before {
                            content: '';
                            width: 24px;
                            height: 32px;
                            background: transparent url("../../../../../front/images/doc-icon.svg");
                            margin-right: 10px;
                        }
                    }

                    &.pdf {
                        &::before {
                            content: '';
                            width: 32px;
                            height: 32px;
                            background: transparent url("../../../../../front/images/pdf-icon.svg");
                            margin-right: 10px;
                        }
                    }
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
