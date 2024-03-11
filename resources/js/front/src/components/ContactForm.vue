<template>
    <div class="contacts-form-block">
        <div class="image">
            <img src="/images/front/contacts-page-form-image.png" alt="">
        </div>

        <div class="form">
            <h2 class="section-heading">{{ data.title }}</h2>
            <div class="form-text" v-html="data.description"></div>

            <div class="success" v-if="success_message">{{ success_message }}</div>

            <div class="form-group required">
                <label>{{ trans.name }}</label>
                <input type="text" v-model="name" class="form-control">
                <div class="error" v-if="nameValidation">{{ trans.nameValidation }}</div>
            </div>

            <div class="form-group required">
                <label>{{ trans.email }}</label>
                <input type="email" v-model="email" class="form-control">
                <div class="error" v-if="emailValidation">{{ trans.emailValidation }}</div>
            </div>

            <div class="form-group required">
                <label>{{ trans.message }}</label>
                <textarea name="" v-model="message" class="form-control"></textarea>
                <div class="error" v-if="messageValidation">{{ trans.messageValidation }}</div>
            </div>

            <div class="submit-form">
                <button type="button" class="submit-form-btn btn btn-primary" @click="send">{{ data.button_text }}</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Newsletter',
    props: ['data', 'locale'],
    data() {
        return {
            name: '',
            nameValidation: null,
            email: '',
            emailValidation: null,
            message: '',
            messageValidation: null,

            success_message: null,
        }
    },
    computed: {
        trans() {
            return {
                name: this.translate('contactForm', 'name'),
                nameValidation: this.translate('contactForm', this.nameValidation),
                email: this.translate('contactForm', 'email'),
                emailValidation: this.translate('contactForm', this.emailValidation),
                message: this.translate('contactForm', 'message'),
                messageValidation: this.translate('contactForm', this.messageValidation),
            }
        }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        send() {
            let payload = {
                name: this.name,
                email: this.email,
                message: this.message,
                language_id: 1
            };

            this.$store.dispatch('sendMessage', payload).then((data) => {
                this.name = '';
                this.email = '';
                this.message = '';
                this.success_message = this.translate('contactForm', data.message);
            }).catch(res => {
                if (res.errors) {
                    this.nameValidation = res.errors.name ? res.errors.name[0] : null;
                    this.emailValidation = res.errors.email ? res.errors.email[0] : null;
                    this.messageValidation = res.errors.message ? res.errors.message[0] : null;
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
