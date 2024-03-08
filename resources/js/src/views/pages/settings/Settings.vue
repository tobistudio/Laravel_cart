<!-- =========================================================================================
  File Name: Settings.vue
  Description: Settings
========================================================================================== -->
<template>
    <div v-if="pageLoaded" class="content">
        <h1>{{ title }}</h1>

        <div class="row">
            <div class="simple-card half">
                <div class="data">
                    <div class="header">Maintenance</div>
                    <div class="content">
                        <div class="checkbox-data">
                            <div :class="['checkbox', maintenance ? 'checked' : '']" @click="toggleMaintenance">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                <input type="checkbox" v-model="maintenance">
                            </div>
                            <div class="label" v-if="maintenance">Maintenance is enabled <a :href="$store.state.APP_URL + '/' + $store.state.MAINTENANCE_TOKEN" target="_blank">{{ $store.state.APP_URL + '/' + $store.state.MAINTENANCE_TOKEN  }}</a></div>
                            <div class="label" v-else>Maintenance is disabled</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            pageLoaded: false,

            title: 'Settings',
            maintenance: false
        }
    },
    methods: {
        getSetting() {
            this.$store.dispatch('getSettings')
                .then((data) => {
                    this.maintenance = data.settings.maintenance;
                    this.pageLoaded = true;
                });
        },
        toggleMaintenance() {
            let payload = {
              maintenance: !this.maintenance
            };

            this.$store.dispatch('toggleMaintenance', payload)
                .then(() => {
                    this.maintenance = !this.maintenance;
                });
        },
    },
    mounted() {
        this.getSetting();
    },
    metaInfo() {
        return {
            title: this.title,
        }
    }
}
</script>
<style lang="scss" scoped>
    .row {
        display: flex;
        flex-wrap: wrap;
        margin: -12px;

        .simple-card {
            padding: 12px;

            &.half {
                flex: 0 0 50%;
            }

            .data {
                border-radius: 0.5rem;
                background: rgba(var(--accent-color));
                color: rgba(50, 71, 92, 0.6);
                box-shadow: 0 2px 9px -2px rgba(50, 71, 92, 0.06),0 4px 9px 1px rgba(50, 71, 92, 0.04),0 2px 6px 4px rgba(50, 71, 92, 0.02);

                .header {
                    padding: 1.5rem;
                    font-size: 1.25rem;
                    font-weight: 500;
                    letter-spacing: .0094rem;
                    color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                }

                .content {
                    padding: 0 1.5rem 1.5rem 1.5rem;

                    .checkbox-data {
                        display: flex;

                        .checkbox {
                                position: relative;
                                cursor: pointer;
                                width: 28px;
                                height: 28px;
                                margin-left: -4px;
                                margin-right: 4px;

                                svg {
                                    width: 100%;
                                    height: 100%;
                                    display: block;
                                    color: rgba(var(--secondary-color), var(--opacity-point-six));

                                    &.check-active {
                                        display: none;
                                        color: rgba(var(--primary-color));
                                    }
                                }

                                input {
                                    display: none;
                                }

                                &.checked {
                                    svg {
                                        display: none;

                                        &.check-active {
                                            display: block;
                                        }
                                    }
                                }
                            }

                        .label {
                            color: rgba(var(--secondary-color), var(--opacity-point-six));
                            line-height: 30px;

                            a {
                                color: rgba(var(--primary-color));
                                text-decoration: unset;
                            }
                        }
                    }
                }
            }

        }
    }
</style>
