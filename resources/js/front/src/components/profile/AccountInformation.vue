<template>
    <div class="content-heading-holder">
        <button type="button" class="mobile-back-btn"></button>
        <h1 class="content-heading">Konta Informācija</h1>
    </div>

    <div class="acount-information" v-if="viewLoaded">
        <h2 class="block-heading">Personīgā informācija</h2>

        <ul class="details">
            <li>
                <span class="span-label">Vārds</span>
                <span>{{ accountInformation.first_name }}</span>
            </li>

            <li>
                <span class="span-label">Uzvārds</span>
                <span>{{ accountInformation.last_name }}</span>
            </li>

            <li>
                <span class="span-label">E-pasta adrese</span>
                <a href="mailto:rolands@wdmarket.lv">{{ accountInformation.email }}</a>
            </li>

            <li>
                <span class="span-label">Tālrunis</span>
                <span>{{ accountInformation.phone_number ? accountInformation.phone_number : 'Nav norādīts' }}</span>
            </li>
        </ul>

        <div class="toolbar">
            <button type="button" class="btn-edit" @click="openAccountInformationPopup">Labot datus</button>
            <button type="button" class="btn-edit" @click="openChangePasswordPopup">Mainīt paroli</button>
        </div>

        <div v-if="accountInformationPopup" :class="['content-popup', accountInformationSuccessPopup ? 'success' : '']">
            <div class="content">
                <div class="popup-header">
                    <h4 class="heading" v-if="!accountInformationSuccessPopup">Labot personīgo informāciju</h4>
                    <p v-if="!accountInformationSuccessPopup">Labo savus personas datus vai kontaktinformāciju</p>

                    <div @click="closeAccountInformationPopup" class="close"></div>
                </div>

                <div class="popup-content">
                    <div class="form" v-if="!accountInformationSuccessPopup">
                        <div class="form-group">
                            <label>Vārds</label>
                            <input type="text" name="first_name" v-model="accountInformation.first_name" class="form-control" disabled>
                        </div>

                        <div class="form-group">
                            <label>Uzvārds</label>
                            <input type="text" name="last_name" v-model="accountInformation.last_name" class="form-control" disabled>
                        </div>

                        <div class="form-group">
                            <label>E-pasta adrese</label>
                            <input type="email" name="email" v-model="accountInformation.email" class="form-control" disabled>
                        </div>

                        <div class="form-group">
                            <label>Tālrunis</label>
                            <input type="text" name="phone_number" v-model="accountInformation.phone_number" class="form-control">
                        </div>

                        <div class="submit-form">
                            <button type="submit" class="btn-submit btn btn-primary" @click="saveAccountInformation">Saglabāt</button>
                        </div>
                    </div>

                    <div class="success-message" v-if="accountInformationSuccessPopup">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 72 72" fill="none">
                                <path d="M23.0391 36.3866L32.7157 46.2647C32.935 46.4885 33.3037 46.4579 33.483 46.2009L48.9591 24.0156" stroke="#49A041" stroke-width="3" stroke-linecap="round"/>
                                <circle cx="35.9996" cy="36.0016" r="30.9" stroke="#49A041" stroke-width="3"/>
                            </svg>
                        </div>

                        <span>Personīgā informācija veiksmīgi labota!</span>

                        <button type="submit" class="btn-submit btn btn-primary" @click="closeAccountInformationPopup">Aizvērt</button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="changePasswordPopup" :class="['content-popup', changePasswordSuccessPopup ? 'success' : '']">
            <div class="content">
                <div class="popup-header">
                    <h4 class="heading" v-if="!changePasswordSuccessPopup">Mainīt paroli</h4>
                    <p v-if="!changePasswordSuccessPopup">Izveido stipru un unikālu paroli</p>

                    <div @click="closeChangePasswordPopup" class="close"></div>
                </div>

                <div class="popup-content">
                    <div class="form" v-if="!changePasswordSuccessPopup">
                        <div class="form-group">
                            <label>Esošā parole</label>

                            <div class="password-holder">
                                <input :type="!currentPasswordShow ? 'password' : ''" v-model="currentPassword" :class="['form-control', currentPasswordFocusClass]" @focus="focusCurrentPassword" @blur="blurCurrentPassword">
                                <button type="button" :class="['show-password', currentPasswordShow ? 'active' : '']" @click="showCurrentPassword"></button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Jaunā parole</label>

                            <div class="password-holder">
                                <input :type="!newPasswordShow ? 'password' : ''" v-model="newPassword" :class="['form-control', newPasswordFocusClass]" @focus="focusNewPassword" @blur="blurNewPassword">
                                <button type="button" :class="['show-password', newPasswordShow ? 'active' : '']" @click="showNewPassword"></button>
                            </div>

                            <div class="strength">
                                Lai parole būtu droša, tai jāsatur zemāk minētās prasības:

                                <div class="min-letters">
                                    <div :class="['icon', validateLength ? 'passed' : '']"></div>
                                    Vismaz 8 rakstzīmes
                                </div>

                                <div class="all-caps">
                                    <div :class="['icon', validateUpperCase ? 'passed' : '']"></div>
                                    1 lielais burts
                                </div>

                                <div class="no-caps">
                                    <div :class="['icon', validateLowerCase ? 'passed' : '']"></div>
                                    1 mazais burts
                                </div>

                                <div class="digit-or-symbol">
                                    <div :class="['icon', validateDigitSymbol ? 'passed' : '']"></div>
                                    1 cipars vai īpašā rakstzīme
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Atkārtot paroli</label>

                            <div class="password-holder">
                                <input :type="!newPasswordConfirmationShow ? 'password' : ''" v-model="newPasswordConfirmation" :class="['form-control', newPasswordConfirmationFocusClass]" @focus="focusNewPasswordConfirmation" @blur="blurNewPasswordConfirmation">
                                <button type="button" :class="['show-password', newPasswordConfirmationShow ? 'active' : '']" @click="showNewPasswordConfirmation"></button>
                            </div>
                        </div>

                        <div class="submit-form">
                            <button type="submit" class="btn-submit btn btn-primary" @click="changePassword">Mainīt paroli</button>
                        </div>
                    </div>

                    <div class="success-message" v-if="changePasswordSuccessPopup">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 72 72" fill="none">
                                <path d="M23.0391 36.3866L32.7157 46.2647C32.935 46.4885 33.3037 46.4579 33.483 46.2009L48.9591 24.0156" stroke="#49A041" stroke-width="3" stroke-linecap="round"/>
                                <circle cx="35.9996" cy="36.0016" r="30.9" stroke="#49A041" stroke-width="3"/>
                            </svg>
                        </div>

                        <span>Paroles maiņa veiksmīga!</span>

                        <button type="submit" class="btn-submit btn btn-primary" @click="closeChangePasswordPopup">Aizvērt</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'profileAccountInformation',
    props: ['locale'],
    data() {
        return {
            viewLoaded: false,
            accountInformation: null,

            accountInformationPopup: false,
            accountInformationSuccessPopup: false,
            changePasswordPopup: false,
            changePasswordSuccessPopup: false,

            currentPassword: '',
            currentPasswordFocusClass: false,
            currentPasswordShow: false,
            currentPasswordValidation: null,

            newPassword: '',
            newPasswordFocusClass: false,
            newPasswordShow: false,
            newPasswordValidationLength: false,
            newPasswordValidationAllCaps: false,
            newPasswordValidationNoCaps: false,
            newPasswordValidationSymbols: false,
            newPasswordValidation: null,

            newPasswordConfirmation: '',
            newPasswordConfirmationFocusClass: false,
            newPasswordConfirmationShow: false,
            newPasswordConfirmationValidation: null,
        }
    },
    computed: {
        validateLength(){
            return this.newPassword.length >= 8;
        },
        validateUpperCase(){
            return /[A-Z]/.test(this.newPassword);
        },
        validateLowerCase(){
            return /[a-z]/.test(this.newPassword);
        },
        validateDigitSymbol(){
            return /[0-9]|[@$!%*?&#]/.test(this.newPassword);
        },
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        getAccountInformation() {
            this.$store.dispatch('getAccountInformation').then((data) => {
                this.accountInformation = data.account_information;

                this.viewLoaded = true;
            });
        },
        openAccountInformationPopup() {
            this.accountInformationPopup = true;
        },
        saveAccountInformation() {
            let payload = {
                phone_number: this.accountInformation.phone_number
            }

            this.$store.dispatch('saveAccountInformation', payload).then((data) => {
                this.accountInformationSuccessPopup = true;
            });
        },
        closeAccountInformationPopup(){
            this.accountInformationPopup = false;
            this.accountInformationSuccessPopup = false;
        },
        openChangePasswordPopup() {
            this.changePasswordPopup = true;
        },
        focusCurrentPassword() {
            this.currentPasswordFocusClass = 'focus';
        },
        blurCurrentPassword() {
            this.currentPasswordFocusClass = false;
        },
        showCurrentPassword() {
            this.currentPasswordShow = !this.currentPasswordShow
        },
        focusNewPassword() {
            this.newPasswordFocusClass = 'focus';
        },
        blurNewPassword() {
            this.newPasswordFocusClass = false;
        },
        showNewPassword() {
            this.newPasswordShow = !this.newPasswordShow
        },
        focusNewPasswordConfirmation() {
            this.newPasswordConfirmationFocusClass = 'focus';
        },
        blurNewPasswordConfirmation() {
            this.newPasswordConfirmationFocusClass = false;
        },
        showNewPasswordConfirmation() {
            this.newPasswordConfirmationShow = !this.newPasswordConfirmationShow
        },
        changePassword() {
            let payload = {
                current_password: this.currentPassword,
                new_password: this.newPassword,
                new_password_confirmation: this.newPasswordConfirmation
            };

            this.$store.dispatch('changePassword', payload)
                .then((data) => {
                    this.currentPassword = '';
                    this.currentPasswordValidation = null;

                    this.newPassword = '';
                    this.newPasswordValidation = null;

                    this.newPasswordConfirmation = '';
                    this.newPasswordConfirmationValidation = null;

                    this.changePasswordSuccessPopup = true;
                })
                .catch(res => {
                    this.currentPassword = '';
                    this.currentPasswordValidation = null;

                    this.newPassword = '';
                    this.newPasswordValidation = null;

                    this.newPasswordConfirmation = '';
                    this.newPasswordConfirmationValidation = null;

                    if (res.errors) {
                        this.currentPasswordValidation = res.errors.current_password ? res.errors.current_password[0] : null;
                        this.newPasswordValidation = res.errors.new_password ? res.errors.new_password[0] : null;
                        this.newPasswordConfirmationValidation = res.errors.new_password_confirmation ? res.errors.new_password_confirmation[0] : null;
                    }
                });
        },
        closeChangePasswordPopup() {
            this.changePasswordPopup = false;
            this.changePasswordSuccessPopup = false;
        },
    },
    mounted() {
        this.getAccountInformation()
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

    .acount-information {
        .details {
            display: flex;
            flex-direction: column;
            gap: 24px 0;

            li {
                line-height: 18px;
                color: #0D2441;

                span {
                    display: block;
                }

                .span-label {
                    display: block;
                    margin: 0 0 8px 0;
                    color: #616571;
                    line-height: 16px;
                }
            }
        }

        .toolbar {
            display: flex;
            gap: 0 24px;
            margin: 32px 0 0 0;

            @media screen {
                @media (max-width: 575px) {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 16px 0;
                    margin: 24px 0 0 0;
                }
            }
        }
    }
</style>
