<!-- =========================================================================================
  File Name: wd-multi-select.vue
  Description: WD Multi select
========================================================================================== -->
<template>
    <div ref="WDMultiSelect" :class="['input-wrapper multi-select', selectedOptions.length > 0 ? 'has-content' : '', field_validation ? 'error' : '', dropdown ? 'focus' : fieldClassFocus]">
        <div class="label">{{ title }}</div>
        <div class="label-floating">{{ title }}</div>

        <div class="select" @click.self="toggleDropdown" tabindex="0" @focus="fieldFocus" @blur="fieldBlur">
            <draggable
                v-model="selOptions"
                ghost-class="ghost"
                item-key="id"
                @change="reorderSelectedOptions"
                @click.self="toggleDropdown">
                <template #item="{element}">
                    <div :class="['chip', element.key]">
                        <div class="value">{{ element[label] }}</div>
                        <i class='bx bx-x' @click="removeSelectedOption(element)"></i>
                    </div>
                </template>
            </draggable>
        </div>

        <span class="error" v-if="validation">{{ validation }}</span>

        <div :class="['options', heightClass]" v-if="dropdown">
            <div class="option" v-for="option in options" v-show="dropdown">
                <div :class="['element', option.sub && option.sub.length > 0 ? 'with-sub' : '', option.active ? 'active' : '']">
                    <svg class="select-dropdown-icon" @click="toggleSub(option)" v-if="option.sub && option.sub.length > 0 && !option.open" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path fill="currentColor" d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path></svg>
                    <svg class="select-dropdown-icon" @click="toggleSub(option)" v-if="option.sub && option.sub.length > 0 && option.open" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path  fill="currentColor" d="M16.293 9.293 12 13.586 7.707 9.293l-1.414 1.414L12 16.414l5.707-5.707z"></path></svg>
                    <span @click="selectOption(option)">{{ option[label] }}</span>
                </div>

                <div class="sub" v-if="option.sub && option.sub.length > 0 && option.open">
                    <div class="option" v-for="sub_option in option.sub">
                        <div :class="['element', sub_option.sub && sub_option.sub.length > 0 ? 'with-sub' : '', sub_option.active ? 'active' : '']">
                            <svg class="select-dropdown-icon" @click="toggleSub(sub_option)" v-if="sub_option.sub && sub_option.sub.length > 0 && !sub_option.open" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path fill="currentColor" d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path></svg>
                            <svg class="select-dropdown-icon" @click="toggleSub(sub_option)" v-if="sub_option.sub && sub_option.sub.length > 0 && sub_option.open" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path  fill="currentColor" d="M16.293 9.293 12 13.586 7.707 9.293l-1.414 1.414L12 16.414l5.707-5.707z"></path></svg>
                            <span @click.self="selectOption(sub_option)">{{ sub_option[label] }}</span>
                        </div>

                        <div class="sub-sub" v-if="sub_option.sub && sub_option.sub.length > 0 && sub_option.open">
                            <div class="option" v-for="sub_sub_option in sub_option.sub">
                                <div :class="['element', sub_sub_option.active ? 'active' : '']">
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
import draggable from 'vuedraggable'

