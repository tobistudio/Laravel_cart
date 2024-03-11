<template>
    <div class="content-heading-holder">
        <button type="button" class="mobile-back-btn"></button>
        <h1 class="content-heading">Maksājumu metodes</h1>
    </div>
   
    <div class="payments-methods">
        <div class="empty">
            <div class="image">
                <img src="../../../../../../resources/front/images/profile-payment-methods-empty-img.png" alt="">
            </div>

            <span class="block-heading">Nav pievienota neviena maksājuma metode!</span>
            <p>Pievieno vēlamo maksājumu metodi un par pasūtījumiem norēķinies ātrāk.</p>

            <a href="#" class="btn btn-add btn-primary" @click="openAddCardPopup">
               <span>Pievienot karti</span>
            </a>
        </div>

        <br>
        <br>

        <div class="cards-list">
            <div class="item">
                <div class="card-info">
                    <div class="image">
                        <img src="../../../../../../resources/front/images/bank-card-image.svg" alt="">
                    </div>

                    <div class="details">
                        <span class="card-number">xxxx xxxx xxxx 6453</span>
                        <span class="card-owner">Rolands Rautmanis</span>
                        <span class="card-date">10/25</span>
                    </div>
                </div>

                <div class="actions">
                    <button type="button" class="btn-choose">
                        <span>Izvēlēties</span>
                    </button>
                    
                    <button type="button" class="btn-remove" @click="openRemoveCardConfirmationPopup()">
                        <span>Dzēst</span>
                    </button>
                </div>
            </div>

            <div class="item">
                <div class="card-info">
                    <div class="image">
                        <img src="../../../../../../resources/front/images/bank-card-image.svg" alt="">
                    </div>

                    <div class="details">
                        <span class="card-number">xxxx xxxx xxxx 9878</span>
                        <span class="card-owner">Rolands Rautmanis</span>
                        <span class="card-date">05/24</span>
                    </div>
                </div>

                <div class="actions">
                    <button type="button" class="btn-choose">
                        <span>Izvēlēties</span>
                    </button>
                    
                    <button type="button" class="btn-remove" @click="openRemoveCardConfirmationPopup()">
                        <span>Dzēst</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="toolbar">
            <button type="button" class="btn btn-add btn-primary" @click="openAddCardPopup">
                <span>Pievienot karti</span>
            </button>
        </div>

        <div v-if="addCardPopup" class="content-popup add-car-popup">
            <div class="content">
                <div class="popup-header">
                    <h4 class="heading">Pievienot maksājumu karti</h4>

                    <div @click="closeAddCardPopup" class="close"></div>
                </div>

                <div class="popup-content">
                    <div class="form">
                        <div class="form-group required">
                            <label>Vārds uz kartes</label>
                            <input type="text" class="form-control" placeholder="Vārds Uzvārds">
                        </div>

                        <div class="form-group required">
                            <label>Kartes numurs</label>
                            <input type="number" class="form-control card-number" placeholder="xxxx-xxxx-xxxx-xxxx">
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group required m-0">
                                    <label>Derīgs līdz</label>
                                    <input type="text" class="form-control date" placeholder="MM/GG">
                                </div>                                
                            </div>

                            <div class="col-6">
                                <div class="form-group required m-0">
                                    <label>CVC/CVV</label>
                                    <input type="number" class="form-control cvv" placeholder="123">
                                </div>                                
                            </div>

                        </div>

                        <div class="submit-form">
                            <button type="submit" class="btn-submit btn btn-primary" @click="">Saglabāt</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="removeCardPopup" class="content-popup confirm-remove">
            <div class="content">
                <div class="popup-header">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <path d="M13.333 20.5882H66.6663M29.9997 10H49.9997M51.6663 70H28.333C24.6511 70 21.6663 66.8397 21.6663 62.9412L20.1443 24.2646C20.0654 22.2594 21.5794 20.5882 23.4748 20.5882H56.5246C58.42 20.5882 59.9339 22.2594 59.855 24.2646L58.333 62.9412C58.333 66.8397 55.3482 70 51.6663 70Z" stroke="#CD2C2C" stroke-width="3" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <span class="heading">Vai tiešām vēlies dzēst šo maksājumu karti?</span>

                    <div @click="closeRemoveCardConfirmationPopup" class="close"></div>
                </div>

                <div class="popup-content">
                    <div class="action-btns">
                        <button type="submit" class="btn-cancel btn btn-secondary" @click="">Atcelt</button>
                        <button type="submit" class="btn-submit btn btn-primary" @click="">Jā, dzēst</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'profilePaymentMethods',
    props: ['locale'],
    data() {
        return {
            viewLoaded: false,
            addCardPopup: false,
            removeCardPopup: false,
        }
    },

    methods: {
        openAddCardPopup() {
            this.addCardPopup = true;
            document.getElementsByTagName('html')[0].style.overflow = "hidden";
        },

        closeAddCardPopup() {
            this.addCardPopup = false;
            document.getElementsByTagName('html')[0].style.overflow = "auto";
        },

        openRemoveCardConfirmationPopup() {
            this.removeCardPopup = true;
            document.getElementsByTagName('html')[0].style.overflow = "hidden";

        },

        closeRemoveCardConfirmationPopup() {
            this.removeCardPopup = false;
            document.getElementsByTagName('html')[0].style.overflow = "auto";
        }
    },
    mounted() {}
}
</script>

