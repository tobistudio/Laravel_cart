<template>
    <li class="user-auto">
        <button type="button" class="toggle-button" @click="openCarsPopup">
            <div class="icon">
                <img src="/images/front/wheel-icon.svg" alt="">
                <span class="total-badge">{{ myVehicles.length ? myVehicles.length : (activeVehicle && !activeVehicle.processing ? 1 : 0) }}</span>
            </div>

            <div class="my-car-spans">
                <span>{{ trans.title }}</span>
                <span class="selected-vehicle" v-if="activeVehicle && !activeVehicle.processing">{{ activeVehicle.brand + ' ' + activeVehicle.modelName }}</span>
            </div>
        </button>

        <div class="backdrop" v-if="myVehiclesDropdown" @click="closeCarsPopup"></div>

        <div class="my-cars-dropdown" v-if="myVehiclesDropdown">
            <div class="block-header">
                <h4 class="dropdown-name">Aktīvais auto</h4>
                <button type="button" class="close-mobile"></button>
            </div>

            <div class="block-content" v-if="activeVehicle.processing">
                <div>
                    <h5 class="block-heading">Nav pievienots neviens auto</h5>
                    <p>Pievieno auto, lai atrastu rezerves daļas, kas atbilst tavam auto.</p>
                </div>

                <div class="actions">
                    <a :href="chooseVehicleUrl" class="btn btn-add btn-primary">
                        <span>Pievienot aktīvo auto</span>
                    </a>
                </div>
            </div>

            <div class="cars-items" v-if="activeVehicle && !activeVehicle.processing">
                <div class="item">
                    <div class="details">
                        <div>
                            <span class="car-name">{{ activeVehicle.brand + ' ' + activeVehicle.modelName }}</span>

                            <ul>
                                <li>{{ translate('chooseVehicle', activeVehicle.fuel) + ' ' + activeVehicle.engine + ' ' + activeVehicle.cm3 + 'cm3'}}</li>
                                <li>{{ activeVehicle.power + ' (' + activeVehicle.engine_code  + ')' }}</li>
                            </ul>
                        </div>

                        <div class="actions">
                            <button type="button" class="btn-remove btn btn-primary" @click="removeActiveVehicle">Noņemt</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-cars-block">
                <div class="block-header">
                    <h4 class="dropdown-name">Mani auto<span class="count">{{ '(' + myVehicles.length + ')' }}</span></h4>
                </div>

                <div class="block-content my-cars-content" v-if="!myVehicles.length">
                    <div>
                        <p>Lai pievienotu vairāk par vienu auto nepieciešams reģistrēties.</p>
                    </div>

                    <div class="actions">
                        <div class="auth-btns">
                            <button class="btn btn-login btn-primary" v-if="!auth" @click="openAuthPopup('login')">Pievienoties</button>
                            <button class="btn btn-reg btn-primary" v-if="!auth" @click="openAuthPopup('register')">Reģistrēties</button>
                        </div>

                        <button class="btn btn-create-list btn-primary" v-if="auth" @click="addVehicleToMyVehicles"><span>Izveidot sarakstu</span></button>
                    </div>
                </div>

                <div class="cars-items" v-if="myVehicles.length">
                    <div class="item" v-for="myVehicle in myVehicles">
                        <div class="details">
                            <div>
                                <span class="car-name">{{ myVehicle.brand + ' ' + myVehicle.modelName }}</span>

                                <ul>
                                    <li>{{ translate('chooseVehicle', myVehicle.fuel) + ' ' + myVehicle.engine + ' ' + myVehicle.cm3 + 'cm3'}}</li>
                                    <li>{{ myVehicle.power + ' (' + myVehicle.engine_code  + ')' }}</li>
                                </ul>
                            </div>

                            <div class="actions">
                                <button type="button" :class="['btn-choose', {'selected' : myVehicle.active }]" @click="activateMyVehicle(myVehicle)"><span>{{ myVehicle.active ? 'Aktīvs' : 'Izvēlēties' }}</span></button>
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
    name: 'HeaderMyCars',
    props: ['locale', 'vehicle_brands'],
    data() {
        return {
            viewLoaded: false,
            auth: false,
            myVehiclesDropdown: false,
            chooseVehicleUrl: null,
            brandOptions: [],
            modelOptions: [],
            engineOptions: [],
            selectedVehicle: null,
            myVehiclesUrls: null,
        }
    },
    computed: {
        trans() {
            return {
                title: this.translate('myVehicles', 'title'),
            }
        },
        activeVehicle() {
            return this.$store.state.activeVehicle;
        },
        myVehicles() {
            return this.$store.state.myVehicles;
        }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        openAuthPopup(type) {
            this.myVehiclesDropdown = false;
            this.$store.state.authPopup = type;
        },
        openCarsPopup() {
            this.myVehiclesDropdown = true;

            document.getElementsByTagName('html')[0].style.overflow = "hidden";
        },
        removeActiveVehicle() {
            let payload = {
                active_vehicle_id: this.$store.state.activeVehicleId,
                remove: true,
                redirect: false
            };

            let vehicle_engine_id = this.$store.state.activeVehicle.vehicle_engine_id;
            this.$store.dispatch('activeVehicle', payload).then((data) => {
                let findMyVehicleIndex = this.myVehicles.findIndex(v => v.vehicle_engine_id === vehicle_engine_id);
                if(findMyVehicleIndex >= 0){
                    let payload = {
                        id: this.myVehicles[findMyVehicleIndex].id,
                    };

                    this.$store.dispatch('setMyVehicleActive', payload).then(() => {
                        this.$store.state.activeVehicle = {processing: true};
                        this.chooseVehicleUrl = data.choose_vehicle_url;

                        if(this.myVehicles[findMyVehicleIndex].active) {
                            this.$store.state.myVehicles[findMyVehicleIndex].active = false;
                        }
                    });
                } else {
                    this.$store.state.activeVehicle = {processing: true};
                    this.chooseVehicleUrl = data.choose_vehicle_url;
                }
            })
        },
        addVehicleToMyVehicles() {
            window.location.replace(this.myVehiclesUrl);
        },
        activateMyVehicle(vehicle) {
            let payload = {
                id: vehicle.id,
            };

            this.$store.dispatch('setMyVehicleActive', payload).then(() => {
                let findVehicleIndex = this.myVehicles.findIndex(v => v.id === vehicle.id);
                if (findVehicleIndex >= 0) {
                    if(vehicle.active) {
                        this.$store.state.myVehicles[findVehicleIndex].active = false;

                        if(this.activeVehicle && this.activeVehicle.vehicle_engine_id && this.activeVehicle.vehicle_engine_id === this.$store.state.myVehicles[findVehicleIndex].vehicle_engine_id){
                            let payload = {
                                active_vehicle_id: this.$store.state.activeVehicleId,
                                remove: true,
                                redirect: false
                            };

                            this.$store.dispatch('activeVehicle', payload).then((data) => {
                                this.$store.state.activeVehicle = {processing: true};
                                this.chooseVehicleUrl = data.choose_vehicle_url;
                            })
                        }
                    } else {
                        let findActiveVehicleIndex = this.myVehicles.findIndex(v => v.active);
                        if(findActiveVehicleIndex >= 0){
                            this.$store.state.myVehicles[findActiveVehicleIndex].active = false;
                        }

                        this.$store.state.myVehicles[findVehicleIndex].active = true;

                        let payload = {
                            active_vehicle_id: this.$store.state.activeVehicleId,
                            vehicle_engine_id: this.$store.state.myVehicles[findVehicleIndex].vehicle_engine_id,
                            year_from: this.$store.state.myVehicles[findVehicleIndex].year_from,
                            year_to: this.$store.state.myVehicles[findVehicleIndex].year_to,
                            locale: this.locale,
                        };

                        this.$store.dispatch('activeVehicle', payload).then((data) => {
                            if(data.choose_vehicle_url){
                                this.chooseVehicleUrl = data.choose_vehicle_url;
                            } else {
                                let findSelectedBrandIndex = this.brandOptions.findIndex(brand => brand.page_id === data.vehicle.vehicle_brand_id);
                                if(findSelectedBrandIndex >= 0){
                                    let selectedVehicleBrand = this.brandOptions[findSelectedBrandIndex];
                                    let selectedVehicleYear = {
                                        from: data.vehicle.year_from,
                                        to: data.vehicle.year_to
                                    };

                                    let payload = {
                                        brand_id: selectedVehicleBrand.id,
                                        year: selectedVehicleYear
                                    }

                                    this.$store.dispatch('getVehicle', payload).then((d) => {
                                        this.modelOptions = d.models;

                                        let findSelectedModelIndex = this.modelOptions.findIndex(model => model.id === data.vehicle.vehicle_model_id);
                                        if(findSelectedModelIndex >= 0){
                                            let selectedVehicleModel = {
                                                id: this.modelOptions[findSelectedModelIndex].id,
                                                name: this.modelOptions[findSelectedModelIndex].name,
                                            };

                                            this.modelOptions[findSelectedModelIndex].active = true;

                                            let findSelectedModelNameIndex = this.modelOptions[findSelectedModelIndex].names.findIndex(name => name.id === data.vehicle.vehicle_model_name_id);
                                            if(findSelectedModelNameIndex >= 0){

                                                let selectedVehicleModelName = {
                                                    model_id: this.modelOptions[findSelectedModelIndex].id,
                                                    model_name_id: this.modelOptions[findSelectedModelIndex].names[findSelectedModelNameIndex].id,
                                                    name: this.modelOptions[findSelectedModelIndex].names[findSelectedModelNameIndex].name
                                                };

                                                let fuel = [];
                                                this.modelOptions[findSelectedModelIndex].names[findSelectedModelNameIndex].engines.map((engine) => {
                                                    if (fuel.length === 0) {
                                                        fuel.push({name: engine.fuel, active: false, visible: engine.visible, engines: []});
                                                    } else {
                                                        let findFuelIndex = fuel.findIndex(f => f.name === engine.fuel);
                                                        if (findFuelIndex < 0) {
                                                            fuel.push({name: engine.fuel, active: false, visible: engine.visible, engines: []});
                                                        }
                                                    }
                                                })

                                                fuel.map((f) => {
                                                    f.engines = this.modelOptions[findSelectedModelIndex].names[findSelectedModelNameIndex].engines.filter(engine => engine.fuel === f.name)
                                                });

                                                this.engineOptions = fuel;

                                                let findSelectedFuelIndex = this.engineOptions.findIndex(f => f.name === data.vehicle.vehicle_fuel);
                                                if(findSelectedFuelIndex >= 0){
                                                    this.engineOptions[findSelectedFuelIndex].active = true;

                                                    let findSelectedFuelEngineIndex = this.engineOptions[findSelectedFuelIndex].engines.findIndex(fe => fe.id === data.vehicle.vehicle_engine_id);
                                                    if(findSelectedFuelEngineIndex >= 0){
                                                        let selectedVehicleFuelEngine = {
                                                            id: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].id,
                                                            name: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].name,
                                                            power: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].power,
                                                            fuel: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].fuel,
                                                            cm3: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].cm3,
                                                            engine_code: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].engine_code,
                                                            year_range: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].year_from + '-' + this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].year_to
                                                        };

                                                        this.selectedVehicle = {
                                                            vehicle_engine_id: selectedVehicleFuelEngine.id,
                                                            brand: selectedVehicleBrand.name,
                                                            model: selectedVehicleModel.name,
                                                            modelName: selectedVehicleModelName.name,
                                                            power: selectedVehicleFuelEngine.power,
                                                            fuel: selectedVehicleFuelEngine.fuel,
                                                            engine: selectedVehicleFuelEngine.name,
                                                            cm3: selectedVehicleFuelEngine.cm3,
                                                            engine_code: selectedVehicleFuelEngine.engine_code,
                                                            year_range: selectedVehicleFuelEngine.year_range,
                                                        };

                                                        this.$store.state.activeVehicle = this.selectedVehicle
                                                    }
                                                }
                                            }
                                        }
                                    });
                                }
                            }
                        })
                    }
                }
            });
        },
        closeCarsPopup() {
            this.myVehiclesDropdown = false;

            document.getElementsByTagName('html')[0].style.overflow = "auto";
        },
    },
    mounted() {
        let payload = {
            active_vehicle_id: this.$store.state.activeVehicleId,
            redirect: false
        };

        this.brandOptions = this.vehicle_brands;
        this.$store.dispatch('activeVehicle', payload).then((data) => {
            if(data.choose_vehicle_url){
                this.chooseVehicleUrl = data.choose_vehicle_url;
                this.viewLoaded = true;
            } else {
                let findSelectedBrandIndex = this.brandOptions.findIndex(brand => brand.page_id === data.vehicle.vehicle_brand_id);
                if(findSelectedBrandIndex >= 0){
                    let selectedVehicleBrand = this.brandOptions[findSelectedBrandIndex];
                    let selectedVehicleYear = {
                        from: data.vehicle.year_from,
                        to: data.vehicle.year_to
                    };

                    let payload = {
                        brand_id: selectedVehicleBrand.id,
                        year: selectedVehicleYear
                    }

                    this.$store.dispatch('getVehicle', payload).then((d) => {
                        this.modelOptions = d.models;

                        let findSelectedModelIndex = this.modelOptions.findIndex(model => model.id === data.vehicle.vehicle_model_id);
                        if(findSelectedModelIndex >= 0){
                            let selectedVehicleModel = {
                                id: this.modelOptions[findSelectedModelIndex].id,
                                name: this.modelOptions[findSelectedModelIndex].name,
                            };

                            this.modelOptions[findSelectedModelIndex].active = true;

                            let findSelectedModelNameIndex = this.modelOptions[findSelectedModelIndex].names.findIndex(name => name.id === data.vehicle.vehicle_model_name_id);
                            if(findSelectedModelNameIndex >= 0){

                                let selectedVehicleModelName = {
                                    model_id: this.modelOptions[findSelectedModelIndex].id,
                                    model_name_id: this.modelOptions[findSelectedModelIndex].names[findSelectedModelNameIndex].id,
                                    name: this.modelOptions[findSelectedModelIndex].names[findSelectedModelNameIndex].name
                                };

                                let fuel = [];
                                this.modelOptions[findSelectedModelIndex].names[findSelectedModelNameIndex].engines.map((engine) => {
                                    if (fuel.length === 0) {
                                        fuel.push({name: engine.fuel, active: false, visible: engine.visible, engines: []});
                                    } else {
                                        let findFuelIndex = fuel.findIndex(f => f.name === engine.fuel);
                                        if (findFuelIndex < 0) {
                                            fuel.push({name: engine.fuel, active: false, visible: engine.visible, engines: []});
                                        }
                                    }
                                })

                                fuel.map((f) => {
                                    f.engines = this.modelOptions[findSelectedModelIndex].names[findSelectedModelNameIndex].engines.filter(engine => engine.fuel === f.name)
                                });

                                this.engineOptions = fuel;

                                let findSelectedFuelIndex = this.engineOptions.findIndex(f => f.name === data.vehicle.vehicle_fuel);
                                if(findSelectedFuelIndex >= 0){
                                    this.engineOptions[findSelectedFuelIndex].active = true;

                                    let findSelectedFuelEngineIndex = this.engineOptions[findSelectedFuelIndex].engines.findIndex(fe => fe.id === data.vehicle.vehicle_engine_id);
                                    if(findSelectedFuelEngineIndex >= 0){
                                        let selectedVehicleFuelEngine = {
                                            id: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].id,
                                            name: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].name,
                                            power: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].power,
                                            fuel: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].fuel,
                                            cm3: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].cm3,
                                            engine_code: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].engine_code,
                                            year_range: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].year_from + '-' + this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].year_to
                                        };

                                        this.selectedVehicle = {
                                            vehicle_engine_id: selectedVehicleFuelEngine.id,
                                            brand: selectedVehicleBrand.name,
                                            model: selectedVehicleModel.name,
                                            modelName: selectedVehicleModelName.name,
                                            power: selectedVehicleFuelEngine.power,
                                            fuel: selectedVehicleFuelEngine.fuel,
                                            engine: selectedVehicleFuelEngine.name,
                                            cm3: selectedVehicleFuelEngine.cm3,
                                            engine_code: selectedVehicleFuelEngine.engine_code,
                                            year_range: selectedVehicleFuelEngine.year_range,
                                        };

                                        this.$store.state.activeVehicle = this.selectedVehicle
                                    }
                                }
                            }
                        }

                        this.viewLoaded = true;
                    });
                }
            }
        })

        if(this.$store.state.token){
            this.auth = true;
        }

        this.$store.dispatch('getMyVehicles', this.locale).then((data) => {
            this.$store.state.myVehicles = data.vehicles;
            this.myVehiclesUrl = data.my_vehicles_url;
        });
    }
}
</script>

