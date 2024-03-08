<!-- =========================================================================================
  File Name: multi-select.vue
  Description: Multi select
========================================================================================== -->
<template>
    <div :class="['input-wrapper', value ? 'has-content' : '', field_validation ? 'error' : '', fieldClassFocus]">
        <div class="label">{{ title }}</div>
        <div class="label-floating">{{ title }}</div>
        <input v-model="inputVal" type="text" @focus="fieldFocus" @blur="fieldBlur"/>
    </div>
</template>
<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        },
        value: {
            type: String,
            required: true
        },
        validation: {
            type: String
        },
    },
    data() {
        return {
            fieldValue: this.value,
            fieldClassFocus: false,
            field_validation: null
        }
    },
    computed: {
        inputVal: {
            get () {
                return this.value
            },
            set (val) {
                this.$emit('input', val)
            }
        }
    },
    methods: {
        fieldFocus() {
            this.fieldClassFocus = 'focus';
        },
        fieldBlur() {
            this.closeDropdown();
            this.fieldClassFocus = false;
        },
        toggleDropdown() {
            this.dropdown = !this.dropdown;

        },
        openDropdown() {
            this.dropdown = true;
        },
        closeDropdown() {
            this.dropdown = false;
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
    opacity: 1;
    flex-direction: column;
    z-index: 1;
    flex-grow: 1;

    &.name {
        width: 70%;
    }

    &.locale {
        width: 30%;
        margin-left: 20px;
    }

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
        transition: .15s cubic-bezier(.4,0,.2,1);
        transition-property: all;
        transition-property: opacity,transform;
        color: rgba(var(--secondary-color));
    }

    .label-floating {
        visibility: hidden;
        transform: translateY(-50%);
        margin: 0 4px;
        font-size: 0.75em;
        left: 10px;
        position: absolute;
        z-index: 999;
        padding: 0 10px;
        font-weight: 600;
        background: rgba(var(--accent-color));
        color: rgba(var(--secondary-color), var(--opacity-point-six));
    }

    input {
        color: #000;
        opacity: 0.6;
        flex: 1;
        transition: .15s opacity cubic-bezier(.4,0,.2,1);
        min-width: 0;
        display: flex;
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
        border: 1px solid rgba(var(--secondary-color), var(--opacity-point-six));
        font-size: 16px;
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
        input {
            border-color: rgba(var(--primary-color));
        }

        .label {
            color: rgba(var(--primary-color));
        }

        .label-floating {
            color: rgba(var(--primary-color));
        }
    }

    &.focus {
        .label {
            visibility: hidden;
        }

        .label-floating {
            visibility: visible;
            color: rgba(var(--primary-color));
        }

        input {
            border: 2px solid rgba(var(--primary-color));
            padding-inline-start: 15px;
        }
    }

    img {
        cursor: pointer;
        opacity: 0.6;
        width: 24px;
        position: absolute;
        top: 28px;
        right: 16px;
    }

    button {
        position: absolute;
        right: 13px;
        top: 25px;
        width: 30px;
        height: 30px;
        background: rgba(var(--primary-color));
        border: rgba(var(--primary-color));
        border-radius: 4px;
        cursor: pointer;

        &:hover {
            opacity: var(--opacity-point-eight-seven);
        }

        svg {
            color: rgba(var(--white-color));
            fill: rgba(var(--white-color));
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
}
</style>
