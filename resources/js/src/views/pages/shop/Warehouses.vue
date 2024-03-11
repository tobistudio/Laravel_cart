<!-- =========================================================================================
  File Name: Warehouses.vue
  Description: Warehouses
========================================================================================== -->

<template>
    <div v-if="pageLoaded" class="content">
        <div class="card table">
            <DataTable v-model:expandedRows="expandedRows" :value="warehouseList">
                <template #header>
                    <div class="d-flex" style="justify-content: space-between;">
                        <div class="left">
                            <div class="languages dialog">
                                <div class="language" v-for="language in languages" @click="tableLanguageID = language.id">
                                    <img
                                        :src="language.country.flag"
                                        :alt="language.name"
                                        :class="`flag ${tableLanguageID === language.id ? 'active' : ''}`"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="right">
                            <input
                                v-model="filterWarehouse"
                                placeholder="Search..."
                                @focus="searchFocus"
                                @blur="searchBlur"
                                @input="e => filterWarehouses(e)"
                                :class="searchClassFocus"
                            />

                            <Button @click="createWarehouseGroup" style="margin-right: .5rem;">
                                {{ trans.addWarehouseGroup }}
                            </Button>

                            <Button @click="createWarehouse">
                                {{ trans.addWarehouse }}
                            </Button>
                        </div>
                    </div>
                </template>

                <template #empty> {{ trans.notFound }} </template>

                <Column expander style="width: 5rem" />

                <Column field="id" header="ID">
                    <template #body="slotProps">
                        <div class="id">
                            {{ slotProps.data.id }}
                        </div>
                    </template>
                </Column>

                <Column field="title" header="Title">
                    <template #body="slotProps">
                        <div class="id">
                            {{ slotProps.data.translations.find(el => el.language_id === tableLanguageID).value }}
                        </div>
                    </template>
                </Column>

                <Column>
                    <template #body="slotProps">
                        <div class="d-flex" style="justify-content: center;">
                            <svg
                                @click="editGroup(slotProps.data.id)"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                class="edit"
                                viewBox="0 0 24 24"
                            >
                                <path data-v-809578de="" stroke="currentColor" d="M8.707 19.707 18 10.414 13.586 6l-9.293 9.293a1.003 1.003 0 0 0-.263.464L3 21l5.242-1.03c.176-.044.337-.135.465-.263zM21 7.414a2 2 0 0 0 0-2.828L19.414 3a2 2 0 0 0-2.828 0L15 4.586 19.414 9 21 7.414z"></path>
                            </svg>

                            <svg
                                @click="deleteGroup(slotProps.data.id)"
                                class="delete"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 24 24" height="24"
                            >
                                <path fill="currentColor" d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path>
                                <path fill="currentColor" d="M9 10h2v8H9zm4 0h2v8h-2z"></path>
                            </svg>
                        </div>
                    </template>
                </Column>

                <template #expansion="slotPropsGroup">
                    <div class="card table">
                        <DataTable v-model:expandedRows="expandedWarehouseRows" :value="slotPropsGroup.data.warehouses">
                            <Column expander style="width: 5rem" />

                            <Column field="id" header="ID">
                                <template #body="slotProps">
                                    <div class="id">
                                        {{ slotProps.data.id }}
                                    </div>
                                </template>
                            </Column>

                            <Column field="type" header="Type">
                                <template #body="slotProps">
                                    <div class="type">
                                        {{ getWarehouseType(slotProps.data.type) }}
                                    </div>
                                </template>
                            </Column>

                            <Column field="title" header="Title">
                                <template #body="slotProps">
                                    <div class="title">
                                        {{ slotProps.data.translations.find(el => el.language_id === tableLanguageID).value }}
                                    </div>
                                </template>
                            </Column>

                            <Column field="address" header="Address">
                                <template #body="slotProps">
                                    <div class="address">
                                        {{ slotProps.data.address }}
                                    </div>
                                </template>
                            </Column>

                            <Column field="max_weight_kg" :header="trans.maxWeightKg">
                                <template #body="slotProps">
                                    <div class="address">
                                        {{ slotProps.data.max_weight_kg }}
                                    </div>
                                </template>
                            </Column>

                            <Column field="max_height_cm" :header="trans.maxHeightCm">
                                <template #body="slotProps">
                                    <div class="address">
                                        {{ slotProps.data.max_height_cm }}
                                    </div>
                                </template>
                            </Column>

                            <Column field="max_width_cm" :header="trans.maxWidthCm">
                                <template #body="slotProps">
                                    <div class="address">
                                        {{ slotProps.data.max_width_cm }}
                                    </div>
                                </template>
                            </Column>

                            <Column field="max_volume_cm" :header="trans.maxVolumeCm">
                                <template #body="slotProps">
                                    <div class="address">
                                        {{ slotProps.data.max_volume_cm }}
                                    </div>
                                </template>
                            </Column>

                            <Column field="deliver_price" :header="trans.deliverPrice">
                                <template #body="slotProps">
                                    <div class="id">
                                        {{ slotProps.data.deliver_price }}
                                    </div>
                                </template>
                            </Column>

                            <Column field="deliver_price_drops_from" :header="trans.deliverPriceDropFrom">
                                <template #body="slotProps">
                                    <div class="id">
                                        {{ slotProps.data.deliver_price_drops_from }}
                                    </div>
                                </template>
                            </Column>

                            <Column field="deliver_time_from_h" :header="trans.deliverTimeFrom">
                                <template #body="slotProps">
                                    <div class="id">
                                        {{ slotProps.data.deliver_time_from_h }}
                                    </div>
                                </template>
                            </Column>

                            <Column field="deliver_time_to_h" :header="trans.deliverTimeTo">
                                <template #body="slotProps">
                                    <div class="id">
                                        {{ slotProps.data.deliver_time_to_h }}
                                    </div>
                                </template>
                            </Column>

                            <Column>
                                <template #body="slotProps">
                                    <div class="d-flex" style="justify-content: center;">
                                        <svg
                                            @click="editWarehouse(slotPropsGroup.data.id, slotProps.data.id)"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            class="edit"
                                            viewBox="0 0 24 24"
                                        >
                                            <path data-v-809578de="" stroke="currentColor" d="M8.707 19.707 18 10.414 13.586 6l-9.293 9.293a1.003 1.003 0 0 0-.263.464L3 21l5.242-1.03c.176-.044.337-.135.465-.263zM21 7.414a2 2 0 0 0 0-2.828L19.414 3a2 2 0 0 0-2.828 0L15 4.586 19.414 9 21 7.414z"></path>
                                        </svg>

                                        <svg
                                            @click="deleteWarehouse(slotProps.data.id)"
                                            class="delete"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            viewBox="0 0 24 24" height="24"
                                        >
                                            <path fill="currentColor" d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path>
                                            <path fill="currentColor" d="M9 10h2v8H9zm4 0h2v8h-2z"></path>
                                        </svg>
                                    </div>
                                </template>
                            </Column>

                            <template #empty> {{ trans.notFound }} </template>

                            <template #expansion="slotProps">
                                <ul>
                                    <li v-for="time in slotProps.data.times">
                                        {{ getWarehouseWeekday(time.week_day) }} | {{ time.from }} - {{ time.to }}
                                    </li>
                                </ul>
                            </template>
                        </DataTable>
                    </div>
                </template>
            </DataTable>
        </div>

        <Dialog
            v-model:visible="dialogGroupVisible"
            modal
            :header="`${groupEdit ? 'Edit' : 'Add'} ${trans.warehouseGroup}`"
            :style="{ width: '50rem' }"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
        >
            <div class="d-flex dialog-row" style="border: none;">
                <div class="languages dialog">
                    <div class="language" v-for="language in languages" @click="groupLanguageID = language.id">
                        <img
                            :src="language.country.flag"
                            :alt="language.name"
                            :class="`flag ${groupLanguageID === language.id ? 'active' : ''}`"
                        />
                    </div>
                </div>
            </div>

            <div class="d-flex dialog-row" style="border: none;" v-if="groupLanguageID">
                <span style="width: 25%;">{{ trans.warehouseGroupName }}:</span>

                <InputText
                    type="text"
                    v-model="groupTitles.find(el => el.languageId === groupLanguageID).value"
                />
            </div>

            <template #footer>
                <Button @click="saveGroup">
                    {{ trans.save }}
                </Button>
            </template>
        </Dialog>

        <Dialog
            v-model:visible="dialogVisible"
            modal
            :header="`${warehouseEdit ? 'Edit' : 'Add'} ${trans.warehouse}`"
            :style="{ width: '50rem' }"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
        >
            <div class="d-flex dialog-row" style="border: none;">
                <div class="languages dialog">
                    <div class="language" v-for="language in languages" @click="changeSelectedGroupLanguage(language.id)">
                        <img
                            :src="language.country.flag"
                            :alt="language.name"
                            :class="`flag ${selectedGroupLanguageID === language.id ? 'active' : ''}`"
                        >
                    </div>
                </div>
            </div>

            <div class="d-flex dialog-row" v-if="selectedGroupLanguageID">
                <div>
                    {{ trans.selectWarehouseGroup }}:
                </div>

                <template v-if="warehouseList.length > 0">
                    <Dropdown
                        v-model="selectedGroup"
                        :options="warehouseList.map(el => el.translations.find(el => el.language_id === selectedGroupLanguageID))"
                        optionLabel="value"
                        placeholder="Select warehouse group"
                        checkmark
                        :highlightOnSelect="false"
                    />
                </template>
                <template v-else>
                    {{ trans.createWarehouseGroup }}
                </template>
            </div>

            <template v-if="selectedGroup">
                <div class="d-flex dialog-row">
                    <div>
                        {{ trans.title }}:
                    </div>

                    <div>
                        <InputText type="text" v-model="warehouse.titles.find(el => el.languageId === selectedGroupLanguageID).value" />
                    </div>
                </div>

                <div class="d-flex dialog-row">
                    <div>
                        {{ trans.address }}:
                    </div>

                    <div>
                        <InputText type="text" v-model="warehouse.address" />
                    </div>
                </div>

                <div class="d-flex dialog-row">
                    <div>
                        {{ trans.type }}:
                    </div>

                    <div>
                        <Dropdown
                            v-model="warehouse.type"
                            :options="warehouseTypes"
                            optionLabel="name"
                            placeholder="Select warehouse type"
                            checkmark
                            :highlightOnSelect="false"
                        />
                    </div>
                </div>

                <div class="d-flex dialog-row">
                    <div>
                        {{ trans.maxWeightKg }}:
                    </div>

                    <div>
                        <InputText type="number" v-model="warehouse.maxWeightKg" />
                    </div>
                </div>

                <div class="d-flex dialog-row">
                    <div>
                        {{ trans.maxHeightCm }}:
                    </div>

                    <div>
                        <InputText type="number" v-model="warehouse.maxHeightCm" />
                    </div>
                </div>

                <div class="d-flex dialog-row">
                    <div>
                        {{ trans.maxWidthCm }}:
                    </div>

                    <div>
                        <InputText type="number" v-model="warehouse.maxWidthCm" />
                    </div>
                </div>

                <div class="d-flex dialog-row">
                    <div>
                        {{ trans.maxVolumeCm }}:
                    </div>

                    <div>
                        <InputText type="number" v-model="warehouse.maxVolumeCm" />
                    </div>
                </div>

                <div class="d-flex dialog-row">
                    <div>{{ trans.deliverTimeFrom }}:</div>

                    <div>
                        <InputText type="number" v-model="warehouse.deliverTimeFrom" />
                    </div>
                </div>

                <div class="d-flex dialog-row">
                    <div>{{ trans.deliverTimeTo }}:</div>

                    <div>
                        <InputText type="number" v-model="warehouse.deliverTimeTo" />
                    </div>
                </div>

                <div class="d-flex dialog-row">
                    <div>{{ trans.deliverPrice }}:</div>

                    <div>
                        <InputText type="number" v-model="warehouse.deliverPrice" />
                    </div>
                </div>

                <div class="d-flex dialog-row">
                    <div>{{ trans.deliverPriceDropFrom }}:</div>

                    <div>
                        <InputText type="number" v-model="warehouse.deliverPriceDropFrom" />
                    </div>
                </div>

                <div class="d-flex dialog-row">
                    <div>
                        {{ trans.addWarehouseWorkingTime }}
                    </div>

                    <div>
                        <Dropdown
                            v-model="selectedWarehouseWorkingTime"
                            :options="warehouseWorkingTimes"
                            optionLabel="day"
                            placeholder="Select working day"
                            checkmark
                            :highlightOnSelect="false"
                            style="margin-right: 1rem;"
                        />

                        <Button @click="addWorkingTime">
                            {{ trans.add }}
                        </Button>
                    </div>
                </div>

                <template v-if="warehouseWorkingTime.length > 0">
                    <div v-for="(time, index) in warehouseWorkingTime" class="d-flex dialog-row">
                        <div style="width: 15%;">
                            {{ time.day }}
                        </div>

                        <div>
                            <InputText
                                type="text"
                                v-model="time.from"
                                @change="e => filterTimeValue(e, index, 'from')"
                                placeholder="from 09:00"
                            />
                        </div>

                        <div>
                            <InputText
                                type="text"
                                v-model="time.to"
                                @change="e => filterTimeValue(e, index, 'to')"
                                placeholder="to 13:00"
                            />
                        </div>

                        <div class="remove" @click="deleteWarehouseWorkingTime(index)">
                            <i class="bx bx-x"></i>
                        </div>
                    </div>
                </template>
            </template>

            <template #footer>
                <Button @click="saveWarehouse">
                    {{ trans.save }}
                </Button>
            </template>
        </Dialog>
    </div>
