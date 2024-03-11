<template>
    <div class="row">
        <Card :cardTitle="title">
            <template #content>
                <div style="margin-top: .1rem;">
                    <MultiSelect
                        v-model="selectedAttributes"
                        display="chip"
                        :options="attributesList"
                        optionLabel="value"
                        placeholder="All attributes"
                        :maxSelectedLabels="7"
                        style="width: 100%; margin-bottom: .5rem;"
                        @change="updateComponentAttributes"
                        filter
                    />
                </div>

                <MultiSelect
                    v-if="selectedAttributes.length > 0"
                    v-model="selectedGroupedAttributes"
                    :options="availableGroupedAttributes"
                    optionGroupLabel="title"
                    optionGroupChildren="items"
                    optionLabel="value"
                    placeholder="Selected attributes"
                    @change="updatePageAttributes"
                    style="margin-bottom: 1rem;"
                    filter
                />
            </template>
        </Card>
    </div>
</template>

<script>
import Card from '@/js/src/components/Card.vue';
import MultiSelect from 'primevue/multiselect';


export default {
    name: 'ProductAttributes',

    components: {
        Card,
        MultiSelect,
    },

    emits: [
        'selectAttributes',
    ],

    props: [
        'pageProductAttributes',
        'selectedLanguage',
        'title',
    ],

    watch: {
        'selectedLanguage' () {
            this.fillAttributes();
        }
    },

    data: () => {
        return {
            attributesList: [],
            attributesListFull: [],
            selectedAttributes: [],
            selectedGroupedAttributes: [],
            availableGroupedAttributes: [],
        }
    },

    methods: {
        async getAttributes() {
            const data = await this.$store.dispatch('getAttributes');

            this.attributesListFull = data;
            this.attributesList = data.map(el => {
                return {
                    ...el.translations.find(el => el.language_id === this.selectedLanguage.id),
                    groupID: el.id,
                }
            });
        },
        updatePageAttributes() {
            this.$emit('selectAttributes', this.selectedGroupedAttributes);
        },
        updateComponentAttributes() {
            this.availableGroupedAttributes = [];
            this.selectedGroupedAttributes = [];

            for (let i=0; i<this.selectedAttributes.length; i++) {
                const attribute = this.attributesListFull.find(el => el.id === this.selectedAttributes[i].groupID);
                const items = [];

                for (let j=0; j<attribute.values.length; j++) {
                    const el = attribute.values[j].translations.find(el => el.language_id === this.selectedLanguage.id);

                    items.push({
                        id: attribute.values[j].id,
                        value: el.value,
                    });
                }

                this.availableGroupedAttributes.push({
                    id: attribute.id,
                    title: attribute.translations.find(el => el.language_id === this.selectedLanguage.id).value,
                    items
                });
            }
        },
        fillAttributes() {
            const selectedAttributesTmp = [];

            for (let i=0; i<this.pageProductAttributes.length; i++) {
                selectedAttributesTmp.push(this.attributesList.find(el => el.key === this.pageProductAttributes[i].attribute_value.attribute.translation_key));
            }

            this.selectedAttributes = [...new Set(selectedAttributesTmp)];

            for (let i=0; i<this.selectedAttributes.length; i++) {
                const attribute = this.attributesListFull.find(el => el.id === this.selectedAttributes[i].groupID);
                const items = [];

                for (let j=0; j<attribute.values.length; j++) {
                    const el = attribute.values[j].translations.find(el => el.language_id === this.selectedLanguage.id);

                    items.push({
                        id: attribute.values[j].id,
                        value: el.value,
                    });
                }

                this.availableGroupedAttributes.push({
                    id: attribute.id,
                    title: attribute.translations.find(el => el.language_id === this.selectedLanguage.id).value,
                    items
                });
            }

            this.selectedGroupedAttributes = this.pageProductAttributes.map(el => {
                return {
                    id: el.attribute_value.id,
                    value: el.attribute_value.translations.find(el => el.language_id === this.selectedLanguage.id).value
                }
            });
        }
    },

    async mounted() {
        await this.getAttributes();

        this.fillAttributes();
    }
}
</script>

<style scoped lang="scss">
.card {
    .content {
        :deep(.p-multiselect-token) {
            background: rgba(var(--secondary-color));
            color: rgba(var(--accent-color));
        }

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

<style lang="scss">
.p-multiselect-panel {
    .p-multiselect-items .p-multiselect-item.p-highlight.p-focus {
        background: rgba(var(--secondary-button-background-color));
        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
        border: 2px solid rgba(var(--primary-color));
    }

    .p-multiselect-items .p-multiselect-item.p-highlight {
        background: rgba(var(--secondary-button-background-color));
        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
    }

    .p-checkbox .p-checkbox-box.p-highlight {
        background: rgba(var(--primary-button-background-color));
        border-color: rgba(var(--primary-button-background-color));
        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
    }
}
</style>
