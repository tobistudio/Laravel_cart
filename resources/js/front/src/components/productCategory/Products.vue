<template>
    <div class="products-list grid-view" v-if="view === 'grid'">
        <div class="product-card" v-for="product in products">
            <a v-if="product.manufacturer" :href="product.manufacturer.slug" class="manufacturer">
                <img :src="product.manufacturer.featured_image" :alt="product.manufacturer.name">
            </a>

            <a :href="product.language_page.slug" class="image">
                <img :src="product.language_page.featured_image" :alt="product.language_page.name">

                <div class="product-label" v-if="product.labels.length > 0">
                    <div v-for="label in product.labels" :class="['label', label.key]">{{ label.name }}</div>
                </div>
            </a>

            <div class="details">
                <h3 class="name">
                    <a :href="product.language_page.slug">{{ product.language_page.name }}</a>
                </h3>

                <div class="product-code">{{ translate('product', 'productCode') }}: {{ product.language_page.data.sku }}</div>
                <div class="stock-ability outgoing">Atlicis noliktavā: {{ storageCount(product) }}</div>
                <div class="delivery-time">Saņem: <strong>Rīt, 22.08.2023</strong> (Jelgava)</div>

                <div class="price">
                    <template v-if="typeof product.language_page.data.special_price === 'string' && product.language_page.data.special_price.trim() !== ''">
                        <span class="new-price">€{{ product.language_page.data.special_price }}
                            <span class="discount mobile">-{{ getPriceDiscountPercentage(product.language_page.data.special_price, product.language_page.data.price) }}%</span>
                        </span>
                        <span class="old-price">€{{ product.language_page.data.price }}</span>
                        <span class="discount desktop">-{{ getPriceDiscountPercentage(product.language_page.data.special_price, product.language_page.data.price) }}%</span>
                    </template>
                    <template v-else>
                        <div class="price"> €{{ product.language_page.data.price }} </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <div v-if="view === 'list'" class="products-list list-view">
        <div class="product-card" v-for="product in products">
            <div class="image-holder">
                <a v-if="product.manufacturer" :href="product.manufacturer.slug" class="manufacturer">
                    <img :src="product.manufacturer.featured_image" :alt="product.manufacturer.name">
                </a>

                <a :href="product.slug" class="image">
                    <img :src="product.language_page.featured_image" :alt="product.language_page.name">

                    <div class="product-label" v-if="product.labels.length > 0">
                        <div v-for="label in product.labels" :class="['label', label.key]">{{ label.name }}</div>
                    </div>
                </a>
            </div>

            <div class="details">
                <div class="top-details">
                    <div>
                        <div class="product-label" v-if="product.labels.length > 0">
                            <div v-for="label in product.labels" :class="['label', label.key]">{{ label.name }}</div>
                        </div>

                        <h3 class="name">
                            <a :href="product.language_page.slug">{{ product.language_page.name }}</a>
                        </h3>

                        <div class="product-code">{{ translate('product', 'productCode') }}: {{ product.language_page.data.sku }}</div>
                    </div>

                    <div class="mobile-image">
                        <a :href="product.language_page.slug" class="image">
                            <img :src="product.language_page.featured_image" :alt="product.language_page.name">

                            <div class="product-label" v-if="product.labels.length > 0">
                                <div v-for="label in product.labels" :class="['label', label.key]">{{ label.name }}</div>
                            </div>
                        </a>
                    </div>
                </div>

                <ul class="features">
                    <li>Ražotājs: <strong>Bosch</strong></li>
                    <li>Ražotāja preces kods: <strong>0 092 S50 050</strong></li>
                    <li>Akumulatora ietilpība (Ah): <strong>75Ah</strong></li>
                    <li>CCA strāva EN (A): <strong>730A</strong></li>
                    <li>Ražotāja preces kods: <strong>0 092 S50 050</strong></li>
                    <li>Akumulatora ietilpība (Ah): <strong>75Ah</strong></li>
                </ul>

                <button type="button" class="show-more">Vairāk</button>
            </div>

            <div class="add-to-cart">
                <div class="toggle-options">
                    <div :class="`option ${product.selectedStorage === 0 ? 'active' : ''}`" @click="product.selectedStorage = 0">
                        <span class="span-label">
                            {{ translate('product', marketCount(product) > 0 ? 'inStore' : 'notInStore') }}
                        </span>
                        <span class="value" :style="`${marketCount(product) === 0 ? 'color: #E72E2C' : ''}`">
                            {{ marketCount(product) }}
                            {{ translate('product', 'count') }}
                        </span>
                    </div>

                    <div :class="`option ${product.selectedStorage === 1 ? 'active' : ''}`" @click="product.selectedStorage = 1">
                        <span class="span-label">{{ translate('product', storageCount(product) > 0 ? 'inStorage' : 'notInStorage') }}</span>
                        <span class="value" :style="`${storageCount(product) === 0 ? 'color: #E72E2C' : 'color: #1F8C31'}`">
                            {{ storageCount(product) > 0
                            ? `€${product.warehouses.filter(el => [2, 4].includes(el.warehouse.type))[0].product_price}`
                            : '-' }}
                        </span>
                    </div>
                </div>

                <div v-if="product.selectedStorage === 1" class="available">
                    {{ translate('product', 'availableIn') }}
                    {{ product.warehouses.filter(el => el.warehouse.type === 4).filter(el => el.product_count > 0).length }}
                    {{ translate('product', 'storages') }}
                    <a href="#" @click="(e) => { e.preventDefault(); product.warehousesPopup = true; }">{{ translate('product', 'watch') }}</a>
                </div>

                <div class="price-holder">
                    <span class="final-price">€{{ product.language_page.data.price }}</span>
                    <span class="price-without-vat">€{{ Number(product.language_page.data.price) - (Number(product.language_page.data.price) / 100 * 21).toFixed(2) }} ({{ translate('product', 'withoutVat') }})</span>
                </div>

                <div class="product-qty">
                    <button type="button" class="minus" @click="product.productsToBuy > 1 ? product.productsToBuy -= 1 : {}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M14.1737 6.85742C14.5524 6.85742 14.8594 7.13724 14.8594 7.48242L14.8594 8.73242C14.8594 9.0776 14.5524 9.35742 14.1737 9.35742L1.8308 9.35742C1.45209 9.35742 1.14509 9.0776 1.14509 8.73242L1.14509 7.48242C1.14509 7.13724 1.45209 6.85742 1.8308 6.85742L14.1737 6.85742Z" fill="#9398A3"/>
                        </svg>
                    </button>

                    <input type="number" v-model="product.productsToBuy" class="qty-input">

                    <button type="button" class="plus" @click="product.productsToBuy < marketCount(product) ? product.productsToBuy += 1 : {}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M6.62891 1.82829C6.62891 1.44958 6.90873 1.14258 7.25391 1.14258H8.50391C8.84908 1.14258 9.12891 1.44958 9.12891 1.82829V14.1712C9.12891 14.5499 8.84908 14.8569 8.50391 14.8569H7.25391C6.90873 14.8569 6.62891 14.5499 6.62891 14.1712V1.82829Z" fill="#0D2441"/>
                        <path d="M14.0526 6.75C14.4313 6.75 14.7383 7.02982 14.7383 7.375L14.7383 8.625C14.7383 8.97018 14.4313 9.25 14.0526 9.25L1.70971 9.25C1.331 9.25 1.024 8.97018 1.024 8.625L1.024 7.375C1.024 7.02982 1.331 6.75 1.70971 6.75L14.0526 6.75Z" fill="#0D2441"/>
                        </svg>
                    </button>
                </div>

                <button type="button" class="cart-btn btn btn-primary" @click="addToCart(product.id, product.productsToBuy)">
                    <span>{{ translate('product', 'addToCart') }}</span>
                </button>

                <div class="availability">
                    <span>{{ translate('product', 'available') }}:</span>

                    <ul>
                        <li><strong>Šodien, 23.11.</strong> (pasūtot līdz 14:00)</li>
                        <li><strong>Rīt, 24.11.</strong> (pasūtot līdz 18:00)</li>
                    </ul>
                </div>
            </div>

            <ProductWarehousePopup
                :showPopup="product.warehousesPopup"
                :locale="locale"
                :warehouses="product.warehouses"
                :languageId="product.language_page.language_id"
                :addToCart="addToCart"
                @closePopup="product.warehousesPopup = false"
            />
        </div>
    </div>

