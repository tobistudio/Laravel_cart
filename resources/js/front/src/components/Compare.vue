<template>
    <div class="sticky-compare" @click="toggleCompareDetailed" v-if="activeProductComparing && activeProductComparing.id && activeProductComparing.products.length && !activeProductComparing.open && !comparePage">
        <div class="count">{{ activeProductComparing.products.length }}</div>
        
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.5 9.25L4.5 18.7488" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <path d="M9.5 3.25781L9.5 18.7536" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <path d="M21.75 21.75H2.25" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <path d="M14.5 9.25L14.5 18.7488" stroke="white" stroke-width="2" stroke-linecap="round"/>
            <path d="M19.5 3.25781L19.5 18.7536" stroke="white" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </div>

    <div class="sticky-compare-detailed" v-if="activeProductComparing && activeProductComparing.open && !comparePage">
        <div class="mobile-amount">2</div>

        <div class="mobile-view">
            <span>Produktu salīdzināšana</span>
        </div>

        <div class="lg-view">
            <div class="close-sticker" @click="toggleCompareDetailed">X</div>
            
            <div class="products">
                <div class="product" v-for="product in activeProductComparing.products">
                    <div class="remove" @click="removeProductFromProductCompare(product.id)"></div>
                    <a :href="product.slug" :title="product.name">
                        <img :src="product.image" :alt="product.name">
                    </a>
                </div>
                <div class="product empty" v-if="activeProductComparing.products.length < 2">
                    Empty product image here
                </div>
                <div class="product empty" v-if="activeProductComparing.products.length < 3">
                    Empty product image here
                </div>
            </div>
    
            <div class="actions">
                <a :href="comparisonUrl" class="btn btn-primary btn-compare">Salīdzināt preces</a>
                <button @click="deleteProductCompare" class="btn btn-primary btn-clear">Notīrīt</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Compare',
    props: ['locale'],
    data() {
        return {
            compare: null,

            compareDetailed: false,
            comparisonUrl: null,
        }
    },
    computed: {
        trans() {
            return {

            }
        },
        comparePage() {
          return this.$store.state.comparePage;
        },
        activeProductComparing() {
            if(!this.comparisonUrl && this.$store.state.activeProductComparing && this.$store.state.activeProductComparing.urls && this.$store.state.activeProductComparing.urls.comparison_url){
                this.comparisonUrl = this.$store.state.activeProductComparing.urls.comparison_url;
            }

            return this.$store.state.activeProductComparing;
        }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        toggleCompareDetailed() {
            this.activeProductComparing.open = !this.activeProductComparing.open;
        },
        removeProductFromProductCompare(product_id) {
            let payload = {
                id: this.activeProductComparing.id,
                locale: this.locale,
                product_id: product_id,
            };

            this.$store.dispatch('removeProductFromProductCompare', payload)
                .then((data) => {
                    this.$store.state.activeProductComparing = {
                        id: data.comparing.id,
                        open: true,
                        products: data.comparing.products,
                        urls: data.comparing.urls
                    }

                    if(this.activeProductComparing && this.activeProductComparing.id){
                        if(this.activeProductComparing.products){
                            let findProductIndex = this.activeProductComparing.products.findIndex(product => product.id === product_id);
                            this.$store.state.activeProductComparing.active_product = findProductIndex >= 0;
                        } else {
                            this.$store.state.activeProductComparing.active_product = false;
                        }
                    } else {
                        this.$store.state.activeProductComparing.active_product = false;
                    }

                    if(!this.activeProductComparing || !this.activeProductComparing.id || !this.activeProductComparing.products || this.activeProductComparing.products.length === 0){
                        this.$store.state.activeProductComparing.open = false;
                    }
                });
        },
        deleteProductCompare() {
            let payload = {
                id: this.activeProductComparing.id,
            };

            this.$store.dispatch('deleteProductCompare', payload)
                .then((data) => {
                    this.$store.state.activeProductComparing = {
                        id: data.comparing.id,
                        open: false,
                        products: data.comparing.products,
                        urls: data.comparing.urls
                    }
                });
        }
    },
    mounted() {
        if(this.$store.state.activeProductComparing && this.$store.state.activeProductComparing.urls && this.$store.state.activeProductComparing.urls.comparison_url){
            this.comparisonUrl = this.$store.state.activeProductComparing.urls.comparison_url;
        }
    }
}
</script>

