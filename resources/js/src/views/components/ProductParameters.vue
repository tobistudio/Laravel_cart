<template>
    <div class="row">
        <Card :cardTitle="trans.title">
            <template #content>
                <Card :cardTitle="parameter.title || 'Default'" v-for="(parameter, index) in parameters">
                    <template #header>
                        <div class="delete" @click="removeGroup(index)">
                            <i class='bx bx-x'></i>
                        </div>
                    </template>

                    <template #content>
                        <div v-if="parameter.title !== null" class="text" style="width: 100%; margin-bottom: 1.5rem;">
                            <span>{{ trans.parameterTitle }}:</span>
                            <InputText type="text" v-model="parameter.title" @change="$emit('updateParameters', this.parameters)" class="text" style="width: 100%;" />
                        </div>

                        <transition-group>
                            <draggable
                                v-model="parameter.items"
                                v-bind="dragOptions"
                                item-key="param_order"
                                key="draggable"
                                handle=".handler"
                                @end="reorderParametersArray"
                            >
                                <template #item="{element}">
                                    <div :key="element.param_order" class="param">
                                        <template v-if="element.type.value !== 0">
                                            <div class="text">
                                                <span class="handler">{{ trans.parameterTitle }}:</span>
                                                <InputText type="text" v-model="element.title" @change="$emit('updateParameters', this.parameters)" />

                                                <span class="handler">{{ trans.parameterValue }}:</span>
                                                <InputText type="text" v-model="element.value" @change="$emit('updateParameters', this.parameters)" />
                                            </div>

                                            <div class="values">
                                                <Dropdown
                                                    v-model="parameter.items.find(el => el.param_order === element.param_order).type"
                                                    :options="parameterTypes"
                                                    class="handler"
                                                    optionLabel="name"
                                                    placeholder="Select type"
                                                    @change="$emit('updateParameters', this.parameters)"
                                                />

                                                <div class="handler" style="margin-left: .5rem;">
                                                    <Checkbox
                                                        :binary="true"
                                                        v-model="parameter.items.find(el => el.param_order === element.param_order).is_primary"
                                                        :inputId="`checkbox-${element.param_order}`"
                                                        @change="$emit('updateParameters', this.parameters)"
                                                    />
                                                    <label :for="`checkbox-${element.param_order}`" style="margin-left: .25rem;"> {{ trans.isPrimary }} </label>
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <div class="text" style="width: 100%;">
                                                <span class="handler">{{ trans.parameterTitle }}:</span>
                                                <InputText type="text" v-model="element.title" @change="$emit('updateParameters', this.parameters)" style="width: 100%;" />
                                            </div>
                                        </template>

                                        <div class="delete" @click="removeParameter(parameter, element.param_order)">
                                            <i class='bx bx-x'></i>
                                        </div>
                                    </div>
                                </template>
                            </draggable>
                        </transition-group>

                        <Button @click="createParameter(parameter)" style="margin-top: 1rem; margin-bottom: 1rem;">{{ trans.add }}</Button>
                    </template>
                </Card>

                <Button @click="createGroup" style="margin-top: 1rem; margin-bottom: 1rem; margin-left: 1rem;">{{ trans.addGroup }}</Button>
            </template>
        </Card>
    </div>
</template>

<script>
import Button from '@/js/src/components/Button.vue';
import Card from '@/js/src/components/Card.vue';
import draggable from 'vuedraggable';
import Dropdown from 'primevue/dropdown';
import Checkbox from 'primevue/checkbox';
import InputText from 'primevue/inputtext';


export default {
    name: 'ProductParameters',

    components: {
        draggable,
        Card,
        Button,
        Dropdown,
        Checkbox,
        InputText,
    },

    props: [
        'pageProductParameters',
    ],

    emits: [
        'updateParameters',
    ],

    watch: {
        'pageProductParameters' () {
            this.parameters = this.$props.pageProductParameters;
        }
    },

    data() {
        return {
            parameters: [],

            parameterTypes: [
                {
                    name: 'default',
                    value: 1,
                },
                {
                    name: 'code',
                    value: 2,
                }
            ],

            dragOptions: {
                animation: 200,
                group: 'description',
                disabled: false,
                ghostClass: 'ghost',
            },

            trans: {
                title: 'Parameters',
                add: 'Add parameter',
                addGroup: 'Add group',
                isPrimary: 'Primary',
                groupTitle: 'Group title',
                parameterTitle: 'Title',
                parameterValue: 'Value'
            }
        }
    },

    methods: {
        createParameter(parameter) {
            parameter.items.push({
                param_order: parameter.items.length,
                title: '',
                value: '',
                type: {
                    name: 'default',
                    value: 1,
                },
                is_primary: false,
            });

            this.$emit('updateParameters', this.parameters);
        },
        createGroup() {
            this.parameters.push({
                title: `Group ${this.parameters.length}`,
                items: [],
            });

            this.$emit('updateParameters', this.parameters);
        },
        removeGroup(index) {
            this.parameters.splice(index, 1);

            this.$emit('updateParameters', this.parameters);
        },
        reorderParametersArray() {
            for (let i=0; i<this.parameters.length; i++) {
                this.parameters[i].items = this.parameters[i].items.map((el, index) => {
                    return {
                        ...el,
                        param_order: index,
                    }
                });
            }

            this.$emit('updateParameters', this.parameters);
        },
        removeParameter(parameter, index) {
            parameter.items.splice(index, 1);

            this.reorderParametersArray(parameter);
        }
    },

    mounted() {
        this.parameters = this.pageProductParameters;
    }
}
</script>

<style scoped lang="scss">
.card {
    .header {
        & > .delete {
            position: relative;
            top: 0;
            background: rgba(var(--white-color));
            border-radius: 1rem;
            width: 1.5rem;
            height: 1.5rem;
            line-height: 1.6rem;
            text-align: center;
            color: rgba(var(--red-color));
            cursor: pointer;
            margin-left: .5rem;

            &:hover {
                border: 1px solid rgba(var(--red-color));
                color: rgba(var(--white-color));
                background: rgba(var(--red-color));
            }
        }
    }

    .param {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: .25rem;

        & > .number {
            margin-right: 1rem;
        }

        & > .text {
            display: flex;
            align-items: center;
            width: 75%;
            margin-right: 1rem;

            & > span {
                margin-right: .25rem;
            }

            input {
                width: 50%;

                &:first-of-type {
                    margin-right: .5rem;
                }
            }
        }

        & > .values {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        & > .delete {
            position: relative;
            top: 0;
            background: rgba(var(--white-color));
            border-radius: 1rem;
            width: 1.5rem;
            height: 1.5rem;
            line-height: 1.6rem;
            text-align: center;
            color: rgba(var(--red-color));
            border: 1px solid rgba(var(--secondary-color), var(--opacity-point-three));
            cursor: pointer;

            &:hover {
                border: 1px solid rgba(var(--red-color));
                color: rgba(var(--white-color));
                background: rgba(var(--red-color));
            }
        }
    }
}
</style>