</template>

<script>
import ProductWarehousePopup from '@/js/front/src/components/ProductWarehousePopup.vue';

export default {
    name: 'Products',

    components: {
        ProductWarehousePopup,
    },

    props: [
        'data',
        'view',
        'locale',
        'currentPage',
        'showPerPage',
    ],

    computed: {
        'products'() {
            const from = this.currentPage * this.showPerPage - this.showPerPage;
            const to = this.currentPage * this.showPerPage;

            if (from >= 0) {
                return this.data.slice(from, to);
            } else {
                return this.data;
            }
        }
    },

    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        getPriceDiscountPercentage(price, priceOld) {
            return 100 - parseInt((Number(price) / Number(priceOld) * 100).toString(), 10);
        },
        marketCount(product) {
            const count = product.warehouses.filter(el => el.warehouse.type === 1).reduce(
                (accumulator, currentValue) => accumulator.product_count + currentValue.product_count,
                { product_count: 0 });

            return count > 0 ? count : 0;
        },
        storageCount(product) {
            const count = product.warehouses.filter(el => [2, 4].includes(el.warehouse.type)).reduce(
                (accumulator, currentValue) => accumulator.product_count + currentValue.product_count,
                { product_count: 0 }
            )

            return count > 0 ? count : 0;
        },
        addToCart(product_id, qty) {
            let payload = {
                id: this.$store.state.activeCartId,
                locale: this.locale,
                product_id: product_id,
                qty: qty ? qty : this.qty,
            };

            this.$store.dispatch('addToCart', payload).then((data) => {
                this.$store.state.activeCart = {
                    id: data.cart.id,
                    total: data.cart.total,
                    currency: data.cart.currency,
                    products: data.cart.products,
                    urls: data.cart.urls ? data.cart.urls : this.$store.state.activeCart.urls,
                };
            });
        },
    },
}
</script>

