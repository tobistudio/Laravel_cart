<template>
    <section class="hero category" v-if="activeVehicleSearchBlock || activeVehicle.processing">
        <div class="container">
            <div class="heading-wrapper">
                <h2 class="section-heading">Izvēlies savu auto</h2>
                <p>Aizpildi nepieciešamos laukus, lai meklētu rezerves daļas kas atbilst tavam auto.</p>
            </div>

            <hero-vehicle-search :locale="locale" :vehicle_brands="vehicle_brands" :data="data" :is_category="true" ></hero-vehicle-search>
        </div>
    </section>

    <div class="container">
        <ul class="breadcrumb">
            <template v-for="(item, index) in breadcrumbs">
                <li :class="['breadcrumb-item', index === breadcrumbs.length - 1 ? 'active' : '']">
                    <span v-if="index === breadcrumbs.length - 1">{{ item.name }}</span>
                    <a :href="item.slug" v-else>{{ item.name }}</a>
                </li>
            </template>
        </ul>

        <div class="selected-vehicle" v-if="data.category.display_mode === 'products'">
            <h1 class="catalog-name">{{ data.category.name }}</h1>

            <div class="holder" v-if="activeVehicle && !activeVehicle.processing">
                <span>{{ activeVehicle.modelName + ', ' + activeVehicle.engine + ' (' + activeVehicle.power + '), ' + activeVehicle.year_range }}</span>

                <div class="action-btns">
                    <button type="button" @click="changeActiveVehicle">Mainīt</button>
                    <button type="button" @click="removeActiveVehicle">Atcelt</button>
                </div>
            </div>
        </div>
    </div>

    <template v-if="data.category.display_mode !== 'products'">
        <div class="product-category-block" v-for="category_block in data.category.blocks">
            <div class="spare-parts-catalog" v-if="category_block.key === 'block-product-categories'">
                <div class="toolbar">
                    <div class="container">
                        <div>
                            <h1 class="page-title">{{ data.category.name }}</h1>

                            <div class="selected-options" v-if="activeVehicle && !activeVehicle.processing">
                                <span>{{ activeVehicle.modelName + ', ' + activeVehicle.engine + ' (' + activeVehicle.power + '), ' + activeVehicle.year_range }}</span>
                                <div class="action-btns">
                                    <button type="button" @click="changeActiveVehicle">Mainīt</button>
                                    <button type="button" @click="removeActiveVehicle">Atcelt</button>
                                </div>
                            </div>
                        </div>

                        <div class="search-form">
                            <input type="text" name="" class="form-control" placeholder="Ātrā meklēšana">
                            <button type="submit"></button>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="categories-list">
                        <div class="col">
                            <div class="category mobile-opened">
                                <div class="block-header">
                                    <h3 class="cat-name">Dzinējs</h3>

                                    <div class="cat-image">
                                        <img src="../../../../../resources/front/images/engine-icon.png" alt="">
                                    </div>

                                    <div class="mobile-icon-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0528 7.05261C14.8102 7.05261 14.5677 7.14482 14.3826 7.32988L10 11.7132L5.61736 7.32988C5.24724 6.96039 4.64723 6.96039 4.27711 7.32988C3.90763 7.69999 3.90763 8.30001 4.27711 8.67012L9.32988 13.7229C9.69999 14.0924 10.3 14.0924 10.6701 13.7229L15.7229 8.67012C16.0924 8.30001 16.0924 7.69999 15.7229 7.32988C15.5378 7.14482 15.2953 7.05261 15.0528 7.05261Z" fill="#0D2441"/>
                                        </svg>
                                    </div>
                                </div>

                                <span class="nav-list-name">Kategorijas</span>

                                <ul class="items nav-list">
                                    <li class="item parent opened">
                                        <a href="#">
                                            <span>Gaisa kondicionēšana</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Dzinēja bloks</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Motora galva</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Dzesēšanas sistēma</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Filtri</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Degvielas sistēma</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Blīves un blīvslēgi</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Apsildes sistēma</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Aizdedzes sistēma</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Siksnas pievads</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Turbokompressors</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col">
                            <div class="category">
                                <div class="block-header">
                                    <h3 class="cat-name">Transmisija</h3>

                                    <div class="cat-image">
                                        <img src="../../../../../resources/front/images/transmisija-icon.png" alt="">
                                    </div>

                                    <div class="mobile-icon-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0528 7.05261C14.8102 7.05261 14.5677 7.14482 14.3826 7.32988L10 11.7132L5.61736 7.32988C5.24724 6.96039 4.64723 6.96039 4.27711 7.32988C3.90763 7.69999 3.90763 8.30001 4.27711 8.67012L9.32988 13.7229C9.69999 14.0924 10.3 14.0924 10.6701 13.7229L15.7229 8.67012C16.0924 8.30001 16.0924 7.69999 15.7229 7.32988C15.5378 7.14482 15.2953 7.05261 15.0528 7.05261Z" fill="#0D2441"/>
                                        </svg>
                                    </div>
                                </div>

                                <span class="nav-list-name">Kategorijas</span>

                                <ul class="items nav-list">
                                    <li class="item">
                                        <a href="#">
                                            <span>Transmisijas daļas</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Sājūgs un sajūga daļas</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Riteņu gultņi</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                            <div class="category">
                                <div class="block-header">
                                    <h3 class="cat-name">Bremžu sistēma</h3>

                                    <div class="cat-image">
                                        <img src="../../../../../resources/front/images/bremzu-sistema-icon.png" alt="">
                                    </div>

                                    <div class="mobile-icon-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0528 7.05261C14.8102 7.05261 14.5677 7.14482 14.3826 7.32988L10 11.7132L5.61736 7.32988C5.24724 6.96039 4.64723 6.96039 4.27711 7.32988C3.90763 7.69999 3.90763 8.30001 4.27711 8.67012L9.32988 13.7229C9.69999 14.0924 10.3 14.0924 10.6701 13.7229L15.7229 8.67012C16.0924 8.30001 16.0924 7.69999 15.7229 7.32988C15.5378 7.14482 15.2953 7.05261 15.0528 7.05261Z" fill="#0D2441"/>
                                        </svg>
                                    </div>
                                </div>

                                <span class="nav-list-name">Kategorijas</span>

                                <ul class="items nav-list">
                                    <li class="item parent">
                                        <a href="#">
                                            <span>Bremžu daļas</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Bremžu hidraulika</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col">
                            <div class="category">
                                <div class="block-header">
                                    <h3 class="cat-name">Piekare</h3>

                                    <div class="cat-image">
                                        <img src="../../../../../resources/front/images/piekare-icon.png" alt="">
                                    </div>


                                    <div class="mobile-icon-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0528 7.05261C14.8102 7.05261 14.5677 7.14482 14.3826 7.32988L10 11.7132L5.61736 7.32988C5.24724 6.96039 4.64723 6.96039 4.27711 7.32988C3.90763 7.69999 3.90763 8.30001 4.27711 8.67012L9.32988 13.7229C9.69999 14.0924 10.3 14.0924 10.6701 13.7229L15.7229 8.67012C16.0924 8.30001 16.0924 7.69999 15.7229 7.32988C15.5378 7.14482 15.2953 7.05261 15.0528 7.05261Z" fill="#0D2441"/>
                                        </svg>
                                    </div>
                                </div>

                                <span class="nav-list-name">Kategorijas</span>

                                <ul class="items nav-list">
                                    <li class="item parent">
                                        <a href="#">
                                            <span>Piekares daļas</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Stūres sistēma</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Amortizācijas sistēma</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                            <div class="category">
                                <div class="block-header">
                                    <h3 class="cat-name">Elektrība</h3>

                                    <div class="cat-image">
                                        <img src="../../../../../resources/front/images/elektriba-icon.png" alt="">
                                    </div>

                                    <div class="mobile-icon-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0528 7.05261C14.8102 7.05261 14.5677 7.14482 14.3826 7.32988L10 11.7132L5.61736 7.32988C5.24724 6.96039 4.64723 6.96039 4.27711 7.32988C3.90763 7.69999 3.90763 8.30001 4.27711 8.67012L9.32988 13.7229C9.69999 14.0924 10.3 14.0924 10.6701 13.7229L15.7229 8.67012C16.0924 8.30001 16.0924 7.69999 15.7229 7.32988C15.5378 7.14482 15.2953 7.05261 15.0528 7.05261Z" fill="#0D2441"/>
                                        </svg>
                                    </div>
                                </div>

                                <span class="nav-list-name">Kategorijas</span>

                                <ul class="items nav-list">
                                    <li class="item parent">
                                        <a href="#">
                                            <span>Sensori</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Slēdži</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Starteri un ģeneratori</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col">
                            <div class="category">
                                <div class="block-header">
                                    <h3 class="cat-name">Apgaismojums,
                                        stikli, virsbūve</h3>

                                    <div class="cat-image">
                                        <img src="../../../../../resources/front/images/apgaismojums-stikli-icon.png" alt="">
                                    </div>

                                    <div class="mobile-icon-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0528 7.05261C14.8102 7.05261 14.5677 7.14482 14.3826 7.32988L10 11.7132L5.61736 7.32988C5.24724 6.96039 4.64723 6.96039 4.27711 7.32988C3.90763 7.69999 3.90763 8.30001 4.27711 8.67012L9.32988 13.7229C9.69999 14.0924 10.3 14.0924 10.6701 13.7229L15.7229 8.67012C16.0924 8.30001 16.0924 7.69999 15.7229 7.32988C15.5378 7.14482 15.2953 7.05261 15.0528 7.05261Z" fill="#0D2441"/>
                                        </svg>
                                    </div>
                                </div>

                                <span class="nav-list-name">Kategorijas</span>

                                <ul class="items nav-list">
                                    <li class="item">
                                        <a href="#">
                                            <span>Apgaismojums</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Virsbūves daļas</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Stikli</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                            <div class="category">
                                <div class="block-header">
                                    <h3 class="cat-name">Universālās
                                        daļas</h3>

                                    <div class="cat-image">
                                        <img src="../../../../../resources/front/images/universalas-dalas-icon.png" alt="">
                                    </div>

                                    <div class="mobile-icon-arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0528 7.05261C14.8102 7.05261 14.5677 7.14482 14.3826 7.32988L10 11.7132L5.61736 7.32988C5.24724 6.96039 4.64723 6.96039 4.27711 7.32988C3.90763 7.69999 3.90763 8.30001 4.27711 8.67012L9.32988 13.7229C9.69999 14.0924 10.3 14.0924 10.6701 13.7229L15.7229 8.67012C16.0924 8.30001 16.0924 7.69999 15.7229 7.32988C15.5378 7.14482 15.2953 7.05261 15.0528 7.05261Z" fill="#0D2441"/>
                                        </svg>
                                    </div>
                                </div>

                                <span class="nav-list-name">Kategorijas</span>

                                <ul class="items nav-list">
                                    <li class="item parent">
                                        <a href="#">
                                            <span>Eļļas</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Akumulatori</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Tehniskie šķidrumi</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Spuldzes</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>

                                    <li class="item parent">
                                        <a href="#">
                                            <span>Paklāji</span>

                                            <div class="icon-arrow">
                                                <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.789355C0 0.991465 0.07684 1.19358 0.23106 1.34779L3.88375 4.99999L0.23106 8.65224C-0.07684 8.96064 -0.07684 9.46064 0.23106 9.76904C0.53949 10.0769 1.0395 10.0769 1.34793 9.76904L5.55855 5.55843C5.86645 5.25 5.86645 4.74999 5.55855 4.44157L1.34793 0.230925C1.0395 -0.076975 0.53949 -0.076975 0.23106 0.230925C0.07684 0.385135 0 0.587245 0 0.789355Z" fill="#0D2441"/>
                                                </svg>
                                            </div>
                                        </a>

                                        <ul class="sub-categories">
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                            <li><a href="#">Apakškategorija</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <template v-if="data.category.display_mode !== 'blocks'">
        <section class="mobile-toolbar">
            <div class="container">
                <div class="buttons-holder">
                    <div class="sorter-group opened">
                        <button type="button" class="sorter-toggle">
                            <span>Kārtot</span>
                        </button>

                        <div class="dropdown">
                            <ul class="inner-dropdown">
                                <li class="selected">Populārākie</li>
                                <li>Cena augoši</li>
                                <li>Cena dilstoši</li>
                            </ul>
                        </div>
                    </div>

                    <button type="button" class="filters-toggle">
                        <span>Filtrs <span class="amount">(0)</span></span>
                    </button>
                </div>
            </div>
        </section>

        <div class="container has-aside">
            <filters
                :categories="this.data.categories"
                :filters="this.filters"
                :productCount="products.length"
                @route-update="routeUpdate"
                @select-filter="updateFilter"
            />

            <div class="column main">
                <controls-top
                    :productCount="products.length"
                    :view="view"
                    :activeFilters="activeFilters"
                    :showPerPage="showPerPage"
                    :currentPage="currentPage"
                    :sorting="sorting"
                    :locale="locale"
                    @toggle-view="val => view = val"
                    @select-sorting="selectSorting"
                    @select-filter="updateFilter"
                    @clear-filters="clearFilters"
                    @show-per-page="updatePerPage"
                />
                <products
                    :view="view"
                    :data="products"
                    :locale="locale"
                    :showPerPage="showPerPage"
                    :currentPage="currentPage"
                />
                <controls-bottom
                    :productCount="products.length"
                    :currentPage="currentPage"
                    :pages="pages"
                    :showPerPage="showPerPage"
                    @select-page="selectPage"
                />
            </div>
        </div>
    </template>
