<!-- =========================================================================================
  File Name: BlockProductCategories.vue
  Description: Block Product Categories
========================================================================================== -->
<template>
    <div class="block-data" v-if="blockLoaded">
    </div>
</template>
<script>
import draggable from 'vuedraggable'
import WDSelect from '../../components/WD-select.vue';

export default {
    props: {
        block: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            blockLoaded: false,
            local_data: null
        }
    },
    watch: {
        local_data: {
            handler(oldData, newData) {
                if (newData) {
                    this.$emit('blockUpdated', this.block.id, this.block.tmp_id, this.local_data, null);
                }
            },
            deep: true,
            immediate: true,
        },
    },
    mounted() {
        this.local_data = {};

        this.blockLoaded = true;
        this.$emit('sidebarBlockUpdated', this.block.id, this.block.tmp_id, this.local_data, null);
    }
}
</script>

<style lang="scss" scoped>
.block-data {
    margin-top: 10px;
    margin-bottom: 10px;
}
</style>
