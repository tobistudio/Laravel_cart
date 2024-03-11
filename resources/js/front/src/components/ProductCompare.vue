<template>
    <div class="container">
        <ul class="breadcrumb">
            <template v-for="(item, index) in data.breadcrumbs">
                <li :class="['breadcrumb-item', index === data.breadcrumbs.length - 1 ? 'active' : '']">
                    <span v-if="index === data.breadcrumbs.length - 1">{{ item.name }}</span>
                    <a :href="item.slug" v-else>{{ item.name }}</a>
                </li>
            </template>
        </ul>

        <div class="product-compare">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>

                        <th>
                            <div class="product-card">
                                <button type="button" class="remove"></button>

                                <a href="#" class="image">
                                    <img src="../../../../../public/images/front/compare-product-image-1.jpg" alt="">
                                </a>

                                <div class="details">
                                    <div>
                                        <h3 class="name">
                                            <a href="#">Bremžu diski FEBI BILSTEIN 26647</a>
                                        </h3>

                                        <div class="price">
                                            <div class="wrapper">
                                                <span class="new-price">€9.40</span>
                                                <span class="old-price">€10.45</span>
                                            </div>

                                            <span class="price-without-vat">€48.30 (bez PVN 21%)</span>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-primary btn-add">Ielikt grozā</button>
                                </div>
                            </div>
                        </th>

                        <th>
                            <div class="product-card">
                                <button type="button" class="remove"></button>

                                <a href="#" class="image">
                                    <img src="../../../../../public/images/front/compare-product-image-2.jpg" alt="">
                                </a>

                                <div class="details">
                                    <div>
                                        <h3 class="name">
                                            <a href="#">Bremžu diski JP GROUP 1163110700</a>
                                        </h3>

                                        <div class="price">
                                            <span>€45.80</span>
                                            <span class="price-without-vat">€48.30 (bez PVN 21%)</span>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-primary btn-add">Ielikt grozā</button>
                                </div>
                            </div>
                        </th>

                        <th>
                            <div class="product-card">
                                <button type="button" class="remove"></button>

                                <a href="#" class="image">
                                    <img src="../../../../../public/images/front/compare-product-image-3.jpg" alt="">
                                    <!-- <img src="../../../../../public/images/front/compare-product-image-3.jpg" alt=""> -->
                                </a>

                                <div class="details">
                                    <div>
                                        <h3 class="name">
                                            <a href="#">Bremžu diski MAPCO 25876</a>
                                        </h3>

                                        <div class="price">
                                            <span>€48.00</span>
                                            <span class="price-without-vat">€40.30 (bez PVN 21%)</span>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-primary btn-add">Ielikt grozā</button>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Uzstādīšanas puse</td>
                        <td class="product-1" data-mobile-group="Uzstādīšanas puse">Priekšējais tilts</td>
                        <td class="product-2" data-mobile-group="Uzstādīšanas puse">Priekšējais tilts</td>
                        <td class="product-3" data-mobile-group="Uzstādīšanas puse">Priekšējais tilts</td>
                    </tr>

                    <tr>
                        <td>Zīmola kategorija</td>
                        <td class="product-1" data-mobile-group="Zīmola kategorija"><span class="category premium">Premium</span></td>
                        <td class="product-2" data-mobile-group="Zīmola kategorija"><span class="category average">Vidējā</span></td>
                        <td class="product-3" data-mobile-group="Zīmola kategorija"><span class="category average">Vidējā</span></td>
                    </tr>

                    <tr>
                        <td>Ražotājs</td>
                        <td class="product-1" data-mobile-group="Ražotājs">FEBI BILSTEIN</td>
                        <td class="product-2" data-mobile-group="Ražotājs">JP GROUP</td>
                        <td class="product-3" data-mobile-group="Ražotājs">MAPCO</td>
                    </tr>

                    <tr>
                        <td>Bremžu diska biezums</td>
                        <td class="product-1" data-mobile-group="Bremžu diska biezums">30 mm</td>
                        <td class="product-2" data-mobile-group="Bremžu diska biezums">30 mm</td>
                        <td class="product-3" data-mobile-group="Bremžu diska biezums">30 mm</td>
                    </tr>

                    <tr>
                        <td>Riteņa diska urbumu skaits</td>
                        <td class="product-1" data-mobile-group="Riteņa diska urbumu skaits">5</td>
                        <td class="product-2" data-mobile-group="Riteņa diska urbumu skaits">5</td>
                        <td class="product-3" data-mobile-group="Riteņa diska urbumu skaits">5</td>
                    </tr>

                    <tr>
                        <td>Stiprināšanas urbumu skaits</td>
                        <td class="product-1" data-mobile-group="Stiprināšanas urbumu skaits">1</td>
                        <td class="product-2" data-mobile-group="Stiprināšanas urbumu skaits">1</td>
                        <td class="product-3" data-mobile-group="Stiprināšanas urbumu skaits">1</td>
                    </tr>

                    <tr>
                        <td>Biezums</td>
                        <td class="product-1" data-mobile-group="Biezums">59,4 mm</td>
                        <td class="product-2" data-mobile-group="Biezums">59,4 mm</td>
                        <td class="product-3" data-mobile-group="Biezums">59,4 mm</td>
                    </tr>

                    <tr>
                        <td>Ārējais diametrs</td>
                        <td class="product-1" data-mobile-group="Ārējais diametrs">321 mm</td>
                        <td class="product-2" data-mobile-group="Ārējais diametrs">321 mm</td>
                        <td class="product-3" data-mobile-group="Ārējais diametrs">321 mm</td>
                    </tr>

                    <tr>
                        <td>Skrūvju loks - Ø</td>
                        <td class="product-1" data-mobile-group="Skrūvju loks - Ø">112 mm</td>
                        <td class="product-2" data-mobile-group="Skrūvju loks - Ø">112 mm</td>
                        <td class="product-3" data-mobile-group="Skrūvju loks - Ø">112 mm</td>
                    </tr>

                    <tr>
                        <td>Virsma</td>
                        <td class="product-1" data-mobile-group="Virsma">pārklāts</td>
                        <td class="product-2" data-mobile-group="Virsma">pārklāts</td>
                        <td class="product-3" data-mobile-group="Virsma">pārklāts</td>
                    </tr>

                    <tr>
                        <td>Bremžu diska tips</td>
                        <td class="product-1" data-mobile-group="Bremžu diska tips">ar iekšējo ventilāciju</td>
                        <td class="product-2" data-mobile-group="Bremžu diska tips">ar iekšējo ventilāciju</td>
                        <td class="product-3" data-mobile-group="Bremžu diska tips">ar iekšējo ventilāciju</td>
                    </tr>

                    <tr>
                        <td>Minimālais biezums</td>
                        <td class="product-1" data-mobile-group="Minimālais biezums">28 mm</td>
                        <td class="product-2" data-mobile-group="Minimālais biezums">28 mm</td>
                        <td class="product-3" data-mobile-group="Minimālais biezums">28 mm</td>
                    </tr>

                    <tr>
                        <td>Centrējošais diametrs</td>
                        <td class="product-1" data-mobile-group="Centrējošais diametrs">68 mm</td>
                        <td class="product-2" data-mobile-group="Centrējošais diametrs">68 mm</td>
                        <td class="product-3" data-mobile-group="Centrējošais diametrs">68 mm</td>
                    </tr>

                    <tr>
                        <td>Svars</td>
                        <td class="product-1" data-mobile-group="Svars">10,8 kg</td>
                        <td class="product-2" data-mobile-group="Svars">10,8 kg</td>
                        <td class="product-3" data-mobile-group="Svars">10,8 kg</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import {defineAsyncComponent} from 'vue'

