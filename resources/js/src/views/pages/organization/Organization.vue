<!-- =========================================================================================
  File Name: Organization.vue
  Description: Organization
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

            title: 'Organization'
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
