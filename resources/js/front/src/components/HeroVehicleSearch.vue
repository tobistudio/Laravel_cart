<template>
    <div :class="['hero-search-overlay', dropdownOpen ? 'active' : '']"></div>

    <div class="form">
        <div :class="['hero-search-overlay', dropdownOpen ? 'active' : '']"></div>
        <div class="car-number">
            <div class="form-group d-flex">
                <div class="country">
                    <div>
                        <img src="/images/front/eu-stars.png" alt="">
                        <span class="name">LV</span>
                    </div>
                </div>

                <input type="text" name="" class="form-control" placeholder="AA 1234">
            </div>

            <button type="submit" class="search-btn btn btn-primary"></button>
        </div>

        <div class="mobile-sep">
            <span>vai</span>
        </div>

        <div class="car-parameters">
            <div :class="['form-group', 'w-210', brandsDropdown ? 'active' : '']">
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

            <div :class="['form-group', 'w-150', 'mobile-hidden', !selectedBrand ? 'disabled' : '', yearDropdown ? 'active' : '']">
                <div class="icon" v-if="yearDropdown"></div>

                <div class="form-control placeholder" v-if="!yearDropdown" @click="focusYearDropdown">
                    <span>{{ selectedYear ? selectedYear.from + ' - ' + selectedYear.to : trans.yearPlaceholder }}</span></div>
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

            <div :class="['form-group', 'w-220', 'mobile-hidden', !selectedYear ? 'disabled' : '', modelDropdown ? 'active' : '']">
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

            <div :class="['form-group', 'w-220', 'mobile-hidden', !selectedModelName ? 'disabled' : '', engineDropdown ? 'active' : '']">
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
                                <span class="category-toggle" v-if="!fuel.active && !selectedFuel">{{ translate('heroVehicleSearch', fuel.name) }}</span>

                                <ul class="submenu" v-if="fuel.active">
                                    <li class="back-btn" @click.prevent.stop="selectFuel(fuel)"><span
                                        class="back-btn-span">{{ translate('heroVehicleSearch', fuel.name) }}</span></li>

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

            <button type="submit" class="search-btn btn btn-primary"></button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'HeroVehicleSearch',
    props: ['locale', 'vehicle_brands', 'data', 'is_category'],
    data() {
        return {
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

            activeVehicleSet: false
        }
    },
    watch: {
        activeVehicle: {
            handler(newData, oldData) {
                if (!this.brandOptions.length) {
                    this.brandOptions = this.vehicle_brands;
                }

                if (this.$store.state.activeVehicleId) {
                    if(!this.activeVehicleSet || (oldData && newData.vehicle_engine_id !== oldData.vehicle_engine_id)) {
                        let payload = {
                            active_vehicle_id: this.$store.state.activeVehicleId,
                            vehicle_engine_id: newData.vehicle_engine_id,
                            year_from: newData.year_from,
                            year_to: newData.year_to,
                            redirect: false
                        };

                        this.$store.dispatch('activeVehicle', payload).then((data) => {
                            let findSelectedBrandIndex = this.brandOptions.findIndex(brand => brand.page_id === data.vehicle.vehicle_brand_id);
                            if (findSelectedBrandIndex >= 0) {
                                this.selectedBrand = this.brandOptions[findSelectedBrandIndex];

                                this.selectedYear = {
                                    from: data.vehicle.year_from,
                                    to: data.vehicle.year_to
                                };

                                let payload = {
                                    brand_id: this.selectedBrand.id,
                                    year: this.selectedYear
                                }

                                this.$store.dispatch('getVehicle', payload).then((d) => {
                                    this.modelOptions = d.models;

                                    let findSelectedModelIndex = this.modelOptions.findIndex(model => model.id === data.vehicle.vehicle_model_id);
                                    if (findSelectedModelIndex >= 0) {
                                        this.selectedModel = {
                                            id: this.modelOptions[findSelectedModelIndex].id,
                                            name: this.modelOptions[findSelectedModelIndex].name,
                                        };

                                        this.modelOptions[findSelectedModelIndex].active = true;

                                        let findSelectedModelNameIndex = this.modelOptions[findSelectedModelIndex].names.findIndex(name => name.id === data.vehicle.vehicle_model_name_id);
                                        if (findSelectedModelNameIndex >= 0) {

                                            this.selectedModelName = {
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
                                            if (findSelectedFuelIndex >= 0) {
                                                this.selectedFuel = {
                                                    name: this.engineOptions[findSelectedFuelIndex].name
                                                };

                                                this.engineOptions[findSelectedFuelIndex].active = true;

                                                let findSelectedFuelEngineIndex = this.engineOptions[findSelectedFuelIndex].engines.findIndex(fe => fe.id === data.vehicle.vehicle_engine_id);
                                                if (findSelectedFuelEngineIndex >= 0) {
                                                    this.selectedFuelEngine = {
                                                        id: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].id,
                                                        name: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].name,
                                                        power: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].power,
                                                        year_range: this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].year_from + '-' + this.engineOptions[findSelectedFuelIndex].engines[findSelectedFuelEngineIndex].year_to
                                                    };
                                                }
                                            }
                                        }
                                    }
                                });
                            }
                        })
                    }
                } else {
                    this.selectedBrand = null;
                    this.selectedYear = null;
                    this.modelOptions = [];
                    this.selectedModel = null;
                    this.selectedModelName = null;
                    this.engineOptions = [];
                    this.selectedFuel = null;
                    this.selectedFuelEngine = null;
                }
            },
            deep: true,
            immediate: true,
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
        activeVehicle() {
            return this.$store.state.activeVehicle;
        }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
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
                    bo.visible = true;
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

                let payload = {
                    active_vehicle_id: this.$store.state.activeVehicleId,
                    vehicle_engine_id: this.selectedFuelEngine.id,
                    year_from: this.selectedYear.from,
                    year_to: this.selectedYear.to,
                    redirect: !this.is_category
                };

                this.$store.dispatch('activeVehicle', payload).then((data) => {
                    this.activeVehicleSet = true;

                    this.$store.state.activeVehicle = {
                        vehicle_engine_id: this.selectedFuelEngine.id,
                        brand: this.selectedBrand.name,
                        model: this.selectedModel.name,
                        modelName: this.selectedModelName.name,
                        power: this.selectedFuelEngine.power,
                        fuel: this.selectedFuelEngine.fuel,
                        engine: this.selectedFuelEngine.name,
                        cm3: this.selectedFuelEngine.cm3,
                        engine_code: this.selectedFuelEngine.engine_code,
                        year_range: this.selectedFuelEngine.year_range,
                    }

                    this.closeEngineDropdown();

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
        closeEngineDropdown() {
            if (this.engineDropdown) {
                this.engineDropdown = false;
                this.dropdownOpen = false;
            }
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
    },
    mounted() {
        document.addEventListener('click', this.handleClickOutside);
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
</style>
