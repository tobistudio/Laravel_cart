<template>
    <div class="newsletter">
        <div class="container">
        <div class="text">
            <h2 class="section-heading">{{ trans.title }}</h2>
            <span v-html="trans.description"></span>
        </div>

        <div class="form">
            <div class="success" v-if="success_message">{{ success_message }}</div>

            <div class="form-group d-flex">
                <input type="email" class="form-control" :placeholder="trans.inputText" v-model="email">
                <button type="submit" class="btn btn-primary" @click="subscribe">{{ trans.buttonText }}</button>
            </div>
            <div class="error" v-if="emailValidation">{{ trans.emailValidation }}</div>

            <div class="checkbox-holder">
                <input id="newsletter-checkbox" v-model="agree" name="checkbox" type="checkbox" @input="agreePrivacyPolicy">
                <label for="newsletter-checkbox">
                    {{ trans.agreeStart }}
                    <a :href="trans.agreeLink">{{ trans.agreeLinkText }}</a>
                    {{ trans.agreeEnd }}
                </label>
            </div>
            <div class="error" v-if="agreeValidation">{{ trans.agreeValidation }}</div>
        </div>
    </div>
    </div>
</template>

<script>
export default {
    name: 'Newsletter',
    props: ['locale'],
    data() {
        return {
            email: '',
            agree: true,

            emailValidation: null,
            agreeValidation: null,

            success_message: null,
        }
    },
    computed: {
      trans() {
          return {
              title: this.translate('newsletter', 'title'),
              description: this.translate('newsletter', 'description'),
              inputText: this.translate('newsletter', 'input_text'),
              buttonText: this.translate('newsletter', 'button_text'),
              agreeStart: this.translate('newsletter', 'agree_start'),
              agreeLink: this.translate('newsletter', 'agree_link'),
              agreeLinkText: this.translate('newsletter', 'agree_link_text'),
              agreeEnd: this.translate('newsletter', 'agree_end'),
              emailValidation: this.translate('newsletter', this.emailValidation),
              agreeValidation: this.translate('newsletter', this.agreeValidation),
          }
      }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        agreePrivacyPolicy() {
          this.agree === true ? this.agree = false : this.agree = true
        },
        subscribe() {
            let payload = {
                email: this.email,
                agree: this.agree,
                type: 'offers',
                locale: this.locale
            };

            this.$store.dispatch('subscribe', payload).then((data) => {
                this.email = '';
                this.success_message = this.translate('newsletter', data.message);
            }).catch(res => {
                if (res.errors) {
                    this.emailValidation = res.errors.email ? res.errors.email[0] : null;
                    this.agreeValidation = res.errors.agree ? res.errors.agree[0] : null;
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
