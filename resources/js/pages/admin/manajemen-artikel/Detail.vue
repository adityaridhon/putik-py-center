<script setup lang="ts">
import PageHeader from '@/components/PageHeader.vue';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import { article as articleRoute } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { getCategoryColor } from '@/utils/categoryColors';
import { Head } from '@inertiajs/vue3';
import { Calendar, Download, FileText } from 'lucide-vue-next';

const props = defineProps<{
    artikel: {
        id: number;
        title: string;
        slug: string;
        author: string;
        category_id: number;
        category?: { id: number; name: string };
        description: string;
        status: 'draft' | 'published' | 'archived';
        file_path?: string;
        cover_image?: string;
        cover_image_url?: string;
        file_path_url?: string;
        published_at?: string;
        created_at?: string;
        updated_at?: string;
    };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Manajemen Artikel', href: articleRoute().url },
    { title: 'Detail Artikel', href: '#' },
];

const formatDate = (dateString?: string) => {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    }).format(date);
};

const getStatusBadge = (status: string) => {
    const badges = {
        draft: 'bg-gray-100 text-gray-700',
        published: 'bg-green-100 text-green-700',
        archived: 'bg-red-100 text-red-700',
    };
    return badges[status as keyof typeof badges] || badges.draft;
};

const getStatusText = (status: string) => {
    const statusText = {
        draft: 'Draft',
        published: 'Dipublikasikan',
        archived: 'Diarsipkan',
    };
    return statusText[status as keyof typeof statusText] || status;
};

// Fungsi untuk membersihkan tag HTML dari deskripsi
const cleanDescription = (html: string) => {
    const div = document.createElement('div');
    div.innerHTML = html;
    return div.textContent || div.innerText || '';
};

// Check if content is HTML format (from TipTap editor)
const isHtmlContent = (content: string) => {
    return content.includes('<p>') || content.includes('<h1>') || content.includes('<h2>') || content.includes('<em>') || content.includes('<strong>');
};

// Add Tailwind prose classes to HTML content for proper styling
const styledHtmlContent = (html: string) => {
    let content = html;
    
    // Add classes to paragraphs
    content = content.replace(/<p>/g, '<p class="text-gray-700 leading-8 text-base text-justify">');
    
    // Add classes to headings
    content = content.replace(/<h1>/g, '<h1 class="text-2xl font-bold mt-6 mb-4 text-gray-900">');
    content = content.replace(/<h2>/g, '<h2 class="text-xl font-bold mt-5 mb-3 text-gray-900">');
    content = content.replace(/<h3>/g, '<h3 class="text-lg font-bold mt-4 mb-2 text-gray-900">');
    
    // Add classes to lists and list items
    content = content.replace(/<ul>/g, '<ul class="list-disc ml-5 text-gray-700">');
    content = content.replace(/<ol>/g, '<ol class="list-decimal ml-5 text-gray-700">');
    content = content.replace(/<li>/g, '<li class="text-gray-700 leading-7 ml-2">');
    
    // Add classes to links
    content = content.replace(/<a /g, '<a class="text-blue-600 underline hover:text-blue-800" ');
    
    // Add classes to blockquotes
    content = content.replace(/<blockquote>/g, '<blockquote class="border-l-4 border-gray-300 pl-4 italic text-gray-700 my-4">');
    
    // Strong tags
    content = content.replace(/<strong>/g, '<strong class="font-bold text-gray-900">');
    
    // Emphasis tags
    content = content.replace(/<em>/g, '<em class="italic text-gray-700">');
    
    return content;
};
</script>

