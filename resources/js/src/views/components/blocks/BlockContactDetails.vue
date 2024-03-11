<!-- =========================================================================================
  File Name: BlockContactDetails.vue
  Description: Block Contact Details
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
                <div :class="['input-wrapper', local_data.working_hours_title ? 'has-content' : '', workingHoursTitleClassFocus]">
                    <div class="label">{{ trans.working_hours_title }}</div>
                    <div class="label-floating">{{ trans.working_hours_title }}</div>
                    <input v-model="local_data.working_hours_title" type="text" @focus="workingHoursTitleFocus" @blur="workingHoursTitleBlur"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="full">
                <div :class="['input-wrapper', local_data.credentials_title ? 'has-content' : '', credentialsTitleClassFocus]">
                    <div class="label">{{ trans.credentials_title }}</div>
                    <div class="label-floating">{{ trans.credentials_title }}</div>
                    <input v-model="local_data.credentials_title" type="text" @focus="credentialsTitleFocus" @blur="credentialsTitleBlur"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="full">
                <div :class="['input-wrapper', local_data.google_map ? 'has-content' : '', googleMapClassFocus]">
                    <div class="label">{{ trans.google_map }}</div>
                    <div class="label-floating">{{ trans.google_map }}</div>
                    <input v-model="local_data.google_map" type="text" @focus="googleMapFocus" @blur="googleMapBlur"/>
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
        }
    },
    data() {
        return {
            blockLoaded: false,
            block_id: null,
            block_tmp_id: null,
            local_data: null,

            titleClassFocus: false,
            workingHoursTitleClassFocus: false,
            credentialsTitleClassFocus: false,
            googleMapClassFocus: false,

            trans: {
                title: 'Title',
                working_hours_title: 'Title',
                credentials_title: 'Title',
                google_map: 'Google Map',
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
        openItem(block) {
            block.active = true;
        },
        closeItem(block) {
            block.active = false;
        },
        openDeleteConfirmPopup(action, type, id, name, item_id) {
            this.$emit('openDeleteConfirmPopup', action, type, id, name, item_id);
        },
        titleFocus() {
            this.titleClassFocus = 'focus';
        },
        titleBlur() {
            this.titleClassFocus = false;
        },
        workingHoursTitleFocus() {
            this.workingHoursTitleClassFocus = 'focus';
        },
        workingHoursTitleBlur() {
            this.workingHoursTitleClassFocus = false;
        },
        credentialsTitleFocus() {
            this.credentialsTitleClassFocus = 'focus';
        },
        credentialsTitleBlur() {
            this.credentialsTitleClassFocus = false;
        },
        googleMapFocus() {
            this.googleMapClassFocus = 'focus';
        },
        googleMapBlur() {
            this.googleMapClassFocus = false;
        }
    },
    mounted() {
        if (!this.block.data || this.block.data.length === 0) {
            this.local_data = {
                title: null,
                working_hours_title: null,
                credentials_title: null,
                google_map: null
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
    }

    .items-title {
        font-weight: 700;
        color: rgba(var(--title-color));
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
        margin-bottom: 5px;
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
