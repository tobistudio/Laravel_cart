<template>
    <div class="popup" v-if="authPopup">
        <div v-if="authPopup === 'login'">
            <div class="popup-content login">
                <div class="image"></div>

                <div class="details">
                    <h5 class="name">{{ trans.loginTitle }}</h5>

                    <div class="social-media-auth">
                        <a href="#" class="btn google-btn">
                            <span>Google</span>
                        </a>

                        <a href="#" class="btn fb-btn">
                            <span>Facebook</span>
                        </a>
                    </div>

                    <div class="sep"><span>{{ trans.loginOr }}</span></div>

                    <div class="form">
                        <div :class="['form-group', 'required', loginEmailValidation ? 'error' : '', loginEmail.length > 0 ? 'with-content' : '']">
                            <input type="email" v-model="loginEmail" :class="['form-control', loginEmailFocusClass]" @focus="focusLoginEmail" @blur="blurLoginEmail">
                            <label>{{ trans.loginEmail }}</label>

                            <div class="error" v-if="loginEmailValidation">{{ trans.loginEmailValidation }}</div>
                        </div>

                        <div :class="['form-group', 'm-0', 'required', loginPasswordValidation ? 'error' : '', loginPassword.length > 0 ? 'with-content' : '']">
                            <div class="password-holder">
                                <input :type="!loginPasswordShow ? 'password' : ''" v-model="loginPassword" :class="['form-control', loginPasswordFocusClass]" @focus="focusLoginPassword" @blur="blurLoginPassword">
                                <label>{{ trans.loginPassword }}</label>

                                <div :class="['show-password', loginPasswordShow ? 'active' : '']" @click="showLoginPassword">show</div>
                            </div>


                            <div class="error" v-if="loginPasswordValidation">{{ trans.loginPasswordValidation }}</div>

                            <div class="remind-password">
                                <span @click="openAuthPopup('remindPassword')">{{ trans.loginForgotPassword }}</span>
                            </div>
                        </div>

                        <div class="submit-form">
                            <button type="submit" class="btn btn-primary" @click="login">{{ trans.loginLogin }}</button>
                        </div>

                        <div class="reg-cta">{{ trans.loginDontHaveAccount }} <span @click="openAuthPopup('register')">{{ trans.loginRegister }}</span></div>
                    </div>
                </div>

                <div @click="closeAuthPopup" class="close"></div>
            </div>
        </div>

        <div v-if="authPopup === 'register'">
            <div class="popup-content register">
                <div class="image"></div>

                <div class="details">
                    <h5 class="name">{{ trans.registerTitle }}</h5>

                    <div class="social-media-auth">
                        <a href="#" class="btn google-btn">
                            <span>Google</span>
                        </a>

                        <a href="#" class="btn fb-btn">
                            <span>Facebook</span>
                        </a>
                    </div>

                    <div class="sep"><span>{{ trans.registerOr }}</span></div>

                    <div class="form">
                        <div :class="['form-group', 'required', registerNameValidation ? 'error' : '', registerName.length > 0 ? 'with-content' : '']">
                            <input type="text" v-model="registerName" :class="['form-control', registerNameFocusClass]" @focus="focusRegisterName" @blur="blurRegisterName">
                            <label>{{ trans.registerName }}</label>

                            <div class="error" v-if="registerNameValidation">{{ trans.registerNameValidation }}</div>
                        </div>

                        <div :class="['form-group', 'required', registerEmailValidation ? 'error' : '', registerEmail.length > 0 ? 'with-content' : '']">
                            <input type="email" v-model="registerEmail" :class="['form-control', registerEmailFocusClass]" @focus="focusRegisterEmail" @blur="blurRegisterEmail">
                            <label>{{ trans.registerEmail }}</label>

                            <div class="error" v-if="registerEmailValidation">{{ trans.registerEmailValidation }}</div>
                        </div>

                        <div :class="['form-group', 'required', registerPasswordValidation ? 'error' : '', registerPassword.length > 0 ? 'with-content' : '']">
                           <div class="password-holder">
                                <input :type="!registerPasswordShow ? 'password' : ''" v-model="registerPassword" :class="['form-control', registerPasswordFocusClass]" @focus="focusRegisterPassword" @blur="blurRegisterPassword">
                                <label>{{ trans.registerPassword }}</label>

                                <div :class="['show-password', registerPasswordShow ? 'active' : '']" @click="showRegisterPassword">show</div>
                           </div>

                            <div class="error" v-if="registerPasswordValidation">{{ trans.registerPasswordValidation }}</div>

                            <div class="strength">
                                Lai parole būtu droša, tai jāsatur zemāk minētās prasības:

                                <div class="min-letters">
                                    <div :class="['icon', validateLength ? 'passed' : '']"></div>
                                    Vismaz 8 rakstzīmes
                                </div>
                                <div class="all-caps">
                                    <div :class="['icon', validateUpperCase ? 'passed' : '']">
                                        {{ validateUpperCase ? 'Yes' : 'No' }}
                                    </div>
                                    1 lielais burts
                                </div>
                                <div class="no-caps">
                                    <div :class="['icon', validateLowerCase ? 'passed' : '']">
                                        {{ validateLowerCase ? 'Yes' : 'No' }}
                                    </div>
                                    1 mazais burts
                                </div>
                                <div class="digit-or-symbol">
                                    <div :class="['icon', validateDigitSymbol ? 'passed' : '']">
                                        {{ validateDigitSymbol ? 'Yes' : 'No' }}
                                    </div>
                                    1 cipars vai īpašā rakstzīme
                                </div>
                            </div>
                        </div>

                        <div :class="['form-group', 'required', registerPasswordConfirmationValidation ? 'error' : '', registerPasswordConfirmation.length > 0 ? 'with-content' : '']">
                            <div class="password-holder">
                                <input :type="!registerPasswordConfirmationShow ? 'password' : ''" v-model="registerPasswordConfirmation" :class="['form-control', registerPasswordConfirmationFocusClass]" @focus="focusRegisterPasswordConfirmation" @blur="blurRegisterPasswordConfirmation">
                                <label>{{ trans.registerPasswordConfirmation }}</label>

                                <div :class="['show-password', registerPasswordConfirmationShow ? 'active' : '']" @click="showRegisterPasswordConfirmation">show</div>
                            </div>

                            <div class="error" v-if="registerPasswordConfirmationValidation">{{ trans.registerPasswordConfirmationValidation }}</div>
                        </div>

                        <div class="submit-form">
                            <button type="submit" class="btn btn-primary" @click="register">{{ trans.registerRegister }}</button>
                        </div>

                        <div class="reg-cta">{{ trans.registerAlreadyRegistered }} <span @click="openAuthPopup('login')">{{ trans.registerLogin }}</span></div>
                    </div>
                </div>

                <div @click="closeAuthPopup" class="close"></div>
            </div>
        </div>
        <div v-if="authPopup === 'registerSuccess'">
            <div class="popup-content register-success">
                <div class="image"></div>

                <div class="details">
                    <h5 class="name">Reģistrācija veiksmīga!</h5>
                    <p class="sub-text">Apsveicam! Tavs konts tika veiksmīgi izveidots.</p>
                    <p class="sub-text">Uz Tavu norādīto e-pasta adresi - <span class="highlight">{{ registerEmail}}</span> tika nosūtīta informācija par paroles E-pasta adreses apstiprināšanu.</p>

                    <div class="form">
                        <div class="submit-form">
                            <button type="submit" class="btn btn-primary" @click="openAuthPopup('login')">Pieslēgties</button>
                        </div>
                    </div>
                </div>

                <div @click="closeAuthPopup" class="close"></div>
            </div>
        </div>
        <div v-if="authPopup === 'emailVerified'">
            <div class="popup-content email-verified-success">
                <div class="image"></div>

                <div class="details">
                    <h5 class="name">Epasts veiksmīgi verificēts!</h5>
                    <p class="sub-text">Apsveicam! Tavs konts tika veiksmīgi apstiprināts.</p>

                    <div class="form">
                        <div class="submit-form">
                            <button type="submit" class="btn btn-primary" @click="closeAuthPopup" v-if="this.$store.state.token">Aizvērt</button>
                            <button type="submit" class="btn btn-primary" @click="openAuthPopup('login')">Pieslēgties</button>
                        </div>
                    </div>
                </div>

                <div @click="closeAuthPopup" class="close"></div>
            </div>
        </div>

        <div v-if="authPopup === 'remindPassword'">
            <div class="popup-content forgot-password">
                <div class="image"></div>

                <div class="details">
                    <h5 class="name">{{ trans.remindPasswordTitle }}</h5>
                    <p class="sub-text">{{ trans.remindPasswordDescription }}</p>

                    <div class="form">
                        <div :class="['form-group', 'required', remindPasswordEmailValidation ? 'error' : '', remindPasswordEmail.length > 0 ? 'with-content' : '']">
                            <input type="email" v-model="remindPasswordEmail" :class="['form-control', remindPasswordEmailFocusClass]" @focus="focusRemindPasswordEmail" @blur="blurRemindPasswordEmail">
                            <label>{{ trans.remindPasswordEmail }}</label>

                            <div class="error" v-if="remindPasswordEmailValidation">{{ trans.remindPasswordEmailValidation }}</div>
                        </div>

                        <div class="submit-form">
                            <button @click="remindPassword" type="submit" class="btn btn-primary">{{ trans.remindPasswordRemindPassword }}</button>
                        </div>

                        <div class="reg-cta">{{ trans.remindPasswordRememberedPassword }} <span @click="openAuthPopup('login')">{{ trans.remindPasswordLogin }}</span></div>
                    </div>
                </div>

                <div @click="closeAuthPopup" class="close"></div>
            </div>
        </div>
        <div v-if="authPopup === 'remindPasswordSuccess'">
            <div class="popup-content forgot-password-success">
                <div class="image"></div>

                <div class="details">
                    <h5 class="name">Paroles atjaunošana ir veiksmīga</h5>
                    <p class="sub-text">Uz Tavu norādīto e-pasta adresi - <span class="highlight">{{ remindPasswordEmail }}</span> tika nosūtīta informācija par paroles atjaunošanu.</p>

                    <div class="submit-form">
                        <button @click="closeAuthPopup" type="submit" class="btn btn-primary">Aizvērt</button>
                    </div>
                </div>

                <div @click="closeAuthPopup" class="close"></div>
            </div>
        </div>

        <div v-if="authPopup === 'resetPassword'">
            <div class="popup-content reset-password">
                <div class="image"></div>

                <div class="details">
                    <h5 class="name">{{ trans.resetPasswordTitle }}</h5>

                    <div class="form">
                        <div :class="['form-group', 'required', resetPasswordPasswordValidation ? 'error' : '', resetPasswordPassword.length > 0 ? 'with-content' : '']">
                            <div class="password-holder">
                                <input :type="!resetPasswordPasswordShow ? 'password' : ''" v-model="resetPasswordPassword" :class="['form-control', resetPasswordPasswordFocusClass]" @focus="focusResetPasswordPassword" @blur="blurResetPasswordPassword">
                                <label>{{ trans.resetPasswordPassword }}</label>

                                 <div :class="['show-password', resetPasswordPasswordShow ? 'active' : '']" @click="showResetPasswordPassword">show</div>
                            </div>


                            <div class="error" v-if="resetPasswordPasswordValidation">{{ trans.resetPasswordPasswordValidation }}</div>

                            <div class="strength">
                                <span class="block-heading">Lai parole būtu droša, tai jāsatur zemāk minētās prasības:</span>

                                <div class="min-letters">
                                    <div :class="['icon', validateLength ? 'passed' : '']"></div>
                                    Vismaz 8 rakstzīmes
                                </div>
                                <div class="all-caps">
                                    <div :class="['icon', validateUpperCase ? 'passed' : '']">
                                        {{ validateUpperCase ? 'Yes' : 'No' }}
                                    </div>
                                    1 lielais burts
                                </div>
                                <div class="no-caps">
                                    <div :class="['icon', validateLowerCase ? 'passed' : '']">
                                        {{ validateLowerCase ? 'Yes' : 'No' }}
                                    </div>
                                    1 mazais burts
                                </div>
                                <div class="digit-or-symbol">
                                    <div :class="['icon', validateDigitSymbol ? 'passed' : '']">
                                        {{ validateDigitSymbol ? 'Yes' : 'No' }}
                                    </div>
                                    1 cipars vai īpašā rakstzīme
                                </div>
                            </div>
                        </div>

                        <div :class="['form-group', 'required', resetPasswordPasswordConfirmationValidation ? 'error' : '', resetPasswordPasswordConfirmation.length > 0 ? 'with-content' : '']">
                            <div class="password-holder">
                                <input :type="!resetPasswordPasswordConfirmationShow ? 'password' : ''" v-model="resetPasswordPasswordConfirmation" :class="['form-control', resetPasswordPasswordConfirmationFocusClass]" @focus="focusResetPasswordPasswordConfirmation" @blur="blurResetPasswordPasswordConfirmation">
                                <label>{{ trans.resetPasswordPasswordConfirmation }}</label>
                                <div :class="['show-password', resetPasswordPasswordConfirmationShow ? 'active' : '']" @click="showResetPasswordConfirmation">show</div>
                            </div>

                            <div class="error" v-if="resetPasswordPasswordConfirmationValidation">{{ trans.resetPasswordPasswordConfirmationValidation }}</div>
                        </div>

                        <div class="submit-form">
                            <button @click="resetPassword" type="submit" class="btn btn-primary">{{ trans.resetPasswordResetPassword }}</button>
                        </div>
                    </div>
                </div>

                <div @click="closeAuthPopup" class="close"></div>
            </div>
        </div>
        <div v-if="authPopup === 'resetPasswordSuccess'">
            <div class="popup-content reset-password-success">
                <div class="image"></div>

                <div class="details">
                    <h5 class="name">Jaunā parole saglabāta!</h5>
                    <p class="sub-text">Tagad Tu vari pieslēgties savam rb24.lv kontam ar jauno paroli.</p>

                    <div class="submit-form">
                        <button @click="openAuthPopup('login')" type="submit" class="btn btn-primary">Pieslēgties</button>
                    </div>
                </div>

                <div @click="closeAuthPopup" class="close"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AuthPopup',
    props: ['extra'],
    data() {
        return {
            registerName: '',
            registerNameFocusClass: false,
            registerNameValidation: null,
            registerEmail: '',
            registerEmailFocusClass: false,
            registerEmailValidation: null,
            registerPassword: '',
            registerPasswordFocusClass: false,
            registerPasswordValidationLength: false,
            registerPasswordValidationAllCaps: false,
            registerPasswordValidationNoCaps: false,
            registerPasswordValidationSymbols: false,
            registerPasswordValidation: null,
            registerPasswordConfirmation: '',
            registerPasswordConfirmationFocusClass: false,
            registerPasswordConfirmationValidation: null,
            registerPasswordShow: false,
            registerPasswordConfirmationShow: false,

            loginEmail: '',
            loginEmailFocusClass: false,
            loginEmailValidation: null,
            loginPassword: '',
            loginPasswordFocusClass: false,
            loginPasswordValidation: null,
            loginPasswordShow: false,

            remindPasswordEmail: '',
            remindPasswordEmailFocusClass: false,
            remindPasswordEmailValidation: null,

            resetPasswordPassword: '',
            resetPasswordPasswordFocusClass: false,
            resetPasswordPasswordValidationLength: false,
            resetPasswordPasswordValidationAllCaps: false,
            resetPasswordPasswordValidationNoCaps: false,
            resetPasswordPasswordValidationSymbols: false,
            resetPasswordPasswordValidation: null,
            resetPasswordPasswordConfirmation: '',
            resetPasswordPasswordConfirmationFocusClass: false,
            resetPasswordPasswordConfirmationValidation: null,
            resetPasswordPasswordShow: false,
            resetPasswordPasswordConfirmationShow: false,
        }
    },
    computed: {
        trans() {
            return {
                registerTitle: this.translate('register', 'title'),
                registerOr: this.translate('register', 'or'),
                registerName: this.translate('register', 'name'),
                registerNameValidation: this.translate('register', this.registerNameValidation),
                registerEmail: this.translate('register', 'email'),
                registerEmailValidation: this.translate('register', this.registerEmailValidation),
                registerPassword: this.translate('register', 'password'),
                registerPasswordValidation: this.translate('register', this.registerPasswordValidation),
                registerPasswordConfirmation: this.translate('register', 'password_confirmation'),
                registerPasswordConfirmationValidation: this.translate('register', this.registerPasswordConfirmationValidation),
                registerRegister: this.translate('register', 'register'),
                registerLogin: this.translate('register', 'login'),
                registerAlreadyRegistered: this.translate('register', 'already_registered'),

                loginTitle: this.translate('login', 'title'),
                loginOr: this.translate('login', 'or'),
                loginEmail: this.translate('login', 'email'),
                loginEmailValidation: this.translate('login', this.loginEmailValidation),
                loginPassword: this.translate('login', 'password'),
                loginPasswordValidation: this.translate('login', this.loginPasswordValidation),
                loginForgotPassword: this.translate('login', 'forgot_password'),
                loginLogin: this.translate('login', 'login'),
                loginDontHaveAccount: this.translate('login', 'dont_have_account'),
                loginRegister: this.translate('login', 'register'),

                remindPasswordTitle: this.translate('remindPassword', 'title'),
                remindPasswordDescription: this.translate('remindPassword', 'description'),
                remindPasswordEmail: this.translate('remindPassword', 'email'),
                remindPasswordEmailValidation: this.translate('remindPassword', this.remindPasswordEmailValidation),
                remindPasswordRemindPassword: this.translate('remindPassword', 'remind_password'),
                remindPasswordRememberedPassword: this.translate('remindPassword', 'remembered_password'),
                remindPasswordLogin: this.translate('remindPassword', 'login'),

                resetPasswordTitle: this.translate('resetPassword', 'title'),
                resetPasswordPassword: this.translate('resetPassword', 'password'),
                resetPasswordPasswordValidation: this.translate('resetPassword', this.registerPasswordValidation),
                resetPasswordPasswordConfirmation: this.translate('resetPassword', 'password_confirmation'),
                resetPasswordPasswordConfirmationValidation: this.translate('resetPassword', this.registerPasswordConfirmationValidation),
                resetPasswordResetPassword: this.translate('resetPassword', 'reset_password'),
            }
        },
        authPopup() {
            return this.$store.state.authPopup;
        },
        validateLength(){
            if(this.$store.state.authPopup === 'register'){
                return this.registerPassword.length >= 8;
            } else if(this.$store.state.authPopup === 'resetPassword') {
                return this.resetPasswordPassword.length >= 8;
            }
        },
        validateUpperCase(){
            if(this.$store.state.authPopup === 'register'){
                return /[A-Z]/.test(this.registerPassword);
            } else if(this.$store.state.authPopup === 'resetPassword') {
                return /[A-Z]/.test(this.resetPasswordPassword);
            }
        },
        validateLowerCase(){
            if(this.$store.state.authPopup === 'register'){
                return /[a-z]/.test(this.registerPassword);
            } else if(this.$store.state.authPopup === 'resetPassword') {
                return /[a-z]/.test(this.resetPasswordPassword);
            }
        },
        validateDigitSymbol(){
            if(this.$store.state.authPopup === 'register'){
                return /[0-9]|[@$!%*?&#]/.test(this.registerPassword);
            } else if(this.$store.state.authPopup === 'resetPassword') {
                return /[0-9]|[@$!%*?&#]/.test(this.resetPasswordPassword);
            }
        }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.extra.locale][page][val]
        },
        openAuthPopup(type) {
            if(type === 'register'){
                this.registerEmail = '';
            }
            if(type === 'remindPassword'){
                this.remindPasswordEmail = '';
            }
            this.$store.state.authPopup = type;
        },
        closeAuthPopup() {
            this.$store.state.authPopup = null;

            document.getElementsByTagName('html')[0].style.overflow = "auto";
        },
        focusRegisterName() {
            this.registerNameFocusClass = 'focus';
        },
        blurRegisterName() {
            this.registerNameFocusClass = false;
        },
        focusRegisterEmail() {
            this.registerEmailFocusClass = 'focus';
        },
        blurRegisterEmail() {
            this.registerEmailFocusClass = false;
        },
        focusRegisterPassword() {
            this.registerPasswordFocusClass = 'focus';
        },
        blurRegisterPassword() {
            this.registerPasswordFocusClass = false;
        },
        focusRegisterPasswordConfirmation() {
            this.registerPasswordConfirmationFocusClass = 'focus';
        },
        blurRegisterPasswordConfirmation() {
            this.registerPasswordConfirmationFocusClass = false;
        },
        showRegisterPassword() {
            this.registerPasswordShow = !this.registerPasswordShow
        },
        showRegisterPasswordConfirmation() {
            this.registerPasswordConfirmationShow = !this.registerPasswordConfirmationShow
        },
        register() {
            let payload = {
                name: this.registerName,
                email: this.registerEmail,
                password: this.registerPassword,
                password_confirmation: this.registerPasswordConfirmation
            };

            this.$store.dispatch('customerRegister', payload)
                .then((data) => {
                    this.registerName = '';
                    this.registerNameValidation = null;
                    this.registerEmailValidation = null;
                    this.registerPassword = '';
                    this.registerPasswordValidation = null;
                    this.registerPasswordConfirmation = '';
                    this.registerPasswordConfirmationValidation = null;

                    this.$store.state.authPopup = 'registerSuccess';
                })
                .catch(res => {
                    this.registerNameValidation = null;
                    this.registerEmailValidation = null;
                    this.registerPassword = '';
                    this.registerPasswordValidation = null;
                    this.registerPasswordConfirmation = '';
                    this.registerPasswordConfirmationValidation = null;

                    if (res.errors) {
                        this.registerNameValidation = res.errors.name ? res.errors.name[0] : null;
                        this.registerEmailValidation = res.errors.email ? res.errors.email[0] : null;
                        this.registerPasswordValidation = res.errors.password ? res.errors.password[0] : null;
                        this.registerPasswordConfirmationValidation = res.errors.password_confirmation ? res.errors.password_confirmation[0] : null;
                    }
                });
        },
        focusLoginEmail() {
            this.loginEmailFocusClass = 'focus';
        },
        blurLoginEmail() {
            this.loginEmailFocusClass = false;
        },
        focusLoginPassword() {
            this.loginPasswordFocusClass = 'focus';
        },
        blurLoginPassword() {
            this.loginPasswordFocusClass = false;
        },
        showLoginPassword() {
            this.loginPasswordShow = !this.loginPasswordShow
        },
        login() {
            let payload = {
              email: this.loginEmail,
              password: this.loginPassword
            };

            this.$store.dispatch('customerLogin', payload)
                .then((data) => {
                    this.loginEmail = '';
                    this.loginEmailValidation = null;
                    this.loginPassword = '';
                    this.loginPasswordValidation = null;

                    window.location.replace(data.redirect);
                }).catch(res => {
                    this.loginEmailValidation = null;
                    this.loginPassword = '';
                    this.loginPasswordValidation = null;

                    if (res.errors) {
                        this.loginEmailValidation = res.errors.email ? res.errors.email[0] : null;
                        this.loginPasswordValidation = res.errors.password ? res.errors.password[0] : null;
                    }
                });
        },
        focusRemindPasswordEmail() {
            this.remindPasswordEmailFocusClass = 'focus';
        },
        blurRemindPasswordEmail() {
            this.remindPasswordEmailFocusClass = false;
        },
        remindPassword() {
            let payload = {
                email: this.remindPasswordEmail
            };

            this.$store.dispatch('customerRemindPassword', payload)
                .then((data) => {
                    this.remindPasswordEmailValidation = null;

                    this.$store.state.authPopup = 'remindPasswordSuccess';
                })
                .catch(res => {
                    this.remindPasswordEmailValidation = null;

                    if (res.errors) {
                        this.remindPasswordEmailValidation = res.errors.email ? res.errors.email[0] : null;
                    }
                });
        },
        focusResetPasswordPassword() {
            this.resetPasswordPasswordFocusClass = 'focus';
        },
        blurResetPasswordPassword() {
            this.resetPasswordPasswordFocusClass = false;
        },
        focusResetPasswordPasswordConfirmation() {
            this.resetPasswordPasswordConfirmationFocusClass = 'focus';
        },
        blurResetPasswordPasswordConfirmation() {
            this.resetPasswordPasswordConfirmationFocusClass = false;
        },
        showResetPasswordPassword() {
            this.resetPasswordPasswordShow = !this.resetPasswordPasswordShow
        },
        showResetPasswordConfirmation() {
            this.resetPasswordPasswordConfirmationShow = !this.resetPasswordPasswordConfirmationShow
        },
        resetPassword() {
            let payload = {
                token: this.extra.password_reset_token,
                new_password: this.resetPasswordPassword,
                new_password_confirmation: this.resetPasswordPasswordConfirmation
            };

            this.$store.dispatch('customerResetPassword', payload)
                .then((data) => {
                    this.resetPasswordPassword = '';
                    this.resetPasswordPasswordValidation = null;
                    this.resetPasswordPasswordConfirmation = '';
                    this.resetPasswordPasswordConfirmationValidation = null;

                    this.$store.state.authPopup = 'resetPasswordSuccess';
                })
                .catch(res => {
                    this.resetPasswordPassword = '';
                    this.resetPasswordPasswordValidation = null;
                    this.resetPasswordPasswordConfirmation = '';
                    this.resetPasswordPasswordConfirmationValidation = null;

                    if (res.errors) {
                        this.resetPasswordPasswordValidation = res.errors.new_password ? res.errors.new_password[0] : null;
                        this.resetPasswordPasswordConfirmationValidation = res.errors.new_password_confirmation ? res.errors.new_password_confirmation[0] : null;
                    }
                });
        },
    },
    mounted() {
        if(this.extra.email_verified){
            this.$store.state.authPopup = 'emailVerified';
        } else if(this.extra.reset_password) {
            this.$store.state.authPopup = 'resetPassword';
        } else if(this.$store.state.token){
            this.$store.state.authPopup = null;
        }
    }
}
</script>