<template>
    <Head :title="`Detail Artikel - ${artikel.title}`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <PageHeader title="Detail Artikel" :back-url="articleRoute().url" />
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-6">
            <!-- Main Content -->
            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Left Column - Main Content -->
                <div class="space-y-6 lg:col-span-2">
                    <!-- Cover Image -->
                    <Card>
                        <CardContent class="p-0">
                            <img
                                :src="
                                    artikel.cover_image_url ||
                                    '/images/logo_putik.webp'
                                "
                                :alt="artikel.title"
                                class="h-96 w-full rounded-t-lg object-cover"
                            />
                        </CardContent>
                    </Card>

                    <!-- Article Content -->
                    <Card>
                        <CardContent class="space-y-6 pt-6">
                            <!-- Category Badge -->
                            <div>
                                <span
                                    :class="[
                                        'inline-flex items-center rounded-full px-4 py-1 text-sm font-medium',
                                        getCategoryColor(artikel.category_id).badge,
                                    ]"
                                >
                                    {{ artikel.category?.name || '-' }}
                                </span>
                            </div>

                            <!-- Title -->
                            <div class="space-y-3">
                                <h1 class="text-4xl font-bold leading-tight text-gray-900">
                                    {{ artikel.title }}
                                </h1>
                                <p class="text-sm text-gray-500">
                                    {{ formatDate(artikel.published_at) }} • Oleh {{ artikel.author }}
                                </p>
                            </div>

                            <!-- Divider -->
                            <div class="border-t border-gray-200"></div>

                            <!-- Description -->
                            <div class="space-y-4">
                                <div
                                    v-if="isHtmlContent(artikel.description)"
                                    v-html="styledHtmlContent(artikel.description)"
                                    class="prose prose-base max-w-none space-y-4"
                                />
                                <p
                                    v-else
                                    class="text-gray-700 leading-8 text-base text-justify"
                                >
                                    {{ cleanDescription(artikel.description) }}
                                </p>
                            </div>

                            <!-- PDF File -->
                            <div v-if="artikel.file_path" class="border-t pt-4">
                                <h3 class="mb-3 text-lg font-semibold">
                                    File Artikel
                                </h3>
                                <a
                                    :href="`/storage/${artikel.file_path}`"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 transition-colors hover:bg-gray-100"
                                >
                                    <FileText class="h-5 w-5 text-red-500" />
                                    <span class="font-medium">
                                        Lihat File PDF
                                    </span>
                                    <Download class="ml-2 h-4 w-4" />
                                </a>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Right Column - Metadata -->
                <div class="space-y-6 lg:col-span-1">
                    <!-- Article Info -->
                    <Card>
                        <CardHeader>
                            <CardTitle>Informasi Artikel</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <!-- Status -->
                            <div>
                                <p
                                    class="mb-1 text-sm font-medium text-gray-500"
                                >
                                    Status
                                </p>
                                <span
                                    :class="[
                                        'inline-flex items-center rounded-full px-3 py-1 text-sm font-medium',
                                        getStatusBadge(artikel.status),
                                    ]"
                                >
                                    {{ getStatusText(artikel.status) }}
                                </span>
                            </div>

                            <!-- Category -->
                            <div>
                                <p
                                    class="mb-1 text-sm font-medium text-gray-500"
                                >
                                    Kategori
                                </p>
                                <span
                                    :class="[
                                        'inline-flex items-center rounded-full px-3 py-1 text-sm font-medium',
                                        getCategoryColor(artikel.category_id)
                                            .badge,
                                    ]"
                                >
                                    {{ artikel.category?.name || '-' }}
                                </span>
                            </div>

                            <!-- Divider -->
                            <div
                                class="border-t border-gray-200"
                            />

                            <!-- Dates -->
                            <div>
                                <p
                                    class="mb-1 text-sm font-medium text-gray-500"
                                >
                                    Tanggal Publikasi
                                </p>
                                <p
                                    class="text-sm text-gray-900"
                                >
                                    {{ formatDate(artikel.published_at) }}
                                </p>
                            </div>

                            <div>
                                <p
                                    class="mb-1 text-sm font-medium text-gray-500"
                                >
                                    Dibuat Pada
                                </p>
                                <p
                                    class="text-sm text-gray-900"
                                >
                                    {{ formatDate(artikel.created_at) }}
                                </p>
                            </div>

                            <div>
                                <p
                                    class="mb-1 text-sm font-medium text-gray-500"
                                >
                                    Terakhir Diperbarui
                                </p>
                                <p
                                    class="text-sm text-gray-900"
                                >
                                    {{ formatDate(artikel.updated_at) }}
                                </p>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
