<template>
    <button type="button" class="product-catalog-btn" @click="openCatalogNavigation">
        <div class="icon-holder">
            <div class="icon"></div>
        </div>

        <span>{{ trans.title }}</span>
    </button>
</template>

<script>
export default {
    name: 'HeaderCatalogButton',
    props: ['locale'],
    data() {
        return {
            auth: false,
        }
    },
    computed: {
        trans() {
            return {
                title: this.translate('navigation', 'title'),
            }
        },
    },
    methods: {
        translate(page, val) {
            const defTransaltions = {
                title: 'Navigation menu',
            }

            if (this.$store.state.currentTranslations[this.locale][page]) {
                return this.$store.state.currentTranslations[this.locale][page][val];
            } else {
                return defTransaltions[val];
            }
        },
        openCatalogNavigation() {
            this.$store.state.catalogNavigation = true;

            document.getElementsByTagName('html')[0].style.overflow = "hidden";
        },
    },
    mounted() {
        if(this.$store.state.token){
            this.auth = true;
        }
    }
}
</script>

<style lang="scss" scoped>
@function rem($size) {
    @return calc($size / 16) * 1rem;
}

</style>