<style lang="scss" scoped>
@function rem($size) {
    @return calc($size / 16) * 1rem;
}

.sticky-compare {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 50%;
    right: 16px;
    padding: 16px;
    background: #0D2441;
    transform: translateY(-50%);
    cursor: pointer;
    border-radius: 12px;
    z-index: 100;

    .count {
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        width: 24px;
        height: 24px;
        top: -8px;
        right: -8px;
        background-color: #E72E2C;
        border: 2px solid #FAFAFA;
        color: #fff;
        font-weight: 600;
        font-size: 14px;
        border-radius: 50%;
    }
}

.sticky-compare-detailed {
    position: fixed;
    padding: 24px;
    left: 50%;
    bottom: 32px;
    background: #0D2441;
    transform: translateX(-50%);
    border-radius: 12px;
    z-index: 100;

    .mobile-amount {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        background-color: #E72E2C;
        border: 2px solid #FAFAFA;
        line-height: 12px;
        font-weight: 600;
        font-size: 14px;
        color: #FAFAFA;
        border-radius: 50%;

        @media screen {
            @media (min-width: 701px) {
                display: none;
            }
        }
    }

    @media screen {
        @media (max-width: 700px) {
            bottom: 16px;
            padding: 14px 16px;
            font-weight: 500;
            color: #fff;
        }
    }

    .lg-view {
        display: none;

        @media screen {
            @media (min-width: 701px) {
                display: flex;
                align-items: center;
            }
        }
    }

    .mobile-view {
        display: block;

        span {
            display: flex;
            align-items: center;
            gap: 0 8px;
            white-space: nowrap;

            &::before {
                content: '';
                width: 20px;
                height: 20px;
                background: url('../../../../front/images/sticker-compare-icon.svg') center center no-repeat;
            }  
        }

        @media screen {
            @media (min-width: 701px) {
                display: none;
            }
        }
    }

    .close-sticker {
        cursor: pointer;
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        border: 0;
        background: #E72E2C url('../../../../../resources/front/images/remove-compare-product-popup.svg') center center no-repeat;
        background-size: 9px;
        font-size: 0;
        transition: all 0.3s ease-in-out;
        border-radius: 4px;

        &:hover {
            background-color: #d62421;
        }
    }

    .products {
        display: flex;
        gap: 0 16px;
        margin: 0 48px 0 0;

        @media screen {
            @media (max-width: 768px) {
                margin: 0 32px 0 0;
            }
        }

        .product {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            flex-shrink: 0;
            width: 64px;
            height: 64px;
            background-color: #fff;
            border-radius: 8px;

            a, img {
                max-width: 100%;
                max-height: 100%;
            }

            .remove {
                position: absolute;
                right: -6px;
                top: -6px;
                flex-shrink: 0;
                width: 16px;
                height: 16px;
                color: #fff;
                background: #E72E2C url('../../../../../resources/front/images/remove-compare-product-popup.svg') center center no-repeat;
                cursor: pointer;
                transition: all 0.3s ease-in-out;
                border-radius: 4px;

                &:hover {
                    background-color: #d62421;
                }
            }

            img {
                width: 100px;
            }

            &.empty {
                background: #fff url('../../../../../resources/front/images/product-not-added.svg') center center no-repeat;
                font-size: 0;
            }
        }
    }

    button {
        cursor: pointer;
    }

    .actions {
        display: flex;
        gap: 0 8px;

        .btn {
            white-space: nowrap;

            &.btn-compare {
                border-bottom: 2px solid #931111;
            }   
            
            &.btn-clear {
                border: 2px solid #fff;
                background: transparent;
                color: #fff;

                &:hover {
                    background-color: #fff;
                    color: #0D2441;
                }
            }
        }
    }
}
</style>
