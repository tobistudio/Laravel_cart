<template>
    <draggable
        v-model="local_data"
        ghost-class="ghost"
        item-key="id">
        <template #item="{element}">
            <div :class="['card', 'with-header', element.active ? 'open' : '']">
                <div class="header">
                    <div class="title">{{ element.name && element.power && element.fuel ? element.name + ' ' + element.power + ' ' + element.fuel.name : trans.newVehicleEngine }}</div>
                    <div class="controls">
                        <div class="button" @click="closeVehicleEngine(element)" v-if="element.active">
                            <i class='bx bx-chevron-up'></i>
                        </div>
                        <div class="button" @click="openVehicleEngine(element)" v-if="!element.active">
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
                    <div class="row">
                        <div class="half">
                            <div :class="['input-wrapper', element.volume ? 'has-content' : '', volumeClassFocus]">
                                <div class="label">{{ trans.volume }}</div>
                                <div class="label-floating">{{ trans.volume }}</div>
                                <input v-model="element.volume" type="text" @focus="volumeFocus" @blur="volumeBlur"/>
                            </div>
                        </div>
                        <div class="half">
                            <div :class="['input-wrapper', element.power ? 'has-content' : '', powerClassFocus]">
                                <div class="label">{{ trans.power }}</div>
                                <div class="label-floating">{{ trans.power }}</div>
                                <input v-model="element.power" type="text" @focus="powerFocus" @blur="powerBlur"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="full">
                            <WDSelect field="selectedFuel" label="name" :item_id="element.id ? element.id : element.tmp_id" :title="trans.fuel" :options="fuelOptions" :selectedOption="element.fuel" @selectedOptionUpdated="selectedOptionUpdated"></WDSelect>
                        </div>
                    </div>

                    <div class="row">
                        <div class="full">
                            <div :class="['input-wrapper', element.cm3 ? 'has-content' : '', cm3ClassFocus]">
                                <div class="label">{{ trans.cm3 }}</div>
                                <div class="label-floating">{{ trans.cm3 }}</div>
                                <input v-model="element.cm3" type="text" @focus="cm3Focus" @blur="cm3Blur"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="full">
                            <div :class="['input-wrapper', element.engine_code ? 'has-content' : '', engineCodeClassFocus]">
                                <div class="label">{{ trans.engineCode }}</div>
                                <div class="label-floating">{{ trans.engineCode }}</div>
                                <input v-model="element.engine_code" type="text" @focus="engineCodeFocus" @blur="engineCodeBlur"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="half">
                            <div :class="['input-wrapper', element.year_from ? 'has-content' : '', yearFromClassFocus]">
                                <div class="label">{{ trans.yearFrom }}</div>
                                <div class="label-floating">{{ trans.yearFrom }}</div>
                                <input v-model="element.year_from" type="text" @focus="yearFromFocus" @blur="yearFromBlur"/>
                            </div>
                        </div>
                        <div class="half">
                            <div :class="['input-wrapper', element.year_to ? 'has-content' : '', yearToClassFocus]">
                                <div class="label">{{ trans.yearTo }}</div>
                                <div class="label-floating">{{ trans.yearTo }}</div>
                                <input v-model="element.year_to" type="text" @focus="yearToFocus" @blur="yearToBlur"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </draggable>
</template>
<script>
import draggable from 'vuedraggable';
import WDSelect from "./WD-select.vue";

export default {
    props: {
        vehicleEngines: {
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

            fuelOptions: [
                {key: 'gasoline', name: 'Gasoline'},
                {key: 'gasoline_electric', name: 'Gasoline/Electric'},
                {key: 'diesel', name: 'Diesel'},
                {key: 'diesel_electric', name: 'Diesel/Electric'}
            ],

            nameClassFocus: false,
            volumeClassFocus: false,
            powerClassFocus: false,
            cm3ClassFocus: false,
            engineCodeClassFocus: false,
            yearFromClassFocus: false,
            yearToClassFocus: false,

            trans: {
                name: 'Name',
                volume: 'Volume',
                power: 'Power',
                fuel: 'Fuel',
                cm3: 'Cm3',
                engineCode: 'Engine code',
                yearFrom: 'Year from',
                yearTo: 'Year to',
                newVehicleEngine: 'New Engine',
            }
        }
    },
    components: {
        draggable,
        WDSelect
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
        openVehicleEngine(vehicleEngine) {
            vehicleEngine.active = true;
        },
        // openItemBlockItem(item_block_item) {
        //     item_block_item.active = true;
        // },
        // closeItemBlockItem(block_item) {
        //     block_item.active = false;
        // },
        closeVehicleEngine(vehicleEngine) {
            vehicleEngine.active = false;
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
        volumeFocus() {
            this.volumeClassFocus = 'focus';
        },
        volumeBlur() {
            this.volumeClassFocus = false;
        },
        powerFocus() {
            this.powerClassFocus = 'focus';
        },
        powerBlur() {
            this.powerClassFocus = false;
        },
        cm3Focus() {
            this.cm3ClassFocus = 'focus';
        },
        cm3Blur() {
            this.cm3ClassFocus = false;
        },
        engineCodeFocus() {
            this.engineCodeClassFocus = 'focus';
        },
        engineCodeBlur() {
            this.engineCodeClassFocus = false;
        },
        yearFromFocus() {
            this.yearFromClassFocus = 'focus';
        },
        yearFromBlur() {
            this.yearFromClassFocus = false;
        },
        yearToFocus() {
            this.yearToClassFocus = 'focus';
        },
        yearToBlur() {
            this.yearToClassFocus = false;
        },
        selectedOptionUpdated(option, field, item_id) {
            let itemIndex = this.local_data.findIndex(item => item.id === item_id);
            if(itemIndex >= 0){
                this.local_data[itemIndex].fuel = option;
            } else {
                let itemIndex = this.local_data.findIndex(item => item.tmp_id === item_id);
                if(itemIndex >= 0){
                    this.local_data[itemIndex].fuel = option;
                }
            }

            this[field] = option;
        },
    },
    mounted() {
        this.local_data = this.vehicleEngines;
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

            .row {
                display: flex;

                .full {
                    width: 100%;
                }

                .half {
                    width: 50%;

                    &:first-of-type {
                        margin-right: 10px;
                    }

                    &:last-of-type {
                        margin-left: 10px;
                    }
                }
            }
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

        &.select {
            z-index: 2;
        }

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
