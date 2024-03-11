<!-- =========================================================================================
  File Name: BlockText.vue
  Description: Block Text
========================================================================================== -->
<template>
    <div class="block-data" v-if="blockLoaded">
        <div class="row">
            <div class="full">
                <div :class="['input-wrapper', local_data.title ? 'has-content' : '', titleFocus]">
                    <div class="label">{{ trans.title }}</div>
                    <div class="label-floating">{{ trans.title }}</div>
                    <input v-model="local_data.title" type="text" @focus="titleFocus" @blur="titleBlur"/>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
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

            trans: {
                title: 'Title'
            }
        }
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
        }
    },
    mounted() {
        if (!this.block.data || this.block.data.length === 0) {
            this.local_data = {
                title: null,
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
}
</style>