<style lang="scss" scoped>
@function rem($size) {
    @return calc($size / 16) * 1rem;
}

.user-auto {
    position: relative;
    margin: 0 18px 0 0;

    @media screen {
        @media (max-width: 1129px) {
            margin: 0 35px 0 0;
        }

        @media (max-width: 575px) {
            margin: 0 25px 0 0;
        }
    }

    .icon {
        position: relative;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        height: 40px;

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
            @media (min-width: 1130px) {
                margin: 0 21px 0 0;
            }
        }
    }

    .toggle-button {
        @media screen {
            @media (max-width: 1129px) {
                padding: 0;

                > span {
                    display: none;
                }
            }
        }

        @media screen {
            @media (min-width: 1130px) {
                position: relative;
                display: flex;
                align-items: center;
                padding: 0 15px 0 0;
                color: #0D2441;
                font-size: rem(14);
                cursor: pointer;

                &::after {
                    content: '';
                    position: absolute;
                    top: 0;
                    right: 0;
                    bottom: 0;
                    margin: auto 0;
                    width: 8px;
                    height: 6px;
                    background: url('../../../../front/images/user-auto-arrow-down.svg') right center no-repeat;
                    transition: all .3s ease-in-out;
                }
            }
        }

        .my-car-spans {
            display: flex;
            flex-direction: column;
            align-items: flex-start;

            @media screen {
                @media (max-width: 1129px) {
                    display: none;
                }
            }

            .selected-vehicle {
                display: block;
                max-width: 100px;
                margin: 4px 0 0 0;
                line-height: 14px;
                color: #616571;
                white-space: nowrap;
                text-overflow: ellipsis;
                text-transform: uppercase;
                overflow: hidden;
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

    .my-cars-dropdown {
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

            @media screen {
                @media (max-width: 1129px) {
                    right: 65px;
                }

                @media (max-width: 575px) {
                    content: none;
                }
            }
        }

        @media screen {
            @media (max-width: 1129px) {
                right: -58px;
            }

            @media (max-width: 575px) {
                position: fixed;
                top: 80px;
                right: 16px;
                left: 16px;
                width: auto;
                max-width: 100vw;
                max-height: calc(100vh - 120px);
                scrollbar-color: #E9EAEC #F1F2F3;
                scrollbar-width: thin;
                overflow: auto;

                &::-webkit-scrollbar {
                    width: 6px;
                    height: 6px;
                }

                &::-webkit-scrollbar-track {
                    background: #F1F2F3;
                    border-radius: 8px;
                }

                &::-webkit-scrollbar-thumb {
                    background: #E9EAEC;
                    border-radius: 8px;
                }

                &::-webkit-scrollbar-thumb:hover {
                    background: #CDD0D4;
                }

                &::-webkit-scrollbar-thumb:active {
                    background: #CDD0D4;
                }
            }
        }

        .block-header {
            margin: 0 0 20px 0;
            padding: 12px 24px 7px 24px;
            border-bottom: 1px solid #E9EAEC;


            @media screen {
                @media (max-width: 575px) {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    padding: 16px;
                }
            }

            .dropdown-name {
                display: flex;
                align-items: center;
                font-weight: 600;
                color: #0D2441;

                .count {
                    margin: 0 0 0 4px;
                    color: #616571;
                    font-size: 14px;
                    font-weight: 400;
                    line-height: 16px;
                }
            }

            .close-mobile {
                width: 32px;
                height: 32px;
                background: #F1F2F3 url('../../../../front/images/popup-close-icon.svg') center center no-repeat;
                background-size: 12px;
                cursor: pointer;
                border-radius: 8px;

                @media screen {
                    @media (min-width: 576px) {
                        display: none;
                    }
                }
            }
        }

        .block-content {
            padding: 3px 16px 16px 16px;
            font-size: 14px;
            text-align: center;

            .block-heading {
                margin: 0 0 7px 0;
                font-size: 16px;
                line-height: 16px;

                &::before {
                    content: '';
                    display: block;
                    height: 80px;
                    width: 100%;
                    margin: 0 0 13px 0;
                    background: url("../../../../front/images/empty-cars-dropdown-icon.png") center top no-repeat;
                }
            }

            p {
                margin: 0;
                font-size: 14px;
                line-height: 18px;
                color: #7D8391;
            }

            .actions {
                display: flex;
                justify-content: center;
                margin: 29px 0 0 0;

                .btn {
                    width: 100%;
                    padding: 12px 34px;
                    font-size: 14px;

                    &.btn-add {
                        min-width: 100%;

                        span {
                            display: flex;
                            align-items: center;
                            justify-content: center;

                            &::before {
                                content: '';
                                width: 16px;
                                height: 16px;
                                margin: 0 8px 0 0;
                                background: url("../../../../front/images/plus-icon.svg") left center no-repeat;
                            }
                        }
                    }

                    &.btn-create-list {
                        min-width: 100%;
                        padding: 10px 34px;
                        margin-top: -7px;
                        background-color: transparent;
                        color: #E72E2C;

                        &:hover {
                            background-color: #EEEFF1;
                        }
                    }
                }
            }

            &.my-cars-content {
                p {
                    line-height: 22px;
                    color: #0D2441;
                    font-size: 16px;
                    text-align: left;
                }
            }
        }

        .cars-items {
            padding: 0;

            .item {
                padding-left: 24px;
                padding-right: 24px;
                padding-bottom: 20px;

                &:not(:last-child) {
                    border-bottom: 1px solid #E9EAEC;
                }

                @media screen {
                    @media (max-width: 575px) {
                        padding-left: 16px;
                        padding-right: 16px;;
                    }
                }

                &:not(:last-child) {
                    margin-bottom: 20px;
                }

                &:first-child {
                    padding-left: 24px;
                    padding-right: 24px;
                    padding-bottom: 20px;

                    @media screen {
                        @media (max-width: 575px) {
                            padding-left: 16px;
                            padding-right: 16px;;
                        }
                    }
                }

                .details {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 0 20px;

                    .car-name {
                        display: block;
                        margin: 0 0 4px 0;
                        font-size: 14px;
                        font-weight: 600;
                        line-height: 14px;
                        color: #0D2441;
                        text-transform: uppercase;
                    }

                    ul {
                        li {
                            font-size: 14px;
                            line-height: 18px;
                            color: #616571;
                        }
                    }

                    .status {
                        flex-shrink: 0;
                        margin: 0 0 0 15px;

                        .btn {
                            padding: 10px 12px;
                            border: 0;
                            font-weight: 500;
                            font-size: 14px;
                            font-family: "Inter", sans-serif;
                            border-radius: 8px;

                            &.active {
                                background: #EAF9EC;
                                color: #49A041;

                                span {
                                    display: flex;
                                    align-items: center;
                                    gap: 0 8px;

                                    &::before {
                                        content: '';
                                        width: 16px;
                                        height: 16px;
                                        background: #49A041 url('../../../../front/images/active-check-icon.svg') center center no-repeat;
                                        border-radius: 4px;
                                    }
                                }
                            }
                        }
                    }
                }

                .actions {
                    margin: 12px 0 0 0;

                    button {
                        line-height: 14px;
                        font-size: 14px;
                        font-weight: 500;
                        font-family: "Inter", sans-serif;
                        cursor: pointer;
                        transition: all 0.3s ease-in-out;

                        &.btn-remove {
                            width: 100%;
                            padding: 10px 12.5px;
                            line-height: 14px;
                            background: #FAEAEA;
                            color: #CD2C2C;
                            font-size: 14px;
                            outline: 1px solid transparent;

                            &:hover {
                                background-color: #EEEFF1;
                                color: #0D2441;
                                outline-color: #0D2441;
                            }
                        }

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
                                        background: #49A041 url('../../../../../resources/front/images/active-check-icon.svg') center center no-repeat;
                                        border-radius: 4px;
                                    }
                                }

                                &:hover {
                                    border-color: #49A041;
                                }
                            }
                        }
                    }
                }
            }
        }

        .my-cars-block {
            background: #F9FAFA;
            border-radius: 0 0 8px 8px;

            .block-header {
                margin: 0 0 20px 0;
            }

            .actions {
                margin-top: 17px;
            }

            .auth-btns {
                display: flex;
                flex-direction: column;
                gap: 8px 0;
                width: 100%;

                .btn {
                    padding: 15px 20px;

                    &.btn-login {
                        background-color: #EEEFF1;
                        color: #0D2441;

                        &:hover {
                            background: #dfe0e1;
                        }
                    }

                    &.btn-reg {
                        /* padding: 9px 20px; */
                        background: transparent;
                        color: #0D2441;

                        &:hover {
                            background: #eee;
                        }
                    }
                }
            }
        }
    }
}
</style>
