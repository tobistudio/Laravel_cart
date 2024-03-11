<template>
    <div class="catalog-navigation-popup" v-if="catalogNavigation" @click="closeCatalogNavigation">
        <div class="catalog-navigation">
            <div class="block-header">
                <span>{{ trans.title }}</span>
                <button @click="closeCatalogNavigation" class="close"></button>
            </div>

            <div class="wrapper">
                <div class="nav-blocks">
                    <div class="nav-block" v-for="category in productCategories">
                        <span class="block-title">{{ category.name }}</span>

                        <ul class="ui-menu">
                            <li :class="['category-ite', 'level-1', sub_category.children.length ? 'parent' : '' ]" v-for="sub_category in category.children">
                                <a :href="sub_category.slug">
                                    <div class="icon">
                                        <img :src="sub_category.image" :alt="sub_category.name">
                                    </div>

                                    <span>{{ sub_category.name }}</span>
                                </a>

                                <ul class="submenu" v-if="sub_category.children.length">
                                    <li class="mobile-back-category">{{ sub_category.name }}</li>

                                    <li :class="['category-item', sub_sub_category.children.length ? 'parent' : '']" v-for="sub_sub_category in sub_category.children">
                                        <a :href="sub_sub_category.slug">{{ sub_sub_category.name }}</a>

                                        <ul class="submenu" v-if="sub_sub_category.children.length">
                                            <li class="category-item" v-for="sub_sub_sub_category in sub_sub_category.children">
                                                <a :href="sub_sub_sub_category.slug">{{ sub_sub_sub_category.name }}</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="contacts-block">
                    <span class="block-title">{{ trans.workingHours }}</span>

                    <ul>
                        <li>
                            <span class="day">{{ trans.mondayFriday }}</span>
                            <span class="hours">8:30-18:00</span>
                        </li>

                        <li>
                            <span class="day">{{ trans.saturday }}</span>
                            <span class="hours">9:00-16:00</span>
                        </li>

                        <li>
                            <span class="day">{{ trans.sunday }}</span>
                            <span class="hours">10:00-14:00</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CatalogNavigation',
    props: ['locale'],
    data() {
        return {
            productCategories: []
        }
    },
    computed: {
        trans() {
            return {
                title: this.translate('navigation', 'title'),
                workingHours: this.translate('navigation', 'working_hours'),
                mondayFriday: this.translate('navigation', 'monday_friday'),
                saturday: this.translate('navigation', 'saturday'),
                sunday: this.translate('navigation', 'sunday'),
            }
        },
        catalogNavigation() {
            return this.$store.state.catalogNavigation;
        },
    },
    methods: {
        translate(page, val) {
            const defTransaltions = {
                title: 'Title',
                working_hours: 'Working hours',
                monday_friday: 'Monday - Friday',
                saturday: 'Saturday',
                sunday: 'Sunday',
            }

            if (this.$store.state.currentTranslations[this.locale][page]) {
                return this.$store.state.currentTranslations[this.locale][page][val];
            } else {
                return defTransaltions[val];
            }
        },
        getProductCategories() {
            let payload = {
                locale: this.locale
            };

            this.$store.dispatch('getProductCategories', payload).then((data) => {
                this.productCategories = data;
            })
        },
        closeCatalogNavigation() {
            this.$store.state.catalogNavigation = null;

            document.getElementsByTagName('html')[0].style.overflow = "auto";
        }
    },
    mounted() {
        this.getProductCategories();
    }
}
</script>

