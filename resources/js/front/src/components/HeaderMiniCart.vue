<template>
    <li class="user-cart">
        <div class="mini-cart" @click="openMiniCartPopup">
            <div class="icon">
                <img src="/images/front/header-cart-icon.svg" alt="Grozs">
                <span class="total-badge">{{ cart ? cart.products.length : 0  }}</span>
            </div>

            <div class="details">
                <span>{{ trans.title }}</span>
                <span class="total-price">{{ cart ? cart.currency + cart.total : '€0.00' }}</span>
            </div>
        </div>

        <div class="backdrop" v-if="miniCart" @click="closeMiniCartPopup"></div>

        <div class="mini-cart-dropdown mini-cart-empty" v-if="miniCart && (cart || cart.products.length === 0)">
            <div class="block-header">
                <h4 class="dropdown-name">Grozs <span class="amount">0</span></h4>
            </div>

            <div class="block-content empty">
                <div>
                    <h5 class="block-heading">Tavs grozs šobrīd ir tukšs.</h5>
                    <p>Sāc ar “Preču katalogu”, lai atrastu nepieciešamās preces.</p>
                </div>

                <div class="actions">
                    <button type="button" class="btn btn-primary" @click="closeMiniCartPopup">Turpināt iepirkties</button>
                </div>
            </div>
        </div>

        <div class="mini-cart-dropdown mini-cart-with-items" v-if="miniCart && cart && cart.products.length > 0">
            <div class="mini-cart-wrapper">
                <div class="block-header">
                    <h4 class="dropdown-name">Grozs <span class="amount">{{ cart.products.length }}</span></h4>
                </div>

                <div class="block-content">
                    <div class="form">
                        <div class="minicart-items">
                            <div class="item" v-for="product in cart.products">
                                <div class="image">
                                    <a :href="product.slug">
                                        <img :src="product.image" :alt="product.name">
                                    </a>
                                </div>

                                <div class="details">
                                    <h5 class="name">
                                        <a :href="product.slug">{{ product.name }}</a>
                                    </h5>

                                    <div class="price-holder">
                                        <span class="price">{{ cart.currency + product.price }}</span>
                                    </div>

                                    <div class="bottom-block">
                                        <div class="qty-holder">
                                            <button :class="['minus', product.qty <= 1 ? 'disabled' : '']" @click="updateQty(product, 'minus')"></button>
                                            <input type="number" v-model="product.qty" class="item-qty" @input="updateQty(product, null)">
                                            <button class="plus" @click="updateQty(product, 'plus')"></button>
                                        </div>

                                        <button type="button" class="remove-item" @click="removeFromCart(product)">Dzēst</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="summary">
                            <div class="subtotal">
                                <span class="label">Kopā</span>
                                <span class="price">{{ cart.currency + cart.total }}</span>
                            </div>

                            <div class="actions">
                                <a :href="cart.urls.cart_url" type="button" class="cart-btn btn btn-primary" >Uz grozu</a>
                                <a :href="cart.urls.checkout_url" type="button" class="btn btn-primary">Noformēt pasūtījumu</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
export default {
    name: 'HeaderMiniCars',
    props: ['locale'],
    data() {
        return {
            viewLoaded: false,

            auth: false,
            miniCart: false,
            miniCartUrls: null,
        }
    },
    computed: {
        trans() {
            return {
                title: this.translate('cart', 'title'),
            }
        },
        cart() {
            return this.$store.state.activeCart;
        }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        openMiniCartPopup() {
            this.miniCart = true;

            document.getElementsByTagName('html')[0].style.overflow = "hidden";
        },
        getCart() {
            let payload = {
                id: this.$store.state.activeCartId,
                locale: this.locale
            }

            this.$store.dispatch('getCart', payload).then((data) => {
                this.$store.state.activeCart = {
                    id: data.cart.id,
                    total: data.cart.total,
                    currency: data.cart.currency,
                    products: data.cart.products,
                    urls: data.cart.urls,
                };
                this.miniCartUrls = this.$store.state.activeCart.urls;
                this.viewLoaded = true;
            })
        },
        updateQty(product, type) {
            if(type === 'plus'){
                product.qty += 1;
            } else if(type === 'minus'){
                if(product.qty >= 2) {
                    product.qty -= 1;
                }
            } else {
                if(product.qty <= 0){
                    product.qty = 1;
                }
            }

            let payload = {
                id: this.cart.id,
                locale: this.locale,
                product_id: product.id,
                qty: product.qty,
            };

            this.$store.dispatch('updateCartProductQuantity', payload).then((data) => {
                this.$store.state.activeCart = {
                    id: data.cart.id,
                    total: data.cart.total,
                    currency: data.cart.currency,
                    products: data.cart.products,
                    urls: this.miniCartUrls
                };
            });
        },
        removeFromCart(product) {
            let payload = {
                id: this.cart.id,
                locale: this.locale,
                product_id: product.id,
            };

            this.$store.dispatch('removeFromCart', payload).then((data) => {
                this.$store.state.activeCart = {
                    id: data.cart.id,
                    total: data.cart.total,
                    currency: data.cart.currency,
                    products: data.cart.products,
                    urls: this.miniCartUrls
                };
            });
        },
        closeMiniCartPopup() {
            this.miniCart = false;

            document.getElementsByTagName('html')[0].style.overflow = "auto";
        },
    },
    mounted() {
        this.getCart();
    }
}
</script>

