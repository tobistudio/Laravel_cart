<template>
    <div v-if="editor">
        <bubble-menu
            class="bubble-menu"
            :tippy-options="{ duration: 100 }"
            :editor="editor">
            <button @click="editor.chain().focus().toggleBold().run()" :class="{ 'is-active': editor.isActive('bold') }">
                Bold
            </button>
            <button @click="editor.chain().focus().toggleItalic().run()" :class="{ 'is-active': editor.isActive('italic') }">
                Italic
            </button>
            <button @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'is-active': editor.isActive('bulletList') }">
               List
            </button>
            <button @click="editor.chain().focus().setColor('#E72E2C').run()" :class="{ 'is-active': editor.isActive('textStyle', { color: '#E72E2C' })}">
                red
            </button>
            <button @click="setLink" :class="{ 'is-active': editor.isActive('link') }">
                setLink
            </button>
        </bubble-menu>
    </div>

    <div :class="['input-wrapper', editor.isFocused ? 'focus' : '', !editor.isEmpty ? 'has-content' : '']" v-if="editor">
        <div class="label">{{ title }}</div>
        <div class="label-floating">{{ title }}</div>

        <div class="code">
            {{ editor.getHTML() }}
        </div>
        <editor-content :editor="editor"/>
    </div>

</template>

<script>
import StarterKit from '@tiptap/starter-kit';
import Link from '@tiptap/extension-link';
import BulletList from '@tiptap/extension-bullet-list'
import ListItem from '@tiptap/extension-list-item'
import { Color } from '@tiptap/extension-color'
import TextStyle from '@tiptap/extension-text-style'

import {
    BubbleMenu,
    Editor,
    EditorContent,
    FloatingMenu
} from '@tiptap/vue-3'

export default {
    components: {
        EditorContent,
        BubbleMenu,
        FloatingMenu
    },
    props: {
        title: {
            type: String,
            required: true
        },
        modelValue: {
            type: String,
            default: '',
        },
    },
    emits: ['update:modelValue'],
    data() {
        return {
            editor: null,

            fieldClassFocus: false,
        }
    },
    watch: {
        modelValue(value) {
            // HTML
            const isSame = this.editor.getHTML() === value

            // JSON
            // const isSame = JSON.stringify(this.editor.getJSON()) === JSON.stringify(value)

            if (isSame) {
                return
            }

            this.editor.commands.setContent(value, false)
        },
    },
    methods: {
        setLink() {
            const previousUrl = this.editor.getAttributes('link').href
            const url = window.prompt('URL', previousUrl)

            // cancelled
            if (url === null) {
                return
            }

            // empty
            if (url === '') {
                this.editor
                    .chain()
                    .focus()
                    .extendMarkRange('link')
                    .unsetLink()
                    .run()

                return
            }

            // update link
            this.editor
                .chain()
                .focus()
                .extendMarkRange('link')
                .setLink({ href: url })
                .run()
        },
    },
    mounted() {
        this.editor = new Editor({
            extensions: [
                StarterKit,
                Link.configure({
                    openOnClick: false,
                }),
                BulletList,
                ListItem,
                TextStyle,
                Color,
            ],
            content: this.modelValue,
            onUpdate: () => {
                this.html = this.editor.getHTML();
                if (this.html === '<p></p>') {
                    this.html = ''
                }
                this.$emit('update:modelValue', this.html);
            },
            onFocus({ editor, event }) {
                this.fieldClassFocus = 'focus';
            },
            onBlur({ editor, event }) {
                this.fieldClassFocus = false;
            },
        })
    },
    beforeUnmount() {
        this.editor.destroy()
    },
}
</script>

<style lang="scss">
.input-wrapper {
    grid-area: field;
    position: relative;
    cursor: text;
    font-size: 16px;
    letter-spacing: .009375em;
    padding: 12px 0;
    opacity: 1;
    flex-direction: column;
    z-index: 1;
    flex-grow: 1;

    .label {
        visibility: visible;
        contain: layout paint;
        margin-left: 16px;
        margin-right: 16px;
        max-width: calc(100% - 16px - 16px);
        pointer-events: none;
        position: absolute;
        top: 26px;
        transform-origin: left center;
        transition: .15s cubic-bezier(.4, 0, .2, 1);
        transition-property: all;
        transition-property: opacity, transform;
        color: rgba(var(--secondary-color), var(--opacity-point-three));
        z-index: 1;
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
        color: rgba(var(--secondary-color), var(--opacity-point-six));
    }

    &.focus {
        .label {
            visibility: hidden;
        }

        .label-floating {
            visibility: visible;
            color: rgba(var(--primary-color));
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

    .code {
        display: none;
    }

    /* Basic editor styles */
    .tiptap {
        letter-spacing: .009375em;
        min-height: 100px;
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
        outline: unset;

        &.ProseMirror-focused {
            border: 2px solid rgba(var(--primary-color));
        }

        > * + * {
            margin-top: 0.75em;
        }

        p {
            margin: 0.5em 0;
        }

        ul,
        ol {
            padding: 0 1rem;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            line-height: 1.1;
        }

        code {
            background-color: rgba(#616161, 0.1);
            color: #616161;
        }

        pre {
            background: #0D0D0D;
            color: #FFF;
            font-family: 'JetBrainsMono', monospace;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;

            code {
                color: inherit;
                padding: 0;
                background: none;
                font-size: 0.8rem;
            }
        }

        img {
            max-width: 100%;
            height: auto;
        }

        blockquote {
            padding-left: 1rem;
            border-left: 2px solid rgba(#0D0D0D, 0.1);
        }

        hr {
            border: none;
            border-top: 2px solid rgba(#0D0D0D, 0.1);
            margin: 2rem 0;
        }
    }

    .bubble-menu {
        display: flex;
        background-color: #0D0D0D;
        padding: 0.2rem;
        border-radius: 0.5rem;

        button {
            border: none;
            background: none;
            color: #FFF;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0 0.2rem;
            opacity: 0.6;

            &:hover,
            &.is-active {
                opacity: 1;
            }
        }
    }
}
</style>
