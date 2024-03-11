<template>
    <section class="page-header-box choose-vehicle-header">
        <div class="container">
            <h1 class="page-title">{{ trans.title }}</h1>

            <div class="sub-text">
                <p>{{ trans.description }}</p>
            </div>

            <button type="button" class="mobile-back-btn"></button>
        </div>
    </section>

    <div class="choose-vehicle">
        <div class="container">
            <div class="search" v-if="!brand">
                <input type="text" v-model="search" :placeholder="trans.searchPlaceholder" @input="searchBrand">
            </div>

            <div class="tabs" v-if="!brand && !searchResults.length">
                <div :class="['popular', tab === 'popular' ? 'active' : '']" @click="showPopularVehicles">{{ trans.popularBrands }} <span>({{ popularVehicles.length }})</span></div>
                <div :class="['all', tab === 'all' ? 'active' : '']" @click="showAllVehicles">{{ trans.allBrands }} <span>({{ allVehicles.length }})</span></div>
            </div>

            <div class="vehicles" v-if="!brand">
                <div class="vehicle" v-for="popularVehicle in popularVehicles" v-if="tab === 'popular' && !searchResults.length">
                    <a :href="popularVehicle.slug" @click.prevent.stop="selectBrand(popularVehicle)">
                        {{ popularVehicle.name }}
                    </a>
                </div>

                <div class="vehicle" v-for="vehicle in allVehicles" v-if="tab === 'all' && !searchResults.length">
                    <a :href="vehicle.slug" @click.prevent.stop="selectBrand(vehicle)">
                        {{ vehicle.name }}
                    </a>
                </div>

                <div class="vehicle" v-for="vehicle in searchResults" v-if="searchResults.length">
                    <a :href="vehicle.slug" @click.prevent.stop="selectBrand(vehicle)">
                        {{ vehicle.name }}
                    </a>
                </div>
            </div>
        </div>

        <div class="filter-wrapper" v-if="brand">
            <div class="container">
                <div class="title">{{ trans.yourChosenVehicle }}</div>
                <div class="filters">
                    <div class="filter brand-logo" @click="selectBrand(brand)">
                        <div class="brand-logo">
                            <img :src="brand.image" :alt="brand.name">
                        </div>
                    </div>

                    <div class="filters-holder">
                        <div class="filter brand" @click="selectBrand(brand)">
                            <div class="label">{{ trans.vehicleBrand }}</div>
                            <div class="value">{{ brand.name }}</div>
                        </div>

                        <div class="filter year" @click="chooseYear(year.from, year.to)">
                            <div class="label">{{ trans.vehicleYear }}</div>
                            <div class="value">{{ year ? (year.from ? year.from + ' - ' : trans.vehicleYearTo + ' ') + year.to : trans.notChosen }}</div>
                        </div>

                        <div class="filter model" @click="chooseModel(model)">
                            <div class="label">{{ trans.vehicleModel }}</div>
                            <div class="value">{{ modelFull ? modelFull.name : (model ? model.name : trans.notChosen) }}</div>
                        </div>

                        <div class="filter engine" @click="chooseFuelType(fuelType)">
                            <div class="label">{{ trans.vehicleEngine }}</div>
                            <div class="value">{{ fuelTypeEngine ? fuelTypeEngine.name + ' (' + fuelTypeEngine.power + ')' : trans.notChosen }}</div>
                        </div>
                    </div>
                </div>
                <div class="clear" @click="clearFilters">{{ trans.clearFilters }}</div>
            </div>
        </div>

        <div class="container data-container">
            <div class="data" v-if="brand">
                <div class="years" v-if="!year">
                    <div class="title">{{ trans.vehicleReleaseYear }}</div>
                    <div class="years-list">
                        <div class="year" @click="chooseYear(1965, 1980)">1965 - 1980</div>
                        <div class="year" @click="chooseYear(1981, 1995)">1981 - 1995</div>
                        <div class="year" @click="chooseYear(1996, 2005)">1996 - 2005</div>
                        <div class="year" @click="chooseYear(2006, 2015)">2006 - 2015</div>
                        <div class="year" @click="chooseYear(2016, 2020)">2016 - 2020</div>
                        <div class="year" @click="chooseYear(2021, 2024)">2021 - 2024</div>
                    </div>
                </div>
                <div class="models" v-if="year && !model">
                    <div class="title">{{ trans.actual + ' ' + brand.name + ' ' + trans.models }}</div>
                    <div class="models">
                        <template v-for="model in modelOptions">
                            <div class="model" @click="chooseModel(model)">{{ model.name }}</div>
                        </template>
                    </div>
                </div>
                <div class="full-models" v-if="model && !modelFull">
                    <div class="title">
                        <button type="button" class="back-btn" @click="chooseModel(model)"></button>
                        <div>{{ trans.choseFull }}<span>{{ brand.name }}</span> {{ trans.model }}</div>
                    </div>

                    <div class="models">
                        <template v-for="modelName in modelNameOptions">
                            <div class="model" @click="chooseModelFull(modelName)">
                                <div class="image">
                                    <img src="../../../../../public/images/front/audi-image.png" alt="">
                                </div>

                                <div class="details">
                                    <div class="name">{{ modelName.name }}</div>
                                    <div class="year">{{ modelName.year_from + ' - ' + modelName.year_to }}</div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="fuel_types" v-if="modelFull && !fuelType">
                    <div class="title">{{ trans.fuelType }}</div>
                    <div class="fuels">
                        <template v-for="fuel in fuelOptions">
                            <div class="fuel" @click="chooseFuelType(fuel)">{{ translate('chooseVehicle', fuel.name) }}</div>
                        </template>
                    </div>
                </div>
                <div class="engine_modifications" v-if="fuelType && !fuelTypeEngine">
                    <div class="title">
                        <button type="button" class="back-btn" @click="chooseFuelType(fuelType)"></button>
                        <div>{{ trans.chooseEngineModification }}</div>
                    </div>
                    <div class="modifications">
                        <template v-for="engine in fuelEngineOptions">
                            <div class="modification" @click="chooseEngineModification(engine)">
                                <div class="image">
                                    <img src="../../../../../public/images/front/engine-image.png" alt="">
                                </div>

                                <div class="details">
                                    <div class="name">{{ engine.name + ' (' + engine.power + ')' }}</div>
                                    <div class="short">{{ engine.engine_code }}</div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ChooseVehicle',
    props: ['data', 'locale'],
    data() {
        return {
            search: '',
            searchResults: [],
            vehicle: null,
            brand: null,
            year: null,
            model: null,
            modelFull: null,
            fuelType: null,
            fuelTypeEngine: null,

            modelOptions: [],
            modelNameOptions: [],
            fuelOptions: [],
            fuelEngineOptions: [],

            tab: 'popular',
            popularVehicles: [],
            allVehicles: [],
        }
    },
    computed: {
        trans() {
            return {
                title: this.translate('chooseVehicle', 'title'),
                description: this.translate('chooseVehicle', 'description'),
                searchPlaceholder: this.translate('chooseVehicle', 'search_placeholder'),
                popularBrands: this.translate('chooseVehicle', 'popular_brands'),
                allBrands: this.translate('chooseVehicle', 'all_brands'),
                yourChosenVehicle: this.translate('chooseVehicle', 'your_chosen_vehicle'),
                vehicleBrand: this.translate('chooseVehicle', 'vehicle_brand'),
                vehicleYear: this.translate('chooseVehicle', 'vehicle_year'),
                vehicleYearTo: this.translate('chooseVehicle', 'vehicle_year_to'),
                vehicleModel: this.translate('chooseVehicle', 'vehicle_model'),
                vehicleEngine: this.translate('chooseVehicle', 'vehicle_engine'),
                notChosen: this.translate('chooseVehicle', 'not_chosen'),
                clearFilters: this.translate('chooseVehicle', 'clear_filters'),
                vehicleReleaseYear: this.translate('chooseVehicle', 'vehicle_release_year'),
                actual: this.translate('chooseVehicle', 'actual'),
                models: this.translate('chooseVehicle', 'models'),
                choseFull: this.translate('chooseVehicle', 'chose_full'),
                model: this.translate('chooseVehicle', 'model'),
                fuelType: this.translate('chooseVehicle', 'fuel_type'),
                chooseEngineModification: this.translate('chooseVehicle', 'choose_engine_modification'),
            }
        }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        searchBrand(){
            if(this.search) {
                this.searchResults = this.allVehicles.filter(vehicle => vehicle.name.toLowerCase().includes(this.search.toLowerCase()));
            } else {
                this.searchResults = [];
            }
        },
        showPopularVehicles() {
            this.tab = 'popular';
        },
        showAllVehicles() {
            this.tab = 'all';
        },
        selectBrand(brand) {
            if(this.brand){
                this.brand = null;
                this.year = null;
                this.model = null;
                this.modelFull = null;
                this.fuelType = null;
                this.fuelTypeEngine = null;
            } else {
                this.brand = {
                    id: brand.id,
                    name: brand.name,
                    image: brand.featured_image
                }
            }
            this.search = '';
            this.searchResults = [];
        },
        chooseYear(from, to) {
            if(this.year) {
                this.year = null;
                this.model = null;
                this.modelFull = null;
                this.fuelType = null;
                this.fuelTypeEngine = null;
                this.modelOptions = [];
                this.modelNameOptions = [];
                this.fuelOptions = [];
                this.fuelEngineOptions = [];
            } else {
                this.year = {
                    from: from,
                    to: to
                }

                let payload = {
                    brand_id: this.brand.id,
                    year: this.year,
                }

                this.$store.dispatch('getVehicle', payload).then((data) => {
                    this.modelOptions = data.models;
                })
            }
        },
        chooseModel(model) {
            if(this.model) {
                this.model = null;
                this.modelFull = null;
                this.fuelType = null;
                this.fuelTypeEngine = null;
                this.modelNameOptions = [];
                this.fuelOptions = [];
                this.fuelEngineOptions = [];
            } else {
                this.model = model;

                let findModelIndex = this.modelOptions.findIndex(mo => mo.id === this.model.id);
                if(findModelIndex >= 0){
                    this.modelNameOptions = this.modelOptions[findModelIndex].names;
                }
            }
        },
        chooseModelFull(modelName) {
            if(this.modelFull) {
                this.modelFull = null;
                this.fuelType = null;
                this.fuelTypeEngine = null;
                this.fuelOptions = [];
                this.fuelEngineOptions = [];
            } else {
                this.modelFull = {
                    id: modelName.id,
                    name: modelName.name
                };

                let fuel = [];
                let findModelNameIndex = this.modelNameOptions.findIndex(mno => mno.id === this.modelFull.id);
                if(findModelNameIndex >= 0){
                    this.fuelOptions = this.modelNameOptions[findModelNameIndex].engines;
                    this.fuelOptions.map((engine) => {
                        if (fuel.length === 0) {
                            fuel.push({name: engine.fuel, active: false, engines: []});
                        } else {
                            let findFuelIndex = fuel.findIndex(f => f.name === engine.fuel);
                            if (findFuelIndex < 0) {
                                fuel.push({name: engine.fuel, active: false, engines: []});
                            }
                        }
                    });

                    fuel.map((f) => {
                        f.engines = this.fuelOptions.filter(engine => engine.fuel === f.name)
                    });
                }
                this.fuelOptions = fuel;
            }
        },
        chooseFuelType(fuelType) {
            if(fuelType) {
                if (this.fuelType) {
                    this.fuelType = null;
                    this.fuelTypeEngine = null;
                    this.fuelEngineOptions = [];
                } else {
                    this.fuelType = fuelType;

                    let findFuelIndex = this.fuelOptions.findIndex(fo => fo.name === fuelType.name);
                    if (findFuelIndex >= 0) {
                        this.fuelEngineOptions = this.fuelOptions[findFuelIndex].engines;
                    }
                }
            }
        },
        chooseEngineModification(fuelTypeEngine) {
            if(this.fuelTypeEngine) {
                this.fuelTypeEngine = null;
            } else {
                this.fuelTypeEngine = {
                    id: fuelTypeEngine.id,
                    name: fuelTypeEngine.name,
                    power: fuelTypeEngine.power,
                    fuel: fuelTypeEngine.fuel,
                    cm3: fuelTypeEngine.cm3,
                    engine_code: fuelTypeEngine.engine_code,
                    year_range: fuelTypeEngine.year_range,
                };

                let payload = {
                    active_vehicle_id: this.$store.state.activeVehicleId,
                    vehicle_engine_id: this.fuelTypeEngine.id,
                    year_from: this.year.from,
                    year_to: this.year.to,
                    locale: this.locale,
                    redirect: true
                };

                this.$store.dispatch('activeVehicle', payload).then((data) => {
                    this.$store.state.activeVehicle = {
                        vehicle_engine_id: this.fuelTypeEngine.id,
                        brand: this.brand.name,
                        model: this.model.name,
                        modelName: this.modelFull.name,
                        power: this.fuelTypeEngine.power,
                        fuel: this.fuelTypeEngine.fuel,
                        engine: this.fuelTypeEngine.name,
                        cm3: this.fuelTypeEngine.cm3,
                        engine_code: this.fuelTypeEngine.engine_code,
                        year_range: this.fuelTypeEngine.year_range,
                    }

                    if(this.$store.state.myVehicles.length > 0) {
                        let findMyVehicleIndex = this.$store.state.myVehicles.findIndex(v => v.vehicle_engine_id === this.$store.state.activeVehicle.vehicle_engine_id);
                        if(findMyVehicleIndex < 0){
                            findMyVehicleIndex = this.$store.state.myVehicles.findIndex(v => v.active);
                        }

                        if(findMyVehicleIndex >= 0) {
                            let payload = {
                                id: this.$store.state.myVehicles[findMyVehicleIndex].id,
                            };

                            this.$store.dispatch('setMyVehicleActive', payload).then(() => {
                                let findActiveVehicleIndex = this.$store.state.myVehicles.findIndex(v => v.active);
                                if (findActiveVehicleIndex >= 0) {
                                    this.$store.state.myVehicles[findActiveVehicleIndex].active = false;
                                }

                                if(this.$store.state.activeVehicle.vehicle_engine_id === this.$store.state.myVehicles[findMyVehicleIndex].vehicle_engine_id) {
                                    this.$store.state.myVehicles[findMyVehicleIndex].active = true;
                                }

                                if(data.redirect){
                                    window.location.replace(data.redirect);
                                }
                            });
                        } else {
                            if(data.redirect){
                                window.location.replace(data.redirect);
                            }
                        }
                    } else {
                        if(data.redirect){
                            window.location.replace(data.redirect);
                        }
                    }
                })
            }
        },
        clearFilters() {
            this.brand = null;
            this.year = null;
            this.model = null;
            this.modelFull = null;
            this.fuelType = null;
            this.fuelTypeEngine = null;
        }
    },
    mounted() {
        this.popularVehicles = this.data.popular_vehicles;
        this.allVehicles = this.data.all_vehicles;
        this.brand = this.data.brand;
        this.year = this.data.year
        this.model = this.data.model;
        this.engine = this.data.engine;
    }
}
</script>

