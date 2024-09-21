<template>
    <div
        v-if="editor"
        class="rounded-md border-0 bg-white shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600"
    >
        <menu class="flex divide-x border-b">
            <li>
                <button
                    @click="() => editor.chain().focus().toggleBold().run()"
                    type="button"
                    class="rounded-tl-md px-3 py-2"
                    :class="[
                        editor.isActive('bold')
                            ? 'bg-indigo-500 text-white'
                            : 'hover:bg-gray-200',
                    ]"
                    title="Bold"
                >
                    <i class="ri-bold"></i>
                </button>
            </li>

            <li>
                <input type="file" @change="handleImageUpload" style="display: none" ref="imageInput">
                <button
                    @click="$refs.imageInput.click()"
                    type="button"
                    class="px-3 py-2 hover:bg-gray-200"
                    title="Upload Image"
                >
                    <i class="ri-image-line"></i>
                </button>
            </li>
            <li>
                <button
                    @click="() => editor.chain().focus().toggleItalic().run()"
                    type="button"
                    class="px-3 py-2"
                    :class="[
                        editor.isActive('italic')
                            ? 'bg-indigo-500 text-white'
                            : 'hover:bg-gray-200',
                    ]"
                    title="Italic"
                >
                    <i class="ri-italic"></i>
                </button>
            </li>
            <li>
                <button
                    @click="() => editor.chain().focus().toggleStrike().run()"
                    type="button"
                    class="px-3 py-2"
                    :class="[
                        editor.isActive('strike')
                            ? 'bg-indigo-500 text-white'
                            : 'hover:bg-gray-200',
                    ]"
                    title="Strikethrough"
                >
                    <i class="ri-strikethrough"></i>
                </button>
            </li>
            <li>
                <button
                    @click="
                        () => editor.chain().focus().toggleBlockquote().run()
                    "
                    type="button"
                    class="px-3 py-2"
                    :class="[
                        editor.isActive('blockquote')
                            ? 'bg-indigo-500 text-white'
                            : 'hover:bg-gray-200',
                    ]"
                    title="Blockquote"
                >
                    <i class="ri-double-quotes-l"></i>
                </button>
            </li>
            <li>
                <button
                    @click="
                        () => editor.chain().focus().toggleBulletList().run()
                    "
                    type="button"
                    class="px-3 py-2"
                    :class="[
                        editor.isActive('bulletList')
                            ? 'bg-indigo-500 text-white'
                            : 'hover:bg-gray-200',
                    ]"
                    title="Bullet list"
                >
                    <i class="ri-list-unordered"></i>
                </button>
            </li>
            <li>
                <button
                    @click="
                        () => editor.chain().focus().toggleOrderedList().run()
                    "
                    type="button"
                    class="px-3 py-2"
                    :class="[
                        editor.isActive('orderedList')
                            ? 'bg-indigo-500 text-white'
                            : 'hover:bg-gray-200',
                    ]"
                    title="Numeric list"
                >
                    <i class="ri-list-ordered"></i>
                </button>
            </li>
            <li>
                <button
                    @click="
                        () => editor.chain().focus().toggleOrderedList().run()
                    "
                    type="button"
                    class="px-3 py-2"
                    :class="[
                        editor.isActive('orderedList')
                            ? 'bg-indigo-500 text-white'
                            : 'hover:bg-gray-200',
                    ]"
                    title="Numeric list"
                >
                    <i class="ri-list-ordered"></i>
                </button>
            </li>
            <li>
                <button
                    @click="promptUserForHref"
                    type="button"
                    class="px-3 py-2"
                    :class="[
                        editor.isActive('link')
                            ? 'bg-indigo-500 text-white'
                            : 'hover:bg-gray-200',
                    ]"
                    title="Add link"
                >
                    <i class="ri-link"></i>
                </button>
            </li>

            <slot name="toolbar" :editor="editor" />
        </menu>
        <EditorContent :editor="editor" />
    </div>
</template>

<script setup>
import { EditorContent, useEditor } from "@tiptap/vue-3";
import { StarterKit } from "@tiptap/starter-kit";
import { Link } from "@tiptap/extension-link";
import { Image } from "@tiptap/extension-image";  // Add Image extension
import { Markdown } from "tiptap-markdown";
import { watch } from "vue";
import "remixicon/fonts/remixicon.css";
import { Placeholder } from "@tiptap/extension-placeholder";

const props = defineProps({
    modelValue: "",
    editorClass: "",
    placeholder: null,
});

const emit = defineEmits(["update:modelValue"]);

const editor = useEditor({
    extensions: [
        StarterKit.configure({
            heading: {
                levels: [2, 3, 4],
            },
            code: false,
            codeBlock: false,
        }),
        Link,
        Image,  // Register Image extension here
        Markdown,
        Placeholder.configure({
            placeholder: props.placeholder,
        }),
    ],
    editorProps: {
        attributes: {
            class: `min-h-[512px] prose prose-sm max-w-none py-1.5 px-3 ${props.editorClass}`,
        },
    },
    onUpdate: () =>
        emit("update:modelValue", editor.value?.storage.markdown.getMarkdown()),
});

defineExpose({ focus: () => editor.value.commands.focus() });

watch(
    () => props.modelValue,
    (value) => {
        if (value === editor.value?.storage.markdown.getMarkdown()) {
            return;
        }

        editor.value?.commands.setContent(value);
    },
    { immediate: true },
);

const handleImageUpload = async (event) => {
    const file = event.target.files[0];

    if (file) {
        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        try {
            const response = await fetch('/upload-image', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            });

            if (response.ok) {
                const data = await response.json();
                const imageUrl = data.url; // Assuming the server responds with the image URL
                insertImage(imageUrl);
            } else {
                console.error('Image upload failed.');
            }
        } catch (error) {
            console.error('Error uploading image:', error);
        }
    }
};


const insertImage = (src) => {
    editor.value.chain().focus().setImage({ src }).run();
};

const promptUserForHref = () => {
    if (editor.value?.isActive("link")) {
        return editor.value?.chain().unsetLink().run();
    }

    const href = prompt("Where do you want to link to?");

    if (!href) {
        return editor.value?.chain().focus().run();
    }

    return editor.value?.chain().focus().setLink({ href }).run();
};
</script>

<style scoped>
:deep(.tiptap p.is-editor-empty:first-child::before) {
    @apply pointer-events-none float-left h-0 text-gray-400;
    content: attr(data-placeholder);
}
</style>
