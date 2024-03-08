<template>
    <li class="mobile-search">
        <div class="icon">
            <img src="/images/front/mobile-header-search-icon.svg" alt="">
        </div>
    </li>
</template>

<script>
export default {
    name: 'HeaderSearchMobile',
    data() {
        return {
            auth: false,
        }
    },
    methods: {
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
