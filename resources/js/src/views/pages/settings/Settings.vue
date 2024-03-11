<!-- =========================================================================================
  File Name: Settings.vue
  Description: Settings
========================================================================================== -->
<template>
    <div class="content" v-if="pageLoaded">
        <div class="row">
            <div class="full">
                <div :class="['card', 'with-header', maintenanceBlockOpen ? 'open' : '']">
                    <div class="header">
                        <div class="title">Maintenance</div>
                        <div class="controls">
                            <div class="button" @click="toggleMaintenanceBlock" v-if="maintenanceBlockOpen">
                                <i class='bx bx-chevron-up'></i>
                            </div>
                            <div class="button" @click="toggleMaintenanceBlock" v-if="!maintenanceBlockOpen">
                                <i class='bx bx-chevron-down'></i>
                            </div>
                        </div>
                    </div>
                    <div class="content" v-if="maintenanceBlockOpen">
                        <div class="row">
                            <div class="full">
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
        </div>

        <div class="row">
            <div class="full">
                <div :class="['card', 'with-header', storeInformationBlockOpen ? 'open' : '']">
                    <div class="header">
                        <div class="title">Store Information</div>
                        <div class="controls">
                            <div class="button" @click="toggleStoreInformationBlock" v-if="storeInformationBlockOpen">
                                <i class='bx bx-chevron-up'></i>
                            </div>
                            <div class="button" @click="toggleStoreInformationBlock" v-if="!storeInformationBlockOpen">
                                <i class='bx bx-chevron-down'></i>
                            </div>
                        </div>
                    </div>
                    <div class="content" v-if="storeInformationBlockOpen">

                        <div class="row">
                            <div class="full">
                                <div :class="['input-wrapper', store_information.address ? 'has-content' : '', addressClassFocus]">
                                    <div class="label">{{ trans.address }}</div>
                                    <div class="label-floating">{{ trans.address }}</div>
                                    <input v-model="store_information.address" type="text" @focus="addressFocus" @blur="addressBlur"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="full">
                                <div :class="['input-wrapper', store_information.address_url ? 'has-content' : '', addressUrlClassFocus]">
                                    <div class="label">{{ trans.address_url }}</div>
                                    <div class="label-floating">{{ trans.address_url }}</div>
                                    <input v-model="store_information.address_url" type="text" @focus="addressUrlFocus" @blur="addressUrlBlur"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="full">
                                <div :class="['input-wrapper', store_information.phone_primary ? 'has-content' : '', phonePrimaryClassFocus]">
                                    <div class="label">{{ trans.phone_primary }}</div>
                                    <div class="label-floating">{{ trans.phone_primary }}</div>
                                    <input v-model="store_information.phone_primary" type="text" @focus="phonePrimaryFocus" @blur="phonePrimaryBlur"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="full">
                                <div :class="['input-wrapper', store_information.phone_secondary ? 'has-content' : '', phoneSecondaryClassFocus]">
                                    <div class="label">{{ trans.phone_secondary }}</div>
                                    <div class="label-floating">{{ trans.phone_secondary }}</div>
                                    <input v-model="store_information.phone_secondary" type="text" @focus="phoneSecondaryFocus" @blur="phoneSecondaryBlur"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="full">
                                <div :class="['input-wrapper', store_information.email ? 'has-content' : '', emailClassFocus]">
                                    <div class="label">{{ trans.email }}</div>
                                    <div class="label-floating">{{ trans.email }}</div>
                                    <input v-model="store_information.email" type="text" @focus="emailFocus" @blur="emailBlur"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="full">
                                <div :class="['input-wrapper', store_information.facebook ? 'has-content' : '', facebookClassFocus]">
                                    <div class="label">{{ trans.facebook }}</div>
                                    <div class="label-floating">{{ trans.facebook }}</div>
                                    <input v-model="store_information.facebook" type="text" @focus="facebookFocus" @blur="facebookBlur"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="full">
                                <div :class="['card', 'with-header', workingHoursBlockOpen ? 'open' : '']">
                                    <div class="header">
                                        <div class="title">Working hours</div>
                                        <div class="controls">
                                            <div class="button" @click="toggleWorkingHoursBlock" v-if="workingHoursBlockOpen">
                                                <i class='bx bx-chevron-up'></i>
                                            </div>
                                            <div class="button" @click="toggleWorkingHoursBlock" v-if="!workingHoursBlockOpen">
                                                <i class='bx bx-chevron-down'></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content" v-if="workingHoursBlockOpen">
                                        <draggable
                                            v-model="store_information.working_hours"
                                            ghost-class="ghost"
                                            item-key="id">
                                            <template #item="{element}">
                                                <div :class="['card', 'with-header', element.active ? 'open' : '']">
                                                <div class="header">
                                                    <div class="title">{{ element.name ? element.name : trans.new_working_hours }}</div>
                                                    <div class="controls">
                                                        <div class="button" @click="closeItem(element)" v-if="element.active">
                                                            <i class='bx bx-chevron-up'></i>
                                                        </div>
                                                        <div class="button" @click="openItem(element)" v-if="!element.active">
                                                            <i class='bx bx-chevron-down'></i>
                                                        </div>
                                                        <div class="button"
                                                             @click="openDeleteConfirmPopup('removeIconTextBlockItem', 'icon-text-block-item', this.block.id, element.title ? element.title : trans.new_item, element.id)">
                                                            <i class='bx bx-x'></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content" v-if="element.active">
                                                    <div class="row">
                                                        <div class="half">
                                                            <div class="row">
                                                                <div class="full">
                                                                    <div :class="['input-wrapper', element.name ? 'has-content' : '', titleClassFocus]">
                                                                        <div class="label">{{ trans.working_hours_name }}</div>
                                                                        <div class="label-floating">{{ trans.working_hours_name }}</div>
                                                                        <input v-model="element.name" type="text" @focus="titleFocus" @blur="titleBlur"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="half">
                                                            <div class="row">
                                                                <div class="full">
                                                                    <div :class="['input-wrapper', element.value ? 'has-content' : '', titleClassFocus]">
                                                                        <div class="label">{{ trans.working_hours_value }}</div>
                                                                        <div class="label-floating">{{ trans.working_hours_value }}</div>
                                                                        <input v-model="element.value" type="text" @focus="titleFocus" @blur="titleBlur"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </template>
                                        </draggable>

                                        <div class="row">
                                            <div class="full">
                                                <button class="primary mb-1" @click="addWorkingHoursItem">{{ trans.add_working_hours }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="full">
                                <div :class="['card', 'with-header', credentialsBlockOpen ? 'open' : '']">
                                    <div class="header">
                                        <div class="title">Credentials</div>
                                        <div class="controls">
                                            <div class="button" @click="toggleCredentialsBlock" v-if="credentialsBlockOpen">
                                                <i class='bx bx-chevron-up'></i>
                                            </div>
                                            <div class="button" @click="toggleCredentialsBlock" v-if="!credentialsBlockOpen">
                                                <i class='bx bx-chevron-down'></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content" v-if="credentialsBlockOpen">
                                        <draggable
                                            v-model="store_information.credentials"
                                            ghost-class="ghost"
                                            item-key="id">
                                            <template #item="{element}">
                                                <div :class="['card', 'with-header', element.active ? 'open' : '']">
                                                    <div class="header">
                                                        <div class="title">{{ element.name ? element.name : trans.new_credentials }}</div>
                                                        <div class="controls">
                                                            <div class="button" @click="closeItem(element)" v-if="element.active">
                                                                <i class='bx bx-chevron-up'></i>
                                                            </div>
                                                            <div class="button" @click="openItem(element)" v-if="!element.active">
                                                                <i class='bx bx-chevron-down'></i>
                                                            </div>
                                                            <div class="button"
                                                                 @click="openDeleteConfirmPopup('removeIconTextBlockItem', 'icon-text-block-item', this.block.id, element.title ? element.title : trans.new_item, element.id)">
                                                                <i class='bx bx-x'></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content" v-if="element.active">
                                                        <div class="row">
                                                            <div class="half">
                                                                <div class="row">
                                                                    <div class="full">
                                                                        <div :class="['input-wrapper', element.name ? 'has-content' : '', titleClassFocus]">
                                                                            <div class="label">{{ trans.credentials_name }}</div>
                                                                            <div class="label-floating">{{ trans.credentials_name }}</div>
                                                                            <input v-model="element.name" type="text" @focus="titleFocus" @blur="titleBlur"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="half">
                                                                <div class="row">
                                                                    <div class="full">
                                                                        <div :class="['input-wrapper', element.value ? 'has-content' : '', titleClassFocus]">
                                                                            <div class="label">{{ trans.credentials_value }}</div>
                                                                            <div class="label-floating">{{ trans.credentials_value }}</div>
                                                                            <input v-model="element.value" type="text" @focus="titleFocus" @blur="titleBlur"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </draggable>

                                        <div class="row">
                                            <div class="full">
                                                <button class="primary mb-1" @click="addCredentialsItem">{{ trans.add_credentials }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="full">
                                <button class="primary" @click="saveStoreInformation">{{ trans.save }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import draggable from 'vuedraggable'
import Editor from '../../components/Editor.vue';

export default {
    // props: {
    //     block: {
    //         type: Object,
    //         required: true,
    //     },
    //     removeLanguagePageBlockOrItem: {
    //         type: Object,
    //     }
    // },
    data() {
        return {
            pageLoaded: false,
            title: 'Settings',

            maintenanceBlockOpen: false,
            maintenance: false,

            storeInformationBlockOpen: false,
            workingHoursBlockOpen: false,
            credentialsBlockOpen: false,
            store_information: {
                address: '',
                address_url: '',
                phone_primary: '',
                phone_secondary: '',
                email: '',
                facebook: '',
                working_hours: [],
                credentials: []
            },

            blockLoaded: false,
            block_id: null,
            block_tmp_id: null,
            local_data: null,

            titleClassFocus: false,
            addressClassFocus: false,
            addressUrlClassFocus: false,
            phonePrimaryClassFocus: false,
            phoneSecondaryClassFocus: false,
            emailClassFocus: false,
            facebookClassFocus: false,

            trans: {
                icon_image: 'Icon image',
                icon_image_description: 'Minimum image size 30x30px, please use 1:1 aspect ratio otherwise image will be cropped',
                title: 'Title',
                address: 'Address',
                address_url: 'Address url',
                phone_primary: 'Phone',
                phone_secondary: 'Phone',
                email: 'E-Mail',
                facebook: 'Facebook',
                working_hours: 'Working Hours',
                add_working_hours: 'Add Working Hours Item',
                new_working_hours: 'New Working Hours Item',
                working_hours_name: 'Name',
                working_hours_value: 'Value',
                credentials: 'Credentials',
                add_credentials: 'Add Credentials item',
                new_credentials: 'New Credentials item',
                credentials_name: 'Name',
                credentials_value: 'Value',
                save: 'Save',
            }
        }
    },
    components: {
        draggable,
        Editor,
    },
    watch: {
        // local_data: {
        //     handler(oldData, newData) {
        //         if (newData) {
        //             this.$emit('blockUpdated', this.block.id, this.block.tmp_id, this.local_data, null);
        //         }
        //     },
        //     deep: true,
        //     immediate: true,
        // },
    },
    methods: {
        getSetting() {
            this.$store.dispatch('getSettings')
                .then((data) => {
                    this.maintenance = data.settings.maintenance;
                    this.store_information = data.settings.store_information;
                    this.pageLoaded = true;
                });
        },
        toggleMaintenanceBlock() {
            this.maintenanceBlockOpen = !this.maintenanceBlockOpen;
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
        toggleStoreInformationBlock() {
            this.storeInformationBlockOpen = !this.storeInformationBlockOpen;
        },
        toggleWorkingHoursBlock() {
            this.workingHoursBlockOpen = !this.workingHoursBlockOpen;
        },
        addWorkingHoursItem() {
            this.store_information.working_hours.push({
                id: new Date().getUTCMilliseconds(),
                name: '',
                value: '',
            })
        },
        toggleCredentialsBlock() {
            this.credentialsBlockOpen = !this.credentialsBlockOpen;
        },
        addCredentialsItem() {
            this.store_information.credentials.push({
                id: new Date().getUTCMilliseconds(),
                name: '',
                value: '',
            })
        },
        openItem(block) {
            block.active = true;
        },
        closeItem(block) {
            block.active = false;
        },
        openDeleteConfirmPopup(action, type, id, name, item_id) {
            this.$emit('openDeleteConfirmPopup', action, type, id, name, item_id);
        },
        triggerIconImageUpload(id) {
            document.getElementById(id).click();
        },
        iconImageUpload(event, element) {
            let reader = new FileReader()
            reader.readAsDataURL(event.target.files[0])
            reader.onload = () => {
                element.icon_image = reader.result;
            };
        },
        titleFocus() {
            this.titleClassFocus = 'focus';
        },
        titleBlur() {
            this.titleClassFocus = false;
        },
        addressFocus() {
            this.addressClassFocus = 'focus';
        },
        addressBlur() {
            this.addressClassFocus = false;
        },
        addressUrlFocus() {
            this.addressUrlClassFocus = 'focus';
        },
        addressUrlBlur() {
            this.addressUrlClassFocus = false;
        },
        phonePrimaryFocus() {
            this.phonePrimaryClassFocus = 'focus';
        },
        phonePrimaryBlur() {
            this.phonePrimaryClassFocus = false;
        },
        phoneSecondaryFocus() {
            this.phoneSecondaryClassFocus = 'focus';
        },
        phoneSecondaryBlur() {
            this.phoneSecondaryClassFocus = false;
        },
        emailFocus() {
            this.emailClassFocus = 'focus';
        },
        emailBlur() {
            this.emailClassFocus = false;
        },
        facebookFocus() {
            this.facebookClassFocus = 'focus';
        },
        facebookBlur() {
            this.facebookClassFocus = false;
        },
        saveStoreInformation() {
            let payload = {
                store_information: this.store_information
            };


            this.$store.dispatch('saveStoreInformation', payload)
                .then(() => {});
        }
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
.content {
    font-family: var(--font-family);
    font-weight: normal;
    background: var(--background-color);
    color: var(--text-color);
    padding: 1rem;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;

    .card {
        background: rgba(var(--accent-color));
        padding: 2rem 1rem;
        border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
        border-radius: 8px;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px -1px #32475c0f, 0 4px 5px #32475c0a, 0 1px 10px #32475c0a;

        &.with-header {
            padding: 0;

            .header {
                display: flex;
                align-items: center;
                padding: 0.5rem 1rem;

                img {
                    height: 20px;
                    margin-right: 10px;
                }

                .title {
                    font-weight: 700;
                    color: rgba(var(--title-color));
                    flex-grow: 1;
                }

                .controls {
                    display: flex;

                    .button {
                        width: 24px;
                        height: 24px;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        border-radius: 50%;
                        cursor: pointer;

                        i {
                            color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                            font-size: 24px;
                        }

                        &:hover {
                            background: rgba(var(--icon-hover-background-color));
                        }
                    }
                }
            }

            .content {
                display: flex;
                flex-direction: column;
                padding: 0.5rem 1rem;
                margin: 0;
            }

            &.open {
                .header {
                    border-bottom: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                }
            }
        }

        &.ghost {
            background: rgba(var(--primary-color), var(--opacity-point-three));
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
            flex-direction: column;
            z-index: 1;
            flex-grow: 1;

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
                top: 20px;
                transform-origin: left center;
                transition: .15s cubic-bezier(.4, 0, .2, 1);
                transition-property: all;
                transition-property: opacity, transform;
                color: rgba(var(--secondary-color), var(--opacity-point-three));
            }

            .label-floating {
                visibility: hidden;
                transform: translateY(-50%);
                margin: 0 4px;
                font-size: 0.75em;
                left: 10px;
                position: absolute;
                z-index: 999;
                padding: 0 10px;
                font-weight: 600;
                background: rgba(var(--accent-color));
                color: rgba(var(--secondary-color), var(--opacity-point-three));
            }

            .label-more {
                height: 75px;
            }

            input {
                flex: 1;
                transition: .15s opacity cubic-bezier(.4, 0, .2, 1);
                min-width: 0;
                display: flex;
                flex-wrap: wrap;
                letter-spacing: .009375em;
                min-height: 40px;
                max-height: 40px;
                padding: 6px 16px;
                width: 100%;
                border-radius: 6px;
                border: 1px solid rgba(var(--secondary-color), var(--opacity-point-three));
                font-size: 16px;
                background: rgba(var(--accent-color));
                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                &:focus-visible {
                    outline: unset;
                }
            }

            textarea {
                flex: 1;
                transition: .15s opacity cubic-bezier(.4, 0, .2, 1);
                min-width: 0;
                display: flex;
                flex-wrap: wrap;
                letter-spacing: .009375em;
                max-height: 40px;
                padding: 16px 16px 6px 16px;
                width: 100% !important;
                min-height: 200px;
                border-radius: 6px;
                border: 1px solid rgba(var(--secondary-color), var(--opacity-point-three));
                font-size: 16px;
                background: rgba(var(--accent-color));
                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                &:focus-visible {
                    outline: unset;
                }
            }

            &.image {
                input {
                    display: none;
                }
            }

            .image-placeholder {
                flex: 1;
                transition: .15s opacity cubic-bezier(.4, 0, .2, 1);
                min-width: 0;
                display: flex;
                flex-wrap: wrap;
                letter-spacing: .009375em;
                padding: 16px;
                width: 100% !important;
                min-height: 200px;
                border-radius: 6px;
                border: 1px solid rgba(var(--secondary-color), var(--opacity-point-three));
                font-size: 16px;
                background: rgba(var(--accent-color));
                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                position: relative;
                cursor: pointer;

                .label {
                    top: -10px;
                    left: 10px;
                    position: absolute;
                    font-size: 0.75em;
                    z-index: 1;
                    background: rgba(var(--accent-color));
                    color: rgba(var(--secondary-color), var(--opacity-point-three));
                    padding: 0 10px;
                    margin: 0 4px;
                    font-weight: 600;
                }

                .image {
                    width: 100%;
                    padding-top: 8px;

                    .placeholder {
                        width: 100%;
                        height: 200px;
                        background: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                    }

                    img {
                        width: 100%;
                        height: auto;
                        position: static;
                    }
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

                textarea {
                    border-color: rgba(var(--primary-color));
                }

                .image-placeholder {
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
                    padding-left: 15px;
                }

                textarea {
                    border: 2px solid rgba(var(--primary-color));
                    padding-left: 15px;
                }

                .image-placeholder {
                    border: 2px solid rgba(var(--primary-color));
                    padding-left: 15px;
                }
            }

            img {
                cursor: pointer;
                width: 24px;
                position: absolute;
                top: 28px;
                right: 16px;
            }

            button {
                position: absolute;
                right: 13px;
                top: 25px;
                width: 30px;
                height: 30px;
                background: rgba(var(--primary-color));
                border: rgba(var(--primary-color));
                border-radius: 4px;
                cursor: pointer;

                &:hover {
                    opacity: var(--opacity-point-eight-seven);
                }

                svg {
                    color: rgba(var(--white-color));
                    fill: rgba(var(--white-color));
                }
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

        .label {
            color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
        }

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

    .row {
        display: flex;

        .full {
            width: 100%;
        }

        .half {
            width: 50%;

            &:first-of-type {
                padding-right: 10px;
            }

            &:nth-of-type(2) {
                padding-left: 10px;
            }
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
            flex-direction: column;
            z-index: 1;
            flex-grow: 1;

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
                top: 20px;
                transform-origin: left center;
                transition: .15s cubic-bezier(.4, 0, .2, 1);
                transition-property: all;
                transition-property: opacity, transform;
                color: rgba(var(--secondary-color), var(--opacity-point-three));
            }

            .label-floating {
                visibility: hidden;
                transform: translateY(-50%);
                margin: 0 4px;
                font-size: 0.75em;
                left: 10px;
                position: absolute;
                z-index: 999;
                padding: 0 10px;
                font-weight: 600;
                background: rgba(var(--accent-color));
                color: rgba(var(--secondary-color), var(--opacity-point-three));
            }

            .label-more {
                height: 75px;
            }

            input {
                flex: 1;
                transition: .15s opacity cubic-bezier(.4, 0, .2, 1);
                min-width: 0;
                display: flex;
                flex-wrap: wrap;
                letter-spacing: .009375em;
                min-height: 40px;
                max-height: 40px;
                padding: 6px 16px;
                width: 100%;
                border-radius: 6px;
                border: 1px solid rgba(var(--secondary-color), var(--opacity-point-three));
                font-size: 16px;
                background: rgba(var(--accent-color));
                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                &:focus-visible {
                    outline: unset;
                }
            }

            textarea {
                flex: 1;
                transition: .15s opacity cubic-bezier(.4, 0, .2, 1);
                min-width: 0;
                display: flex;
                flex-wrap: wrap;
                letter-spacing: .009375em;
                max-height: 40px;
                padding: 16px 16px 6px 16px;
                width: 100% !important;
                min-height: 200px;
                border-radius: 6px;
                border: 1px solid rgba(var(--secondary-color), var(--opacity-point-three));
                font-size: 16px;
                background: rgba(var(--accent-color));
                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                &:focus-visible {
                    outline: unset;
                }
            }

            &.image {
                input {
                    display: none;
                }
            }

            .image-placeholder {
                flex: 1;
                transition: .15s opacity cubic-bezier(.4, 0, .2, 1);
                min-width: 0;
                display: flex;
                flex-wrap: wrap;
                letter-spacing: .009375em;
                padding: 16px;
                width: 100% !important;
                min-height: 200px;
                border-radius: 6px;
                border: 1px solid rgba(var(--secondary-color), var(--opacity-point-three));
                font-size: 16px;
                background: rgba(var(--accent-color));
                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                position: relative;
                cursor: pointer;

                .label {
                    top: -10px;
                    left: 10px;
                    position: absolute;
                    font-size: 0.75em;
                    z-index: 1;
                    background: rgba(var(--accent-color));
                    color: rgba(var(--secondary-color), var(--opacity-point-three));
                    padding: 0 10px;
                    margin: 0 4px;
                    font-weight: 600;
                }

                .image {
                    width: 100%;
                    padding-top: 8px;

                    .placeholder {
                        width: 100%;
                        height: 200px;
                        background: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                    }

                    img {
                        width: 100%;
                        height: auto;
                        position: static;
                    }
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

                textarea {
                    border-color: rgba(var(--primary-color));
                }

                .image-placeholder {
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
                    padding-left: 15px;
                }

                textarea {
                    border: 2px solid rgba(var(--primary-color));
                    padding-left: 15px;
                }

                .image-placeholder {
                    border: 2px solid rgba(var(--primary-color));
                    padding-left: 15px;
                }
            }

            img {
                cursor: pointer;
                width: 24px;
                position: absolute;
                top: 28px;
                right: 16px;
            }

            button {
                position: absolute;
                right: 13px;
                top: 25px;
                width: 30px;
                height: 30px;
                background: rgba(var(--primary-color));
                border: rgba(var(--primary-color));
                border-radius: 4px;
                cursor: pointer;

                &:hover {
                    opacity: var(--opacity-point-eight-seven);
                }

                svg {
                    color: rgba(var(--white-color));
                    fill: rgba(var(--white-color));
                }
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
    }

    .items-title {
        font-weight: 700;
        color: rgba(var(--title-color));
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
        margin-bottom: 5px;
    }

    button {
        width: 100%;
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
    }

    .mb-1 {
        margin-bottom: 1rem;
    }
}
</style>
