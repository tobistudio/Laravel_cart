<template>
    <div class="toolbar-products top">
        <div class="wrapper">
            <div class="toolbar-amount">
                Rāda: <strong>{{ shows }}</strong> no
                <strong>{{ productCount }}</strong>
            </div>

            <div class="right-side">
                <div class="view-modes">
                    <button type="button" :class="`mode mode-grid ${view === 'grid' ? 'active' : ''}`" @click="$emit('toggleView', 'grid')">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 1.625C0 1.07272 0.447715 0.625 1 0.625H19C19.5523 0.625 20 1.07272 20 1.625V3.375C20 3.92728 19.5523 4.375 19 4.375H1C0.447716 4.375 0 3.92728 0 3.375V1.625Z" fill="#BABABA"/>
                            <path d="M0 9.125C0 8.57272 0.447715 8.125 1 8.125H19C19.5523 8.125 20 8.57272 20 9.125V10.875C20 11.4273 19.5523 11.875 19 11.875H1C0.447716 11.875 0 11.4273 0 10.875V9.125Z" fill="#BABABA"/>
                            <path d="M0 16.6248C0 16.0725 0.447715 15.6248 1 15.6248H19C19.5523 15.6248 20 16.0725 20 16.6248V18.3748C20 18.9271 19.5523 19.3748 19 19.3748H1C0.447716 19.3748 0 18.9271 0 18.3748V16.6248Z" fill="#BABABA"/>
                        </svg>
                    </button>

                    <button type="button" :class="`mode mode-list ${view === 'list' ? 'active' : ''}`" @click="$emit('toggleView', 'list')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
                            <g clip-path="url(#clip0_2260_218906)">
                                <path d="M6.05627 0H1.41858C1.0984 0 0.838867 0.259536 0.838867 0.579711V5.2174C0.838867 5.53757 1.0984 5.79711 1.41858 5.79711H6.05627C6.37644 5.79711 6.63598 5.53757 6.63598 5.2174V0.579711C6.63598 0.259536 6.37644 0 6.05627 0Z" fill="#BABABA"/>
                                <path d="M13.0123 0H8.37463C8.05446 0 7.79492 0.259536 7.79492 0.579711V5.2174C7.79492 5.53757 8.05446 5.79711 8.37463 5.79711H13.0123C13.3325 5.79711 13.592 5.53757 13.592 5.2174V0.579711C13.592 0.259536 13.3325 0 13.0123 0Z" fill="#BABABA"/>
                                <path d="M6.05627 6.95605H1.41858C1.0984 6.95605 0.838867 7.21559 0.838867 7.53577V12.1735C0.838867 12.4936 1.0984 12.7532 1.41858 12.7532H6.05627C6.37644 12.7532 6.63598 12.4936 6.63598 12.1735V7.53577C6.63598 7.21559 6.37644 6.95605 6.05627 6.95605Z" fill="#BABABA"/>
                                <path d="M13.0123 6.95703H8.37463C8.05446 6.95703 7.79492 7.21657 7.79492 7.53674V12.1744C7.79492 12.4946 8.05446 12.7541 8.37463 12.7541H13.0123C13.3325 12.7541 13.592 12.4946 13.592 12.1744V7.53674C13.592 7.21657 13.3325 6.95703 13.0123 6.95703Z" fill="#BABABA"/>
                                <path d="M19.9694 0H15.3317C15.0115 0 14.752 0.259536 14.752 0.579711V5.2174C14.752 5.53757 15.0115 5.79711 15.3317 5.79711H19.9694C20.2895 5.79711 20.5491 5.53757 20.5491 5.2174V0.579711C20.5491 0.259536 20.2895 0 19.9694 0Z" fill="#BABABA"/>
                                <path d="M19.9694 6.95605H15.3317C15.0115 6.95605 14.752 7.21559 14.752 7.53577V12.1735C14.752 12.4936 15.0115 12.7532 15.3317 12.7532H19.9694C20.2895 12.7532 20.5491 12.4936 20.5491 12.1735V7.53577C20.5491 7.21559 20.2895 6.95605 19.9694 6.95605Z" fill="#BABABA"/>
                                <path d="M6.05627 14.2031H1.41858C1.0984 14.2031 0.838867 14.4627 0.838867 14.7828V19.4205C0.838867 19.7407 1.0984 20.0002 1.41858 20.0002H6.05627C6.37644 20.0002 6.63598 19.7407 6.63598 19.4205V14.7828C6.63598 14.4627 6.37644 14.2031 6.05627 14.2031Z" fill="#BABABA"/>
                                <path d="M13.0123 14.2031H8.37463C8.05446 14.2031 7.79492 14.4627 7.79492 14.7828V19.4205C7.79492 19.7407 8.05446 20.0002 8.37463 20.0002H13.0123C13.3325 20.0002 13.592 19.7407 13.592 19.4205V14.7828C13.592 14.4627 13.3325 14.2031 13.0123 14.2031Z" fill="#BABABA"/>
                                <path d="M19.9694 14.2031H15.3317C15.0115 14.2031 14.752 14.4627 14.752 14.7828V19.4205C14.752 19.7407 15.0115 20.0002 15.3317 20.0002H19.9694C20.2895 20.0002 20.5491 19.7407 20.5491 19.4205V14.7828C20.5491 14.4627 20.2895 14.2031 19.9694 14.2031Z" fill="#BABABA"/>
                            </g>

                            <defs>
                            <clipPath id="clip0_2260_218906">
                                <rect width="20" height="20" fill="white" transform="translate(0.694336)"/>
                            </clipPath>
                            </defs>
                        </svg>
                    </button>
                </div>

                <div class="limiter" @click="toggleDropdown('showCountDropdown')">
                    <div :class="`form-group ${showCountDropdown ? 'opened' : ''}`">
                        <input type="text" :value="showPerPage" readonly>

                        <div class="dropdown">
                            <ul class="inner-dropdown">
                                <li :class="`${showPerPage === 12 ? 'selected' : ''}`" @click="$emit('showPerPage', 12)">12</li>
                                <li :class="`${showPerPage === 24 ? 'selected' : ''}`" @click="$emit('showPerPage', 24)">24</li>
                                <li :class="`${showPerPage === 36 ? 'selected' : ''}`" @click="$emit('showPerPage', 36)">36</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="sorter" @click="toggleDropdown('showTypeDropdown')">
                    <div :class="`form-group ${showTypeDropdown ? 'opened' : ''}`">
                        <input name="" :value="translate('products', sorting)" class="sorter-options" readonly>

                        <div class="dropdown">
                            <ul class="inner-dropdown">
                                <li :class="`${sorting === 'id' ? 'selected' : ''}`" @click="$emit('selectSorting', 'id')">{{ translate('products', 'id') }}</li>
                                <li :class="`${sorting === 'name' ? 'selected' : ''}`" @click="$emit('selectSorting', 'name')">{{ translate('products', 'name') }}</li>
                                <li :class="`${sorting === 'price' ? 'selected' : ''}`" @click="$emit('selectSorting', 'price')">{{ translate('products', 'price') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="toolbar-pagination">
                    <button type="button" class="prev disabled">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 19L8.35348 12.3536C8.15818 12.1583 8.15818 11.8417 8.35348 11.6464L15 5" stroke="#0D2441" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </button>

                    <div :class="`form-group ${showPageDropdown ? 'opened' : ''}`"  @click="toggleDropdown('showPageDropdown')">
                        <input type="text" name="" value="1" readonly>

                        <div class="dropdown">
                            <ul class="inner-dropdown">
                                <li class="selected">1</li>
                                <li>2</li>
                                <li>3</li>
                            </ul>
                        </div>
                    </div>

                    <button type="button" class="next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M9.00002 5L15.6465 11.6464C15.8418 11.8417 15.8418 12.1583 15.6465 12.3536L8.99998 19" stroke="#0D2441" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="active-filters" v-if="activeFilters.length > 0">
            <span class="block-name">Aktīvie filrti:</span>

            <div class="list">
                <ul>
                    <li v-for="activeFilter in activeFilters">
                        <button type="button" class="filter-btn" @click="$emit('selectFilter', {
                            ...activeFilter,
                            selected: false
                        })">
                            <span class="remove"></span>
                            <span>{{ activeFilter.title }}</span>
                        </button>
                    </li>
                </ul>

                <button type="button" class="clear-filters" @click="$emit('clearFilters')">
                    <span>Notīrīt filtrus</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ControlsTop',

    props: [
        'view',
        'productCount',
        'activeFilters',
        'showPerPage',
        'currentPage',
        'sorting',
        'locale',
    ],

    emit: [
        'toggleView',
        'selectFilter',
        'clearFilters',
        'showPerPage',
        'selectSorting',
    ],

    computed: {
        shows() {
            const from = (this.currentPage > 0 ? this.currentPage : 1) * this.showPerPage - this.showPerPage;
            const to = (this.currentPage > 0 ? this.currentPage : 1) * this.showPerPage;

            return `${from} - ${to}`;
        },
    },

    data() {
        return {
            showCountDropdown: false,
            showTypeDropdown: false,
            showPageDropdown: false,
        }
    },

    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        toggleDropdown(type) {
            if (type === 'showCountDropdown') {
                this.showCountDropdown = !this.showCountDropdown;
            } else if (type === 'showTypeDropdown') {
                this.showTypeDropdown = !this.showTypeDropdown;
            } else if (type === 'showPageDropdown') {
                this.showPageDropdown = !this.showPageDropdown;
            }
        }
    }
}
</script>

