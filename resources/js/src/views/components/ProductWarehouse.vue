<template>
    <div class="row">
        <Card :cardTitle="trans.title">
            <template #content>
                <div class="row">
                    <Card :cardTitle="trans.productPack">
                        <template #content>
                            <div class="row">
                            <span class="p-float-label">
                                <InputText id="packedWeight" type="number" v-model="packedWeight" @change="updateWarehouseProductCount()" />
                                <label for="packedWeight">{{ trans.packedWeight }}</label>
                            </span>
                            </div>

                            <div class="row">
                            <span class="p-float-label">
                                <InputText id="packedHeight" type="number" v-model="packedHeight" @change="updateWarehouseProductCount()" />
                                <label for="packedHeight">{{ trans.packedHeight }}</label>
                            </span>
                            </div>

                            <div class="row">
                            <span class="p-float-label">
                                <InputText id="packedWidth" type="number" v-model="packedWidth" @change="updateWarehouseProductCount()" />
                                <label for="packedWidth">{{ trans.packedWidth }}</label>
                            </span>
                            </div>

                            <div class="row">
                            <span class="p-float-label">
                                <InputText id="packedVolume" type="number" v-model="packedVolume" @change="updateWarehouseProductCount()" />
                                <label for="packedVolume">{{ trans.packedVolume }}</label>
                            </span>
                            </div>
                        </template>
                    </Card>
                </div>

                <div class="row">
                    <ul>
                        <li v-for="(warehouse, index) in warehouseList">
                            <Card :cardTitle="warehouse.translations.find(el => el.language_id === selectedLanguage.id).value">
                                <template #content>
                                    <div class="row">
                                        <span class="p-float-label">
                                            <InputText id="packedVolume" type="number" v-model="warehouseProductCount[index].value" @change="updateWarehouseProductCount()" />
                                            <label for="packedVolume">{{ trans.productCount }}</label>
                                        </span>

                                        <span class="p-float-label">
                                            <InputText id="packedVolume" type="number" v-model="warehouseProductCount[index].price" @change="updateWarehouseProductCount()" />
                                            <label for="packedVolume">{{ trans.packedPrice }}</label>
                                        </span>
                                    </div>
                                </template>
                            </Card>
                        </li>
                    </ul>
                </div>
            </template>
        </Card>
    </div>
</template>

<script>
import Button from '@/js/src/components/Button.vue';
import Card from '@/js/src/components/Card.vue';
import InputText from 'primevue/inputtext';


export default {
    name: 'ProductWarehouse',

    components: {
        Card,
        Button,
        InputText,
    },

    props: [
        'selectedLanguage',
        'productWarehouseCount',
        'productWarehousePacked',
    ],

    emits: [
        'update-warehouse-product-count'
    ],

    watch: {
        productWarehouseCount() {
            this.getWarehouses();
        },
        productWarehousePacked() {
            if (this.$props.productWarehousePacked) {
                this.packedWeight = this.$props.productWarehousePacked.packedWeight;
                this.packedHeight = this.$props.productWarehousePacked.packedHeight;
                this.packedWidth = this.$props.productWarehousePacked.packedWidth;
                this.packedVolume = this.$props.productWarehousePacked.packedVolume;
            } else {
                this.packedWeight = null;
                this.packedHeight = null;
                this.packedWidth = null;
                this.packedVolume = null;
            }
        },
    },

    data() {
        return {
            trans: {
                title: 'Warehouse',
                productPack: 'Packed product',
                productCount: 'Product count',
                packedWeight: 'Packed weight kg',
                packedHeight: 'Packed height cm',
                packedWidth: 'Packed width cm',
                packedVolume: 'Packed volume cm',
                packedPrice: 'Packed product price',
            },

            warehouseList: [],
            warehouseProductCount: [],

            packedWeight: null,
            packedHeight: null,
            packedWidth: null,
            packedVolume: null,
        }
    },

    methods: {
        updateWarehouseProductCount() {
            this.$emit('update-warehouse-product-count', {
                count: this.warehouseProductCount,
                packedWeight: this.packedWeight,
                packedHeight: this.packedHeight,
                packedWidth: this.packedWidth,
                packedVolume: this.packedVolume,
            });
        },
        async getWarehouses() {
            const warehouseList = await this.$store.dispatch('getWarehouses');
            const data = [];

            this.warehouseProductCount = [];

            for (let i=0; i<warehouseList.length; i++) {
                for (let j=0; j<warehouseList[i].warehouses.length; j++) {
                    if (warehouseList[i].warehouses[j].type !== 3) {
                        data.push(warehouseList[i].warehouses[j]);

                        const savedProductCount = this.$props.productWarehouseCount.find(el => el.warehouse_id === warehouseList[i].warehouses[j].id);

                        this.warehouseProductCount.push({
                            warehouseId: warehouseList[i].warehouses[j].id,
                            value: savedProductCount ? savedProductCount.product_count : null,
                            price: savedProductCount ? savedProductCount.product_price : null,
                        });
                    }
                }
            }

            this.warehouseList = data;
        },
    },

    async mounted() {
        await this.getWarehouses();

        if (this.$props.productWarehousePacked) {
            this.packedWeight = this.$props.productWarehousePacked.packedWeight;
            this.packedHeight = this.$props.productWarehousePacked.packedHeight;
            this.packedWidth = this.$props.productWarehousePacked.packedWidth;
            this.packedVolume = this.$props.productWarehousePacked.packedVolume;
        }
    }
}
</script>

<style scoped lang="scss">
.card {
    .content {
        & > div {
            .p-float-label {
                input {
                    width: 100%;
                    margin-bottom: .5rem;
                }
            }

            & > ul {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                list-style: none;
                padding-left: 0;

                & > li {
                    display: flex;
                    align-items: center;
                    width: 100%;
                    margin-bottom: .5rem;
                }
            }

            .title {
                width: 25%;
            }

            .value {
                width: 75%;

                input {
                    width: 100%;
                }
            }
        }
    }
}
</style>
