<template>
    <div class="content-heading-holder">
        <button type="button" class="mobile-back-btn"></button>
        <h1 class="content-heading">Adrešu grāmata</h1>
    </div>

    <div class="address-book">
        <div class="block">
            <h2 class="block-heading">Norēķinu adrese</h2>

            <ul>
                <li>Nav norādīta norēķinu adrese</li>
            </ul>
<!--            <ul>-->
<!--                <li>Rolands Rautmanis</li>-->
<!--                <li>Brīvības iela 12, Rīga,</li>-->
<!--                <li>LV-1010, Latvija</li>-->
<!--                <li>Tālrunis: +371 27 454 454</li>-->
<!--            </ul>-->

            <button type="button" class="btn-add-red" @click="openAddPopup">Pievienot adresi</button>
<!--            <button type="button" class="btn-edit" @click="openAddPopup"><span>Labot</span></button>-->
        </div>

        <div class="block">
            <h2 class="block-heading">Piegādes adrese</h2>

            <ul>
                <li>Nav norādīta piegādes adrese</li>
            </ul>
<!--            <ul>-->
<!--                <li>Rolands Rautmanis</li>-->
<!--                <li>Brīvības iela 12, Rīga,</li>-->
<!--                <li>LV-1010, Latvija</li>-->
<!--                <li>Tālrunis: +371 27 454 454</li>-->
<!--            </ul>-->

            <button type="button" class="btn-add-red" @click="openAddPopup">Pievienot adresi</button>
<!--            <button type="button" class="btn-edit" @click="openAddPopup"><span>Labot</span></button>-->
        </div>

        <div v-if="addPopup" class="content-popup add-popup">
            <div class="content">
                <div class="popup-header">
                    <h4 class="heading">Pievienot norēķinu adresi</h4>
                    <p>Norādiet norēķinu piegādes adresi</p>

                    <div @click="closeAddPopup" class="close"></div>
                </div>

                <div class="popup-content">
                    <div class="form">
                        <div class="form-group required">
                            <label>Valsts</label>

                            <p>select html below</p>
                        </div>

                        <div :class="['form-group', 'dropdown-search', countriesDropdown ? 'active' : '']">
                            <div class="icon" v-if="countriesDropdown"></div>

                            <div class="form-control placeholder" v-if="!countriesDropdown" @click="focusCountriesDropdown">
                                <span>{{ selectedCountry ? selectedCountry.name : trans.countryPlaceholder }}</span>
                            </div>

                            <input v-else :value="countrySearchTerm ? countrySearchTerm : (selectedCountry && !countriesDropdown ? selectedCountry.name : '')" @input="searchCountry" type="text" ref="countriesSelect" :class="['form-control', countriesDropdown ? 'focused' : '']" :placeholder="trans.countryPlaceholderActive">

                            <div class="dropdown" v-if="countriesDropdown">
                                <ul class="inner-dropdown text-uppercase">
                                    <template v-for="country in countryOptions">
                                        <li v-if="country.visible" :class="['select-country-item', selectedCountry && selectedCountry.id === country.id ? 'active' : '']"
                                            @click="selectCountry(country)">
                                            {{ country.name }}
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>


                        <div class="form-group required">
                            <label>Pilsēta/ciems/pagasts/novads</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="form-group required">
                            <label>Ielas vai mājas nosaukums</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="form-group required m-0">
                            <label>Pasta indekss</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="submit-form">
                            <button type="submit" class="btn-submit btn btn-primary" @click="">Saglabāt</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'profileAddresses',
    props: ['locale'],
    data() {
        return {
            viewLoaded: false,

            addPopup: false,

            dropdownOpen: false,

            countriesDropdown: false,
            countryOptions: [
                {name: 'aaa', visible: true},
                {name: 'bbb', visible: true},
                {name: 'ccc', visible: true},
            ],
            countrySearchTerm: '',
            selectedCountry: null,
        }
    },
    computed: {
        trans() {
            return {
                countryPlaceholder: this.translate('profile', 'country_placeholder'),
                countryPlaceholderActive: this.translate('profile', 'country_placeholder_active'),
            }
        },
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        openAddPopup() {
            this.addPopup = true;
            document.getElementsByTagName('html')[0].style.overflow = "hidden";
        },
        focusCountriesDropdown() {
            this.countriesDropdown = true;

            let vm = this;
            setTimeout(function () {
                vm.$refs.countriesSelect.focus();
                vm.dropdownOpen = true;
            }, 10);
        },
        searchCountry(event) {
            this.countrySearchTerm = event.target.value.toLowerCase();

            this.countryOptions.map((bo) => {
                if (!this.countrySearchTerm) {
                    bo.visible = true;
                } else {
                    bo.visible = bo.name.toLowerCase().includes(this.countrySearchTerm);
                }
            });
        },
        selectCountry(country) {
            if (this.selectedCountry !== country) {

                this.selectedCountry = country;
                this.countrySearchTerm = '';
                this.countryOptions.map((bo) => {
                    bo.visible = true;
                });
            }

            this.closeCountriesDropdown();
        },
        closeCountriesDropdown() {
            if (this.countriesDropdown) {
                this.countriesDropdown = false;
                this.dropdownOpen = false;
            }
        },
        closeAddPopup() {
            this.addPopup = false;
            document.getElementsByTagName('html')[0].style.overflow = "auto";
        },
        handleClickOutside(event) {
            const countriesSelect = this.$refs.countriesSelect;
            if (countriesSelect && this.dropdownOpen && event) {
                if (!countriesSelect.contains(event.target) && event.target.classList[0] !== 'select-country-item') {
                    this.closeCountriesDropdown();
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

    .address-book {
        display: flex;
        gap: 0 200px;

        @media screen {
            @media (max-width: 991px) {
                flex-direction: column;
                gap: 46px 0;
            }

            @media (max-width: 575px) {
                gap: 69px 0;
            }
        }

        .block {
            .block-heading {
                margin: 0 0 16px 0;
                font-size: 16px;
                font-weight: 600;
                line-height: 16px;
                color: #0D2441;

                @media screen {
                    @media (max-width: 575px) {
                        margin: 0 0 12px 0;
                    }
                }
            }

            p {
                margin: 0 0 16px 0;
                line-height: 24px;
                color: #49515A;
            }

            ul {
                margin: 0 0 11px 0;

                li {
                    line-height: 24px;
                    color: #49515A;

                    @media screen {
                        @media (max-width: 575px) {
                            line-height: 20px;
                            font-size: 14px;
                        }
                    }
                }
            }
        }
    }
</style>