export default {
    name: 'ProductCompare',
    props: ['locale', 'data'],
    data() {
        return {
            activeVehicleSearchBlock: false
        }
    },
    components: {
        // heroVehicleSearch: defineAsyncComponent(() => import('./HeroVehicleSearch.vue')),
        // filters: defineAsyncComponent(() => import('./productCategory/Filters.vue')),
        // controlsTop: defineAsyncComponent(() => import('./productCategory/ControlsTop.vue')),
        // products: defineAsyncComponent(() => import('./productCategory/Products.vue')),
        // controlsBottom: defineAsyncComponent(() => import('./productCategory/ControlsBottom.vue')),
    },
    computed: {
        trans() {
            return {
                // title: this.translate('productCategory', 'title'),
            }
        },
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        }
    },
    mounted() {
        this.$store.state.comparePage = true;
    }
}
</script>

<style lang="scss" scoped>
    .sub-text {
        margin: 10px auto 0;
        line-height: 18px;
        font-size: 18px;

        &:before {
            content: unset;
        }

        p {
            color: #CDCFD5;
        }
    }

    .container.has-aside {
        display: flex;
        gap: 40px;

        @media screen {
            @media (max-width: 1120px) {
                flex-direction: column;
                gap: 0;
            }
        }

        .column.main {
            flex-grow: 1;
        }
    }

    .page-header-box {
        @media screen {
            @media (max-width: 1120px) {
                margin: 0;
            }
        }
    }

    .breadcrumb {
        @media screen {
            @media (max-width: 575px) {
                margin: 0 0 33px 0;
            }
        }
    }

    .mobile-toolbar {
        position: relative;
        margin: 0 0 12px 0;
        background: #EEEFF1;
        box-shadow: 0px 1px 2px -1px rgba(16, 24, 40, 0.10), 0px 1px 3px 0px rgba(16, 24, 40, 0.10);
        z-index: 11;

        @media screen {
            @media (min-width: 1121px) {
                display: none;
            }

            @media (max-width: 575px) {
                margin: 0 0 2px 0;
            }
        }

        .buttons-holder {
            position: relative;
            display: flex;

            &::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                margin: auto;
                width: 1px;
                height: 24px;
                background-color: #D8DADE;
            }
        }

        .sorter-group,
        .filters-toggle {
            flex-basis: 50%;
            text-align: center;
        }

        .sorter-group {
            position: relative;

            .sorter-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 56px;
                width: 100%;
                line-height: 16px;
                font-weight: 600;
                color: #0D2441;
                cursor: pointer;

                &::before {
                    content: '';
                    width: 16px;
                    height: 16px;
                    margin: 0 12px 0 0;
                    background: url('../../../../../resources/front/images/sort-icon.svg') center center no-repeat;
                }
            }

            .dropdown {
                position: absolute;
                top: calc(100% + 4px);
                left: 0;
                right: 0;
                max-height: 220px;
                padding: 4px 0;
                background-color: #fff;
                border: 1px solid #EBEBEF;
                overflow: auto;
                visibility: hidden;
                opacity: 0;
                border-radius: 8px;
                box-shadow: 0px 8px 30px 0px rgba(140, 148, 156, 0.10), 0px 2px 8px 0px rgba(101, 107, 114, 0.10);
                transition: all .3s ease-in-out;
                z-index: 1;

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

                .inner-dropdown {
                    li {
                        padding: 11px 16px;
                        line-height: 14px;
                        color: #0D2441;
                        font-size: 14px;
                        font-weight: 400;
                        cursor: pointer;
                        text-align: left;
                        transition: all .3s ease-in-out;

                        &:hover {
                            background: #F4F4F6;
                        }

                        &.selected {
                            background: #F4F4F6;
                        }
                    }
                }
            }

            &.opened {
                .dropdown {
                    visibility: visible;
                    opacity: 1;
                }
            }
        }

        .filters-toggle {
            height: 56px;
            line-height: 16px;
            font-weight: 600;
            color: #0D2441;
            cursor: pointer;

            > span {
                display: flex;
                align-items: center;
                justify-content: center;

                &::before {
                    content: '';
                    width: 18px;
                    height: 18px;
                    margin: 0 12px 0 0;
                    background: url('../../../../../resources/front/images/filters-icon.svg') center center no-repeat;
                }

                > span {
                    margin: 0 0 0 4px;
                    font-weight: 400;
                    color: #616571;
                }
            }
        }
    }

    .spare-parts-catalog {
        .page-title {
            font-size: 30px;
            line-height: 36px;
            letter-spacing: -0.6px;

            @media screen {
                @media (max-width: 768px) {
                    line-height: 32px;
                    font-size: 26px;
                    letter-spacing: -0.52px;
                }
            }
        }

        .toolbar {
            margin: 0 0 44px 0;

            @media screen {
                @media (max-width: 1130px) {
                    margin: 0 0 40px 0;
                }
            }

            .container {
                display: flex;
                align-items: center;
                justify-content: space-between;

                @media screen {
                    @media (max-width: 1130px) {
                        flex-direction: column;
                        justify-content: flex-start;
                        align-items: flex-start;
                    }
                }
            }

            .selected-options {
                display: flex;
                align-items: center;
                gap: 0 16px;
                margin: 10px 0 0 0;
                line-height: 14px;
                font-size: 14px;

                @media screen {
                    @media (max-width: 575px) {
                        flex-direction: column;
                        align-items: flex-start;
                        gap: 12px 0;

                        > span {
                            line-height: 18px;
                        }
                    }
                }

                .action-btns {
                    display: flex;
                    align-items: center;
                    gap: 0 12px;

                    button, a {
                        padding: 0;
                        border: 0;
                        background: none;
                        font-weight: 600;
                        color: #E72E2C;
                        cursor: pointer;

                        &:hover {
                            text-decoration: underline;
                        }
                    }
                }
            }

            .search-form {
                position: relative;
                width: 100%;

                @media screen {
                    @media(min-width: 1131px) {
                        max-width: 400px;
                    }

                    @media (max-width: 1130px) {
                        margin: 32px 0 0 0;
                    }

                    @media (max-width: 768px) {
                        margin: 29px 0 0 0;
                    }
                }

                .form-control {
                    width: 100%;
                    height: 42px;
                    padding: 0 50px 0 16px;

                    @media screen {
                        @media (max-width: 1130px) {
                            height: 48px;
                        }
                    }
                }

                button[type="submit"] {
                    position: absolute;
                    top: 0;
                    right: 16px;
                    bottom: 0;
                    width: 18px;
                    height: 18px;
                    padding: 0;
                    margin: auto 0;
                    border: 0;
                    background: url('../../../../../resources/front/images/search-icon-dark.svg') center center no-repeat;
                    background-size: contain;
                    cursor: pointer;
                }
            }
        }

        .container.has-side {
            display: flex;
            gap: 0 24px;
        }

        .categories-list {
            display: grid;
            gap: 24px;
            grid-template-columns: repeat(4, minmax(0, 1fr));

            @media screen {
                @media (max-width: 1199px) AND (min-width: 1031px) {
                    gap: 16px;
                }

                @media (max-width: 1030px) {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                @media (max-width: 575px) {
                    grid-template-columns: auto;
                    gap: 16px 0;
                }
            }

            .col {
                height: 100%;
            }

            .category {
                padding: 0 0 8px 0;
                border: 1px solid #EBECED;
                border-radius: 8px;

                @media screen {
                    @media (max-width: 575px) {
                        padding: 0;
                    }
                }

                &:not(:last-child) {
                    margin: 0 0 24px 0;

                    @media screen {
                        @media (max-width: 575px) {
                            margin: 0 0 16px 0;
                        }
                    }
                }

                .block-header {
                    display: flex;
                    align-items: center;
                    position: relative;
                    padding-right: 20%;
                    margin: 0 0 32px 0;
                    background-color: #F4F5F6;
                    border-radius: 8px 8px 0 0;

                    @media screen {
                        @media (min-width: 576px) {
                            height: 72px;
                            padding: 24px 20px;
                        }

                        @media (max-width: 575px) {
                            height: 64px;
                            margin: 0;
                            padding: 16px 0 16px 16px;
                            background-color: transparent;
                            cursor: pointer;
                        }
                    }

                    .cat-name {
                        padding: 0 95px 0 0;
                        font-size: 18px;
                        line-height: 24px;
                        color: #0D2441;

                        @media screen {
                            @media (max-width: 1399px) {
                                padding: 0 60px 0 0;
                            }

                            @media (max-width: 1199px) AND (min-width: 1031px) {
                                font-size: 16px;
                                line-height: 21px;
                            }

                            @media (max-width: 575px) {
                                order: 2;
                                width: 100%;
                                line-height: 20px;
                                font-size: 16px;
                            }
                        }
                    }

                    .cat-image {
                        position: absolute;
                        top: 8px;
                        right: 20px;
                        max-width: 99px;
                        pointer-events: none;
                        border-radius: 4px;

                        @media screen {
                            @media (max-width: 1399px) AND (min-width: 1031px) {
                                display: flex;
                                align-items: center;
                                bottom: 8px;
                                max-width: 60px;
                                margin: auto 0;
                            }

                            @media (max-width: 670px) {
                                display: flex;
                                align-items: center;
                                bottom: 8px;
                                max-width: 60px;
                                margin: auto 0;
                            }

                            @media (max-width: 575px) {
                                order: 1;
                                position: static;
                                display: flex;
                                align-items: center;
                                width: 40px;
                                height: 32px;
                                margin: 0 12px 0 0;

                                img {
                                    max-width: 100%;
                                    max-height: 100%;
                                }
                            }
                        }
                    }

                    .mobile-icon-arrow {
                        display: flex;
                        align-items: center;
                        justify-content: flex-end;
                        position: absolute;
                        top: 0;
                        right: 16px;
                        bottom: 0;
                        margin: auto 0;
                        width: 20px;
                        height: 20px;
                        transition: all .3s ease-in-out;

                        svg {
                            path {
                                transition: all .3s ease-in-out;
                            }
                        }

                        @media screen {
                            @media (min-width: 576px) {
                                display: none;
                            }
                        }
                    }
                }

                .nav-list-name {
                    display: block;
                    padding: 8px 16px;
                    font-size: 12px;
                    font-weight: 500;
                    line-height: 14px;
                    letter-spacing: 1.2px;
                    text-transform: uppercase;

                    @media screen {
                        @media (max-width: 575px) {
                            display: none;
                        }
                    }
                }

                .nav-list {
                    @media screen {
                        @media (max-width: 575px) {
                            display: none;
                        }
                    }

                    .item {
                        transition: all .3s ease-in-out;

                        > a {
                            position: relative;
                            display: flex;
                            align-items: center;
                            padding: 14px 30px 14px 16px;
                            line-height: 14px;
                            font-size: 14px;

                            @media screen {
                                @media (max-width: 575px) {
                                    padding-left: 20px;
                                }
                            }

                            .icon-arrow {
                                display: flex;
                                align-items: center;
                                justify-content: flex-end;
                                position: absolute;
                                top: 0;
                                right: 24px;
                                bottom: 0;
                                margin: auto 0;
                                width: 14px;
                                height: 14px;
                                transition: all .3s ease-in-out;

                                @media screen {
                                    @media (max-width: 575px) {
                                        right: 18px;
                                        justify-content: center;
                                    }
                                }

                                svg {
                                    path {
                                        transition: all .3s ease-in-out;
                                    }
                                }
                            }

                            &:hover {
                                background: #F4F5F6;
                                color: #E72E2C;
                                /* font-weight: 500; */

                                .icon-arrow {
                                    path {
                                        fill: #E72E2C;
                                    }
                                }
                            }
                        }

                        .sub-categories {
                            display: none;

                            li {
                                a {
                                    display: block;
                                    padding: 13px 24px;
                                    line-height: 14px;
                                    font-size: 14px;
                                    color: #49515A;

                                    @media screen {
                                        @media (max-width: 575px) {
                                            padding-left: 28px;
                                        }
                                    }

                                    &:hover {
                                        background-color: #eee;
                                        color: #E72E2C;
                                    }
                                }
                            }
                        }

                        &.parent {
                            &.opened {
                                @media screen {
                                    @media (min-width: 576px) {
                                        background: #F4F5F6;
                                    }
                                }

                                > a {
                                    @media screen {
                                        @media (max-width: 575px) {
                                            background: #F4F5F6;
                                        }
                                    }

                                    .icon-arrow {
                                        transform: rotate(90deg);

                                        path {
                                            fill: #E72E2C;
                                        }
                                    }
                                }

                                .sub-categories {
                                    display: block;
                                }
                            }
                        }
                    }
                }

                @media screen {
                    @media (max-width: 575px) {
                        &.mobile-opened {
                            .mobile-icon-arrow {
                                transform: rotate(-180deg);
                            }
                            .nav-list {
                                display: block;
                            }

                        }
                    }
                }
            }
        }
    }

    .selected-vehicle {
        margin: 0 0 40px 0;
        line-height: 14px;
        font-size: 14px;

        .catalog-name {
            display: block;
            margin: 0 0 12px 0;
            font-size: 30px;
            line-height: 36px;
            letter-spacing: -0.6px;
        }

        @media screen {
            @media (max-width: 575px) {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px 0;

                > span {
                    line-height: 18px;
                }
            }
        }

        .holder {
            display: flex;
            align-items: center;
            gap: 0 16px;
        }

        .action-btns {
            display: flex;
            align-items: center;
            gap: 0 12px;

            button, a {
                padding: 0;
                border: 0;
                background: none;
                font-weight: 600;
                color: #E72E2C;
                cursor: pointer;

                &:hover {
                    text-decoration: underline;
                }
            }
        }
    }


    .product-compare {
        @media screen {
            @media (max-width: 991px) {
                margin-top: -32px;
            }
        }

        .table {
            width: 100%;
            border-collapse: collapse;

            thead {
                position: relative;

                tr {
                    th {
                        position: sticky;
                        top: 0;
                        padding: 48px 25px 40px 0;
                        background: #fafafa;
                        vertical-align: top;
                        z-index: 1;

                        @media screen {
                            @media (max-width: 991px) {
                                width: 33.33%;
                                padding: 32px 25px 32px 0;
                                vertical-align: top;

                                &:first-child {
                                    display: none;
                                }
                            }

                            @media (max-width: 660px) {
                                width: 50%;
                                padding-top: 24px;
                                padding-right: 16px;

                                &:nth-child(3) {
                                    padding-right: 0;
                                }

                                &:last-child {
                                    display: none;
                                }
                            }
                        }

                        &:last-child {
                            padding-right: 0;
                        }

                        .product-card {
                            display: flex;
                            flex-direction: column;
                            position: relative;
                            padding: 0;
                            border: 0;
                            background: transparent;
                            border-radius: 0;

                            .remove {
                                position: absolute;
                                top: 10px;
                                right: 10px;
                                width: 32px;
                                height: 32px;
                                border: 0;
                                background: #F7F7F8 url('../../../../../resources/front/images/remove-compare-product.svg') center center no-repeat;
                                cursor: pointer;
                                background-size: 12px;
                                transition: all .3s ease-in-out;
                                border-radius: 4px;
                                z-index: 1;

                                @media screen {
                                    @media (max-width: 660px) {
                                        width: 24px;
                                        height: 24px;
                                    }
                                }

                                &:hover {
                                    background-color: #dadada;
                                }
                            }

                            .image {
                                height: 143px;
                                margin: 0 0 16px 0;
                                background-color: #fff;
                                border-radius: 8px;

                                img {
                                    max-height: 90%;
                                }

                                @media screen {
                                    @media (max-width: 991px) {
                                        height: 119px;
                                    }

                                    @media (max-width: 660px) {
                                        height: 85px;
                                        margin: 0 0 8px 0;
                                    }
                                }
                            }

                            .details {
                                display: flex;
                                flex-direction: column;
                                justify-content: space-between;
                                flex-grow: 1;

                                .name {
                                    min-height: 37px;
                                    font-size: 16px;
                                    font-weight: 600;
                                    line-height: 22px;
                                    text-align: left;

                                    @media screen {
                                        @media (max-width: 660px) {
                                            min-height: 36px;
                                            font-size: 14px;
                                        }
                                    }
                                }

                                .price {
                                    flex-direction: column;
                                    align-items: flex-start;
                                    font-size: 20px;

                                    @media screen {
                                        @media (max-width: 991px) {
                                            font-size: 18px;
                                        }

                                        @media (max-width: 660px) {
                                            font-size: 16px;
                                        }
                                    }

                                    .wrapper {
                                        display: flex;
                                        align-items: center;
                                    }

                                    .price-without-vat {
                                        display: block;
                                        margin: 6px 0 0 0;
                                        font-size: 14px;
                                        font-weight: 400;
                                        line-height: 14px;
                                        color: #49515A;
                                        text-align: left;

                                        @media screen {
                                            @media (max-width: 991px) {
                                                margin: 4px 0 18px 0;
                                            }

                                            @media (max-width: 660px) {
                                                margin-bottom: 15px;
                                                line-height: 12px;
                                                font-size: 12px;
                                            }
                                        }
                                    }
                                }

                                .btn-add {
                                    width: 100%;
                                    margin-top: 18px;

                                    @media screen {
                                        @media (max-width: 991px) {
                                            padding: 12px 15px;
                                            margin: 0;
                                        }
                                    }
                                }
                            }
                        }

                        .show-options {
                            text-align: left;

                            > span {
                                display: block;
                                margin: 0 0 16px 0;
                                font-size: 16px;
                            }

                            .form-group {
                                margin: 0 0 12px 0;

                                &:last-child {
                                    margin: 0;
                                }
                            }
                        }
                    }
                }

                .load-more-items {
                    position: absolute;
                    top: 0;
                    right: 0;
                    bottom: 0;
                    height: 16px;
                    width: 16px;
                    background-color: red;
                }
            }

            th, td {
                border-style: solid;
                border-width: 0;
            }

            tbody {
                tr {
                    td {
                        padding: 16px;
                        line-height: 14px;
                        font-size: 14px;
                        font-weight: 500;
                        color: #0D2441;
                        vertical-align: middle;

                        @media screen {
                            @media (max-width: 991px) {
                                padding: 22px 0 42px 0;
                                border-top: 1px solid #e9eaec;
                                vertical-align: top;

                                &:first-child {
                                    display: none;
                                }

                                &.product-1 {
                                    position: relative;

                                    &::before {
                                        content: attr(data-mobile-group);
                                        position: absolute;
                                        top: -8px;
                                        left: 0;
                                        padding: 0 16px 0 0;
                                        line-height: 14px;
                                        background-color: #f9fafc;
                                        color: #585D68;
                                        font-size: 14px;
                                        font-weight: 400;
                                    }
                                }
                            }

                            @media (max-width: 660px) {
                                width: 50%;
                                padding-bottom: 37px;

                                &:last-child {
                                    display: none;
                                }
                            }
                        }

                        &:first-child {
                            width: 31.9%;
                            font-weight: 400;
                            color: #585D68;
                        }

                        &.product-1,
                        &.product-2,
                        &.product-3 {
                            width: 22.7%;

                            @media screen {
                                @media (max-width: 991px) {
                                    width: 33.33%;
                                }
                            }
                        }

                        .category {
                            display: inline-block;
                            padding: 5.5px 8px;
                            font-size: 10px;
                            font-weight: 600;
                            line-height: 10px;
                            letter-spacing: 0.04em;
                            color: #fff;
                            text-transform: uppercase;
                            text-align: center;
                            border-radius: 4px;

                            &.premium {
                                background-color: #E72E2C;
                            }

                            &.average {
                                background-color: #F06D23;
                            }

                        }
                    }

                    @media screen {
                        @media (min-width: 992px) {
                            &:nth-child(2n+0) {
                                td {
                                    background: #F1F2F3;
                                }
                            }
                        }

                        @media (max-width: 991px) {
                            &:last-child {
                                td {
                                    padding-bottom: 0;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
</style>