</template>

<script>
import Button from '@/js/src/components/Button.vue';
import Column from 'primevue/column';
import Dropdown from 'primevue/dropdown';
import DataTable from 'primevue/datatable';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';


export default {
    name: 'Warehouses',

    components: {
        Button,
        Dropdown,
        DataTable,
        Column,
        Dialog,
        InputText,
    },

    data() {
        return {
            title: 'Warehouses',
            pageLoaded: false,
            searchClassFocus: false,

            filterWarehouse: null,
            languages: [],
            warehouseList: [],
            expandedRows: [],
            expandedWarehouseRows: [],

            dialogGroupVisible: false,
            groupEdit: false,
            groupEditId: null,
            groupLanguageID: null,
            groupTitles: [],
            selectedGroup: null,
            selectedGroupLanguageID: null,

            dialogVisible: false,
            warehouseEdit: false,
            warehouseEditId: null,
            warehouseEditGroupId: null,
            selectedWarehouseWorkingTime: null,
            warehouseWorkingTime: [],
            warehouse: {
                titles: [],
                address: '',
                type: null,
                maxWeightKg: 0,
                maxHeightCm: 0,
                maxWidthCm: 0,
                maxVolumeCm: 0,
                deliverPrice: null,
                deliverPriceDropFrom: null,
                deliverTimeFrom: null,
                deliverTimeTo: null,
            },
            warehouseTypes: [
                {
                    name: 'shop',
                    value: 1,
                },
                {
                    name: 'self pickup',
                    value: 2,
                },
                {
                    name: 'deliver to',
                    value: 3,
                },
                {
                    name: 'storage',
                    value: 4,
                },
            ],
            warehouseWorkingTimes: [
                { day: 'monday' },
                { day: 'tuesday' },
                { day: 'wednesday' },
                { day: 'thursday' },
                { day: 'friday' },
                { day: 'saturday' },
                { day: 'sunday' },
            ],

            tableLanguageID: null,

            trans: {
                title: 'Title',
                address: 'Address',
                type: 'Type',
                warehouse: 'warehouse',
                createWarehouseGroup: 'First create warehouse group',
                warehouseGroupName: 'Group name',
                warehouseGroup: 'warehouse group',
                selectWarehouseGroup: 'Select warehouse group',
                addWarehouse: 'Add warehouse',
                addWarehouseGroup: 'Add group',
                notFound: 'No Warehouses found.',
                save: 'save',
                add: 'add',
                maxWeightKg: 'Max delivery package weight (kg)',
                maxHeightCm: 'Max delivery package height (cm)',
                maxWidthCm: 'Max delivery package width (cm)',
                maxVolumeCm: 'Max delivery package volume (cm)',
                addWarehouseWorkingTime: 'Add working time',
                deliverTimeFrom: 'Deliver time from (hours)',
                deliverTimeTo: 'Deliver time to (hours)',
                deliverPrice: 'Deliver price',
                deliverPriceDropFrom: 'Deliver price drops from',
            }
        }
    },

    methods: {
        searchFocus() {
            this.searchClassFocus = 'focus';
        },
        searchBlur() {
            this.searchClassFocus = false;
        },
        async getLanguages() {
            const data = await this.$store.dispatch('getLanguages');

            this.languages = data.languages;
        },
        getWarehouseType(type) {
            if (type === 1) {
                return 'Shop';
            } else if (type === 2) {
                return 'Self pickup';
            } else if (type === 3) {
                return 'Deliver to';
            } else if (type === 4) {
                return 'Storage';
            }
        },
        getWarehouseWeekday(day) {
            switch (day) {
                case 1: return 'monday';
                case 2: return 'tuesday';
                case 3: return 'wednesday';
                case 4: return 'thursday';
                case 5: return 'friday';
                case 6: return 'saturday';
                case 7: return 'sunday';
            }
        },
        filterTimeValue(e, index, dest) {
            const values = e.target.value.match(/\d{2}:?/gm);

            if (Array.isArray(values)) {
                if (values.length === 2) {
                    if (Number(values[0].substring(0, 2)) > 24) {
                        values[0] = '24:';
                    }
                    if (Number(values[1]) > 60) {
                        values[1] = 60;
                    }
                    if (values[0] === '24:' && Number(values[1]) > 0) {
                        values[1] = '00';
                    }

                    this.warehouseWorkingTime[index][dest] = values.join('');
                } else if (values.length === 1) {
                    if (Number(values[0].substring(0, 2)) > 24) {
                        values[0] = 24;
                    }

                    this.warehouseWorkingTime[index][dest] = `${values[0]}:00`;
                } else {
                    this.warehouseWorkingTime[index][dest] = '';
                }
            } else {
                this.warehouseWorkingTime[index][dest] = '';
            }
        },
        filterWarehouses() {

        },
        changeSelectedGroupLanguage(id) {
            if (this.selectedGroupLanguageID && this.selectedGroup) {
                const warehouse = this.warehouseList.find(el => el.translations.find(el => el.id === this.selectedGroup.id));

                this.selectedGroupLanguageID = id;
                this.selectedGroup = warehouse.translations.find(el => el.language_id === this.selectedGroupLanguageID);
            } else {
                this.selectedGroupLanguageID = id
            }
        },
        deleteWarehouseWorkingTime(index) {
            this.warehouseWorkingTime.splice(index, 1);
        },
        addWorkingTime() {
            if (this.selectedWarehouseWorkingTime) {
                this.warehouseWorkingTime.push({
                    day: this.selectedWarehouseWorkingTime.day,
                    from: null,
                    to: null,
                });
            }
        },
        createWarehouse() {
            this.dialogVisible = true;

            if (this.warehouseEdit) {
                this.clearWarehouse();
            }

            if (this.warehouse.titles.length < this.languages.length) {
                for (let i=0; i<this.languages.length; i++) {
                    this.warehouse.titles.push({
                        value: '',
                        languageId: this.languages[i].id,
                    });
                }
            }
        },
        clearWarehouse() {
            this.warehouseEdit = false;
            this.warehouseEditId = null;
            this.warehouseEditGroupId = null;
            this.selectedGroup = null;

            this.warehouse = {
                titles: [],
                address: '',
                type: null,
                maxWeightKg: 0,
                maxHeightCm: 0,
                maxWidthCm: 0,
                maxVolumeCm: 0,
                deliverPrice: null,
                deliverPriceDropFrom: null,
                deliverTimeFrom: null,
                deliverTimeTo: null,
            };
            this.warehouseWorkingTime = [];
            this.warehouse.titles = [];
        },
        editWarehouse(groupId, id) {
            this.dialogVisible = true;
            this.warehouseEdit = true;
            this.warehouseEditId = id;
            this.warehouseEditGroupId = groupId;
            this.selectedGroupLanguageID = this.tableLanguageID || this.languages[0].id;

            const warehouseGroup = this.warehouseList.find(el => el.id === groupId);
            const warehouse = warehouseGroup.warehouses.find(el => el.id === id);

            this.selectedGroup = warehouseGroup.translations.find(el => el.language_id === this.selectedGroupLanguageID);
            this.warehouse = {
                titles: warehouse.translations.map(el => {
                    return {
                        value: el.value,
                        languageId: el.language_id,
                    }
                }),
                address: warehouse.address,
                type: this.warehouseTypes.find(el => el.value === warehouse.type),
                maxWeightKg: warehouse.max_weight_kg,
                maxHeightCm: warehouse.max_height_cm,
                maxWidthCm: warehouse.max_width_cm,
                maxVolumeCm: warehouse.max_volume_cm,
                deliverPrice: warehouse.deliver_price,
                deliverPriceDropFrom: warehouse.deliver_price_drops_from,
                deliverTimeFrom: warehouse.deliver_time_from_h,
                deliverTimeTo: warehouse.deliver_time_to_h,
            };
            this.warehouseWorkingTime = warehouse.times.map(el => {
                return {
                    day: this.warehouseWorkingTimes[el.week_day-1].day,
                    from: el.from.slice(0, 5),
                    to: el.to.slice(0, 5),
                }
            });
        },
        async deleteWarehouse(id) {
            await this.$store.dispatch('deleteWarehouse', id);

            await this.getWarehouses();
        },
        async saveWarehouse() {
            if (this.warehouseEdit) {
                await this.$store.dispatch('updateWarehouse', {
                    id: this.warehouseEditId,
                    warehouse: this.warehouse,
                    workingTimes: this.warehouseWorkingTime,
                    warehouseGroup: this.warehouseList.find(el => el.translations.find(el => el.id === this.selectedGroup.id)),
                });

                await this.getWarehouses();
            } else {
                if (this.selectedGroup) {
                    await this.$store.dispatch('createWarehouse', {
                        warehouse: this.warehouse,
                        workingTimes: this.warehouseWorkingTime,
                        warehouseGroup: this.warehouseList.find(el => el.translations.find(el => el.id === this.selectedGroup.id)),
                    });

                    await this.getWarehouses();
                }
            }

            this.clearWarehouse();
        },

        createWarehouseGroup() {
            this.dialogGroupVisible = true;
            this.groupEdit = false;
            this.groupEditId = null;
            this.groupLanguageID = null;
            this.groupTitles = [];

            for (let i=0; i<this.languages.length; i++) {
                this.groupTitles.push({
                    value: '',
                    languageId: this.languages[i].id,
                });
            }
        },
        editGroup(id) {
            this.dialogGroupVisible = true;
            this.groupEdit = true;
            this.groupEditId = id;
            this.groupLanguageID = this.tableLanguageID || this.languages[0].id;

            const warehouse = this.warehouseList.find(el => el.id === id);

            for (let i=0; i<this.languages.length; i++) {
                this.groupTitles = warehouse.translations.map(el => {
                    return {
                        value: el.value,
                        languageId: el.language_id,
                    }
                })
            }
        },
        async deleteGroup(id) {
            await this.$store.dispatch('deleteWarehouseGroup', id);

            await this.getWarehouses();
        },
        async saveGroup() {
            if (this.groupEdit) {
                await this.$store.dispatch('updateWarehouseGroup', {
                    id: this.groupEditId,
                    warehouses: this.groupTitles,
                    group: this.group,
                });
            } else {
                await this.$store.dispatch('createWarehouseGroup', {
                    warehouses: this.groupTitles,
                    group: this.group,
                });
            }

            await this.getWarehouses();
        },

        async getWarehouses() {
            this.warehouseList = await this.$store.dispatch('getWarehouses');
        },
    },

    async mounted() {
        await this.getLanguages();
        await this.getWarehouses();

        if (this.languages[0]) {
            this.tableLanguageID = this.languages[0].id;
        }

        this.pageLoaded = true;
    },

    metaInfo() {
        return {
            title: this.title,
        }
    }
}
</script>

