<template>
    <div v-if="viewLoaded">
        <div class="content-heading-holder" v-if="vehicles.length === 0">
            <button type="button" class="mobile-back-btn"></button>
            <h1 class="content-heading">Mani auto</h1>
        </div>

        <div class="my-cars" v-if="vehicles.length === 0">
            <div class="empty">
                <div class="image">
                    <img src="../../../../../../resources/front/images/Iamge_no_cars.png" alt="">
                </div>

                <span class="block-heading">Nav pievienots neviens auto!</span>
                <p>Pievienojot auto, rezerves daļu meklēšana kļūst ātrāka un precīzāka.</p>

                <a href="#" class="btn btn-add btn-primary" @click="openAddCarPopup">
                    <span>Pievienot auto</span>
                </a>
            </div>
        </div>

        <div class="my-cars" v-if="vehicles.length > 0">
            <div class="content-heading-holder">
                <button type="button" class="mobile-back-btn"></button>

                <div>
                    <h1 class="content-heading">Mani auto </h1>
                </div>
            </div>

            <div class="list">
                <div class="item" v-for="vehicle in vehicles">
                    <div class="car-info">
                        <span class="car-name">{{ vehicle.brand + ' ' + vehicle.modelName }}</span>

                        <ul class="details">
                            <li>{{ translate('chooseVehicle',vehicle.fuel) + ' ' + vehicle.engine + ' ' + vehicle.cm3 + 'cm3' }}</li>
                            <li>{{ vehicle.power + ' (' + vehicle.engine_code + ')' }}</li>
                        </ul>
                    </div>

                    <div class="actions">
                        <button type="button" :class="['btn-choose', {'selected' : vehicle.active }]" @click="setMyVehicleActive(vehicle)"><span>{{ vehicle.active ? 'Aktīvs' : 'Izvēlēties' }}</span></button>
                        <button type="button" class="btn-remove" @click="openRemoveCarConfirmationPopup(vehicle)"><span>Dzēst</span></button>
                    </div>
                </div>
            </div>

            <div class="toolbar">
                <a href="#" class="btn btn-add btn-primary" @click="openAddCarPopup">
                    <span>Pievienot auto</span>
                </a>
            </div>
        </div>

        <div v-if="addCarPopup" class="content-popup add-car-popup">
            <div class="content">
                <div class="popup-header">
                    <h4 class="heading">Pievienot auto</h4>
                    <p>Lai veiksmīgi pievienotu auto nepieciešams aizpildīt visus laukus.</p>

                    <div @click="closeAddCarPopup" class="close"></div>
                </div>

                <div class="popup-content">
                    <div class="form">
                        <div :class="['form-group', 'dropdown-search', brandsDropdown ? 'active' : '']">
                            <div class="icon" v-if="brandsDropdown"></div>

                            <div class="form-control placeholder" v-if="!brandsDropdown" @click="focusBrandsDropdown">
                                <span>{{ selectedBrand ? selectedBrand.name : trans.brandPlaceholder }}</span>
                            </div>

                            <input v-else :value="brandSearchTerm ? brandSearchTerm : (selectedBrand && !brandsDropdown ? selectedBrand.name : '')" @input="searchBrand" type="text" ref="brandsSelect" :class="['form-control', brandsDropdown ? 'focused' : '']" :placeholder="trans.brandPlaceholderActive">


                            <div class="dropdown" v-if="brandsDropdown">
                                <ul class="inner-dropdown text-uppercase">
                                    <template v-for="brand in brandOptions">
                                        <li v-if="brand.visible" :class="['select-brand-item', selectedBrand && selectedBrand.id === brand.id ? 'active' : '']"
                                            @click="selectBrand(brand)">
                                            {{ brand.name }}
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        <div :class="['form-group', 'dropdown-search', 'mobile-hidden', !selectedBrand ? 'disabled' : '', yearDropdown ? 'active' : '']">
                            <div class="icon" v-if="yearDropdown"></div>

                            <div class="form-control placeholder" v-if="!yearDropdown" @click="focusYearDropdown">
                                <span>{{ selectedYear ? selectedYear.from + ' - ' + selectedYear.to : trans.yearPlaceholder }}</span>
                            </div>

                            <input v-else :value="yearSearchTerm ? yearSearchTerm : (selectedYear && !yearDropdown ? selectedYear.from + ' - ' + selectedYear.to : '')"
                                   @input="searchYear" type="text" ref="yearSelect" :class="['form-control', yearDropdown ? 'focused' : '']"
                                   :placeholder="trans.yearPlaceholderActive">

                            <div class="dropdown" v-if="yearDropdown">
                                <ul class="inner-dropdown">
                                    <template v-for="year in yearOptions">
                                        <li v-if="year.visible"
                                            :class="['select-year-item', selectedYear && selectedYear.from === year.from && selectedYear.to === year.to ? 'active' : '']"
                                            @click="selectYear( year.from, year.to)">{{ year.from + ' - ' + year.to }}
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        <div :class="['form-group', 'dropdown-search', 'mobile-hidden', !selectedYear ? 'disabled' : '', modelDropdown ? 'active' : '']">
                            <div class="icon" v-if="modelDropdown"></div>

                            <div class="form-control placeholder" v-if="!modelDropdown" @click="focusModelDropdown">
                                <span>{{ selectedModelName ? selectedModelName.name : (selectedModel ? selectedModel.name : trans.modelPlaceholder) }}</span></div>
                            <input v-else :value="modelSearchTerm ? modelSearchTerm : (selectedModelName && !selectedYear ? selectedModelName.name : '')"
                                   @input="searchModel" type="text" ref="modelSelect" :class="['form-control', modelDropdown ? 'focused' : '']"
                                   :placeholder="trans.modelPlaceholderActive">

                            <div :class="['dropdown', selectedModel !== null ? 'open' : '']" v-if="modelDropdown">
                                <ul class="inner-dropdown">
                                    <template v-for="model in modelOptions">
                                        <li class="category-item" v-if="model.visible" @click="selectModel(model)">
                                            <span class="category-toggle" v-if="!model.active && !selectedModel">{{ model.name }}</span>

                                            <ul class="submenu" v-if="model.active">
                                                <li class="back-btn" @click.prevent.stop="selectModel(model)"><span class="back-btn-span">{{ model.name }}</span></li>

                                                <template v-for="name in model.names">
                                                    <li v-if="name.visible" :class="[selectedModelName && selectedModelName.model_name_id === name.id ? 'active' : '']"
                                                        @click.prevent.stop="selectModelName(model, name)">{{ name.name }}
                                                    </li>
                                                </template>
                                            </ul>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        <div :class="['form-group', 'dropdown-search', 'mobile-hidden', !selectedModelName ? 'disabled' : '', engineDropdown ? 'active' : '']">
                            <div class="icon" v-if="engineDropdown"></div>

                            <div class="form-control placeholder" v-if="!engineDropdown" @click="focusEngineDropdown">
                                <span>{{ selectedFuelEngine ? selectedFuelEngine.name + ' (' + selectedFuelEngine.power + ')' : trans.enginePlaceholder }}</span></div>
                            <input v-else :value="engineSearchTerm ? engineSearchTerm : (selectedFuelEngine && !engineDropdown ? selectedFuelEngine.name : '')"
                                   @input="searchEngine" type="text" ref="engineSelect" :class="['form-control', engineDropdown ? 'focused' : '']"
                                   :placeholder="trans.enginePlaceholderActive">

                            <div :class="['dropdown', selectedFuel !== null ? 'open' : '']" v-if="engineDropdown">
                                <ul class="inner-dropdown">
                                    <template v-for="fuel in engineOptions">
                                        <li class="category-item" v-if="fuel.visible" @click="selectFuel(fuel)">
                                            <span class="category-toggle" v-if="!fuel.active && !selectedFuel">{{ translate('chooseVehicle', fuel.name) }}</span>

                                            <ul class="submenu" v-if="fuel.active">
                                                <li class="back-btn" @click.prevent.stop="selectFuel(fuel)"><span
                                                    class="back-btn-span">{{ translate('chooseVehicle', fuel.name) }}</span></li>

                                                <template v-for="engine in fuel.engines">
                                                    <li v-if="engine.visible" :class="[selectedFuelEngine && selectedFuelEngine.id === engine.id ? 'active' : '']"
                                                        @click.prevent.stop="selectFuelEngine(engine)">{{ engine.name + ' (' + engine.power + ')' }}
                                                    </li>
                                                </template>
                                            </ul>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        <div class="submit-form">
                            <button type="submit" class="btn-submit btn btn-primary" @click="addMyVehicle">Pievienot</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="removeCarConfirmationPopup" class="content-popup confirm-remove remove-car-confirmation-popup">
            <div class="content">
                <div class="popup-header">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <path d="M13.333 20.5882H66.6663M29.9997 10H49.9997M51.6663 70H28.333C24.6511 70 21.6663 66.8397 21.6663 62.9412L20.1443 24.2646C20.0654 22.2594 21.5794 20.5882 23.4748 20.5882H56.5246C58.42 20.5882 59.9339 22.2594 59.855 24.2646L58.333 62.9412C58.333 66.8397 55.3482 70 51.6663 70Z" stroke="#CD2C2C" stroke-width="3" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <span class="heading">Vai tiešām vēlies dzēst šo auto?</span>

                    <div @click="closeRemoveCarConfirmationPopup" class="close"></div>
                </div>

                <div class="popup-content">
                    <div class="action-btns">
                        <button type="submit" class="btn-cancel btn btn-secondary" @click="closeRemoveCarConfirmationPopup">Atcelt</button>
                        <button type="submit" class="btn-submit btn btn-primary" @click="deleteCar">Jā, dzēst</button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="carRemovedPopup" class="content-popup car-removed-popup">
            <div class="content">
                <div class="popup-header">
                    <div @click="closeCarRemovedPopup" class="close"></div>
                </div>
                <div class="popup-content">
                    {{ vehicleRemovedName + ' tika izdzēst no saraksta.' }}

                    <button type="submit" class="btn-submit btn btn-primary" @click="closeCarRemovedPopup">Aizvērt</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'profileMyVehicles',
    props: ['locale', 'vehicle_brands'],
    data() {
        return {
            viewLoaded: false,

            addCarPopup: false,
            removeCarConfirmationPopup: false,
            carRemovedPopup: false,
            vehicleRemovedName: '',
            dropdownOpen: false,

            brandsDropdown: false,
            brandOptions: [],
            brandSearchTerm: '',
            selectedBrand: null,

            yearDropdown: false,
            yearOptions: [
                {from: 1965, to: 1980, visible: true},
                {from: 1981, to: 1995, visible: true},
                {from: 1996, to: 2005, visible: true},
                {from: 2006, to: 2015, visible: true},
                {from: 2016, to: 2020, visible: true},
                {from: 2021, to: 2024, visible: true},
            ],
            yearSearchTerm: '',
            selectedYear: null,

            modelDropdown: false,
            modelOptions: [],
            modelSearchTerm: '',
            selectedModel: null,
            selectedModelName: null,

            engineDropdown: false,
            engineOptions: [],
            engineSearchTerm: '',
            selectedFuel: null,
            selectedFuelEngine: null,
        }
    },
    computed: {
        trans() {
            return {
                brandPlaceholder: this.translate('heroVehicleSearch', 'brand_placeholder'),
                brandPlaceholderActive: this.translate('heroVehicleSearch', 'brand_placeholder_active'),
                yearPlaceholder: this.translate('heroVehicleSearch', 'year_placeholder'),
                yearPlaceholderActive: this.translate('heroVehicleSearch', 'year_placeholder_active'),
                modelPlaceholder: this.translate('heroVehicleSearch', 'model_placeholder'),
                modelPlaceholderActive: this.translate('heroVehicleSearch', 'model_placeholder_active'),
                enginePlaceholder: this.translate('heroVehicleSearch', 'engine_placeholder'),
                enginePlaceholderActive: this.translate('heroVehicleSearch', 'engine_placeholder_active'),
                from: this.translate('heroVehicleSearch', 'from'),
                to: this.translate('heroVehicleSearch', 'to'),
            }
        },
        vehicles() {
            return this.$store.state.myVehicles;
        }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        openAddCarPopup() {
            this.addCarPopup = true;
            document.getElementsByTagName('html')[0].style.overflow = "hidden";
        },
        focusBrandsDropdown() {
            this.brandsDropdown = true;
            this.yearDropdown = false;
            this.modelDropdown = false;
            this.engineDropdown = false;

            let vm = this;
            setTimeout(function () {
                vm.$refs.brandsSelect.focus();
                vm.dropdownOpen = true;
            }, 10);
        },
        searchBrand(event) {
            this.brandSearchTerm = event.target.value.toLowerCase();

            this.brandOptions.map((bo) => {
                if (!this.brandSearchTerm) {
                    bo.x = true;
                } else {
                    bo.visible = bo.name.toLowerCase().includes(this.brandSearchTerm);
                }
            });
        },
        selectBrand(brand) {
            if (this.selectedBrand !== brand) {

                this.selectedBrand = brand;
                this.brandSearchTerm = '';
                this.brandOptions.map((bo) => {
                    bo.visible = true;
                });

                this.selectedYear = null;
                this.selectedModel = null;
                this.selectedModelName = null;
                this.selectedFuel = null;
                this.selectedFuelEngine = null;
            }

            this.closeBrandsDropdown();
            this.focusYearDropdown();
        },
        closeBrandsDropdown() {
            if (this.brandsDropdown) {
                this.brandsDropdown = false;
                this.dropdownOpen = false;
            }
        },
        focusYearDropdown() {
            if (this.selectedBrand) {
                this.brandsDropdown = false;
                this.yearDropdown = true;
                this.modelDropdown = false;
                this.engineDropdown = false;

                let vm = this;
                setTimeout(function () {
                    vm.$refs.yearSelect.focus();
                    vm.dropdownOpen = true;
                }, 10);
            }
        },
        searchYear(event) {
            this.yearSearchTerm = event.target.value.toLowerCase();

            this.yearOptions.map((yo) => {
                if (!this.yearSearchTerm) {
                    yo.visible = true;
                } else {
                    yo.visible = (yo.from + ' - ' + yo.to).includes(this.yearSearchTerm);
                }
            });
        },
        selectYear(from, to) {
            if (!this.selectedYear || this.selectedYear.from !== from || this.selectedYear.to !== to) {
                this.selectedYear = {
                    from: from,
                    to: to
                };

                this.yearSearchTerm = '';
                this.yearOptions.map((bo) => {
                    bo.visible = true;
                });

                let payload = {
                    brand_id: this.selectedBrand.id,
                    year: this.selectedYear
                }

                this.$store.dispatch('getVehicle', payload).then((data) => {
                    this.modelOptions = data.models;

                    this.selectedModel = null;
                    this.selectedModelName = null;
                    this.selectedFuel = null;
                    this.selectedFuelEngine = null;

                    this.closeYearDropdown();
                    this.focusModelDropdown();
                })
            } else {
                this.closeYearDropdown();
                this.focusModelDropdown();
            }
        },
        closeYearDropdown() {
            if (this.yearDropdown) {
                this.yearDropdown = false;
                this.dropdownOpen = false;
            }
        },
        focusModelDropdown() {
            if (this.selectedYear) {
                this.brandsDropdown = false;
                this.yearDropdown = false;
                this.modelDropdown = true;
                this.engineDropdown = false;

                let vm = this;
                setTimeout(function () {
                    vm.$refs.modelSelect.focus();
                    vm.dropdownOpen = true;
                }, 10);
            }
        },
        searchModel(event) {
            this.modelSearchTerm = event.target.value.toLowerCase();

            this.modelOptions.map((m) => {
                if (this.selectedModel) {
                    let findModelIndex = this.modelOptions.findIndex(mo => mo.id === this.selectedModel.id);
                    if (findModelIndex >= 0) {
                        this.modelOptions[findModelIndex].names.map((mn) => {
                            if (!this.modelSearchTerm) {
                                mn.visible = true;
                            } else {
                                mn.visible = mn.name.toLowerCase().includes(this.modelSearchTerm);
                            }
                        });
                    }
                } else {
                    if (!this.modelSearchTerm) {
                        m.visible = true;
                    } else {
                        m.visible = m.name.toLowerCase().includes(this.modelSearchTerm);
                    }
                }
            });
        },
        selectModel(model) {
            model.active = !model.active;

            if (model.active) {
                this.selectedModel = {
                    id: model.id,
                    name: model.name,
                };
            } else {
                this.selectedModel = null;
            }

            let vm = this;
            setTimeout(function () {
                vm.$refs.modelSelect.focus();
                vm.dropdownOpen = true;
            }, 10);

            this.modelOptions.map((m) => {
                if (this.selectedModel) {
                    let findModelIndex = this.modelOptions.findIndex(mo => mo.id === this.selectedModel.id);
                    if (findModelIndex >= 0) {
                        this.modelOptions[findModelIndex].names.map((mn) => {
                            if (!this.modelSearchTerm) {
                                mn.visible = true;
                            } else {
                                mn.visible = mn.name.toLowerCase().includes(this.modelSearchTerm);
                            }
                        });
                    }
                } else {
                    if (!this.modelSearchTerm) {
                        m.visible = true;
                    } else {
                        m.visible = m.name.toLowerCase().includes(this.modelSearchTerm);
                    }
                }
            });
        },
        selectModelName(model, modelName) {
            if (!this.selectedModelName || this.selectedModelName.model_name_id !== modelName.id) {
                this.selectedModelName = {
                    model_id: model.id,
                    model_name_id: modelName.id,
                    name: modelName.name
                };

                this.modelSearchTerm = '';
                this.modelOptions.map((m) => {
                    m.visible = true;

                    m.names.map((mn) => {
                        mn.visible = true;
                    })
                });


                let fuel = [];
                modelName.engines.map((engine) => {
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
                    f.engines = modelName.engines.filter(engine => engine.fuel === f.name)
                });

                this.selectedFuel = null;
                this.selectedFuelEngine = null;

                this.engineOptions = fuel;
            }

            this.closeModelDropdown();
            this.focusEngineDropdown();
        },
        closeModelDropdown() {
            if (this.modelDropdown) {
                this.modelDropdown = false;
                this.dropdownOpen = false;
            }
        },
        focusEngineDropdown() {
            if (this.selectedModelName) {
                this.brandsDropdown = false;
                this.yearDropdown = false;
                this.modelDropdown = false;
                this.engineDropdown = true;

                let vm = this;
                setTimeout(function () {
                    vm.$refs.engineSelect.focus();
                    vm.dropdownOpen = true;
                }, 10);
            }
        },
        searchEngine(event) {
            this.engineSearchTerm = event.target.value.toLowerCase();

            this.engineOptions.map((fuel) => {
                if (this.selectedFuel) {
                    let findFuelIndex = this.engineOptions.findIndex(f => f.id === this.selectedFuel.id);
                    if (findFuelIndex >= 0) {
                        this.engineOptions[findFuelIndex].engines.map((e) => {
                            if (!this.engineSearchTerm) {
                                e.visible = true;
                            } else {
                                e.visible = (e.name + ' (' + e.power + ')').toLowerCase().includes(this.engineSearchTerm);
                            }
                        });
                    }
                } else {
                    if (!this.engineSearchTerm) {
                        fuel.visible = true;
                    } else {
                        fuel.visible = this.translate('heroVehicleSearch', fuel.name).toLowerCase().includes(this.engineSearchTerm);
                    }
                }
            });
        },
        selectFuel(fuel) {
            fuel.active = !fuel.active;

            if (fuel.active) {
                this.selectedFuel = {
                    name: fuel.name
                };
            } else {
                this.selectedFuel = null;
            }

            this.engineOptions.map((fuel) => {
                if (this.selectedFuel) {
                    let findFuelIndex = this.engineOptions.findIndex(f => f.id === this.selectedFuel.id);
                    if (findFuelIndex >= 0) {
                        this.engineOptions[findFuelIndex].engines.map((e) => {
                            if (!this.engineSearchTerm) {
                                e.visible = true;
                            } else {
                                e.visible = e.name.toLowerCase().includes(this.engineSearchTerm);
                            }
                        });
                    }
                } else {
                    if (!this.engineSearchTerm) {
                        fuel.visible = true;
                    } else {
                        fuel.visible = this.translate('heroVehicleSearch', fuel.name).toLowerCase().includes(this.engineSearchTerm);
                    }
                }
            });

            let vm = this;
            setTimeout(function () {
                vm.$refs.engineSelect.focus();
                vm.dropdownOpen = true;
            }, 10);
        },
        selectFuelEngine(fuelEngine) {
            if (!this.selectedFuelEngine || this.selectedFuelEngine.id !== fuelEngine.id) {
                this.selectedFuelEngine = {
                    id: fuelEngine.id,
                    name: fuelEngine.name,
                    power: fuelEngine.power,
                    fuel: fuelEngine.fuel,
                    cm3: fuelEngine.cm3,
                    engine_code: fuelEngine.engine_code,
                    year_range: fuelEngine.year_from + '-' + fuelEngine.year_to
                };

                this.engineSearchTerm = '';
                this.engineOptions.map((f) => {
                    f.visible = true;

                    f.engines.map((e) => {
                        e.visible = true;
                    })
                });

                this.closeEngineDropdown();
            }
        },
        closeEngineDropdown() {
            if (this.engineDropdown) {
                this.engineDropdown = false;
                this.dropdownOpen = false;
            }
        },
        addMyVehicle() {
            let payload = {
                locale: this.locale,
                active_vehicle_id: this.$store.state.activeVehicleId,
                vehicle_engine_id: this.selectedFuelEngine.id,
                year_from: this.selectedYear.from,
                year_to: this.selectedYear.to
            };

            this.$store.dispatch('addMyVehicle', payload).then((data) => {
                let findVehicleIndex = this.vehicles.findIndex(v => v.id === data.vehicle.id);
                if(findVehicleIndex < 0){
                    this.$store.state.myVehicles.push(data.vehicle);
                }

                this.closeAddCarPopup();

                this.selectedBrand =  null;
                this.brandSearchTerm = '';
                this.selectedYear = null;
                this.yearSearchTerm = '';
                this.selectedModel = null;
                this.selectedModelName = null;
                this.modelSearchTerm = '';
                this.modelOptions = [];
                this.selectedFuel = null;
                this.selectedFuelEngine = null;
                this.engineSearchTerm = '';
                this.engineOptions = [];
            });
        },
        handleClickOutside(event) {
            const brandsSelect = this.$refs.brandsSelect;
            if (brandsSelect && this.dropdownOpen && event) {
                if (!brandsSelect.contains(event.target) && event.target.classList[0] !== 'select-brand-item') {
                    this.closeBrandsDropdown();
                }
            }

            const yearSelect = this.$refs.yearSelect;
            if (yearSelect) {
                if (event && this.dropdownOpen && event) {
                    if (!yearSelect.contains(event.target) && event.target.classList[0] !== 'select-brand-item' && event.target.classList[0] !== 'select-year-item') {
                        this.closeYearDropdown();
                    }
                }
            }

            const modelSelect = this.$refs.modelSelect;
            if (modelSelect && this.dropdownOpen && event) {
                if (!modelSelect.contains(event.target) && event.target.classList[0] !== 'select-brand-item' && event.target.classList[0] !== 'select-year-item' && event.target.classList[0] !== 'select-model-item' && event.target.classList[0] !== 'dropdown' && event.target.classList[0] !== 'inner-dropdown' && event.target.classList[0] !== 'category-item' && event.target.classList[0] !== 'category-toggle' && event.target.classList[0] !== 'back-btn' && event.target.classList[0] !== 'back-btn-span') {
                    this.closeModelDropdown();
                }
            }

            const engineSelect = this.$refs.engineSelect;
            if (engineSelect && this.dropdownOpen && event) {
                if (!engineSelect.contains(event.target) && event.target.classList[0] !== 'select-brand-item' && event.target.classList[0] !== 'select-year-item' && event.target.classList[0] !== 'select-model-item' && event.target.classList[0] !== 'select-engine-item' && event.target.classList[0] !== 'dropdown' && event.target.classList[0] !== 'inner-dropdown' && event.target.classList[0] !== 'category-item' && event.target.classList[0] !== 'category-toggle' && event.target.classList[0] !== 'back-btn' && event.target.classList[0] !== 'back-btn-span') {
                    this.closeEngineDropdown();
                }
            }
        },
        closeAddCarPopup() {
            this.addCarPopup = false;
            document.getElementsByTagName('html')[0].style.overflow = "auto";
        },
        setMyVehicleActive(vehicle) {
            let payload = {
                id: vehicle.id,
            };

            this.$store.dispatch('setMyVehicleActive', payload).then(() => {
                let findVehicleIndex = this.vehicles.findIndex(v => v.id === vehicle.id);
                if (findVehicleIndex >= 0) {
                    if(vehicle.active) {
                        this.$store.state.myVehicles[findVehicleIndex].active = false;

                        if(this.$store.state.activeVehicle && this.$store.state.activeVehicle.vehicle_engine_id && this.$store.state.activeVehicle.vehicle_engine_id === this.$store.state.myVehicles[findVehicleIndex].vehicle_engine_id){
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
                        let findActiveVehicleIndex = this.vehicles.findIndex(v => v.active);
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
                            this.$store.state.activeVehicle = {
                                vehicle_engine_id: this.$store.state.myVehicles[findVehicleIndex].vehicle_engine_id,
                                brand: this.$store.state.myVehicles[findVehicleIndex].brand,
                                model: this.$store.state.myVehicles[findVehicleIndex].model,
                                modelName: this.$store.state.myVehicles[findVehicleIndex].modelName,
                                power: this.$store.state.myVehicles[findVehicleIndex].power,
                                fuel: this.$store.state.myVehicles[findVehicleIndex].fuel,
                                engine: this.$store.state.myVehicles[findVehicleIndex].engine,
                                cm3: this.$store.state.myVehicles[findVehicleIndex].cm3,
                                engine_code: this.$store.state.myVehicles[findVehicleIndex].engine_code,
                                year_range: this.$store.state.myVehicles[findVehicleIndex].year_from + '-' + this.$store.state.myVehicles[findVehicleIndex].year_to,
                            };
                        })
                    }
                }
            });
        },
        openRemoveCarConfirmationPopup(vehicle) {
            this.removeCarConfirmationPopup = {
                id: vehicle.id
            };
            document.getElementsByTagName('html')[0].style.overflow = "hidden";
        },
        closeRemoveCarConfirmationPopup() {
            this.removeCarConfirmationPopup = false;
            document.getElementsByTagName('html')[0].style.overflow = "auto";
        },
        deleteCar() {
            this.$store.dispatch('removeMyVehicle', this.removeCarConfirmationPopup.id).then(() => {
                let findVehicleIndex = this.vehicles.findIndex(v => v.id === this.removeCarConfirmationPopup.id);
                if(findVehicleIndex >= 0){
                    this.vehicleRemovedName = this.vehicles[findVehicleIndex].brand + ' ' + this.vehicles[findVehicleIndex].modelName;

                    if(this.$store.state.activeVehicle && this.$store.state.activeVehicle.vehicle_engine_id && this.$store.state.activeVehicle.vehicle_engine_id === this.$store.state.myVehicles[findVehicleIndex].vehicle_engine_id){
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

                    this.$store.state.myVehicles.splice(findVehicleIndex, 1);
                    this.closeRemoveCarConfirmationPopup();
                    this.openCarRemovedPopup();
                }
            });
        },
        openCarRemovedPopup() {
            this.carRemovedPopup = true;
            document.getElementsByTagName('html')[0].style.overflow = "hidden";
        },
        closeCarRemovedPopup() {
            this.carRemovedPopup = false;
            document.getElementsByTagName('html')[0].style.overflow = "auto";
        },
    },
    mounted() {
        this.brandOptions = this.vehicle_brands;
        this.viewLoaded = true;

        document.addEventListener('click', this.handleClickOutside);
    }
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

