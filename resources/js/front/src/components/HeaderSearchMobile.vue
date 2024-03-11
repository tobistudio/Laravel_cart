<template>
    <li class="mobile-search">
        <div class="icon">
            <img src="/images/front/mobile-header-search-icon.svg" :alt="trans.searchShort">
        </div>
    </li>
</template>

<script>
export default {
    name: 'HeaderSearchMobile',
    props: ['locale'],
    data() {
        return {
            auth: false,
        }
    },
    computed: {
        trans() {
            return {
                searchShort: this.translate('search', 'search_short'),
            }
        }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
    },
    mounted() {}
}
</script>

<style lang="scss" scoped>
@function rem($size) {
    @return calc($size / 16) * 1rem;
}

.mobile-search {
    margin: 0 25px 0 0;

    .icon {
        position: relative;
        flex-shrink: 0;
        display: flex;
        align-items: center;

        @media screen {
            @media (max-width: 575px) {
                margin: 0 16px 0 0;
            }
        }
    }

    @media screen {
        @media (min-width: 1130px) {
            display: none !important;
        }

        @media (max-width: 575px) {
            margin: 0 18px 0 0;
        }
    }
}
</style>
