<template>
    <div class="header-search">
        <div class="form">
            <div class="form-group d-flex">
                <input type="text" class="form-control" :placeholder="trans.searchLong">
                <button type="submit" class="btn btn-primary">{{ trans.searchShort }}</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'HeaderSearch',
    props: ['locale'],
    data() {
        return {
            auth: false,
        }
    },
    computed: {
        trans() {
            return {
                searchLong: this.translate('search', 'search_long'),
                searchShort: this.translate('search', 'search_short'),
            }
        }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        openAuthPopup(type) {
            this.$store.state.authPopup = type;
        }
    },
    mounted() {}
}
</script>

<style lang="scss" scoped>
.header-search {
    flex-grow: 1;
    margin-right: 24px;

    @media screen {
        @media (max-width: 1129px) {
            display: none;
        }
    }

    .form {
        width: 100%;
    }

    .form-group {
        margin: 0;
        width: 100%;
    }

    .form-control {
        flex-grow: 1;
    }

    button[type="submit"],
    input[type="submit"] {
        margin: 0 0 0 8px;
    }
}
</style>
