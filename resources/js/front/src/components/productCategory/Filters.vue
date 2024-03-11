<template>
    <aside class="sidebar-filters">
        <div class="mobile-header">
            <span class="header-name">Filtrs</span>
            <button type="button" class="close-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <rect width="32" height="32" rx="8" fill="#E9EAEC"/>
                    <path d="M17.4097 15.9991L21.7061 11.7127C21.8943 11.5245 22 11.2693 22 11.0033C22 10.7372 21.8943 10.482 21.7061 10.2938C21.518 10.1057 21.2628 10 20.9967 10C20.7307 10 20.4755 10.1057 20.2873 10.2938L16.0009 14.5903L11.7144 10.2938C11.5262 10.1057 11.2711 10 11.005 10C10.7389 10 10.4837 10.1057 10.2956 10.2938C10.1074 10.482 10.0017 10.7372 10.0017 11.0033C10.0017 11.2693 10.1074 11.5245 10.2956 11.7127L14.592 15.9991L10.2956 20.2856C10.2019 20.3785 10.1276 20.489 10.0768 20.6108C10.0261 20.7325 10 20.8631 10 20.995C10 21.1269 10.0261 21.2575 10.0768 21.3793C10.1276 21.501 10.2019 21.6116 10.2956 21.7044C10.3884 21.7981 10.499 21.8724 10.6207 21.9232C10.7425 21.9739 10.8731 22 11.005 22C11.1369 22 11.2675 21.9739 11.3892 21.9232C11.511 21.8724 11.6215 21.7981 11.7144 21.7044L16.0009 17.408L20.2873 21.7044C20.3802 21.7981 20.4907 21.8724 20.6125 21.9232C20.7342 21.9739 20.8648 22 20.9967 22C21.1286 22 21.2592 21.9739 21.381 21.9232C21.5028 21.8724 21.6133 21.7981 21.7061 21.7044C21.7998 21.6116 21.8741 21.501 21.9249 21.3793C21.9756 21.2575 22.0017 21.1269 22.0017 20.995C22.0017 20.8631 21.9756 20.7325 21.9249 20.6108C21.8741 20.489 21.7998 20.3785 21.7061 20.2856L17.4097 15.9991Z" fill="#616571"/>
                </svg>
            </button>
        </div>

        <div class="filters-options-wrapper">
            <div class="filter-options">
                <div class="filter-option nav-bar">
                    <h4 class="filter-options-title" v-if="activeCategory">
                        <button type="button" class="back-btn" @click="moveOut()"></button>
                        <span>{{ activeCategory.name }}</span>
                    </h4>

                    <div class="filter-options-content">
                        <input
                            type="text"
                            class="form-control search-input"
                            placeholder="Meklēt"
                            @input="e => findCategory(e.target.value)"
                        />

                        <template v-if="activeCategory">
                            <ul class="items nav-list">
                                <li v-for="category in activeCategory.sub"
                                    :class="[
                                        'item',
                                        category.sub && category.sub.length > 0 ? 'parent' : '',
                                        selectedCategory && selectedCategory.value === category.value ? 'current' : ''
                                    ]">
                                    <a :href="category.slug" @click="e => moveToPage(e, category)">{{ category.name }}</a>

                                    <div @click="moveToCategory(category)">
                                        <svg v-if="category.sub && category.sub.length > 0" width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                        </svg>
                                    </div>
                                </li>
                            </ul>
                        </template>
                        <template v-else>
                            <ul class="items nav-list">
                                <li v-for="category in categoryList"
                                    :class="[
                                        'item',
                                        category.sub && category.sub.length > 0 ? 'parent' : '',
                                        selectedCategory && selectedCategory.value === category.value ? 'current' : ''
                                    ]">
                                    <a :href="category.slug" @click="e => moveToPage(e, category)">{{ category.name }}</a>

                                    <div @click="moveToCategory(category)">
                                        <svg v-if="category.sub && category.sub.length > 0" width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                        </svg>
                                    </div>
                                </li>
                            </ul>
                        </template>
                    </div>
                </div>

                <Filter
                    v-for="filter in filters"
                    :data="filter"
                    @select-filter="data => $emit('selectFilter', data)"
                />
            </div>
        </div>

        <div class="mobile-footer">
            <button type="button" class="btn-choose btn btn-primary">Atlasīt preces <span>({{ productCount }})</span></button>
            <button type="button" class="btn-cancel">Atcelt</button>
        </div>
    </aside>