<style lang="scss" scoped>
    .page-header-box {
        &.choose-vehicle-header {
            .page-title {
                @media screen {
                    @media (max-width: 575px) {
                        padding-right: 50px;
                        line-height: 32px;
                        font-size: 26px;
                        letter-spacing: -0.52px;
                    }
                }
            }

            .sub-text {
                margin-top: 10px;
                color: #D8DADE;

                @media screen {
                    @media (max-width: 768px) {
                        margin-top: 3px;
                    }

                    @media (max-width: 575px) {
                        margin-top: 6px;
                        line-height: 16px;
                        font-size: 14px;
                    }
                }

                &::before {
                    content: none;
                }
            }

            @media screen {
                @media (max-width: 768px) {
                    justify-content: flex-start;
                    height: auto;
                    margin-bottom: 48px;
                    padding-top: 30px;
                    padding-bottom: 30px;

                    .container {
                        position: relative;
                        width: 100%;
                        text-align: left;
                    }
                }

                @media (max-width: 575px) {
                    margin-bottom: 16px;
                }
            }

            .mobile-back-btn {
                position: absolute;
                top: -15px;
                right: 30px;
                width: 32px;
                height: 32px;
                border: 0;
                background: #E9EAEC url('../../../../../resources/front/images/page-header-back-icon.svg') center center no-repeat;
                cursor: pointer;
                border-radius: 8px;

                @media screen {
                    @media (min-width: 769px) {
                        display: none;
                    }

                    @media (max-width: 575px) {
                        right: 15px;
                    }
                }
            }
        }
    }

    .choose-vehicle {

        @media screen {
            @media (max-width: 575px) {
                display: flex;
                flex-direction: column;

                .container {
                    width: 100%;
                }

                .data-container {
                    order: 1;
                    width: 100%;
                    padding-top: 16px;
                    margin-bottom: 48px;
                }

                .filter-wrapper {
                    order: 2;
                }
            }
        }

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

        .search {
            display: flex;
            justify-content: center;
            margin: 0 0 64px 0;

            @media screen {
                @media (max-width: 768px) {
                    margin: 0 0 46px 0;
                }
            }

            input[type="text"] {
                height: 56px;
                width: 100%;
                max-width: 810px;
                padding: 0 60px 0 16px;
                background: url('../../../../../resources/front/images/search-icon-dark.svg') calc(100% - 15px) center no-repeat;
                border: 1px solid #D8DADE;
                color: #0D2441;
                font-size: 16px;
                transition: all .3s ease-in-out;
                border-radius: 8px;

                &::-webkit-input-placeholder {
                    color: #616571;
                }

                &::placeholder {
                    color: #616571;
                }

                &:focus {
                    border-color: #49515A;
                }
            }
        }

        .tabs {
            display: flex;
            gap: 0 24px;
            margin: 0 0 32px 0;
            border-bottom: 1px solid #E3E5E8;

            @media screen {
                @media (max-width: 575px) {
                    margin: 0 0 19px 0;
                    border: 0;
                }
            }

            > div {
                padding: 0 0 5px 0;
                margin-bottom: -1px;
                border-bottom: 3px solid transparent;
                cursor: pointer;
                transition: all .3s ease-in-out;

                @media screen {
                    @media (max-width: 575px) {
                        padding: 0;
                        margin: 0;
                        border: 0;

                        &:last-child {
                            display: none;
                        }
                    }
                }

                span {
                    font-weight: 400;
                }

                &.popular {

                }

                &.all {

                }

                &.active {
                    border-color: #E72E2C;
                    color: #E72E2C;
                    font-weight: 600;
                    /* pointer-events: none; */

                    @media screen {
                        @media (max-width: 575px) {
                            border-color: transparent;
                            color: #0D2441;
                            font-weight: 500;
                            pointer-events: none;

                            span {
                                color: #616571;
                                font-size: 14px;
                            }
                        }
                    }
                }

                &:hover {
                    color: #E72E2C;
                }
            }
        }

        .vehicles {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 16px;

            @media screen {
                @media (max-width: 1199px) {
                    grid-template-columns: repeat(4, minmax(0, 1fr));
                }

                @media (max-width: 768px) {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }

                @media (max-width: 575px) {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    gap: 12px;
                }
            }

            .vehicle {
                a {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 100%;
                    min-height: 48px;
                    padding: 0 10px;
                    line-height: 1.2;
                    border: 1px solid #D8DADE;
                    color: #0D2441;
                    font-size: 16px;
                    word-wrap: break-word;
                    text-transform: uppercase;
                    text-align: center;
                    border-radius: 8px;

                    @media screen {
                        @media (max-width: 575px) {
                            font-size: 12px;
                        }
                    }

                    &:hover {
                        border-color: #0D2441;
                    }
                }
            }
        }

        .filter-wrapper {
            margin: -40px 0 64px 0;
            padding: 32px 0;
            background-color: #EFEFF1;

            @media screen {
                @media (max-width: 768px) {
                    margin-top: -48px;
                }

                @media (max-width: 575px) {
                    padding-top: 24px;
                    padding-bottom: 24px;
                    margin-top: 0;
                }
            }

            .container {
                position: relative;
            }

            .title {
                display: block;
                margin: 0 0 16px 0;
                font-size: 20px;
                font-weight: 600;
                line-height: 26px;
                letter-spacing: -0.2px;
                color: #0D2441;

                @media screen {
                    @media (max-width: 768px) {
                        margin: 0 0 31px 0;
                    }
                }
            }

            .clear {
                position: absolute;
                top: 4px;
                right: 15px;
                padding-left: 16px;
                line-height: 16px;
                background: url('../../../../../resources/front/images/filter-remove-icon.svg') left center no-repeat;
                color: #E72E2C;
                font-size: 14px;
                font-weight: 500;
                cursor: pointer;
            }

            .filters {
                display: flex;
                align-items: center;
                gap: 0 32px;
                cursor: pointer;

                @media screen {
                    @media (max-width: 575px) {
                        display: flex;
                        flex-direction: column;

                        .filter.brand-logo {
                            order: 2
                        }

                        .filters-holder {
                            order: 1;
                        }
                    }
                }

                .filter {
                    /* flex-grow: 1; */

                    &.brand-logo {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        flex-shrink: 0;
                        width: 184px;
                        height: 96px;
                        padding: 15px;
                        background: #FFF;
                        border-radius: 8px;

                        img {
                            max-height: 100%;
                        }

                        @media screen {
                            @media (max-width: 575px) {
                                width: 100%;
                                height: 170px;
                                margin: 32px 0 0 0;
                            }
                        }
                    }

                    .label {
                        display: block;
                        margin: 0 0 8px 0;
                        font-size: 14px;
                        font-weight: 400;
                        line-height: 16px;

                        @media screen {
                            @media (max-width: 460px) {
                                margin: 0 0 6px 0;
                                line-height: 12px;
                                font-size: 12px;
                            }
                        }

                    }

                    .value {
                        display: block;
                        font-size: 16px;
                        font-weight: 600;
                        line-height: 16px;
                        color: #0D2441;

                        @media screen {
                            @media (max-width: 460px) {
                                font-size: 14px;
                            }
                        }
                    }
                }

                .filters-holder {
                    display: flex;
                    align-items: center;
                    flex-grow: 1;
                    gap: 32px;

                    @media screen {
                        @media (max-width: 768px) {
                            display: grid;
                            grid-template-columns: repeat(2, minmax(0, 1fr));
                            gap: 24px 32px;
                        }

                        @media (max-width: 575px) {
                            width: 100%;
                        }

                        @media (max-width: 460px) {
                            grid-template-columns: auto;
                        }
                    }

                    .filter {
                        flex-grow: 1;
                    }
                }
            }
        }

        .data {
            .title {
                display: flex;
                align-items: center;
                margin: 0 0 24px 0;
                color: #0D2441;
                font-size: 16px;
                font-weight: 500;
                line-height: 16px;

                .back-btn {
                    width: 24px;
                    height: 24px;
                    margin: 0 16px 0 0;
                    background: #E72E2C url('../../../../../resources/front/images/choose-vehicle-back-btn-arrow.svg') center center no-repeat;
                    cursor: pointer;
                    transition: all .3s ease-in-out;
                    border-radius: 3px;

                    &:hover {
                        background-color: #d32623;
                    }
                }
            }

            .years, .models, .full-models, .fuel_types, .engine_volumes {
                .years-list, .models, .fuels, .volumes {
                    display: flex;
                    gap: 16px;
                    flex-wrap: wrap;

                    @media screen {
                        @media (max-width: 575px) {
                            display: grid;
                            grid-template-columns: repeat(2, minmax(0, 1fr));
                            gap: 12px;
                        }
                    }

                    .year, .model, .fuel, .volume {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        min-height: 48px;
                        padding: 10px 16px;
                        line-height: 16px;
                        border: 1px solid #DDDFE3;
                        color: #0D2441;
                        font-size: 14px;
                        text-align: center;
                        cursor: pointer;
                        transition: all .3s ease-in-out;
                        border-radius: 4px;

                        &:hover {
                            border-color: #0D2441;
                        }
                    }
                }

                .fuel {
                    @media screen {
                        @media (min-width: 769px) {
                            min-width: 184px;
                        }
                    }
                }

                .volume {
                    @media screen {
                        @media (min-width: 769px) {
                            min-width: 160px;
                        }
                    }
                }
            }

            .full-models, .engine_modifications {
                .title {
                    span {
                        margin-left: 4px;
                        font-weight: 500;
                        color: #E72E2C;
                    }
                }

                .models, .modifications {
                    display: grid;
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                    gap: 16px;

                    @media screen {
                        @media (max-width: 768px) {
                            grid-template-columns: repeat(2, minmax(0, 1fr));
                            gap: 16px 12px;
                        }

                        @media (max-width: 575px) {
                            grid-template-columns: auto;
                        }

                    }

                    .model, .modification {
                        display: flex;
                        align-items: center;
                        justify-content: flex-start;
                        gap: 0 16px;
                        padding: 16px 24px;
                        border: 1px solid #DDDFE3;
                        cursor: pointer;
                        text-align: left;
                        transition: all .3s ease-in-out;
                        border-radius: 4px;

                        @media screen {
                            @media (max-width: 768px) {
                                padding: 16px;
                            }
                        }

                        &:hover {
                            border-color: #0D2441;
                        }

                        .image {
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            width: 105px;
                            height: 64px;

                            @media screen {
                                @media (max-width: 768px) {
                                    width: 92px;
                                    height: 56px;
                                }

                                @media (max-width: 575px) {
                                    width: 66px;
                                    height: 40px;
                                }
                            }
                        }

                        .name {
                            display: block;
                            margin: 0 0 7px 0;
                            line-height: 18px;
                            font-size: 16px;
                            color: #0D2441;
                            text-transform: uppercase;

                            @media screen {
                                @media (max-width: 575px) {
                                    line-height: 16px;
                                    font-size: 14px;
                                }
                            }
                        }

                        .year, .short {
                            display: block;
                            min-height: 1px;
                            padding: 0;
                            border: 0;
                            line-height: 18px;
                            font-size: 14px;
                            font-weight: 400;
                            color: #616571;
                            text-align: left;

                            @media screen {
                                @media (max-width: 575px) {
                                    line-height: 12px;
                                    font-size: 12px;
                                }
                            }
                        }
                    }

                    .modification {
                        .image {
                            width: 72px;

                            @media screen {
                                @media (max-width: 575px) {
                                    width: 54px;
                                    height: 48px;
                                }
                            }
                        }
                    }
                }
            }

            .full-models {
                @media screen {
                    @media (max-width: 991px) {
                        .models {
                            display: grid;
                            grid-template-columns: repeat(2, minmax(0, 1fr));
                            gap: 16px;
                        }
                    }

                    @media (max-width: 575px) {
                        .models {
                            grid-template-columns: auto;
                        }
                    }
                }
            }
        }

    }
</style>
