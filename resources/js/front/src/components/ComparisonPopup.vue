<template>
    <div class="comparison-popup" v-if="comparisonList.length > 0 && showPopup">
        <div class="popup-container">
            <div class="product-thumbnails">
                <span v-for="product in comparisonList" :key="product.id" class="product-item">
                    <div class="thumbnail-container">
                      <img :src="product.image" :alt="product.name" class="product-thumbnail">
                    </div>
                    <button class="remove-btn" @click="removeFromComparison(product.id)">✕</button>
                  </span>
            </div>
            <div class="button-container">
                <router-link to="/comparison" class="btn btn-primary">View Comparison</router-link>
                <button @click="closePopup" class="close-btn">Close</button>
            </div>
        </div>
    </div>
</template>


<script>

import { mapActions, mapGetters } from 'vuex';

export default {
    computed: {
        ...mapGetters(['comparisonList']),
    },
    data() {
        return {
            showPopup: true,
        };
    },
    methods: {
        ...mapActions(['removeProductFromComparison', 'clearComparisonList']),
        removeFromComparison(productId) {
            this.removeProductFromComparison(productId);
        },
        closePopup() {
            this.clearComparisonList();
        },
    },
};

</script>

<style scoped>
.comparison-popup {
    position: fixed;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    background-color: #0E2341;
    padding: 15px 20px;
    border-radius: 10px 10px 0 0;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    color: white;
    min-height: 100px;
    min-width: 600px;
}
.popup-container
{
    display: inline-flex;
    width: 100%;
    justify-content: space-between;
}
.product-thumbnails {
    display: flex;
    gap: 10px;
}

.product-thumbnail {
    width: 50px;
    height: 50px;
    object-fit: cover;
}

.product-item {
    position: relative;
}

.remove-btn {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: #ff4d4d;
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    line-height: 18px;
    text-align: center;
    cursor: pointer;
}

.remove-btn:hover {
    background-color: #e62626;
}

.thumbnail-container {
    width: 50px;
    height: 50px;
    overflow: hidden;
    border-radius: 5px;
}

.button-container {
    display: flex;
    justify-content: flex-end;
    margin-top: 10px;
}


.close-btn {
    background-color: #0E2341;
    color: white;
    border: 1px solid white;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
    margin-left: 5px;
    min-width:80px;

}

.close-btn:hover {
    background-color: white;
    color: black;
    border: 1px solid black;
}

</style>
