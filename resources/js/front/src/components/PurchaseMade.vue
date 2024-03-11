<template>
    <div class="order-ty-page">
        <div class="container">
            <h1 class="title"><span>Paldies, pasūtījums ir pieņemts!</span></h1>

            <div class="blocks-holder">
                <div class="block your-order">
                    <div>
                        <h2 class="block-heading">Tavs pasūtījums</h2>
        
                        <div class="details">
                            <span class="order-number">Pasūtījuma numurs: <b>P003546</b></span>
                            <span>
                                Uz Tavu norādīto e-pasta adresi tiks nosūtīts ziņojums ar detalizētu pasūtījuma informāciju.
                            </span>
                        </div>
                    </div>

                    <a href="/" class="btn btn-primary no-border">Turpināt iepirkties</a>
                </div>

                <div class="block create-account" v-if="!auth">
                    <div>
                        <h2 class="block-heading">Izveidot kontu</h2>

                        <div class="details">
                            <span>Tev ir iespēja izsekot savu pasūtījumu, izveidojot kontu mūsu interneta aptiekā.</span>
                            <span>Tava e-pasta adrese: <b>rolands@piemers.lv</b></span>
                        </div>
                    </div>

                    <a href="/" class="btn btn-secondary">Reģistrēties</a>
                </div>
            </div>

            <br>
            <br>

            <div class="single-block">
                <div class="block your-order">
                    <div>
                        <h2 class="block-heading">Tavs pasūtījums</h2>
        
                        <div class="details">
                            <span class="order-number">Pasūtījuma numurs: <b>P003546</b></span>
                            <span>
                                Uz Tavu norādīto e-pasta adresi tiks nosūtīts ziņojums ar detalizētu pasūtījuma informāciju.
                            </span>
                        </div>
                    </div>

                    <div class="btn-holder">
                        <a href="/" class="btn btn-primary no-border">Turpināt iepirkties</a>
                        <a href="/" class="btn btn-secondary">Mani pasūtījumi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PurchaseMade',
    props: ['locale', 'data'],
    data() {
        return {
            auth: false
        }
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
        if(this.$store.state.token){
            this.auth = true;
        }
    }
}
</script>

<style lang="scss" scoped>
    .order-ty-page {
        padding: 90px 0 23px 0;

        @media screen {
            @media (max-width: 1299px) {
                padding: 48px 0 0 0;
            }

            @media (max-width: 640px) {
                padding: 35px 0 0 0;
            }
        }

        .container {
            max-width:  1050px;
        }

        .title {
            margin: 0 0 66px 0;
            font-size: 36px;
            font-weight: 700;
            line-height: 36px;
            color: #49A041;
            text-align: center;

            @media screen {
                @media (max-width: 1299px) {
                    margin: 0 0 48px 0;
                    line-height: 36px;
                    font-size: 32px;
                }

                @media (max-width: 640px) {
                    font-size: 26px;
                    line-height: 32px;
                    letter-spacing: -0.02em;
                    text-align: center;
                }
            }

            span {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0 12px;

                @media screen {
                    @media (max-width: 640px) {
                        flex-direction: column;
                        gap: 12px 0;
                    }
                }

                &::before {
                    content: '';
                    width: 44px;
                    height: 44px;
                    background: url('../../../../../resources/front/images/check-icon-ty.svg') center center no-repeat;

                    @media screen {
                        @media (max-width: 768px) {
                            width: 36px;
                            height: 36px;
                            background-size: contain;
                        }

                        @media (max-width: 640px) {
                            width: 50px;
                            height: 50px;
                        }
                    }
                }
            }
        }

        .blocks-holder, .single-block {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0 24px;

            @media screen {
                @media (max-width: 768px) {
                    grid-template-columns: auto;
                    gap: 24px 0;
                }

                @media (max-width: 640px) {
                    gap: 32px 0;
                }
            }

            .block {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                align-items: flex-start;
                padding: 32px 24px;
                border-radius: 12px;

                @media screen {
                    @media (max-width: 768px) {
                        padding: 16px;
                    }
                }

                .block-heading {
                    margin: 0 0 28px 0;
                    font-size: 24px;
                    line-height: 30px;
                    letter-spacing: -0.02em;

                    @media screen {
                        @media (max-width: 768px) {
                            margin: 0 0 28px 0;
                            font-size: 20px;
                            line-height: 26px;
                        }

                        @media (max-width: 640px) {
                            margin: 0 0 12px 0;
                        }
                    }
                }

                .details {
                    b, strong {
                        font-weight: 600;
                        color: #0D2441;
                    }

                    span {
                        display: block;
                        line-height: 24px;

                        @media screen {
                            @media (max-width: 640px) {
                                font-size: 14px;

                                &:first-child {
                                    font-size: 16px;
                                }
                            }
                        }
                                
                        &:not(:last-child) {
                            margin: 0 0 8px 0;
                        }

                        &.order-number {
                            @media screen {
                                @media (min-width: 769px) {
                                    font-size: 18px;
                                }
                            }
                        }
                    }
                }

                .btn-holder {
                    display: flex;
                    gap: 0 16px;
                    margin-top: 48px;

                    @media screen {
                        @media (max-width: 640px) {
                            flex-direction: column; 
                            gap: 8px 0;
                            margin-top: 31px;
                            width: 100%;
                        }
                    }

                    .btn {
                        margin: 0;
                    }
                }

                .btn {
                    display: inline-block;
                    padding: 19px 35px;
                    margin-top: 48px;

                    @media screen {
                        @media (max-width: 640px) {
                            margin-top: 31px;
                            width: 100%;
                        }
                    }
                }

                &.your-order {
                    background-color: #F4F4F6;
                }

                &.create-account {
                    border: 1px solid #E9EAEC;
                }
            }
        }

        .single-block {
            display: block;
            max-width: 600px;
            margin: 0 auto;
        }
    }
</style>
