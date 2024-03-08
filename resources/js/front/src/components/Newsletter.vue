<template>
    <div class="newsletter">
        <div class="container">
        <div class="text">
            <h2 class="section-heading">{{ data.title }}</h2>
            <span v-html="data.description"></span>
        </div>

        <div class="form">
            <div class="success" v-if="success_message">{{ success_message }}</div>

            <div class="form-group d-flex">
                <input type="email" class="form-control" :placeholder="data.input_text" v-model="email">
                <button type="submit" class="btn btn-primary" @click="subscribe">{{ data.button_text }}</button>
            </div>
            <div class="error" v-if="email_validation">{{ email_validation }}</div>

            <div class="checkbox-holder">
                <input id="newsletter-checkbox" v-model="agree" name="checkbox" type="checkbox" @input="agreePrivacyPolicy">
                <label for="newsletter-checkbox" v-html="data.agree_text"></label>
            </div>
            <div class="error" v-if="agree_validation">{{ agree_validation }}</div>
        </div>
    </div>
    </div>
</template>

<script>
export default {
    name: 'Newsletter',
    props: ['data'],
    data() {
        return {
            email: '',
            agree: true,

            email_validation: null,
            agree_validation: null,

            success_message: null,

            trans:
                {
                    lv: {
                        'email_required': 'E-pasts ir obligāts lauks',
                        'email_format': 'Nekorekts e-pasta formāts',
                        'already_subscribed': 'Šis epasts jau ir jaunumu saņemšanas sarakstā',
                        'agree_privacy_policy': 'Lai pieteiktos jaunumiem, jums ir jāpiekrīt privātuma politikas noteikumiem',
                        'subscribed': 'Jūs esat veiksmīgi pieteicies jaunumu saņemšanai'
                    },
                    ru: {
                        'email_required': 'E-pasts ir obligāts lauks',
                        'email_format': 'Nekorekts e-pasta formāts',
                        'already_subscribed': 'Šis epasts jau ir jaunumu saņemšanas sarakstā',
                        'agree_privacy_policy': 'Lai pieteiktos jaunumiem, jums ir jāpiekrīt privātuma politikas noteikumiem',
                        'subscribed': 'Jūs esat veiksmīgi pieteicies jaunumu saņemšanai'
                    },
                    en: {
                        'email_required': 'E-pasts ir obligāts lauks',
                        'email_format': 'Nekorekts e-pasta formāts',
                        'already_subscribed': 'Šis epasts jau ir jaunumu saņemšanas sarakstā',
                        'agree_privacy_policy': 'Lai pieteiktos jaunumiem, jums ir jāpiekrīt privātuma politikas noteikumiem',
                        'subscribed': 'Jūs esat veiksmīgi pieteicies jaunumu saņemšanai',
                    }
                },
        }
    },
    methods: {
        agreePrivacyPolicy() {
          this.agree === true ? this.agree = false : this.agree = true
        },
        subscribe() {
            let payload = {
                email: this.email,
                agree: this.agree,
                language_id: 1
            };

            let locale = 'lv';

            this.$store.dispatch('subscribe', payload).then((data) => {
                this.email = '';
                this.success_message = this.trans[locale][data.message];
            }).catch(res => {
                if (res.errors) {
                    this.email_validation = res.errors.email ? this.trans[locale][res.errors.email[0]] : null;
                    this.agree_validation = res.errors.agree ? this.trans[locale][res.errors.agree[0]] : null;
                }
            });
        },
    },
    mounted() {}
}
</script>

<style lang="scss" scoped>
    .success {
        color: green;
        line-height: 1.25rem;
        font-size: 0.875rem;
        font-weight: 400;
        margin-bottom: 10px;
    }

    .error {
        color: #E72E2C;
        line-height: 1.25rem;
        font-size: 0.875rem;
        font-weight: 400;
        margin-top: 5px;
    }
</style>
