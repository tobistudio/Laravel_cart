<template>
    <draggable
        v-model="local_data"
        ghost-class="ghost"
        item-key="id">
        <template #item="{element}">
            <div :class="['card', 'with-header', element.active ? 'open' : '']">
                <div class="header">
                    <div class="title">{{ element.name ? element.name : trans.newVehicleModelName }}</div>
                    <div class="controls">
                        <div class="button" @click="closeVehicleModelName(element)" v-if="element.active">
                            <i class='bx bx-chevron-up'></i>
                        </div>
                        <div class="button" @click="openVehicleModelName(element)" v-if="!element.active">
                            <i class='bx bx-chevron-down'></i>
                        </div>
<!--                        <div class="button"-->
<!--                             @click="openDeleteConfirmPopup('removeTableBlockItemBlock', 'table-block-item', block.id, element.title ? element.title : trans.new_item_block, item.id, element.id)">-->
<!--                            <i class='bx bx-x'></i>-->
<!--                        </div>-->
                    </div>
                </div>
                <div class="content" v-if="element.active">
                    <div class="row">
                        <div class="full">
                            <div :class="['input-wrapper', element.name ? 'has-content' : '', nameClassFocus]">
                                <div class="label">{{ trans.name }}</div>
                                <div class="label-floating">{{ trans.name }}</div>
                                <input v-model="element.name" type="text" @focus="nameFocus" @blur="nameBlur"/>
                            </div>
                        </div>
                    </div>

                    <vehicle-engine :vehicleEngines="element.engines" :removeLanguagePageBlockOrItem="removeLanguagePageBlockOrItem"></vehicle-engine>

                    <div class="row">
                        <div class="full">
                            <button class="primary mb-1" @click="addVehicleEngine(element.id)">{{ trans.addVehicleEngine }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </draggable>
</template>
<script>
import draggable from 'vuedraggable';
import VehicleEngine from './VehicleEngine.vue';

export default {
    props: {
        vehicleModelNames: {
            type: Array,
            required: true,
        },
        removeLanguagePageBlockOrItem: {
            type: Object,
        }
    },
    data() {
        return {
            local_data: [],

            nameClassFocus: false,

            trans: {
                name: 'Name',
                newVehicleModelName: 'New Model Name',
                addVehicleEngine: 'Add Engine',
            }
        }
    },
    components: {
        draggable,
        VehicleEngine
    },
    // watch: {
    //     local_data: {
    //         handler(oldData, newData) {
    //             if (newData) {
    //                 this.$emit('blockUpdated', this.block.id, this.block.tmp_id, this.local_data, null);
    //             }
    //         },
    //         deep: true,
    //         immediate: true,
    //     },
    // },
    methods: {
        openVehicleModelName(vehicleModelName) {
            vehicleModelName.active = true;
        },

        addVehicleEngine(vehicleModelNameId) {
            let findVehicleModelNameIndex = this.local_data.findIndex(item => item.id === vehicleModelNameId);

            if (findVehicleModelNameIndex >= 0) {
                this.local_data[findVehicleModelNameIndex].engines.push({
                    tmp_id: 'tmp-' + new Date().getUTCMilliseconds(),
                    name: '',
                    volume: '',
                    power: '',
                    fuel: null,
                    cm3: '',
                    engine_code: '',
                    year_from: '',
                    year_to: '',
                })
            }
        },

        // openItemBlockItem(item_block_item) {
        //     item_block_item.active = true;
        // },
        // closeItemBlockItem(block_item) {
        //     block_item.active = false;
        // },

        closeVehicleModelName(vehicleModelName) {
            vehicleModelName.active = false;
        },
        openDeleteConfirmPopup(action, type, id, name, item_id, item_block_id, item_block_item_id) {
            this.$emit('openDeleteConfirmPopup', action, type, id, name, item_id, item_block_id, item_block_item_id);
        },
        nameFocus() {
            this.nameClassFocus = 'focus';
        },
        nameBlur() {
            this.nameClassFocus = false;
        },
    },
    mounted() {
        this.local_data = this.vehicleModelNames;
    }
}
</script>
<style lang="scss" scoped>
.card {
    background: rgba(var(--accent-color));
    padding: 2rem 1rem;
    border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
    border-radius: 8px;
    margin-bottom: 1rem;
    box-shadow: 0 2px 4px -1px #32475c0f, 0 4px 5px #32475c0a, 0 1px 10px #32475c0a;


    &.with-header {
        padding: 0;

        .header {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;

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

        .content {
            display: flex;
            flex-direction: column;
            padding: 0.5rem 1rem;
            margin: 0;
        }

        &.open {
            .header {
                border-bottom: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
            }
        }
    }

    &.ghost {
        background: rgba(var(--primary-color), var(--opacity-point-three));
    }

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
            transition: .15s cubic-bezier(.4, 0, .2, 1);
            transition-property: all;
            transition-property: opacity, transform;
            color: rgba(var(--secondary-color), var(--opacity-point-three));
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
            color: rgba(var(--secondary-color), var(--opacity-point-three));
        }

        .label-more {
            height: 75px;
        }

        input {
            flex: 1;
            transition: .15s opacity cubic-bezier(.4, 0, .2, 1);
            min-width: 0;
            display: flex;
            flex-wrap: wrap;
            letter-spacing: .009375em;
            min-height: 40px;
            max-height: 40px;
            padding: 6px 16px;
            width: 100%;
            border-radius: 6px;
            border: 1px solid rgba(var(--secondary-color), var(--opacity-point-three));
            font-size: 16px;
            background: rgba(var(--accent-color));
            color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

            &:focus-visible {
                outline: unset;
            }
        }

        textarea {
            flex: 1;
            transition: .15s opacity cubic-bezier(.4, 0, .2, 1);
            min-width: 0;
            display: flex;
            flex-wrap: wrap;
            letter-spacing: .009375em;
            max-height: 40px;
            padding: 16px 16px 6px 16px;
            width: 100% !important;
            min-height: 200px;
            border-radius: 6px;
            border: 1px solid rgba(var(--secondary-color), var(--opacity-point-three));
            font-size: 16px;
            background: rgba(var(--accent-color));
            color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

            &:focus-visible {
                outline: unset;
            }
        }

        &.image {
            input {
                display: none;
            }
        }

        .image-placeholder {
            flex: 1;
            transition: .15s opacity cubic-bezier(.4, 0, .2, 1);
            min-width: 0;
            display: flex;
            flex-wrap: wrap;
            letter-spacing: .009375em;
            padding: 16px;
            width: 100% !important;
            min-height: 200px;
            border-radius: 6px;
            border: 1px solid rgba(var(--secondary-color), var(--opacity-point-three));
            font-size: 16px;
            background: rgba(var(--accent-color));
            color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
            position: relative;
            cursor: pointer;

            .label {
                top: -10px;
                left: 10px;
                position: absolute;
                font-size: 0.75em;
                z-index: 1;
                background: rgba(var(--accent-color));
                color: rgba(var(--secondary-color), var(--opacity-point-three));
                padding: 0 10px;
                margin: 0 4px;
                font-weight: 600;
            }

            .image {
                width: 100%;
                padding-top: 8px;

                .placeholder {
                    width: 100%;
                    height: 200px;
                    background: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                }

                img {
                    width: 100%;
                    height: auto;
                    position: static;
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
            input {
                border-color: rgba(var(--primary-color));
            }

            textarea {
                border-color: rgba(var(--primary-color));
            }

            .image-placeholder {
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
                padding-left: 15px;
            }

            textarea {
                border: 2px solid rgba(var(--primary-color));
                padding-left: 15px;
            }

            .image-placeholder {
                border: 2px solid rgba(var(--primary-color));
                padding-left: 15px;
            }
        }

        img {
            cursor: pointer;
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

    .label {
        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
    }
}

button {
    width: 100%;
    border-radius: 4px;
    cursor: pointer;
    line-height: 23px;
    outline: 0;
    padding: 8px;
    transition: all .2s ease-in-out;
    text-transform: uppercase;
    font-weight: 600;
    font-size: 16px;

    &:hover {
        opacity: var(--opacity-point-eight-seven);
    }

    &:disabled {
        opacity: var(--opacity-point-six);
    }

    &.primary {
        background: rgba(var(--primary-button-background-color));
        border: 1px solid rgba(var(--primary-button-background-color));
        color: rgba(var(--primary-button-color));
        margin-right: 10px;
    }
}
</style>
