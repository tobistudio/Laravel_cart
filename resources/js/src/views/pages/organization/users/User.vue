<!-- =========================================================================================
  File Name: User.vue
  Description: User
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

            title: 'User'
        }
    },
    mounted() {
        this.pageLoaded = true;
        this.active_record = 'Lauris';
    },
    metaInfo() {
        return {
            title: this.title,
        }
    }
}
</script>
