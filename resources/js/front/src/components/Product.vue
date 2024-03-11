<template>
    <div class="product-page">
        <div class="container">
            <ul class="breadcrumb">
                <template v-for="(item, index) in data.breadcrumbs">
                    <li :class="['breadcrumb-item', index === data.breadcrumbs.length - 1 ? 'active' : '']">
                        <span v-if="index === data.breadcrumbs.length - 1">{{ item.name }}</span>
                        <a :href="item.slug" v-else>{{ item.name }}</a>
                    </li>
                </template>
            </ul>

            <div class="product">
                <div class="left-side">
                    <div class="wrapper">
                        <div class="gallery">
                            <div class="main-image">
                                <a href="#" class="manufacturer">
                                    <img :src="data.product.manufacturer.featured_image" :alt="data.product.manufacturer.name">
                                </a>

                                <img v-if="gallery.length > 0" :src="gallery[activeImageID].img_path" alt="">

                                <div class="product-label">
                                    <div
                                        v-if="data.product.labels"
                                        v-for="label in data.product.labels"
                                        :class="`label ${label.key}`"
                                    >
                                        {{ label.name }}
                                    </div>
                                </div>
                            </div>

                            <div class="thumbnails">
                                <div
                                    v-if="gallery.length > 0"
                                    v-for="(image, index) in gallery"
                                    :class="`image ${activeImageID === index ? 'active' : ''}`"
                                    @click="activeImageID = index"
                                >
                                    <img :src="image.img_path" alt="" style="width: 80px; max-height: 120px; object-fit: cover;">
                                </div>
                            </div>
                        </div>

                        <div class="info-details">
                            <h1 class="page-title">{{ data.product.name }}</h1>
                            <span class="stock-sku">Preces kods: {{ data.product.data.sku }}</span>

                            <table class="features-table">
                                <tbody>
                                    <tr v-for="parameter in primaryParams">
                                        <td>
                                            {{ parameter.title }}
                                        </td>

                                        <td>
                                            <strong>{{ parameter.value }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="info-tabs desktop-view">
                        <ul class="nav nav-tabs">
                            <li class="nav-item" :role="activeTab !== 0 ? 'presentation' : 'none'" @click="selectTab(0)">
                                <button
                                    :class="`nav-link ${activeTab === 0 ? 'active' : ''}`"
                                    type="button"
                                    :aria-selected="activeTab === 0"
                                >
                                    {{ translate('product', 'techParams') }}
                                </button>
                            </li>

                            <li class="nav-item" :role="activeTab !== 1 ? 'presentation' : 'none'" @click="selectTab(1)">
                                <button
                                    :class="`nav-link ${activeTab === 1 ? 'active' : ''}`"
                                    type="button"
                                    :aria-selected="activeTab === 1"
                                >
                                    {{ translate('product', 'replacements') }} <span>({{ data.product.substitutes.length }})</span>
                                </button>
                            </li>

                            <li class="nav-item" :role="activeTab !== 2 ? 'presentation' : 'none'" @click="selectTab(2)">
                                <button
                                    :class="`nav-link ${activeTab === 2 ? 'active' : ''}`"
                                    type="button"
                                    :aria-selected="activeTab === 2"
                                >
                                    {{ translate('product', 'otherCodes') }}
                                </button>
                            </li>

                            <li class="nav-item" :role="activeTab !== 3 ? 'presentation' : 'none'" @click="selectTab(3)">
                                <button
                                    :class="`nav-link ${activeTab === 3 ? 'active' : ''}`"
                                    type="button"
                                    :aria-selected="activeTab === 3"
                                >
                                    {{ translate('product', 'downloads') }}
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div :class="`tab-pane fade ${activeTab === 0 ? 'active show' : ''}`">
                                <div class="groups max-height" ref="defaultParams-d">
                                    <div v-for="group in defaultParams" class="group">
                                        <div v-if="group.title" class="title">
                                            {{ group.title }}
                                        </div>

                                        <table class="features-table">
                                            <tbody>
                                            <tr v-for="parameter in group.items">
                                                <td>
                                                    {{ parameter.title }}
                                                </td>

                                                <td>
                                                    <strong>{{ parameter.value }}</strong>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <a v-if="showMoreDefaultParams" href="#" :class="`show-more ${showMoreParams.defaultParams ? 'less' : ''}`" @click="e => showMore(e, 'defaultParams-d')">
                                    {{ translate('product', showMoreParams.defaultParams ? 'showLess' : 'showMore') }}
                                </a>
                            </div>

                            <div :class="`tab-pane fade ${activeTab === 1 ? 'active show' : ''}`">
                                <div class="substitutes">
                                    <ProductSubstitute
                                        v-for="substitute in data.product.substitutes"
                                        :data="substitute"
                                        :locale="locale"
                                        :addToCart="addToCart"
                                        :languageId="data.language_id"
                                    />
                                </div>
                            </div>

                            <div :class="`tab-pane fade ${activeTab === 2 ? 'active show' : ''}`">
                                <div class="groups max-height" ref="codeParams-d">
                                    <div v-for="group in codeParams" class="group">
                                        <div v-if="group.title" class="title">
                                            {{ group.title }}
                                        </div>

                                        <table class="features-table">
                                            <tbody>
                                                <tr v-for="parameter in group.items">
                                                    <td>
                                                        {{ parameter.title }}
                                                    </td>

                                                    <td>
                                                        <strong>{{ parameter.value }}</strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <a v-if="showMoreCodeParams" href="#" :class="`show-more ${showMoreParams.codeParams ? 'less' : ''}`" @click="e => showMore(e, 'codeParams-d')">
                                    {{ translate('product', showMoreParams.codeParams ? 'showLess' : 'showMore') }}
                                </a>
                            </div>

                            <div :class="`tab-pane fade ${activeTab === 3 ? 'active show' : ''}`">
                                <div class="download-link" v-for="download in data.product.downloads">
                                    <a :href="download.file_path" download target="_blank">{{ downloadLinkName(download) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="right-side">
                    <div class="add-to-cart">
                        <div class="toggle-options">
                            <div :class="['option', priceBlock === 'store' ? 'active' : '']" @click="openPriceBlock('store')">
                                <span class="span-label">
                                    {{ translate('product', inMarket ? 'inStore' : 'notInStore') }}
                                </span>
                                <span class="value" :style="`${marketCount === 0 ? 'color: #E72E2C' : ''}`">
                                    {{ marketCount }}
                                    {{ translate('product', 'count') }}
                                </span>
                            </div>

                            <div :class="['option', priceBlock === 'warehouses' ? 'active' : '']" @click="openPriceBlock('warehouses')">
                                <span class="span-label">{{ translate('product', inStorage ? 'inStorage' : 'notInStorage') }}</span>
                                <span class="value" :style="`${inStorage ? '' : 'color: #E72E2C'}`">
                                    {{ inStorage
                                    ? `€${this.data.product.warehouse_count.filter(el => [2, 4].includes(el.warehouse.type))[0].product_price}`
                                    : '-' }}
                                </span>
                            </div>
                        </div>

                        <div class="option-content active" v-if="priceBlock === 'store'">
                            <div class="mobile-left-side">
                                <div class="price-holder">
                                    <template v-if="data.product.data.special_price">
                                        <div class="special-price">
                                            <span class="new-price">{{ '€' + data.product.data.special_price }}</span>
                                            <span class="old-price">{{ '€' + data.product.data.price }}</span>

                                            <div class="discount">
                                                <svg width="40" height="20" viewBox="0 0 40 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3.11562 2.47059C3.73441 0.975187 5.19331 0 6.81168 0H36C38.2091 0 40 1.79086 40 4V16C40 18.2091 38.2091 20 36 20H6.81168C5.19331 20 3.7344 19.0248 3.11562 17.5294L0.474643 11.1471C0.170711 10.4126 0.170711 9.58745 0.474644 8.85294L3.11562 2.47059Z" fill="#CD2C2C"/>
                                                </svg>

                                                <span>
                                                    {{ `-${Math.floor(100 - (data.product.data.special_price / data.product.data.price) * 100)}%` }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="price-without-vat">
                                            €{{ (data.product.data.special_price - (data.product.data.special_price / 100 * 21)).toFixed(2) }}
                                            ({{ translate('product', 'withoutVat') }})
                                        </div>
                                    </template>
                                    <template v-else>
                                        <span class="final-price">€{{ data.product.data.price }}</span>
                                        <span class="price-without-vat">
                                            €{{ (data.product.data.price - (data.product.data.price / 100 * 21)).toFixed(2) }}
                                            ({{ translate('product', 'withoutVat') }})
                                        </span>
                                    </template>
                                </div>

                                <div class="availability mobile-view">
                                    <span>{{ translate('product', 'available') }}:</span>

                                    <ul>
                                        <li><strong>Šodien, 23.11.</strong> (pasūtot līdz 14:00)</li>
                                        <li><strong>Rīt, 24.11.</strong> (pasūtot līdz 18:00)</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mobile-right-side">
                                <div class="mobile-available-quantity mobile-hidden">
                                    <span class="text">
                                        {{ translate('product', 'availableIn') }}
                                        {{ data.product.warehouse_count.filter(el => el.warehouse.type === 4).filter(el => el.product_count > 0).length }}
                                        {{ translate('product', 'storages') }}
                                    </span>
                                    <a href="#" class="read-more" @click="warehousesPopup = true">{{ translate('product', 'watch') }}</a>
                                </div>

                                <div class="product-qty">
                                    <button type="button" class="minus" @click="updateQty('minus')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M14.1737 6.85742C14.5524 6.85742 14.8594 7.13724 14.8594 7.48242L14.8594 8.73242C14.8594 9.0776 14.5524 9.35742 14.1737 9.35742L1.8308 9.35742C1.45209 9.35742 1.14509 9.0776 1.14509 8.73242L1.14509 7.48242C1.14509 7.13724 1.45209 6.85742 1.8308 6.85742L14.1737 6.85742Z" :fill="qty > 1 ? '#0D2441' : '#9398A3'"/>
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

                                <button type="button" class="cart-btn btn btn-primary" @click="addToCart(data.product.id, null)"><span>{{ translate('product', 'addToCart') }}</span></button>

                                <div v-if="activeProductComparing" :class="['compare-product', activeProductComparing && activeProductComparing.products.length === 3 && !activeProductComparing.active_product ? 'disabled' : '']" @click.prevent.stop="addToCompare(data.product.id)">
                                    <input type="checkbox" name="" v-model="activeProductComparing.active_product">
                                    <label>{{ 'Pievienot salīdzināšanai (' + (activeProductComparing && activeProductComparing.products.length ? activeProductComparing.products.length : '0') + '/3)' }}</label>
                                </div>
                            </div>

                            <div class="availability desktop-view">
                                <span>{{ translate('product', 'available') }}:</span>

                                <ul>
                                    <li><strong>Šodien, 23.11.</strong> (pasūtot līdz 14:00)</li>
                                    <li><strong>Rīt, 24.11.</strong> (pasūtot līdz 18:00)</li>
                                </ul>
                            </div>
                        </div>

                        <div class="option-content active" v-if="priceBlock === 'warehouses'">
                            <ProductWarehousePopup
                                :showPopup="warehousesPopup"
                                :locale="locale"
                                :warehouses="data.product.warehouse_count"
                                :languageId="data.language_id"
                                :addToCart="addToCart"
                                @closePopup="warehousesPopup = false"
                            />

                            <div class="mobile-left-side">
                                <div class="available-quantity top">
                                    <span class="text">
                                        {{ translate('product', 'availableIn') }}
                                        {{ data.product.warehouse_count.filter(el => el.warehouse.type === 4).filter(el => el.product_count > 0).length }}
                                        {{ translate('product', 'storages') }}
                                    </span>

                                    <button class="read-more" @click="warehousesPopup = true">
                                        {{ translate('product', 'watch') }}
                                    </button>
                                </div>

                                <div class="price-holder">
                                    <template v-if="data.product.data.special_price">
                                        <div class="special-price">
                                            <span class="new-price">{{ '€' + data.product.data.special_price }}</span>
                                            <span class="old-price">{{ '€' + data.product.data.price }}</span>

                                            <div class="discount">
                                                <svg width="40" height="20" viewBox="0 0 40 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3.11562 2.47059C3.73441 0.975187 5.19331 0 6.81168 0H36C38.2091 0 40 1.79086 40 4V16C40 18.2091 38.2091 20 36 20H6.81168C5.19331 20 3.7344 19.0248 3.11562 17.5294L0.474643 11.1471C0.170711 10.4126 0.170711 9.58745 0.474644 8.85294L3.11562 2.47059Z" fill="#CD2C2C"/>
                                                </svg>

                                                <span>
                                                    {{ `-${Math.floor(100 - (data.product.data.special_price / data.product.data.price) * 100)}%` }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="price-without-vat">
                                            €{{ (data.product.data.special_price - (data.product.data.special_price / 100 * 21)).toFixed(2) }}
                                            ({{ translate('product', 'withoutVat') }})
                                        </div>
                                    </template>
                                    <template v-else>
                                        <span class="final-price">€{{ data.product.data.price }}</span>
                                        <span class="price-without-vat">
                                            €{{ (data.product.data.price - (data.product.data.price / 100 * 21)).toFixed(2) }}
                                            ({{ translate('product', 'withoutVat') }})
                                        </span>
                                    </template>
                                </div>

                                <div class="availability mobile-view">
                                    <span>{{ translate('product', 'available') }}:</span>

                                    <ul>
                                        <li><strong>Šodien, 23.11.</strong> (pasūtot līdz 14:00)</li>
                                        <li><strong>Rīt, 24.11.</strong> (pasūtot līdz 18:00)</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mobile-right-side">
                                <div class="mobile-available-quantity mobile-hidden">
                                    <span class="text">
                                        {{ translate('product', 'availableIn') }}
                                        {{ data.product.warehouse_count.filter(el => el.warehouse.type === 4).filter(el => el.product_count > 0).length }}
                                        {{ translate('product', 'storages') }}
                                    </span>
                                    <a href="#" class="read-more" @click="warehousesPopup = true">
                                        {{ translate('product', 'watch') }}
                                    </a>
                                </div>

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

                                <button type="button" class="cart-btn btn btn-primary" @click="addToCart(data.product.id, null)">
                                    <span>{{ translate('product', 'addToCart') }}</span>
                                </button>

                                <div v-if="activeProductComparing" :class="['compare-product', activeProductComparing && activeProductComparing.products.length === 3 && !activeProductComparing.active_product ? 'disabled' : '']" @click="addToCompare(data.product.id)">
                                    <input type="checkbox" name="" v-model="activeProductComparing.active_product">
                                    <label>{{ 'Pievienot salīdzināšanai (' + (activeProductComparing && activeProductComparing.products ? activeProductComparing.products.length : '0' ) + '/3)' }}</label>
                                </div>
                            </div>

                            <div class="availability desktop-view">
                                <span>{{ translate('product', 'available') }}:</span>

                                <ul>
                                    <li><strong>Šodien, 23.11.</strong> (pasūtot līdz 14:00)</li>
                                    <li><strong>Rīt, 24.11.</strong> (pasūtot līdz 18:00)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="blocks-holder">
                        <div class="mobile-view-wrapper">
                            <div class="block payment-options">
                                <h4 class="block-heading">Apmaksa</h4>

                                <ul class="logos">
                                    <li>
                                        <img src="/images/front/footer-swedbank-logo.svg" alt="">
                                    </li>

                                    <li>
                                        <img src="/images/front/footer-citadele-logo.svg" alt="">
                                    </li>

                                    <li>
                                        <img src="/images/front/footer-luminor-logo.svg" alt="">
                                    </li>

                                    <li>
                                        <img src="/images/front/footer-seb-logo.svg" alt="">
                                    </li>

                                    <li>
                                        <img src="/images/front/footer-master-card-logo.svg" alt="">
                                    </li>

                                </ul>
                            </div>

                            <div class="block we-guarantee mobile-view">
                                <ul>
                                    <li>
                                        <div class="icon">
                                            <img src="../../../../../resources/front/images/single-product-we-guarantee-icon-1.svg" alt="">
                                        </div>

                                        <span>14 dienu atgriešanas tiesības</span>
                                    </li>

                                    <li>
                                        <div class="icon">
                                            <img src="../../../../../resources/front/images/single-product-we-guarantee-icon-2.svg" alt="">
                                        </div>

                                        <span>Detaļu atbilstība tavam auto</span>
                                    </li>

                                    <li>
                                        <div class="icon">
                                            <img src="../../../../../resources/front/images/single-product-we-guarantee-icon-3.svg" alt="">
                                        </div>

                                        <span>Piegāde visā Latvijas teritorijā</span>
                                    </li>

                                    <li>
                                        <div class="icon">
                                            <img src="../../../../../resources/front/images/single-product-we-guarantee-icon-4.svg" alt="">
                                        </div>

                                        <span>Profesionāla palīdzība</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="block delivery-options">
                            <h4 class="block-heading">Preču saņemšana:</h4>

                            <ul>
                                <template v-for="warehouses in warehouseGroups">
                                    <li v-for="warehouse in warehouses.filter(el => [1, 2, 4].includes(el.warehouse.type))">
                                        <div class="option">
                                            {{ warehouse.warehouse.translation.value }}
                                            <div class="tooltip">
                                                <div class="text">
                                                    <p>Pirkums līdz {{ warehouse.warehouse.deliver_price_drops_from }} € - piegāde <strong>{{ warehouse.warehouse.deliver_price }} €</strong></p>
                                                    <p>Pirkums virs {{ warehouse.warehouse.deliver_price_drops_from }} € - <strong>piegāde bez maksas</strong></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="time">
                                            {{ warehouse.warehouse.deliver_time_from_h || '0' }} h - {{ warehouse.warehouse.deliver_time_to_h || '1' }} h
                                        </div>
                                    </li>
                                </template>

                                <template v-for="groups in warehouseDeliverGroups">
                                    <li v-for="warehouse in [groups[0]]">
                                        <div class="option">
                                            {{ warehouse.group.translations.find(el => el.language_id === data.language_id).value }}
                                            <div class="tooltip">
                                                <div class="text">
                                                    <p>Pirkums līdz {{ warehouse.deliver_price_drops_from }} € - piegāde <strong>{{ warehouse.deliver_price }} €</strong></p>
                                                    <p>Pirkums virs {{ warehouse.deliver_price_drops_from }} € - <strong>piegāde bez maksas</strong></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="time">
                                            {{ warehouse.deliver_time_from_h || '0' }} h - {{ warehouse.deliver_time_to_h || '1' }} h
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>

                        <div class="block we-guarantee desktop-view">
                            <ul>
                                <li>
                                    <div class="icon">
                                        <img src="../../../../../resources/front/images/single-product-we-guarantee-icon-1.svg" alt="">
                                    </div>

                                    <span>14 dienu atgriešanas tiesības</span>
                                </li>

                                <li>
                                    <div class="icon">
                                        <img src="../../../../../resources/front/images/single-product-we-guarantee-icon-2.svg" alt="">
                                    </div>

                                    <span>Detaļu atbilstība tavam auto</span>
                                </li>

                                <li>
                                    <div class="icon">
                                        <img src="../../../../../resources/front/images/single-product-we-guarantee-icon-3.svg" alt="">
                                    </div>

                                    <span>Piegāde visā Latvijas teritorijā</span>
                                </li>

                                <li>
                                    <div class="icon">
                                        <img src="../../../../../resources/front/images/single-product-we-guarantee-icon-4.svg" alt="">
                                    </div>

                                    <span>Profesionāla palīdzība</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="info-tabs tablet-view">
                    <ul class="nav nav-tabs">
                        <li class="nav-item" :role="activeTab !== 0 ? 'presentation' : 'none'" @click="selectTab(0)">
                            <button
                                :class="`nav-link ${activeTab === 0 ? 'active' : ''}`"
                                type="button"
                                :aria-selected="activeTab === 0"
                            >
                                {{ translate('product', 'techParams') }}
                            </button>
                        </li>

                        <li class="nav-item" :role="activeTab !== 1 ? 'presentation' : 'none'" @click="selectTab(1)">
                            <button
                                :class="`nav-link ${activeTab === 1 ? 'active' : ''}`"
                                type="button"
                                :aria-selected="activeTab === 1"
                            >
                                {{ translate('product', 'replacements') }} <span>({{ data.product.substitutes.length }})</span>
                            </button>
                        </li>

                        <li class="nav-item" :role="activeTab !== 2 ? 'presentation' : 'none'" @click="selectTab(2)">
                            <button
                                :class="`nav-link ${activeTab === 2 ? 'active' : ''}`"
                                type="button"
                                :aria-selected="activeTab === 2"
                            >
                                {{ translate('product', 'otherCodes') }}
                            </button>
                        </li>

                        <li class="nav-item" :role="activeTab !== 3 ? 'presentation' : 'none'" @click="selectTab(3)">
                            <button
                                :class="`nav-link ${activeTab === 3 ? 'active' : ''}`"
                                type="button"
                                :aria-selected="activeTab === 3"
                            >
                                {{ translate('product', 'downloads') }}
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div :class="`tab-pane fade ${activeTab === 0 ? 'active show' : ''}`">
                            <div class="groups max-height" ref="defaultParams-t">
                                <div v-for="group in defaultParams" class="group">
                                    <div v-if="group.title" class="title">
                                        {{ group.title }}
                                    </div>

                                    <table class="features-table">
                                        <tbody>
                                            <tr v-for="parameter in group.items">
                                                <td>
                                                    {{ parameter.title }}
                                                </td>

                                                <td>
                                                    <strong>{{ parameter.value }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <a v-if="showMoreDefaultParams" href="#" :class="`show-more ${showMoreParams.defaultParams ? 'less' : ''}`" @click="e => showMore(e, 'defaultParams-t')">
                                {{ translate('product', showMoreParams.defaultParams ? 'showLess' : 'showMore') }}
                            </a>
                        </div>

                        <div :class="`tab-pane fade ${activeTab === 1 ? 'active show' : ''}`">
                            <div class="substitutes">
                                <ProductSubstitute
                                    v-for="substitute in data.product.substitutes"
                                    :data="substitute"
                                    :locale="locale"
                                    :addToCart="addToCart"
                                    :languageId="data.language_id"
                                />
                            </div>
                        </div>

                        <div :class="`tab-pane fade ${activeTab === 2 ? 'active show' : ''}`">
                            <div class="groups max-height" ref="codeParams-t">
                                <div v-for="group in codeParams" class="group">
                                    <div v-if="group.title" class="title">
                                        {{ group.title }}
                                    </div>

                                    <table class="features-table">
                                        <tbody>
                                            <tr v-for="parameter in group.items">
                                                <td>
                                                    {{ parameter.title }}
                                                </td>

                                                <td>
                                                    <strong>{{ parameter.value }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <a v-if="showMoreCodeParams" href="#" :class="`show-more ${showMoreParams.codeParams ? 'less' : ''}`" @click="e => showMore(e, 'codeParams-t')">
                                {{ translate('product', showMoreParams.codeParams ? 'showLess' : 'showMore') }}
                            </a>
                        </div>

                        <div :class="`tab-pane fade ${activeTab === 3 ? 'active show' : ''}`">
                            <div class="download-link" v-for="download in data.product.downloads">
                                <a :href="download.file_path" download target="_blank">{{ downloadLinkName(download) }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-tabs mobile-view">
                    <div :class="`tab-item ${activeTab === 0 ? 'active' : ''}`">
                        <button @click="selectTab(0)" class="tab-toggle">{{ translate('product', 'techParams') }}</button>

                        <div class="tab-content">
                            <div class="groups max-height" ref="defaultParams-m">
                                <div v-for="group in defaultParams" class="group">
                                    <div v-if="group.title" class="title">
                                        {{ group.title }}
                                    </div>

                                    <table class="features-table">
                                        <tbody>
                                            <tr v-for="parameter in group.items">
                                                <td>
                                                    {{ parameter.title }}
                                                </td>

                                                <td>
                                                    <strong>{{ parameter.value }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <a v-if="showMoreDefaultParams" href="#" :class="`show-more ${showMoreParams.defaultParams ? 'less' : ''}`" @click="e => showMore(e, 'defaultParams-m')">
                                {{ translate('product', showMoreParams.defaultParams ? 'showLess' : 'showMore') }}
                            </a>
                        </div>
                    </div>

                    <div :class="`tab-item ${activeTab === 1 ? 'active' : ''}`">
                        <button @click="selectTab(1)" class="tab-toggle">{{ translate('product', 'replacements') }} <span>({{ data.product.substitutes.length }})</span></button>

                        <div class="tab-content">
                            <div class="substitutes">
                                <ProductSubstitute
                                    v-for="substitute in data.product.substitutes"
                                    :data="substitute"
                                    :locale="locale"
                                    :addToCart="addToCart"
                                    :languageId="data.language_id"
                                />
                            </div>
                        </div>
                    </div>

                    <div :class="`tab-item ${activeTab === 2 ? 'active' : ''}`">
                        <button @click="selectTab(2)" class="tab-toggle">{{ translate('product', 'otherCodes') }}</button>

                        <div class="tab-content">
                            <div class="groups max-height" ref="codeParams-m">
                                <div v-for="group in codeParams" class="group">
                                    <div v-if="group.title" class="title">
                                        {{ group.title }}
                                    </div>

                                    <table class="features-table">
                                        <tbody>
                                            <tr v-for="parameter in group.items">
                                                <td>
                                                    {{ parameter.title }}
                                                </td>

                                                <td>
                                                    <strong>{{ parameter.value }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <a v-if="showMoreCodeParams" href="#" :class="`show-more ${showMoreParams.codeParams ? 'less' : ''}`" @click="e => showMore(e, 'codeParams-m')">
                                {{ translate('product', showMoreParams.codeParams ? 'showLess' : 'showMore') }}
                            </a>
                        </div>
                    </div>

                    <div :class="`tab-item ${activeTab === 3 ? 'active' : ''}`">
                        <button @click="selectTab(3)" class="tab-toggle">{{ translate('product', 'downloads') }}</button>

                        <div class="tab-content">
                            <div class="download-link" v-for="download in data.product.downloads">
                                <a :href="download.file_path" download target="_blank">{{ downloadLinkName(download) }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="popular-products">
            <div class="container">
                <h2 class="section-heading">Populāri produkti</h2>

                <div class="products-swiper-wrapper">
                    <div class="swiper products-swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide" v-for="popular_product in data.popular_products">
                                <div class="product-card">
                                    <a :href="popular_product.slug" class="manufacturer" v-if="popular_product.manufacturer">
                                        <img :src="popular_product.manufacturer.image" :alt="popular_product.manufacturer.name">
                                    </a>

                                    <a :href="popular_product.slug" class="image">
                                        <img :src="popular_product.image" :alt="popular_product.name">

                                        <div class="product-label" v-if="popular_product.labels.length > 0">
                                            <div v-for="label in popular_product.labels" :class="['label', label.key]">{{ label.name }}</div>
                                        </div>
                                    </a>

                                    <div class="details">
                                        <h3 class="name">
                                            <a :href="popular_product.slug">{{ popular_product.name }}</a>
                                        </h3>

                                        <div class="product-code">Preces kods: {{ popular_product.sku }}</div>

                                        <div class="stock-ability outgoing">Atlicis noliktavā: 5</div>

                                        <div class="delivery-time">Saņem: <strong>Rīt, 22.08.2023</strong> (Jelgava)</div>

                                        <div class="price">
                                            <template v-if="popular_product.special_price">
                                                <span class="new-price">{{ '€' + popular_product.special_price }}</span>
                                                <span class="old-price">{{ '€' + popular_product.price }}</span>

                                                <span class="discount">{{ '-' + popular_product.discount_percentage + '%' }}</span>
                                            </template>
                                            <template v-else>
                                                {{ '€' + popular_product.price }}
                                            </template>
                                        </div>

                                        <div class="add-to-cart">
                                            <div class="form">

                                                <div v-if="activeProductComparing" :class="['form-group', 'd-flex', 'checkbox', activeProductComparing && activeProductComparing.products.length === 3 && !activeProductComparing.active_product ? 'disabled' : '']" @click="addToCompare(popular_product.id)">
                                                    <input id="compare-1" name="checkbox" type="checkbox" v-model="activeProductComparing.active_product">
                                                    <label for="compare-1">{{ 'Pievienot salīdzināšanai (' + (activeProductComparing && activeProductComparing.products ? activeProductComparing.products.length : '0' ) + '/3)' }}</label>
                                                </div>

                                                <button type="button" class="cart-btn btn btn-primary" @click="addToCart(popular_product.id, 1)">Ielikt grozā</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ProductSubstitute from '@/js/front/src/components/ProductSubstitute.vue';
import ProductWarehousePopup from '@/js/front/src/components/ProductWarehousePopup.vue';


export default {
    name: 'Product',
    components: {
        ProductWarehousePopup,
        ProductSubstitute,
    },
    props: ['data', 'locale'],
    data() {
        return {
            priceBlock: 'store',
            warehousesPopup: false,
            gallery: [],
            warehouseGroups: [],
            warehouseDeliverGroups: [],
            activeImageID: 0,
            activeTab: 0,

            comparing: false,
            comparingCount: 0,

            qty: 1,
            productStorageCartCount: {},
            showMoreParams: {
                defaultParams: false,
                codeParams: false,
            }
        }
    },
    computed: {
        primaryParams() {
            const result = [];

            for (let i=0; i<this.data.product.parameters.length; i++) {
                const params = this.data.product.parameters[i].items.filter(el => el.is_primary);

                for (let j=0; j<params.length; j++) {
                    result.push(params[j]);
                }
            }

            return result;
        },
        defaultParams() {
            const result = [];

            for (let i=0; i<this.data.product.parameters.length; i++) {
                const items = this.data.product.parameters[i].items.filter(el => el.type.value === 1);

                if (items.length > 0) {
                    result.push({
                        title: this.data.product.parameters[i].title,
                        items,
                    });
                }
            }

            return result;
        },
        codeParams() {
            const result = [];

            for (let i=0; i<this.data.product.parameters.length; i++) {
                const items = this.data.product.parameters[i].items.filter(el => el.type.value === 2);

                if (items.length > 0) {
                    result.push({
                        title: this.data.product.parameters[i].title,
                        items,
                    });
                }
            }

            return result;
        },
        showMoreDefaultParams() {
            return this.defaultParams[0] && (this.defaultParams.length > 1 || this.defaultParams[0].items.length > 7);
        },
        showMoreCodeParams() {
            return this.codeParams[0] && (this.codeParams.length > 1 || this.codeParams[0].items.length > 7);
        },
        activeCart() {
            return this.$store.state.activeCart;
        },
        activeProductComparing() {
            return this.$store.state.activeProductComparing;
        },
        inMarket() {
            return this.data.product.warehouse_count.filter(el => el.warehouse.type === 1).reduce(
                (accumulator, currentValue) => accumulator.product_count + currentValue.product_count,
                { product_count: 0 }
            ) > 0
        },
        inStorage() {
            return this.data.product.warehouse_count.filter(el => [2, 4].includes(el.warehouse.type)).reduce(
                (accumulator, currentValue) => accumulator.product_count + currentValue.product_count,
                { product_count: 0 }
            ) > 0
        },
        marketCount() {
            const count = this.data.product.warehouse_count.filter(el => el.warehouse.type === 1).reduce(
                (accumulator, currentValue) => accumulator.product_count + currentValue.product_count,
                { product_count: 0 });

            return count > 0 ? count : 0;
        },
    },
    methods: {
        downloadLinkName(download) {
            if (download.translation && download.translation.value.trim() !== '') {
                return download.translation.value
            } else {
                const totalSlices = download.file_path.split('/').length;

                return download.file_path.split('/')[totalSlices - 1];
            }
        },
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        addToCart(product_id, qty) {
            let payload = {
                id: this.$store.state.activeCartId,
                locale: this.locale,
                product_id: product_id,
                qty: qty ? qty : this.qty,
            };

            this.$store.dispatch('addToCart', payload).then((data) => {
                this.$store.state.activeCart = {
                    id: data.cart.id,
                    total: data.cart.total,
                    currency: data.cart.currency,
                    products: data.cart.products,
                    urls: data.cart.urls ? data.cart.urls : this.$store.state.activeCart.urls,
                };
            });
        },
        updateQty(type) {
            if(type === 'plus'){
                if (this.qty < this.marketCount) {
                    this.qty += 1;
                }
            } else if(type === 'minus'){
                if(this.qty >= 2) {
                    this.qty -= 1;
                }
            } else {
                if(this.qty <= 0){
                    this.qty = 1;
                }
            }
        },
        addToCompare(product_id) {
            let payload = {
                id: this.activeProductComparing && this.activeProductComparing.id ? this.activeProductComparing.id : null,
                locale: this.locale,
                product_id: product_id
            };

            if(this.activeProductComparing.active_product) {
                this.$store.dispatch('removeProductFromProductCompare', payload)
                    .then((data) => {
                        this.$store.state.activeProductComparing = {
                            id: data.comparing.id,
                            open: true,
                            products: data.comparing.products,
                            urls: data.comparing.urls
                        }

                        if (this.activeProductComparing && this.activeProductComparing.id) {
                            if (this.activeProductComparing.products) {
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
            } else {
                if(this.activeProductComparing.products.length < 3) {
                    this.$store.dispatch('addToCompare', payload)
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
                        });
                }
            }
        },
        openPriceBlock(value) {
            this.priceBlock = value;
        },
        selectTab(index) {
            this.activeTab = index;
        },
        showMore(e, type) {
            e.preventDefault();
            const newType = type.split('-')[0];

            this.$refs[type].style.maxHeight = this.showMoreParams[newType] ? '' : '100%';
            this.showMoreParams[newType] = !this.showMoreParams[newType];
        },
    },
    mounted() {
        this.warehouseGroups = this.data.product.warehouse_count.reduce((groups, item) => ({
            ...groups,
            [item.warehouse.group.id]: [...(groups[item.warehouse.group.id] || []), item]
        }), {});
        this.warehouseDeliverGroups = this.data.product.warehouse_delivers.reduce((groups, item) => ({
            ...groups,
            [item.group.id]: [...(groups[item.group.id] || []), item]
        }), {});

        for (let i=0; i<this.data.product.warehouse_count.length; i++) {
            this.productStorageCartCount[this.data.product.warehouse_count[i].id] = {
                product_to_buy: 0,
            };
        }

        if (this.data.product.featured_image) {
            this.gallery = [
                {
                    key: -1,
                    img_path: this.data.product.featured_image,
                },
                ...this.data.product.gallery,
            ];
        } else {
            this.gallery = this.data.product.gallery;
        }

        if(this.activeProductComparing && this.activeProductComparing.id && this.activeProductComparing.products){
            let findProductIndex = this.activeProductComparing.products.findIndex(product => product.id === this.data.product.id);
            if (findProductIndex >= 0) {
                this.activeProductComparing.active_product = true;
            }
        } else {
            this.$store.state.activeProductComparing = {
                id: null,
                open: false,
                products: [],
                urls: null
            };
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

    .breadcrumb {
        @media screen {
            @media (max-width: 575px) {
                margin: 0 0 33px 0;
            }
        }
    }

    .product-page {
        .product {
            display: flex;
            gap: 0 64px;

            @media screen {
                @media (max-width: 1199px) {
                    gap: 0 40px;
                }

                @media (max-width: 991px) {
                    flex-direction: column;
                    gap: 40px 0;
                }
            }

            .left-side {
                @media screen {
                    @media (max-width: 991px) {
                        width: 100%;
                    }
                }

                .wrapper {
                    display: flex;
                    gap: 0 24px;
                    margin-bottom: 64px;

                    @media screen {
                        @media (max-width: 991px) {
                            gap: 0 55px;
                            margin: 0;
                        }

                        @media (max-width: 680px) {
                            gap: 0 30px;
                        }

                        @media (max-width: 575px) {
                            flex-direction: column;
                            gap: 0;
                        }
                    }
                }

                .gallery {
                    flex-shrink: 0;
                    width: 392px;

                    @media screen {
                        @media (max-width: 1199px) {
                            width: 50%;
                        }

                        @media (max-width: 991px) {
                            width: 249px;
                        }

                        @media (max-width: 575px) {
                            display: flex;
                            align-items: flex-start;
                            width: 100%;
                            gap: 0 8px;
                            margin: 0 0 24px 0;
                        }
                    }

                    .main-image {
                        position: relative;
                        margin: 0 0 12px 0;
                        background: #fff;
                        border-radius: 8px;

                        @media screen {
                            @media (min-width: 1200px) {
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                height: 392px;
                            }

                            @media (max-width: 991px) {
                                margin: 0 0 10px 0;
                            }

                            @media (max-width: 575px) {
                                flex-grow: 1;
                            }
                        }

                        .manufacturer {
                            position: absolute;
                            top: 20px;
                            left: 20px;
                        }

                        .product-label {
                            position: absolute;
                            left: 16px;
                            bottom: 16px;
                            display: flex;

                            @media screen {
                                @media (max-width: 575px) {
                                    left: 12px;
                                    bottom: 12px;
                                }
                            }

                            .label {
                                padding: 6px 8px;
                                margin: 0;
                                line-height: 10px;
                                letter-spacing: 0.4px;
                                font-weight: 600;
                                font-size: 10px;
                                color: #FFF;
                                text-transform: uppercase;
                                border-radius: 4px;
                                margin-right: 5px;

                                &.bg-orange {
                                    background: #F06D23;
                                }

                                &.bg-red {
                                    background: #E72E2C;
                                }
                            }
                        }
                    }

                    .thumbnails {
                        display: flex;
                        gap: 0 10px;

                        @media screen {
                            @media (max-width: 575px) {
                                flex-shrink: 0;
                                width: 82px;
                                flex-direction: column;
                                gap: 8px 0;
                            }
                        }

                        .image {
                            display: flex;
                            opacity: .6;
                            outline: 1px solid transparent;
                            cursor: pointer;
                            transition: all .3s ease-in-out;
                            border-radius: 8px;

                            img {
                                border-radius: 8px;
                            }

                            &:hover {
                                opacity: 1;
                            }

                            &.active {
                                opacity: 1;
                                outline-color: #7D8391;
                                pointer-events: none;
                            }
                        }
                    }
                }

                .info-details {
                    flex-grow: 1;
                    font-size: 14px;

                    .page-title {
                        margin: 0 0 8px 0;
                        font-size: 30px;
                        line-height: 36px;
                        letter-spacing: -0.6px;

                        @media screen {
                            @media (max-width: 991px) {
                                font-size: 26px;
                                line-height: 32px;
                                letter-spacing: -0.52px;
                            }

                            @media (max-width: 575px) {
                                margin: 0 0 3px 0;
                            }
                        }
                    }

                    .stock-sku {
                        display: block;

                        @media screen {
                            @media (min-width: 576px) {
                                padding: 0 0 18px 0;
                                margin: 0 0 16px 0;
                                border-bottom: 1px solid #E9EAEC;
                            }

                            @media (max-width: 575px) {
                                margin: 0 0 20px 0;
                            }
                        }
                    }

                    .features-table {
                        width: 100%;

                        tr {
                            td {
                                padding: 2px 0;
                                width: 50%;
                                border: 0;
                                border-bottom: 1px dashed #E9EAEC;
                                vertical-align: middle;

                                @media screen {
                                    @media (max-width: 575px) {
                                        font-size: 12px;
                                    }
                                }

                                strong {
                                    font-weight: 500;
                                    color: #0D2441;
                                }

                                &:last-child {
                                    text-align: right;
                                }
                            }

                            &:last-child {
                                td {
                                    border-bottom: 0;
                                }
                            }
                        }
                    }
                }
            }

            .right-side {
                @media screen {
                    @media (min-width: 992px) {
                        flex-shrink: 0;
                        width: 288px;
                    }
                }

                .option-content {
                    display: none;

                    &.active {
                        display: block;

                        @media screen {
                            @media (max-width: 991px) {
                                display: flex;
                                width: 100%;
                            }

                            @media (max-width: 575px) {
                                flex-direction: column;
                            }
                        }
                    }
                }

                .add-to-cart {
                    padding: 24px;
                    background: #F4F5F7;
                    border: 1px solid #EBEBEF;
                    border-radius: 12px;

                    @media screen {
                        @media (max-width: 991px) {
                            padding: 32px;
                        }

                        @media (max-width: 680px) {
                            padding: 16px;
                        }
                    }

                    .toggle-options {
                        display: flex;
                        padding: 4px;
                        gap: 0 4px;
                        margin: 0 0 22px 0;
                        background: #EAECF0;
                        border: 1px solid #E8E8ED;
                        box-shadow: 0px 1px 4px 0px rgba(84, 96, 110, 0.15) inset;
                        border-radius: 8px;

                        @media screen {
                            @media (max-width: 991px) {
                                width: 100%;
                                margin: 0 0 32px 0;
                            }

                            @media (max-width: 575px) {
                                margin: 0 0 22px 0;
                            }
                        }

                        .option {
                            display: flex;
                            flex-direction: column;
                            justify-content: center;
                            width: 50%;
                            padding: 6px 0;
                            border-top: 1.5px solid transparent;
                            cursor: pointer;
                            border-radius: 6px;
                            transition: all .3s ease-in-out;

                            span {
                                display: block;
                                color: #616571;
                                font-weight: 500;
                                text-align: center;
                                transition: all .3s ease-in-out;

                                &.span-label {
                                    margin: 0 0 2px 0;
                                    line-height: 14px;
                                    font-size: 14px;
                                }

                                &.value {
                                    line-height: 12px;
                                    font-size: 12px;
                                }
                            }

                            &.active, &:hover {
                                background: #FAFAFA;
                                border-color: #FFF;
                                box-shadow: 1px 2px 6px 0px rgba(102, 116, 133, 0.15);

                                span {
                                    &.span-label {
                                        color: #0D2441;
                                    }

                                    &.value {
                                        color: #1F8C31;
                                    }
                                }
                            }

                            &.active {
                                pointer-events: none;
                            }
                        }
                    }

                    .price-holder {
                        margin: 0 0 1.5rem 0;

                        .final-price,
                        .price-without-vat {
                            display: block;
                        }

                        & > .special-price {
                            display: flex;
                            align-items: center;

                            & > .new-price {
                                font-size: 24px;
                                font-weight: 700;
                                line-height: 24px;
                                color: #CD2C2C;
                            }

                            & > .old-price {
                                font-size: 14px;
                                font-weight: 400;
                                line-height: 14px;
                                color: #616571;
                                text-decoration: line-through;
                                margin-left: .5rem;
                            }

                            & > .discount {
                                position: relative;
                                margin-left: .75rem;

                                & > span {
                                    position: absolute;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    top: 4px;
                                    left: 0;
                                    width: 40px;
                                    font-size: 12px;
                                    font-weight: 600;
                                    line-height: 12px;
                                    color: #FAFAFA;
                                }
                            }
                        }

                        & > .final-price {
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
                            }
                        }

                        .price-without-vat {
                            color: #49515A;
                            font-size: 14px;
                            line-height: 14px;
                            margin-top: .25rem;

                            @media screen {
                                @media (max-width: 575px) {
                                    font-size: 12px;
                                    line-height: 12px;
                                }
                            }
                        }
                    }

                    .product-qty {
                        display: flex;
                        margin: 0 0 8px 0;
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
                            max-width: calc(100% - 96px);
                            padding: 0;
                            border: 0;
                            font-size: 18px;
                            font-weight: 600;
                            color: #0D2441;
                            text-align: center;
                        }
                    }

                    .available-quantity.top {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        margin: 0 0 26px 0;
                        font-size: 14px;

                        .text {
                            display: flex;
                            align-items: center;
                            gap: 0 6px;
                            line-height: 14px;
                            color: #0D2441;

                            &::before {
                                content: '';
                                width: 18px;
                                height: 18px;
                                background: url('../../../../../resources/front/images/fi_6161944.svg') center center no-repeat;
                            }
                        }

                        .read-more {
                            font-size: 11px;
                            letter-spacing: 0.44px;
                            text-transform: uppercase;
                            cursor: pointer;

                            &:hover {
                                text-decoration: underline;
                            }

                            &::after {
                                content: none;
                            }
                        }

                        @media screen {
                            @media (max-width: 991px) AND (min-width: 576px) {
                                display: none;
                            }
                        }
                    }

                    .mobile-available-quantity {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        margin: 0 0 16px 0;
                        font-size: 14px;

                        .text {
                            display: flex;
                            align-items: center;
                            gap: 0 6px;
                            line-height: 14px;
                            color: #0D2441;

                            &::before {
                                content: '';
                                width: 18px;
                                height: 18px;
                                background: url('../../../../../resources/front/images/fi_6161944.svg') center center no-repeat;
                            }
                        }

                        .read-more {
                            font-size: 11px;
                            letter-spacing: 0.44px;
                            text-transform: uppercase;

                            &:hover {
                                text-decoration: underline;
                            }

                            &::after {
                                content: none;
                            }
                        }

                        @media screen {
                            @media (min-width: 992px) {
                                display: none;
                            }
                        }
                    }

                    .cart-btn {
                        width: 100%;
                        margin: 0 0 22px 0;
                        padding: 11px 15px;
                        border-bottom: 2px solid #931211;

                        @media screen {
                            @media (max-width: 991px) {
                                margin: 0 0 16px 0;
                            }
                        }

                        span {
                            display: flex;
                            align-items: center;
                            justify-content: center;

                            &::before {
                                content: '';
                                width: 25px;
                                height: 24px;
                                margin: 0 8px 0 0;
                                background: url('../../../../../resources/front/images/add-to-cart-icon-white-2.svg') center center no-repeat;
                            }
                        }

                        &:hover {
                            background-color: #0D2441;
                            border-color: #0D2441;
                        }
                    }

                    .compare-product {
                        display: flex;
                        align-items: center;
                        padding: 0 0 24px 0;
                        margin: 0 0 24px 0;
                        border-bottom: 1px solid #E1E2E5;

                        @media screen {
                            @media (max-width: 991px) AND (min-width: 576px) {
                                padding: 0;
                                margin: 0;
                                border: 0;
                            }

                            @media (max-width: 575px) {
                                padding: 0 0 21px 0;
                            }
                        }

                        input[type=checkbox] {
                            position: relative;
                            top: -2px;
                            width: 18px;
                            height: 18px;
                            border-color: #616571;
                            background-color: #f4f5f7;
                        }

                        input[type=checkbox] + label {
                            color: #0D2441;
                        }

                        input[type=checkbox]:checked {
                            background-color: #0D2441;
                            border-color: #0D2441;
                        }

                        &.disabled {
                            input[type=checkbox] {
                                cursor: not-allowed;
                                background-color: #9b9da0;
                                border-color: #9b9da0;
                            }

                            input[type=checkbox] + label {
                                color: #9b9da0;
                                cursor: not-allowed;
                            }
                        }
                    }

                    .availability {
                        padding-right: 5px;

                        &.mobile-view {
                            @media screen {
                                @media (min-width: 992px) {
                                    display: none;
                                }

                                @media (max-width: 575px) {
                                    display: none;
                                }
                            }
                        }

                        &.desktop-view {
                            @media screen {
                                @media (max-width: 991px) {
                                    display: none;
                                }

                                @media (max-width: 575px) {
                                    display: block;
                                }
                            }
                        }

                        > span {
                            display: block;
                            margin: 0 0 12px 0;
                            color:#616571;
                            font-size: 12px;
                            font-weight: 500;
                            line-height: 14px;
                            letter-spacing: 1.2px;
                            text-transform: uppercase;

                            @media screen {
                                @media (max-width: 575px) {

                                }
                            }
                        }

                        ul {
                            li {
                                line-height: 16px;
                                font-size: 14px;
                                color: #454851;

                                @media screen {
                                    @media (max-width: 575px) {
                                        /* line-height: 12px;
                                        font-size: 12px; */
                                    }
                                }

                                &:not(:last-child) {
                                    margin-bottom: 6px;
                                }

                                strong {
                                    font-weight: 500;
                                    color: #0D2441;
                                }
                            }
                        }
                    }

                    .mobile-left-side {
                        .mobile-available-quantity {
                            &.desktop-hidden {
                                @media screen {
                                    @media (min-width: 576px) {
                                        display: none;
                                    }
                                }
                            }

                            &.mobile-hidden {
                                @media screen {
                                    @media (max-width: 575px) {
                                        display: none !important;
                                    }
                                }
                            }
                        }
                    }

                    .mobile-right-side {
                        .mobile-available-quantity {
                            &.mobile-hidden {
                                @media screen {
                                    @media (max-width: 575px) {
                                        display: none;
                                    }
                                }
                            }
                        }
                    }

                    @media screen {
                        @media (max-width: 991px) AND (min-width: 576px) {
                            display: flex;
                            flex-wrap: wrap;

                            .mobile-left-side {
                                width: 50%;
                            }

                            .mobile-right-side {
                                width: 50%;
                            }
                        }
                    }
                }

                .blocks-holder {
                    @media screen {
                        @media (max-width: 991px) AND (min-width: 576px) {
                            display: flex;
                            gap: 0 88px;
                            padding: 8px 0 30px 0;

                            .mobile-view-wrapper {
                                width: 50%;

                                .block {
                                    width: 100%;
                                }
                            }
                        }
                    }
                }

                .block {
                    padding: 24px 0;
                    font-size: 14px;

                    @media screen {
                        @media (max-width: 991px) AND (min-width: 576px) {
                            width: 50%;
                        }
                    }

                    &:not(:last-child) {
                        border-bottom: 1px solid #E9EAEC;
                    }

                    .block-heading {
                        margin: 0 0 12px 0;
                        font-size: 12px;
                        font-weight: 500;
                        line-height: 14px;
                        letter-spacing: 1.2px;
                        color: #616571;
                        text-transform: uppercase;
                    }

                    &.payment-options {
                        .logos {
                            display: flex;
                            align-items: center;
                            flex-wrap: wrap;
                            gap: 8px 12px;

                            li {
                                display: flex;
                                align-items: center;

                                img {
                                    max-height: 18px;
                                }
                            }
                        }
                    }

                    &.delivery-options {
                        @media screen {
                            @media (max-width: 991px) AND (min-width: 576px) {
                                padding-bottom: 0;
                                border-bottom: 0;
                            }
                        }

                        ul {
                            li {
                                &:not(:last-child) {
                                    margin-bottom: 12px;
                                }

                                div:not(.text) {
                                    display: flex;
                                    justify-content: start;
                                    align-items: baseline;
                                    line-height: 20px;

                                    & > .tooltip {
                                        margin-left: .5rem;
                                    }

                                    &.option {
                                        font-weight: 500;
                                        color: #0D2441;
                                    }

                                    &.time {
                                        color: #585D68;
                                    }
                                }
                            }
                        }
                    }

                    &.we-guarantee {
                        &.mobile-view {
                            @media screen {
                                @media (min-width: 992px) {
                                    display: none;
                                }

                                @media (max-width: 575px) {
                                    display: none;
                                }
                            }
                        }

                        &.desktop-view {
                            @media screen {
                                @media (max-width: 991px) {
                                    display: none;
                                }

                                @media (max-width: 575px) {
                                    display: block;
                                    padding-bottom: 8px;
                                }
                            }
                        }

                        li {
                            display: flex;
                            align-items: center;
                            gap: 0 8px;
                            line-height: 16px;
                            color: #0D2441;

                            &:not(:last-child) {
                                margin-bottom: 12px;
                            }

                            .icon {
                                flex-shrink: 0;
                                width: 24px;
                                height: 24px;
                                pointer-events: none;
                            }
                        }
                    }
                }
            }

            .info-tabs {
                table {
                    width: 100%;

                    &.features-table {
                        border-collapse: collapse;
                        border-spacing: 0;

                        &.codes {
                            tbody {
                                tr {
                                    td {
                                        &:last-of-type {
                                            strong {
                                                color: #E72E2C;
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        tbody {
                            tr {
                                td {
                                    padding: 11px 16px;

                                    @media screen {
                                        @media (max-width: 575px) {
                                            padding: 7px 12px;
                                            font-size: 12px;
                                        }
                                    }

                                    strong, b {
                                        font-weight: 500;
                                        color: #0D2441;
                                    }

                                    &:last-child {
                                        text-align: right;
                                    }
                                }

                                &:nth-child(2n+0) {
                                    td {
                                        background: #F1F2F3;
                                    }
                                }
                            }
                        }
                    }
                }

                &.desktop-view {
                    @media screen {
                        @media (max-width: 991px) {
                            display: none;
                        }
                    }
                }

                &.tablet-view {
                    @media screen {
                        @media (min-width: 992px) {
                            display: none;
                        }

                        @media (max-width: 575px) {
                            display: none;
                        }
                    }
                }

                .nav-tabs {
                    display: flex;
                    gap: 0 24px;
                    border-bottom: 1px solid #e9eaec;

                    .nav-item {
                        margin-bottom: -1px;

                        .nav-link {
                            padding: 8px 16px;
                            border-bottom: 2px solid transparent;
                            color: #4B4B62;
                            font-size: 16px;
                            cursor: pointer;
                            transition: all 0.3s ease-in-out;

                            @media screen {
                                @media (max-width: 1199px) {
                                    padding: 8px 10px;
                                }

                                @media (max-width: 991px) {
                                    font-size: 14px;
                                }
                            }

                            &:hover {
                                color: #E72E2C;
                            }

                            &.active {
                                font-weight: 500;
                                color: #E72E2C;
                                border-color: #e72e2c;
                                pointer-events: none;
                            }
                        }
                    }
                }

                .tab-content {
                    padding: 48px 0 0 0;

                    @media screen {
                        @media (max-width: 991px) {
                            padding: 40px 0 0 0;
                        }

                        @media (max-width: 575px) {
                            .substitutes {
                                display: flex;
                                flex-wrap: wrap;
                            }
                        }
                    }

                    .tab-pane {
                        display: none;
                        font-size: 14px;

                        .download-link {
                            & > a {
                                font-family: Inter;
                                font-size: 16px;
                                font-weight: 400;
                                line-height: 16px;
                                color: #E72E2C;
                            }
                        }

                        & > .groups {
                            overflow: hidden;
                            display: flex;
                            flex-direction: column;

                            &.max-height {
                                max-height: 365px;
                            }

                            & > .group {
                                &:first-of-type {
                                    & > .title {
                                        margin-top: 0;
                                    }
                                }

                                & > .title {
                                    font-size: 18px;
                                    font-weight: 600;
                                    line-height: 18px;
                                    color: #0D2441;
                                    margin-top: 4rem;
                                    margin-bottom: .5rem;
                                    margin-left: 1rem;
                                }
                            }
                        }

                        .show-more {
                            display: flex;
                            position: relative;
                            font-family: Geologica;
                            font-size: 12px;
                            font-weight: 400;
                            line-height: 14px;
                            color: #E72E2C;
                            text-transform: uppercase;
                            margin-left: 1rem;
                            margin-top: 1rem;

                            &.less {
                                &:after {
                                    transform: rotatex(180deg);
                                    top: -0.15rem;
                                }
                            }

                            &:after {
                                content: url('../../../../../resources/front/images/read-more-arrow-2.svg');
                                position: relative;
                                margin-left: .5rem;
                            }
                        }

                        &.show {
                            display: block;
                        }
                    }
                }

                &.mobile-view {
                    @media screen {
                        @media (min-width: 576px) {
                            display: none;
                        }
                    }

                    .tab-item {
                        &:not(:first-child) {
                            border-top: 1px solid #E5E5E5;
                        }

                        .tab-toggle {
                            position: relative;
                            display: block;
                            width: 100%;
                            padding: 16px 30px 16px 0;
                            line-height: 24px;
                            color: #0D2441;
                            font-size: 16px;
                            font-weight: 600;
                            cursor: pointer;
                            text-align: left;

                            span {
                                font-weight: 400;
                            }

                            &::after {
                                content: '';
                                position: absolute;
                                top: 0;
                                right: 0;
                                bottom: 0;
                                margin: auto 0;
                                width: 20px;
                                height: 20px;
                                background: url('../../../../../resources/front/images/product-mobile-tables-down-arrow.svg') center center no-repeat;
                                transition: all .3s ease-in-out;
                            }
                        }

                        .tab-content {
                            display: none;
                            padding: 8px 0 16px 0;

                            & > .groups {
                                overflow: hidden;
                                display: flex;
                                flex-direction: column;

                                &.max-height {
                                    max-height: 365px;
                                }

                                & > .group {
                                    & > .title {
                                        font-size: 18px;
                                        font-weight: 600;
                                        line-height: 18px;
                                        color: #0D2441;
                                        margin-top: 4rem;
                                        margin-bottom: .5rem;
                                        margin-left: 1rem;
                                    }
                                }
                            }

                            .show-more {
                                display: flex;
                                position: relative;
                                font-family: Geologica;
                                font-size: 12px;
                                font-weight: 400;
                                line-height: 14px;
                                color: #E72E2C;
                                text-transform: uppercase;
                                margin-left: 1rem;
                                margin-top: 1rem;
                                justify-content: center;

                                &.less {
                                    &:after {
                                        transform: rotatex(180deg);
                                        top: -0.15rem;
                                    }
                                }

                                &:after {
                                    content: url('../../../../../resources/front/images/read-more-arrow-2.svg');
                                    position: relative;
                                    margin-left: .5rem;
                                }
                            }
                        }

                        &.active {
                            .tab-toggle {
                                color: #E72E2C;

                                &::after {
                                    opacity: .5;
                                    transform: rotate(-180deg);
                                }
                            }

                            .tab-content {
                                display: block;
                            }
                        }
                    }
                }
            }
        }

        .popular-products {
            margin-top: 88px;
            padding: 88px 0 0 0;
            border-top: 1px solid #e9eaec;
        }
    }
</style>
