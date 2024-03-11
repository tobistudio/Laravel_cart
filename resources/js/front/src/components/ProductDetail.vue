<template>
    <div class="product-page">
        <div class="product-card">
            <div class="product-content">
                <div class="image-container">
                    <img :src="product.image" :alt="product.name" class="product-image">
                </div>
                <div class="details">
                    <div v-if="product.manufacturer" class="manufacturer">
                        <img :src="product.manufacturer.image" :alt="product.manufacturer.name" class="manufacturer-image">
                    </div>
                    <h3 class="name">{{ product.name }}</h3>
                    <h4>Description</h4>
                    <div class="product-description">
                        <p style="white-space: pre-wrap">{{product.description}}</p>
                    </div>
                    <div class="product-code">Product Code: {{ product.sku }}</div>
                    <comparison-checkbox :product="product"></comparison-checkbox>
                    <div class="price">
                        <span v-if="product.special_price" class="new-price">€{{ product.special_price }}</span>
                        <span v-if="product.special_price" class="old-price">€{{ product.price }}</span>
                        <span v-else>€{{ product.price }}</span>
                    </div>
                    <product-options
                        v-if="hasOptions"
                        :options="product.options"
                        @option-changed="updateProductVariant"
                    />
                    <button @click="handleAddToCart" class="cart-btn btn btn-primary">Add to Cart</button>
                </div>
            </div>
            <product-description v-if="product.description" :description="product.description" />
        </div>
    </div>
</template>


<style scoped>
.product-page {
    display: flex;
    justify-content: center;
}

.product-card {
    max-width: 60%;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 25%;
}

.product-content {
    display: flex;
    align-items: flex-end;
    gap: 20px;
    padding-top: 20px;
}

.image-container {
    flex: 1;
    display: flex;
    justify-content: center;
}

.product-image {
    min-width: 100%;
    border-radius: 10px;
}

.details {
    flex: 2;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
}

.manufacturer-image {
    width: 100%;
    margin-bottom: 10px;
}

.cart-btn {
    margin-top: 10px;
}
</style>

<script>
import comparisonCheckbox from "./ComparisonCheckbox.vue";
export default {
    props: ['product'],
    methods: {
        handleAddToCart() {
            this.$store.dispatch('addToCart', {
                productId: this.product.id,
                quantity: 1
            });
        }
    }
}
</script>
