<template>
    <div class="row">
        <Card :cardTitle="trans.title">
            <template #content>
                <transition-group>
                    <draggable
                        v-model="uploads"
                        v-bind="dragOptions"
                        item-key="key"
                        key="draggable"
                        @end="reorderUploadsArray"
                    >
                        <template #item="{element}">
                            <div class="download" :key="element.file_order">
                                <div class="title">
                                    <WDInput
                                        :title="trans.text"
                                        :value="element.value"
                                        @input="val => val.target && val.target.value ? element.value = val.target.value : {}"
                                        @change="reorderUploadsArray"
                                    />
                                </div>

                                <div class="link">
                                    <a :href="element.file_path">
                                        <i class="bx bx-file"></i>
                                        File
                                    </a>
                                </div>

                                <Button @click="removeUpload(element.file_order)">
                                    <svg
                                        class="delete"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        viewBox="0 0 24 24" height="24"
                                    >
                                        <path fill="currentColor" d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path>
                                        <path fill="currentColor" d="M9 10h2v8H9zm4 0h2v8h-2z"></path>
                                    </svg>
                                </Button>
                            </div>
                        </template>
                    </draggable>
                </transition-group>

                <input @change="uploadFile" :value="uploads[uploads.length]" type="file" accept="image/*" class="hidden" :id="`file-${uploads.length}`" multiple />

                <div>
                    <Button @click="toggleFileUpload">{{ trans.add }}</Button>

                    <ProgressSpinner v-if="isLoading" style="width: 2rem; height: 2rem; margin-right: 1rem; margin-left: 1rem;" />
                </div>
            </template>
        </Card>
    </div>
</template>

<script>
import draggable from 'vuedraggable';
import ProgressSpinner from 'primevue/progressspinner';
import Card from '@/js/src/components/Card.vue';
import Button from '@/js/src/components/Button.vue';
import WDInput from '@/js/src/views/components/WD-input.vue';


export default {
    name: 'ProductDownloads',

    components: {
        draggable,
        ProgressSpinner,
        Card,
        Button,
        WDInput,
    },

    props: [
        'selectedLanguage',
    ],

    data() {
        return {
            uploads: [],

            isLoading: false,

            trans: {
                title: 'Downloads',
                text: 'Text',
                add: 'Add',
            },

            dragOptions: {
                animation: 200,
                group: 'description',
                disabled: false,
                ghostClass: 'ghost',
            },
        }
    },

    methods: {
        toggleFileUpload() {
            const evt = document.createEvent('MouseEvents');
            evt.initEvent('click', true, false);
            document.querySelector(`#file-${this.uploads.length}`).dispatchEvent(evt);
        },
        async reorderUploadsArray() {
            const uploads = await this.$store.dispatch('updateDownloadFiles', {
                page_id: this.$route.params.page_id,
                language_id: this.selectedLanguage.id,
                files: this.uploads,
            });

            this.uploads = uploads.map((el, index) => {
                return {
                    id: el.id,
                    file_path: el.file_path,
                    file_order: index,
                    value: el.translation ? el.translation.value : '',
                }
            });
        },
        async removeUpload(index) {
            await this.$store.dispatch('deleteDownloadFile', {
                page_id: this.$route.params.page_id,
                id: this.uploads[index].id,
            });

            this.uploads.splice(index, 1);

            await this.reorderUploadsArray();
        },
        async uploadFile(event) {
            const reader = new FileReader();
            const files = event.target.files;

            this.isLoading = true;

            const readFile = (index) => {
                if (index >= files.length) {
                    this.isLoading = false;
                    return false;
                }

                reader.onload = async (e) => {
                    const data = await this.$store.dispatch('addDownloadFile', {
                        page_id: this.$route.params.page_id,
                        file_order: this.uploads.length,
                        file_name: files[index].name,
                        file: reader.result,
                    });

                    this.uploads.push({
                        id: data.file.id,
                        file_path: data.file.file_path,
                        file_order: data.file.file_order,
                        value: data.file.translation ? data.file.translation.value : '',
                    });

                    readFile(index + 1);
                };

                reader.readAsDataURL(files[index]);
            };

            readFile(0);
        },
        async getDownloadFiles() {
            const uploads = await this.$store.dispatch('getDownloadFiles', {
                page_id: this.$route.params.page_id,
                language_id: this.selectedLanguage.id,
            });

            this.uploads = uploads.map((el, index) => {
                return {
                    id: el.id,
                    file_path: el.file_path,
                    file_order: index,
                    value: el.translation ? el.translation.value : '',
                }
            });
        },
    },

    async mounted() {
        await this.getDownloadFiles();
    }
}
</script>

<style scoped lang="scss">
.hidden {
    display: none;
}

.ghost {
    opacity: 0.5;
    background: #c8ebfb;
}

.card {
    .content {
        & > div {
            & > .download {
                display: flex;
                align-items: center;

                & > .title {
                    width: 100%;
                }

                & > .link {
                    margin-left: 1.5rem;
                    margin-right: 3rem;

                    & > a {
                        display: flex;
                        align-items: center;
                        text-decoration: none;
                        color: rgba(var(--primary-button-background-color));

                        &:hover {
                            color: rgba(var(--secondary-button-color));
                        }

                        & > i {
                            margin-right: .25rem;
                        }
                    }
                }

                & > .button {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    padding: 0;
                    height: 32px;
                }
            }

            & > .button {
                margin-bottom: 1rem;
            }
        }
    }
}
</style>
