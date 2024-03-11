<template>
    <a :href="link" class="btn btn-primary">{{ trans.linkText }}</a>
</template>

<script>
export default {
    name: 'Newsletter',
    props: ['locale', 'link', 'link_text'],
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
              linkText: this.translate('link', this.link_text),
          }
      }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        }
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
