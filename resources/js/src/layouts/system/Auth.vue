<!-- =========================================================================================
    File Name: System.vue
    Description: System layout
========================================================================================== -->

<template>
    <div v-if="layoutLoaded" class="auth">
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    data() {
        return {
            layoutLoaded: false,
        }
    },
    mounted() {
        this.layoutLoaded = true;
    }
}
</script>
<style lang="scss" scoped>
    .auth {
        height: 100vh;
    }
</style>
