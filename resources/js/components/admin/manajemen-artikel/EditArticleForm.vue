<script setup lang="ts">
import ArticleController from '@/actions/App/Http/Controllers/Admin/ArticleController';
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { NativeSelect } from '@/components/ui/native-select';
import { Form, router } from '@inertiajs/vue3';
import Link from '@tiptap/extension-link';
import TextAlign from '@tiptap/extension-text-align';
import Underline from '@tiptap/extension-underline';
import StarterKit from '@tiptap/starter-kit';
import { EditorContent, useEditor } from '@tiptap/vue-3';
import {
    AlignCenter,
    AlignLeft,
    AlignRight,
    Bold,
    FileText,
    Italic,
    Link as LinkIcon,
    List,
    ListOrdered,
    Strikethrough,
    Underline as UnderlineIcon,
    Upload,
    X,
} from 'lucide-vue-next';
import { ref, watch } from 'vue';

const props = defineProps<{
    article: {
        id: number;
        slug: string;
        author: string;
        title: string;
        description: string;
        status: 'draft' | 'published' | 'archived';
        category_id: number;
        file_path?: string;
        cover_image?: string;
    };
    categories: Array<{ id: number; name: string }>;
}>();



// State for previews
const coverPreview = ref<string | null>(null);
const attachmentName = ref<string | null>(null);
const editorContent = ref('');

// Reactive form values - initialized from props
const title = ref(props.article.title);
const author = ref(props.article.author);
const categoryId = ref(props.article.category_id);
const status = ref(props.article.status);

// Rich text editor setup
const editor = useEditor({
    content: props.article.description || '',
    extensions: [
        StarterKit,
        Underline,
        TextAlign.configure({
            types: ['heading', 'paragraph'],
        }),
        Link.configure({
            openOnClick: false,
            HTMLAttributes: {
                class: 'text-blue-500 underline cursor-pointer',
            },
        }),
    ],
    editorProps: {
        attributes: {
            class: 'prose prose-sm sm:prose lg:prose-lg xl:prose-2xl mx-auto focus:outline-none min-h-[300px] p-4',
        },
    },
    onUpdate: ({ editor }) => {
        editorContent.value = editor.getHTML();
    },
    onCreate: ({ editor }) => {
        editorContent.value = editor.getHTML();
    },
});

// Watch article changes to update all form values
watch(
    () => props.article,
    (article) => {
        // Update form values
        title.value = article.title;
        author.value = article.author;
        categoryId.value = article.category_id;
        status.value = article.status;

        // Set preview cover if exists
        coverPreview.value = article.cover_image
            ? `/storage/${article.cover_image}`
            : null;

        // Set attachment name if exists
        attachmentName.value = article.file_path
            ? article.file_path.split('/').pop() || null
            : null;

        // Update editor content
        if (editor.value && article.description) {
            editor.value.commands.setContent(article.description);
            editorContent.value = article.description;
        }
    },
    { deep: true, immediate: true },
);

// Editor toolbar actions
const toggleBold = () => editor.value?.chain().focus().toggleBold().run();
const toggleItalic = () => editor.value?.chain().focus().toggleItalic().run();
const toggleUnderline = () =>
    editor.value?.chain().focus().toggleUnderline().run();
const toggleStrike = () => editor.value?.chain().focus().toggleStrike().run();
const toggleBulletList = () =>
    editor.value?.chain().focus().toggleBulletList().run();
const toggleOrderedList = () =>
    editor.value?.chain().focus().toggleOrderedList().run();
const setAlignLeft = () =>
    editor.value?.chain().focus().setTextAlign('left').run();
const setAlignCenter = () =>
    editor.value?.chain().focus().setTextAlign('center').run();
const setAlignRight = () =>
    editor.value?.chain().focus().setTextAlign('right').run();

const setLink = () => {
    const url = window.prompt('Enter URL:');
    if (url) {
        editor.value?.chain().focus().setLink({ href: url }).run();
    }
};

