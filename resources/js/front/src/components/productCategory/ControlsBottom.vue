<template>
    <div class="toolbar-products bottom">
        <div class="toolbar-amount">
            Rāda:
            <strong>{{ shows }}</strong> no
            <strong>{{ productCount }}</strong>
        </div>

        <ul class="pagination" v-if="pages > 1">
            <li class="page-item prev">
                <a class="page-link" href="#" @click="e => { e.preventDefault(); $emit('selectPage', currentPage > 1 ? currentPage - 1 : 1) }">Atpakaļ</a>
            </li>

            <li v-if="currentPage > 3" class="page-item sep">
                <span>...</span>
            </li>

            <li
                v-for="value in pages"
                :class="[
                    'page-item',
                    (value - currentPage > 1) || (currentPage - value > 1) ? 'hidden' : '',
                    value === (currentPage === 0 ? 1 : currentPage) ? 'active' : '',
                ]"
            >
                <a class="page-link" href="#" @click="e => { e.preventDefault(); $emit('selectPage', value) }">{{ value }}</a>
            </li>

            <li v-if="pages - currentPage > 2" class="page-item sep">
                <span>...</span>
            </li>

            <li class="page-item next">
                <a class="page-link" href="#" @click="e => { e.preventDefault(); $emit('selectPage', currentPage < pages ? currentPage + 1 : pages) }">Nākošā</a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'ControlsBottom',

    props: [
        'productCount',
        'currentPage',
        'showPerPage',
        'pages',
    ],

    emits: [
        'selectPage',
    ],

    computed: {
        shows() {
            const from = (this.currentPage > 0 ? this.currentPage : 1) * this.showPerPage - this.showPerPage;
            const to = (this.currentPage > 0 ? this.currentPage : 1) * this.showPerPage;

            return `${from} - ${to}`;
        }
    }
}
</script>

<style lang="scss" scoped>
     .toolbar-products.bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 48px 0 0 0;

        @media screen {
            @media (max-width: 767px) {
                flex-direction: column;
                justify-content: flex-start;
                align-items: flex-start;
            }

            @media (max-width: 575px) {
                margin: 38px 0 0 0;
            }
        }

        .toolbar-amount {
            color: #616571;
            font-size: 14px;

            @media screen {
                @media (max-width: 767px) {
                    margin: 0 0 34px 0;
                }

                @media (max-width: 575px) {
                    margin: 0 0 24px 0;
                    line-height: 12px;
                    font-size: 12px;
                }
            }

            strong {
                line-height: 14px;
                font-weight: 500;
                color: #0D2441;
            }
        }

        .pagination {
            display: flex;
            gap: 0 8px;

            .page-item {
                width: 40px;
                height: 40px;
                background: #fafafa;
                border-radius: 8px;

                &.hidden {
                    display: none;
                }

                @media screen {
                    @media (max-width: 575px) {
                        width: 36px;
                        height: 36px;
                    }

                    @media (max-width: 390px) {
                        width: 30px;
                        height: 30px;
                    }
                }

                a {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 100%;
                    width: 100%;
                    border: 1px solid #E9EAEC;
                    background: #fafafa;
                    line-height: 16px;
                    color: #585D68;
                    font-size: 16px;
                    border-radius: 8px;

                    @media screen {
                        @media (max-width: 575px) {
                            font-size: 14px;
                        }
                    }

                    &:hover {
                        border-color: #0D2441;
                        color: #0D2441;
                    }
                }

                &:hover {
                    background-color: #E5E5E5;
                }

                &.prev, &.next {
                    width: auto;

                    a {
                        display: flex;
                        align-items: center;
                        padding: 0 16px;
                        color: #585D68;
                    }
                }

                &.prev {
                    margin-right: 16px;

                    @media screen {
                        @media (max-width: 767px) {
                            display: none;
                        }
                    }

                    a {
                        &::before {
                            content: '';
                            width: 6px;
                            height: 10px;
                            margin: 0 10px 0 0;
                            background: url('../../../../../../resources/front/images/pagination-prev-arrow.svg') center center no-repeat;
                        }
                    }
                }

                &.next {
                    margin-left: 16px;

                    a {
                        &::after {
                            content: '';
                            width: 6px;
                            height: 10px;
                            margin: 0 0 0 10px;
                            background: url('../../../../../../resources/front/images/pagination-next-arrow.svg') center center no-repeat;
                        }
                    }
                }

                &.sep {
                    pointer-events: none;

                    span {
                        display: block;
                        width: 100%;
                        padding-top: 7px;
                        text-align: center;
                    }
                }

                &.active {
                    pointer-events: none;

                    a {
                        background-color: #E72E2C;
                        border-color: #E72E2C;
                        color: #FAFAFA;
                    }
                }

                a {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 100%;
                    height: 100%;
                    color: #616571;
                    font-size: 14px;
                    font-weight: 500;
                    transition: all 0.3s ease-in-out;
                }
            }
        }
    }
</style>
