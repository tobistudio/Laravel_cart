<template>
    <div :class="['download-file-block', data.margin_top ? 'margin-top' : '']">
        <h3>{{ data.title }}</h3>
        <div class="description" v-html="data.description"></div>
        <ul class="files">
            <li>
                <span :class="['name', data.file.extension]">
                    <span class="title">{{ data.file.name }}</span>
                </span>
                <a :href="data.file.file" class="download-btn"><span>{{ trans.download }}</span></a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'Newsletter',
    props: ['data', 'locale'],
    computed: {
        trans() {
            return {
                download: this.translate('download', 'download'),
            }
        }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
    },
    mounted() {
    }
}
</script>

<style lang="scss" scoped>
.download-file-block {
    margin: 0 0 35px 0;

    &.margin-top {
        margin-top: 32px;
        margin-bottom: 0;
    }

    h3 {
        display: block;
        margin: 0 0 12px 0;
        font-size: 20px;
        font-weight: 400;
        line-height: 20px;
        color: #0D2441;

        @media screen {
            @media (max-width: 575px) {
                line-height: normal;
            }
        }
    }

    .description {
        margin: 0 0 12px 0;
    }

    .files {
        li {
            display: flex;
            align-items: center;

            &:not(:last-child) {
                margin: 0 0 20px 0;
            }

            .name {
                display: flex;
                align-items: center;
                margin: 0 16px 0 0;
                color: #0D2441;

                &.docx {
                    span {
                        display: flex;
                        line-height: 32px;

                        @media screen {
                            @media (max-width: 575px) {
                                line-height: normal;
                            }
                        }

                        &:before {
                            content: '';
                            width: 24px;
                            height: 32px;
                            background: url('../../../../front/images/doc-icon.svg');
                            margin-right: 10px;
                        }
                    }
                }

                &.pdf {
                    span {
                        display: flex;
                        line-height: 32px;

                        &:before {
                            content: '';
                            width: 32px;
                            height: 32px;
                            background: url('../../../../front/images/pdf-icon.svg');
                            margin-right: 10px;
                        }
                    }
                }


                img {
                    margin: 0 10px 0 0;
                }
            }

            .download-btn {
                position: relative;
                color: #E72E2C;

                &::before {
                    content: '';
                    position: absolute;
                    top: calc(100% - 2px);
                    left: 0;
                    right: 0;
                    height: 1px;
                    background-color: #e62e2c;
                    transition: all .3s ease-in-out;
                }

                span {
                    display: flex;
                    align-items: center;

                    &::before {
                        content: '';
                        width: 16px;
                        height: 16px;
                        background: url('../../../../front/images/download-icon.svg') left center no-repeat
                    }
                }

                &:hover {
                    &::before {
                        opacity: 0;
                    }
                }
            }
        }
    }
}
</style>