<style lang="scss" scoped>
    .content-heading {
        margin: 0 0 32px 0;
        font-size: 28px;
        line-height: 34px;
        letter-spacing: -0.56px;

        @media screen {
            @media (max-width: 991px) {
                font-size: 23px;
                line-height: 29px;
                letter-spacing: -0.46px;
            }
        }

        &.tablet-hidden {
            @media screen {
                @media (max-width: 991px) {
                    display: none;
                }
            }
        }
    }

    .cards-list {
        display: flex;
        flex-direction: column;
        gap: 12px 0;
        margin: 0 0 40px 0;

        @media screen {
            @media (max-width: 575px) {
                margin: 0 0 32px 0;
            }
        }

        .item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            border: 1px solid #E9EAEC;
            border-radius: 8px;

            @media screen {
                @media (max-width: 820px) {
                    flex-direction: column;
                    align-items: flex-start;
                    justify-content: flex-start;
                }
            }

            .card-info {
                display: flex;
                align-items: flex-start;
                gap: 0 16px;

                .image {
                    flex-shrink: 0;
                    width: 56px;
                }

                .details {
                    span {
                        display: block;
                        line-height: 18px;
                        color: #0D2441;
                        font-size: 14px;
                        &.card-number {
                            margin: 0 0 8px 0;
                            line-height: 14px;
                            font-size: 20px;
                            font-weight: 500;

                            @media screen {
                                @media (max-width: 575px) {
                                    font-size: 18px;
                                }
                            }
                        }
                        &.card-owner {
                            margin: 0;
                            font-weight: 500;
                        }                        
                        &.card-date {
                            color: #49515A;
                            

                            @media screen {
                                @media (max-width: 575px) {
                                    font-size: 12px;
                                }
                            }
                        }
                    }
                }
            }

            .actions {
                display: flex;
                gap: 0 16px;

                @media screen {
                    @media (max-width: 880px) AND (min-width: 821px) {
                        flex-direction: column;
                        align-items: flex-end;
                        gap: 8px 0;
                    }

                    @media (max-width: 820px) {
                        gap: 0 16px;
                        margin: 22px 0 0 0;
                    }

                    @media (max-width: 575px) {
                        margin: 19px 0 0 0;
                    }
                }

                button {
                    line-height: 14px;
                    font-size: 14px;
                    font-weight: 500;
                    font-family: "Inter", sans-serif;
                    cursor: pointer;
                    transition: all 0.3s ease-in-out;

                    &.btn-choose {
                        padding: 12px 18px;
                        background: #F1F2F3;
                        border: 1px solid #F1F2F3;
                        color: #49515A;
                        text-align: center;
                        border-radius: 8px;

                        &:hover {
                            border-color: #0D2441;
                            color: #0D2441;
                        }

                        &.selected {
                            padding-left: 16px;
                            padding-right: 16px;;
                            background: #EAF9EC;
                            color: #49A041;

                            span {
                                display: flex;
                                align-items: center;
                                justify-content: center;

                                &::before {
                                    content: "";
                                    width: 16px;
                                    height: 16px;
                                    margin: 0 8px 0 0;
                                    background: #49A041 url('../../../../../../resources/front/images/active-check-icon.svg') center center no-repeat;
                                    border-radius: 4px;
                                }
                            }

                            &:hover {
                                border-color: #49A041;
                            }
                        }
                    }

                    &.btn-remove {
                        display: flex;
                        align-items: center;
                        padding: 9px 0;
                        gap: 0 2px;
                        border: 0;
                        background: none;
                        font-weight: 500;
                        color: #7D8391;

                        &::before {
                            content: '';
                            width: 14px;
                            height: 14px;
                            background: url('../../../../../../resources/front/images/remove-icon.svg') left center no-repeat;
                        }

                        &:hover {
                            color: #0D2441;
                        }
                    }
                }
            }
        }
    }

    .toolbar {
        display: flex;
        justify-content: flex-start;

        @media screen {
            @media (max-width: 575px) {
                .btn {
                    min-width: 100%;
                    flex-basis: 100%;
                }
            }
        }
    }
</style>
