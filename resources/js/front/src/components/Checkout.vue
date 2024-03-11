<template>
    <div class="container">
        <div class="heading-wrapper navigation steps-navigation">
            <template v-for="page in data.header_navigation">
                <span v-if="page.active" class="item active">{{ page.title }}</span>
                <a v-else :href="page.slug" class="item">{{ page.title }}</a>
            </template>
            <span class="item">Pasūtījums pieņemts</span>
        </div>
    </div>

    <div class="container">
        <div class="checkout-content">
            <div class="checkout-steps">
                <h1 class="page-heading">Noformēt pasūtījumu</h1>

                <div class="login-cta">
                    <span>Esi jau reģistrējies mūsu veikalā? Ielogojies savā kontā.</span>
                    <a href="#">Pieslēgties</a>
                </div>
                
                <div class="step-block step-1">
                    <div class="block-header">
                        <div class="step-number">1</div>
                        <div class="details">
                            <h2 class="step-name">Kontaktinformācija</h2>
                            <p>Informāciju izmantosim pasūtījuma apstrādei</p>
                        </div>
                    </div>

                    <div class="tabs">
                        <ul class="nav-tabs">
                            <li class="active" data-target="tab-pane-1" @click="changeTab">Privātpersona</li>
                            <li data-target="tab-pane-2" @click="changeTab">Uzņēmums</li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane tab-pane-1 active">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" v-on:focus="handleFocus" v-on:blur="handleBlur">
                                    <label class="required" v-on:click="handleFocus">E-pasts</label>
                                </div>
    
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control" v-on:focus="handleFocus" v-on:blur="handleBlur">
                                    <label class="required" v-on:click="handleFocus">Tālrunis</label>
                                </div>
    
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" v-on:focus="handleFocus" v-on:blur="handleBlur">
                                    <label class="required" v-on:click="handleFocus">Vārds</label>
                                </div>
    
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" v-on:focus="handleFocus" v-on:blur="handleBlur">
                                    <label class="required" v-on:click="handleFocus">Uzvārds</label>
                                </div>
                                
                                <div class="form-group checkbox m-bt-0">
                                    <input type="checkbox" name="" id="cb-1">
                                    <label for="cb-1" v-on:click="handleFocus">Reģistrēties “RB Motors” interneta veikalā (paroli nosūtīsim e-pastā)</label>
                                </div>
                            </div>

                            <div class="tab-pane tab-pane-2">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" v-on:focus="handleFocus" v-on:blur="handleBlur">
                                    <label class="required" v-on:click="handleFocus">E-pasts</label>
                                </div>
    
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control" v-on:focus="handleFocus" v-on:blur="handleBlur">
                                    <label class="required" v-on:click="handleFocus">Tālrunis</label>
                                </div>
    
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" v-on:focus="handleFocus" v-on:blur="handleBlur">
                                    <label class="required" v-on:click="handleFocus">Vārds</label>
                                </div>
    
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" v-on:focus="handleFocus" v-on:blur="handleBlur">
                                    <label class="required" v-on:click="handleFocus">Uzvārds</label>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" v-on:focus="handleFocus" v-on:blur="handleBlur">
                                    <label class="required" v-on:click="handleFocus">Uzņēmuma nosaukums</label>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" v-on:focus="handleFocus" v-on:blur="handleBlur">
                                    <label class="required" v-on:click="handleFocus">Reģistrācijas numurs</label>
                                </div>

                                <div class="legal-address">
                                    <h4 class="block-heading">Juridiskā adrese <span>(pvadzīmēm)</span></h4>

                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" v-on:focus="handleFocus" v-on:blur="handleBlur">
                                        <label class="required" v-on:click="handleFocus">Pilsēta / ciems / pagasts / novads</label>
                                    </div>

                                    <div class="form-group-wrapper">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" v-on:focus="handleFocus" v-on:blur="handleBlur">
                                            <label class="required" v-on:click="handleFocus">Ielas vai mājas nosaukums</label>
                                        </div>

                                        <div class="form-group postcode">
                                            <input type="text" name="name" class="form-control" v-on:focus="handleFocus" v-on:blur="handleBlur">
                                            <label class="required" v-on:click="handleFocus">Pasta indekss</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="step-block step-2">
                    <div class="block-header">
                        <div class="step-number">2</div>
                        <div class="details">
                            <h2 class="step-name">Piegādes veids</h2>
                            <p>Izvēlies kādu no piegādes veidiem</p>
                        </div>
                    </div>

                    <div class="tabs delivery-methods-tabs">
                        <ul class="nav-tabs">
                            <li class="active" data-target="tab-pane-1" @click="changeTab">Saņemt veikalā</li>
                            <li data-target="tab-pane-2" @click="changeTab">Saņemšanas punkti</li>
                            <li data-target="tab-pane-3" @click="changeTab">Kurjers</li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane tab-pane-1 active">
                                <div class="form-group radio">
                                    <input type="radio" name="delivery-store" id="delivery-store" checked>
                                    <label for="delivery-store">
                                        <div>
                                            <strong class="name">“RB Motors” veikals</strong>
                                            <span class="location">Rūpniecības iela 39a, Jelgava</span>
                                        </div>
                                        
                                        <div class="time-and-cost">
                                            <div class="price">
                                                <span class="span-label">Piegādes izmaksas</span> 
                                                <strong>Bezmaksas</strong>
                                            </div>
                                        </div>    
                                    </label>
                                </div>

                                <div class="time-and-cost">
                                    <div class="time">
                                        <span class="span-label">Piegādes laiks</span> 
                                        <p>Saņem šodien līdz 18:00, veicot pirkumu līdz 17:00</p>
                                    </div>

                                    <div class="working-hours">
                                        <span class="span-label">Darba laiks</span> 
                                        
                                        <ul>
                                            <li><strong>P-Pk</strong> 8:30-18:00</li>
                                            <li><strong>S</strong> 9:00-16:00</li>
                                            <li><strong>Sv</strong> 10:00-14:00</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane tab-pane-2">
                                <div class="inline-radio-list">
                                    <div class="form-group radio m-0">
                                        <input type="radio" name="delivery-type-2" id="delivery-type-2-1" checked>
                                        <label for="delivery-type-2-1">DPD</label>
                                    </div>

                                    <div class="form-group radio m-0">
                                        <input type="radio" name="delivery-type-2" id="delivery-type-2-2">
                                        <label for="delivery-type-2-2">Latvijas pasts</label>
                                    </div>

                                    <div class="form-group radio m-0">
                                        <input type="radio" name="delivery-type-2" id="delivery-type-2-3">
                                        <label for="delivery-type-2-3">Circle K</label>
                                    </div>
                                </div>

                                <div class="form-group dropdown">
                                    <input type="text" name="dropdown-name">
                                    <button type="button" class="dropdown-toggle" @click="dropdown">Izvēlies paku skapja adresi</button>

                                    <div class="dropdown-menu">
                                        <li>Option 1</li>
                                        <li>Option 2</li>
                                        <li>Option 3</li>
                                    </div>
                                </div>

                                <div class="time-and-cost justify-content-between">
                                    <div class="time">
                                        <span class="span-label">Piegādes laiks</span> 
                                        <p>1-2 darba dienas</p>
                                    </div>

                                    <div class="price">
                                        <span class="span-label">Piegādes izmaksas</span> 
                                        <p>€1.98</p>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane tab-pane-3">
                                <div class="inline-radio-list">
                                    <div class="form-group radio m-0">
                                        <input type="radio" name="delivery-type-3" id="delivery-type-3-1" checked>
                                        <label for="delivery-type-3-1">DPD</label>
                                    </div>

                                    <div class="form-group radio m-0">
                                        <input type="radio" name="delivery-type-3" id="delivery-type-3-2">
                                        <label for="delivery-type-3-2">Express Pasts</label>
                                    </div>
                                </div>

                                <div class="inputs-row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="text" name="" class="form-control" v-on:focus="handleFocus" v-on:blur="handleBlur">
                                            <label class="required" v-on:click="handleFocus">Pilsēta / ciems / pagasts / novads</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="text" name="" class="form-control" v-on:focus="handleFocus" v-on:blur="handleBlur">
                                            <label class="required" v-on:click="handleFocus">Ielas vai mājas nosaukums</label>
                                        </div>

                                        <div class="form-group postcode">
                                            <input type="number" name="" class="form-control" v-on:focus="handleFocus" v-on:blur="handleBlur">
                                            <label class="required" v-on:click="handleFocus">Pasta indekss</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="time-and-cost justify-content-between">
                                    <div class="time">
                                        <span class="span-label">Piegādes laiks</span> 
                                        <p>1-2 darba dienas</p>
                                    </div>

                                    <div class="price">
                                        <span class="span-label">Piegādes izmaksas</span> 
                                        <p>€1.98</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="step-block step-3">
                    <div class="block-header">
                        <div class="step-number">3</div>
                        <div class="details">
                            <h2 class="step-name">Maksājuma metode</h2>
                            <p>Izvēlies ērtāko apmaksas veidu</p>
                        </div>
                    </div>

                    <div class="radio-list-holder">
                        <button type="button" class="mobile-dropdown-toggle" @click="openMobileRadioDropdown">Izvēlies apmaksas veidu</button>

                        <div class="radio-list">
                            <div class="form-group">
                                <input type="radio" name="payments-methods" value="Maksājumu karte" id="payments-method-1" checked>
                                <label for="payments-method-1" @click="mobileRadioLabelClick">
                                    <div><strong>Maksājumu karte</strong></div>

                                    <div class="logos">
                                        <img src="../../../../../public/images/front/banks-logos/visa-logo.svg" alt="">
                                        <img src="../../../../../public/images/front/banks-logos/master-card-logo.svg" alt="">
                                    </div>
                                </label>
                            </div>

                            <div class="form-group">
                                <input type="radio" name="payments-methods" value="Internetbanka" id="payments-method-2">
                                <label for="payments-method-2" @click="mobileRadioLabelClick">
                                    <div><strong>Internetbanka</strong></div>

                                    <div class="logos">
                                        <img src="../../../../../public/images/front/banks-logos/swedbank-logo.svg" alt="">
                                        <img src="../../../../../public/images/front/banks-logos/citadele-logo.svg" alt="">
                                        <img src="../../../../../public/images/front/banks-logos/luminor-logo.svg" alt="">
                                        <img src="../../../../../public/images/front/banks-logos/seb-logo.svg" alt="">
                                    </div>
                                </label>
                            </div>

                            <div class="form-group">
                                <input type="radio" name="payments-methods" value="Bankas pārskaitījums" id="payments-method-3">
                                <label for="payments-method-3" @click="mobileRadioLabelClick">
                                    <div><strong>Bankas pārskaitījums</strong> <span>Uz Tavu norādīto e-pasta adresi tiks nosūtīts rēķins.</span></div>
                                </label>
                            </div>

                            <div class="form-group">
                                <input type="radio" name="payments-methods" value="Skaidrā naudā preces saņemšanas brīdī" id="payments-method-4">
                                <label for="payments-method-4" @click="mobileRadioLabelClick">
                                    <div><strong>Skaidrā naudā preces saņemšanas brīdī</strong> <span>Apmaksai jāsagatavo precīza naudas summa.</span></div>
                                </label>
                            </div>

                            <div class="form-group">
                                <input type="radio" name="payments-methods" value="Ar maksājumu karti preces saņemšanas brīdī" id="payments-method-5">
                                <label for="payments-method-5" @click="mobileRadioLabelClick">
                                    <div><strong>Ar maksājumu karti preces saņemšanas brīdī</strong></div>
                                </label>
                            </div>
                        </div>                        
                    </div>
                </div>

                <div class="submit-toolbar">
                    <div class="form-group checkbox">
                        <input type="checkbox" name="confirm-checkbox" id="confirm-checkbox">
                        <label for="confirm-checkbox">Esmu iepazinies/usies ar <a href="#" target="_blank">Noteikumiem un nosacījumiem</a> un <a href="#" target="_blank">Privātuma politiku</a>.</label>
                    </div>

                    <div class="action-btns">
                        <a href="#" class="btn-back">Atpakaļ uz grozu</a>
                        <button type="submit" class="btn btn-primary">Pasūtīt</button>
                    </div>
                </div>
            </div>

            <div class="summary">
                <h4 class="block-name" @click="mobileSummaryToggle">Tavs pasūtījums <span class="mobile-qty">(3)</span></h4>

                <div class="wrapper">
                    <ul class="minicart-items">
                        <li class="product-item">
                            <div class="image">
                                <a href="#">
                                    <img src="../../../../../public/images/front/TRW-GDB1307.png" alt="">
                                </a>
                            </div>

                            <div class="short-details">
                                <h5 class="product-name">
                                    <a href="#">Bremžu uzliku komplekts TRW GDB1307</a>
                                </h5>

                                <span class="code">Preces kods: 713289 </span>
                            </div>

                            <div class="subtotal">
                                <span class="qty">1x</span>
                                <span class="price">€39.70</span>
                            </div>
                        </li>

                        <li class="product-item">
                            <div class="image">
                                <a href="#">
                                    <img src="../../../../../public/images/front/FEBI-BILSTEIN-26647.png" alt="">
                                </a>
                            </div>

                            <div class="short-details">
                                <h5 class="product-name">
                                    <a href="#">Bremžu diski FEBI BILSTEIN 26647</a>
                                </h5>

                                <span class="code">Preces kods: 713289 </span>
                            </div>

                            <div class="subtotal">
                                <span class="qty">2x</span>
                                <span class="price">€72.60</span>
                            </div>
                        </li>

                        <li class="product-item">
                            <div class="image">
                                <a href="#">
                                    <img src="../../../../../public/images/front/TRW-GDB1307.png" alt="">
                                </a>
                            </div>

                            <div class="short-details">
                                <h5 class="product-name">
                                    <a href="#">Suporta izspiedēja komplekts YATO YT-0611</a>
                                </h5>

                                <span class="code">Preces kods: 713289 </span>
                            </div>

                            <div class="subtotal">
                                <span class="qty">1x</span>
                                <span class="price">€31.30</span>
                            </div>
                        </li>
                    </ul>

                    <table class="price-table">
                        <tbody>
                            <tr>
                                <td>Preču summa <span class="no-vat">(bez PVN)</span></td>
                                <td>€106.44</td>
                            </tr>

                            <tr>
                                <td>PVN 21% </td>
                                <td>€25.80</td>
                            </tr>

                            <tr>
                                <td>Saņemšanas veids <span>Piegāde ar DPD paku skapi</span></td>
                                <td>€1.98</td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td>Kopā</td>
                                <td>€134.27</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>            
        </div>
    </div>
