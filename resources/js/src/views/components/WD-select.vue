<!-- =========================================================================================
  File Name: WD-select.vue
  Description: WD select
========================================================================================== -->
<template>
    <div ref="WDSelect" :class="['input-wrapper select', selectedOption ? 'has-content' : '', field_validation ? 'error' : '', dropdown ? 'focus' : fieldClassFocus]">
        <div class="label">{{ title }}</div>
        <div class="label-floating">{{ title }}</div>

        <div class="select" @click="toggleDropdown" tabindex="0" @focus="fieldFocus" @blur="fieldBlur">
            {{ selectedOption ? selectedOption[label] : null }}
        </div>

        <span class="error" v-if="validation">{{ validation }}</span>

        <div class="options" v-if="dropdown">
            <div class="option" v-for="option in options" v-show="dropdown">
                <div :class="['element', option.sub && option.sub.length > 0 ? 'with-sub' : '', selectedOption && selectedOption.id === option.id ? 'active' : '']">
                    <svg class="select-dropdown-icon" @click="toggleSub(option)" v-if="option.sub && option.sub.length > 0 && !option.open" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path fill="currentColor" d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path></svg>
                    <svg class="select-dropdown-icon" @click="toggleSub(option)" v-if="option.sub && option.sub.length > 0 && option.open" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path  fill="currentColor" d="M16.293 9.293 12 13.586 7.707 9.293l-1.414 1.414L12 16.414l5.707-5.707z"></path></svg>
                    <span @click="selectOption(option)">{{ option[label] }}</span>
                </div>

                <div class="sub" v-if="option.sub && option.sub.length > 0 && option.open">
                    <div class="option" v-for="sub_option in option.sub">
                        <div :class="['element', sub_option.sub && sub_option.sub.length > 0 ? 'with-sub' : '', selectedOption && selectedOption.id === sub_option.id ? 'active' : '']">
                            <svg class="select-dropdown-icon" @click="toggleSub(sub_option)" v-if="sub_option.sub && sub_option.sub.length > 0 && !sub_option.open" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path fill="currentColor" d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path></svg>
                            <svg class="select-dropdown-icon" @click="toggleSub(sub_option)" v-if="sub_option.sub && sub_option.sub.length > 0 && sub_option.open" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path  fill="currentColor" d="M16.293 9.293 12 13.586 7.707 9.293l-1.414 1.414L12 16.414l5.707-5.707z"></path></svg>
                            <span @click.self="selectOption(sub_option)">{{ sub_option[label] }}</span>
                        </div>

                        <div class="sub-sub" v-if="sub_option.sub && sub_option.sub.length > 0 && sub_option.open">
                            <div class="option" v-for="sub_sub_option in sub_option.sub">
                                <div :class="['element', selectedOption && selectedOption.id === sub_sub_option.id ? 'active' : '']">
                                    <span @click.self="selectOption(sub_sub_option)">{{ sub_sub_option[label] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['field', 'label', 'title', 'options', 'selectedOption', 'validation', 'item_id'],
    data() {
        return {
            dropdown: false,

            fieldClassFocus: false,
            field_validation: null
        }
    },
    methods: {
        fieldFocus() {
            this.fieldClassFocus = 'focus';
        },
        fieldBlur() {
            this.fieldClassFocus = false;
        },
        toggleSub(option) {
            option.open = !option.open;
        },
        selectOption(option){
            this.closeDropdown();
            this.$emit('selectedOptionUpdated', option, this.field, this.item_id);
        },
        toggleDropdown() {
            this.dropdown = !this.dropdown;
        },
        openDropdown() {
            this.dropdown = true;
        },
        closeDropdown() {
            this.dropdown = false;
        },
        handleClickOutside(event) {
            const targetElement = this.$refs.WDSelect;
            if(targetElement){
                if (!targetElement.contains(event.target) && event.target.classList[0] !== 'select-dropdown-icon') {
                    if(this.dropdown) {
                        this.closeDropdown();
                    }
                }
            }
        },
    },
    mounted() {
        document.addEventListener('click', this.handleClickOutside);
    }
}
</script>

<style lang="scss" scoped>
    .input-wrapper {
            grid-area: field;
            position: relative;
            align-items: flex-start;
            display: flex;
            cursor: text;
            font-size: 16px;
            letter-spacing: .009375em;
            padding: 12px 0;
            flex-direction: column;
            z-index: 2;

            .label {
                visibility: visible;
                contain: layout paint;
                margin-inline-start: 16px;
                margin-inline-end: 16px;
                max-width: calc(100% - 16px - 16px);
                pointer-events: none;
                position: absolute;
                top: 20px;
                transform-origin: left center;
                transition: .15s cubic-bezier(.4, 0, .2, 1);
                transition-property: all;
                transition-property: opacity, transform;
                color: rgba(var(--secondary-color), var(--opacity-point-three));
                z-index: 1;
            }

            .label-floating {
                visibility: hidden;
                transform: translateY(-50%);
                margin: 0 4px;
                font-size: 0.75em;
                left: 10px;
                position: absolute;
                z-index: 1;
                background: #fff;
                padding: 0 10px;
                font-weight: 600;
                background: rgba(var(--accent-color));
                color: rgba(var(--secondary-color), var(--opacity-point-three));
            }

            .select {
                flex: 1;
                transition: .15s opacity cubic-bezier(.4, 0, .2, 1);
                min-width: 0;
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                letter-spacing: .009375em;
                min-height: 40px;
                max-height: 40px;
                padding-inline-start: 16px;
                padding-inline-end: 16px;
                padding-top: 5px;
                padding-bottom: 6px;
                width: 100%;
                border-radius: 6px;
                border: 1px solid rgba(var(--secondary-color), var(--opacity-point-three));
                font-size: 16px;
                position: relative;
                background: rgba(var(--accent-color));
                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                &:focus-visible {
                    outline: unset;
                }
            }

            &.has-content {
                .label {
                    visibility: hidden;
                }

                .label-floating {
                    visibility: visible;
                }
            }

            &.error {
                .select {
                    border-color: #f6303a;
                }

                .label {
                    color: rgba(var(--primary-color));
                }

                .label-floating {
                    color: rgba(var(--primary-color));
                }
            }

            &.focus {
                z-index: 3;

                .label {
                    visibility: hidden;
                }

                .label-floating {
                    visibility: visible;
                    color: rgba(var(--primary-color));
                }

                .select {
                    border: 2px solid rgba(var(--primary-color));
                    padding-inline-start: 15px;
                }
            }

            span.error {
                color: rgba(var(--primary-color));
                align-items: flex-end;
                display: flex;
                font-size: .75rem;
                font-weight: 400;
                letter-spacing: .0333333333em;
                line-height: normal;
                min-height: 22px;
                overflow: hidden;
                justify-content: space-between;
                padding: 3px 14px 0 14px;
            }

            .options {
                position: absolute;
                top: 60px;
                max-height: 200px;
                overflow-y: auto;
                width: 100%;
                background: rgba(var(--accent-color));
                border-radius: 6px;
                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                box-shadow: 0 1px 7px -2px, 0 3px 7px 1px rgba(var(--shadow-color), var(--opacity-point-zero-four)), 0 1px 4px 2px rgba(var(--shadow-color), var(--opacity-point-zero-two));
                cursor: pointer;
                padding: 8px 0;
                z-index: 2;

                &::-webkit-scrollbar {
                    width: 10px;
                    border-radius: 6px;
                }

                &::-webkit-scrollbar-track {
                    border-left: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                }

                &::-webkit-scrollbar-thumb {
                    border-radius: 6px;
                    background-color: rgba(var(--secondary-color), var(--opacity-point-four));
                }

                .option {
                    .element {
                        display: flex;
                        align-items: center;

                        svg {
                            width: 32px;
                            height: 32px;
                            padding: 6px;

                            &:hover {
                                color: rgba(var(--primary-color));
                            }
                        }

                        span {
                            padding: 4px 16px;
                            flex-grow: 1;
                        }

                        &.with-sub {
                            span {
                                padding: 4px 16px 4px 0;
                            }
                        }

                        &.active {
                            font-weight: 600;
                            background: rgba(var(--icon-hover-background-color));
                        }

                        &:hover {
                            background: rgba(var(--icon-hover-background-color), var(--opacity-point-four));
                        }
                    }

                    .sub {
                        .element {
                            span {
                                padding: 4px 16px 4px 46px;
                            }

                            &.with-sub {
                                svg {
                                    margin-left: 32px;
                                }

                                span {
                                    padding: 4px 16px 4px 0;
                                }
                            }
                        }

                        .sub-sub {
                            .element {
                                span {
                                    padding: 4px 16px 4px 80px;
                                }
                            }
                        }
                    }
                }
            }
        }
</style>
