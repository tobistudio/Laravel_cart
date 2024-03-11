<!-- =========================================================================================
  File Name: Attributes.vue
  Description: Attributes
========================================================================================== -->
<template>
    <div v-if="pageLoaded" class="content">
        <div class="card table">
            <DataTable v-model:expandedRows="expandedRows" :value="attributesList">
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
                                v-model="filterAttribute"
                                placeholder="Search..."
                                @focus="searchFocus"
                                @blur="searchBlur"
                                @input="e => filterAttributes(e)"
                                :class="searchClassFocus"
                            />

                            <Button @click="createAttribute">
                                {{ trans.addAttribute }}
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

                <Column header="Title" v-if="tableLanguageID">
                    <template #body="slotProps">
                        <div class="title">
                            {{ slotProps.data.translations.find(el => el.language_id === tableLanguageID).value }}
                        </div>
                    </template>
                </Column>

                <Column field="type" header="Type">
                    <template #body="slotProps">
                        <div class="type">
                            {{ slotProps.data.type }}
                        </div>
                    </template>
                </Column>

                <Column field="filterable" header="Filterable">
                    <template #body="slotProps">
                        <div class="filterable">
                            {{ slotProps.data.filterable === 1 ? trans.yes : trans.no }}
                        </div>
                    </template>
                </Column>

                <Column>
                    <template #body="slotProps">
                        <div class="d-flex" style="justify-content: center;">
                            <svg
                                @click="editAttribute(slotProps.data.id)"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                class="edit"
                                viewBox="0 0 24 24"
                            >
                                <path data-v-809578de="" stroke="currentColor" d="M8.707 19.707 18 10.414 13.586 6l-9.293 9.293a1.003 1.003 0 0 0-.263.464L3 21l5.242-1.03c.176-.044.337-.135.465-.263zM21 7.414a2 2 0 0 0 0-2.828L19.414 3a2 2 0 0 0-2.828 0L15 4.586 19.414 9 21 7.414z"></path>
                            </svg>

                            <svg
                                @click="deleteAttribute(slotProps.data.id)"
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

                <template #expansion="slotProps">
                    <div>
                        <ul>
                            <template v-for="attr in slotProps.data.values">
                                <template v-for="value in attr.translations.filter(el => el.language_id === tableLanguageID)">
                                    <li>
                                        {{ value.value }}
                                    </li>
                                </template>
                            </template>
                        </ul>
                    </div>
                </template>
            </DataTable>
        </div>

        <Dialog
            v-model:visible="dialogVisible"
            modal
            :header="`${attributeEdit ? 'Edit' : 'Add'} attribute`"
            :style="{ width: '50rem' }"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
        >
            <div class="d-flex dialog-row">
                <div>
                    {{ trans.selectAttributeType }}:
                </div>

                <div class="d-flex">
                    <div style="margin-right: 1rem" class="d-flex">
                        <RadioButton inputId="select" v-model="attributeType" name="attributeType" value="select" />
                        <label for="select" style="margin-left: .5rem;">Select</label>
                    </div>

                    <div class="d-flex">
                        <RadioButton inputId="multiselect" v-model="attributeType" name="attributeType" value="multiselect" />
                        <label for="multiselect" style="margin-left: .5rem;">Multiselect</label>
                    </div>
                </div>
            </div>

            <div class="d-flex dialog-row">
                <div>
                    {{ trans.isFilterable }}:
                </div>

                <div class="d-flex">
                    <Checkbox v-model="attributeFilter" name="attributeFilter" :binary="true" />
                </div>
            </div>

            <div v-if="attributeType" class="d-flex dialog-row">
                <div>
                    {{ trans.selectAttributeLanguage }}:
                </div>

                <div class="languages dialog">
                    <div class="language" v-for="language in languages" @click="attributeLanguageID = language.id">
                        <img
                            :src="language.country.flag"
                            :alt="language.name"
                            :class="`flag ${attributeLanguageID === language.id ? 'active' : ''}`"
                        />
                    </div>
                </div>
            </div>

            <div v-if="attributeLanguageID" class="d-flex dialog-row">
                <div>
                    {{ trans.title }}:
                </div>

                <div>
                    <input type="text" v-model="attribute.find(el => el.languageId === attributeLanguageID).value" />
                </div>
            </div>

            <div
                v-if="attributeLanguageID"
                v-for="(attribute, index) in attribute.find(el => el.languageId === attributeLanguageID).attributes"
                class="d-flex dialog-row"
            >
                <div>
                    {{ trans.attributeTitle }} ({{ index + 1 }}):
                </div>

                <div class="d-flex">
                    <input type="text" v-model="attribute.value" />

                    <div class="remove" @click="removeAttribute(index)">
                        <i class="bx bx-x"></i>
                    </div>
                </div>
            </div>

            <div>
                <Button @click="addAttribute">
                    {{ trans.addAttribute }}
                </Button>
            </div>

            <template #footer>
                <Button @click="saveAttribute">
                    {{ trans.save }}
                </Button>
            </template>
        </Dialog>
    </div>
</template>

<script>
import Button from '@/js/src/components/Button.vue';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import Dialog from 'primevue/dialog';
import RadioButton from 'primevue/radiobutton';
import Checkbox from 'primevue/checkbox';


