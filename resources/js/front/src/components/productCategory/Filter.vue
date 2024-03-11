<template>
    <div :class="`filter-option ${isOpen ? 'opened' : ''}`">
        <h4 class="filter-options-title" @click="isOpen = !isOpen">{{ data.translation.value }}</h4>

        <div class="filter-options-content">
            <ul class="items list">
                <li v-for="value in data.values" class="item">
                    <input
                        type="checkbox"
                        v-model="value.selected"
                        :name="`attribute-${data.id}`"
                        :id="`filter-${data.id}-${value.id}`"
                        @change="$emit('selectFilter', {
                            title: value.translation.value,
                            attributeID: data.id,
                            valueID: value.id,
                            selected: value.selected
                        })"
                    >
                    <label :id="`filter-${data.id}-${value.id}`">{{ value.translation.value }}</label>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Filter',

    props: [
        'data',
    ],

    emits: [
        'selectFilter',
    ],

    data() {
        return {
            isOpen: true,
        }
    },
}
</script>

<style scoped lang="scss">
.filter-option {
    &:not(:last-child) {
        margin-bottom: 24px;
        padding-bottom: 24px;
        border-bottom: 1px solid #E3E3E8;
    }

    .filter-options-title {
        position: relative;
        display: block;
        padding: 8px 30px 8px 0;
        line-height: 16px;
        cursor: pointer;

        @media screen {
            @media (max-width: 768px) {
                padding: 6px 30px 6px 0;
                line-height: 16px;
                font-size: 16px;
            }
        }

        &::after {
            content: '';
            display: block;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            margin: auto 0;
            width: 12px;
            height: 8px;
            background: url('../../../../../../resources/front/images/category-filters-arrow-down.svg') right center no-repeat;
            transition: all .3s ease-in-out;
        }
    }

    .filter-options-content {
        display: none;
        padding: 14px 0 0 0;

        .form-control {
            width: 100%;
        }

        .search-input {
            height: 42px;
            padding-right: 50px;
            border: 1px solid #D8DADE;
            background: url('../../../../../../resources/front/images/search-icon-dark.svg') calc(100% - 16px) center no-repeat;
            background-size: 20px;

            &::-webkit-input-placeholder {
                color: #7D8391;
            }

            &::-moz-placeholder {
                color: #7D8391;
            }

            &:-ms-input-placeholder {
                color: #7D8391;
            }

            &:-moz-placeholder {
                color: #7D8391;
            }

            &::placeholder {
                color: #7D8391;
            }

        }

        .items {
            .item {
                display: flex;
                align-items: center;
                gap: 0 8px;

                @media screen {
                    @media (max-width: 768px) {
                        font-size: 14px;
                    }
                }

                input {
                    margin: 0;

                    @media screen {
                        @media (max-width: 768px) {
                            width: 18px;
                            height: 18px;
                        }
                    }
                }

                input[type="checkbox"] + label {
                    margin: 0;
                    color: #0D2441;
                    font-size: 16px;

                    @media screen {
                        @media (max-width: 768px) {
                            font-size: 14px;
                        }
                    }
                }

                &:not(:last-child) {
                    margin-bottom: 12px;

                    @media screen {
                        @media (max-width: 768px) {
                            margin-bottom: 10px;
                        }
                    }
                }
            }
        }
    }

    &.nav-bar {
        .filter-options-title {
            display: flex;
            align-items: center;
            padding: 0;
            cursor: auto;

            span {
                pointer-events: none;
            }

            .back-btn {
                width: 18px;
                height: 18px;
                margin: 0 12px 0 0;
                background: #E72E2C url('../../../../../../resources/front/images/choose-vehicle-back-btn-arrow.svg') center center no-repeat;
                cursor: pointer;
                transition: all 0.3s ease-in-out;
                border-radius: 3px;
            }


            &::after {
                content: none;
            }

        }

        .filter-options-content {
            display: block;
        }

        .search-input {
            margin-bottom: 8px;
        }

        .items.nav-list {
            .item {
                display: block;
                margin: 0;

                > a {
                    display: block;
                    padding: 10px 0;
                    line-height: 16px;

                    @media screen {
                        @media (max-width: 768px) {
                            line-height: 14px;
                        }
                    }
                }

                &.current {
                    > a {
                        font-weight: 500;
                        color: #E72E2C;
                    }
                }

                &.parent {
                    position: relative;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;

                    & > div {
                        display: flex;
                        justify-content: end;
                        height: 36px;
                        align-items: center;
                        cursor: pointer;
                        flex-grow: 1;

                        &:hover {
                            & > svg {
                                & > path {
                                    fill: #E72E2C;
                                }
                            }
                        }

                        & > svg {
                            width: 6px;
                            height: 10px;
                        }
                    }
                }
            }
        }

    }

    &.opened {
        .filter-options-title {
            &::after {
                transform: rotate(180deg);
            }
        }

        .filter-options-content {
            display: block;
        }
    }
}
</style>
