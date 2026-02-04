<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { NativeSelect } from '@/components/ui/native-select';
import { store } from '@/routes/article';
import { router, useForm, usePage } from '@inertiajs/vue3';
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
import { computed, ref } from 'vue';
import { toast } from 'vue-sonner';

// Get props
const props = defineProps<{
    article?: {
        id?: number;
        author?: string;
        title?: string;
        description?: string;
        status?: 'draft' | 'published' | 'archived';
        categories?: Array<{ id: number; name: string }>;
        file_path?: string;
        cover_image?: string;
    };
}>();

// Get current user
const page = usePage();
const user = computed(() => page.props.auth?.user);
const categories = computed(
    () =>
        page.props.categories as
            | Array<{ id: number; name: string }>
            | undefined,
);

// Form data with Inertia
const form = useForm({
    title: '',
    author: user.value?.name || '',
    category_id: null as number | null,
    description: '',
    status: 'draft' as 'draft' | 'published' | 'archived',
    file_path: null as File | null,
    cover_image: null as File | null,
});

// Preview URLs
const coverPreview = ref<string | null>(null);
const attachmentName = ref<string | null>(null);

// Rich text editor setup
const editor = useEditor({
    content: form.description,
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
        form.description = editor.getHTML();
    },
});

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

// File handling
const handleCoverChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file && file.type.startsWith('image/')) {
        form.cover_image = file;
        coverPreview.value = URL.createObjectURL(file);
    }
};

const removeCover = () => {
    form.cover_image = null;
    coverPreview.value = null;
};

const handleAttachmentChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file && file.type === 'application/pdf') {
        form.file_path = file;
        attachmentName.value = file.name;
    }
};

const removeAttachment = () => {
    form.file_path = null;
    attachmentName.value = null;
};

// Submit handler
const handleSubmit = () => {
    form.post(store.url(), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            // toast.success('Artikel berhasil dibuat!');
            form.reset();
            editor.value?.commands.setContent('');
            coverPreview.value = null;
            attachmentName.value = null;
        },
        onError: (errors) => {
            toast.error('Gagal membuat artikel. Periksa kembali form Anda.');
            console.error(errors);
        },
    });
};

// Cancel handler
const handleCancel = () => {
    router.visit('/admin/articles');
};
</script>

<template>
    <div class="mx-auto max-w-5xl">
        <form @submit.prevent="handleSubmit" class="space-y-6">
            <!-- Title -->
            <div class="space-y-2">
                <Label for="title"
                    >Judul Artikel <span class="text-red-500">*</span></Label
                >
                <Input
                    id="title"
                    v-model="form.title"
                    type="text"
                    placeholder="Masukkan judul artikel..."
                    :class="{ 'border-red-500': form.errors.title }"
                />
                <p v-if="form.errors.title" class="text-sm text-red-500">
                    {{ form.errors.title }}
                </p>
            </div>

            <!-- Category -->
            <div class="space-y-2">
                <Label for="category"
                    >Kategori <span class="text-red-500">*</span></Label
                >
                <NativeSelect
                    id="category"
                    v-model="form.category_id"
                    :class="{ 'border-red-500': form.errors.category_id }"
                >
                    <option value="" disabled selected>Pilih Kategori</option>
                    <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                    >
                        {{ category.name }}
                    </option>
                </NativeSelect>
                <p v-if="form.errors.category_id" class="text-sm text-red-500">
                    {{ form.errors.category_id }}
                </p>
            </div>

            <!-- Cover Image -->
            <div class="space-y-2">
                <Label for="cover"
                    >Cover Artikel <span class="text-red-500">*</span></Label
                >
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
                            type="file"
                            accept="image/*"
                            @change="handleCoverChange"
                            class="hidden"
                        />
                        <span class="text-sm text-gray-500"
                            >Format: JPG, PNG, WebP (Max 2MB)</span
                        >
                    </div>
                </div>
                <p v-if="form.errors.cover_image" class="text-sm text-red-500">
                    {{ form.errors.cover_image }}
                </p>
            </div>

            <!-- Rich Text Editor -->
            <div class="space-y-2">
                <Label
                    >Deskripsi/Konten Artikel
                    <span class="text-red-500">*</span></Label
                >
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
                <p v-if="form.errors.description" class="text-sm text-red-500">
                    {{ form.errors.description }}
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
                <p v-if="form.errors.file_path" class="text-sm text-red-500">
                    {{ form.errors.file_path }}
                </p>
            </div>

            <!-- Status -->
            <div class="space-y-2">
                <Label for="status"
                    >Status <span class="text-red-500">*</span></Label
                >
                <NativeSelect
                    id="status"
                    v-model="form.status"
                    :class="{ 'border-red-500': form.errors.status }"
                >
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                    <option value="archived">Archived</option>
                </NativeSelect>
                <p v-if="form.errors.status" class="text-sm text-red-500">
                    {{ form.errors.status }}
                </p>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3 pt-4">
                <Button type="button" variant="outline" @click="handleCancel">
                    Batal
                </Button>
                <Button type="submit" :disabled="form.processing">
                    {{
                        form.processing ? 'Mempublikasikan...' : 'Publikasikan'
                    }}
                </Button>
            </div>
        </form>
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
