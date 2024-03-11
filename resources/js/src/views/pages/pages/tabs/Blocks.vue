<!-- =========================================================================================
  File Name: Page.vue
  Description: Page
========================================================================================== -->
<template>
    <div class="buttons">
        <div class="add-new-sidebar-block" ref="sidebarBlocksDropdown" v-if="$route.params.type === 'page'">
            <button class="primary mb-1" @click="toggleSidebarBlocksDropdown">Add Sidebar Block</button>
            <div class="blocks-dropdown" v-if="sidebarBlocksDropdown">
                <div class="block" @click="addSidebarBlock(block)" v-for="block in sidebarBlocks">
                    <div class="icon">
                        <i :class="['bx', 'bx-' + block.icon]"></i>
                    </div>
                    <div class="text">{{ block.name }}</div>
                </div>
            </div>
        </div>

        <div class="add-new-block" ref="blocksDropdown">
            <button class="primary mb-1" @click="toggleBlocksDropdown">Add Block</button>
            <div class="blocks-dropdown" v-if="blocksDropdown">
                <div class="block" @click="addBlock(block)" v-for="block in blocks">
                    <div class="icon">
                        <i :class="['bx', 'bx-' + block.icon]"></i>
                    </div>
                    <div class="text">{{ block.name }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="all-block">
        <div class="sidebar-blocks" v-if="localPageSidebarBlocks.length > 0">
            <draggable
                v-model="localPageSidebarBlocks"
                @end="pageSidebarBlockOrderChanged"
                ghost-class="ghost"
                item-key="id">
                <template #item="{element}">
                    <div :class="['card', 'with-header', element.active ? 'open' : '']">
                        <div class="header">
                            <div class="title">{{ element.name }}</div>
                            <div class="controls">
                                <div class="button" @click="closeSidebarBlock(element)" v-if="element.active">
                                    <i class='bx bx-chevron-up'></i>
                                </div>
                                <div class="button" @click="openSidebarBlock(element)" v-if="!element.active">
                                    <i class='bx bx-chevron-down'></i>
                                </div>
                                <div class="button" @click="openDeleteConfirmPopup('removeLanguagePageSidebarBlock', 'block', element.id ? element.id : element.tmp_id, element.name)">
                                    <i class='bx bx-x'></i>
                                </div>
                            </div>
                        </div>
                        <div class="content" v-if="element.active">
                            <SidebarBlockNavigation v-if="element.key === 'block-navigation'" :block="element" :pagesOptions="pagesOptions" @sidebarBlockUpdated="sidebarBlockUpdated" @openDeleteConfirmPopup="openDeleteConfirmPopup" :removeLanguagePageBlockOrItem="removeLanguagePageBlockOrItem"/>
                            <SidebarBlockIconText v-if="element.key === 'block-icon-text'" :block="element" @sidebarBlockUpdated="sidebarBlockUpdated" @openDeleteConfirmPopup="openDeleteConfirmPopup" :removeLanguagePageBlockOrItem="removeLanguagePageBlockOrItem"/>
                        </div>
                    </div>
                </template>
            </draggable>
        </div>
        <div class="content-blocks" v-if="localPageBlocks.length > 0">
            <draggable
                v-model="localPageBlocks"
                @end="pageBlockOrderChanged"
                ghost-class="ghost"
                item-key="id">
                <template #item="{element}">
                    <div :class="['card', 'with-header', element.active ? 'open' : '']">
                        <div class="header">
                            <div class="title">{{ element.name }}</div>
                            <div class="controls">
                                <div class="button" @click="closeBlock(element)" v-if="element.active">
                                    <i class='bx bx-chevron-up'></i>
                                </div>
                                <div class="button" @click="openBlock(element)" v-if="!element.active">
                                    <i class='bx bx-chevron-down'></i>
                                </div>
                                <div class="button" @click="openDeleteConfirmPopup('removeLanguagePageBlock', 'block', element.id ? element.id : element.tmp_id, element.name)">
                                    <i class='bx bx-x'></i>
                                </div>
                            </div>
                        </div>
                        <div class="content" v-if="element.active">
                            <BlockHeroSearch v-if="element.key === 'block-hero-search'" :block="element" @blockUpdated="blockUpdated" :vehicleBrands="vehicleBrands"/>
                            <BlockIconText v-if="element.key === 'block-icon-text'" :block="element" @blockUpdated="blockUpdated" @openDeleteConfirmPopup="openDeleteConfirmPopup" :removeLanguagePageBlockOrItem="removeLanguagePageBlockOrItem"/>
                            <BlockTable v-if="element.key === 'block-table'" :block="element" @blockUpdated="blockUpdated" @openDeleteConfirmPopup="openDeleteConfirmPopup" :removeLanguagePageBlockOrItem="removeLanguagePageBlockOrItem"/>
                            <BlockPopularCategories v-if="element.key === 'block-popular-categories'" :block="element" @blockUpdated="blockUpdated" :productCategories="productCategories"/>
                            <BlockTwoBanner v-if="element.key === 'block-two-banner'" :block="element" @blockUpdated="blockUpdated"/>
                            <BlockPopularProducts v-if="element.key === 'block-popular-products'" :block="element" @blockUpdated="blockUpdated"/>
                            <BlockRecentPosts v-if="element.key === 'block-recent-posts'" :block="element" @blockUpdated="blockUpdated"/>
                            <BlockTextImage v-if="element.key === 'block-text-image'" :block="element" @blockUpdated="blockUpdated"/>
                            <BlockTextComplex v-if="element.key === 'block-text-complex'" :block="element" @blockUpdated="blockUpdated" @openDeleteConfirmPopup="openDeleteConfirmPopup" :removeLanguagePageBlockOrItem="removeLanguagePageBlockOrItem"/>
                            <BlockTextSimple v-if="element.key === 'block-text-simple'" :block="element" @blockUpdated="blockUpdated" @openDeleteConfirmPopup="openDeleteConfirmPopup" :removeLanguagePageBlockOrItem="removeLanguagePageBlockOrItem"/>
                            <BlockDownload v-if="element.key === 'block-download'" :block="element" @blockUpdated="blockUpdated"/>
                            <BlockList v-if="element.key === 'block-list'" :block="element" @blockUpdated="blockUpdated" @openDeleteConfirmPopup="openDeleteConfirmPopup" :removeLanguagePageBlockOrItem="removeLanguagePageBlockOrItem"/>
                            <BlockFullWidthTextBackgroundImage v-if="element.key === 'block-full-width-text-background-image'" :block="element" @blockUpdated="blockUpdated"/>
                            <BlockContactDetails v-if="element.key === 'block-contact-details'" :block="element" @blockUpdated="blockUpdated"/>
                            <BlockContactForm v-if="element.key === 'block-contact-form'" :block="element" @blockUpdated="blockUpdated"/>
                            <BlockProductCategories v-if="element.key === 'block-product-categories'" :block="element" @blockUpdated="blockUpdated" @openDeleteConfirmPopup="openDeleteConfirmPopup"/>
                        </div>
                    </div>
                </template>
            </draggable>
        </div>
    </div>


</template>

<script>
import draggable from 'vuedraggable'

import SidebarBlockNavigation from '../../../components/sidebarBlocks/BlockNavigation.vue'
import SidebarBlockIconText from '../../../components/sidebarBlocks/BlockIconText.vue'

import BlockHeroSearch from '../../../components/blocks/BlockHeroSearch.vue'
import BlockIconText from '../../../components/blocks/BlockIconText.vue'
import BlockTable from '../../../components/blocks/BlockTable.vue'
import BlockPopularCategories from '../../../components/blocks/BlockPopularCategories.vue'
import BlockTwoBanner from '../../../components/blocks/BlockTwoBanner.vue'
import BlockPopularProducts from '../../../components/blocks/BlockPopularProducts.vue'
import BlockRecentPosts from '../../../components/blocks/BlockRecentPosts.vue'
import BlockTextImage from '../../../components/blocks/BlockTextImage.vue'
import BlockTextComplex from '../../../components/blocks/BlockTextComplex.vue'
import BlockTextSimple from '../../../components/blocks/BlockTextSimple.vue'
import BlockDownload from '../../../components/blocks/BlockDownload.vue'
import BlockList from '../../../components/blocks/BlockList.vue'
import BlockFullWidthTextBackgroundImage from '../../../components/blocks/BlockFullWidthTextBackgroundImage.vue'
import BlockContactDetails from '../../../components/blocks/BlockContactDetails.vue'
import BlockContactForm from '../../../components/blocks/BlockContactForm.vue'
import BlockProductCategories from '../../../components/blocks/BlockProductCategories.vue'

export default {
    props: {
        pageBlocks: {
            type: Array
        },
        pageSidebarBlocks: {
            type: Array
        },
        removeLanguagePageBlockOrItem: {
            type: Object
        },
        vehicleBrands: {
            type: Array
        },
        productCategories: {
            type: Array
        },
        pagesOptions: {
            type: Array
        },
    },
    emits: ["openDeleteConfirmPopup", "pageBlockOrderChanged", "pageSidebarBlockOrderChanged"],
    data() {
        return {
            localPageBlocks: [],
            blocksDropdown: false,
            blocks: [
                {
                    name: 'Hero search block',
                    key: 'block-hero-search',
                    icon: 'search',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Icon text block',
                    key: 'block-icon-text',
                    icon: 'diamond',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Icon table block',
                    key: 'block-table',
                    icon: 'table',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Popular categories block',
                    key: 'block-popular-categories',
                    icon: 'package',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Two banner block',
                    key: 'block-two-banner',
                    icon: 'images',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Popular products block',
                    key: 'block-popular-products',
                    icon: 'grid',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Recent posts block',
                    key: 'block-recent-posts',
                    icon: 'news',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Text image block',
                    key: 'block-text-image',
                    icon: 'image-add',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Text complex block',
                    key: 'block-text-complex',
                    icon: 'list-minus',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Text Simple block',
                    key: 'block-text-simple',
                    icon: 'list-minus',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Download block',
                    key: 'block-download',
                    icon: 'download',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'List block',
                    key: 'block-list',
                    icon: 'list-ol',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Full width text background image block',
                    key: 'block-full-width-text-background-image',
                    icon: 'image',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Contact details block',
                    key: 'block-contact-details',
                    icon: 'message-dots',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Contact form block',
                    key: 'block-contact-form',
                    icon: 'message-dots',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Product categories block',
                    key: 'block-product-categories',
                    icon: 'grid',
                    data: [],
                    collapsible: true
                },
            ],

            localPageSidebarBlocks: [],
            sidebarBlocksDropdown: false,
            sidebarBlocks: [
                {
                    name: 'Navigation block',
                    key: 'block-navigation',
                    icon: 'list-ul',
                    data: [],
                    collapsible: true
                },
                {
                    name: 'Icon text block',
                    key: 'block-icon-text',
                    icon: 'diamond',
                    data: [],
                    collapsible: true
                },
            ],
        }
    },
    watch: {
        removeLanguagePageBlockOrItem: {
            handler(data) {
                if(this.localPageBlocks) {
                    let findBlockIndex = this.localPageBlocks.findIndex(block => (block.id === data.id || block.tmp_id === data.id));

                    if(findBlockIndex >= 0) {
                        if(data.item_block_item_id){
                            let findBlockItemIndex = this.localPageBlocks[findBlockIndex].data.items.findIndex(item => item.id === data.item_id);
                            if(findBlockItemIndex >= 0) {
                                let findBlockItemBlockIndex = this.localPageBlocks[findBlockIndex].data.items[findBlockItemIndex].blocks.findIndex(item_block => item_block.id === data.item_block_id);
                                if(findBlockItemBlockIndex >= 0) {
                                    let findBlockItemBlockItemIndex = this.localPageBlocks[findBlockIndex].data.items[findBlockItemIndex].blocks[findBlockItemBlockIndex].items.findIndex(item_block_item => item_block_item.id === data.item_block_item_id);
                                    if(findBlockItemBlockItemIndex >= 0) {
                                        this.localPageBlocks[findBlockIndex].data.items[findBlockItemIndex].blocks[findBlockItemBlockIndex].items.splice(findBlockItemBlockItemIndex, 1);
                                    }
                                }
                            }
                        } else if(data.item_block_id){
                            let findBlockItemIndex = this.localPageBlocks[findBlockIndex].data.items.findIndex(item => item.id === data.item_id);
                            if(findBlockItemIndex >= 0) {
                                let findBlockItemBlockIndex = this.localPageBlocks[findBlockIndex].data.items[findBlockItemIndex].blocks.findIndex(item_block => item_block.id === data.item_block_id);
                                if(findBlockItemBlockIndex >= 0) {
                                    this.localPageBlocks[findBlockIndex].data.items[findBlockItemIndex].blocks.splice(findBlockItemBlockIndex, 1);
                                }
                            }
                        } else if (data.item_id) {
                            let findBlockItemIndex = this.localPageBlocks[findBlockIndex].data.items.findIndex(item => item.id === data.item_id);
                            if(findBlockItemIndex >= 0) {
                                this.localPageBlocks[findBlockIndex].data.items.splice(findBlockItemIndex, 1);
                            }
                        } else {
                            this.localPageBlocks.splice(findBlockIndex, 1);
                        }
                    }
                }

                if(this.localPageSidebarBlocks){
                    let findSidebarBlockIndex = this.localPageSidebarBlocks.findIndex(block => (block.id === data.id || block.tmp_id === data.id));

                    if(findSidebarBlockIndex >= 0) {
                        if (data.item_id) {
                            let findBlockItemIndex = this.localPageSidebarBlocks[findSidebarBlockIndex].data.items.findIndex(item => item.id === data.item_id);
                            this.localPageSidebarBlocks[findSidebarBlockIndex].data.items.splice(findBlockItemIndex, 1);
                        } else {
                            this.localPageSidebarBlocks.splice(findSidebarBlockIndex, 1);
                        }
                    }
                }
            },
            deep: true,
            immediate: true,
        },
    },
    components: {
        draggable,

        SidebarBlockIconText,
        SidebarBlockNavigation,

        BlockHeroSearch,
        BlockIconText,
        BlockTable,
        BlockPopularCategories,
        BlockTwoBanner,
        BlockPopularProducts,
        BlockRecentPosts,
        BlockTextImage,
        BlockTextComplex,
        BlockTextSimple,
        BlockDownload,
        BlockList,
        BlockFullWidthTextBackgroundImage,
        BlockContactDetails,
        BlockContactForm,
        BlockProductCategories
    },
    methods: {
        toggleBlocksDropdown() {
            this.sidebarBlocksDropdown = false;
            this.blocksDropdown = !this.blocksDropdown;
        },
        addBlock(block) {
            let local_block = {
                tmp_id: 'tmp-' + new Date().getUTCMilliseconds(),
                name: block.name,
                key: block.key,
                icon: block.icon,
                data: block.data,
                collapsible: block.collapsible,
                active: true,
            }

            this.localPageBlocks.push(local_block);
            this.toggleBlocksDropdown();
        },
        openBlock(block) {
            block.active = true;
        },
        closeBlock(block) {
            block.active = false;
        },
        pageBlockOrderChanged() {
            this.$emit('pageBlockOrderChanged', this.localPageBlocks);
        },
        blockUpdated(id, tmp_id, data) {
            let block_index = null;
            if (id) {
                block_index = this.localPageBlocks.findIndex(block => block.id === id);
            } else {
                block_index = this.localPageBlocks.findIndex(block => block.tmp_id === tmp_id);
            }

            if(block_index >= 0){
                this.localPageBlocks[block_index].data = data;
                this.pageBlocks[block_index].data = this.localPageBlocks[block_index].data;
            }
        },
        toggleSidebarBlocksDropdown() {
            this.blocksDropdown = false;
            this.sidebarBlocksDropdown = !this.sidebarBlocksDropdown;
        },
        addSidebarBlock(block) {
            let local_sidebar_block = {
                tmp_id: 'tmp-' + new Date().getUTCMilliseconds(),
                name: block.name,
                key: block.key,
                icon: block.icon,
                data: block.data,
                collapsible: block.collapsible,
                active: true,
            }

            this.localPageSidebarBlocks.push(local_sidebar_block);
            this.toggleSidebarBlocksDropdown();
        },
        openSidebarBlock(block) {
            block.active = true;
        },
        closeSidebarBlock(block) {
            block.active = false;
        },
        pageSidebarBlockOrderChanged() {
            this.$emit('pageSidebarBlockOrderChanged', this.localPageSidebarBlocks);
        },
        sidebarBlockUpdated(id, tmp_id, data) {
            let block_index = null;
            if (id) {
                block_index = this.localPageSidebarBlocks.findIndex(block => block.id === id);
            } else {
                block_index = this.localPageSidebarBlocks.findIndex(block => block.tmp_id === tmp_id);
            }

            this.localPageSidebarBlocks[block_index].data = data;
        },
        handleClickOutside(event) {
            if(this.blocksDropdown){
                const targetElement = this.$refs.blocksDropdown;
                if(targetElement){
                    if (!targetElement.contains(event.target)) {
                        this.toggleBlocksDropdown();
                    }
                }
            }

            if(this.sidebarBlocksDropdown){
                const targetElement = this.$refs.sidebarBlocksDropdown;
                if(targetElement){
                    if (!targetElement.contains(event.target)) {
                        this.toggleSidebarBlocksDropdown();
                    }
                }
            }
        },
        openDeleteConfirmPopup(action, type, id, name, item_id = null, item_block_id = null, item_block_item_id = null) {
            let data = {
                action: action,
                type: type,
                name: name,
                id: id,
                item_id: item_id,
                item_block_id: item_block_id,
                item_block_item_id: item_block_item_id
            }

            this.$emit('openDeleteConfirmPopup', data);
        },

    },
    mounted() {
        this.localPageBlocks = this.pageBlocks;
        this.localPageSidebarBlocks = this.pageSidebarBlocks;

        document.addEventListener('click', this.handleClickOutside);
    },
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
    display: flex;
    flex-direction: column;

    .all-block {
        display: flex;

        .sidebar-blocks {
            min-width: 33.33%;
            width: 33.33%;
            margin-right: 20px;
        }

        .content-blocks {
            width: 100%;
        }

        .card {
            background: rgba(var(--accent-color));
            padding: 2rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px -1px #32475c0f, 0 4px 5px #32475c0a, 0 1px 10px #32475c0a;

            &.with-header {
                padding: 0;

                .header {
                    display: flex;
                    align-items: center;
                    padding: 0.5rem 1rem;

                    .title {
                        font-weight: 700;
                        color: rgba(var(--title-color));
                        flex-grow: 1;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
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
        }
    }


    .buttons {
        display: flex;
        position: relative;
        z-index: 3;

        .add-new-sidebar-block {
            position: relative;
            height: 58px;
            width: auto;
            z-index: 4;

            .blocks-dropdown {
                position: absolute;
                top: 50px;
                width: max-content;
                max-height: 296px;
                overflow: auto;
                background: rgba(var(--accent-color));
                padding: 0.5rem;
                border-radius: 8px;
                margin-bottom: 1rem;
                box-shadow: 0 2px 4px -1px rgba(50, 71, 92, 0.0588235294), 0 4px 5px rgba(50, 71, 92, 0.0392156863), 0 1px 10px rgba(50, 71, 92, 0.0392156863);

                .block {
                    padding: 0.5rem;
                    border: 1px solid rgba(var(--primary-color), var(--opacity-point-six));
                    margin-bottom: 0.5rem;
                    cursor: pointer;
                    font-weight: 500;
                    display: flex;

                    .icon {
                        height: 22px;
                        margin-right: 10px;

                        i {
                            font-size: 22px;
                            color: rgba(var(--primary-color));
                        }
                    }

                    .text {
                        line-height: 22px;
                        color: rgba(var(--primary-color));
                    }

                    &:hover {
                        border: 1px solid rgba(var(--primary-color));
                        background: rgba(var(--primary-color));
                        color: rgba(var(--white-color));

                        .icon {
                            i {
                                color: rgba(var(--white-color));
                            }
                        }

                        .text {
                            color: rgba(var(--white-color));
                        }
                    }

                    &:last-of-type {
                        margin-bottom: 0;
                    }
                }
            }
        }

        .add-new-block {
            position: relative;
            height: 58px;
            width: auto;
            z-index: 4;

            .blocks-dropdown {
                position: absolute;
                top: 50px;
                width: max-content;
                max-height: 296px;
                overflow: auto;
                background: rgba(var(--accent-color));
                padding: 0.5rem;
                border-radius: 8px;
                margin-bottom: 1rem;
                box-shadow: 0 2px 4px -1px rgba(50, 71, 92, 0.0588235294), 0 4px 5px rgba(50, 71, 92, 0.0392156863), 0 1px 10px rgba(50, 71, 92, 0.0392156863);

                .block {
                    padding: 0.5rem;
                    border: 1px solid rgba(var(--primary-color), var(--opacity-point-six));
                    margin-bottom: 0.5rem;
                    cursor: pointer;
                    font-weight: 500;
                    display: flex;

                    .icon {
                        height: 22px;
                        margin-right: 10px;

                        i {
                            font-size: 22px;
                            color: rgba(var(--primary-color));
                        }
                    }

                    .text {
                        line-height: 22px;
                        color: rgba(var(--primary-color));
                    }

                    &:hover {
                        border: 1px solid rgba(var(--primary-color));
                        background: rgba(var(--primary-color));
                        color: rgba(var(--white-color));

                        .icon {
                            i {
                                color: rgba(var(--white-color));
                            }
                        }

                        .text {
                            color: rgba(var(--white-color));
                        }
                    }

                    &:last-of-type {
                        margin-bottom: 0;
                    }
                }
            }
        }
    }

    button {
        border-radius: 4px;
        cursor: pointer;
        line-height: 23px;
        outline: 0;
        padding: 8px;
        transition: all 0.2s ease-in-out;
        text-transform: uppercase;
        font-weight: 600;
        font-size: 16px;

        &.primary {
            background: rgba(var(--primary-button-background-color));
            border: 1px solid rgba(var(--primary-button-background-color));
            color: rgba(var(--primary-button-color));
            margin-right: 10px;

            &:hover {
                opacity: var(--opacity-point-eight-seven);
            }
        }
    }

    .mb-1 {
        margin-bottom: 1rem;
    }
}
</style>
