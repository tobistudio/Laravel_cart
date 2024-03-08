<template>
    <div class="header-search">
        <div class="form">
            <div class="form-group d-flex">
                <input type="text" name="" class="form-control" placeholder="Meklē pēc detaļas nosaukuma vai OEM numura">
                <button type="submit" class="btn btn-primary">Meklēt</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'HeaderSearch',
    data() {
        return {
            auth: false,
        }
    },
    methods: {
        openAuthPopup(type) {
            this.$store.state.authPopup = type;
        }
    },
    mounted() {}
}
</script>

<style lang="scss" scoped>
.header-search {
    flex-grow: 1;
    margin-right: 24px;

    @media screen {
        @media (max-width: 1129px) {
            display: none;
        }
    }

    .form {
        width: 100%;
    }

    .form-group {
        margin: 0;
        width: 100%;
    }

    .form-control {
        flex-grow: 1;
    }

    button[type="submit"],
    input[type="submit"] {
        margin: 0 0 0 8px;
    }
}
</style>
