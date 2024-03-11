<template>
    <div class="content-heading-holder">
        <button type="button" class="mobile-back-btn"></button>
        <h1 class="content-heading">Jaunumu abonēšana</h1>
    </div>

    <div class="form" v-if="viewLoaded">
        <h2 class="form-name">Kādus jaunumus savā e-pastā vēlies saņemt?</h2>

        <div class="form-group">
            <input type="checkbox" name="checkbox" id="cb-1" v-model="industry">
            <label for="cb-1">Jaunumi industrijā</label>
        </div>

        <div class="form-group">
            <input type="checkbox" name="checkbox" id="cb-2" v-model="offers">
            <label for="cb-2">Atlaides, izpārdošanas un īpašie piedāvājumi</label>
        </div>

        <button type="button" class="btn btn-submit btn-primary" @click="saveSubscriptions">Saglabāt</button>
    </div>
</template>

<script>

export default {
    name: 'profileNewsletter',
    props: ['locale'],
    data() {
        return {
            viewLoaded: false,
            industry: false,
            offers: false,
        }
    },
    methods: {
        translate(page, val) {
            return this.$store.state.currentTranslations[this.locale][page][val]
        },
        getSubscriptions() {
            this.$store.dispatch('getSubscription').then((data) => {
                console.log(data);
                this.industry = data.industry;
                this.offers = data.offers;

                this.viewLoaded = true;
            });
        },
        saveSubscriptions() {
            let payload = {
                industry: this.industry,
                offers: this.offers,
                locale: this.locale
            };

            this.$store.dispatch('saveSubscriptions', payload);
        }
    },
    mounted() {
        this.getSubscriptions();
    }
}
</script>

<style lang="scss" scoped>

.content-heading {
    margin: 0 0 32px 0 !important;
    font-size: 28px;
    line-height: 34px;
    letter-spacing: -0.56px;

    @media screen {
        @media (max-width: 991px) {
            font-size: 23px;
            line-height: 29px;
            letter-spacing: -0.46px;
        }
    }

    &.tablet-hidden {
        @media screen {
            @media (max-width: 991px) {
                display: none;
            }
        }
    }
}

.form {
    input[type="checkbox"] {
        width: 18px;
        height: 18px;
        margin-top: -1px;
        vertical-align: middle;

        &:checked {
            background-color: #E72E2C;
            border-color: #E72E2C;
        }
    }

    .form-name {
        margin: 0 0 24px 0;
        font-size: 20px;
        line-height: 26px;
        letter-spacing: -0.2px;

        @media screen {
            @media (max-width: 768px) {
                margin: 0 0 22px 0;
                font-size: 17px;
                line-height: 21px;
                letter-spacing: -0.17px;
            }
        }
    }

    .form-group {
        display: flex;
        align-items: center;
        margin: 0;

        &:not(:last-child) {
            margin: 0 0 16px 0;
        }
    }

    input[type="checkbox"] + label {
        font-size: 16px;
        font-weight: 400;
        color: #0D2441;
    }

    .btn-submit {
        max-width: 128px;
        margin-top: 16px;
        padding: 16px 30px;

        @media screen {
            @media (max-width: 575px) {
                max-width: 100%;
                width: 100%;
                margin-top: 23px;
            }
        }
    }
}
</style>
