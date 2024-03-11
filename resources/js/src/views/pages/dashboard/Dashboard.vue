<!-- =========================================================================================
  File Name: Dashboard.vue
  Description: Dashboard
========================================================================================== -->
<template>
    <div v-if="dashboardLoaded" class="content">
        <h1>{{ title }}</h1>
    </div>
</template>

<script>
export default {
    data() {
        return {
            dashboardLoaded: false,

            title: 'Dashboard'
        }
    },
    mounted() {
        this.dashboardLoaded = true;
    },
    metaInfo() {
        return {
            title: this.title,
        }
    }
}
</script>
