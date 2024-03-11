<template>
    <div v-if="showPopup" class="warehouses-availability-popup">
        <div class="content">
            <div class="popup-header">
                <h4 class="heading">{{ translate('product', 'warehouseAvailability') }}</h4>
                <p>{{ translate('product', 'warehouseList') }}</p>

                <div @click="$emit('closePopup')" class="close"></div>
            </div>

            <div class="popup-content">
                <div class="list">
                    <div class="block" v-for="warehouse in warehousesList">
                        <div class="left-side">
                            <div class="warehouse-name">
                                <h5 style="font-size: 18px;">
                                    {{ warehouse.warehouse.translation.value }}
                                </h5>

                                <div class="amount">
                                    <strong>{{ warehouse.product_count }}</strong>
                                    {{ translate('product', 'count') }}
                                </div>
                            </div>

                            <div class="availability mobile-hidden">
                                <span>{{ translate('product', 'available') }}:</span>

                                <ul>
                                    <li><strong>Rīt, 24.11.</strong> (pasūtot līdz 18:00)</li>
                                </ul>
                            </div>
                        </div>

                        <div class="right-side">
                            <div class="price-holder">
                                <span class="final-price">€{{ warehouse.product_price }}</span>
                                <span>
                                        €{{ warehouse.product_price - (warehouse.product_price / 100 * 21).toFixed(2) }}
                                        ({{ translate('product', 'withoutVat') }})
                                    </span>
                            </div>

                            <div class="wrapper">
                                <div class="product-qty">
                                    <button type="button" class="minus" @click="warehouse.product_to_buy > 1 ? warehouse.product_to_buy -= 1 : {}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M14.1737 6.85742C14.5524 6.85742 14.8594 7.13724 14.8594 7.48242L14.8594 8.73242C14.8594 9.0776 14.5524 9.35742 14.1737 9.35742L1.8308 9.35742C1.45209 9.35742 1.14509 9.0776 1.14509 8.73242L1.14509 7.48242C1.14509 7.13724 1.45209 6.85742 1.8308 6.85742L14.1737 6.85742Z" fill="#9398A3"/>
                                        </svg>
                                    </button>

                                    <input type="number" v-model="warehouse.product_to_buy" class="qty-input">

                                    <button type="button" class="plus" @click="warehouse.product_to_buy < warehouse.product_count ? warehouse.product_to_buy += 1 : {}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M6.62891 1.82829C6.62891 1.44958 6.90873 1.14258 7.25391 1.14258H8.50391C8.84908 1.14258 9.12891 1.44958 9.12891 1.82829V14.1712C9.12891 14.5499 8.84908 14.8569 8.50391 14.8569H7.25391C6.90873 14.8569 6.62891 14.5499 6.62891 14.1712V1.82829Z" fill="#0D2441"/>
                                            <path d="M14.0526 6.75C14.4313 6.75 14.7383 7.02982 14.7383 7.375L14.7383 8.625C14.7383 8.97018 14.4313 9.25 14.0526 9.25L1.70971 9.25C1.331 9.25 1.024 8.97018 1.024 8.625L1.024 7.375C1.024 7.02982 1.331 6.75 1.70971 6.75L14.0526 6.75Z" fill="#0D2441"/>
                                        </svg>
                                    </button>
                                </div>

                                <button type="button" class="cart-btn btn btn-primary" @click="addToCart(pageId ? pageId : warehouse.product.id, warehouse.product_to_buy)">
                                    <span>{{ translate('product', 'addToCart') }}</span>
                                </button>

                                <div class="availability mobile-view">
                                    <span>{{ translate('product', 'available') }}:</span>

                                    <ul>
                                        <li><strong>Rīt, 24.11.</strong> (pasūtot līdz 18:00)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ProductWarehousePopup',

    props: [
        'showPopup',
        'warehouses',
        'locale',
        'languageId',
        'addToCart',
        'pageId',
    ],

    emits: [
        'closePopup',
    ],

    watch: {
        showPopup(newValue) {
            if (newValue === true) {
                document.getElementsByTagName('html')[0].style.overflow = "hidden";
            } else {
                document.getElementsByTagName('html')[0].style.overflow = "auto";
            }
        },
    },

    data() {
        return {
            warehousesList: [],
        }
    },

    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val];
        },
    },

    mounted() {
        this.warehousesList = this.warehouses.filter(el => [2, 4].includes(el.warehouse.type))
            .filter(el => el.product_count > 0)
            .map(el => {
                return {
                    ...el,
                    product_to_buy: 1,
                }
            });
    }
}
</script>