export default {
    components: {
        Button,
        DataTable,
        Column,
        Dialog,
        RadioButton,
        Checkbox,
    },
    data() {
        return {
            pageLoaded: false,

            title: 'Attributes',

            attributesList: [],
            attributesListFull: [],
            languages: [],
            expandedRows: [],

            filterAttribute: '',
            searchClassFocus: false,

            dialogVisible: false,
            tableLanguageID: null,

            attributeEdit: false,
            attributeEditID: null,
            attributeType: null,
            attributeFilter: true,
            attributeLanguageID: null,
            attribute: [],

            trans: {
                addAttribute: 'Add attribute',
                notFound: 'No Attributes found.',
                save: 'save',
                selectAttributeType: 'Select attribute type',
                isFilterable: 'Enable filter for products',
                selectAttributeLanguage: 'Select attribute language',
                title: 'Title',
                attributeTitle: 'Attribute title',
                yes: 'yes',
                no: 'no'
            }
        }
    },
    methods: {
        async getLanguages() {
            const data = await this.$store.dispatch('getLanguages');

            this.languages = data.languages;
        },
        filterAttributes(e) {
            if (e.target.value.trim() !== '') {
                const filteredAttributeIDS = [];
                const filteredAttributes = [];

                for (let i=0; i<this.attributesListFull.length; i++) {
                    const attributes = Object.values(this.attributesListFull[i].attributes);

                    for (let j=0; j<attributes.length; j++) {
                        if (attributes[j].title.includes(e.target.value)) {
                            filteredAttributeIDS.push(this.attributesListFull[i].id);

                            filteredAttributeIDS.filter((item, index) => filteredAttributeIDS.indexOf(item) === index);
                        }
                    }
                }

                for (let i=0; i<filteredAttributeIDS.length; i++) {
                    if (this.attributesListFull[i] && this.attributesListFull[i].id === filteredAttributeIDS[i]) {
                        filteredAttributes.push(this.attributesListFull[i]);
                    }
                }

                this.attributesList = filteredAttributes;
            } else {
                this.attributesList = JSON.parse(JSON.stringify(this.attributesListFull));
            }
        },
        searchFocus() {
            this.searchClassFocus = 'focus';
        },
        searchBlur() {
            this.searchClassFocus = false;
        },
        createAttribute() {
            this.attributeEdit = false;
            this.dialogVisible = true;
            this.attributeEditID = null;
            this.attributeType = null;
            this.attributeFilter = true;
            this.attributeLanguageID = null;

            this.attribute = [];

            for (let i=0; i<this.languages.length; i++) {
                this.attribute.push({
                    value: '',
                    attributes: [],
                    languageId: this.languages[i].id,
                });
            }
        },
        editAttribute(id) {
            this.attributeEdit = true;
            this.dialogVisible = true;
            this.attributeEditID = id;

            const attribute = this.attributesList.find(el => el.id === id);

            this.attributeType = attribute.type;
            this.attributeFilter = Boolean(attribute.filterable);
            this.attributeLanguageID = this.languages[0].id;

            this.attribute = [];

            for (let i=0; i<attribute.translations.length; i++) {
                const attributes = [];

                for (let j=0; j<attribute.values.length; j++) {
                    attributes.push(attribute.values[j].translations.find(el => el.language_id === attribute.translations[i].language_id));
                }

                this.attribute.push({
                    attributes,
                    value: attribute.translations[i].value,
                    languageId: attribute.translations[i].language_id,
                })
            }
        },
        async saveAttribute() {
            if (!this.attributeEdit) {
                await this.$store.dispatch('addAttribute', {
                    type: this.attributeType,
                    filterable: this.attributeFilter,
                    attributes: this.attribute,
                });

                await this.getAttributes();
            } else {
                await this.$store.dispatch('updateAttribute', {
                    id: this.attributeEditID,
                    type: this.attributeType,
                    filterable: this.attributeFilter,
                    attributes: this.attribute,
                });

                await this.getAttributes();

                this.editAttribute(this.attributeEditID);
            }
        },
        async deleteAttribute(id) {
            await this.$store.dispatch('deleteAttribute', id);

            await this.getAttributes();
        },
        addAttribute() {
            for (let i=0; i<this.attribute.length; i++) {
                this.attribute[i].attributes.push({
                    value: ''
                });
            }
        },
        async removeAttribute(index) {
            if (this.attributeEdit) {
                for (let i=0; i<this.attribute.length; i++) {
                    if (this.attribute[i].attributes[index].id) {
                        await this.$store.dispatch('deleteAttributeValue', this.attribute[i].attributes[index].id);
                    }
                }
            }

            for (let i=0; i<this.attribute.length; i++) {
                this.attribute[i].attributes.splice(index, 1);
            }

            //correct order, do not change
            if (this.attributeEdit) {
                await this.getAttributes();
            }
        },
        async getAttributes() {
            const data = await this.$store.dispatch('getAttributes');

            this.attributesList = data;
            this.attributesListFull = data;
        },
    },
    async mounted() {
        await this.getLanguages();
        await this.getAttributes();

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

<style lang="scss" scoped>
.d-flex {
    display: flex;
    align-items: center;
}

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

    & > div:nth-child(2) {
        width: 50%;
    }
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
