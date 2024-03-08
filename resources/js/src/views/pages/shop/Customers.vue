<!-- =========================================================================================
  File Name: Categories.vue
  Description: Categories
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

            title: 'Customers'
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