// File handling for preview
const handleCoverChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file && file.type.startsWith('image/')) {
        coverPreview.value = URL.createObjectURL(file);
    }
};

const removeCover = () => {
    coverPreview.value = null;
    const input = document.getElementById('cover') as HTMLInputElement;
    if (input) input.value = '';
};

const handleAttachmentChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file && file.type === 'application/pdf') {
        attachmentName.value = file.name;
    }
};

const removeAttachment = () => {
    attachmentName.value = null;
    const input = document.getElementById('attachment') as HTMLInputElement;
    if (input) input.value = '';
};
</script>

<template>
    <div class="mx-auto max-w-5xl">
        <Form
            v-bind="ArticleController.update.form(article.slug)"
            class="space-y-6"
            v-slot="{ errors, processing }"
        >
            <!-- Title -->
            <div class="space-y-2">
                <Label for="title">
                    Judul Artikel <span class="text-red-500">*</span>
                </Label>
                <Input
                    id="title"
                    name="title"
                    type="text"
                    v-model="title"
                    placeholder="Masukkan judul artikel..."
                    required
                />
                <p v-if="errors.title" class="text-sm text-red-500">
                    {{ errors.title }}
                </p>
            </div>

            <!-- Author -->
            <div class="space-y-2">
                <Label for="author">
                    Penulis <span class="text-red-500">*</span>
                </Label>
                <Input
                    id="author"
                    name="author"
                    type="text"
                    v-model="author"
                    placeholder="Masukkan nama penulis..."
                    required
                />
                <p v-if="errors.author" class="text-sm text-red-500">
                    {{ errors.author }}
                </p>
            </div>

            <!-- Category -->
            <div class="space-y-2">
                <Label for="category">
                    Kategori <span class="text-red-500">*</span>
                </Label>
                <NativeSelect
                    id="category"
                    name="category_id"
                    v-model="categoryId"
                    required
                >
                    <option value="" disabled>Pilih Kategori</option>
                    <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                    >
                        {{ category.name }}
                    </option>
                </NativeSelect>
                <p v-if="errors.category_id" class="text-sm text-red-500">
                    {{ errors.category_id }}
                </p>
            </div>

            <!-- Cover Image -->
            <div class="space-y-2">
                <Label for="cover">
                    Cover Artikel <span class="text-red-500">*</span>
                </Label>
                <div class="space-y-3">
                    <div
                        v-if="coverPreview"
                        class="relative max-w-md overflow-hidden rounded-lg border border-gray-200"
                    >
                        <img
                            :src="coverPreview"
                            alt="Cover preview"
                            class="h-48 w-full object-cover"
                        />
                        <button
                            type="button"
                            @click="removeCover"
                            class="absolute top-2 right-2 rounded-full bg-red-500 p-1 text-white transition-colors hover:bg-red-600"
                        >
                            <X :size="16" />
                        </button>
                    </div>
                    <div class="flex items-center gap-2">
                        <label
                            for="cover"
                            class="inline-flex cursor-pointer items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 transition-colors hover:bg-gray-50"
                        >
                            <Upload :size="16" />
                            <span>{{
                                coverPreview ? 'Ganti Cover' : 'Upload Cover'
                            }}</span>
                        </label>
                        <input
                            id="cover"
                            name="cover_image"
                            type="file"
                            accept="image/*"
                            @change="handleCoverChange"
                            class="hidden"
                        />
                        <span class="text-sm text-gray-500">
                            Format: JPG, PNG, WebP (Max 2MB)
                        </span>
                    </div>
                </div>
                <p v-if="errors.cover_image" class="text-sm text-red-500">
                    {{ errors.cover_image }}
                </p>
            </div>

            <!-- Rich Text Editor -->
            <div class="space-y-2">
                <Label>
                    Deskripsi/Konten Artikel <span class="text-red-500">*</span>
                </Label>
                <div class="overflow-hidden rounded-lg border border-gray-300">
                    <!-- Toolbar -->
                    <div
                        class="flex flex-wrap gap-1 border-b border-gray-300 bg-gray-50 p-2"
                    >
                        <button
                            type="button"
                            @click="toggleBold"
                            :class="[
                                'rounded p-2 transition-colors hover:bg-gray-200',
                                editor?.isActive('bold') ? 'bg-gray-300' : '',
                            ]"
                            title="Bold"
                        >
                            <Bold :size="18" />
                        </button>
                        <button
                            type="button"
                            @click="toggleItalic"
                            :class="[
                                'rounded p-2 transition-colors hover:bg-gray-200',
                                editor?.isActive('italic') ? 'bg-gray-300' : '',
                            ]"
                            title="Italic"
                        >
                            <Italic :size="18" />
                        </button>
                        <button
                            type="button"
                            @click="toggleUnderline"
                            :class="[
                                'rounded p-2 transition-colors hover:bg-gray-200',
                                editor?.isActive('underline')
                                    ? 'bg-gray-300'
                                    : '',
                            ]"
                            title="Underline"
                        >
                            <UnderlineIcon :size="18" />
                        </button>
                        <button
                            type="button"
                            @click="toggleStrike"
                            :class="[
                                'rounded p-2 transition-colors hover:bg-gray-200',
                                editor?.isActive('strike') ? 'bg-gray-300' : '',
                            ]"
                            title="Strikethrough"
                        >
                            <Strikethrough :size="18" />
                        </button>

                        <div class="mx-1 w-px bg-gray-300"></div>

                        <button
                            type="button"
                            @click="toggleBulletList"
                            :class="[
                                'rounded p-2 transition-colors hover:bg-gray-200',
                                editor?.isActive('bulletList')
                                    ? 'bg-gray-300'
                                    : '',
                            ]"
                            title="Bullet List"
                        >
                            <List :size="18" />
                        </button>
                        <button
                            type="button"
                            @click="toggleOrderedList"
                            :class="[
                                'rounded p-2 transition-colors hover:bg-gray-200',
                                editor?.isActive('orderedList')
                                    ? 'bg-gray-300'
                                    : '',
                            ]"
                            title="Ordered List"
                        >
                            <ListOrdered :size="18" />
                        </button>

                        <div class="mx-1 w-px bg-gray-300"></div>

                        <button
                            type="button"
                            @click="setAlignLeft"
                            :class="[
                                'rounded p-2 transition-colors hover:bg-gray-200',
                                editor?.isActive({ textAlign: 'left' })
                                    ? 'bg-gray-300'
                                    : '',
                            ]"
                            title="Align Left"
                        >
                            <AlignLeft :size="18" />
                        </button>
                        <button
                            type="button"
                            @click="setAlignCenter"
                            :class="[
                                'rounded p-2 transition-colors hover:bg-gray-200',
                                editor?.isActive({ textAlign: 'center' })
                                    ? 'bg-gray-300'
                                    : '',
                            ]"
                            title="Align Center"
                        >
                            <AlignCenter :size="18" />
                        </button>
                        <button
                            type="button"
                            @click="setAlignRight"
                            :class="[
                                'rounded p-2 transition-colors hover:bg-gray-200',
                                editor?.isActive({ textAlign: 'right' })
                                    ? 'bg-gray-300'
                                    : '',
                            ]"
                            title="Align Right"
                        >
                            <AlignRight :size="18" />
                        </button>

                        <div class="mx-1 w-px bg-gray-300"></div>

                        <button
                            type="button"
                            @click="setLink"
                            :class="[
                                'rounded p-2 transition-colors hover:bg-gray-200',
                                editor?.isActive('link') ? 'bg-gray-300' : '',
                            ]"
                            title="Insert Link"
                        >
                            <LinkIcon :size="18" />
                        </button>
                    </div>

                    <!-- Editor Content -->
                    <div class="min-h-[300px] bg-white">
                        <EditorContent :editor="editor" />
                    </div>
                </div>
                <!-- Hidden input untuk submit description -->
                <input
                    type="hidden"
                    name="description"
                    :value="editorContent"
                />
                <p v-if="errors.description" class="text-sm text-red-500">
                    {{ errors.description }}
                </p>
            </div>

            <!-- PDF Attachment -->
            <div class="space-y-2">
                <Label for="attachment">Lampiran PDF (Opsional)</Label>
                <div class="space-y-3">
                    <div
                        v-if="attachmentName"
                        class="flex max-w-md items-center gap-3 rounded-lg border border-gray-200 bg-gray-50 p-3"
                    >
                        <FileText :size="24" class="text-red-500" />
                        <span class="flex-1 truncate text-sm">{{
                            attachmentName
                        }}</span>
                        <button
                            type="button"
                            @click="removeAttachment"
                            class="text-red-500 transition-colors hover:text-red-700"
                        >
                            <X :size="20" />
                        </button>
                    </div>
                    <div class="flex items-center gap-2">
                        <label
                            for="attachment"
                            class="inline-flex cursor-pointer items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 transition-colors hover:bg-gray-50"
                        >
                            <Upload :size="16" />
                            <span>{{
                                attachmentName
                                    ? 'Ganti Lampiran'
                                    : 'Upload Lampiran'
                            }}</span>
                        </label>
                        <input
                            id="attachment"
                            name="file_path"
                            type="file"
                            accept="application/pdf"
                            @change="handleAttachmentChange"
                            class="hidden"
                        />
                        <span class="text-sm text-gray-500"
                            >Format: PDF (Max 5MB)</span
                        >
                    </div>
                </div>
                <p v-if="errors.file_path" class="text-sm text-red-500">
                    {{ errors.file_path }}
                </p>
            </div>

            <!-- Status -->
            <div class="space-y-2">
                <Label for="status">
                    Status <span class="text-red-500">*</span>
                </Label>
                <NativeSelect
                    id="status"
                    name="status"
                    v-model="status"
                    required
                >
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                    <option value="archived">Archived</option>
                </NativeSelect>
                <p v-if="errors.status" class="text-sm text-red-500">
                    {{ errors.status }}
                </p>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3 pt-4">
                <Button
                    type="button"
                    variant="outline"
                    @click="router.visit('/admin/articles')"
                >
                    Batal
                </Button>
                <Button type="submit" :disabled="processing">
                    {{ processing ? 'Mempublikasikan...' : 'Publikasikan' }}
                </Button>
            </div>
        </Form>
    </div>
</template>

<style scoped>
/* Tiptap Editor Styles */
:deep(.ProseMirror) {
    outline: none;
    min-height: 300px;
    padding: 1rem;
}

:deep(.ProseMirror p) {
    margin-bottom: 0.5rem;
}

:deep(.ProseMirror ul),
:deep(.ProseMirror ol) {
    padding-left: 1.5rem;
    margin-bottom: 0.5rem;
}

:deep(.ProseMirror ul) {
    list-style-type: disc;
}

:deep(.ProseMirror ol) {
    list-style-type: decimal;
}

:deep(.ProseMirror h1) {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

:deep(.ProseMirror h2) {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

:deep(.ProseMirror h3) {
    font-size: 1.25rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

:deep(.ProseMirror a) {
    color: #3b82f6;
    text-decoration: underline;
    cursor: pointer;
}

:deep(.ProseMirror strong) {
    font-weight: bold;
}

:deep(.ProseMirror em) {
    font-style: italic;
}

:deep(.ProseMirror u) {
    text-decoration: underline;
}

:deep(.ProseMirror s) {
    text-decoration: line-through;
}
</style>
