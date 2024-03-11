<!-- =========================================================================================
  File Name: DiscountCodes.vue
  Description: Discount codes
========================================================================================== -->
<template>
    <div v-if="pageLoaded" class="content">
        <h1>{{ title }}</h1>
    </div>
</template>

<script>
export default {
    data() {
        return {
            pageLoaded: false,

            title: 'Discount codes'
        }
    },
    mounted() {
        this.pageLoaded = true;
    },
    metaInfo() {
        return {
            title: this.title,
        }
    }
}
</script>
