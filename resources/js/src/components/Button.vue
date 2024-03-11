<template>
    <button :class="`button ${type}`">
        <slot />
    </button>
</template>

<script>
export default {
    name: 'Button',

    props: [
        'btnType',
    ],

    computed: {
        type() {
            return this.$props.btnType ? this.$props.btnType : 'primary'
        }
    }
}
</script>

<style scoped lang="scss">
.button {
    border-radius: 4px;
    cursor: pointer;
    line-height: 20px;
    outline: 0;
    padding: 8px 16px;
    transition: all 0.2s ease-in-out;
    text-transform: uppercase;
    font-weight: 400;
    font-size: 14px;
    max-width: 200px;
    width: auto;
    text-decoration: unset;

    &.primary {
        background: rgba(var(--primary-button-background-color));
        border: 1px solid rgba(var(--primary-button-background-color));
        color: rgba(var(--primary-button-color));
        cursor: pointer;

        &:hover {
            opacity: var(--opacity-point-eight-seven);
        }
    }
}
</style>
