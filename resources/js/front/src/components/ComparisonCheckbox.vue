<!-- ComparisonCheckbox.vue -->
<template>
    <div class="form-group d-flex checkbox">
        <input
            type="checkbox"
            :id="`compare-${product.id}`"
            v-model="isChecked"
            :disabled="isDisabled"
            @change="handleCheckboxChange"
        />
        <label :for="`compare-${product.id}`">Pievienot salīdzināšanai ({{ comparisonCount }}/3)</label>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
    props: {
        product: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            isChecked: false,
        };
    },
    computed: {
        ...mapGetters(['comparisonList']),
        comparisonCount() {
            return this.comparisonList.length;
        },
        isDisabled() {
            return this.comparisonCount >= 3 && !this.isChecked;
        }
    },
    methods: {
        ...mapActions(['addProductToComparison', 'removeProductFromComparison']),
        handleCheckboxChange() {
            if (this.isChecked) {
                this.addProductToComparison(this.product);
            } else {
                this.removeProductFromComparison(this.product.id);
            }
        },
    },
    watch: {
        comparisonList: {
            handler(newList) {
                this.isChecked = newList.some(p => p.id === this.product.id);
            },
            deep: true,
            immediate: true,
        },
    },
};
</script>


