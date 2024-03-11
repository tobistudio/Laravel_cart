<template>
        <div class="row">
            <Card :cardTitle="trans.title">
                <template #content>
                    <transition-group>
                        <draggable
                            v-model="images"
                            v-bind="dragOptions"
                            item-key="key"
                            key="draggable"
                            @end="reorderImagesArray"
                        >
                            <template #item="{element}">
                                <div :key="element.img_order">
                                    <div :class="`${element.img_order % 4 === 0 && element.key !== 0 ? 'break' : ''}`" />

                                    <div class="image">
                                        <img
                                            v-if="element.img_path"
                                            class="image"
                                            :ref="`image-${element.img_order}`"
                                            :src="`${element.img_path}`"
                                            :alt="`image-${element.img_order}`"
                                        />

                                        <div class="number">
                                            {{ element.img_order + 1 }}
                                        </div>

                                        <div class="delete" v-if="!isLoading" @click="removeImage(element.img_order)">
                                            <i class='bx bx-x'></i>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </draggable>
                    </transition-group>

                    <input @change="uploadImage" :value="images[images.length]" type="file" accept="image/*" class="hidden" :id="`image-${images.length}`" multiple />

                    <div style="align-items: unset;">
                        <Button style="margin-bottom: 1rem;" @click="toggleImageUpload">{{ trans.add }}</Button>

                        <ProgressSpinner v-if="isLoading" style="width: 2rem; height: 2rem; margin-right: 1rem; margin-left: 1rem;" />
                    </div>
                </template>
            </Card>
        </div>
</template>

<script>
import draggable from 'vuedraggable';
import ProgressSpinner from 'primevue/progressspinner';
import Button from '@/js/src/components/Button.vue';
import Card from '@/js/src/components/Card.vue';


export default {
    name: 'ProductGallery',

    components: {
        draggable,
        ProgressSpinner,
        Card,
        Button,
    },

    data: () => {
        return {
            images: [],
            dragOptions: {
                animation: 200,
                group: 'description',
                disabled: false,
                ghostClass: 'ghost',
            },

            trans: {
                title: 'Gallery',
                add: 'Add Image',
            },

            isLoading: false,
            toggledOnce: false,
        }
    },

    methods: {
        toggleImageUpload() {
            const evt = document.createEvent('MouseEvents');
            evt.initEvent('click', true, false);
            document.querySelector(`#image-${this.images.length}`).dispatchEvent(evt);
        },
        async reorderImagesArray() {
            const images = await this.$store.dispatch('updateGalleryImages', {
                page_id: this.$route.params.page_id,
                images: this.images.map((el, index) => {
                    return {
                        id: el.id,
                        img_order: index,
                        img_path: el.img_path,
                    }
                }),
            });

            this.images = images.map(el => {
                return {
                    id: el.id,
                    img_order: el.img_order,
                    img_path: el.img_path,
                }
            });
        },
        async removeImage(index) {
            await this.$store.dispatch('deleteGalleryImage', {
                page_id: this.$route.params.page_id,
                id: this.images[index].id,
            });

            this.images.splice(index, 1);

            await this.reorderImagesArray();
        },
        async uploadImage(event) {
            const reader = new FileReader();
            const files = event.target.files;

            this.isLoading = true;

            const readFile = (index) => {
                if (index >= files.length) {
                    this.isLoading = false;
                    return false;
                }

                reader.onload = async (e) => {
                    const data = await this.$store.dispatch('addGalleryImage', {
                        page_id: this.$route.params.page_id,
                        img_order: this.images.length,
                        img: reader.result,
                    });

                    this.images.push({
                        id: data.image.id,
                        img_order: data.image.img_order,
                        img_path: data.image.img_path
                    });

                    readFile(index + 1);
                };

                reader.readAsDataURL(files[index]);
            };

            readFile(0);
        },
        async getImages() {
            const images = await this.$store.dispatch('getGalleryImages', {
                page_id: this.$route.params.page_id,
            });

            this.images = images.map(el => {
                return {
                    id: el.id,
                    img_order: el.img_order,
                    img_path: el.img_path,
                }
            });
        },
    },

    async mounted() {
        await this.getImages();
    },
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
            display: flex;
            justify-content: start;
            align-items: flex-start;
            flex-wrap: wrap;
            list-style: none;
            padding-left: 0;

            & > div {
                & > .image {
                    border: 1px solid rgba(var(--secondary-color),var(--opacity-point-three));
                    position: relative;
                    margin-right: 1rem;
                    margin-bottom: 1rem;
                }

                .image {
                    height: 150px;

                    img {
                        max-height: 100%;
                    }
                }

                .break {
                    flex-basis: 100%;
                    height: 0;
                }

                .number {
                    position: absolute;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    bottom: 0.5rem;
                    left: 1rem;
                    background: #fff;
                    border-radius: 1rem;
                    width: 1.5rem;
                    height: 1.5rem;
                    text-align: center;
                    border: 1px solid;
                }

                .delete {
                    position: absolute;
                    top: -0.5rem;
                    right: -0.5rem;
                    background: rgba(var(--white-color));
                    border-radius: 1rem;
                    width: 1.5rem;
                    height: 1.5rem;
                    line-height: 1.5rem;
                    text-align: center;
                    color: rgba(var(--red-color));
                    border: 1px solid rgba(var(--secondary-color),var(--opacity-point-three));
                    cursor: pointer;

                    &:hover {
                        border: 1px solid rgba(var(--red-color));
                        color: rgba(var(--white-color));
                        background: rgba(var(--red-color));
                    }
                }
            }
        }
    }
}
</style>