export default {
    props: ['field', 'label', 'title', 'options', 'selectedOptions', 'validation'],
    components: {
        draggable
    },
    data() {
        return {
            dropdown: false,
            heightClass: 'heightOne',

            fieldClassFocus: false,
            field_validation: null,
            selOptions: this.selectedOptions
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
            let findSelOptionIndex = this.selOptions.findIndex(so => so.value === option.value);
            if(findSelOptionIndex >= 0){
                option.active = false;
                this.removeSelectedOption(option, findSelOptionIndex);
            } else {
                option.active = true;
                this.selOptions.push(option);
            }

            this.$emit('selectedMultiOptionsUpdated', this.selOptions, this.field);

            this.setHeightClass();
        },
        removeSelectedOption(option, index) {
            let findOptionIndex = this.options.findIndex(o => o.value === option.value);
            if(findOptionIndex >= 0){
                this.options[findOptionIndex].active = false;

                let selOptionIndex = index;
                if(!index){
                    selOptionIndex = this.selOptions.findIndex(so => so.value === option.value);
                }
                this.selOptions.splice(selOptionIndex, 1);
                this.$emit('selectedMultiOptionsUpdated', this.selOptions);
            } else {
                this.options.map((subOption, index) => {
                    let findOptionSubIndex = subOption.sub.findIndex(o => o.value === option.value);
                    if(findOptionSubIndex >= 0){
                        this.options[index].sub[findOptionSubIndex].active = false;

                        let selOptionIndex = index;
                        if(!index){
                            selOptionIndex = this.selOptions.findIndex(so => so.value === option.value);
                        }
                        this.selOptions.splice(selOptionIndex, 1);
                        this.$emit('selectedMultiOptionsUpdated', this.selOptions);
                    } else {
                        subOption.sub.map((subSubOption, subIndex) => {
                            let findOptionSubSubIndex = subSubOption.sub.findIndex(o => o.value === option.value);
                            if(findOptionSubSubIndex >= 0){
                                this.options[index].sub[subIndex].sub[findOptionSubSubIndex].active = false;

                                let selOptionIndex = index;
                                if(!index){
                                    selOptionIndex = this.selOptions.findIndex(so => so.value === option.value);
                                }
                                this.selOptions.splice(selOptionIndex, 1);
                                this.$emit('selectedMultiOptionsUpdated', this.selOptions);
                            }
                        })
                    }
                })
            }


            this.setHeightClass();
        },
        reorderSelectedOptions() {
            this.$emit('selectedMultiOptionsUpdated', this.selOptions);
        },
        toggleDropdown() {
            this.dropdown = !this.dropdown;
            this.setHeightClass();
        },
        closeDropdown() {
            this.dropdown = false;
        },
        handleClickOutside(event) {
            const targetElement = this.$refs.WDMultiSelect;
            if(targetElement){
                if (!targetElement.contains(event.target) && event.target.classList[0] !== 'select-dropdown-icon') {
                    if(this.dropdown) {
                        this.closeDropdown();
                    }
                }
            }
        },
        setHeightClass() {
            let height = this.$refs.WDMultiSelect.clientHeight;
            if(height > 149) {
                this.heightClass = 'heightFive';
            } else if(height > 121) {
                this.heightClass = 'heightFour';
            } else if(height > 93) {
                this.heightClass = 'heightThree';
            } else if(height > 68){
                this.heightClass = 'heightTwo';
            } else {
                this.heightClass = 'heightOne';
            }
        }
    },
    mounted() {
        document.addEventListener('click', this.handleClickOutside);
        if(this.selOptions.length > 0) {
            this.options.map((o) => {
                this.selOptions.map((selOption) => {
                    if(selOption.value === o.value){
                        o.active = true;
                        selOption.name = o.name;
                    }
                })

                if(o.sub && o.sub.length > 0) {
                    o.sub.map((so) => {
                        this.selOptions.map((selOption) => {
                            if (selOption.value === so.value) {
                                so.active = true;
                                selOption.name = so.name;
                            }
                        })

                        if(so.sub && so.sub.length > 0) {
                            so.sub.map((sso) => {
                                this.selOptions.map((selOption) => {
                                    if (selOption.value === sso.value) {
                                        sso.active = true;
                                        selOption.name = sso.name;
                                    }
                                })
                            })
                        }
                    })
                }
            })
        }
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
        min-height: 44px;
        padding: 4px 15px 5px 15px;
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

        > div {
            display: flex;
            flex-wrap: wrap;

            > .chip {
                margin: 4px 4px 0 0;
                padding: 2px 0;
                background: rgba(var(--secondary-color));
                color: rgba(var(--accent-color));
                border-radius: 4px;
                cursor: move;
                display: flex;

                &.bg-red {
                    background: #E72E2C;
                    color: rgba(var(--primary-button-color));
                }

                &.bg-orange {
                    background: #F06D23;
                    color: rgba(var(--primary-button-color));
                }

                .value {
                    line-height: 12px;
                    padding: 2px 5px;
                }

                .bx {
                    cursor: pointer;
                    line-height: 18px;
                    margin-right: 2px;

                    &:hover {
                        color: rgba(var(--accent-color));
                    }
                }
            }
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
            padding: 4px 15px 5px 15px;
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

        &.heightOne {
            top: 65px;
        }

        &.heightTwo {
            top: 90px;
        }

        &.heightThree {
            top: 120px;
        }

        &.heightFour {
            top: 145px;
        }

        &.heightFive {
            top: 175px;
        }

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
                    display: flex;
                    align-items: center;
                    margin-left: 20px;

                    svg {
                        width: 32px;
                        height: 32px;
                        padding: 6px;

                        &:hover {
                            color: rgba(var(--primary-color));
                        }
                    }

                    span {
                        padding: 4px 16px 4px 46px;
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

                .sub-sub {
                    .element {
                        display: flex;
                        align-items: center;
                        margin-left: 20px;

                        span {
                            padding: 4px 16px 4px 46px;
                        }

                        &.active {
                            font-weight: 600;
                            background: rgba(var(--icon-hover-background-color));
                        }

                        &:hover {
                            background: rgba(var(--icon-hover-background-color), var(--opacity-point-four));
                        }
                    }
                }
            }
        }
    }
}
</style>
