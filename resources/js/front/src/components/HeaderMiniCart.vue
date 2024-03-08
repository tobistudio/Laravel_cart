<template>
    <li class="user-cart">
        <a href="#">
            <div class="icon">
                <img src="/images/front/header-cart-icon.svg" alt="">
                <span class="total-badge">0</span>
            </div>

            <div class="details">
                <span>GROZS</span>
                <span class="total-price">€0.00</span>
            </div>
        </a>
    </li>
</template>

<script>
export default {
    name: 'HeaderMiniCars',
    data() {
        return {
            auth: false,
        }
    },
    methods: {
        authPopup(type) {
            this.$store.state.authPopup = type;
        }
    },
    mounted() {}
}
</script>

<style lang="scss" scoped>
@function rem($size) {
    @return calc($size / 16) * 1rem;
}

.user-cart {
    a {
        display: flex;
        align-items: center;

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
}
</style>
