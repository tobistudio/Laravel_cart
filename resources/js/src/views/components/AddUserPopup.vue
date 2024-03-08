<template>
    <div class="popup">
        <div class="popup-overlay" @click="closePopup"></div>
        <div class="popup-content-wrapper">
            <div class="popup-content" @click.prevent.stop>
                <div class="popup-header">
                    <div class="title">Add User</div>
                    <div class="close" @click="closePopup">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24"><path fill="currentColor" d="m16.192 6.344l-4.243 4.242l-4.242-4.242l-1.414 1.414L10.535 12l-4.242 4.242l1.414 1.414l4.242-4.242l4.243 4.242l1.414-1.414L13.364 12l4.242-4.242z"></path></svg>
                    </div>
                </div>
                <div class="popup-content">
                    <div v-if="error_message" class="error">{{ error_message }}</div>


                    <div class="input-wrapper-container">
                        <div :class="['input-wrapper name', localName ? 'has-content' : '', name_validation ? 'error' : '', nameClassFocus]">
                            <div class="label">{{ trans.name }}</div>
                            <div class="label-floating">{{ trans.name }}</div>
                            <input v-model="localName" type="text" @focus="nameFocus" @blur="nameBlur"/>
                            <span class="error" v-if="name_validation">{{ name_validation }}</span>
                        </div>

                        <div :class="['input-wrapper locale', localLocale ? 'has-content' : '', locale_validation ? 'error' : '', localeClassFocus]">
                            <div class="label">{{ trans.locale }}</div>
                            <div class="label-floating">{{ trans.locale }}</div>
                            <input v-model="localLocale" type="email" @focus="localeFocus" @blur="localeBlur"/>
                            <span class="error" v-if="locale_validation">{{ locale_validation }}</span>
                        </div>
                    </div>

                    <WDSelect field="localCountry" label="name" :title="trans.country" :options="countries" :selectedOption="localCountry" @selectedOptionUpdated="selectedOptionUpdated" :validation="country_validation"></WDSelect>
                    <WDSelect field="localPrimary" label="label" :title="trans.primary" :options="primaryOptions" :selectedOption="localPrimary" @selectedOptionUpdated="selectedOptionUpdated" :validation="primary_validation"></WDSelect>
                    <WDSelect field="localActive" label="label" :title="trans.active" :options="activeOptions" :selectedOption="localActive" @selectedOptionUpdated="selectedOptionUpdated" :validation="active_validation"></WDSelect>

                    <div class="actions">
                        <button class="primary" @click="saveLanguage">{{ trans.save }}</button>
                        <button class="secondary" @click="closePopup">{{ trans.cancel }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import WDSelect from "./wd-select.vue";

export default {
    props: {
        language: {
            type: Object
        },
        countries: {
            type: Array,
            required: true
        },
    },
    components: {
        WDSelect
    },
    data() {
        return {
            localName: '',
            nameClassFocus: false,
            name_validation: null,

            localLocale: '',
            localeClassFocus: false,
            locale_validation: null,

            localCountry: {},
            country_validation: null,

            primaryOptions: [
                {label: 'Primary', value: 1},
                {label: 'Not Primary', value: 0},
            ],
            localPrimary: {},
            primary_validation: null,

            activeOptions: [
                {label: 'Active', value: 1},
                {label: 'Not Active', value: 0},
            ],
            localActive: {},
            active_validation: null,

            error_message: null,

            trans: {
                name: 'Name',
                locale: 'Locale',
                country: 'Country',
                primary: 'Primary',
                active: 'Active',
                save: 'Save',
                cancel: 'Cancel',
                message: {
                    language_update_error: 'language not updated please try later',
                    name_required: 'Name is required',
                    locale_required: 'Locale is required',
                    country_required: 'Country is required',
                    primary_required: 'Primary is required',
                    active_required: 'Active is required',
                    primary_inactive: 'Primary language can not be inactive',
                }
            }
        }
    },
    methods: {
        nameFocus() {
            this.nameClassFocus = 'focus';
        },
        nameBlur() {
            this.nameClassFocus = false;
        },
        localeFocus() {
            this.nameClassFocus = 'focus';
        },
        localeBlur() {
            this.nameClassFocus = false;
        },
        selectedOptionUpdated(option, field) {
            this[field] = option;
        },
        saveLanguage() {
            let payload = {
                id: this.language.id,
                name: this.localName,
                locale: this.localLocale,
                country_id: this.localCountry.id,
                primary: this.localPrimary.value,
                active: this.localActive.value,
            };

            this.$store.dispatch('saveLanguage', payload).then((data) => {
                this.$store.state.error_message = false;
                this.$store.state.success_message = data.message;
                this.$store.state.message_type = data.message_type ? data.message_type : 'system';

                this.$emit('languageSaved', data);
            }).catch(res => {
                if (res.errors) {
                    this.name_validation = res.errors.name ? this.trans.message[res.errors.name[0]] : null;
                    this.locale_validation = res.errors.locale ? this.trans.message[res.errors.locale[0]] : null;
                    this.country_validation = res.errors.country ? this.trans.message[res.errors.country[0]] : null;
                    this.primary_validation = res.errors.primary ? this.trans.message[res.errors.primary[0]] : null;
                    this.active_validation = res.errors.active ? this.trans.message[res.errors.active[0]] : null;
                } else {
                    this.error_message = res.message ? this.trans.message[res.message]: null;
                }
            });
        },
        closePopup() {
            this.$emit('closePopup');
        }
    },
    mounted() {
        this.localName = this.language.name;
        this.localLocale = this.language.locale;
        this.localCountry = this.language.country;
        this.localPrimary = this.primaryOptions.filter(p => p.value === this.language.primary)[0];
        this.localActive = this.activeOptions.filter(a => a.value === this.language.active)[0];
    }
}
</script>

<style lang="scss" scoped>
    .popup {
        align-items: center;
        justify-content: center;
        margin: auto;
        border-radius: inherit;
        display: flex;
        left: 0;
        position: fixed;
        top: 0;
        bottom: 0;
        right: 0;
        z-index: 2;

        .popup-overlay {
            border-radius: inherit;
            bottom: 0;
            left: 0;
            opacity: 1;
            position: fixed;
            right: 0;
            top: 0;
            background: rgba(var(--popup-background-color),var(--opacity-point-six));
            z-index: 2;
        }

        .popup-content-wrapper {
            max-height: calc(100% - 48px);
            width: 800px;
            max-width: calc(100% - 48px);
            margin: 24px;
            display: flex;
            flex-direction: column;
            border-radius: 6px;
            z-index: 2;

            .popup-content {
                display: flex;
                flex-direction: column;
                overflow-y: auto;
                box-shadow: 0 8px 10px -5px rgba(var(--popup-background-color), var(--opacity-point-zero-six)),0 16px 24px 2px rgba(var(--popup-background-color), var(--opacity-point-zero-four)),0 6px 30px 5px rgba(var(--popup-background-color), var(--opacity-point-zero-two));
                background: rgb(var(--accent-color));
                color: rgba(var(--secondary-color),var(--opacity-point-six));
                min-height: 100px;
                border-radius: 6px;

                .popup-header {
                    padding: 20px 20px 12px 20px;
                    position: relative;
                    border-bottom: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));

                    .title {
                        font-size: 1.25rem;
                        line-height: 1.6;
                        font-weight: 500;
                        letter-spacing: .0094rem;
                        text-overflow: ellipsis;
                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                    }

                    .close {
                        position: absolute;
                        z-index: 2;
                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                        top: 0.9375rem;
                        right: 0.9375rem;
                        width: 34px;
                        height: 34px;
                        align-items: center;
                        display: flex;
                        transition: transform,opacity .2s cubic-bezier(.4,0,.2,1);
                        grid-area: content;
                        justify-content: center;
                        white-space: nowrap;
                        cursor: pointer;
                        border-radius: 50%;

                        svg {
                            color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                            font-size: 24px;
                            height: 24px;
                            width: 24px;
                        }

                        &:hover {
                            background: rgba(var(--icon-hover-background-color));
                        }
                    }
                }

                .popup-content {
                    padding: 12px 20px 20px 20px;

                    .error {
                        padding: 13.5px;
                        background: rgba(var(--red-color), var(--opacity-point-one-two));
                        border-radius: 6px;
                        color: rgba(var(--red-color));
                        margin-bottom: 20px;
                    }

                    .input-wrapper-container {
                        display: flex;
                        flex-direction: row;
                    }

                    .input-wrapper {
                        grid-area: field;
                        position: relative;
                        align-items: flex-start;
                        display: flex;
                        cursor: text;
                        font-size: 16px;
                        letter-spacing: .009375em;
                        padding: 12px 0;
                        opacity: 1;
                        flex-direction: column;

                        &.name {
                            width: 70%;
                        }

                        &.locale {
                            width: 30%;
                            margin-left: 20px;
                        }

                        .label {
                            visibility: visible;
                            contain: layout paint;
                            margin-inline-start: 16px;
                            margin-inline-end: 16px;
                            max-width: calc(100% - 16px - 16px);
                            pointer-events: none;
                            position: absolute;
                            top: 28px;
                            transform-origin: left center;
                            transition: .15s cubic-bezier(.4,0,.2,1);
                            transition-property: all;
                            transition-property: opacity,transform;
                        }

                        .label-floating {
                            visibility: hidden;
                            transform: translateY(-50%);
                            margin: 0 4px;
                            font-size: 0.75em;
                            left: 10px;
                            position: absolute;
                            z-index: 999;
                            background: #fff;
                            padding: 0 10px;
                            font-weight: 600;
                            background: rgba(var(--accent-color));
                            color: rgba(var(--secondary-color), var(--opacity-point-six));
                        }

                        input {
                            color: #000;
                            opacity: 0.6;
                            flex: 1;
                            transition: .15s opacity cubic-bezier(.4,0,.2,1);
                            min-width: 0;
                            display: flex;
                            flex-wrap: wrap;
                            letter-spacing: .009375em;
                            min-height: 56px;
                            max-height: 56px;
                            padding-inline-start: 16px;
                            padding-inline-end: 16px;
                            padding-top: 5px;
                            padding-bottom: 6px;
                            width: 100%;
                            border-radius: 6px;
                            border: 1px solid rgba(50, 71, 92, 0.6);
                            font-size: 16px;
                            background: rgba(var(--accent-color));
                            color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                            &:focus-visible {
                                outline: unset;
                            }
                        }

                        &.has-content {
                            .label {
                                visibility: hidden;
                            }

                            .label-floating {
                                visibility: visible;
                            }
                        }

                        &.error {
                            input {
                                border-color: rgba(var(--primary-color));
                            }

                            .label {
                                color: rgba(var(--primary-color));
                            }

                            .label-floating {
                                color: rgba(var(--primary-color));
                            }
                        }

                        &.focus {
                            .label {
                                visibility: hidden;
                            }

                            .label-floating {
                                visibility: visible;
                                color: rgba(var(--primary-color));
                            }

                            input {
                                border: 2px solid rgba(var(--primary-color));
                                padding-inline-start: 15px;
                            }
                        }

                        img {
                            cursor: pointer;
                            opacity: 0.6;
                            width: 24px;
                            position: absolute;
                            top: 28px;
                            right: 16px;
                        }

                        span.error {
                            color: rgba(var(--primary-color));
                            align-items: flex-end;
                            display: flex;
                            font-size: .75rem;
                            font-weight: 400;
                            letter-spacing: .0333333333em;
                            line-height: normal;
                            min-height: 22px;
                            overflow: hidden;
                            justify-content: space-between;
                            padding: 3px 14px 0 14px;
                        }
                    }

                    .actions {
                        border: 0;
                        flex-direction: row;
                        padding: 0;
                        align-items: center;
                        align-self: center;
                        display: flex;
                        width: 100%;
                        margin-top: 20px;

                        button {
                            width: 50%;
                            border-radius: 4px;
                            cursor: pointer;
                            line-height: 23px;
                            outline: 0;
                            padding: 8px;
                            transition: all .2s ease-in-out;
                            text-transform: uppercase;
                            font-weight: 600;
                            font-size: 16px;

                            &:hover {
                                opacity: var(--opacity-point-eight-seven);
                            }

                            &:disabled {
                                opacity: var(--opacity-point-six);
                            }

                            &.primary {
                                background: rgba(var(--primary-button-background-color));
                                border: 1px solid rgba(var(--primary-button-background-color));
                                color: rgba(var(--primary-button-color));
                                margin-right: 10px;
                            }

                            &.secondary {
                                background: rgba(var(--secondary-button-background-color));
                                border: 1px solid rgba(var(--secondary-button-background-color));
                                color: rgba(var(--secondary-button-color));
                                margin-left: 10px;
                            }
                        }
                    }
                }
            }
        }
    }
</style>