.sub-heading {
    display: block;
    margin: 0 0 32px 0;
    color: #49515A;
    font-size: 16px;
    line-height: 24px;
}

.my-cars {
    .list {
        display: flex;
        flex-direction: column;
        gap: 12px 0;
        margin: 0 0 40px 0;

        .item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            border: 1px solid #E9EAEC;
            border-radius: 8px;

            @media screen {
                @media (max-width: 575px) {
                    flex-direction: column;
                    align-items: flex-start;
                    justify-content: flex-start;
                }
            }

            .car-info {
                padding-right: 15px;

                .car-name {
                    display: block;
                    margin: 0 0 7px 0;
                    line-height: 16px;
                    font-size: 16px;
                    font-weight: 600;
                    color: #0D2441;
                }

                .details {
                    line-height: 18px;
                    font-size: 14px;

                    @media screen {
                        @media (max-width: 575px) {
                            li {
                                &:not(:last-child) {
                                    margin: 0 0 2px 0;
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
                    @media (max-width: 880px) AND (min-width: 576px) {
                        flex-direction: column;
                        align-items: flex-end;
                        gap: 8px 0;
                    }

                    @media (max-width: 575px) {
                        gap: 0 24px;
                        margin: 20px 0 0 0;
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
}

.content-popup {
    &.add-car-popup {
        .popup-content {
            .submit-form {
                padding: 8px 0 0 0;
            }
        }
    }

    &.remove-car-confirmation-popup {

    }

    &.car-removed-popup {

    }
}


</style>