</template>

<script>
import {defineAsyncComponent} from 'vue'

export default {
    name: 'Checkout',
    props: ['locale', 'data'],
    data() {
        return {
            activeVehicleSearchBlock: false,
            isFocused: false
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
        },

        handleFocus() {
            this.isFocused = true; 
            const formGroup = event.target.closest('.form-group');

            formGroup.classList.add('on-focus');

            if (formGroup) {
                const input = formGroup.querySelector('input');

                if (input) {
                    input.focus();
                }
            }
        },

        handleBlur() {
            this.isFocused = false;
            const formGroup = event.target.closest('.form-group');

            formGroup.classList.remove('on-focus');

            if (event.target.value) {
                formGroup.classList.add('has-value');
                formGroup.classList.add('valid');
            } else {
                formGroup.classList.remove('has-value');
                formGroup.classList.remove('valid');
            }
        },

        changeTab() {
            const target = event.target;
            const targetTab = target.getAttribute('data-target');
            const tabs = target.closest('.tabs');
            const tabPanes = tabs.querySelectorAll('.tab-pane');

            tabs.querySelector('.nav-tabs .active').classList.remove('active');
            target.classList.add('active');

            tabs.querySelector('.tab-content .active').classList.remove('active');
            tabs.querySelector(`.${targetTab}`).classList.add('active');
        },

        mobileSummaryToggle() {
            const summary = event.target.closest('.summary');
            summary.classList.toggle('mobile-opened');
        },

        openMobileRadioDropdown() {
            const radioListHolder = event.target.closest('.radio-list-holder');
            radioListHolder.classList.toggle('mobile-opened');
        },

        mobileRadioLabelClick() {
            if (window.innerWidth < 576) {
                const label = event.target.closest('label');
                const input = label.closest('.form-group').querySelector('input');  
                            
                const radioListHolder = label.closest('.radio-list-holder');
                const mobileDropdownToggle = radioListHolder.querySelector('.mobile-dropdown-toggle');

                mobileDropdownToggle.textContent = input.value;
                radioListHolder.classList.remove('mobile-opened');
            }
        },

        dropdown () {
            const radioListHolder = event.target.closest('.dropdown');
            radioListHolder.classList.toggle('opened');
        }
    },
    mounted() {}
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

    .steps-navigation {		
		display: flex;
		align-items: center;
		justify-content: center;
		padding: 40px 0;
        margin: 0 0 40px 0;

		@media screen {
            @media (max-width: 1050px) {
                margin: 0 0 21px 0;
                padding: 24px 0;
            }

            @media (max-width: 575px) {
                padding: 14px 0;
                margin-bottom: 16px;
            }
		}

		&.m-0 {
			margin: 0;
		}
		
		.item {
			line-height: 20px;
			font-size: 20px;
			font-weight: 500;
			color: #BABABA;

			@media screen {
				@media (max-width: 1050px) {
					line-height: 20px;
					font-size: 18px;
				}

				@media (max-width: 730px) {
					line-height: 16px;
					font-size: 16px;
				}

				@media (max-width: 630px) {
					&:first-child {
                        display: none !important;
                    }
				}

                @media (max-width: 510px) {
                    line-height: 12px;
					font-size: 12px;
                }
			}

			&:not(:last-child) {
				display: flex;
				align-items: center;

				&::after {
					content: '';
					height: 16px;
					width: 25px;
					margin: 0 32px;
					background: url('../../../../../resources/front/images/navigation-right-arrow.svg') center center no-repeat;

					@media screen {
						@media (max-width: 1050px) {
							margin: 0 26px;
						}

                        @media (max-width: 510px) {
                            margin: 0 17px;
                            width: 16px;
                            background-size: contain;
                        }
					}
				}

				&.active {
					color: #E72E2C;
				}
			}
		}

		a.item {
            color: #7D8391;

			&:hover {
				color: #E72E2C;
			}
		}

		.mobile-heading {
			font-size: 23px;
			font-weight: 600;
			line-height: 29px;
			letter-spacing: -0.02em;

			@media screen {
				@media (min-width: 576px) {
					display: none;
				}
			}
		}
	}

    .checkout-content {
        display: flex;
        align-items: flex-start;
        gap: 0 24px;

        @media screen {
            @media (max-width: 1050px) {
                flex-direction: column;
            }
        }

        .page-heading {
            margin: 0 0 17px 0;
            font-size: 30px;
            font-weight: 600;
            line-height: 36px;
            letter-spacing: -0.02em;

            @media screen {
                @media (max-width: 1199px) {
                    margin: 0 0 14px 0;
                    line-height: 32px;
                    font-size: 26px;
                }

                @media (max-width: 575px) {
                    margin: 0 0 11px 0;
                }
            }
        }

        .login-cta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0 0 32px 0;
            color: #0D2441;

            @media screen {
                @media (max-width: 1050px) {
                    margin: 0 0 42px 0;
                }

                @media (max-width: 675px) {
                    align-items: flex-start;
                    flex-direction: column;
                }

                @media (max-width: 575px) {
                    margin-bottom: 58px;
                }
            }

            a {
                color: #E72E2C;
                text-decoration: underline;

                &:hover {
                    text-decoration: none;
                }

                @media screen {
                    @media (max-width: 675px) {
                        margin-top: 8px;
                    }
                }
            }
        }

        .checkout-steps {
            flex-grow: 1;

            @media screen {
                @media (max-width: 1050px) {
                    order: 2;
                    width: 100%;
                }
            }

            .step-block {
                @media screen {
                    @media (min-width: 576px) {
                        padding: 32px;
                        border: 1px solid #F4F4F6;
                        background-color: #fff;
                        border-radius: 8px;
                    }
                }

                &:not(:last-child) {
                    margin: 0 0 32px 0;

                    @media screen {
                        @media (max-width: 575px) {
                            margin: 0 0 72px 0;

                            &.step-3 {
                                margin-bottom: 32px;
                            }
                        }
                    }
                }

                .block-header {
                    display: flex;
                    align-items: flex-start;
                    gap: 0 12px;
                    margin: 0 0 30px 0;

                    @media screen {
                        @media (max-width: 575px) {
                            margin: 0 0 24px 0;
                        }
                    }

                    .step-number {
                        position: relative;
                        top: 4px;
                        flex-shrink: 0;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 40px;
                        height: 40px;
                        line-height: 20px;
                        border: 1px solid #D8DADE;
                        font-size: 20px;
                        font-weight: 700;
                        color: #0D2441;
                        border-radius: 50%;

                        @media screen {
                            @media (max-width: 575px) {
                                display: none;
                            }
                        }
                    }

                    .step-name {
                        margin: 0 0 4px 0;
                        font-size: 24px;
                        font-weight: 600;
                        line-height: 30px;
                        letter-spacing: -0.02em;

                        @media screen {
                            @media (max-width: 575px) {
                                line-height: 26px;
                                font-size: 20px;
                            }
                        }
                    }

                    p {
                        margin: 0;
                        line-height: 16px;

                        @media screen {
                            @media (max-width: 575px) {
                                line-height: 14px;
                                font-size: 14px;
                            }
                        }
                    }
                }

                .tabs {
                    .nav-tabs {
                        display: flex;
                        margin: 0 0 32px 0;
                        border-bottom: 1px solid #e9eaee;

                        @media screen {
                            @media (max-width: 575px) {
                                margin: 0 0 24px 0;
                            }
                        }

                        li {
                            flex-basis: 50%;
                            padding: 12px 10px 10px 10px;
                            margin-bottom: -1px;
                            border-bottom: 2px solid transparent;
                            line-height: 16px;
                            color: #616571;
                            cursor: pointer;
                            text-align: center;
                            transition: all .3s ease-in-out;

                            &:hover {
                                color: #E72E2C;
                            }

                            &.active {
                                border-color: #e62e2c;
                                font-weight: 500;
                                color: #E72E2C;
                                cursor: default;
                            }
                        }
                    }

                    .tab-content {
                        .tab-pane {
                            display: none;

                            &.active {
                                display: block;
                            }
                        }

                        .legal-address {
                            padding: 32px 0 0 0;

                            .block-heading {
                                margin: 0 0 15px 0;
                                line-height: 27px;
                                font-size: 19px;

                                span {
                                    font-size: 16px;
                                    font-weight: 400;
                                    color: #616571;
                                }
                            }
                        }

                        .form-group {
                            @media screen {
                                @media (max-width: 575px) {
                                    margin: 0 0 12px 0;
                                }
                            }
                        }

                        .form-group-wrapper {
                            display: flex;

                            .form-group {
                                flex-grow: 1;
                                margin: 0;

                                &.postcode {
                                    flex-grow: 0;
                                    width: 164px;
                                    margin: 0 0 0 16px;
                                }
                            }
                        }
                    }
                }

                .radio-list-holder {
                    position: relative;

                    .mobile-dropdown-toggle {
                        position: relative;
                        width: 100%;
                        padding: 20px 30px 20px 16px;
                        border: 1px solid #D8DADE; 
                        background-color: #fff;
                        color:  #616571;
                        line-height: 14px;
                        font-size: 14px;
                        font-weight: 400;
                        text-align: left;
                        cursor: pointer;
                        border-radius: 8px;

                        &::after {
                            content: '';
                            position: absolute;
                            top: 0;
                            right: 15px;
                            bottom: 0;
                            margin: auto 0;
                            width: 12px;
                            height: 7px;
                            background: url('../../../../../resources/front/images/dropdown-toggle-arrow.svg') right center no-repeat;
                            transition: all .3s ease-in-out;
                        }

                        @media screen {
                            @media (min-width: 576px) {
                                display: none;
                            }
                        }
                    }

                    &.mobile-opened {
                        .mobile-dropdown-toggle {
                            &::after {
                                transform: rotate(-180deg);
                            }
                        }

                        .radio-list {
                            display: block;
                        }
                    }
                }

                .radio-list {
                    @media screen {
                        @media (max-width: 575px) {
                            display: none;
                            position: absolute;
                            top: calc(100% + 4px);
                            left: 0;
                            right: 0;
                            padding: 8px 0;
                            background-color: #fff;
                            box-shadow: 0px 2px 8px 0px #2323231A;
                            border-radius: 8px;
                            z-index: 1;

                            .form-group {
                                margin: 0;
                            }
                        }
                    }

                    input[type="radio"] {
                        display: none;
                    }

                    input[type="radio"] + label {
                        @media screen {
                            @media (min-width: 576px) {
                                position: relative;
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                                min-height: 70px;
                                padding: 0 16px 0 42px;
                                border: 1px solid #E5E6E8;
                                border-radius: 8px;
                                transition: all .3s ease-in-out; 
                                
                                &:hover {
                                    border-color: #0D2441;
                                }

                                &::before {
                                    content: '';
                                    position: absolute;
                                    top: 0;
                                    left: 16px;
                                    bottom: 0;
                                    margin: auto 0;
                                    width: 18px;
                                    height: 18px;
                                    border: 1px solid #9398A3;
                                    border-radius: 50%;
                                    transition: border-color .3s ease-in-out;    
                                }
                            }

                            @media (max-width: 575px) {
                                display: block;
                                padding: 12px 16px;
                                line-height: 14px;
                                font-weight: 400;
                                font-size: 14px;
                            }
                        }

                        div {
                            span {
                                display: block; 
                                margin: 8px 0 0 0;
                                line-height: 14px;
                                font-size: 14px;
                                font-weight: 400;
                                color: #616571;

                                @media screen {
                                    @media (max-width: 575px) {
                                        display: none;
                                    }
                                }
                            }
                        }

                        strong {
                            font-size: 16px;
                            font-weight: 500;
                            line-height: 16px;
                            color: #0D2441;

                            @media screen {
                                @media (max-width: 575px) {
                                    line-height: 14px;
                                    font-weight: 400;
                                    font-size: 14px;
                                }
                            }
                        }

                        .logos {
                            display: flex;
                            align-items: center;
                            gap: 0 16px;

                            @media screen {
                                @media (max-width: 575px) {
                                    display: none;
                                }
                            }
                        }
                    }  

                    input[type="radio"]:checked + label {
                        border-color: #0D2441;

                        &::before {
                            background: url('../../../../../resources/front/images/radio-checked.svg') center center no-repeat;
                            border-color: #0D2441;
                        }
                    }
                    
                }

                .delivery-methods-tabs {
                    input[type="radio"]:checked + label {
                        pointer-events: none;
                    }

                    input[type="radio"] + label {
                        display: flex;
                        justify-content: space-between;
                        
                        strong, b {
                            font-weight: 500;
                            color: #0D2441;
                        }

                        .name {
                            line-height: 18px;
                            font-size: 18px;
                        }

                        .location {
                            display: flex;
                            align-items: center;
                            gap: 0 4px;
                            margin: 5px 0 0 0;
                            line-height: 14px;
                            font-size: 14px;
                            font-weight: 400;
                            color: #49515A;

                            &::before {
                                content: '';
                                width: 14px;
                                height: 14px;
                                background: url('../../../../../resources/front/images/location-icon.svg') left center no-repeat;
                            }
                        }

                        .time-and-cost {
                            padding: 0;
                            border: 0;
                            text-align: right;
                        }
                    }

                    .span-label {
                        display: block;
                        margin: 0 0 6px 0;
                        font-size: 12px;
                        font-weight: 500;
                        line-height: 14px;
                        letter-spacing: 0.1em;
                        color: #616571;
                        text-transform: uppercase;

                        @media screen {
                            @media (max-width: 440px) {
                                line-height: 10px;
                                font-size: 10px;
                            }
                        }
                    }

                    .time-and-cost {
                        padding: 18px 0 0 0;
                        border-top: 1px solid #E9EAEC;
                        line-height: 14px;
                        font-size: 14px;  
                        color: #0D2441;

                        @media screen {
                            @media (max-width: 575px) {
                                padding: 16px 0 0 0;
                                line-height: 12px;
                                font-size: 12px;  
                            }
                        }

                        &.justify-content-between {
                            display: flex;
                            align-items: flex-start;
                            justify-content: space-between;
                        }

                        p {
                            margin: 0;
                        }

                        strong, b {
                            font-weight: 500;
                        }

                        .working-hours {
                            margin: 16px 0 0 0;

                            ul {
                                display: flex;
                                align-items: center;
                                gap: 0 20px;
                            }
                        }

                        .price {
                            text-align: right;

                            @media screen {
                                @media (max-width: 575px) {
                                    display: none;
                                }
                            }

                            p {
                                font-weight: 600;
                            }
                        }
                    }

                    .nav-tabs {
                        display: grid;
                        grid-template-columns: repeat(3, minmax(0, 1fr));
                        margin: 0 0 32px 0;
                        background-color: #f7f7f9;
                        border: 0;
                        border-radius: 8px;

                        li {
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            height: 54px;
                            font-weight: 500;
                            text-align: center;
                            cursor: pointer;
                            transition: all .3s ease-in-out;
                            border-radius: 8px;

                            @media screen {
                                @media (max-width: 575px) {
                                    height: 48px;
                                    line-height: 16px;
                                    font-size: 12px;
                                }
                            }

                            &:hover {
                                color: #e72e2c;
                            }
                        
                            &.active {
                                background-color: #e72e2c;
                                color: #FAFAFA;
                                pointer-events: none;
                            }
                        }
                    }

                    .tab-content {
                        .tab-pane {
                            display: none;

                            &.active {
                                display: block;
                            }

                            &.tab-pane-1 {
                                .radio {
                                    label {
                                        width: 100%;
                                    }
                                }
                            }
                        }
                    }

                    .inputs-row {
                        padding-bottom: 8px;
                        
                        .col-12 {
                            @media screen {
                                @media (min-width: 576px) {
                                    display: flex;
                                }
                            }

                            .form-group {
                                width: 100%;

                                &.postcode {
                                    @media screen {
                                        @media (min-width: 576px) {
                                            flex-shrink: 0;
                                            width: 194px;
                                            margin-left: 16px;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        .summary {
            width: 495px;
            padding: 24px;
            background-color: #F4F4F6;
            border-radius: 8px;

            @media screen {
                @media (max-width: 1199px) {
                    width: 390px;
                    padding: 20px;
                }

                @media (min-width: 1051px) {
                    position: sticky;
                    top: 25px;
                }

                @media (max-width: 1050px) {
                    order: 1;
                    width: 100%;
                    margin: 0 0 40px 0;
                    padding: 0;

                    .wrapper {
                        display: none;
                        padding: 9px 24px 24px 24px;
                    }

                    &.mobile-opened {
                        .wrapper {
                            display: block;
                        }

                        .block-name {
                            background-color: #f1f2f4;

                            &::after {
                                transform: rotate(-180deg);
                            }
                        }
                    }
                }
            }

            .block-name {
                padding: 0 0 13px 0;
                margin: 0 0 24px 0;
                border-bottom: 2px solid #E9EAEC;
                font-size: 24px;
                font-weight: 600;
                line-height: 30px;
                letter-spacing: -0.02em;

                @media screen {
                    @media (max-width: 1050px) {
                        position: relative;
                        margin: 0;
                        padding: 0 50px 0 0;
                        padding: 22px 50px 22px 24px;
                        border: 0;
                        line-height: 24px;
                        font-size: 18px;
                        cursor: pointer;
                        transition: all .3s ease-in-out;
                        border-radius: 8px;

                        &::after {
                            content: '';
                            position: absolute;
                            top: 0;
                            right: 24px;
                            bottom: 0;
                            margin: auto 0;
                            width: 16px;
                            height: 16px;
                            background: url('../../../../../resources/front/images/checkout-summary-toggle-arrow.svg') right center no-repeat;
                            transition: all .3s ease-in-out;
                        }
                    }

                    @media (max-width: 575px) {
                        padding: 16px 50px 16px 16px;
                        line-height: 16px;
                        font-size: 16px;
                    }
                }

                .mobile-qty {
                    line-height: 14px;
                    font-size: 14px;
                    font-weight: 400;
                    color: #49515A;

                    @media screen {
                        @media (min-width: 576px) {
                            display: none;
                        }
                    }
                }
            }

            .minicart-items {
                margin: 0 0 16px 0;

                .product-item {
                    display: flex;
                    align-items: center;
                    gap: 0 12px;
                    padding: 24px 0;
                    border-bottom: 1px solid #e9eaec;

                    &:first-child {
                        padding-top: 0;
                    }

                    .image {
                        flex-shrink: 0;
                        width: 64px;
                        height: 50px;
                        border-radius: 8px;

                        a {
                            display: flex;
                            align-items: center;
                            height: 100%;
                            width: 100%; 
                            background-color: #fff;
                            border-radius: 8px;

                            img {
                                border-radius: 8px;
                            }
                        }
                    }

                    .short-details {
                        flex-grow: 1;
                        padding: 0 50px 0 0;

                        @media screen {
                            @media (max-width: 1199px) {
                                padding: 0 30px 0 0;
                            }
                        }

                        .product-name {
                            margin: 0 0 8px 0;
                            line-height: 18px;
                            font-size: 14px;
                            font-weight: 400;

                            a {
                                color: #0D2441;

                                &:hover {
                                    color: #E72E2C;
                                }
                            }
                        }

                        .code {
                            display: block;
                            line-height: 12px;
                            font-size: 12px;
                            color: #616571;
                        }
                    }

                    .subtotal {
                        display: flex;
                        align-items: center;
                        gap: 0 8px;
                        line-height: 16px;
                        color: #0D2441;

                        .qty {
                            color: #7D8391;
                        }
                    }
                }
            }

            .price-table {
                width: 100%;
                border-collapse: collapse;

                tbody {
                    tr {
                        td {
                            padding: 4px 0;
                            font-weight: 500;
                            color: #0D2441;
                            vertical-align: middle;

                            span {
                                display: block;
                                line-height: 16px;
                                font-size: 12px;
                                font-weight: 400;
                                color: #49515A;
                            }

                            .no-vat {
                                display: inline-block;
                            }

                            &:last-child {
                                text-align: right;
                            }
                        }

                        &:last-child {
                            td {
                                padding-bottom: 20px;
                            }
                        }
                    }
                }

                tfoot {
                    tr {
                        td {
                            padding: 16px 0 0 0;
                            border-top: 1px solid #e9eaec;
                            line-height: 20px;
                            font-weight: 600;
                            font-size: 20px;
                            color: #0D2441;

                            &:last-child {
                                text-align: right;
                            }
                        }
                    }
                }
            }
        }

        .submit-toolbar {
            margin: 32px 0 0 0;

            @media screen {
                @media (max-width: 575px) {
                    margin: 0;
                }
            }

            .action-btns { 
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin: 56px 0 0 0;

                @media screen {
                    @media (max-width: 575px) {
                        margin: 48px 0 0 0;
                        flex-direction: column;

                        .btn-back {
                            order: 2;
                        }
                    }
                }

                .btn-back {
                    display: flex;
                    align-items: center;
                    gap: 0 4px;

                    &::before {
                        content: '';
                        width: 14px;
                        height: 14px;
                        background: url('../../../../../resources/front/images/left-back-icon.svg') left center no-repeat;
                    }
                }

                .btn {
                    min-width: 250px;
                    padding: 19px 15px;
                    border-bottom: 0;

                    @media screen {
                        @media (max-width: 575px) {
                            order: 1;
                            min-width: 100%;
                            margin-bottom: 27px;
                        }
                    }
                }
            }
        }
    }

    .form-control {
        width: 100%;
        height: 56px;
        border-color: #D8DADE;
        color: #0D2441;
    }

    input.form-control + label,
    textarea.form-control + label {
        display: flex;
        align-items: center;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 0 16px;
        margin: auto 0;
        height: 16px;
        color: #7D8391;
        font-weight: 400;
        font-size: 16px;
        cursor: text;
        transition: all .2s ease-in-out;

        &.required {
            &::after {
                content: '*';
                font-weight: 600;
                color: #DF2C21;
            }
        }
    } 

    .on-focus, .has-value {
        .form-control {
            padding-top: 11px;
        }
    }

    .on-focus, .has-value, .has-error, .valid {
        input.form-control + label,
        textarea.form-control + label {
            line-height: 10px;
            font-size: 10px;
            color: #454851;
            transform: translateY(-10px);
        } 
    }

    .valid {
        input {
            border-color: #49A041;
            background-image: url('../../../../../resources/front/images/valid-icon.svg');
            background-position: calc(100% - 15px) center;
            background-repeat: no-repeat;
        }
    }

    .radio {
        align-items: flex-start;

        input[type="radio"] {
            width: 18px;
            height: 18px;
        }
    }

    .inline-radio-list {
        display: flex;
        align-items: center;
        gap: 0 33px;
        margin-bottom: 24px;

        @media screen {
            @media (max-width: 575px) {
                gap: 0 25px;
            }
        }

        .form-group {
            margin: 0;
        }
    }

    .checkbox {
        display: flex;
        align-items: flex-start;
        margin-top: 32px;

        @media screen {
            @media (max-width: 1050px) {
                margin-top: 24px;
            }
        }

        label {
            margin: 0;
            font-size: 16px;
            color: #0D2441;

            @media screen {
                @media (max-width: 575px) {
                    line-height: 20px;
                    font-size: 14px;
                }
            }
        }
    }

    .dropdown {
        position: relative;
        width: 100%;

        input {
            display: none;
        }

        .dropdown-toggle {
            position: relative;
            width: 100%;
            padding: 15px 30px 15px 18px;
            border: 1px solid #7D8391;
            font-family: Inter;
            font-size: 16px;
            font-weight: 400;
            line-height: 16px;
            letter-spacing: 0.01em;
            color: #585D68;
            text-align: left;
            cursor: pointer;
            border-radius: 8px;

            &::after {
                content: "";
                position: absolute;
                top: 0;
                right: 15px;
                bottom: 0;
                margin: auto 0;
                width: 12px;
                height: 7px;
                background: url('../../../../../resources/front/images/dropdown-toggle-arrow.svg') right center no-repeat;
                transition: all 0.3s ease-in-out;
            }
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 2px);
            left: 0;
            right: 0;
            max-height: 220px;
            padding: 4px 0;
            background-color: #fff;
            border: 1px solid #EBEBEF;
            overflow: auto;
            visibility: hidden;
            opacity: 0;
            list-style: none;
            border-radius: 8px;
            box-shadow: 0px 8px 30px 0px rgba(140, 148, 156, 0.1), 0px 2px 8px 0px rgba(101, 107, 114, 0.1);
            transition: all 0.3s ease-in-out;
            z-index: 1;

            li {
                padding: 11px 16px;
                line-height: 14px;
                color: #0D2441;
                font-size: 14px;
                font-weight: 400;
                cursor: pointer;
                transition: all 0.3s ease-in-out;

                &:hover {
                    background: #F4F4F6;
                }
            }
        }

        &.opened {
            .dropdown-toggle {

                &::after {
                    transform: rotate(-180deg);
                }
            }

            .dropdown-menu { 
                visibility: visible;
                opacity: 1;
            
            }
        }
    }

    .m-bt-0 {
        margin-bottom: 0;
    }

</style>
