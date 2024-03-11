<!-- =========================================================================================
  File Name: Page.vue
  Description: Page
========================================================================================== -->
<template>
    <div class="card">
        <div class="row">
            <div :class="['input-wrapper', 'input', pageSeo.title ? 'has-content' : '', seoTitleClassFocus]">
                <div class="label">{{ trans.seo.title }}</div>
                <div class="label-floating">{{ trans.seo.title }}</div>
                <input v-model="pageSeo.title" type="text" @focus="seoTitleFocus" @blur="seoTitleBlur"/>
            </div>
        </div>
        <div class="row">
            <div class="half">
                <div :class="['input-wrapper', 'input', pageSeo.description ? 'has-content' : '', seoDescriptionClassFocus]">
                    <div class="label">{{ trans.seo.description }}</div>
                    <div class="label-floating">{{ trans.seo.description }}</div>
                    <textarea v-model="pageSeo.description" type="text" @focus="seoDescriptionFocus" @blur="seoDescriptionBlur"/>
                </div>

                <div class="label">{{ trans.seo.index }}</div>
                <div class="checkbox-data">
                    <div :class="['checkbox', pageSeo.index ? 'checked' : '']" @click="toggleIndex">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                        <input type="checkbox" v-model="pageSeo.index">
                    </div>
                    <div class="label-more">{{ pageSeo.index ? trans.seo.index_active : trans.seo.index_not_active }}</div>
                </div>

                <div class="label">{{ trans.seo.fallow }}</div>
                <div class="checkbox-data">
                    <div :class="['checkbox', pageSeo.fallow ? 'checked' : '']" @click="toggleFallow">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                        <input type="checkbox" v-model="pageSeo.fallow">
                    </div>
                    <div class="label-more">{{ pageSeo.fallow ? trans.seo.fallow_active : trans.seo.fallow_not_active }}</div>
                </div>
            </div>
            <div class="half">
                <div :class="['input-wrapper', 'input', 'image', metaImageValidation ? 'error' : '', seoImageClassFocus]">
                    <input @change="seoImageUpload" type="file" accept="image/*" class="image" id="seoImage" ref="seoImage">
                    <div class="image-placeholder">
                        <div class="label">{{ trans.seo.image }}</div>
                        <div class="label-more">{{ trans.seo.image_description }}</div>
                        <div class="image" @click="triggerSeoImageUpload">
                            <div class="placeholder" v-if="!pageSeo.image"></div>
                            <img :src="pageSeo.image" :alt="pageSeo.title" v-if="pageSeo.image">
                        </div>
                    </div>
                    <span class="error" v-if="metaImageValidation">{{ metaImageValidation }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Editor from '../../../components/Editor.vue';

export default {
    props: [
        'pageSeo',
        'metaImageValidation',
    ],
    data() {
        return {
            seoTitleClassFocus: false,
            seoDescriptionClassFocus: false,

            seoImageClassFocus: false,

            trans: {
                seo: {
                    title: 'Title',
                    description: 'Description',
                    image: 'Image',
                    image_description: 'Minimum image size 1200x630px, please use 1.91:1 aspect ratio otherwise image will be cropped',
                    index: 'Robots index',
                    index_active: 'Allow search engines robots to index the page.',
                    index_not_active: 'Disallow search engines from showing this page in their results.',
                    fallow: 'Robots fallow',
                    fallow_active: 'Tells the search engines robots to follow the links on the page, whether it can index it or not.',
                    fallow_not_active: 'Tells the search engines robots to not follow any links on the page at all.',
                }
            }
        }
    },
    components: {
        Editor,
    },
    methods: {
        seoTitleFocus() {
            this.seoTitleClassFocus = 'focus';
        },
        seoTitleBlur() {
            this.seoTitleClassFocus = false;
        },
        seoDescriptionFocus() {
            this.seoDescriptionClassFocus = 'focus';
        },
        seoDescriptionBlur() {
            this.seoDescriptionClassFocus = false;
        },
        triggerSeoImageUpload() {
            document.getElementById('seoImage').click();
        },
        seoImageUpload(event) {
            let reader = new FileReader()
            reader.readAsDataURL(event.target.files[0])
            reader.onload = () => {
                this.pageSeo.image = reader.result;
            };
        },
        toggleIndex() {
            this.pageSeo.index = !this.pageSeo.index;
        },
        toggleFallow() {
            this.pageSeo.fallow = !this.pageSeo.fallow;
        },
    },
    mounted() {
    },
}
</script>
<style lang="scss" scoped>
    .row {
        display: flex;

        .half {
            width: 50%;

            &:first-of-type {
                padding-right: 10px;
            }

            &:nth-of-type(2) {
                padding-left: 10px;
            }
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
    }
</style>
