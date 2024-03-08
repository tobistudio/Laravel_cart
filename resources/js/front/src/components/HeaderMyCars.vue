<template>
    <li class="user-auto">
        <button type="button" class="toggle-button">
            <div class="icon">
                <img src="/images/front/wheel-icon.svg" alt="">
                <span class="total-badge">0</span>
            </div>

            <span>Mani auto</span>
        </button>
    </li>
</template>

<script>
export default {
    name: 'HeaderMyCars',
    data() {
        return {
            auth: false,
        }
    },
    methods: {
        authPopup(type) {
            this.$store.state.authPopup = type;
        }
    },
    mounted() {}
}
</script>

<style lang="scss" scoped>
@function rem($size) {
    @return calc($size / 16) * 1rem;
}

.user-auto {
    margin: 0 18px 0 0;

    @media screen {
        @media (max-width: 1129px) {
            margin: 0 35px 0 0;
        }

        @media (max-width: 575px) {
            margin: 0 25px 0 0;
        }
    }

    .icon {
        position: relative;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        height: 40px;

        .total-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: -2px;
            right: -18px;
            height: 20px;
            min-width: 30px;
            padding: 0;
            line-height: 12px;
            background: #E72E2C;
            border: 1.5px solid #FAFAFA;
            color: #FAFAFA;
            font-family: Geologica;
            font-size: rem(12);
            font-weight: 500;
            border-radius: 20px;
        }

        @media screen {
            @media (min-width: 1130px) {
                margin: 0 21px 0 0;
            }
        }
    }

    .toggle-button {
        @media screen {
            @media (max-width: 1129px) {
                padding: 0;

                > span {
                    display: none;
                }
            }
        }

        @media screen {
            @media (min-width: 1130px) {
                position: relative;
                display: flex;
                align-items: center;
                padding: 0 15px 0 0;
                color: #0D2441;
                font-size: rem(14);
                cursor: pointer;

                &::after {
                    content: '';
                    position: absolute;
                    top: 0;
                    right: 0;
                    bottom: 0;
                    margin: auto 0;
                    width: 8px;
                    height: 6px;
                    background: url('../../../../front/images/user-auto-arrow-down.svg') right center no-repeat;
                    transition: all .3s ease-in-out;
                }
            }
        }
    }
}
</style>