</template>

<script>
import Filter from '@/js/front/src/components/productCategory/Filter.vue';

export default {
    name: 'Filters',
    components: {
        Filter
    },

    emits: [
        'routeUpdate',
        'selectFilter'
    ],

    props: [
        'categories',
        'filters',
        'productCount',
    ],

    data() {
        return {
            categoryList: [],
            activeCategory: null,
            selectedCategory: null,
        }
    },

    methods: {
        findCategory(value) {
            const foundCategories = this.categories.filter(el => el.name.toLowerCase().includes(value));

            if (foundCategories.length === 0) {
                let tmpCategories = [];

                const findCategory = (categories) => {
                    for (let i=0; i<categories.length; i++) {
                        if (categories[i].sub) {
                            const subCategories = categories[i].sub.filter(el => el.name.toLowerCase().includes(value));

                            if (subCategories.length > 0) {
                                tmpCategories = [
                                    ...tmpCategories,
                                    ...subCategories,
                                ]
                            } else {
                                if (categories[i].sub) {
                                    findCategory(categories[i].sub);
                                }
                            }
                        }
                    }
                };

                for (let i=0; i<this.categories.length; i++) {
                    findCategory(this.categories[i].sub);
                }

                this.categoryList = tmpCategories;
                this.activeCategory = null;
            } else {
                this.categoryList = foundCategories;
                this.activeCategory = null;
            }
        },
        findCategoryLevel(categories) {
            const category = categories.find(el => el.value === this.activeCategory.value);

            if (!category) {
                for (let i=0; i<categories.length; i++) {
                    if (this.findCategoryLevel(categories[i].sub)) {
                        return categories[i];
                    }
                }
            } else {
                return true;
            }
        },
        moveOut() {
            const category = this.findCategoryLevel(this.categories);

            if (typeof category === 'boolean') {
                this.activeCategory = null;
            } else {
                this.activeCategory = category;
            }
        },
        moveToCategory(category) {
            if (category.sub && category.sub.length > 0) {
                this.selectedCategory = null;
                this.activeCategory = category;
            } else {
                this.selectedCategory = category;
            }
        },
        moveToPage(e, category) {
            e.preventDefault();

            window.history.pushState({}, category.name , `${window.location.origin}/${category.slug}`);

            this.$emit('routeUpdate', category);
        }
    },

    beforeMount() {
        this.categoryList = this.categories;
    }
}
</script>

