<template>
    <section class="hero category steps-hero">
        <div class="container">
            <div class="heading-wrapper navigation steps-navigation m-0">
                <template v-for="page in data.header_navigation">
                    <span v-if="page.active" class="item active">{{ page.title }}</span>
                    <a v-else :href="page.slug" class="item">{{ page.title }}</a>
                </template>
                <span class="item">Pasūtījums pieņemts</span>
                <span class="mobile-heading">Iepirkumu grozs</span>
            </div>
        </div>
    </section>

    <div class="container">
        <ul class="breadcrumb">
            <template v-for="(item, index) in data.breadcrumbs">
                <li :class="['breadcrumb-item', index === data.breadcrumbs.length - 1 ? 'active' : '']">
                    <span v-if="index === data.breadcrumbs.length - 1">{{ item.name }}</span>
                    <a :href="item.slug" v-else>{{ item.name }}</a>
                </li>
            </template>
        </ul>

        <div class="cart-container">
            <div class="cart-side">
                <div class="cart-name-holder">
                    <h1 class="cart-name">Iepirkumu grozs</h1>

                    <button type="button" class="print-order">
                        <span>Drukāt piedāvājumu</span>
                    </button>
                </div>
                
                <table id="shopping-cart-table">
                    <thead>
                        <tr>
                            <th class="product">Produkts</th>
                            <th class="price">Cena</th>
                            <th class="amount">Daudzums</th>
                            <th class="sum">Summa</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="product" data-mobile="">
                                <div class="product-details">
                                    <div class="image">
                                        <img src="../../../../../public/images/front/cart-product-image.jpg" alt="">
                                    </div>

                                    <div class="details">
                                        <h3 class="name">
                                            <a href="#" target="_blank">Bremžu uzliku komplekts TRW GDB1307</a>
                                        </h3>

                                        <span class="code">Preces kods: 45672 </span>

                                        <div class="delivery">
                                            <span>Pieejams:</span>

                                            <ul>
                                                <li><strong>Šodien, 23.11.</strong> (pasūtot līdz 14:00)</li>
                                            </ul>
                                        </div>

                                        <div class="tablet-price"><span>Cena</span> €39.70</div>
                                    </div>
                                </div>
                            </td>

                            <td class="price" data-mobile="Cena">€39.70</td>

                            <td class="amount" data-mobile="Daudzums">
                                <div class="product-qty">
                                    <button type="button" class="minus" @click="updateQty('minus')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M14.1737 6.85742C14.5524 6.85742 14.8594 7.13724 14.8594 7.48242L14.8594 8.73242C14.8594 9.0776 14.5524 9.35742 14.1737 9.35742L1.8308 9.35742C1.45209 9.35742 1.14509 9.0776 1.14509 8.73242L1.14509 7.48242C1.14509 7.13724 1.45209 6.85742 1.8308 6.85742L14.1737 6.85742Z" fill="#9398A3"/>
                                        </svg>
                                    </button>

                                    <input type="number" name="qty" v-model="qty" class="qty-input" @input="updateQty(null)">

                                    <button type="button" class="plus" @click="updateQty('plus')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M6.62891 1.82829C6.62891 1.44958 6.90873 1.14258 7.25391 1.14258H8.50391C8.84908 1.14258 9.12891 1.44958 9.12891 1.82829V14.1712C9.12891 14.5499 8.84908 14.8569 8.50391 14.8569H7.25391C6.90873 14.8569 6.62891 14.5499 6.62891 14.1712V1.82829Z" fill="#0D2441"/>
                                        <path d="M14.0526 6.75C14.4313 6.75 14.7383 7.02982 14.7383 7.375L14.7383 8.625C14.7383 8.97018 14.4313 9.25 14.0526 9.25L1.70971 9.25C1.331 9.25 1.024 8.97018 1.024 8.625L1.024 7.375C1.024 7.02982 1.331 6.75 1.70971 6.75L14.0526 6.75Z" fill="#0D2441"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            <td class="sum" data-mobile="Summa">
                                <strong>€39.70</strong>

                                <button type="button" class="remove">
                                    <span>Dzēst</span>
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td class="product" data-mobile="">
                                <div class="product-details">
                                    <div class="image">
                                        <img src="../../../../../public/images/front/cart-product-image-2.jpg" alt="">
                                    </div>

                                    <div class="details">
                                        <h3 class="name">
                                            <a href="#" target="_blank">Bremžu diski FEBI BILSTEIN 26647</a>
                                        </h3>

                                        <span class="code">Preces kods: 713289 </span>

                                        <div class="delivery">
                                            <span>Pieejams:</span>

                                            <ul>
                                                <li><strong>Šodien, 23.11.</strong> (pasūtot līdz 14:00)</li>
                                            </ul>
                                        </div>

                                        <div class="tablet-price"><span>Cena</span> €36.30</div>
                                    </div>
                                </div>
                            </td>

                            <td class="price" data-mobile="Cena">€36.30</td>

                            <td class="amount" data-mobile="Daudzums">
                                <div class="product-qty">
                                    <button type="button" class="minus" @click="updateQty('minus')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M14.1737 6.85742C14.5524 6.85742 14.8594 7.13724 14.8594 7.48242L14.8594 8.73242C14.8594 9.0776 14.5524 9.35742 14.1737 9.35742L1.8308 9.35742C1.45209 9.35742 1.14509 9.0776 1.14509 8.73242L1.14509 7.48242C1.14509 7.13724 1.45209 6.85742 1.8308 6.85742L14.1737 6.85742Z" fill="#9398A3"/>
                                        </svg>
                                    </button>

                                    <input type="number" name="qty" v-model="qty" class="qty-input" @input="updateQty(null)">

                                    <button type="button" class="plus" @click="updateQty('plus')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M6.62891 1.82829C6.62891 1.44958 6.90873 1.14258 7.25391 1.14258H8.50391C8.84908 1.14258 9.12891 1.44958 9.12891 1.82829V14.1712C9.12891 14.5499 8.84908 14.8569 8.50391 14.8569H7.25391C6.90873 14.8569 6.62891 14.5499 6.62891 14.1712V1.82829Z" fill="#0D2441"/>
                                        <path d="M14.0526 6.75C14.4313 6.75 14.7383 7.02982 14.7383 7.375L14.7383 8.625C14.7383 8.97018 14.4313 9.25 14.0526 9.25L1.70971 9.25C1.331 9.25 1.024 8.97018 1.024 8.625L1.024 7.375C1.024 7.02982 1.331 6.75 1.70971 6.75L14.0526 6.75Z" fill="#0D2441"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            <td class="sum" data-mobile="Summa">
                                <strong>€72.60</strong>
                                                                
                                <button type="button" class="remove">
                                    <span>Dzēst</span>
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td class="product" data-mobile="">
                                <div class="product-details">
                                    <div class="image">
                                        <img src="../../../../../public/images/front/cart-product-image.jpg" alt="">
                                    </div>

                                    <div class="details">
                                        <h3 class="name">
                                            <a href="#" target="_blank">Bremžu uzliku komplekts TRW GDB1307</a>
                                        </h3>

                                        <span class="code">Preces kods: 45672 </span>

                                        <div class="delivery">
                                            <span>Pieejams:</span>

                                            <ul>
                                                <li><strong>Šodien, 23.11.</strong> (pasūtot līdz 14:00)</li>
                                            </ul>
                                        </div>

                                        <div class="tablet-price"><span>Cena</span> €39.70</div>
                                    </div>
                                </div>
                            </td>

                            <td class="price" data-mobile="Cena">€39.70</td>

                            <td class="amount" data-mobile="Daudzums">
                                <div class="product-qty">
                                    <button type="button" class="minus" @click="updateQty('minus')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M14.1737 6.85742C14.5524 6.85742 14.8594 7.13724 14.8594 7.48242L14.8594 8.73242C14.8594 9.0776 14.5524 9.35742 14.1737 9.35742L1.8308 9.35742C1.45209 9.35742 1.14509 9.0776 1.14509 8.73242L1.14509 7.48242C1.14509 7.13724 1.45209 6.85742 1.8308 6.85742L14.1737 6.85742Z" fill="#9398A3"/>
                                        </svg>
                                    </button>

                                    <input type="number" name="qty" v-model="qty" class="qty-input" @input="updateQty(null)">

                                    <button type="button" class="plus" @click="updateQty('plus')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M6.62891 1.82829C6.62891 1.44958 6.90873 1.14258 7.25391 1.14258H8.50391C8.84908 1.14258 9.12891 1.44958 9.12891 1.82829V14.1712C9.12891 14.5499 8.84908 14.8569 8.50391 14.8569H7.25391C6.90873 14.8569 6.62891 14.5499 6.62891 14.1712V1.82829Z" fill="#0D2441"/>
                                        <path d="M14.0526 6.75C14.4313 6.75 14.7383 7.02982 14.7383 7.375L14.7383 8.625C14.7383 8.97018 14.4313 9.25 14.0526 9.25L1.70971 9.25C1.331 9.25 1.024 8.97018 1.024 8.625L1.024 7.375C1.024 7.02982 1.331 6.75 1.70971 6.75L14.0526 6.75Z" fill="#0D2441"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            <td class="sum" data-mobile="Summa">
                                <strong>€39.70</strong>

                                <button type="button" class="remove">
                                    <span>Dzēst</span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="summary-side">
                <div class="summary">
                    <h4 class="block-name">Kopsavilkums</h4>

                    <table class="price-table">
                        <tbody>
                            <tr>
                                <td>Preču summa <span class="no-vat">(bez PVN)</span></td>
                                <td class="value">€61.50</td> 
                            </tr>

                            <tr>
                                <td>PVN 21%</td>
                                <td class="value">€10.88</td> 
                            </tr>

                            <tr>
                                <td>Starpsumma</td>
                                <td class="value">€37.18</td> 
                            </tr>
                        </tbody>
                    </table>

                    <div class="discount-coupon opened">
                        <button type="button" class="toggle-btn">Atlaižu kods</button>
                        <input type="text" class="form-control" placeholder="Kods">
                    </div>

                    <div class="total-price">
                        <span>Kopā:</span>
                        <span class="price">€208.99</span>
                    </div>

                    <button type="submit" class="btn btn-primary">Noformēt pasūtījumu</button>

                    <ul class="payments-logos">
                        <li><img src="../../../../../public/images/front/banks-logos/swedbank-logo.svg" alt=""></li>
                        <li><img src="../../../../../public/images/front/banks-logos/citadele-logo.svg" alt=""></li>
                        <li><img src="../../../../../public/images/front/banks-logos/luminor-logo.svg" alt=""></li>
                        <li><img src="../../../../../public/images/front/banks-logos/seb-logo.svg" alt=""></li>
                        <li><img src="../../../../../public/images/front/banks-logos/visa-logo.svg" alt=""></li>
                        <li><img src="../../../../../public/images/front/banks-logos/master-card-logo.svg" alt=""></li>
                    </ul>
                </div>

                <div class="text-block">
                    <h3>Piegāde</h3>
                    <p class="excerpt">Preču piegādi visā Latvijas teritorijā nodrošinam ar DPD, Omniva un Itella. Piegādes Jelgavas pilsēta nodrošina arī RB Motors kurjers.</p>

                    <button type="button" class="read-more">Lasīt vairāk</button>
                </div>

                <div class="text-block">
                    <h3>Apmaksa</h3>
                    <p class="excerpt">Pasūtot preces rb24.lv intreneta veikalā pasūtījumu iespējams apmaksāt šādos veidos:</p>

                    <button type="button" class="read-more">Lasīt vairāk</button>
                </div>

                <div class="text-block">
                    <h3>Preču atgriešana</h3>
                    <p class="excerpt">Veicot pirkumu interneta veikalā rb24.lv, Jūs varat izmantot atteikuma tiesības un vienpusēji atkāpties no līguma 14 kalendāro dienu laikā no preces saņemšanas dienas. Atteikuma tiesības neattiecas uz juridiskām personām.</p>
                </div>
            </div>
        </div>

        <div class="related-products">
                <h2 class="section-heading">Tev varētu interesēt</h2>

                <!-- This slider need to INIT -->

                <div class="swiper products-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="product-card">
                                <a href="#" class="manufacturer">
                                    <img src="/storage/uploads/pages/featured_images/page-turtle-wax-480-1_57f0695c3ce4f89853ac2979f90593dba99295e3_optimized.webp" alt="Turtle wax" data-v-5f7621c6="">
                                </a>
                                
                                <a href="/vejstiklu-skidrums-turtle-wax-twl427-4l" class="image">
                                    <img src="/storage/uploads/pages/featured_images/page-vejstiklu-skidrums-turtle-wax-twl427-4l-479-1_2e64e12659e48a4ff0f07f8f4a86f81187571069_optimized.webp" alt="Vējstiklu šķidrums TURTLE WAX TWL427 4L" data-v-5f7621c6="">
                                    <div class="product-label">
                                        <div class="label bg-orange">Average</div>
                                    </div>
                                </a>
                                
                                <div class="details">
                                    <h3 class="name">
                                        <a href="/vejstiklu-skidrums-turtle-wax-twl427-4l">Vējstiklu šķidrums TURTLE WAX TWL427 4L</a>
                                    </h3>
                                    
                                    <div class="product-code">Preces kods: 123456781</div>
                                    <div class="stock-ability outgoing">Atlicis noliktavā: 5</div>
                                    <div class="delivery-time">Saņem: <strong>Rīt, 22.08.2023</strong> (Jelgava)</div>
                                    
                                    <div class="price">
                                        <span class="new-price">€9.40</span>
                                        <span class="old-price">€10.45</span>
                                        <span class="discount desktop">-10%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="product-card">
                                <a href="#" class="manufacturer">
                                    <img src="/storage/uploads/pages/featured_images/page-turtle-wax-480-1_57f0695c3ce4f89853ac2979f90593dba99295e3_optimized.webp" alt="Turtle wax" data-v-5f7621c6="">
                                </a>
                                
                                <a href="/vejstiklu-skidrums-turtle-wax-twl427-4l" class="image">
                                    <img src="/storage/uploads/pages/featured_images/page-vejstiklu-skidrums-turtle-wax-twl427-4l-479-1_2e64e12659e48a4ff0f07f8f4a86f81187571069_optimized.webp" alt="Vējstiklu šķidrums TURTLE WAX TWL427 4L" data-v-5f7621c6="">
                                    <div class="product-label">
                                        <div class="label bg-orange">Average</div>
                                    </div>
                                </a>
                                
                                <div class="details">
                                    <h3 class="name">
                                        <a href="/vejstiklu-skidrums-turtle-wax-twl427-4l">Vējstiklu šķidrums TURTLE WAX TWL427 4L</a>
                                    </h3>
                                    
                                    <div class="product-code">Preces kods: 123456781</div>
                                    <div class="stock-ability outgoing">Atlicis noliktavā: 5</div>
                                    <div class="delivery-time">Saņem: <strong>Rīt, 22.08.2023</strong> (Jelgava)</div>
                                    
                                    <div class="price">
                                        <span class="new-price">€9.40</span>
                                        <span class="old-price">€10.45</span>
                                        <span class="discount desktop">-10%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="product-card">
                                <a href="#" class="manufacturer">
                                    <img src="/storage/uploads/pages/featured_images/page-turtle-wax-480-1_57f0695c3ce4f89853ac2979f90593dba99295e3_optimized.webp" alt="Turtle wax" data-v-5f7621c6="">
                                </a>
                                
                                <a href="/vejstiklu-skidrums-turtle-wax-twl427-4l" class="image">
                                    <img src="/storage/uploads/pages/featured_images/page-vejstiklu-skidrums-turtle-wax-twl427-4l-479-1_2e64e12659e48a4ff0f07f8f4a86f81187571069_optimized.webp" alt="Vējstiklu šķidrums TURTLE WAX TWL427 4L" data-v-5f7621c6="">
                                    <div class="product-label">
                                        <div class="label bg-orange">Average</div>
                                    </div>
                                </a>
                                
                                <div class="details">
                                    <h3 class="name">
                                        <a href="/vejstiklu-skidrums-turtle-wax-twl427-4l">Vējstiklu šķidrums TURTLE WAX TWL427 4L</a>
                                    </h3>
                                    
                                    <div class="product-code">Preces kods: 123456781</div>
                                    <div class="stock-ability outgoing">Atlicis noliktavā: 5</div>
                                    <div class="delivery-time">Saņem: <strong>Rīt, 22.08.2023</strong> (Jelgava)</div>
                                    
                                    <div class="price">
                                        <span class="new-price">€9.40</span>
                                        <span class="old-price">€10.45</span>
                                        <span class="discount desktop">-10%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="product-card">
                                <a href="#" class="manufacturer">
                                    <img src="/storage/uploads/pages/featured_images/page-turtle-wax-480-1_57f0695c3ce4f89853ac2979f90593dba99295e3_optimized.webp" alt="Turtle wax" data-v-5f7621c6="">
                                </a>
                                
                                <a href="/vejstiklu-skidrums-turtle-wax-twl427-4l" class="image">
                                    <img src="/storage/uploads/pages/featured_images/page-vejstiklu-skidrums-turtle-wax-twl427-4l-479-1_2e64e12659e48a4ff0f07f8f4a86f81187571069_optimized.webp" alt="Vējstiklu šķidrums TURTLE WAX TWL427 4L" data-v-5f7621c6="">
                                    <div class="product-label">
                                        <div class="label bg-orange">Average</div>
                                    </div>
                                </a>
                                
                                <div class="details">
                                    <h3 class="name">
                                        <a href="/vejstiklu-skidrums-turtle-wax-twl427-4l">Vējstiklu šķidrums TURTLE WAX TWL427 4L</a>
                                    </h3>
                                    
                                    <div class="product-code">Preces kods: 123456781</div>
                                    <div class="stock-ability outgoing">Atlicis noliktavā: 5</div>
                                    <div class="delivery-time">Saņem: <strong>Rīt, 22.08.2023</strong> (Jelgava)</div>
                                    
                                    <div class="price">
                                        <span class="new-price">€9.40</span>
                                        <span class="old-price">€10.45</span>
                                        <span class="discount desktop">-10%</span>
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
import {defineAsyncComponent} from 'vue'