<style scoped lang="scss">
.dialog-row {
    padding-top: .25rem;
    padding-bottom: .25rem;
    justify-content: space-between;
    border-bottom: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
    margin-bottom: .5rem;

    .remove {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 16px;
        height: 16px;
        border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
        border-radius: 50%;
        cursor: pointer;
        color: rgba(var(--primary-color));

        &:hover {
            color: rgba(var(--secondary-color), var(--opacity-point-four));
            fill: rgba(var(--secondary-color), var(--opacity-point-four));
        }
    }

    input {
        width: 100%;
        height: 40px;
        padding: 8px 16px;
        border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
        border-radius: 6px;
        font-size: 16px;
        background: rgba(var(--accent-color));
        margin-right: 20px;
        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

        &:focus-visible {
            outline: unset;
        }

        &:focus {
            border: 2px solid rgba(var(--primary-color));
            padding-inline-start: 15px;
        }
    }
}

.d-flex {
    display: flex;
    align-items: center;
}

.languages {
    display: flex;
    justify-content: end;
    align-items: center;

    &.dialog {
        justify-content: start;

        .language {
            width: 45px;
            cursor: pointer;

            &:hover {
                opacity: var(--opacity-point-eight-seven);
            }

            .flag {
                transition: .3s;

                &.active {
                    height: 25px;
                    border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                    border-radius: 4px;
                }
            }
        }
    }

    .language {
        width: 30px;
        margin-right: 16px;

        .flag {
            height: 16px;
        }
    }
}

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
        border-radius: 10px;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px -1px #32475c0f, 0 4px 5px #32475c0a, 0 1px 10px #32475c0a;

        &.table {
            padding: 2rem 0;
        }

        :deep(.p-datatable) {
            .p-datatable-header {
                background: rgba(var(--accent-color));
                border-top: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                border-bottom: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                padding: 1rem 1rem;

                .right  {
                    display: flex;
                    justify-content: end;

                    input {
                        height: 40px;
                        padding: 8px  16px;
                        border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                        border-radius: 6px;
                        font-size: 16px;
                        background: rgba(var(--accent-color));
                        margin-right: 20px;
                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                        &:focus-visible {
                            outline: unset;
                        }

                        &.focus {
                            border: 2px solid rgba(var(--primary-color));
                            padding-inline-start: 15px;
                        }
                    }

                    a {
                        &.button {
                            border-radius: 4px;
                            cursor: pointer;
                            line-height: 20px;
                            outline: 0;
                            padding: 8px 16px;
                            transition: all .2s ease-in-out;
                            text-transform: uppercase;
                            font-weight: 400;
                            font-size: 14px;
                            max-width: 200px;
                            width: auto;
                            text-decoration: unset;

                            &:hover {
                                opacity: var(--opacity-point-eight-seven);
                            }

                            &.primary {
                                background: rgba(var(--primary-button-background-color));
                                border: 1px solid rgba(var(--primary-button-background-color));
                                color: rgba(var(--primary-button-color));
                            }
                        }
                    }
                }
            }

            .p-datatable-thead  {
                tr {
                    th {
                        font-size: 12px;
                        font-weight: 500;
                        background: rgba(var(--accent-color));
                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                        border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                        border-width: 0 0 1px 0;
                    }
                }
            }

            .p-datatable-tbody {
                tr {
                    td {
                        font-size: 12px;
                        font-weight: 500;
                        padding: 0.5rem 1rem;
                        background: rgba(var(--accent-color));
                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                        border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                        border-width: 0 0 1px 0;

                        .edit {
                            height: 18px;
                            width: 18px;
                            color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                            fill: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                            margin-right: .5rem;
                            cursor: pointer;

                            &:hover {
                                color: rgba(var(--secondary-color), var(--opacity-point-four));
                                fill: rgba(var(--secondary-color), var(--opacity-point-four));
                            }
                        }

                        .delete {
                            fill: rgba(var(--primary-button-background-color));
                            color: rgba(var(--primary-button-background-color));
                            cursor: pointer;

                            &:hover {
                                color: rgba(var(--secondary-color), var(--opacity-point-four));
                                fill: rgba(var(--secondary-color), var(--opacity-point-four));
                            }
                        }

                        .p-datatable-toggler {
                            margin-top: -4px;

                            &:focus {
                                box-shadow: unset;
                            }

                            &:focus-visible {
                                outline: unset;
                            }
                        }

                        .name {
                            display: inline-block;
                            font-size: .875rem;
                            color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                            font-weight: 500;
                            text-decoration: unset;
                            line-height: 32px;

                            .type {
                                font-weight: 700;
                                margin-left: 5px;
                            }
                        }

                        .languages {
                            display: flex;
                            justify-content: end;

                            .language {
                                margin-right: 16px;
                                display: flex;
                                align-items: center;
                                cursor: pointer;
                                width: 30px;

                                .flag {
                                    height: 14px;
                                }

                                .create {
                                    height: 18px;
                                    width: 18px;
                                    color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                                    fill: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                                    &:hover {
                                        color: rgba(var(--secondary-color), var(--opacity-point-four));
                                        fill: rgba(var(--secondary-color), var(--opacity-point-four));
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
</style>