<style lang="scss" scoped>
    .popup {
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(7, 20, 36, 0.70);
        z-index: 9999;

        @media screen {
            @media (max-width: 640px) {
                align-items: flex-start;

                > div {
                    height: 100%;
                    width: 100%;
                }
            }
        }

        .popup-content {
            position: relative;
            display: flex;
            min-width: 915px;
            min-height: 546px;
            background-color: #fafafa;
            border-radius: 14px;

            @media screen {
                @media (max-width: 991px) {
                    min-width: 1px;
                    width: calc(100vw - 82px);
                }

                @media (max-width: 640px) {
                    width: 100%;
                    flex-direction: column;
                    min-height: 100%;
                    border-radius: 0;
                }
            }

            > div {
                flex-basis: 50%;
                flex-shrink: 0;

                @media screen {
                    @media (max-width: 640px) {
                        flex-basis: 100%;
                    }
                }
            }

            .image {
                border-radius: 14px 0 0 14px;

                @media screen {
                    @media (max-width: 640px) {
                        min-height: 210px;
                        border-radius: 0;
                    }
                }
            }

            &.login {
                .image {
                    background: #E9EAEC url("../../../../front/images/login-popup-image.jpg") left center no-repeat;
                    background-size: cover;
                }
            }

            &.register {
                .image {
                    background: #E9EAEC url("../../../../front/images/register-popup-image.jpg") left center no-repeat;
                    background-size: cover;
                }
            }

            &.register-success {
                @media screen {
                    @media (min-width: 1200px) {
                        min-height: 662px;
                    }
                }

                .image {
                    background: #E9EAEC url("../../../../front/images/register-popup-image.jpg") left center no-repeat;
                    background-size: cover;
                }

                .details {
                    .name {
                        text-align: center;
                    }

                    a {
                        color: #E72E2C;

                        &:hover {
                            text-decoration: underline;
                        }
                    }
                }
            }

            &.email-verified-success {
                .image {
                    background: #E9EAEC url("../../../../front/images/forgot-password-popup-image.jpg") left center no-repeat;
                    background-size: cover;
                }

                .details {
                    text-align: center;
                }
            }

            &.forgot-password {
                .image {
                    background: #E9EAEC url("../../../../front/images/forgot-password-popup-image.jpg") left center no-repeat;
                    background-size: cover;

                    @media screen {
                        @media (max-width: 640px) {
                            background-position: center bottom;
                        }
                    }
                }

                .details {
                    .name {
                        margin: 0 0 8px 0;
                    }

                    .sub-text {
                        margin: 0 0 32px 0;
                        font-size: 16px;
                        font-weight: 400;
                        line-height: 24px;

                        @media screen {
                            @media (max-width: 991px) {
                                line-height: 20px;
                                font-size: 14px;
                            }
                        }
                    }
                }
            }

            &.forgot-password-success {
                .image {
                    background: #E9EAEC url("../../../../front/images/login-popup-image.jpg") left center no-repeat;
                    background-size: cover;
                }
            }

            &.reset-password {
                .image {
                    background: #E9EAEC url("../../../../front/images/forgot-password-popup-image.jpg") left center no-repeat;
                    background-size: cover;
                }
            }

            &.reset-password-success {
                .image {
                    background: #E9EAEC url("../../../../front/images/forgot-password-popup-image.jpg") left center no-repeat;
                    background-size: cover;
                }
            }

            &.register-success,
            &.email-verified-success,
            &.forgot-password-success,
            &.reset-password-success {
                .details {
                    .name {
                        margin: 0 0 8px 0;

                        &::before {
                            content: '';
                            display: block;
                            width: 100%;
                            height: 72px;
                            margin: 20px 0 35px 0;
                            background: url('../../../../front/images/popup-success-icon.svg') center center no-repeat;

                            @media screen {
                                @media (max-width: 640px) {
                                    margin: 0 0 30px 0;
                                }
                            }
                        }
                    }

                    .submit-form {
                        margin: 32px 0 0 0;
                    }
                }

            }

            .details {
                padding: 48px 48px 30px 48px;

                @media screen {
                    @media (max-width: 991px) {
                        padding: 48px 24px 30px 24px;
                    }

                    @media (max-width: 640px) {
                        padding: 32px 16px;
                    }
                }

                .name {
                    margin: 0 0 32px 0;
                    font-size: 24px;
                    font-weight: 600;
                    line-height: 30px;
                    letter-spacing: -0.48px;

                    @media screen {
                        @media (max-width: 767px) {
                            font-size: 20px;
                            line-height: 26px;
                        }
                    }
                }
            }

            .social-media-auth {
                display: flex;
                gap: 0 16px;
                margin: 0 0 24px 0;

                .btn {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 48px;
                    flex-basis: 50%;
                    padding: 0;
                    font-size: 16px;
                    border-radius: 8px;

                    span {
                        display: flex;
                        align-items: center;
                        justify-content: center;

                        &::before {
                            content: '';
                            margin: 0 12px 0 0;
                        }
                    }

                    &.google-btn {
                        border: 1px solid #CDCFD5;

                        span {
                            &::before {
                                width: 20px;
                                height: 20px;
                                background: url("../../../../front/images/google-icon.svg") no-repeat center;
                            }
                        }
                    }

                    &.fb-btn {
                        background: #3B5998;
                        color: #fff;

                        span {
                            &::before {
                                width: 10px;
                                height: 18px;
                                background: url("../../../../front/images/fb-icon.svg") no-repeat center;
                            }
                        }

                        &:hover {
                            background-color: rgb(35, 57, 94);
                        }
                    }
                }
            }

            .sep {
                display: flex;
                justify-content: center;
                position: relative;
                margin: 0 0 28px 0;
                text-align: center;

                &::before {
                    content: '';
                    position: absolute;
                    top: 3px;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    height: 1px;
                    margin: auto;
                    background-color: #e9eaec;
                }

                span {
                    padding: 0 8px;
                    line-height: 16px;
                    background-color: #fafafa;
                    color: #7D8391;
                    z-index: 1;
                }
            }

            .form {
                input, button {
                    width: 100%;
                }

                .form-control {
                    color: #0D2441;

                    + label {
                        position: absolute;
                        left: 16px;
                        line-height: 16px;
                        font-size: 16px;
                        color: #616571;
                        cursor: text;
                        transform: translateY(18px);
                        transition: all .3s ease-in-out;
                    }

                    &:focus {
                        padding-top: 21px;

                        + label {
                            line-height: 12px;
                            font-size: 12px;
                            transform: translateY(6px);

                            &::after {
                                line-height: 12px;
                                font-size: 12px;
                            }
                        }
                    }
                }

                .form-group {
                    position: relative;

                    &.m-0 {
                        margin: 0;
                    }

                    &.error {
                        .form-control {
                            border-color: #CD2C2C;
                        }

                        div.error {
                            padding: 6px 0 0 0;
                            line-height: 12px;
                            font-size: 12px;
                            color: #CD2C2C;
                        }
                    }

                    &.required {
                        label {
                            &::after {
                                content: '*';
                                margin: 0 0 0 3px;
                                line-height: 16px;
                                font-size: 16px;
                                color: #CD2C2C;
                            }
                        }
                    }

                    &.on-focus,
                    &.with-content {
                        .form-control {
                            padding-top: 21px;

                            + label {
                                line-height: 12px;
                                font-size: 12px;
                                transform: translateY(6px);

                                &::after {
                                    line-height: 12px;
                                    font-size: 12px;
                                }
                            }
                        }
                    }
                }

                .remind-password {
                    display: flex;
                    justify-content: flex-end;
                    padding: 6px 0 0 0;

                    span {
                        line-height: 14px;
                        font-size: 14px;
                        color: #0D2441;
                        cursor: pointer;
                        transition: all .3s ease-in-out;

                        &:hover {
                            color: #E72E2C;
                        }
                    }
                }

                .submit-form {
                    margin: 16px 0 32px 0;

                    .btn {
                        padding: 19px 20px;
                    }
                }

                .reg-cta {
                    line-height: 14px;
                    font-size: 14px;
                    color: #0D2441;
                    text-align: center;

                    span {
                        color: #E72E2C;
                        cursor: pointer;

                        &:hover {
                            text-decoration: underline;
                        }
                    }
                }
            }

            .close {
                position: absolute;
                top: 16px;
                right: 16px;
                width: 32px;
                height: 32px;
                flex-basis: 32px;
                background: #E9EAEC url("../../../../front/images/close-popup-icon.svg") center center no-repeat;
                cursor: pointer;
                transition: all 0.3s ease-in-out;
                border-radius: 8px;

                &:hover {
                    background-color: #d7d8d9;
                }
            }
        }
    }
</style>