<style lang="scss" scoped>
    .catalog-navigation-popup {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: 9999;

        @media screen {
            @media (min-width: 768px) {
                background: rgba(13, 36, 65, 0.50);
            }

            @media (max-width: 767px) {
                top: 78px;
            }
        }

        .catalog-navigation {
            position: relative;
            width: 340px;
            height: 100%;
            background-color: #fafafa;

            @media screen {
                @media (max-width: 991px) AND (min-width: 768px) {
                    width: 33.33vw;
                }

                @media (max-width: 767px) {
                    width: 100%;
                    background-color: #f9fafc;
                }
            }

            .block-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 16px;
                line-height: 24px;
                background: #0D2441 url('../../../../front/images/catalog-navigation-popup-block-header-bg.png') 0 0 no-repeat;
                background-size: cover;
                font-size: 18px;
                font-weight: 600;
                color: #fff;

                .close {
                    width: 32px;
                    height: 32px;
                    background: rgba(71, 100, 138, 0.50) url('../../../../front/images/close-catalog-navigation-icon.svg') center center no-repeat;
                    cursor: pointer;
                    transition: all .3s ease-in-out;
                    border-radius: 6px;

                    &:hover {
                        background-color: rgba(71, 100, 138, 0.90);
                    }
                }

                @media screen {
                    @media (max-width: 767px) {
                        display: none;
                    }
                }
            }

            .wrapper {
                display: flex;
                justify-content: space-between;
                flex-direction: column;
                height: 100%;
                max-height: calc(100% - 64px);
                overflow: auto;

                @media screen {
                    @media (max-width: 767px) {
                        max-height: 100%;
                    }
                }

                &::-webkit-scrollbar {
                    width: 5px;
                }

                &::-webkit-scrollbar-track {
                    background: #E9EAEC;
                    border-radius: 3px;
                }

                &::-webkit-scrollbar-thumb {
                    background: #C7C7C7;
                    border-radius: 3px;
                }

                &::-webkit-scrollbar-thumb:hover {
                    background: #B3B6BD;
                }
            }

            .block-title {
                display: block;
                padding: 0 16px;
                margin: 0 0 12px 0;
                font-size: 12px;
                font-weight: 500;
                line-height: 14px;
                letter-spacing: 1.2px;
                color: #CDCFD5;
                text-transform: uppercase;

                @media screen {
                    @media (max-width: 767px) {
                        line-height: 10px;
                        font-size: 10px;
                        letter-spacing: 1px;
                    }
                }
            }

            .nav-block {
                padding: 24px 0;

                &:not(:last-child) {
                    border-bottom: 1px solid #E9EAEC;
                }

                .block-title {
                    color: #616571;
                }

                .ui-menu {
                    li {
                        a {
                            position: relative;
                            display: flex;
                            align-items: center;
                            padding: 15px 16px;
                            line-height: 14px;
                            font-size: 14px;

                            @media screen {
                                @media (max-width: 991px) {
                                    line-height: normal;
                                }
                            }
                        }

                        &.parent {
                            > a {
                                padding-right: 40px;

                                &::after {
                                    content: '';
                                    position: absolute;
                                    top: 0;
                                    right: 24px;
                                    bottom: 0;
                                    margin: auto 0;
                                    width: 6px;
                                    height: 10px;
                                    background: url('../../../../front/images/nav-parent-arrow.svg') center center no-repeat;
                                    transition: all .3s ease-in-out;
                                }
                            }

                            .submenu {
                                position: absolute;
                                top: 0;
                                left: 100%;
                                bottom: 0;
                                width: 340px;
                                opacity: 0;
                                visibility: hidden;
                                transition: opacity .3s ease-in-out;

                                @media screen {
                                    @media (max-width: 1100px) {
                                        width: 280px;
                                    }

                                    @media (max-width: 991px) {
                                        width: 33.33vw;
                                    }
                                }
                            }

                            @media screen {
                                @media (min-width: 768px) {
                                    &:hover {
                                        > a {
                                            &::after {
                                                background: url('../../../../front/images/nav-parent-arrow-hover.svg') center center no-repeat;
                                            }
                                        }

                                        > .submenu {
                                            opacity: 1;
                                            visibility: visible;
                                        }
                                    }
                                }

                                @media (max-width: 767px) {
                                    &.show-mobile {
                                        > .submenu {
                                            left: 0;
                                            right: 0;
                                            width: 100%;
                                            opacity: 1;
                                            visibility: visible;
                                            z-index: 1;
                                        }
                                    }
                                }
                            }
                        }

                        &.level-1 {
                            > a {
                                padding: 5px 40px 5px 16px;
                                font-weight: 500;

                                .icon {
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    width: 43px;
                                    margin: 0 8px 0 0;
                                    background-color: #fff;
                                    border-radius: 3px;

                                    img {
                                        border-radius: 3px;
                                    }
                                }
                            }

                            &:hover {
                                &:hover {
                                    background-color: #EEEFF1;
                                }
                            }

                            .mobile-back-category {
                                position: relative;
                                padding: 20px 16px;
                                line-height: 16px;
                                background: #E9EAEC url('../../../../front/images/mobile-back-category-arrow.svg') 16px center no-repeat;
                                color: #0D2441;
                                font-size: 18px;
                                font-weight: 600;
                                text-align: center;
                                cursor: pointer;

                                @media screen {
                                    @media (min-width: 768px) {
                                        display: none;
                                    }
                                }
                            }

                            > .submenu {
                                background-color: #eeeff1;

                                @media screen {
                                    @media (max-width: 767px) {
                                        background-color: #f9fafb;
                                    }
                                }

                                > .category-item {
                                    &:hover {
                                        > a {
                                            background-color: #E3E6E8;
                                        }
                                    }

                                    &.parent {
                                        > .submenu {
                                            background-color: #e2e6e9;

                                            @media screen {
                                                @media (max-width: 767px) {
                                                    background-color: #f9fafb;
                                                }
                                            }

                                            .category-item {
                                                > a {
                                                    &:hover {
                                                        background-color: #d8dce0;

                                                        @media screen {
                                                            @media (max-width: 767px) {
                                                                background-color:  #E3E6E8;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        @media screen {
                                            @media (max-width: 767px) {
                                                &.show-mobile {
                                                    > .submenu {
                                                        z-index: 2;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            .contacts-block {
                padding: 16px;
                background-color: #0D2441;
                color: #FAFAFA;
                font-size: 14px;

                @media screen {
                    @media (max-width: 767px) {
                        padding: 16px 27px;
                    }
                }

                .block-title {
                    margin: 0 0 8px 0;
                    padding-left: 0;
                    padding-right: 0;
                }

                ul {
                    li {
                        display: flex;
                        align-items: center;
                        margin: 0;

                        @media screen {
                            @media (max-width: 767px) AND (min-width: 576px) {
                                justify-content: space-between;
                            }
                        }

                        .day {
                            width: 190px;

                            @media screen {
                                @media (max-width: 991px) AND (min-width: 768px) {
                                    width: 60%;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
</style>
