<template>
    <div class="substitute">
        <div class="product">
            <img :src="data.product.language_page.featured_image" alt="product" />

            <div class="text">
                <div>
                    <a class="title" :href="data.product.language_page.slug">
                        {{ data.product.language_page.name }}
                    </a>

                    <div class="code">
                        {{ translate('product', 'productCode') }}
                        :
                        {{ data.product.data.sku }}
                    </div>

                    <div class="price">
                        <template v-if="data.product.data.special_price">
                            <div class="title">
                                <div>
                                    €{{ data.product.data.special_price }}

                                    <div class="old">
                                        €{{ data.product.data.price }}
                                    </div>
                                </div>

                                <div class="discount">
                                    <svg width="40" height="20" viewBox="0 0 40 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.11562 2.47059C3.73441 0.975187 5.19331 0 6.81168 0H36C38.2091 0 40 1.79086 40 4V16C40 18.2091 38.2091 20 36 20H6.81168C5.19331 20 3.7344 19.0248 3.11562 17.5294L0.474643 11.1471C0.170711 10.4126 0.170711 9.58745 0.474644 8.85294L3.11562 2.47059Z" fill="#CD2C2C"/>
                                    </svg>
                                    <span>{{ `-${parseInt((100 - (data.product.data.special_price / data.product.data.price) * 100), 0)}%` }}</span>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <div class="title">
                                €{{ data.product.data.price }}
                            </div>
                        </template>
                    </div>
                </div>

                <div>
                    <div class="available">
                        {{ translate('product', 'available') }}
                        :
                    </div>

                    <div class="dates">
                        <div class="date">
                            <span>Šodien, 23.11.</span> (pasūtot līdz 14:00)
                        </div>

                        <div class="date">
                            <span>Šodien, 24.11.</span> (pasūtot līdz 18:00)
                        </div>
                    </div>
                </div>
            </div>

            <div class="cart">
                <div class="buttons">
                    <div :class="`button ${selectedStorage === 0 ? 'active' : ''}`" @click="selectedStorage = 0">
                        <div>{{ translate('product', marketCount > 0 ? 'inStore' : 'notInStore') }}</div>
                        <div :style="`${marketCount > 0 ? 'color: #1F8C31;' : 'color: #E72E2C;'}`">
                            {{ marketCount }}
                            {{ translate('product', 'count') }}
                        </div>
                    </div>

                    <div :class="`button ${selectedStorage === 1 ? 'active' : ''}`" @click="data.product.warehouses.filter(el => el.warehouse.type === 4).filter(el => el.product_count > 0).length > 0 ? selectedStorage = 1 : {}">
                        <div>{{ translate('product', storageCount > 0 ? 'inStorage' : 'notInStorage') }}</div>
                        <div :style="`${storageCount > 0 ? 'color: #1F8C31;' : 'color: #E72E2C;'}`">
                            {{ storageCount > 0
                            ? `€${data.product.warehouses.filter(el => [2, 4].includes(el.warehouse.type))[0].product_price}`
                            : '-' }}
                        </div>
                    </div>
                </div>

                <div class="available" v-if="selectedStorage === 1 && data.product.warehouses.filter(el => el.warehouse.type === 4).filter(el => el.product_count > 0).length > 0">
                    {{ translate('product', 'availableIn') }}
                    {{ data.product.warehouses.filter(el => el.warehouse.type === 4).filter(el => el.product_count > 0).length }}
                    {{ translate('product', 'storages') }}
                    <a href="#" @click="(e) => { e.preventDefault(); warehousesPopup = true; }">{{ translate('product', 'watch') }}</a>
                </div>

                <div class="price">
                    <template v-if="data.product.data.special_price">
                        <div class="title">
                            €{{ data.product.data.special_price }}

                            <div class="old">
                                €{{ data.product.data.price }}
                            </div>

                            <div class="discount">
                                <svg width="40" height="20" viewBox="0 0 40 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.11562 2.47059C3.73441 0.975187 5.19331 0 6.81168 0H36C38.2091 0 40 1.79086 40 4V16C40 18.2091 38.2091 20 36 20H6.81168C5.19331 20 3.7344 19.0248 3.11562 17.5294L0.474643 11.1471C0.170711 10.4126 0.170711 9.58745 0.474644 8.85294L3.11562 2.47059Z" fill="#CD2C2C"/>
                                </svg>
                                <span>{{ `-${Math.floor(100 - (data.product.data.special_price / data.product.data.price) * 100)}%` }}</span>
                            </div>
                        </div>

                        <div class="subtitle">
                            €{{ data.product.data.price - (data.product.data.price / 100 * 21).toFixed(2) }}
                            ({{ translate('product', 'withoutVat') }})
                        </div>
                    </template>
                    <template v-else>
                        <div class="title">
                            €{{ data.product.data.price }}
                        </div>

                        <div class="subtitle">
                            €{{ data.product.data.price - (data.product.data.price / 100 * 21).toFixed(2) }}
                            ({{ translate('product', 'withoutVat') }})
                        </div>
                    </template>
                </div>

                <div class="buy">
                    <div class="product-qty">
                        <button type="button" class="minus" @click="productsToBuy > 1 ? productsToBuy -= 1 : {}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M14.1737 6.85742C14.5524 6.85742 14.8594 7.13724 14.8594 7.48242L14.8594 8.73242C14.8594 9.0776 14.5524 9.35742 14.1737 9.35742L1.8308 9.35742C1.45209 9.35742 1.14509 9.0776 1.14509 8.73242L1.14509 7.48242C1.14509 7.13724 1.45209 6.85742 1.8308 6.85742L14.1737 6.85742Z" fill="#9398A3"/>
                            </svg>
                        </button>

                        <input type="number" v-model="productsToBuy" class="qty-input">

                        <button type="button" class="plus" @click="productsToBuy < marketCount ? productsToBuy += 1 : {}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M6.62891 1.82829C6.62891 1.44958 6.90873 1.14258 7.25391 1.14258H8.50391C8.84908 1.14258 9.12891 1.44958 9.12891 1.82829V14.1712C9.12891 14.5499 8.84908 14.8569 8.50391 14.8569H7.25391C6.90873 14.8569 6.62891 14.5499 6.62891 14.1712V1.82829Z" fill="#0D2441"/>
                                <path d="M14.0526 6.75C14.4313 6.75 14.7383 7.02982 14.7383 7.375L14.7383 8.625C14.7383 8.97018 14.4313 9.25 14.0526 9.25L1.70971 9.25C1.331 9.25 1.024 8.97018 1.024 8.625L1.024 7.375C1.024 7.02982 1.331 6.75 1.70971 6.75L14.0526 6.75Z" fill="#0D2441"/>
                            </svg>
                        </button>
                    </div>

                    <button>
                        <svg @click="addToCart(data.product.page_id, productsToBuy)" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.6442 20C12.4799 20 11.2888 19.912 10.9775 18.6667C10.3109 16 8.62466 9.33333 8.62466 9.33333H27.6739C27.9981 9.33333 28.2367 9.63465 28.1575 9.94905C27.7536 11.5526 26.6245 15.9235 25.6442 18.6667C25.1109 20 24.1419 20 22.9775 20H13.6442Z" fill="white"/>
                            <path d="M4 5.33333H7.05262C7.27342 5.33333 7.46808 5.47816 7.53153 5.68965L8.62466 9.33333M8.62466 9.33333C8.62466 9.33333 10.3109 16 10.9775 18.6667C11.2888 19.912 12.4799 20 13.6442 20C15.5094 20 20.9775 20 22.9775 20C24.1419 20 25.1109 20 25.6442 18.6667C26.6245 15.9235 27.7536 11.5526 28.1575 9.94905C28.2367 9.63465 27.9981 9.33333 27.6739 9.33333H8.62466Z" stroke="#FAFAFA" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M15.5599 24.4435C15.5599 25.502 14.7018 26.3602 13.6432 26.3602C12.5847 26.3602 11.7266 25.502 11.7266 24.4435C11.7266 23.3849 12.5847 22.5268 13.6432 22.5268C14.7018 22.5268 15.5599 23.3849 15.5599 24.4435Z" fill="white" stroke="#FAFAFA" stroke-width="1.5"/>
                            <circle cx="22.9792" cy="24.4435" r="1.91667" fill="white" stroke="#FAFAFA" stroke-width="1.5"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <ProductWarehousePopup
            :showPopup="warehousesPopup"
            :locale="locale"
            :warehouses="data.product.warehouses"
            :languageId="languageId"
            :addToCart="addToCart"
            :pageId="data.product.language_page.page_id"
            @closePopup="warehousesPopup = false"
        />
    </div>