<style lang="scss" scoped>
    .toolbar-products {
        position: relative;
        margin: 0 0 32px 0;
        z-index: 10;

        @media screen {
            @media (max-width: 575px) {
                margin: 0 0 16px 0;
            }
        }

        .wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .toolbar-amount {
            color: #616571;
            font-size: 14px;

            @media screen {
                @media (max-width: 575px) {
                    font-size: 10px;
                }
            }

            strong {
                line-height: 14px;
                font-weight: 500;
                color: #0D2441;

                @media screen {
                    @media (max-width: 575px) {
                        line-height: 10px;
                    }
                }
            }
        }

        .right-side {
            display: flex;
            align-items: center;
            gap: 0 24px;

            @media screen {
                @media (max-width: 575px) {
                    gap: 0 16px;
                }
            }
        }

        .form-group {
            position: relative;
            margin: 0;

            input {
                height: 42px;
                min-width: 67px;
                padding: 0 30px 0 12px;
                background: transparent url('../../../../../../resources/front/images/toolbar-select-arrow.svg') calc(100% - 12px) center no-repeat !important;
                border: 1px solid #D8DADE;
                color: #0D2441;
                cursor: pointer;
                border-radius: 8px;

                &.sorter-options {
                    min-width: 193px;
                }
            }

            .dropdown {
                position: absolute;
                top: calc(100% + 2px);
                left: 0;
                right: 0;
                max-height: 220px;
                padding: 4px 0;
                background-color: #fff;
                border: 1px solid #EBEBEF;
                overflow: auto;
                visibility: hidden;
                opacity: 0;
                border-radius: 8px;
                box-shadow: 0px 8px 30px 0px rgba(140, 148, 156, 0.10), 0px 2px 8px 0px rgba(101, 107, 114, 0.10);
                transition: all .3s ease-in-out;
                z-index: 1;

                &::-webkit-scrollbar {
                    width: 5px;
                }

                &::-webkit-scrollbar-track {
                    background: #E9EAEC;
                    border-radius: 3px;
                }

                &::-webkit-scrollbar-thumb {
                    background: #C7C7C7;
                    border-radius: 3px;
                }

                &::-webkit-scrollbar-thumb:hover {
                    background: #B3B6BD;
                }

                .inner-dropdown {
                    li {
                        padding: 11px 16px;
                        line-height: 14px;
                        color: #0D2441;
                        font-size: 14px;
                        font-weight: 400;
                        cursor: pointer;
                        transition: all .3s ease-in-out;

                        &:hover {
                            background: #F4F4F6;
                        }

                        &.selected {
                            background: #F4F4F6;
                        }
                    }
                }
            }

            &.opened {
                input {
                    background: transparent url('../../../../../../resources/front/images/toolbar-select-arrow-opened.svg') calc(100% - 12px) center no-repeat !important;
                }

                .dropdown {
                    visibility: visible;
                    opacity: 1;
                }
            }
        }

        .limiter {
            input {
                width: 67px;

                @media screen {
                    @media (max-width: 575px) {
                        width: 80px;
                    }
                }
            }
        }

        .view-modes {
            display: flex;
            align-items: center;
            gap: 0 12px;

            button {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0;
                border: 0;
                cursor: pointer;

                svg {
                    path {
                        transition: all .3s ease;
                    }
                }

                &.active, &:hover {
                    svg {
                        path {
                            fill: #0D2441;
                        }
                    }
                }
            }
        }

        .sorter {
            @media screen {
                @media (max-width: 991px) {
                    display: none;
                }
            }
        }

        .toolbar-pagination {
            display: flex;
            gap: 0 4px;

            @media screen {
                @media (max-width: 600px) {
                    display: none;
                }
            }

            input {
                width: 80px;
                text-align: center;
            }

            button {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 42px;
                height: 42px;
                padding: 0;
                border: 1px solid #D8DADE;
                cursor: pointer;
                transition: all .3s ease;
                border-radius: 8px;

                &.prev {

                }

                &.next {

                }

                &.disabled {
                    pointer-events: none;

                    svg {
                        path {
                            stroke: #BABABA;;
                        }
                    }
                }

                &:hover {
                    border-color: #a6a8ad;
                }
            }
        }
    }

    .active-filters {
        margin: 24px 0 0 0;

        @media screen {
            @media (max-width: 575px) {
                display: none;
            }
        }

        .block-name {
            display: block;
            margin: 0 0 12px 0;
            line-height: 14px;
            font-size: 14px;
            color: #0D2441;
        }

        .list {
            display: flex;
            align-items: center;

            ul {
                display: flex;
                align-items: center;
                gap: 0 8px;

                .filter-btn {
                    display: flex;
                    align-items: center;
                    gap: 0 4px;
                    padding: 11px 10px;
                    background: #F1F2F3;
                    color: #49515A;
                    /* cursor: pointer; */
                    border-radius: 8px;

                    .remove {
                        width: 16px;
                        height: 16px;
                        padding: 0;
                        background: url('../../../../../../resources/front/images/remove-filter-icon.svg') center center no-repeat;
                        cursor: pointer;
                    }
                }
            }

            .clear-filters {
                display: flex;
                align-items: center;
                gap: 0 2px;
                font-weight: 500;
                color: #E72E2C;
                cursor: pointer;

                &::before {
                    content: '';
                    width: 16px;
                    height: 16px;
                    background: url('../../../../../../resources/front/images/clear-filters-icon.svg') center center no-repeat;

                }

                &:hover {
                    text-decoration: underline;
                }
            }
        }
    }
</style>