<style lang="scss" scoped>
    .sidebar-filters {
        flex-shrink: 0;
        width: 272px;

        @media screen {
            @media (max-width: 1120px) {
                padding-bottom: 98px;
            }
        }

        .filters-options-wrapper {
            @media screen {
                @media (max-width: 1120px) {
                    max-height: calc(100% - 96px);
                    overflow: auto;
                }
            }
        }

        .mobile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 80px;
            padding: 0 16px;
            margin: 0 0 16px 0;
            background: #182132 url('../../../../../../resources/front/images/filters-mobile-header-bg.png') center center no-repeat;
            background-size: cover;

            .header-name {
                font-size: 23px;
                font-weight: 600;
                line-height: 29px;
                letter-spacing: -0.46px;
                color: #FFF;
            }

            .close-btn {
                width: 32px;
                height: 32px;
                padding: 0;
                border: 0;
                cursor: pointer;
            }

            @media screen {
                @media (min-width: 1121px) {
                    display: none;
                }
            }
        }

        @media screen {
            @media (max-width: 1120px) {
                position: fixed;
                top: 0;
                right: -100vw;
                bottom: 0;
                width: 372px;
                background-color: #fafafa;
                opacity: 0;
                visibility: hidden;
                transition: all .3s ease-in-out;
                z-index: 99999;

                @media (min-width: 576px) {
                    &::after {
                        content: '';
                        position: absolute;
                        top: 0;
                        right: 100%;
                        bottom: 0;
                        width: calc(100vw - 372px);
                        background: rgba(7, 20, 36, 0.70);
                        opacity: 0;
                        visibility: hidden;
                        transition: all .3s ease-in-out;
                    }
                }

                &.mobile-show {
                    right: 0;
                    opacity: 1;
                    visibility: visible;

                    &::after {
                        opacity: 1;
                        visibility: visible;
                    }
                }
            }

            @media (max-width: 575px) {
                width: 100vw;
            }
        }

        .filter-options {
            @media screen {
                @media (max-width: 1120px) {
                    padding: 16px;
                }
            }

            .filter-option {
                &:not(:last-child) {
                    margin-bottom: 24px;
                    padding-bottom: 24px;
                    border-bottom: 1px solid #E3E3E8;
                }

                .filter-options-title {
                    position: relative;
                    display: block;
                    padding: 8px 30px 8px 0;
                    line-height: 16px;
                    cursor: pointer;

                    @media screen {
                        @media (max-width: 768px) {
                            padding: 6px 30px 6px 0;
                            line-height: 16px;
                            font-size: 16px;
                        }
                    }

                    &::after {
                        content: '';
                        display: block;
                        position: absolute;
                        top: 0;
                        right: 0;
                        bottom: 0;
                        margin: auto 0;
                        width: 12px;
                        height: 8px;
                        background: url('../../../../../../resources/front/images/category-filters-arrow-down.svg') right center no-repeat;
                        transition: all .3s ease-in-out;
                    }
                }

                .filter-options-content {
                    display: none;
                    padding: 14px 0 0 0;

                    .form-control {
                       width: 100%;
                    }

                    .search-input {
                        height: 42px;
                        padding-right: 50px;
                        border: 1px solid #D8DADE;
                        background: url('../../../../../../resources/front/images/search-icon-dark.svg') calc(100% - 16px) center no-repeat;
                        background-size: 20px;

                        &::-webkit-input-placeholder {
                            color: #7D8391;
                        }

                        &::-moz-placeholder {
                            color: #7D8391;
                        }

                        &:-ms-input-placeholder {
                            color: #7D8391;
                        }

                        &:-moz-placeholder {
                            color: #7D8391;
                        }

                        &::placeholder {
                            color: #7D8391;
                        }

                    }
                }

                &.nav-bar {
                    .filter-options-title {
                        display: flex;
                        align-items: center;
                        padding: 0;
                        cursor: auto;

                        span {
                            pointer-events: none;
                        }

                        .back-btn {
                            width: 18px;
                            height: 18px;
                            margin: 0 12px 0 0;
                            background: #E72E2C url('../../../../../../resources/front/images/choose-vehicle-back-btn-arrow.svg') center center no-repeat;
                            cursor: pointer;
                            transition: all 0.3s ease-in-out;
                            border-radius: 3px;
                        }

                        &::after {
                            content: none;
                        }

                    }

                    .filter-options-content {
                        display: block;
                    }

                    .search-input {
                        margin-bottom: 8px;
                    }

                    .items.nav-list {
                        .item {
                            display: block;
                            margin: 0;

                            > a {
                                display: block;
                                padding: 10px 0;
                                line-height: 16px;

                                @media screen {
                                    @media (max-width: 768px) {
                                        line-height: 14px;
                                    }
                                }
                            }

                            &.current {
                                > a {
                                    font-weight: 500;
                                    color: #E72E2C;
                                }
                            }

                            &.parent {
                                position: relative;
                                display: flex;
                                align-items: center;
                                justify-content: space-between;

                                & > div {
                                    display: flex;
                                    justify-content: end;
                                    height: 36px;
                                    align-items: center;
                                    cursor: pointer;
                                    flex-grow: 1;

                                    &:hover {
                                        & > svg {
                                            & > path {
                                                fill: #E72E2C;
                                            }
                                        }
                                    }

                                    & > svg {
                                        width: 6px;
                                        height: 10px;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        .mobile-footer {
            display: flex;
            gap: 0 16px;
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 16px;
            box-shadow: 0px -2px 8px 0px rgba(101, 107, 114, 0.10);


            .btn-choose, .btn-cancel {
                font-size: 14px;
            }

            .btn-choose {
                padding: 18px 36px;
                border-bottom: 2px solid #931211;
                font-weight: 500;

                span {
                    font-weight: 400;
                }
            }

            .btn-cancel {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 18px 16px;
                border: 0;
                line-height: 14px;
                color: #7D8391;
            }

            @media screen {
                @media (min-width: 1121px) {
                    display: none;
                }
            }
        }
    }
</style>
