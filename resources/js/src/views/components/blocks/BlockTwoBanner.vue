\<!-- =========================================================================================
  File Name: BlockTwoBanner.vue
  Description: Block Two Banner
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
            <div class="half">
                <div :class="['input-wrapper', 'image', first_banner_image_validation ? 'error' : '']">
                    <input @change="firstBannerImageUpload" type="file" accept="image/*" class="image" id="firstBannerImage" ref="firstBannerImage">
                    <div class="image-placeholder">
                        <div class="label">{{ trans.banner_image }}</div>

                        <div :class="['input-wrapper', local_data.first_banner_title ? 'has-content' : '', firstBannerTitleClassFocus]">
                            <div class="label">{{ trans.title }}</div>
                            <div class="label-floating">{{ trans.title }}</div>
                            <input v-model="local_data.first_banner_title" type="text" @focus="firstBannerTitleFocus" @blur="firstBannerTitleBlur"/>
                        </div>

                        <div class="label-more">{{ trans.banner_image_description }}</div>
                        <div class="image" @click="triggerFirstBannerImageUpload">
                            <div class="placeholder" v-if="!local_data.first_banner_image"></div>
                            <img :src="local_data.first_banner_image" :alt="trans.banner_image" v-if="local_data.first_banner_image">
                        </div>

                        <div :class="['input-wrapper', local_data.first_banner_link ? 'has-content' : '', firstBannerLinkClassFocus]">
                            <div class="label">{{ trans.banner_link }}</div>
                            <div class="label-floating">{{ trans.banner_link }}</div>
                            <input v-model="local_data.first_banner_link" type="text" @focus="firstBannerLinkFocus" @blur="firstBannerLinkBlur"/>
                        </div>
                    </div>
                    <span class="error" v-if="first_banner_image_validation">{{ first_banner_image_validation }}</span>
                </div>
            </div>
            <div class="half">
                <div :class="['input-wrapper', 'image', second_banner_image_validation ? 'error' : '']">
                    <input @change="secondBannerImageUpload" type="file" accept="image/*" class="image" id="secondBannerImage" ref="secondBannerImage">
                    <div class="image-placeholder">
                        <div class="label">{{ trans.banner_image }}</div>

                        <div :class="['input-wrapper', local_data.second_banner_title ? 'has-content' : '', secondBannerTitleClassFocus]">
                            <div class="label">{{ trans.title }}</div>
                            <div class="label-floating">{{ trans.title }}</div>
                            <input v-model="local_data.second_banner_title" type="text" @focus="secondBannerTitleFocus" @blur="secondBannerTitleBlur"/>
                        </div>

                        <div class="label-more">{{ trans.banner_image_description }}</div>
                        <div class="image" @click="triggerSecondBannerImageUpload">
                            <div class="placeholder" v-if="!local_data.second_banner_image"></div>
                            <img :src="local_data.second_banner_image" :alt="trans.banner_image" v-if="local_data.second_banner_image">
                        </div>

                        <div :class="['input-wrapper', local_data.second_banner_link ? 'has-content' : '', secondBannerLinkClassFocus]">
                            <div class="label">{{ trans.banner_link }}</div>
                            <div class="label-floating">{{ trans.banner_link }}</div>
                            <input v-model="local_data.second_banner_link" type="text" @focus="secondBannerLinkFocus" @blur="secondBannerLinkBlur"/>
                        </div>
                    </div>
                    <span class="error" v-if="second_banner_image_validation">{{ second_banner_image_validation }}</span>
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

            firstBannerTitleClassFocus: false,
            first_banner_image_validation: null,
            firstBannerLinkClassFocus: false,

            secondBannerTitleClassFocus: false,
            second_banner_image_validation: null,
            secondBannerLinkClassFocus: false,

            trans: {
                title: 'Title',
                banner_image: 'Banner',
                banner_image_description: 'Minimum image width 600px',
                banner_link: 'Banner link',
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
        },
        firstBannerTitleFocus() {
            this.firstBannerTitleClassFocus = 'focus';
        },
        firstBannerTitleBlur() {
            this.firstBannerTitleClassFocus = false;
        },
        triggerFirstBannerImageUpload() {
            document.getElementById('firstBannerImage').click();
        },
        firstBannerImageUpload(event) {
            let reader = new FileReader()
            reader.readAsDataURL(event.target.files[0])
            reader.onload = () => {
                this.local_data.first_banner_image = reader.result;
            };
        },
        firstBannerLinkFocus() {
            this.firstBannerLinkClassFocus = 'focus';
        },
        firstBannerLinkBlur() {
            this.firstBannerLinkClassFocus = false;
        },
        secondBannerTitleFocus() {
            this.secondBannerTitleClassFocus = 'focus';
        },
        secondBannerTitleBlur() {
            this.secondBannerTitleClassFocus = false;
        },
        triggerSecondBannerImageUpload() {
            document.getElementById('secondBannerImage').click();
        },
        secondBannerImageUpload(event) {
            let reader = new FileReader()
            reader.readAsDataURL(event.target.files[0])
            reader.onload = () => {
                this.local_data.second_banner_image = reader.result;
            };
        },
        secondBannerLinkFocus() {
            this.secondBannerLinkClassFocus = 'focus';
        },
        secondBannerLinkBlur() {
            this.secondBannerLinkClassFocus = false;
        },
    },
    mounted() {
        if (!this.block.data || this.block.data.length === 0) {
            this.local_data = {
                title: '',
                first_banner_title: '',
                first_banner_image: null,
                first_banner_link: '',
                second_banner_title: '',
                second_banner_image: null,
                second_banner_link: '',
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

        &.image {
            > input {
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
    }
}
</style>
