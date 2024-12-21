<template>
    <div
        class="flex flex-col border border-solid border-slate-500 rounded-md"
        v-if="editor"
    >
        <div class="border-b border-solid border-b-slate-500">
            <button
                title="Bold"
                type="button"
                @click="editor.chain().focus().toggleBold().run()"
                :disabled="!editor.can().chain().focus().toggleBold().run()"
                :class="{ 'is-active': editor.isActive('bold') }"
            >
                <Icon icon="octicon:bold-16" width="16" height="16" />
            </button>
            <button
                title="Italic"
                type="button"
                @click="editor.chain().focus().toggleItalic().run()"
                :disabled="!editor.can().chain().focus().toggleItalic().run()"
                :class="{ 'is-active': editor.isActive('italic') }"
            >
                <Icon icon="octicon:italic-16" width="16" height="16" />
            </button>
            <button
                title="Strike"
                type="button"
                @click="editor.chain().focus().toggleStrike().run()"
                :disabled="!editor.can().chain().focus().toggleStrike().run()"
                :class="{ 'is-active': editor.isActive('strike') }"
            >
                <Icon icon="octicon:strikethrough-16" width="16" height="16" />
            </button>
            <button
                title="Link"
                type="button"
                @click="setLink"
                :class="{ 'is-active': editor.isActive('link') }"
            >
                <Icon icon="octicon:link-16" width="16" height="16" />
            </button>
            <button
                title=""
                type="button"
                @click="editor.chain().focus().toggleBulletList().run()"
                :class="{ 'is-active': editor.isActive('bulletList') }"
            >
                <Icon icon="octicon:list-unordered-16" width="16" height="16" />
            </button>
            <button
                title="Bullet list"
                type="button"
                @click="editor.chain().focus().toggleOrderedList().run()"
                :class="{ 'is-active': editor.isActive('orderedList') }"
            >
                <Icon icon="octicon:list-ordered-16" width="16" height="16" />
            </button>
            <button
                title="Ordered list"
                type="button"
                @click="editor.chain().focus().toggleBlockquote().run()"
                :class="{ 'is-active': editor.isActive('blockquote') }"
            >
                <Icon icon="octicon:quote" width="14" height="16" />
            </button>
            <button
                title="Highlight"
                type="button"
                @click="editor.chain().focus().toggleHighlight().run()"
                :disabled="
                    !editor.can().chain().focus().toggleHighlight().run()
                "
                :class="{ 'is-active': editor.isActive('highlight') }"
            >
                <Icon icon="octicon:paintbrush-16" width="16" height="16" />
            </button>
            <button
                title="Undo"
                type="button"
                @click="editor.chain().focus().undo().run()"
                :disabled="editor.can().chain().focus().undo().run()"
            >
                <Icon icon="octicon:chevron-left-12" width="12" height="12" />
            </button>
            <button
                title="Redo"
                type="button"
                @click="editor.chain().focus().redo().run()"
                :disabled="editor.can().chain().focus().redo().run()"
            >
                <Icon icon="octicon:chevron-right-12" width="12" height="12" />
            </button>
        </div>
        <EditorContent :editor="editor" v-model="model" />
        <template v-if="error">
            <template v-if="typeof error === String">
                <span class="text-sm text-red-600">{{ error }}</span>
            </template>
            <template v-else>
                <div class="flex flex-col">
                    <span
                        v-for="(err, i) in error"
                        :key="i"
                        class="text-sm text-red-600"
                    >
                        {{ err }}
                    </span>
                </div>
            </template>
        </template>
    </div>
</template>

<script setup>
import { useEditor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import { Color } from "@tiptap/extension-color";
import ListItem from "@tiptap/extension-list-item";
import Highlight from "@tiptap/extension-highlight";
import TextStyle from "@tiptap/extension-text-style";
import Link from "@tiptap/extension-link";

import { Icon } from "@iconify/vue";

defineProps({
    label: String,
    error: String | Array,
});

const model = defineModel();

const editor = useEditor({
    content: model.value,
    extensions: [
        StarterKit,
        Color.configure({ types: [TextStyle.name, ListItem.name] }),
        ListItem,
        TextStyle,
        Highlight,
        Link.configure({
            defaultProtocol: "https",
        }),
    ],
});

const setLink = () => {
    const previousUrl = editor.value.getAttributes("link").href;
    const url = window.prompt("URL", previousUrl);

    // cancelled
    if (url === null) {
        return;
    }

    // empty
    if (url === "") {
        editor.value.chain().focus().extendMarkRange("link").unsetLink().run();

        return;
    }

    // update link
    editor.value
        .chain()
        .focus()
        .extendMarkRange("link")
        .setLink({ href: url })
        .run();
};
</script>