</template>

<script>
import ProductWarehousePopup from '@/js/front/src/components/ProductWarehousePopup.vue';


export default {
    name: 'ProductSubstitutes',
    components: {
        ProductWarehousePopup
    },

    props: [
        'data',
        'locale',
        'languageId',
        'addToCart',
    ],

    data() {
        return {
            selectedStorage: 0,
            productsToBuy: 1,
            warehousesPopup: false,
        }
    },

    computed: {
        marketCount() {
            const count = this.data.product.warehouses.filter(el => el.warehouse.type === 1).reduce(
                (accumulator, currentValue) => accumulator.product_count + currentValue.product_count,
                { product_count: 0 });

            return count > 0 ? count : 0;
        },
        storageCount() {
            const count = this.data.product.warehouses.filter(el => [2, 4].includes(el.warehouse.type)).reduce(
                (accumulator, currentValue) => accumulator.product_count + currentValue.product_count,
                { product_count: 0 }
            )

            return count > 0 ? count : 0;
        }
    },

    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
    },
}
</script>

<style scoped lang="scss">
.substitute {
    margin-bottom: 1rem;
    font-family: Inter;

    & > .product {
        display: flex;
        justify-content: space-between;
        background: #fff;
        border-radius: 12px;
        border: 1px solid #EBEBEF;

        & > img {
            width: 172px;
            height: 172px;
            margin-left: 1.4rem;
            margin-top: 1.4rem;
        }

        & > .text {
            margin-left: 1rem;
            margin-top: 1.4rem;

            & > div {
                &:first-of-type {
                    padding-bottom: 1.25rem;
                    margin-bottom: 1.25rem;
                    border-bottom: 1px solid #E9EAEC;

                    & > .title {
                        font-size: 16px;
                        font-weight: 600;
                        line-height: 22px;
                        color: #0D2441;
                        margin-bottom: .5rem;
                    }

                    & > .code {
                        font-size: 14px;
                        font-weight: 400;
                        line-height: 14px;
                        color: #616571;
                    }

                    & > .price {
                        display: none;
                    }
                }

                &:last-of-type {
                    & > .available {
                        font-size: 12px;
                        font-weight: 500;
                        line-height: 14px;
                        letter-spacing: 0.1em;
                        text-transform: uppercase;
                        margin-bottom: .5rem;
                        color: #616571;
                    }

                    & > .dates {
                        & > .date {
                            font-size: 14px;
                            font-weight: 400;
                            color: #585D68;

                            & > span {
                                font-weight: 500;
                                color: #0D2441;
                            }
                        }
                    }
                }
            }
        }

        & > .cart {
            height: 100%;
            width: 288px;
            border-left: 1px solid #EBEBEF;
            background: #F4F5F7;
            margin-left: 1rem;
            padding: 1.25rem;

            @media screen {
                @media (max-width: 575px) {
                    display: none;
                }
            }

            & > .buttons {
                display: flex;
                justify-content: space-between;
                padding: .3rem;
                border-radius: 6px;
                background: #EBEBEF;

                & > .button {
                    display: flex;
                    align-items: center;
                    flex-direction: column;
                    min-height: 42px;
                    width: 100%;
                    color: #616571;
                    transition: all .3s;
                    padding: 6px 12px 6px 12px;
                    cursor: pointer;

                    & > div {
                        text-align: center;
                        line-height: 14px;

                        &:last-of-type {
                            font-size: 12px;
                            font-weight: 500;
                            line-height: 12px;
                            margin-top: .3rem;
                        }
                    }

                    &.active {
                        color: #0D2441;
                        background: #FAFAFA;
                        border-radius: 6px;
                        box-shadow: 0 1px 4px 0 #54606E26;

                        & > div {
                            &:first-of-type {
                                font-size: 14px;
                                font-weight: 500;
                            }
                        }
                    }
                }
            }

            & > .available {
                position: relative;
                left: 1.5rem;
                margin-top: .75rem;
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
                    background: url('../../../../../resources/front/images/fi_6161944.svg') center center no-repeat;
                }
            }

            & > .price {
                margin-top: .75rem;

                & > .title {
                    display: flex;
                    align-items: center;
                    font-size: 20px;
                    font-weight: 700;
                    line-height: 20px;
                    color: #0D2441;

                    & > .old {
                        font-size: 14px;
                        font-weight: 400;
                        line-height: 14px;
                        text-decoration:line-through;
                        color: #616571;
                        margin-left: .25rem;
                    }

                    & > .discount {
                        position: relative;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin-left: .75rem;

                        & > span {
                            position: absolute;
                            left: 1px;
                            top: 3px;
                            width: 40px;
                            height: 20px;
                            font-size: 12px;
                            font-weight: 600;
                            line-height: 12px;
                            text-align: center;
                            color: #FAFAFA;
                            text-transform: uppercase;
                        }
                    }
                }

                & > .subtitle {
                    font-size: 12px;
                    font-weight: 400;
                    line-height: 12px;
                    color: #49515A;
                    margin-top: .5rem;
                }
            }

            & > .buy {
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                margin-top: 1rem;

                & > button {
                    border-radius: 8px;
                    background: #E72E2C;
                    border-bottom: 2px solid #931211;
                    height: 48px;
                    padding: .25rem 1rem 0;
                    margin-left: .5rem;
                    cursor: pointer;
                    transition: all .3s;

                    &:hover {
                        background-color: #0D2441;
                        border-color: #0D2441;
                    }
                }
            }
        }
    }

    .product-qty {
        display: flex;
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
            width: 100%;
            max-width: calc(100% - 96px);
            padding: 0;
            border: 0;
            font-size: 18px;
            font-weight: 600;
            color: #0D2441;
            text-align: center;
        }
    }

    @media screen {
        @media only screen and (max-width: 960px) {
            & > .product {
                & > .cart {
                    min-width: 288px;
                }
            }
        }

        @media only screen and (max-width: 575px) {
            max-width: 50%;

            & > .product {
                flex-direction: column;
                margin-right: .5rem;
                justify-content: center;
                align-items: center;
                padding: .5rem;

                & > img {
                    width: auto;
                    height: auto;
                    min-width: 144px;
                    min-height: 144px;
                    object-fit: cover;
                    margin-left: 0;
                    margin-top: 0;
                }

                & > .text {
                    margin-left: 0;
                    margin-top: 0;

                    & > div {
                        &:first-of-type {
                            padding-bottom: 0;
                            margin-bottom: 0;
                            border-bottom: none;

                            & > .title {
                                font-size: 12px;
                                font-weight: 500;
                                line-height: 16px;
                                margin-top: .5rem;
                                margin-bottom: 0;
                            }

                            & > .code {
                                display: none;
                            }

                            & > .price {
                                display: flex;
                                flex-direction: column;
                                margin-top: .75rem;

                                & > .title {
                                    display: flex;
                                    align-items: center;
                                    font-size: 20px;
                                    font-weight: 700;
                                    line-height: 20px;
                                    color: #0D2441;

                                    & > div {
                                        &:first-of-type {
                                            & > .old {
                                                font-size: 14px;
                                                font-weight: 400;
                                                line-height: 14px;
                                                text-decoration:line-through;
                                                color: #616571;
                                                margin-left: .25rem;
                                            }
                                        }
                                    }

                                    & > .discount {
                                        position: relative;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        margin-left: .75rem;

                                        & > span {
                                            position: absolute;
                                            left: 1px;
                                            top: 3px;
                                            width: 40px;
                                            height: 20px;
                                            font-size: 12px;
                                            font-weight: 600;
                                            line-height: 12px;
                                            text-align: center;
                                            color: #FAFAFA;
                                            text-transform: uppercase;
                                        }
                                    }
                                }
                            }
                        }

                        &:last-of-type {
                            display: none;
                        }
                    }
                }
            }
        }
    }
}
</style>