<style scoped lang="scss">
.warehouses-availability-popup {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(7, 20, 36, 0.7);
    z-index: 9999;
    overflow: auto;
    scrollbar-width: none;
    padding: 60px 0;

    @media screen {
        @media (max-height: 900px) {
            align-items: flex-start !important;
        }

        @media (max-width: 680px) {
            padding: 0;
        }
    }

    &::-webkit-scrollbar {
        width: 0;
        height: 0;
    }

    .content {
        min-width: 915px;
        background-color: #FFFFFF;
        border-radius: 12px;

        @media screen {
            @media (max-width: 991px) {
                width: calc(100% - 64px);
            }

            @media (max-width: 680px) {
                width: 100%;
                min-height: 100%;
                border-radius: 0;
            }
        }

        .popup-header {
            position: relative;
            padding: 32px;
            border-bottom: 1px solid #E9EAEC;
            border-radius: 12px 12px 0 0;

            @media screen {
                @media (max-width: 680px) {
                    padding: 16px;
                    background: url('../../../../../resources/front/images/warehouses-availability-popup-mobile-header-bg.png') center center no-repeat;
                    background-size: cover;
                    border-radius: 0;
                }
            }

            .heading {
                margin: 0 0 8px 0;
                font-size: 28px;
                line-height: 34px;
                letter-spacing: -0.56px;

                @media screen {
                    @media (max-width: 768px) {
                        font-size: 23px;
                        line-height: 29px;
                        letter-spacing: -0.46px;
                    }

                    @media (max-width: 680px) {
                        color: #fff;
                    }
                }
            }

            > p {
                margin: 0;
                padding: 0 80px 0 0;
                line-height: 14px;
                font-size: 14px;
                font-weight: 400;
                color: #616571;

                @media screen {
                    @media (max-width: 680px) {
                        line-height: 16px;
                        color: #D8DADE;
                    }
                }
            }

            .close {
                position: absolute;
                top: 16px;
                right: 16px;
                width: 32px;
                height: 32px;
                border: 0;
                background: #f1f2f4 url('../../../../../resources/front/images/popup-close-icon.svg') center center no-repeat;
                cursor: pointer;
                transition: all .3s ease-in-out;
                border-radius: 6px;

                &:hover {
                    background-color: rgb(220, 222, 225);
                }
            }
        }

        .popup-content {
            border-radius: 0 0 12px 12px;

            .list {
                .block {
                    display: flex;
                    gap: 0 24px;
                    width: 100%;
                    padding: 32px;

                    @media screen {
                        @media (max-width: 991px) {
                            justify-content: space-between;
                        }

                        @media (max-width: 575px) {
                            flex-direction: column;
                            padding: 24px 16px;
                        }
                    }


                    &:not(:last-child) {
                        border-bottom: 1px solid #E9EAEC;
                    }

                    .left-side {
                        flex-shrink: 0;
                        width: 312px;

                        @media screen {
                            @media (max-width: 991px) {
                                width: auto;
                            }

                            @media (max-width: 575px) {
                                width: 100%;
                            }
                        }

                        .warehouse-name {
                            display: flex;
                            align-items: center;
                            gap: 0 16px;
                            margin: 0 0 16px 0;
                            line-height: 24px;
                            font-size: 18px;
                            font-weight: 600;
                            color: #0D2441;

                            @media screen {
                                @media (max-width: 575px) {
                                    gap: 0 24px;
                                    margin: 0;
                                    font-size: 20px;
                                    line-height: 26px;
                                    letter-spacing: -0.4px;
                                }
                            }

                            .amount {
                                padding: 5px 8px;
                                background: #F3FCF4;
                                border: 1px solid #BEEDC5;
                                line-height: 14px;
                                color: #1F8C31;
                                font-weight: 400;
                                font-size: 14px;
                                border-radius: 20px;

                                @media screen {
                                    @media (max-width: 575px) {
                                        padding: 4px 8px;
                                        font-size: 12px;
                                    }
                                }

                                strong, b {
                                    font-weight: 600;
                                }
                            }
                        }

                        .availability {
                            > span {
                                margin: 0 0 8px 0;
                            }

                            &.mobile-hidden {
                                @media screen {
                                    @media (max-width: 575px) {
                                        display: none;
                                    }
                                }
                            }
                        }
                    }

                    .right-side {
                        display: flex;
                        flex-grow: 1;
                        align-items: flex-start;
                        width: auto;

                        @media screen {
                            @media (max-width: 991px) {
                                flex-grow: 0;
                                flex-direction: column;
                            }

                            @media (max-width: 575px) {
                                align-items: initial;
                                width: 100%;
                                margin: 20px 0 0 0;
                            }
                        }

                        .price-holder {
                            margin: 0 32px 0 0;
                            padding: 5px 0 0 0;
                            white-space: nowrap;

                            @media screen {
                                @media (max-width: 991px) {
                                    margin: 0 0 9px 0;
                                }
                            }

                            & > span {
                                &:last-of-type {
                                    display: block;
                                }
                            }

                            .final-price {
                                margin: 0 0 6px 0;
                                line-height: 24px;
                                font-size: 24px;
                                font-weight: 700;
                                color: #0D2441;

                                @media screen {
                                    @media (max-width: 575px) {
                                        line-height: 22px;
                                        font-size: 22px;
                                    }

                                    @media (max-width: 991px) {
                                        line-height: 18px;
                                        font-size: 18px;
                                    }
                                }
                            }
                        }

                        .product-qty {
                            flex-shrink: 0;
                            align-items: center;
                            width: 140px;
                            margin: 0 8px 0 0;

                            @media screen {
                                @media (max-width: 991px) {
                                    width: 180px;
                                }

                                @media (max-width: 575px) {
                                    flex-grow: 1;
                                    width: auto;
                                    max-width: calc(100% - 88px);
                                }
                            }
                        }

                        .cart-btn {
                            margin: 0;

                            span {
                                display: flex;
                                align-items: center;
                                justify-content: center;

                                &::before {
                                    content: "";
                                    width: 25px;
                                    height: 24px;
                                    margin: 0 8px 0 0;
                                    background: url("../../../../../resources/front/images/add-to-cart-icon-white-2.svg") center center no-repeat;
                                    position: relative;
                                }
                            }

                            @media screen {
                                @media (max-width: 991px) {
                                    width: 80px;
                                    font-size: 0;

                                    span {
                                        &::before {
                                            margin: 0;
                                        }
                                    }
                                }
                            }
                        }

                        .wrapper {
                            display: flex;
                            flex-grow: 1;
                        }

                        .availability {
                            &.mobile-view {
                                display: block;
                                margin: 16px 0 0 0;

                                @media screen {
                                    @media (min-width: 576px) {
                                        display: none;
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
        height: 100%;
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
</style>