</template>

<script>
import {defineAsyncComponent} from 'vue';


export default {
    name: 'ProductCategory',
    props: [
        'locale',
        'vehicle_brands',
        'data',
    ],
    data() {
        return {
            view: 'grid',

            category: {},

            activeVehicleSearchBlock: false,
            activeFilters: [],
            filters: [],
            products: [],
            breadcrumbs: [],

            sorting: 'id',
            showPerPage: 12,
            currentPage: 1,
            pages: 0,
        }
    },
    components: {
        heroVehicleSearch: defineAsyncComponent(() => import('./HeroVehicleSearch.vue')),
        filters: defineAsyncComponent(() => import('./productCategory/Filters.vue')),
        controlsTop: defineAsyncComponent(() => import('./productCategory/ControlsTop.vue')),
        products: defineAsyncComponent(() => import('./productCategory/Products.vue')),
        controlsBottom: defineAsyncComponent(() => import('./productCategory/ControlsBottom.vue')),
    },
    computed: {
        trans() {
            return {
                // title: this.translate('productCategory', 'title'),
            }
        },
        activeVehicle() {
            return this.$store.state.activeVehicle;
        }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        changeActiveVehicle() {
            this.activeVehicleSearchBlock = true;
        },
        removeActiveVehicle() {
            let payload = {
                active_vehicle_id: this.$store.state.activeVehicleId,
                remove: true,
                redirect: false
            };

            this.$store.dispatch('activeVehicle', payload).then((data) => {
                this.activeVehicleSearchBlock = true;
                this.$store.state.activeVehicle = {processing: true};
            })
        },
        selectPage(value) {
            this.currentPage = value;
        },
        updatePerPage(value) {
            this.pages = Math.ceil(this.products.length / value);
            this.currentPage = 1;
        },
        selectSorting(value) {
            this.sorting = value;

            const url = new URL(window.location.href);

            if (this.sorting === 'id') {
                url.searchParams.delete('sorting');
            } else {
                url.searchParams.set('sorting', this.sorting);
            }

            window.history.replaceState({}, '', url);

            this.products.sort((a, b) => {
                if (this.sorting === 'price') {
                    if (Number(a.language_page.data.price) > Number(b.language_page.data.price)) {
                        return 1;
                    } else if (Number(a.language_page.data.price) < Number(b.language_page.data.price)) {
                        return -1;
                    } else {
                        return 0;
                    }
                } else if (this.sorting === 'name') {
                    if (a.language_page.name > b.language_page.name) {
                        return 1;
                    } else if (a.language_page.name < b.language_page.name) {
                        return -1;
                    } else {
                        return 0;
                    }
                } else {
                    if (a.id > b.id) {
                        return 1;
                    } else if (a.id < b.id) {
                        return -1;
                    } else {
                        return 0;
                    }
                }
            });
        },
        async clearFilters() {
            this.activeFilters = [];

            for (let i=0; i<this.filters.length; i++) {
                for (let j=0; j<this.filters[i].values.length; j++) {
                    this.filters[i].values[j].selected = false;
                }
            }

            const url = new URL(window.location.href);

            url.searchParams.set('filters', this.activeFilters.map(el => el.valueID).join(','));
            window.history.replaceState({}, '', url);

            await this.routeUpdate({
                value: this.category.value,
            });
        },
        async updateFilter(data) {
            this.filters
                .find(el => el.id === data.attributeID)
                .values
                .find(el => el.id === data.valueID)
                .selected = data.selected;

            if (data.selected) {
                this.activeFilters.push(data);
            } else {
                const activeFilterIndex = this.activeFilters.findIndex(el => el.valueID === data.valueID);

                this.activeFilters.splice(activeFilterIndex, 1);
            }

            const url = new URL(window.location.href);

            if (this.activeFilters.length > 0) {
                url.searchParams.set('filters', this.activeFilters.map(el => el.valueID).join(','));
            } else {
                url.searchParams.delete('filters');
            }

            window.history.replaceState({}, '', url);

            await this.routeUpdate({
                value: this.category.value,
            });
        },
        async routeUpdate(category) {
            const data = await this.$store.dispatch('getCategoryProducts', {
                locale: this.locale,
                page_id: category.value,
                filters: this.activeFilters.length > 0 ? this.activeFilters.map(el => el.valueID) : null,
            });

            this.products = data.products.map(el => {
                return {
                    ...el,
                    productsToBuy: 1,
                    warehousesPopup: false,
                    selectedStorage: 0,
                }
            });
            this.category = category;
            this.breadcrumbs = data.breadcrumbs;
            this.currentPage = 1;
            this.pages = Math.ceil(this.products.length / this.showPerPage);
            this.selectSorting(this.sorting);
        }
    },
    mounted() {
        this.products = this.data.products.map(el => {
            return {
                ...el,
                productsToBuy: 1,
                warehousesPopup: false,
                selectedStorage: 0,
            }
        });
        this.breadcrumbs = this.data.breadcrumbs;
        this.filters = this.data.filters;
        this.category = { value: this.data.category.page_id };
        this.pages = Math.ceil(this.products.length / this.showPerPage);

        const urlParams = new URLSearchParams(window.location.search);

        if (urlParams.get('filters')) {
            const filters = urlParams.get('filters').split(',').map(el => Number(el));

            for (let i=0; i<this.filters.length; i++) {
                for (let j=0; j<this.filters[i].values.length; j++) {
                    if (filters.includes(this.filters[i].values[j].id)) {
                        this.activeFilters.push({
                            title: this.filters[i].values[j].translation.value,
                            attributeID: this.filters[i].id,
                            valueID: this.filters[i].values[j].id,
                            selected: true
                        });

                        this.filters[i].values[j].selected = true;
                    }
                }
            }
        }

        if (urlParams.get('sorting')) {
            this.selectSorting(urlParams.get('sorting'));
        } else {
            this.selectSorting('id');
        }
    }
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
</style>