<style lang="scss" scoped>
    .products-list {
        &.grid-view {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;

            @media screen {
                @media (max-width: 1199px) {
                    grid-template-columns: repeat(2, 1fr);
                }

                @media (max-width: 1120px) AND (min-width: 992px) {
                    grid-template-columns: repeat(3, 1fr);
                }

                @media (max-width: 640px) {
                    gap: 8px;
                }
            }

            .product-card {
                @media screen {
                    @media (max-width: 640px) {
                        display: flex;
                        flex-direction: column;
                        padding: 8px;

                        .details {
                            flex-grow: 1;
                        }
                    }

                }

                .image {
                    @media screen {
                        @media (max-width: 991px) {
                            height: 307px;
                        }

                        @media (max-width: 640px) {
                            height: 144px;
                            margin: 0 0 16px 0;
                        }
                    }
                }

                .details {
                    @media screen {
                        @media (max-width: 640px) {
                            display: flex;
                            flex-direction: column;
                            flex-grow: 1;
                            justify-content: space-between;
                        }
                    }

                    .name {
                        @media screen {
                            @media (max-width: 575px) {
                                margin: 0 0 7px 0;
                                line-height: 16px;
                                font-size: 12px;
                            }
                        }
                    }

                    .product-code, .stock-ability, .delivery-time {
                        @media screen {
                            @media (max-width: 640px) {
                                display: none;
                            }
                        }
                    }

                    .price {
                        @media screen {
                            @media (max-width: 640px) {
                                display: flex;
                                align-items: flex-start;
                                flex-direction: column;
                                line-height: 16px;
                                font-size: 16px;

                                .old-price {
                                    order: 1;
                                    margin: 0 0 4px 0;
                                    line-height: 12px;
                                    font-size: 12px;
                                }

                                .new-price {
                                    display: flex;
                                    align-items: center;
                                    order: 2;
                                }
                            }
                        }

                        .discount {
                            width: 50px;
                            height: 24px;
                            font-size: 14px;

                            @media screen {
                                @media (min-width: 641px) {
                                    &.mobile {
                                        display: none;
                                    }
                                }

                                @media (max-width: 640px) {
                                    &.desktop {
                                        display: none;
                                    }

                                    &.mobile {
                                        width: 33px;
                                        height: 16px;
                                        margin: 0 0 0 8px;
                                        background-size: cover;
                                        line-height: 10px;
                                        font-size: 10px;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        &.list-view {
            .product-card {
                display: flex;
                gap: 0 12px;
                padding: 0;
                border: 1px solid #EBEBEF;

                @media screen {
                    @media (max-width: 1199px) {
                        flex-wrap: wrap;
                    }

                    @media (max-width: 768px) {
                        gap: 12px;
                    }
                }

                &:not(:last-child) {
                    margin-bottom: 24px;
                }

                .image-holder {
                    position: relative;
                    flex-shrink: 0;
                    width: 264px;
                    height: 240px;
                    padding-top: 24px;
                    padding-left: 24px;

                    @media screen {
                        @media (max-width: 767px) {
                            display: none;
                        }
                    }

                    .manufacturer {
                        top: 30px;
                        left: 24px;
                    }

                    .image {
                        height: 100%;
                        margin: 0;
                    }
                }

                .details {
                    flex-grow: 1;
                    padding-top: 24px;
                    padding-bottom: 24px;
                    margin: 0 20px 0 0;

                    @media screen {
                        @media (max-width: 1199px) {
                            margin: 0;
                        }

                        @media (max-width: 767px) {
                            padding: 16px;
                        }
                    }

                    .top-details {
                        display: flex;
                        align-items: center;

                        @media screen {
                            @media (min-width: 768px) {
                                .product-label {
                                    display: none;
                                }
                            }

                            @media (max-width: 767px) {
                                padding: 0 0 8px 0;

                                .product-label {
                                    position: static;
                                    display: inline-block;
                                    margin: 0 0 8px 0;

                                    .label {
                                        padding: 4px 6px;
                                        margin: 0;
                                        font-size: 8px;
                                        letter-spacing: 0.32px;
                                    }
                                }

                                > div {
                                    flex-grow: 1;
                                }

                                .product-code {
                                    margin: 0;
                                }
                            }

                            @media (max-width: 575px) {
                                .name {
                                    line-height: 18px;
                                    font-size: 14px;
                                }
                            }
                        }

                        .mobile-image {
                            flex-grow: 0;
                            flex-shrink: 0;
                            width: 96px;
                            height: 97px;

                            .image {
                                height: 100%;
                                width: 100%;
                            }

                            .product-label {
                                display: none;
                            }

                            @media screen {
                                @media (min-width: 768px) {
                                    display: none;
                                }
                            }
                        }
                    }

                    .name {
                        padding-right: 24px;
                        line-height: 24px;
                        font-size: 18px;
                    }

                    .product-code {
                        margin: 0 0 24px 0;
                    }

                    .features {
                        padding: 19px 0 0 0;
                        border-top: 1px solid #E9EAEC;

                        @media screen {
                            @media (max-width: 575px) {
                                padding: 11px 0 0 0;
                            }
                        }

                        li {
                            font-size: 14px;
                            color: #616571;

                            @media screen {
                                @media (max-width: 575px) {
                                    line-height: 21px;
                                    font-size: 12px;
                                }
                            }


                            &:not(:last-child) {
                                margin-bottom: 1px;
                            }

                            strong, b {
                                color: #0D2441;
                                font-weight: 400;
                            }
                        }

                    }
                }

                .add-to-cart {
                    flex-shrink: 0;
                    width: 288px;
                    padding: 24px;
                    background: #F4F5F7;
                    border-left: 1px solid #EBEBEF;
                    border-radius: 0px 12px 12px 0px;

                    @media screen {
                        @media (max-width: 1199px) {
                            width: 100%;
                            border-radius: 0 0 12px 12px;
                        }

                        @media (max-width: 767px) {
                            padding: 16px;
                        }
                    }

                    .toggle-options {
                        display: flex;
                        padding: 4px;
                        gap: 0 4px;
                        margin: 0 0 22px 0;
                        background: #EAECF0;
                        border: 1px solid #E8E8ED;
                        box-shadow: 0px 1px 4px 0px rgba(84, 96, 110, 0.15) inset;
                        border-radius: 8px;

                        @media screen {
                            @media (max-width: 575px) {
                                margin: 0 0 26px 0;
                            }
                        }

                        .option {
                            width: 50%;
                            padding: 6px 0;
                            border-top: 1.5px solid transparent;
                            cursor: pointer;
                            border-radius: 6px;
                            transition: all .3s ease-in-out;

                            span {
                                display: block;
                                color: #616571;
                                font-weight: 500;
                                text-align: center;
                                transition: all .3s ease-in-out;

                                &.span-label {
                                    margin: 0 0 2px 0;
                                    line-height: 14px;
                                    font-size: 14px;
                                }

                                &.value {
                                    line-height: 12px;
                                    font-size: 12px;
                                }
                            }

                            &.active, &:hover {
                                background: #FAFAFA;
                                border-color: #FFF;
                                box-shadow: 1px 2px 6px 0px rgba(102, 116, 133, 0.15);

                                span {
                                    &.span-label {
                                        color: #0D2441;
                                    }

                                    &.value {
                                        color: #1F8C31;
                                    }
                                }
                            }

                            &.active {
                                pointer-events: none;
                            }
                        }
                    }

                    .price-holder {
                        margin: 0 0 24px 0;

                        .final-price,
                        .price-without-vat {
                            display: block;
                        }

                        .final-price {
                            margin: 0 0 6px 0;
                            line-height: 22px;
                            font-size: 22px;
                            font-weight: 700;
                            color: #0D2441;

                            @media screen {
                                @media (max-width: 575px) {
                                    line-height: 20px;
                                    font-size: 20px;
                                }
                            }
                        }

                        .price-without-vat {
                            color: #49515A;
                            font-size: 14px;
                            line-height: 14px;

                            @media screen {
                                @media (max-width: 575px) {
                                    font-size: 12px;
                                    line-height: 12px;
                                }
                            }
                        }
                    }

                    .product-qty {
                        display: flex;
                        margin: 0 0 8px 0;
                        border: 1px solid #D1D1DB;
                        background: #FFF;
                        border-radius: 8px;

                        button {
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            flex-shrink: 0;
                            width: 48px;
                            height: 48px;
                            padding: 0;
                            border: 0;
                            cursor: pointer;
                            transition: all .3s ease-in-out;

                            &.plus {
                                border-radius: 0 8px 8px 0;
                            }

                            &.minus {
                                border-radius: 8px 0 0 8px;
                            }

                            &:hover {
                                background-color: #eeeef1;;
                            }
                        }

                        .qty-input {
                            flex-grow: 1;
                            max-width: calc(100% - 96px);
                            padding: 0;
                            border: 0;
                            font-size: 18px;
                            font-weight: 600;
                            color: #0D2441;
                            text-align: center;
                        }
                    }

                    .cart-btn {
                        width: 100%;
                        margin: 0 0 22px 0;
                        border-bottom: 2px solid #931211;

                        span {
                            display: flex;
                            align-items: center;
                            justify-content: center;

                            &::before {
                                content: '';
                                width: 25px;
                                height: 24px;
                                margin: 0 8px 0 0;
                                background: url('../../../../../../resources/front/images/add-to-cart-icon-white.svg') center center no-repeat;
                            }
                        }
                    }

                    .availability {
                        > span {
                            display: block;
                            margin: 0 0 12px 0;
                            color:#616571;
                            font-size: 12px;
                            font-weight: 500;
                            line-height: 14px;
                            letter-spacing: 1.2px;
                            text-transform: uppercase;

                            @media screen {
                                @media (max-width: 575px) {
                                    line-height: 10px;
                                    font-size: 10px;
                                    letter-spacing: 1px;
                                }
                            }
                        }

                        ul {
                            li {
                                line-height: 16px;
                                font-size: 14px;
                                color: #454851;

                                @media screen {
                                    @media (max-width: 575px) {
                                        line-height: 12px;
                                        font-size: 12px;
                                    }
                                }

                                &:not(:last-child) {
                                    margin-bottom: 6px;
                                }

                                strong {
                                    font-weight: 500;
                                    color: #0D2441;
                                }
                            }
                        }
                    }

                    & > .available {
                        position: relative;
                        left: 1.5rem;
                        margin-top: -.75rem;
                        margin-bottom: .75rem;
                        font-size: 14px;
                        font-weight: 400;
                        line-height: 14px;
                        color: #0D2441;

                        & > a {
                            font-size: 11px;
                            font-weight: 500;
                            line-height: 11px;
                            letter-spacing: 0.04em;
                            text-transform: uppercase;
                            color: #E72E2C;
                        }

                        &:before {
                            content: "";
                            position: absolute;
                            width: 18px;
                            height: 18px;
                            left: -1.5rem;
                            top: -1px;
                            background: url('../../../../../../resources/front/images/fi_6161944.svg') center center no-repeat;
                        }
                    }
                }

                .show-more {
                    display: flex;
                    align-items: center;
                    justify-content: flex-start;
                    margin: 14px 0 0 0;
                    padding: 0;
                    line-height: 14px;
                    font-size: 13px;
                    font-weight: 600;
                    color: #E72E2C;
                    letter-spacing: .5px;
                    text-transform: uppercase;
                    cursor: pointer;

                    @media screen {
                        @media (max-width: 575px) {
                            font-size: 10px;
                        }
                    }

                    &::after {
                        content: '';
                        width: 14px;
                        height: 14px;
                        margin: -2px 0 0 4px;
                        background: url('../../../../../../resources/front/images/read-more-arrow-2.svg') right center no-repeat;

                        @media screen {
                            @media (max-width: 575px) {
                                width: 10px;
                                height: 10px;
                                background-size: contain;
                            }
                        }

                    }
                }
            }
        }


    }
</style>