export default {
    name: 'Cart',
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

    .cart-container {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 0 24px;
        margin: 0 0 88px 0;

        @media screen {
            @media (max-width: 991px) {
                flex-direction: column;
                gap: 64px 0;
            }

            @media (max-width: 640px) {
                margin-bottom: 64px;
            }
        }

        .cart-side {
            flex-grow: 1;

            @media screen {
                @media (max-width: 991px) {
                    width: 100%;
                }

                @media (max-width: 575px) {
                    display: flex;
                    flex-direction: column;
                    padding-top: 8px;
                }
            }

            .cart-name-holder {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin: 0 0 48px 0;

                @media screen {
                    @media (max-width: 575px) {
                        order: 2;
                        justify-content: center;
                        padding: 22px 0 0 0;
                        margin: 0;
                    }
                }

                .cart-name {
                    font-size: 30px;
                    line-height: 36px;
                    letter-spacing: -0.02em;
                    text-align: left;

                    @media screen {
                        @media (max-width: 575px) {
                            display: none;
                        }
                    }
                }

                .print-order {
                    display: flex;
                    align-items: center;
                    cursor: pointer;
                    gap: 0 8px;
                    font-size: 14px;
                    color: #0D2441;
                    font-family: "Inter", sans-serif;

                    &::before {
                        content: '';
                        width: 16px;
                        height: 16px;
                        background: url('../../../../../resources/front/images/printer-icon.svg') left center no-repeat;
                    }

                    &:hover {
                        text-decoration: underline;
                    }
                }
            }

            table {
                width: 100%;
                border-collapse: collapse;

                @media screen {
                    @media (max-width: 575px) {
                        order: 1;
                    }
                }

                th, td {
                    @media screen {
                        @media (max-width: 768px) {
                            font-size: 14px;
                        }
                    }

                    &.product {
                        width: 48.5%;

                        @media screen {
                            @media (max-width: 768px) {
                                width: 64.26%;
                            }
                        }
                    }

                    &.price {
                        width: 20.6%;
                        text-align: center;

                        @media screen {
                            @media (max-width: 1199px) {
                                width: 16%;
                            }

                            @media (max-width: 768px) AND (min-width: 576px) {
                                display: none;
                            }

                            @media (max-width: 575px) {
                                padding: 3px 0;
                                text-align: right;
                            }
                        }
                    }

                    &.amount {
                        width: 120px;
                        text-align: center;
                    }

                    &.sum {
                        text-align: right;

                        @media screen {
                            @media (max-width: 768px) {
                                width: 18.36%;
                            }

                            @media (max-width: 575px) {
                                padding-top: 3px;

                                &::before {
                                    top: 10px;
                                    bottom: auto;
                                }
                            }
                        }
                    }
                }

                thead {
                    @media screen {
                        @media (max-width: 575px) {
                            display: none;
                        }
                    }

                    tr {
                        th {
                            padding: 0 0 3px 0;
                            border-bottom: 1px solid #e9eaec;
                            color: #0D2441;
                            font-weight: 500;
                            text-align: left;

                            @media screen {
                                @media (max-width: 768px) { 
                                    padding: 0 0 2px 0;
                                }
                            }

                            &:first-child {
                                padding-left: 16px;
                                text-align: left;
                            }

                            &:last-child {
                                padding-right: 16px;
                                text-align: right;
                            }
                        }
                    }
                }

                tbody {
                    tr {
                        td {
                            padding-top: 24px;
                            padding-bottom: 24px;
                            vertical-align: top;
                            border-bottom: 1px solid #e9eaec;

                            @media screen {
                                @media (max-width: 768px) {
                                    vertical-align: bottom;
                                }

                                @media (max-width: 575px) {
                                    position: relative;
                                    display: block;
                                    width: 100% !important;
                                    padding: 10px 0;
                                    border: 0;
                                    vertical-align: middle;
                                    text-align: right;

                                    &::before {
                                        content: attr(data-mobile);
                                        position: absolute;
                                        top: 0;
                                        bottom: 0;
                                        left: 80px;
                                        margin: auto 0;
                                        height: 12px;
                                        line-height: 12px;
                                        font-size: 12px;
                                        font-weight: 500;
                                        color: #0D2441;
                                    }
                                }
                            }

                            strong {
                                color: #0D2441;
                                font-weight: 600;
                            }

                            &:first-child {
                                text-align: left;

                                @media screen {
                                    @media (min-width: 576px) {
                                        padding-left: 16px;
                                    }
                                }
                            }

                            &:last-child {
                                text-align: right;

                                @media screen {
                                    @media (min-width: 576px) {
                                        padding-right: 16px;
                                    }
                                }
                            }      

                            &.product {
                                @media screen {
                                    @media (max-width: 575px) {
                                        padding-top: 24px;
                                        border-top: 1px solid #e4e3e8;
                                        text-align: left;
                                    }
                                }

                                .product-details {
                                    display: flex;
                                    align-items: flex-start;
                                    gap: 0 16px;

                                    .image {
                                        flex-shrink: 0;
                                        width: 64px;
                                    }

                                    .details {
                                        .name {
                                            margin: 0 0 6px 0;
                                            line-height: 20px;
                                            font-weight: 400;
                                            font-size: 16px;
                                        }

                                        .code {
                                            display: block;
                                            margin: 0 0 16px 0;
                                            line-height: 14px;
                                            font-size: 14px;
                                            color: #616571;

                                            @media screen {
                                                @media (max-width: 575px) {
                                                    line-height: 10px;
                                                    font-size: 10px;
                                                }
                                            }
                                        }

                                        .delivery {
                                            > span {
                                                display: block;
                                                margin: 0 0 2px 0;
                                                font-size: 12px;
                                                font-weight: 500;
                                                line-height: 14px;
                                                letter-spacing: 0.1em;
                                                text-transform: uppercase;
                                                color: #7D8391;
                                                text-align: left;

                                                @media screen {
                                                    @media (max-width: 575px) {
                                                        margin: 0 0 8px 0;
                                                        line-height: 10px;
                                                        font-size: 10px;
                                                    }
                                                }
                                            }

                                            ul {
                                                li {
                                                    color: #616571;
                                                    
                                                    @media screen {
                                                        @media (max-width: 768px) {
                                                            display: flex;
                                                            align-items: center;
                                                            flex-wrap: wrap;

                                                            &::before {
                                                                content: '';
                                                                width: 14px;
                                                                height: 14px;
                                                                margin: 0 7px 0 0;
                                                                background: url('../../../../../resources/front/images/green-stock-icon.svg') left center no-repeat;
                                                            }
                                                        }

                                                        @media (max-width: 575px) {
                                                            line-height: 12px;
                                                            font-size: 12px;
                                                        }
                                                    }

                                                    strong, b {
                                                        font-weight: 500;
                                                        color: #0D2441
                                                    }
                                                }
                                            }
                                        }

                                        .tablet-price {
                                            margin: 15px 0 0 0;
                                            font-size: 16px;
                                            line-height: 16px;
                                            letter-spacing: 0;
                                            color: #49515A;
                                            text-align: left;

                                            @media screen {
                                                @media (min-width: 769px) {
                                                    display: none;
                                                }

                                                @media (max-width: 575px) {
                                                    display: none;
                                                }
                                            }

                                            > span {
                                                display: block;
                                                margin: 0 0 4px 0;
                                                font-size: 12px;
                                                font-weight: 500;
                                                line-height: 14px;
                                                letter-spacing: 0.1em;
                                                text-transform: uppercase;
                                                color: #7D8391;
                                            }
                                        }
                                    }
                                }

                                @media screen {
                                    @media (max-width: 768px) {
                                        padding-right: 15px;;
                                    }
                                }
                            }
                            
                            &.amount {
                                .product-qty {
                                    display: flex;
                                    width: 120px;
                                    margin: 0;
                                    border: 1px solid #D1D1DB;
                                    background: #FFF;
                                    border-radius: 8px;

                                    @media screen {
                                        @media (max-width: 575px) {
                                            margin-left: auto;
                                        }
                                    }

                                    button {
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        flex-shrink: 0;
                                        width: 40px;
                                        height: 40px;
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
                                        max-width: calc(100% - 80px);
                                        padding: 0;
                                        border: 0;
                                        font-size: 16px;
                                        font-weight: 600;
                                        color: #0D2441;
                                        text-align: center;
                                    }
                                }
                            }
                            
                            &.sum {
                                position: relative;

                                @media screen {
                                    @media (max-width: 575px) {
                                        padding-bottom: 50px;
                                    }
                                }

                                .remove {
                                    position: absolute;
                                    right: 16px;
                                    bottom: 30px;
                                    display: flex;
                                    align-items: center;
                                    padding: 0;
                                    font-size: 14px;
                                    color: #7D8391;
                                    cursor: pointer;

                                    @media screen {
                                        @media (max-width: 768px) {
                                            top: 23px;
                                            bottom: auto;
                                        }

                                        @media (max-width: 575px) {
                                            top: auto;
                                            right: 0;
                                            bottom: 23px;
                                        }
                                    }

                                    &::before {
                                        content: "";
                                        width: 12px;
                                        height: 16px;
                                        margin: 0 4px 0 0;
                                        background: url('../../../../../resources/front/images/bin-icon.svg') left center no-repeat;
                                    }

                                    &:hover {
                                        color: #E72E2C;

                                        &::before {
                                            background: url('../../../../../resources/front/images/bin-icon-hover.svg') left center no-repeat;
                                        }
                                    }
                                }
                            }
                        }

                        @media screen {
                            @media (max-width: 575px) {
                                &:first-child {
                                    td {
                                        &:first-child {
                                            padding-top: 0;
                                            border-top: 0;
                                        }
                                    }
                                }

                                &:last-child {
                                    td {
                                        &:last-child {
                                            border-bottom: 1px solid #e4e3e8;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        .summary-side {
            flex-basis: 392px;

            @media screen {
                @media (max-width: 1199px) {
                    flex-basis: 300px;
                }

                @media (max-width: 991px) {
                    flex-basis: 100%;
                }
            }

            .summary {
                width: 100%;
                padding: 24px;
                margin: 0 0 24px 0;
                background-color: #F4F4F6;
                border-radius: 8px;

                @media screen {
                    @media (max-width: 575px) {
                        padding: 16px;
                    }
                }

                .block-name { 
                    margin: 0 0 15px 0;
                    font-size: 24px;
                    line-height: 30px;
                    letter-spacing: -0.02em;
                    text-align: left;

                    @media screen {
                        @media (max-width: 575px) {
                            line-height: 26px;
                            font-size: 20px;
                        }
                    }
                }

                .price-table {
                    width: 100%;

                    tr {
                        td {
                            padding: 2px 0;
                            vertical-align: middle;

                            @media screen {
                                @media (max-width: 1199px) {
                                    font-size: 14px;
                                }
                            }

                            .no-vat {
                                font-size: 12px;
                                color: #49515A;
                            }

                            &:first-child {
                                color: #0D2441;
                            }

                            &:last-child {
                                text-align: right;
                            }
                        }
                    }
                }

                .total-price {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 24px 0;
                    font-size: 20px;
                    font-weight: 600;
                    color: #0D2441;

                    @media screen {
                        @media (max-width: 575px) {
                            padding: 20px 0;
                            font-size: 18px;
                        }
                    }
                }

                .discount-coupon {
                    margin: 14px 0 0 0;
                    border-top: 1px solid #E1E2E5;
                    border-bottom: 1px solid #E1E2E5;

                    .toggle-btn {
                        position: relative;
                        width: 100%;
                        padding: 18px 20px 18px 0;
                        font-size: 16px;
                        font-family: "Inter", sans-serif;
                        font-weight: 500;
                        color: #0D2441;
                        text-align: left;
                        cursor: pointer;

                        &::after {
                            content: '';
                            position: absolute;
                            top: 0;
                            right: 0;
                            bottom: 0;
                            margin: auto 0;
                            width: 12px;
                            height: 7px;
                            background: url('../../../../../resources/front/images/arrow-down.svg') right center no-repeat;
                            transition: all .3s ease-in-out;
                        }
                    }

                    .form-control {
                        display: none;
                        width: 100%;
                        height: 46px;
                        background-color: #fff;
                    }

                    &.opened {
                        padding-bottom: 20px;

                        .toggle-btn {
                            &::after {
                                transform: rotate(-180deg);
                            }
                        }

                        .form-control {
                            display: block;
                        }
                    }
                }

                .btn {
                    width: 100%;
                    border: 0;
                }

                .payments-logos {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 12px;
                    /* flex-wrap: wrap; */
                    margin: 16px 0 0 0;

                    @media screen {
                        @media (max-width: 575px) {
                            padding-bottom: 3px;
                        }
                    }

                    li {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        height: 24px;
                    }
                }
            }

            .text-block {
                padding: 16px 24px;
                border: 1px solid #E9EAEC;
                border-radius: 8px;

                &:not(:last-child) {
                    margin: 0 0 12px 0;
                }

                h3 {
                    margin: 0 0 8px 0;
                    line-height: 24px;
                    font-size: 18px;
                }

                .excerpt {
                    margin: 0;
                    line-height: 20px;
                    font-size: 14px;
                }

                .read-more {
                    margin: 9px 0 0 0;
                    padding: 0;
                    line-height: 14px;
                    font-size: 14px;
                    color: #0D2441;
                    cursor: pointer;
                    text-decoration: underline;

                    @media screen {
                        @media (max-width: 575px) {
                            margin: 15px 0 0 0;
                        }
                    }

                    &:hover {
                        text-decoration: none;
                    }

                    &::after {
                        content: normal;
                    }
                }
            }
        }
    }

    .related-products {
        .section-heading {
            margin: 0 0 24px 0;
        }
    }
</style>
