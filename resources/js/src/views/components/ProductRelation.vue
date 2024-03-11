<template>
    <div class="row">
        <Card :cardTitle="title">
            <template #content>
                <MultiSelect
                    v-model="selectedProducts"
                    :options="products"
                    :maxSelectedLabels="1"
                    :virtualScrollerOptions="{ itemSize: 44 }"
                    optionLabel="name"
                    optionValue="id"
                    placeholder="Selected products"
                    style="width: 100%;"
                    filter
                    @change="onChange"
                    class="multiselect"
                >
                    <template #option="slotProps">
                        <div class="title">
                            {{ slotProps.option.name }}
                            <span class="id" style="display: none;">
                                {{ slotProps.option.id }}
                            </span>
                        </div>
                    </template>
                </MultiSelect>
            </template>
        </Card>
    </div>
</template>

<script>
import Card from '@/js/src/components/Card.vue';
import MultiSelect from 'primevue/multiselect';


export default {
    name: 'ProductRelation',

    props: [
        'selectedLanguage',
        'type',
        'title',
    ],

    components: {
        Card,
        MultiSelect
    },

    data() {
        return {
            selectedProducts: [],
            products: [],
            selectAll: false,
        }
    },

    methods: {
        async onChange(event) {
            let id = null;
            if (event.originalEvent.target instanceof HTMLInputElement) {
                id = Number(event.originalEvent.target.parentElement.parentElement.children[1].children[0].innerText);
            } else {
                id = Number(event.originalEvent.target.children[0].innerText);
            }

            if (this.selectedProducts.find(el => el === id)) {
                await this.$store.dispatch('createProductRelation', {
                    page_id: this.$route.params.page_id,
                    related_product_id: id,
                    type: this.type,
                });
            } else {
                await this.$store.dispatch('deleteProductRelation', {
                    page_id: this.$route.params.page_id,
                    related_product_id: id,
                });
            }

            this.selectAll = event.value.length === this.products.length;
        },
        async getProducts() {
            const products = await this.$store.dispatch('getProducts', {
                page_id: this.$route.params.page_id,
                language_id: this.selectedLanguage.id,
            });

            this.products = products.map(el => {
                return {
                    id: el.id,
                    name: el.language_page.name,
                }
            });
        },
        async getProductRelations() {
            const data = await this.$store.dispatch('getProductRelations', {
                page_id: this.$route.params.page_id,
                language_id: this.selectedLanguage.id,
                type: this.type,
            });

            this.selectedProducts = data.relations.map(el => el.related_product.id);
        },
    },

    async mounted() {
        await this.getProducts();
        await this.getProductRelations();
    }
}
</script>

<style scoped lang="scss">

</style>
