<!-- =========================================================================================
  File Name: Menu.vue
  Description: Menu
========================================================================================== -->
<template>
    <div v-if="pageLoaded" class="content">
        <div class="card">
            <div class="tabs">
                <div v-for="(translation, index) in menu.translations" :class="['tab', translation.locale === activeEditLocale ? 'active' : '']"  @click="switchEditLang(translation.locale)">
                    {{ translation.locale.toUpperCase() }}
                </div>
            </div>
            <div v-for="(translation, index) in menu.translations" :class="['tab-content', translation.locale === activeEditLocale ? 'active' : '']">
                <div :class="['input-wrapper', translation.name ? 'has-content' : '', name_validation ? 'error' : '', nameClassFocus]">
                    <div class="label">{{ trans.name }}</div>
                    <div class="label-floating">{{ trans.name }}</div>
                    <input v-model="translation.name " type="text" @focus="nameFocus" @blur="nameBlur"/>
                    <span class="error" v-if="name_validation">{{ name_validation }}</span>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="one-three">
                <div class="card with-header open">
                    <div class="header">
                        <div class="title">{{ trans.add_menu_item }}</div>
                    </div>
                    <div class="content">
                        <div :class="['items', pagesItemsOpen ? 'open' : '']">
                            <div class="header" @click="togglePagesItems">
                                {{ trans.pages }}
                                <i class='bx bx-chevron-up' v-if="pagesItemsOpen"></i>
                                <i class='bx bx-chevron-down' v-else></i>
                            </div>
                            <div class="content">
                                <div class="items">
                                    <div class="checkbox-data" v-for="page in menu.pages[activeEditLocale]" @click="selectPageItem(page)">
                                        <div :class="['checkbox', page.checked ? 'checked' : '']">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                            <input type="checkbox" v-model="page.checked">
                                        </div>
                                        <div class="label">{{ page.text }}</div>
                                    </div>
                                </div>

                                <div class="actions right">
                                    <button class="primary" @click="addToMenu('page')">{{ trans.add_to_menu }}</button>
                                </div>
                            </div>
                        </div>
                        <div :class="['items', customLinkItemsOpen ? 'open' : '']">
                            <div class="header" @click="toggleCustomLinkItems">
                                {{ trans.custom_link }}
                                <i class='bx bx-chevron-up' v-if="customLinkItemsOpen"></i>
                                <i class='bx bx-chevron-down' v-else></i>
                            </div>
                            <div class="content">
                                <div :class="['input-wrapper', custom_link_url ? 'has-content' : '', this.activeMenuItemId === null ? customLinkUrlClassFocus : '']">
                                    <div class="label">{{ trans.custom_link_url }}</div>
                                    <div class="label-floating">{{ trans.custom_link_url }}</div>
                                    <input v-model="custom_link_url" type="text" @focus="customLinkUrlFocus(null)" @blur="customLinkUrlBlur"/>
                                </div>

                                <div :class="['input-wrapper', 'last', custom_link_navigation_label ? 'has-content' : '', this.activeMenuItemId === null ? customLinkNavigationLabelClassFocus : '']">
                                    <div class="label">{{ trans.custom_link_navigation_label }}</div>
                                    <div class="label-floating">{{ trans.custom_link_navigation_label }}</div>
                                    <input v-model="custom_link_navigation_label" type="text" @focus="customLinkNavigationLabelFocus(null)" @blur="customLinkNavigationLabelBlur"/>
                                </div>

                                <div class="checkbox-data" @click="toggleCustomLinkOpenInNewTab">
                                    <div :class="['checkbox', custom_link_open_in_new_tab ? 'checked' : '']">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                        <input type="checkbox" v-model="custom_link_open_in_new_tab">
                                    </div>
                                    <div class="label">{{ trans.open_in_new_tab }}</div>
                                </div>

                                <div class="actions right">
                                    <button class="primary" @click="addToMenu('custom_link')">{{ trans.add_to_menu }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="three-one">
                <div class="card with-header open">
                    <div class="header">
                        <div class="title">{{ trans.menu_structure }}</div>
                    </div>
                    <div class="content">
                        <Draggable v-model="menu.menus[activeEditLocale]" ref="tree" :getTriggerEl="getTriggerEl">
                            <template #default="{ node, stat }">
                                <div :class="['main-data', node.active ? 'active' : '']">
                                    <span class="item-title">
                                        <span>{{ node.text }}</span>
                                    </span>
                                    <span class="item-controls">
                                        <span class="item-type">{{ trans['type_' + node.type] }}</span>
                                        <i class='bx bx-chevron-up' @click="closeMenuItem(node.id)" v-if="node.active"></i>
                                        <i class='bx bx-chevron-down' @click="openMenuItem(node.id)" v-else></i>
                                    </span>
                                </div>
                                <div class="edit-data" v-if="node.active">
                                    <div :class="['input-wrapper', node.url ? 'has-content' : '', node.id === this.activeMenuItemId ? customLinkUrlClassFocus : '']" v-if="node.type === 'custom_link'">
                                        <div class="label">{{ trans.custom_link_url }}</div>
                                        <div class="label-floating">{{ trans.custom_link_url }}</div>
                                        <input v-model="node.url" type="text" @focus="customLinkUrlFocus(node.id)" @blur="customLinkUrlBlur"/>
                                    </div>

                                    <div :class="['input-wrapper', 'last', node.text ? 'has-content' : '', node.id === this.activeMenuItemId ? customLinkNavigationLabelClassFocus : '']">
                                        <div class="label">{{ trans.custom_link_navigation_label }}</div>
                                        <div class="label-floating">{{ trans.custom_link_navigation_label }}</div>
                                        <input v-model="node.text" type="text" @focus="customLinkNavigationLabelFocus(node.id)" @blur="customLinkNavigationLabelBlur"/>
                                    </div>

                                    <div class="checkbox-data" @click="toggleOpenInNewTab(node)">
                                        <div :class="['checkbox', node.open_in_new_tab ? 'checked' : '']">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>
                                            <input type="checkbox" v-model="node.open_in_new_tab">
                                        </div>
                                        <div class="label">{{ trans.open_in_new_tab }}</div>
                                    </div>

                                    <p class="link-to-original" v-if="node.type !== 'custom_link'">
                                        {{ trans.original }}: <a :href="node.url" target="_blank">{{
                                            node.original_title }}</a>
                                    </p>

                                    <a @click="removeMenuItem(node.id, stat)" class="remove">{{ trans.remove }}</a>|
                                    <a @click="cancelMenuItem(node.id)" class="cancel">{{ trans.cancel }}</a>
                                </div>
                            </template>
                        </Draggable>

<!--                        <draggable-->
<!--                            v-model="menu.menus[activeEditLocale]"-->
<!--                            ghost-class="ghost"-->
<!--                            item-key="id">-->
<!--                            <template #item="{element}">-->
<!--                                <div>-->
<!--                                    <div :class="['main-data', element.active ? 'active' : '']">-->
<!--                                    <span class="item-title">-->
<!--                                        <span>{{ element.text }}</span>-->
<!--                                    </span>-->
<!--                                        <span class="item-controls">-->
<!--                                        <span class="item-type">{{ trans['type_' + element.type] }}</span>-->
<!--                                        <i class='bx bx-chevron-up' @click="closeMenuItem(element.id)" v-if="element.active"></i>-->
<!--                                        <i class='bx bx-chevron-down' @click="openMenuItem(element.id)" v-else></i>-->
<!--                                    </span>-->
<!--                                    </div>-->
<!--                                    <div class="edit-data" v-if="element.active">-->
<!--                                        <div :class="['input-wrapper', element.url ? 'has-content' : '', customLinkNavigationLabelClassFocus]" v-if="element.type === 'custom_link'">-->
<!--                                            <div class="label">{{ trans.custom_link_url }}</div>-->
<!--                                            <div class="label-floating">{{ trans.custom_link_url }}</div>-->
<!--                                            <input v-model="element.url" type="text" @focus="customLinkNavigationLabelFocus" @blur="customLinkNavigationLabelBlur"/>-->
<!--                                        </div>-->

<!--                                        <div :class="['input-wrapper', 'last', element.text ? 'has-content' : '', customLinkNavigationLabelClassFocus]">-->
<!--                                            <div class="label">{{ trans.custom_link_navigation_label }}</div>-->
<!--                                            <div class="label-floating">{{ trans.custom_link_navigation_label }}</div>-->
<!--                                            <input v-model="element.text" type="text" @focus="customLinkNavigationLabelFocus" @blur="customLinkNavigationLabelBlur"/>-->
<!--                                        </div>-->

<!--                                        <div class="checkbox-data">-->
<!--                                            <div :class="['checkbox', element.open_in_new_tab ? 'checked' : '']">-->
<!--                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check-active" viewBox="0 0 24 24"><g fill="none"><path fill="currentColor" d="M17.551 3h-10.8a3.6 3.6 0 00-3.6 3.6v10.8a3.6 3.6 0 003.6 3.6h10.8a3.6 3.6 0 003.6-3.6V6.6a3.6 3.6 0 00-3.6-3.6Z"></path><path fill="#fff" d="m8.636 11.567-.102-.095-.102.095-.883.817-.118.11.118.11 2.94 2.721.101.094.102-.094 6.061-5.611.12-.11-.12-.11-.883-.818-.101-.094-.102.094-5.077 4.7-1.954-1.81Z"></path></g></svg>-->
<!--                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="check" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M6.79 3.75h10.422a3.04 3.04 0 013.039 3.04v10.42a3.04 3.04 0 01-3.04 3.04H6.792a3.04 3.04 0 01-3.04-3.04V6.79a3.04 3.04 0 013.04-3.04Z"></path></svg>-->
<!--                                                <input type="checkbox" v-model="element.open_in_new_tab">-->
<!--                                            </div>-->
<!--                                            <div class="label">{{ trans.open_in_new_tab }}</div>-->
<!--                                        </div>-->

<!--                                        <p class="link-to-original" v-if="element.type !== 'custom_link'">-->
<!--                                            {{ trans.original }}: <a :href="element.url" target="_blank">{{-->
<!--                                                element.original_title }}</a>-->
<!--                                        </p>-->

<!--                                        <a @click="removeMenuItem(element.id)" class="remove">{{ trans.remove }}</a>|-->
<!--                                        <a @click="cancelMenuItem(element.id)" class="cancel">{{ trans.cancel }}</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </template>-->
<!--                        </draggable>-->

                        <div class="actions right">
                            <button class="primary mr" @click="saveMenu(true)">{{ trans.save }}</button>
                            <button class="secondary mr" @click="saveMenu(false)">{{ trans.save_close }}</button>
                            <button class="cancel" @click="backToMenus">{{ trans.cancel }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Draggable } from '@he-tree/vue'
// import draggable from 'vuedraggable'
import '@he-tree/vue/style/default.css'

export default {
    components: {
        // draggable,
        Draggable
    },
    data() {
        return {
            pageLoaded: false,

            title: 'Menu',

            menu: {},
            activeEditLocale: null,
            nameClassFocus: false,
            name_validation: null,

            pagesItemsOpen: false,

            activeMenuItemId: null,
            customLinkItemsOpen: false,
            customLinkUrlClassFocus: false,
            custom_link_url: '',
            customLinkNavigationLabelClassFocus: false,
            custom_link_navigation_label: '',
            custom_link_open_in_new_tab: false,
            newItemCount: 1,

            trans: {
                name: 'Name',
                add_menu_item: 'Add Menu item',
                pages: 'Pages',
                custom_link: 'Custom link',
                custom_link_url: 'Url',
                custom_link_navigation_label: 'Navigation label',
                open_in_new_tab: 'Open in new tab',
                add_to_menu: 'Add to menu',
                original: 'Original',
                menu_structure: 'Menu structure',
                save: 'Save',
                save_close: 'Save & close',
                remove: 'Remove',
                cancel: 'Cancel',
            }
        }
    },
    methods: {
        getMenu() {
            let id = this.$route.params.menu_id;
            this.$store.dispatch('getMenu', id)
                .then((data) => {
                    // this.menu = data.menu;
                    this.menu.translations = data.translations;
                    this.menu.pages = data.pages;
                    this.activeEditLocale = this.menu.translations[0].locale;

                    this.menu.menus = data.menus;

                    this.$store.state.active_record = {
                        id: id,
                        name: this.menu.translations[2].name,
                        deleteAction: false
                    };

                    this.pageLoaded = true;
                }).catch(res => {
                this.$router.push(res.redirect).catch(() => {});
            });
        },
        switchEditLang(locale) {
            this.activeEditLocale = locale;
        },
        nameFocus() {
            this.nameClassFocus = 'focus';
        },
        nameBlur() {
            this.nameClassFocus = false;
        },
        customLinkUrlFocus(id) {
            this.activeMenuItemId = id;
            this.customLinkUrlClassFocus = 'focus';
        },
        customLinkUrlBlur() {
            this.activeMenuItemId = null;
            this.customLinkUrlClassFocus = false;
        },
        customLinkNavigationLabelFocus(id) {
            this.activeMenuItemId = id;
            this.customLinkNavigationLabelClassFocus = 'focus';
        },
        customLinkNavigationLabelBlur() {
            this.customLinkNavigationLabelClassFocus = false;
        },
        togglePagesItems() {
            this.pagesItemsOpen = !this.pagesItemsOpen;
        },
        selectPageItem(page) {
            page.checked = !page.checked;
        },
        toggleCustomLinkItems(){
            this.customLinkItemsOpen = !this.customLinkItemsOpen;
        },
        toggleCustomLinkOpenInNewTab() {
            this.custom_link_open_in_new_tab = !this.custom_link_open_in_new_tab;
        },
        toggleOpenInNewTab(node) {
          node.open_in_new_tab = !node.open_in_new_tab;
        },
        addToMenu(type) {
            this.newItemCount++;
            if (type === 'page') {
                let pages_to_add = this.menu.pages[this.activeEditLocale].filter(page => page.checked);
                pages_to_add.map((page) => {

                    let item = {
                        id: 'page-' + this.newItemCount,
                        item_id: page.item_id,
                        old_text: page.text,
                        text: page.text,
                        original_title: page.text,
                        url: page.url,
                        old_open_in_new_tab: false,
                        open_in_new_tab: false,
                        active: false,
                        type: page.type,
                    };

                    this.$refs.tree.add(item);

                    page.checked = false;
                    this.newItemCount++;
                });
            } else if (type === 'custom_link') {
                let item = {
                    id: 'custom_link-' + this.newItemCount,
                    old_text: this.custom_link_navigation_label,
                    text: this.custom_link_navigation_label,
                    old_url: this.custom_link_url,
                    url: this.custom_link_url,
                    old_open_in_new_tab: this.custom_link_open_in_new_tab,
                    open_in_new_tab: this.custom_link_open_in_new_tab,
                    active: false,
                    type: 'custom_link',
                };

                this.$refs.tree.add(item);

                this.custom_link_url = '';
                this.custom_link_navigation_label = '';

                this.custom_link_open_in_new_tab = false;
            }
        },
        getTriggerEl(nodeVm) {
            return nodeVm.$el.querySelector('.main-data')
        },
        openMenuItem(id) {
            this.menu.menus[this.activeEditLocale].map((item) => {
                if (item.id === id) {
                    item.active = true;
                } else {
                    this.funcMenuItem(item, 'open', id);
                }
            });
        },
        closeMenuItem(id) {
            this.menu.menus[this.activeEditLocale].map((item) => {
                if (item.id === id) {
                    item.active = false;
                } else {
                    this.funcMenuItem(item, 'close', id);
                }
            });
        },
        removeMenuItem(id, stat) {
            this.menu.menus[this.activeEditLocale].map((item, index) => {
                if (item.id === id) {
                    this.$refs.tree.remove(stat);
                } else {
                    this.funcMenuItem(item, 'remove', stat);
                }
            });
        },
        cancelMenuItem(id) {
            this.menu.menus[this.activeEditLocale].map((item) => {
                if (item.id === id) {
                    if (item.type === 'custom_link') {
                        item.url = item.old_url;
                    }
                    item.open_in_new_tab = item.old_open_in_new_tab;
                    item.text = item.old_text;
                    item.active = true;
                } else {
                    this.funcMenuItem(item, 'cancel', id);
                }
            });
        },
        funcMenuItem(node, action, id) {
            if (node.children) {
                node.children.map((child, index) => {
                    if (child.id === id) {
                        if (action === 'cancel') {
                            if (child.type === 'custom_link') {
                                child.url = child.old_url;
                            }
                            child.open_in_new_tab = child.old_open_in_new_tab;
                            child.text = child.old_text;
                            child.active = true;
                        } else if (action === 'open') {
                            child.active = true;
                        } else if (action === 'close') {
                            child.active = false;
                        } else if (action === 'remove') {
                            this.$refs.tree.remove(id);
                        }
                    } else {
                        this.funcMenuItem(child, action, id);
                    }
                });
            }
        },
        saveMenu(val) {
            this.menu.translations.map((lang, index) => {
                let menu = [];

                this.menu.menus[lang.locale].map((item) => {
                    let menu_item = {
                        item_id: item.item_id ? item.item_id : null,
                        text: item.text,
                        url: item.item_id ? null : item.url,
                        open_in_new_tab: item.open_in_new_tab,
                        type: item.type
                    };

                    if(item.children && item.children.length > 0){
                        menu_item.children = this.getMenuTree(menu_item, item.children);
                        menu.push(menu_item);
                    } else {
                        menu.push(menu_item);
                    }
                });

                this.menu.translations[index].menu = menu;
            });

            const payload = {
                id: this.$route.params.menu_id,
                menus: this.menu.translations,
            };

            this.$store.dispatch('saveMenu', payload).then((data) => {
                this.$store.state.error_message = false;
                this.$store.state.success_message = data.message;
                this.$store.state.message_type = data.message_type ? data.message_type : 'system';

                if (!val) {
                    this.$router.push("/system/menus").catch(() => {
                    })
                }
            });
        },
        getMenuTree(parent, children) {
            let menu = [];
            children.map((item) => {
                let menu_item = {
                    item_id: item.item_id ? item.item_id : null,
                    text: item.text,
                    url: item.item_id ? null : item.url,
                    open_in_new_tab: item.open_in_new_tab,
                    type: item.type
                };

                if(item.children && item.children.length > 0){
                    menu_item.children = this.getMenuTree(menu_item, item.children);
                    menu.push(menu_item);
                } else {
                    menu.push(menu_item);
                }
            });

            return menu;
        },
        backToMenus() {
            this.$router.push("/system/menus").catch(() => {
            })
        },
    },
    mounted() {
        this.getMenu();
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

    .row {
        display: flex;

        .one-three {
            width: 33.33%;
            margin-right: 20px;
        }

        .three-one {
            width: 66.67%;
        }
    }

    .card {
        background: rgba(var(--accent-color));
        padding: 2rem 1rem;
        border-radius: 10px;
        margin-bottom: 1rem;

        &.with-header {
            padding: 0;

            > .header {
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

                :deep(.he-tree) {
                    width: 100%;

                    .tree-node {
                        margin-top: 10px;

                        .tree-line {
                            display: none;
                        }

                        .tree-node-inner {
                            .main-data {
                                    height: 50px;
                                    cursor: move;
                                    border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                                    position: relative;
                                    padding: 10px 0 10px 15px !important;
                                    width: 100%;
                                    line-height: 2.30769230;
                                    overflow: hidden;
                                    background: rgba(var(--accent-color));
                                    color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));


                                    .item-controls {
                                        font-size: 12px;
                                        position: absolute;
                                        right: 0;
                                        top: 0;

                                        .item-type {
                                            display: inline-block;
                                            padding: 11px 8px 12px 8px;
                                            color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                                            font-size: 12px;
                                            line-height: 1.5;
                                        }

                                        .bx {
                                            padding: 14px 8px 14px 8px;
                                            font-size: 20px;
                                            top: 0;
                                            cursor: pointer;
                                        }
                                    }

                                    .item-title {
                                        font-size: 16px;
                                        font-weight: 600;
                                        line-height: 1.8;
                                        display: block;
                                        margin-right: 13em;
                                    }

                                    &:hover {
                                        border-color: rgba(var(--primary-color));
                                    }
                                }

                            .edit-data {
                                    width: 100%;
                                    padding: 10px 0 10px 10px;
                                    position: relative;
                                    z-index: 10;
                                    border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                                    border-top: none;
                                    box-shadow: 0 1px 1px rgba(0, 0, 0, .04);
                                    color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                                    .link-to-original {
                                        display: block;
                                        margin: 15px 0 15px 0;
                                        padding: 3px 5px 5px;
                                        border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                                        font-size: 12px;
                                        font-style: italic;

                                        a {
                                            color: rgba(var(--primary-color), 1);
                                            text-decoration: unset;
                                        }
                                    }

                                    .remove {
                                        margin-right: 5px;
                                        color: rgba(var(--red-color), 1);
                                        cursor: pointer;
                                    }

                                    .cancel {
                                        margin-left: 5px;
                                        color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));
                                        cursor: pointer;
                                    }
                                }

                            .drag-placeholder {
                                background: rgba(var(--primary-color), var(--opacity-point-three));
                                border: 1px dashed rgba(var(--primary-color));
                                color: rgba(var(--primary-color));
                                height: 50px;
                            }
                        }

                        .drag-placeholder {
                            border: 1px dashed #0088F8;
                            box-sizing: border-box;
                            background: rgba(0, 136, 249, 0.09);
                            color: #0088f9;
                            text-align: center;
                            padding: 0;
                            display: flex;
                            align-items: center;
                        }
                    }
                }
            }

            &.open {
                > .header {
                    border-bottom: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                    margin-bottom: 10px;
                }

                padding-bottom: 10px;
            }
        }

        > .content {
            > .items {
                border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                padding: 0.6rem;
                border-radius: 5px;
                margin-bottom: 10px;

                .header {
                    padding: 0;
                    position: relative;
                    font-weight: 600;
                    cursor: pointer;
                    color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                    .bx {
                        position: absolute;
                        right: 0;
                        top: 2px;
                        font-size: 20px;
                    }
                }

                > .content {
                    display: none;
                    margin-top: 10px;
                    padding: 0;

                    .items {
                        padding: 6px 10px 3px 10px;
                        border: 1px solid rgba(var(--secondary-color), var(--opacity-point-one-two));
                        max-height: 220px;
                        overflow: auto;

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

                &.open {
                    .content {
                        display: block;
                    }
                }

                &:last-of-type {
                    margin-bottom: 0;
                }
            }
        }

        .tabs {
            display: flex;
            margin-bottom: 10px;

            .tab {
                border-bottom: 2px solid transparent;
                padding: 3px 6px;
                cursor: pointer;
                color: rgba(var(--secondary-color), var(--opacity-point-eight-seven));

                &.active {
                    color: rgba(var(--primary-color));
                    border-bottom: 2px solid rgba(var(--primary-color));
                }
            }
        }

        .tab-content {
            display: none;

            &.active {
                display: block;
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
            padding: 12px 0 0 0;
            flex-direction: column;
            z-index: 1;

            &.last {
                padding: 12px 0;
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
                transition: .15s cubic-bezier(.4,0,.2,1);
                transition-property: all;
                transition-property: opacity,transform;
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

            input {
                color: #000;
                flex: 1;
                transition: .15s opacity cubic-bezier(.4,0,.2,1);
                min-width: 0;
                display: flex;
                flex-wrap: wrap;
                letter-spacing: .009375em;
                min-height: 40px;
                max-height: 40px;
                padding-inline-start: 16px;
                padding-inline-end: 16px;
                padding-top: 5px;
                padding-bottom: 6px;
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
                    border-color: #f6303a;
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

        .checkbox-data {
            display: flex;
            cursor: pointer;

            .checkbox {
                position: relative;
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

        .actions {
            border: 0;
            flex-direction: row;
            padding: 0;
            align-items: center;
            align-self: center;
            display: flex;
            width: 100%;
            margin-top: 10px;

            button {
                border-radius: 4px;
                cursor: pointer;
                line-height: 20px;
                outline: 0;
                padding: 8px 20px;
                transition: all .2s ease-in-out;
                text-transform: uppercase;
                font-weight: 600;
                font-size: 14px;

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
                }

                &.secondary {
                    background: rgba(var(--white-color));
                    border: 1px solid rgba(var(--primary-button-background-color));
                    color: rgba(var(--primary-button-background-color));
                    margin-left: 10px;
                }

                &.cancel {
                    background: rgba(var(--secondary-button-background-color));
                    border: 1px solid rgba(var(--secondary-button-background-color));
                    color: rgba(var(--secondary-button-color));
                    margin-left: 10px;
                }

                &.mr {
                    margin-right: 10px;
                }
            }

            &.right {
                justify-content: end;
            }
        }
    }
}
</style>