<style lang="scss" scoped>
@function rem($size) {
    @return calc($size / 16) * 1rem;
}

.user-cart {
    position: relative;

    .mini-cart {
        display: flex;
        align-items: center;
        cursor: pointer;

        .icon {
            position: relative;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            height: 40px;
            margin: 0 24px 0 0;

            .total-badge {
                display: flex;
                align-items: center;
                justify-content: center;
                position: absolute;
                top: -2px;
                right: -18px;
                height: 20px;
                min-width: 30px;
                padding: 0;
                line-height: 12px;
                background: #E72E2C;
                border: 1.5px solid #FAFAFA;
                color: #FAFAFA;
                font-family: Geologica;
                font-size: rem(12);
                font-weight: 500;
                border-radius: 20px;
            }

            @media screen {
                @media (max-width: 575px) {
                    margin: 0 16px 0 0;
                }
            }
        }

        .details {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            line-height: normal;
            font-size: rem(12);
            text-transform: uppercase;

            span {
                @media screen {
                    @media (max-width: 575px) {
                        &:not(.total-price) {
                            font-size: rem(8);
                        }
                    }
                }
            }

            .total-price {
                margin: 3px 0 0 0;
                line-height: 13px;
                font-weight: 600;
                font-size: rem(16);
                color: #0D2441;

                @media screen {
                    @media (max-width: 575px) {
                        margin: 1px 0 0 0;
                        font-size: rem(14);
                    }
                }
            }
        }
    }

    .backdrop {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 1;
        visibility: visible;
        transition: all .3s ease-in-out;
        background: rgba(0, 0, 0, 0.70);
        z-index: 100;
    }

    .mini-cart-dropdown {
        position: absolute;
        top: calc(100% + 25px);
        right: 0;
        width: 358px;
        max-width: 85vw;
        background-color: #fafafa;
        opacity: 1;
        visibility: visible;
        transition: all .3s ease-in-out;
        border-radius: 8px;
        z-index: 999;

        &::before {
            content: '';
            position: absolute;
            top: -7px;
            right: 37px;
            width: 0px;
            height: 0px;
            border-style: solid;
            border-width: 0 10px 7px 10px;
            border-color: transparent transparent #fafafa transparent;
            transform: rotate(0deg);
        }

        .block-header {
            margin: 0 0 24px 0;
            padding: 12px 16px 7px 16px;
            border-bottom: 1px solid #E9EAEC;

            .dropdown-name {
                display: flex;
                align-items: center;
                font-weight: 600;
                color: #0D2441;

                .amount {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 24px;
                    height: 16px;
                    margin: 0 0 0 4px;
                    background-color: #0D2441;
                    line-height: 12px;
                    font-size: 12px;
                    font-weight: 500;
                    color: #FAFAFA;
                    border-radius: 20px;
                }
            }
        }

        .minicart-items {
            padding: 0 16px 48px 16px;

            .item {
                display: flex;
                gap: 0 8px;

                &:not(:last-child) {
                    margin: 0 0 24px 0;
                }

                .image {
                    display: flex;
                    align-items: flex-start;
                    width: 56px;
                    flex-shrink: 0;

                    a {
                        display: flex;
                        align-items: center;
                        width: 100%;
                        height: 44px;
                        padding: 6px;
                        background-color: #fff;
                        border-radius: 8px;
                    }
                }

                .details {
                    flex-grow: 1;
                    max-width: calc(100% - 64px);

                    .name {
                        margin: 0 0 8px 0;
                        line-height: 18px;
                        font-size: 14px;
                        font-weight: 400;
                        color: #0D2441;
                        word-break: break-all;

                        a {
                            display: inline-block;
                            color: #0D2441;
                        }
                    }

                    .price-holder {
                        margin: 0 0 16px 0;
                        line-height: 14px;
                        font-size: 14px;
                        font-weight: 600;
                        color: #0D2441;

                        .price {

                        }
                    }

                    .bottom-block {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;

                        .qty-holder {
                            display: flex;
                            gap: 0 4px;
                            width: 144px;

                            button {
                                width: 36px;
                                height: 36px;
                                padding: 0;
                                border: 0;
                                cursor: pointer;
                                transition: all .3s ease-in-out;
                                border-radius: 8px;

                                &.minus {
                                    background: #E9EAEC url("../../../../front/images/button-minus-icon.svg") center center no-repeat;

                                    &.disabled {
                                        background: #E9EAEC url("../../../../front/images/button-minus-icon-disabled.svg") center center no-repeat;
                                    }
                                }

                                &.plus {
                                    background: #E9EAEC url("../../../../front/images/button-plus-icon.svg") center center no-repeat;

                                    &.disabled {
                                        background: #E9EAEC url("../../../../front/images/button-plus-icon-disabled.svg") center center no-repeat;
                                    }
                                }

                                &:hover {
                                    background-color: #d4d5d6;
                                }

                                &:active {
                                    background-color: #c9cacb;
                                }
                            }

                            .item-qty {
                                width: 64px;
                                height: 36px;
                                border: 1px solid #D1D1DB;
                                background: #fff;
                                color: #0D2441;
                                font-size: 16px;
                                font-weight: 600;
                                text-align: center;
                                border-radius: 8px;
                            }
                        }

                        .remove-item {
                            display: flex;
                            align-items: center;
                            color: #7D8391;
                            font-size: 14px;
                            cursor: pointer;

                            &::before {
                                content: '';
                                width: 12px;
                                height: 16px;
                                margin: 0 8px 0 0;
                                background: url("../../../../front/images/bin-icon.svg") right center no-repeat;
                            }

                            &:hover {
                                color: #E72E2C;

                                &::before {
                                    background: url("../../../../front/images/bin-icon-hover.svg") right center no-repeat;
                                }
                            }
                        }
                    }
                }
            }
        }

        .summary {
            padding: 14px 16px 16px 16px;
            border-top: 1px solid #E9EAEC;

            .subtotal {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin: 0 0 16px 0;
                font-weight: 700;
                font-size: 16px;
                color: #0D2441;

                .price {
                    line-height: 20px;
                    font-size: 20px;
                }


            }

            .actions {
                display: flex;
                flex-direction: column;

                a, button {
                    width: 100%;
                    text-align: center;
                }

                .cart-btn {
                    margin: 0 0 12px 0;
                    border: 0;
                    justify-content: center;
                    background: #EFF0F2;
                    color: #49515A;
                    text-align: center;

                    &:hover {
                        background: #dadbdc;
                    }
                }
            }
        }

        &.mini-cart-empty {

            .block-content {
                padding: 16px;
                text-align: center;

                .block-heading {
                    margin: 0 0 8px 0;
                    font-size: 18px;
                    font-weight: 600;
                    line-height: 24px;

                    &::before {
                        content: '';
                        display: block;
                        height: 60px;
                        width: 100%;
                        margin: 0 0 19px 0;
                        background: url("../../../../front/images/empty-cart-icon.svg") center top no-repeat;
                    }
                }

                p {
                    margin: 0;
                    line-height: 20px;
                    color: #7D8391;
                }

                .actions {
                    display: flex;
                    justify-content: center;
                    margin: 48px 0 0 0;

                    .btn {
                        width: 100%;
                    }
                }
            }

            .actions {
                .btn {
                    justify-content: center;
                }
            }
        }
    }
}
</style>
