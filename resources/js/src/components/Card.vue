<template>
    <div :class="`card with-header ${card ? 'open' : 'close'}`">
        <div class="header">
            <div class="title">{{ title }}</div>

            <div class="controls">
                <div class="button" @click="toggleCard()" v-if="card">
                    <i class='bx bx-chevron-up'></i>
                </div>

                <div class="button" @click="toggleCard()" v-if="!card">
                    <i class='bx bx-chevron-down'></i>
                </div>
            </div>

            <slot name="header" />
        </div>

        <div class="content">
            <slot name="content" />
        </div>
    </div>
</template>

<script>
export default {
    name: "Card",

    props: [
        'cardTitle'
    ],

    emits: [
        'card-toggled',
    ],

    computed: {
        title() {
            return this.$props.cardTitle
                ? this.$props.cardTitle
                : 'Title';
        },
    },

    data() {
        return {
            card: false,
        }
    },

    methods: {
        toggleCard() {
            this.card = !this.card;

            this.$emit('card-toggled', this.card);
        }
    },
}
</script>

<style scoped lang="scss">
.card {
    background: rgba(var(--accent-color));
    padding: 2rem 1rem;
    border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
    border-radius: 8px;
    margin-bottom: 1rem;
    box-shadow: 0 2px 4px -1px #32475c0f, 0 4px 5px #32475c0a, 0 1px 10px #32475c0a;
    width: 100%;
    margin-top: .5rem;

    &.close {
        & .content {
            height: 0;
            max-height: 0;
            min-height: 0;
            overflow: hidden;
            padding: 0;
            margin: 0;
        }
    }

    &.with-header {
        padding: 0;

        > .header {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-bottom: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
            width: 100%;

            img {
                height: 20px;
                margin-right: 10px;
            }

            .title {
                font-weight: 700;
                color: rgba(var(--title-color));
                flex-grow: 1;
            }

            .controls {
                display: flex;

                .button {
                    width: 24px;
                    height: 24px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    border-radius: 50%;
                    cursor: pointer;

                    i {
                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                        font-size: 24px;
                    }

                    &:hover {
                        background: rgba(var(--icon-hover-background-color));
                    }
                }
            }
        }
    }

    .content {
        letter-spacing: 0.009375em;
        min-height: 100px;
        padding-inline-start: 16px;
        padding-inline-end: 16px;
        padding-top: 5px;
        padding-bottom: 6px;
        width: 100%;
        border-radius: 6px;
        font-size: 16px;
        background: rgba(var(--accent-color));
        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
        outline: unset;

        & > div {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            list-style: none;
            padding-left: 0;
        }
    }
}
</style>
