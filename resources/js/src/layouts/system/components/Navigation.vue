<!-- =========================================================================================
    File Name: Header.vue
    Description: System layout Header
========================================================================================== -->
<template>
    <div class="main">
        <div class="navigation" v-if="navigation.length > 0">
            <div v-for="an in navigation">
                    <router-link :to="an.url" v-if="an.url">
                        <div>{{ an.icon }}</div>
                        {{ an.name }}
                    </router-link>
                    <div v-else>
                        <div>{{ an.icon }}</div>
                        {{ an.name }}
                    </div>

                    <div v-if="an.children && an.children.length > 0">
                        <div v-for="anc in an.children">
                            <router-link :to="anc.url" v-if="anc.url">
                                <div>{{ anc.icon }}</div>
                                {{ anc.name }}
                            </router-link>
                            <div v-else>
                                <div>{{ anc.icon }}</div>
                                {{ anc.name }}
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        user: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            navigation: [],
        }
    },
    mounted() {
        this.navigation = [
            {name: 'Dashboard', url: '/system/dashboard', icon: ''},
            {name: 'Settings', url: '/system/settings', icon: ''}
        ];
    }
}
</script>
<style lang="scss" scoped>
.main {

}
</style>
